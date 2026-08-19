<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Depreciation;
use App\Models\Journal;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $assets = Asset::with(['category', 'depreciationMethod'])->orderByDesc('created_at')->get();
        $activeAssets = $assets->where('status', 'active');

        $latestAccumulated = Depreciation::where('status', 'posted')
            ->orderByDesc('period')
            ->get()
            ->unique('asset_id')
            ->pluck('accumulated_after', 'asset_id')
            ->map(fn ($value) => (float) $value);

        $totalCost = (float) $activeAssets->sum('acquisition_cost');
        $totalAccumulated = $activeAssets->sum(fn (Asset $asset) => $latestAccumulated->get($asset->id, 0.0));
        $bookValue = max($totalCost - $totalAccumulated, 0);

        $statusCounts = $assets->groupBy('status')->map->count();

        $categorySummaries = AssetCategory::with('assets')->get()->map(function (AssetCategory $category) use ($latestAccumulated) {
            $cost = (float) $category->assets->sum('acquisition_cost');
            $accumulated = $category->assets->sum(fn (Asset $asset) => $latestAccumulated->get($asset->id, 0.0));

            return [
                'category' => $category,
                'count' => $category->assets->count(),
                'cost' => $cost,
                'accumulated' => $accumulated,
                'book_value' => $cost - $accumulated,
            ];
        })->filter(fn (array $summary) => $summary['count'] > 0);

        $recentJournals = Journal::with('journalable')->orderByDesc('transaction_date')->limit(5)->get();

        $currentPeriod = now()->format('Y-m');
        $currentPeriodExpense = (float) Depreciation::where('period', $currentPeriod)->where('status', 'posted')->sum('expense_amount');
        $pendingCount = Depreciation::where('status', 'pending')->count();

        return view('dashboard.index', compact(
            'assets',
            'totalCost',
            'totalAccumulated',
            'bookValue',
            'statusCounts',
            'categorySummaries',
            'recentJournals',
            'currentPeriodExpense',
            'pendingCount',
        ));
    }
}
