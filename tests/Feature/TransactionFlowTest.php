<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetDisposal;
use App\Models\Depreciation;
use App\Models\DepreciationMethod;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionFlowTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->user = User::firstOrFail();
    }

    private function makeAsset(string $method = 'SL', array $overrides = []): Asset
    {
        $category = AssetCategory::where('code', 'PRL')->firstOrFail();
        $depMethod = DepreciationMethod::where('code', $method)->firstOrFail();

        return Asset::create(array_merge([
            'asset_number' => 'AST-UJI-'.strtoupper(substr(md5((string) uniqid()), 0, 6)),
            'name' => 'Aset Uji '.$method,
            'category_id' => $category->id,
            'acquisition_date' => '2024-01-01',
            'acquisition_cost' => 100000000,
            'residual_value' => 0,
            'useful_life' => 10,
            'depreciation_method_id' => $depMethod->id,
            'status' => 'active',
        ], $overrides));
    }

    public function test_transaction_pages_load(): void
    {
        $routes = [
            'acquisitions.index',
            'acquisitions.create',
            'depreciations.index',
            'disposals.index',
            'disposals.create',
        ];

        foreach ($routes as $route) {
            $this->actingAs($this->user)->get(route($route))->assertOk();
        }
    }

    public function test_acquisition_creates_balanced_journal(): void
    {
        $asset = $this->makeAsset();
        $assetAccountId = $asset->category->asset_account_id;
        $kasAccountId = Account::where('code', '1110')->firstOrFail()->id;

        $this->actingAs($this->user)
            ->post(route('acquisitions.store'), [
                'asset_id' => $asset->id,
                'transaction_date' => '2026-08-19',
                'source' => 'kas',
            ])
            ->assertRedirect(route('acquisitions.index'));

        $journal = Journal::where('reference', 'like', 'ACQ-%')
            ->where('journalable_type', $asset->getMorphClass())
            ->where('journalable_id', $asset->id)
            ->firstOrFail();

        $this->assertSame((float) $asset->acquisition_cost, (float) $journal->details()->where('account_id', $assetAccountId)->value('debit'));
        $this->assertSame((float) $asset->acquisition_cost, (float) $journal->details()->where('account_id', $kasAccountId)->value('credit'));
        $this->assertEquals(
            $journal->details->sum('debit'),
            $journal->details->sum('credit'),
        );

        $this->actingAs($this->user)
            ->post(route('acquisitions.store'), [
                'asset_id' => $asset->id,
                'transaction_date' => '2026-08-20',
                'source' => 'utang',
            ])
            ->assertSessionHas('error');
    }

    public function test_depreciation_run_and_post(): void
    {
        $asset = $this->makeAsset();

        Asset::where('id', '!=', $asset->id)->update(['status' => 'maintenance']);

        $this->actingAs($this->user)
            ->post(route('depreciations.run'), ['period' => '2026-08'])
            ->assertRedirect();

        $depreciation = Depreciation::where('asset_id', $asset->id)->where('period', '2026-08')->firstOrFail();
        $this->assertSame('pending', $depreciation->status);
        $this->assertSame(833333.33, (float) $depreciation->expense_amount);

        $this->actingAs($this->user)
            ->post(route('depreciations.post'), ['period' => '2026-08'])
            ->assertRedirect();

        $depreciation->refresh();
        $this->assertSame('posted', $depreciation->status);

        $journal = Journal::where('reference', 'like', 'DEP-2026-08-%')
            ->where('journalable_type', $depreciation->getMorphClass())
            ->where('journalable_id', $depreciation->id)
            ->firstOrFail();

        $this->assertEquals($journal->details->sum('debit'), $journal->details->sum('credit'));
        $this->assertSame(1, Depreciation::where('asset_id', $asset->id)->where('period', '2026-08')->count());

        $this->actingAs($this->user)
            ->post(route('depreciations.run'), ['period' => '2026-08'])
            ->assertRedirect()
            ->assertSessionHas('info');
    }

    public function test_disposal_sale_records_gain_and_disposes_asset(): void
    {
        $asset = $this->makeAsset();
        Asset::where('id', '!=', $asset->id)->update(['status' => 'maintenance']);

        $this->actingAs($this->user)->post(route('depreciations.run'), ['period' => '2026-08']);
        $this->actingAs($this->user)->post(route('depreciations.run'), ['period' => '2026-09']);
        $this->actingAs($this->user)->post(route('depreciations.post'), ['period' => '2026-08']);
        $this->actingAs($this->user)->post(route('depreciations.post'), ['period' => '2026-09']);

        $accumulated = (float) $asset->depreciations()->where('status', 'posted')->sum('expense_amount');
        $bookValue = (float) $asset->acquisition_cost - $accumulated;
        $salePrice = 120000000;
        $expectedGain = round($salePrice - $bookValue, 2);

        $this->actingAs($this->user)
            ->post(route('disposals.store'), [
                'asset_id' => $asset->id,
                'disposal_date' => '2026-09-30',
                'disposal_type' => 'sale',
                'sale_price' => $salePrice,
                'notes' => 'Dijual ke pihak ketiga.',
            ])
            ->assertRedirect();

        $disposal = AssetDisposal::where('asset_id', $asset->id)->firstOrFail();
        $this->assertSame('sale', $disposal->disposal_type);
        $this->assertSame('disposed', $asset->refresh()->status);
        $this->assertSame($expectedGain, (float) $disposal->gain_loss);

        $journal = $disposal->journals()->firstOrFail();
        $this->assertEquals($journal->details->sum('debit'), $journal->details->sum('credit'));
    }

    public function test_disposal_write_off_records_loss(): void
    {
        $asset = $this->makeAsset();
        Asset::where('id', '!=', $asset->id)->update(['status' => 'maintenance']);

        $this->actingAs($this->user)
            ->post(route('disposals.store'), [
                'asset_id' => $asset->id,
                'disposal_date' => '2026-08-31',
                'disposal_type' => 'write_off',
            ])
            ->assertRedirect();

        $disposal = AssetDisposal::where('asset_id', $asset->id)->firstOrFail();
        $this->assertSame('written_off', $asset->refresh()->status);
        $this->assertSame(100000000.0, (float) $disposal->book_value);
        $this->assertSame(-100000000.0, (float) $disposal->gain_loss);

        $journal = $disposal->journals()->firstOrFail();
        $this->assertEquals($journal->details->sum('debit'), $journal->details->sum('credit'));
    }
}
