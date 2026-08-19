<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetDisposal;
use App\Models\DepreciationMethod;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AccountingModuleTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->user = User::firstOrFail();
    }

    private function postCapital(float $amount = 500000000): void
    {
        $journal = Journal::create([
            'reference' => 'CAP-0001',
            'transaction_date' => '2026-01-01',
            'description' => 'Setoran modal awal',
        ]);

        $journal->details()->create([
            'account_id' => Account::where('code', '1110')->firstOrFail()->id,
            'debit' => $amount,
            'credit' => 0,
        ]);

        $journal->details()->create([
            'account_id' => Account::where('code', '3100')->firstOrFail()->id,
            'debit' => 0,
            'credit' => $amount,
        ]);
    }

    private function makeAsset(): Asset
    {
        $category = AssetCategory::where('code', 'PRL')->firstOrFail();
        $method = DepreciationMethod::where('code', 'SL')->firstOrFail();

        return Asset::create([
            'asset_number' => 'AST-RPT-'.strtoupper(substr(md5((string) uniqid()), 0, 6)),
            'name' => 'Aset Laporan',
            'category_id' => $category->id,
            'acquisition_date' => '2026-08-01',
            'acquisition_cost' => 120000000,
            'residual_value' => 12000000,
            'useful_life' => 10,
            'depreciation_method_id' => $method->id,
            'status' => 'active',
        ]);
    }

    private function seedReportingScenario(): Asset
    {
        $this->postCapital();
        $asset = $this->makeAsset();
        Asset::where('id', '!=', $asset->id)->update(['status' => 'maintenance']);

        $this->actingAs($this->user)->post(route('acquisitions.store'), [
            'asset_id' => $asset->id,
            'transaction_date' => '2026-08-01',
            'source' => 'kas',
        ])->assertRedirect();

        $this->actingAs($this->user)->post(route('depreciations.run'), ['period' => '2026-08']);
        $this->actingAs($this->user)->post(route('depreciations.post'), ['period' => '2026-08']);

        return $asset;
    }

    public function test_accounting_pages_load_empty(): void
    {
        $routes = [
            'journals.index',
            'ledger.index',
            'trial-balance.index',
            'reports.index',
            'reports.neraca',
            'reports.laba-rugi',
            'reports.kategori',
            'reports.kartu-aset',
            'reports.jadwal-penyusutan',
            'reports.pelepasan',
            'reports.arus-kas',
        ];

        foreach ($routes as $route) {
            $this->actingAs($this->user)->get(route($route))->assertOk();
        }
    }

    public function test_reports_show_correct_figures(): void
    {
        $asset = $this->seedReportingScenario();

        $this->actingAs($this->user)->get(route('journals.index'))
            ->assertOk()
            ->assertSee('CAP-0001')
            ->assertSee('ACQ-')
            ->assertSee('DEP-2026-08');

        $journal = Journal::where('reference', 'like', 'ACQ-%')->firstOrFail();
        $this->actingAs($this->user)->get(route('journals.show', $journal))
            ->assertOk()
            ->assertSee('Peralatan')
            ->assertSee('Kas');

        $kas = Account::where('code', '1110')->firstOrFail();
        $this->actingAs($this->user)->get(route('ledger.index'))
            ->assertOk()
            ->assertSee('Kas');
        $this->actingAs($this->user)->get(route('ledger.show', $kas))
            ->assertOk()
            ->assertSee('380.000.000');

        $this->actingAs($this->user)->get(route('trial-balance.index'))
            ->assertOk()
            ->assertSee('620.900.000');

        $this->actingAs($this->user)->get(route('reports.neraca'))
            ->assertOk()
            ->assertSee('499.100.000');

        $this->actingAs($this->user)->get(route('reports.laba-rugi'))
            ->assertOk()
            ->assertSee('900.000');

        $this->actingAs($this->user)->get(route('reports.kategori'))
            ->assertOk()
            ->assertSee('Peralatan');

        $this->actingAs($this->user)->get(route('reports.kartu-aset', ['asset_id' => $asset->id]))
            ->assertOk()
            ->assertSee($asset->name);

        $this->actingAs($this->user)->get(route('reports.jadwal-penyusutan'))
            ->assertOk()
            ->assertSee('2026-08');

        $this->actingAs($this->user)->get(route('reports.pelepasan'))
            ->assertOk();

        $this->actingAs($this->user)->get(route('reports.arus-kas'))
            ->assertOk()
            ->assertSee('380.000.000')
            ->assertSee('120.000.000');
    }

    public function test_disposal_flows_into_reports(): void
    {
        $asset = $this->seedReportingScenario();
        $accumulated = (float) $asset->depreciations()->where('status', 'posted')->sum('expense_amount');
        $bookValue = (float) $asset->acquisition_cost - $accumulated;
        $salePrice = 100000000;

        $this->actingAs($this->user)->post(route('disposals.store'), [
            'asset_id' => $asset->id,
            'disposal_date' => '2026-08-31',
            'disposal_type' => 'sale',
            'sale_price' => $salePrice,
            'notes' => 'Dijual.',
        ])->assertRedirect();

        $disposal = AssetDisposal::where('asset_id', $asset->id)->firstOrFail();
        $expectedLoss = $salePrice - $bookValue;

        $this->actingAs($this->user)->get(route('reports.pelepasan'))
            ->assertOk()
            ->assertSee(number_format(abs($expectedLoss), 0, ',', '.'));

        $this->actingAs($this->user)->get(route('reports.neraca'))
            ->assertOk();

        $this->assertSame('disposed', $asset->refresh()->status);
        $this->assertNotEmpty($disposal->journals);
        $this->assertEquals($disposal->journals->first()->details->sum('debit'), $disposal->journals->first()->details->sum('credit'));
    }

    public function test_ledger_index_contains_accumulated_depreciation_balance(): void
    {
        $this->seedReportingScenario();

        $this->actingAs($this->user)->get(route('ledger.index'))
            ->assertOk()
            ->assertSee('Akumulasi Penyusutan')
            ->assertSee('Beban Penyusutan');
    }

    public function test_profile_page_and_logout(): void
    {
        $this->actingAs($this->user)->get(route('profile.show'))
            ->assertOk()
            ->assertSee('Ganti Kata Sandi');

        $this->actingAs($this->user)->post(route('logout'))
            ->assertRedirect(route('login'));

        $this->assertGuest();
    }

    public function test_change_password_updates_credentials(): void
    {
        $this->actingAs($this->user)
            ->put(route('profile.password'), [
                'current_password' => 'password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertTrue(Hash::check('new-password', $this->user->fresh()->password));

        $this->actingAs($this->user)
            ->put(route('profile.password'), [
                'current_password' => 'password',
                'password' => 'other-password',
                'password_confirmation' => 'other-password',
            ])
            ->assertSessionHasErrors('current_password');
    }
}
