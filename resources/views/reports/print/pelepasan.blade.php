@php
    $typeLabel = ['sale' => 'Penjualan', 'write_off' => 'Penghapusan', 'transfer' => 'Transfer'];
@endphp

<table class="print-table">
    <thead>
        <tr>
            <th>Aset</th>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th class="num">Harga Jual</th>
            <th class="num">Nilai Buku</th>
            <th class="num">Laba / Rugi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($disposals as $disposal)
            <tr>
                <td>
                    {{ $disposal->asset?->name ?? '-' }}
                    <span style="color:#64748b;">({{ $disposal->asset?->asset_number ?? '-' }})</span>
                </td>
                <td>{{ $disposal->disposal_date->format('d M Y') }}</td>
                <td>{{ $typeLabel[$disposal->disposal_type] ?? $disposal->disposal_type }}</td>
                <td class="num">{{ $disposal->sale_price > 0 ? number_format($disposal->sale_price, 0, ',', '.') : '-' }}</td>
                <td class="num">{{ number_format($disposal->book_value, 0, ',', '.') }}</td>
                <td class="num">{{ number_format($disposal->gain_loss, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="6">Belum ada pelepasan aset.</td></tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5">Total Laba / Rugi</td>
            <td class="num">{{ number_format($totalGainLoss, 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>