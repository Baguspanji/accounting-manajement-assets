<?php

namespace App\Services;

use App\Models\Journal;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JournalService
{
    /**
     * @param  array<int, array{account_id: int, debit?: float, credit?: float}>  $entries
     */
    public function create(Model $journalable, string $reference, string $date, string $description, array $entries): Journal
    {
        $totalDebit = round(array_sum(array_column($entries, 'debit') ?? []), 2);
        $totalCredit = round(array_sum(array_column($entries, 'credit') ?? []), 2);

        if (abs($totalDebit - $totalCredit) > 0.01) {
            throw new \InvalidArgumentException('Jurnal tidak seimbang: debit '.$totalDebit.' vs kredit '.$totalCredit.'.');
        }

        return DB::transaction(function () use ($journalable, $reference, $date, $description, $entries): Journal {
            $journal = Journal::create([
                'reference' => $reference,
                'transaction_date' => $date,
                'description' => $description,
                'journalable_type' => $journalable->getMorphClass(),
                'journalable_id' => $journalable->getKey(),
            ]);

            foreach ($entries as $entry) {
                $journal->details()->create([
                    'account_id' => $entry['account_id'],
                    'debit' => $entry['debit'] ?? 0,
                    'credit' => $entry['credit'] ?? 0,
                ]);
            }

            return $journal;
        });
    }

    public function nextReference(string $prefix): string
    {
        $count = Journal::where('reference', 'like', $prefix.'%')->count();

        return $prefix.str_pad((string) ($count + 1), 4, '0', STR_PAD_LEFT);
    }
}
