<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Asset;
use App\Models\Journal;

class AcquisitionService
{
    public function __construct(private readonly JournalService $journalService) {}

    public function acquire(Asset $asset, string $date, string $source): Journal
    {
        if ($asset->status !== 'active') {
            throw new \InvalidArgumentException('Hanya aset berstatus aktif yang dapat dicatat perolehannya.');
        }

        $exists = Journal::where('journalable_type', $asset->getMorphClass())
            ->where('journalable_id', $asset->getKey())
            ->where('reference', 'like', 'ACQ-%')
            ->exists();

        if ($exists) {
            throw new \InvalidArgumentException('Aset ini sudah memiliki jurnal perolehan.');
        }

        $assetAccount = $asset->category?->assetAccount
            ?? Account::where('code', '1250')->first();

        if (! $assetAccount) {
            throw new \InvalidArgumentException('Akun aset untuk kategori belum dikonfigurasi.');
        }

        $cost = (float) $asset->acquisition_cost;

        if ($source === 'utang') {
            $creditAccount = Account::where('code', '2100')->first();
            $description = 'Perolehan aset '.$asset->name.' secara kredit';
        } else {
            $creditAccount = Account::where('code', '1110')->first();
            $description = 'Perolehan aset '.$asset->name.' secara tunai';
        }

        if (! $creditAccount) {
            throw new \InvalidArgumentException('Akun kas atau utang usaha belum tersedia di chart of accounts.');
        }

        $reference = $this->journalService->nextReference('ACQ-');

        return $this->journalService->create($asset, $reference, $date, $description, [
            ['account_id' => $assetAccount->id, 'debit' => $cost, 'credit' => 0],
            ['account_id' => $creditAccount->id, 'debit' => 0, 'credit' => $cost],
        ]);
    }
}
