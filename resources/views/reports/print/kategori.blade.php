@php
    $grandCost = $categories->sum('cost');
    $grandAccumulated = $categories->sum('accumulated');
    $grandBookValue = $categories->sum('book_value');
@endphp

<table class="print-table">
    <thead>
        <tr>
            <th>Kode</th>
            <th>Kategori</th>
            <th class="num">Jumlah Aset</th>
            <th class="num">Harga Perolehan</th>
            <th class="num">Akumulasi Penyusutan</th>
            <th class="num">Nilai Buku</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $item)
            <tr>
                <td>{{ $item['category']->code }}</td>
                <td>{{ $item['category']->name }}</td>
                <td class="num">{{ $item['count'] }}</td>
                <td class="num">{{ number_format($item['cost'], 0, ',', '.') }}</td>
                <td class="num">{{ number_format($item['accumulated'], 0, ',', '.') }}</td>
                <td class="num">{{ number_format($item['book_value'], 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="6">Belum ada kategori aset.</td></tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td colspan="2">Total</td>
            <td class="num">{{ $categories->sum('count') }}</td>
            <td class="num">{{ number_format($grandCost, 0, ',', '.') }}</td>
            <td class="num">{{ number_format($grandAccumulated, 0, ',', '.') }}</td>
            <td class="num">{{ number_format($grandBookValue, 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>