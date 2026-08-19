@php
    $revenueRows = $revenues->where('normal_balance', '!=', 0);
    $expenseRows = $expenses->where('normal_balance', '!=', 0);
@endphp

<h2 class="section-title">Pendapatan</h2>
<table class="print-table">
    <thead>
        <tr><th>Kode</th><th>Nama Akun</th><th class="num">Jumlah</th></tr>
    </thead>
    <tbody>
        @forelse ($revenueRows as $entry)
            <tr>
                <td>{{ $entry['account']->code }}</td>
                <td>{{ $entry['account']->name }}</td>
                <td class="num">{{ number_format($entry['normal_balance'], 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="3">Tidak ada pendapatan.</td></tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr><td colspan="2">Total Pendapatan</td><td class="num">{{ number_format($revenueTotal, 0, ',', '.') }}</td></tr>
    </tfoot>
</table>

<h2 class="section-title">Beban</h2>
<table class="print-table">
    <thead>
        <tr><th>Kode</th><th>Nama Akun</th><th class="num">Jumlah</th></tr>
    </thead>
    <tbody>
        @forelse ($expenseRows as $entry)
            <tr>
                <td>{{ $entry['account']->code }}</td>
                <td>{{ $entry['account']->name }}</td>
                <td class="num">{{ number_format($entry['normal_balance'], 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="3">Tidak ada beban.</td></tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr><td colspan="2">Total Beban</td><td class="num">{{ number_format($expenseTotal, 0, ',', '.') }}</td></tr>
    </tfoot>
</table>

<table class="print-table" style="margin-top:12px;">
    <tfoot>
        <tr>
            <td>{{ $netIncome >= 0 ? 'Laba Bersih' : 'Rugi Bersih' }}</td>
            <td class="num" colspan="2">{{ number_format(abs($netIncome), 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>