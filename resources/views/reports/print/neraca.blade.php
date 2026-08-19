@php
    $assetRows = $assets->where('balance', '!=', 0);
    $liabilityRows = $liabilities->where('normal_balance', '!=', 0);
    $equityRows = $equityEntries->where('normal_balance', '!=', 0);
    $grandLiabilityEquity = $liabilityTotal + $equityTotal;
@endphp

<h2 class="section-title">Aset</h2>
<table class="print-table">
    <thead>
        <tr><th>Kode</th><th>Nama Akun</th><th class="num">Saldo</th></tr>
    </thead>
    <tbody>
        @forelse ($assetRows as $entry)
            <tr>
                <td>{{ $entry['account']->code }}</td>
                <td>{{ $entry['account']->name }}</td>
                <td class="num">{{ number_format($entry['balance'], 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="3">Tidak ada saldo aset.</td></tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr><td colspan="2">Total Aset</td><td class="num">{{ number_format($assetTotal, 0, ',', '.') }}</td></tr>
    </tfoot>
</table>

<h2 class="section-title">Liabilitas</h2>
<table class="print-table">
    <thead>
        <tr><th>Kode</th><th>Nama Akun</th><th class="num">Saldo</th></tr>
    </thead>
    <tbody>
        @forelse ($liabilityRows as $entry)
            <tr>
                <td>{{ $entry['account']->code }}</td>
                <td>{{ $entry['account']->name }}</td>
                <td class="num">{{ number_format($entry['normal_balance'], 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="3">Tidak ada saldo liabilitas.</td></tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr><td colspan="2">Total Liabilitas</td><td class="num">{{ number_format($liabilityTotal, 0, ',', '.') }}</td></tr>
    </tfoot>
</table>

<h2 class="section-title">Ekuitas</h2>
<table class="print-table">
    <thead>
        <tr><th>Kode</th><th>Nama Akun</th><th class="num">Saldo</th></tr>
    </thead>
    <tbody>
        @forelse ($equityRows as $entry)
            <tr>
                <td>{{ $entry['account']->code }}</td>
                <td>{{ $entry['account']->name }}</td>
                <td class="num">{{ number_format($entry['normal_balance'], 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="3">Tidak ada saldo ekuitas.</td></tr>
        @endforelse
        <tr>
            <td>-</td>
            <td>Laba Periode Berjalan</td>
            <td class="num">{{ number_format($netIncome, 0, ',', '.') }}</td>
        </tr>
    </tbody>
    <tfoot>
        <tr><td colspan="2">Total Ekuitas</td><td class="num">{{ number_format($equityTotal, 0, ',', '.') }}</td></tr>
    </tfoot>
</table>

<table class="print-table" style="margin-top:12px;">
    <tfoot>
        <tr>
            <td>Total Aset</td>
            <td class="num">{{ number_format($assetTotal, 0, ',', '.') }}</td>
            <td style="width:50%;">Total Liabilitas + Ekuitas</td>
            <td class="num" style="width:25%;">{{ number_format($grandLiabilityEquity, 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>