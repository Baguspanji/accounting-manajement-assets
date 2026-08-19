<?php

namespace App\Services;

use App\Models\Account;
use App\Models\JournalDetail;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class FinancialReportService
{
    /**
     * Saldo setiap akun (debit, kredit, dan saldo pada sisi normal).
     *
     * @return Collection<int, array{account: Account, debit: float, credit: float, balance: float, normal_balance: float}>
     */
    public function accountBalances(?Carbon $asOf = null, ?Carbon $from = null, ?Carbon $to = null): Collection
    {
        return Account::where('is_active', true)
            ->orderBy('code')
            ->get()
            ->map(function (Account $account) use ($asOf, $from, $to): array {
                $query = JournalDetail::query()->where('account_id', $account->id);

                $query->whereHas('journal', function ($journal) use ($asOf, $from, $to) {
                    if ($asOf) {
                        $journal->whereDate('transaction_date', '<=', $asOf);
                    }
                    if ($from) {
                        $journal->whereDate('transaction_date', '>=', $from);
                    }
                    if ($to) {
                        $journal->whereDate('transaction_date', '<=', $to);
                    }
                });

                $debit = (float) $query->sum('debit');
                $credit = (float) $query->sum('credit');

                return [
                    'account' => $account,
                    'debit' => $debit,
                    'credit' => $credit,
                    'balance' => $debit - $credit,
                    'normal_balance' => $account->normal_balance === 'debit'
                        ? $debit - $credit
                        : $credit - $debit,
                ];
            });
    }

    /**
     * @param  Collection<int, array{normal_balance: float, account: Account}>  $entries
     */
    public function categoryTotal(Collection $entries, string $category): float
    {
        return $entries
            ->where('account.category', $category)
            ->sum('normal_balance');
    }

    public function revenueTotal(Collection $entries): float
    {
        return $this->categoryTotal($entries, 'revenue');
    }

    /**
     * Total aset memperhitungkan akun kontra (akumulasi penyusutan) yang dikurangkan.
     */
    public function assetTotal(Collection $entries): float
    {
        return $entries->where('account.category', 'asset')->sum('balance');
    }

    public function expenseTotal(Collection $entries): float
    {
        return $this->categoryTotal($entries, 'expense');
    }

    public function netIncome(Collection $entries): float
    {
        return $this->revenueTotal($entries) - $this->expenseTotal($entries);
    }
}
