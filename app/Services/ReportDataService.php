<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetDisposal;
use App\Models\Depreciation;
use App\Models\JournalDetail;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReportDataService
{
    public function __construct(private readonly FinancialReportService $reportService) {}

    public function summary(): array
    {
        $entries = $this->reportService->accountBalances();

        return [
            'assets' => $this->reportService->assetTotal($entries),
            'liabilities' => $this->reportService->categoryTotal($entries, 'liability'),
            'equity' => $this->reportService->categoryTotal($entries, 'equity'),
            'revenue' => $this->reportService->revenueTotal($entries),
            'expense' => $this->reportService->expenseTotal($entries),
            'net_income' => $this->reportService->netIncome($entries),
        ];
    }

    public function neraca(?Carbon $asOf): array
    {
        $entries = $this->reportService->accountBalances($asOf);

        $assets = $entries->where('account.category', 'asset');
        $liabilities = $entries->where('account.category', 'liability');
        $equityEntries = $entries->where('account.category', 'equity');

        $netIncome = $this->reportService->netIncome($entries);

        $assetTotal = $this->reportService->assetTotal($entries);
        $liabilityTotal = $liabilities->sum('normal_balance');
        $equityTotal = $equityEntries->sum('normal_balance') + $netIncome;

        return compact('asOf', 'assets', 'liabilities', 'equityEntries', 'netIncome', 'assetTotal', 'liabilityTotal', 'equityTotal');
    }

    public function labaRugi(?Carbon $from, ?Carbon $to): array
    {
        $entries = $this->reportService->accountBalances(null, $from, $to);

        $revenues = $entries->where('account.category', 'revenue');
        $expenses = $entries->where('account.category', 'expense');

        $revenueTotal = $this->reportService->revenueTotal($entries);
        $expenseTotal = $this->reportService->expenseTotal($entries);
        $netIncome = $revenueTotal - $expenseTotal;

        return compact('from', 'to', 'revenues', 'expenses', 'revenueTotal', 'expenseTotal', 'netIncome');
    }

    public function kategori(): Collection
    {
        return AssetCategory::with('assets')
            ->get()
            ->map(function (AssetCategory $category): array {
                $cost = $category->assets->sum(fn (Asset $asset) => (float) $asset->acquisition_cost);
                $accumulated = $category->assets->sum(fn (Asset $asset) => (float) $asset->depreciations()->where('status', 'posted')->sum('expense_amount'));

                return [
                    'category' => $category,
                    'count' => $category->assets->count(),
                    'cost' => $cost,
                    'accumulated' => $accumulated,
                    'book_value' => $cost - $accumulated,
                ];
            });
    }

    public function kartuAset(?int $assetId): array
    {
        $assets = Asset::with('category', 'depreciationMethod')->orderBy('name')->get();

        $selected = $assetId
            ? Asset::with('category', 'depreciationMethod')->findOrFail($assetId)
            : $assets->first();

        $schedule = $selected?->depreciations()->orderBy('period')->get();

        return compact('assets', 'selected', 'schedule');
    }

    public function jadwalPenyusutan(): array
    {
        $depreciations = Depreciation::with('asset')
            ->orderByDesc('period')
            ->orderBy('id')
            ->get();

        $totalExpense = $depreciations->sum('expense_amount');

        return compact('depreciations', 'totalExpense');
    }

    public function pelepasan(): array
    {
        $disposals = AssetDisposal::with('asset')->orderByDesc('disposal_date')->get();

        $totalGainLoss = $disposals->sum('gain_loss');

        return compact('disposals', 'totalGainLoss');
    }

    public function arusKas(): array
    {
        $kas = Account::where('code', '1110')->first();

        $periods = Collection::empty();

        if ($kas) {
            $periods = JournalDetail::query()
                ->join('journals', 'journal_details.journal_id', '=', 'journals.id')
                ->where('journal_details.account_id', $kas->id)
                ->selectRaw("strftime('%Y-%m', journals.transaction_date) as period")
                ->selectRaw('COALESCE(SUM(journal_details.debit), 0) as inflow')
                ->selectRaw('COALESCE(SUM(journal_details.credit), 0) as outflow')
                ->groupBy('period')
                ->orderBy('period')
                ->get();
        }

        $opening = 0;
        $rows = $periods->map(function ($row) use (&$opening): array {
            $closing = $opening + (float) $row->inflow - (float) $row->outflow;

            $item = [
                'period' => $row->period,
                'inflow' => (float) $row->inflow,
                'outflow' => (float) $row->outflow,
                'net' => (float) $row->inflow - (float) $row->outflow,
                'opening' => $opening,
                'closing' => $closing,
            ];

            $opening = $closing;

            return $item;
        });

        $totalInflow = $rows->sum('inflow');
        $totalOutflow = $rows->sum('outflow');

        return compact('rows', 'totalInflow', 'totalOutflow');
    }
}
