@php
    $totalDebit = $journal->details->sum(fn ($detail) => $detail->debit);
    $totalCredit = $journal->details->sum(fn ($detail) => $detail->credit);
@endphp

<div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden">
    <div class="p-5 border-b border-slate-100 flex flex-wrap items-center justify-between gap-3">
        <div>
            <p class="text-xs font-semibold text-text-secondary uppercase tracking-wider">Jurnal Transaksi</p>
            <p class="font-bold text-text-primary mt-1">{{ $journal->description }}</p>
        </div>
        <div class="flex items-center gap-4 text-sm">
            <span class="text-text-secondary">Ref: <span class="font-mono font-medium text-text-primary">{{ $journal->reference }}</span></span>
            <span class="text-text-secondary">Tanggal: <span class="font-medium text-text-primary">{{ $journal->transaction_date->format('d M Y') }}</span></span>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider">Kode</th>
                    <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider">Akun</th>
                    <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider text-right">Debit</th>
                    <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider text-right">Kredit</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($journal->details as $detail)
                    <tr class="hover:bg-slate-50">
                        <td class="py-3 px-4 text-sm font-mono text-slate-600">{{ $detail->account->code }}</td>
                        <td class="py-3 px-4 text-sm font-medium text-text-primary">{{ $detail->account->name }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600 text-right">{{ $detail->debit > 0 ? number_format($detail->debit, 0, ',', '.') : '-' }}</td>
                        <td class="py-3 px-4 text-sm text-slate-600 text-right">{{ $detail->credit > 0 ? number_format($detail->credit, 0, ',', '.') : '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="border-t-2 border-slate-200 bg-slate-50">
                <tr>
                    <td class="py-3 px-4 text-xs font-semibold uppercase tracking-wider text-text-secondary" colspan="2">Total</td>
                    <td class="py-3 px-4 text-sm font-bold text-text-primary text-right">{{ number_format($totalDebit, 0, ',', '.') }}</td>
                    <td class="py-3 px-4 text-sm font-bold text-text-primary text-right">{{ number_format($totalCredit, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>