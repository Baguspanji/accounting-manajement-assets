<table class="print-table">
    <thead>
        <tr>
            <th>Aset</th>
            <th>Periode</th>
            <th>Metode</th>
            <th class="num">Beban Penyusutan</th>
            <th class="num">Akumulasi</th>
            <th class="num">Nilai Buku</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($depreciations as $depreciation)
            <tr>
                <td>
                    {{ $depreciation->asset?->name ?? '-' }}
                    <span style="color:#64748b;">({{ $depreciation->asset?->asset_number ?? '-' }})</span>
                </td>
                <td>{{ $depreciation->period }}</td>
                <td>{{ $depreciation->asset?->depreciationMethod?->name ?? '-' }}</td>
                <td class="num">{{ number_format($depreciation->expense_amount, 0, ',', '.') }}</td>
                <td class="num">{{ number_format($depreciation->accumulated_after, 0, ',', '.') }}</td>
                <td class="num">{{ number_format($depreciation->book_value_after, 0, ',', '.') }}</td>
                <td>
                    @if ($depreciation->status === 'posted')
                        <span class="badge badge-primary">Posted</span>
                    @else
                        <span class="badge badge-warning">Pending</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr><td colspan="7">Belum ada jadwal penyusutan.</td></tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="3">Total Beban Penyusutan</td>
            <td class="num">{{ number_format($totalExpense, 0, ',', '.') }}</td>
            <td colspan="3"></td>
        </tr>
    </tfoot>
</table>