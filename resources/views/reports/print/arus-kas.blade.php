<table class="print-table">
    <thead>
        <tr>
            <th>Periode</th>
            <th class="num">Saldo Awal</th>
            <th class="num">Kas Masuk</th>
            <th class="num">Kas Keluar</th>
            <th class="num">Arus Kas Bersih</th>
            <th class="num">Saldo Akhir</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($rows as $row)
            <tr>
                <td>{{ $row['period'] }}</td>
                <td class="num">{{ number_format($row['opening'], 0, ',', '.') }}</td>
                <td class="num">{{ number_format($row['inflow'], 0, ',', '.') }}</td>
                <td class="num">{{ number_format($row['outflow'], 0, ',', '.') }}</td>
                <td class="num">{{ number_format($row['net'], 0, ',', '.') }}</td>
                <td class="num">{{ number_format($row['closing'], 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="6">Belum ada mutasi kas.</td></tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr>
            <td>Total</td>
            <td></td>
            <td class="num">{{ number_format($totalInflow, 0, ',', '.') }}</td>
            <td class="num">{{ number_format($totalOutflow, 0, ',', '.') }}</td>
            <td class="num">{{ number_format($totalInflow - $totalOutflow, 0, ',', '.') }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>