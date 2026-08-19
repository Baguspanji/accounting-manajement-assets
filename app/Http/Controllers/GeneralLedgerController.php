<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\JournalDetail;
use Illuminate\View\View;

class GeneralLedgerController extends Controller
{
    public function index(): View
    {
        $accounts = Account::where('is_active', true)
            ->orderBy('code')
            ->get()
            ->map(function (Account $account): array {
                $debit = (float) JournalDetail::where('account_id', $account->id)->sum('debit');
                $credit = (float) JournalDetail::where('account_id', $account->id)->sum('credit');

                return [
                    'account' => $account,
                    'debit' => $debit,
                    'credit' => $credit,
                    'balance' => $debit - $credit,
                ];
            })
            ->filter(fn (array $entry): bool => $entry['debit'] > 0 || $entry['credit'] > 0)
            ->values();

        return view('ledger.index', compact('accounts'));
    }

    public function show(Account $account): View
    {
        $details = JournalDetail::query()
            ->where('journal_details.account_id', $account->id)
            ->join('journals', 'journal_details.journal_id', '=', 'journals.id')
            ->orderBy('journals.transaction_date')
            ->orderBy('journals.id')
            ->with(['journal.journalable'])
            ->get(['journal_details.*']);

        $runningBalance = 0;
        $rows = $details->map(function (JournalDetail $detail) use (&$runningBalance): array {
            $runningBalance += (float) $detail->debit - (float) $detail->credit;

            return [
                'journal' => $detail->journal,
                'debit' => (float) $detail->debit,
                'credit' => (float) $detail->credit,
                'balance' => $runningBalance,
            ];
        });

        $totalDebit = $rows->sum('debit');
        $totalCredit = $rows->sum('credit');

        return view('ledger.show', compact('account', 'rows', 'totalDebit', 'totalCredit'));
    }
}
