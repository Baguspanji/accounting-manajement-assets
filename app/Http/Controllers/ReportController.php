<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetDisposal;
use App\Models\Depreciation;
use App\Models\JournalDetail;
use App\Services\FinancialReportService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(private readonly FinancialReportService $reportService) {}

    public function index(): View
    {
        $entries = $this->reportService->accountBalances();

        $summary = [
            'assets' => $this->reportService->assetTotal($entries),
            'liabilities' => $this->reportService->categoryTotal($entries, 'liability'),
            'equity' => $this->reportService->categoryTotal($entries, 'equity'),
            'revenue' => $this->reportService->revenueTotal($entries),
            'expense' => $this->reportService->expenseTotal($entries),
            'net_income' => $this->reportService->netIncome($entries),
        ];

        return view('reports.index', compact('summary'));
    }

    public function neraca(Request $request): View
    {
        $asOf = $request->filled('as_of') ? Carbon::parse($request->as_of) : null;

        $entries = $this->reportService->accountBalances($asOf);

        $assets = $entries->where('account.category', 'asset');
        $liabilities = $entries->where('account.category', 'liability');
        $equityEntries = $entries->where('account.category', 'equity');

        $netIncome = $this->reportService->netIncome($entries);

        $assetTotal = $this->reportService->assetTotal($entries);
        $liabilityTotal = $liabilities->sum('normal_balance');
        $equityTotal = $equityEntries->sum('normal_balance') + $netIncome;

        return view('reports.neraca', compact('asOf', 'assets', 'liabilities', 'equityEntries', 'netIncome', 'assetTotal', 'liabilityTotal', 'equityTotal'));
    }

    public function labaRugi(Request $request): View
    {
        $from = $request->filled('from') ? Carbon::parse($request->from) : null;
        $to = $request->filled('to') ? Carbon::parse($request->to) : null;

        $entries = $this->reportService->accountBalances(null, $from, $to);

        $revenues = $entries->where('account.category', 'revenue');
        $expenses = $entries->where('account.category', 'expense');

        $revenueTotal = $this->reportService->revenueTotal($entries);
        $expenseTotal = $this->reportService->expenseTotal($entries);
        $netIncome = $revenueTotal - $expenseTotal;

        return view('reports.laba-rugi', compact('from', 'to', 'revenues', 'expenses', 'revenueTotal', 'expenseTotal', 'netIncome'));
    }

    public function kategori(): View
    {
        $categories = AssetCategory::with('assets')
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

        return view('reports.kategori', compact('categories'));
    }

    public function kartuAset(Request $request): View
    {
        $assets = Asset::with('category', 'depreciationMethod')->orderBy('name')->get();

        $selected = $request->filled('asset_id')
            ? Asset::with('category', 'depreciationMethod')->findOrFail($request->asset_id)
            : $assets->first();

        $schedule = $selected?->depreciations()->orderBy('period')->get();

        return view('reports.kartu-aset', compact('assets', 'selected', 'schedule'));
    }

    public function jadwalPenyusutan(): View
    {
        $depreciations = Depreciation::with('asset')
            ->orderByDesc('period')
            ->orderBy('id')
            ->get();

        $totalExpense = $depreciations->sum('expense_amount');

        return view('reports.jadwal-penyusutan', compact('depreciations', 'totalExpense'));
    }

    public function pelepasan(): View
    {
        $disposals = AssetDisposal::with('asset')->orderByDesc('disposal_date')->get();

        $totalGainLoss = $disposals->sum('gain_loss');

        return view('reports.pelepasan', compact('disposals', 'totalGainLoss'));
    }

    public function arusKas(): View
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

        return view('reports.arus-kas', compact('rows', 'totalInflow', 'totalOutflow'));
    }
}
