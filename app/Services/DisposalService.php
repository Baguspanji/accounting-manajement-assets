<?php

namespace App\Services;

use App\Models\Account;
use App\Models\Asset;
use App\Models\AssetDisposal;

class DisposalService
{
    public function __construct(private readonly JournalService $journalService) {}

    public function dispose(Asset $asset, string $date, string $type, float $salePrice = 0, ?string $notes = null): AssetDisposal
    {
        if ($asset->status !== 'active') {
            throw new \InvalidArgumentException('Hanya aset berstatus aktif yang dapat dilepaskan.');
        }

        if ($type === 'sale' && $salePrice < 0) {
            throw new \InvalidArgumentException('Harga jual tidak boleh negatif.');
        }

        $accumulated = (float) $asset->depreciations()
            ->where('status', 'posted')
            ->sum('expense_amount');

        $bookValue = (float) $asset->acquisition_cost - $accumulated;

        $gainLoss = match ($type) {
            'sale' => $salePrice - $bookValue,
            'write_off' => -$bookValue,
            default => 0,
        };

        $disposal = $asset->disposals()->create([
            'disposal_date' => $date,
            'disposal_type' => $type,
            'sale_price' => $type === 'sale' ? $salePrice : 0,
            'accumulated_depreciation' => $accumulated,
            'book_value' => $bookValue,
            'gain_loss' => $gainLoss,
            'notes' => $notes,
        ]);

        if ($type !== 'transfer') {
            $this->postJournal($asset, $disposal, $type, $salePrice, $accumulated, $bookValue, $gainLoss, $date);
        }

        if ($type !== 'transfer') {
            $asset->update(['status' => $type === 'write_off' ? 'written_off' : 'disposed']);
        }

        return $disposal;
    }

    private function postJournal(
        Asset $asset,
        AssetDisposal $disposal,
        string $type,
        float $salePrice,
        float $accumulated,
        float $bookValue,
        float $gainLoss,
        string $date,
    ): void {
        $assetAccount = $asset->category?->assetAccount
            ?? Account::where('code', '1250')->first();
        $accumulatedAccount = $asset->category?->accumulatedDepreciationAccount
            ?? Account::where('code', '1290')->first();

        if (! $assetAccount || ! $accumulatedAccount) {
            throw new \InvalidArgumentException('Akun aset atau akumulasi penyusutan belum dikonfigurasi.');
        }

        $entries = [
            ['account_id' => $accumulatedAccount->id, 'debit' => $accumulated, 'credit' => 0],
            ['account_id' => $assetAccount->id, 'debit' => 0, 'credit' => (float) $asset->acquisition_cost],
        ];

        if ($type === 'sale') {
            $cashAccount = Account::where('code', '1110')->first();

            if (! $cashAccount) {
                throw new \InvalidArgumentException('Akun kas belum tersedia di chart of accounts.');
            }

            $entries[] = ['account_id' => $cashAccount->id, 'debit' => $salePrice, 'credit' => 0];

            if ($gainLoss > 0) {
                $gainAccount = Account::where('code', '4100')->first();

                if (! $gainAccount) {
                    throw new \InvalidArgumentException('Akun laba pelepasan aset belum tersedia.');
                }

                $entries[] = ['account_id' => $gainAccount->id, 'debit' => 0, 'credit' => $gainLoss];
            } elseif ($gainLoss < 0) {
                $lossAccount = Account::where('code', '5300')->first();

                if (! $lossAccount) {
                    throw new \InvalidArgumentException('Akun rugi pelepasan aset belum tersedia.');
                }

                $entries[] = ['account_id' => $lossAccount->id, 'debit' => abs($gainLoss), 'credit' => 0];
            }
        } elseif ($type === 'write_off' && $bookValue > 0) {
            $lossAccount = Account::where('code', '5300')->first();

            if (! $lossAccount) {
                throw new \InvalidArgumentException('Akun rugi pelepasan aset belum tersedia.');
            }

            $entries[] = ['account_id' => $lossAccount->id, 'debit' => $bookValue, 'credit' => 0];
        }

        $reference = $this->journalService->nextReference('DSP-');

        $this->journalService->create(
            $disposal,
            $reference,
            $date,
            'Pelepasan aset '.$asset->name.' ('.ucfirst($type).')',
            $entries,
        );
    }
}
