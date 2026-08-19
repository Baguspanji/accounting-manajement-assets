<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Asset;
use App\Models\Depreciation;
use Carbon\Carbon;

class DepreciationService
{
    public function __construct(private readonly JournalService $journalService) {}

    public function monthlyExpense(Asset $asset, string $period): float
    {
        if (! $asset->isDepreciable() || (int) $asset->useful_life <= 0) {
            return 0;
        }

        $cost = (float) $asset->acquisition_cost;
        $residual = (float) $asset->residual_value;
        $life = (int) $asset->useful_life;
        $depreciable = $cost - $residual;

        if ($depreciable <= 0) {
            return 0;
        }

        $accumulatedBefore = (float) $asset->depreciations()
            ->where('status', 'posted')
            ->sum('expense_amount');

        if ($accumulatedBefore >= $depreciable) {
            return 0;
        }

        [$year, $month] = array_map('intval', explode('-', $period));
        $periodDate = Carbon::create($year, $month, 1);
        $method = strtoupper($asset->depreciationMethod?->code ?? 'SL');

        $expense = match ($method) {
            'DDB' => $this->decliningBalanceExpense($cost, $accumulatedBefore, $life),
            'SOYD' => $this->sumOfYearsDigitsExpense($asset, $cost, $residual, $life, $periodDate),
            'UP' => $this->unitsOfProductionExpense($asset, $depreciable, $life),
            default => $this->straightLineExpense($depreciable, $life),
        };

        if ($accumulatedBefore + $expense > $depreciable) {
            $expense = max($depreciable - $accumulatedBefore, 0);
        }

        return round($expense, 2);
    }

    private function straightLineExpense(float $depreciable, int $life): float
    {
        return $depreciable / $life / 12;
    }

    private function decliningBalanceExpense(float $cost, float $accumulated, int $life): float
    {
        $bookValue = $cost - $accumulated;

        return $bookValue * (2 / $life) / 12;
    }

    private function sumOfYearsDigitsExpense(Asset $asset, float $cost, float $residual, int $life, Carbon $periodDate): float
    {
        $acquisition = Carbon::parse($asset->acquisition_date)->startOfMonth();
        $monthsSince = $acquisition->diffInMonths($periodDate);

        if ($monthsSince < 0) {
            return 0;
        }

        $yearIndex = (int) floor($monthsSince / 12) + 1;
        $yearIndex = min($yearIndex, $life);

        $totalDigits = $life * ($life + 1) / 2;
        $remaining = $life - $yearIndex + 1;
        $annual = ($cost - $residual) * $remaining / $totalDigits;

        return $annual / 12;
    }

    private function unitsOfProductionExpense(Asset $asset, float $depreciable, int $life): float
    {
        $capacity = (float) ($asset->production_capacity ?? 0);

        if ($capacity <= 0) {
            return $depreciable / $life / 12;
        }

        $monthlyUnits = $capacity / ($life * 12);

        return $depreciable * ($monthlyUnits / $capacity);
    }

    public function runForPeriod(string $period): array
    {
        [$year, $month] = array_map('intval', explode('-', $period));

        $assets = Asset::with('depreciationMethod', 'category')
            ->where('status', 'active')
            ->whereDoesntHave('depreciations', fn ($query) => $query->where('period', $period))
            ->get();

        $created = 0;

        foreach ($assets as $asset) {
            $expense = $this->monthlyExpense($asset, $period);

            if ($expense <= 0) {
                continue;
            }

            $accumulatedAfter = (float) $asset->depreciations()
                ->where('status', 'posted')
                ->sum('expense_amount') + $expense;

            $asset->depreciations()->create([
                'period' => $period,
                'year' => $year,
                'month' => $month,
                'expense_amount' => $expense,
                'accumulated_after' => $accumulatedAfter,
                'book_value_after' => (float) $asset->acquisition_cost - $accumulatedAfter,
                'status' => 'pending',
                'notes' => 'Penyusutan '.$asset->depreciationMethod?->name.' periode '.$period,
            ]);

            $created++;
        }

        return ['created' => $created];
    }

    public function postForPeriod(string $period): array
    {
        $depreciations = Depreciation::with(['asset.category', 'asset.depreciationMethod'])
            ->where('period', $period)
            ->where('status', 'pending')
            ->orderBy('id')
            ->get();

        $posted = 0;

        foreach ($depreciations as $depreciation) {
            $asset = $depreciation->asset;

            $expenseAccount = $asset->category?->depreciationExpenseAccount
                ?? Account::where('code', '5100')->first();
            $accumulatedAccount = $asset->category?->accumulatedDepreciationAccount
                ?? Account::where('code', '1290')->first();

            if (! $expenseAccount || ! $accumulatedAccount) {
                continue;
            }

            $accumulatedAfter = (float) $asset->depreciations()
                ->where('status', 'posted')
                ->where('id', '!=', $depreciation->id)
                ->sum('expense_amount') + (float) $depreciation->expense_amount;

            $reference = $this->journalService->nextReference('DEP-'.$period.'-');

            $this->journalService->create(
                $depreciation,
                $reference,
                $period.'-01',
                'Penyusutan '.$asset->name.' periode '.$period,
                [
                    ['account_id' => $expenseAccount->id, 'debit' => (float) $depreciation->expense_amount, 'credit' => 0],
                    ['account_id' => $accumulatedAccount->id, 'debit' => 0, 'credit' => (float) $depreciation->expense_amount],
                ],
            );

            $depreciation->update([
                'status' => 'posted',
                'accumulated_after' => $accumulatedAfter,
                'book_value_after' => (float) $asset->acquisition_cost - $accumulatedAfter,
            ]);

            $posted++;
        }

        return ['posted' => $posted];
    }
}
