<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\DepreciationMethod;
use App\Models\Journal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportPdfExportTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->user = User::firstOrFail();
    }

    private function seedReportingScenario(): void
    {
        $category = AssetCategory::where('code', 'PRL')->firstOrFail();
        $method = DepreciationMethod::where('code', 'SL')->firstOrFail();

        $journal = Journal::create([
            'reference' => 'CAP-0001',
            'transaction_date' => '2026-01-01',
            'description' => 'Setoran modal awal',
        ]);

        $journal->details()->create([
            'account_id' => Account::where('code', '1110')->firstOrFail()->id,
            'debit' => 500000000,
            'credit' => 0,
        ]);

        $journal->details()->create([
            'account_id' => Account::where('code', '3100')->firstOrFail()->id,
            'debit' => 0,
            'credit' => 500000000,
        ]);

        $asset = Asset::create([
            'asset_number' => 'AST-PDF-'.strtoupper(substr(md5((string) uniqid()), 0, 6)),
            'name' => 'Aset PDF',
            'category_id' => $category->id,
            'acquisition_date' => '2026-08-01',
            'acquisition_cost' => 120000000,
            'residual_value' => 12000000,
            'useful_life' => 10,
            'depreciation_method_id' => $method->id,
            'status' => 'active',
        ]);

        Asset::where('id', '!=', $asset->id)->update(['status' => 'maintenance']);

        $this->actingAs($this->user)->post(route('acquisitions.store'), [
            'asset_id' => $asset->id,
            'transaction_date' => '2026-08-01',
            'source' => 'kas',
        ])->assertRedirect();

        $this->actingAs($this->user)->post(route('depreciations.run'), ['period' => '2026-08']);
        $this->actingAs($this->user)->post(route('depreciations.post'), ['period' => '2026-08']);
    }

    private function assertPdf(string $routeName, array $params = []): void
    {
        $response = $this->actingAs($this->user)->get(route($routeName, $params));

        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');

        $file = $response->getFile();
        $this->assertNotNull($file);
        $this->assertStringStartsWith('%PDF', $file->getContent());
    }

    public function test_all_report_pdfs_generate(): void
    {
        $this->seedReportingScenario();

        $this->assertPdf('reports.neraca.pdf');
        $this->assertPdf('reports.laba-rugi.pdf');
        $this->assertPdf('reports.kategori.pdf');
        $this->assertPdf('reports.kartu-aset.pdf');
        $this->assertPdf('reports.jadwal-penyusutan.pdf');
        $this->assertPdf('reports.pelepasan.pdf');
        $this->assertPdf('reports.arus-kas.pdf');
    }

    public function test_report_pdfs_respect_filters(): void
    {
        $this->seedReportingScenario();

        $this->assertPdf('reports.neraca.pdf', ['as_of' => '2026-08-31']);
        $this->assertPdf('reports.laba-rugi.pdf', ['from' => '2026-01-01', 'to' => '2026-08-31']);
        $this->assertPdf('reports.kartu-aset.pdf', ['asset_id' => Asset::where('name', 'Aset PDF')->firstOrFail()->id]);
    }
}
