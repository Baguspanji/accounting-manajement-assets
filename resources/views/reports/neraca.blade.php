@extends('layouts.app')

@section('title', 'Laporan Neraca')
@section('page-title', 'Laporan')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Laporan</a>
    <span>/</span>
    <a href="{{ route('reports.index') }}" class="hover:text-primary">Semua Laporan</a>
    <span>/</span>
    <span class="text-slate-700">Neraca</span>
@endsection

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Neraca</h2>
            <p class="text-text-secondary text-sm">Posisi keuangan {{ $asOf ? 'per '.$asOf->format('d M Y') : 'hingga seluruh transaksi tercatat' }}.</p>
        </div>
        <form method="GET" action="{{ route('reports.neraca') }}" class="flex items-end gap-2">
            <div class="w-44">
                <x-forms.label for="as_of">Per Tanggal</x-forms.label>
                <x-forms.datepicker name="as_of" :value="old('as_of', $asOf?->format('Y-m-d'))" />
            </div>
            <button type="submit" class="px-4 py-2.5 text-sm font-semibold text-white bg-primary rounded-xl hover:bg-primary-dark transition-colors shadow-sm flex items-center gap-2">
                <i data-lucide="filter" class="w-4 h-4"></i> Tampilkan
            </button>
            <a href="{{ route('reports.neraca.pdf', request()->query()) }}" target="_blank"
                class="px-4 py-2.5 text-sm font-semibold text-primary bg-primary-light rounded-xl hover:bg-primary/15 transition-colors flex items-center gap-2">
                <i data-lucide="file-down" class="w-4 h-4"></i> Export PDF
            </a>
        </form>
    </div>

    @php
        $assetRows = $assets->where('balance', '!=', 0);
        $liabilityRows = $liabilities->where('normal_balance', '!=', 0);
        $equityRows = $equityEntries->where('normal_balance', '!=', 0);
        $grandLiabilityEquity = $liabilityTotal + $equityTotal;
    @endphp

    <div class="space-y-6">
        <x-table empty="Tidak ada saldo aset.">
            <x-slot:header>
                <h3 class="font-bold text-text-primary">Aset</h3>
            </x-slot:header>
            <x-slot:head>
                <x-table.th>Kode</x-table.th>
                <x-table.th>Nama Akun</x-table.th>
                <x-table.th align="right">Saldo</x-table.th>
            </x-slot>
            @foreach ($assetRows as $entry)
                <tr class="hover:bg-slate-50 transition-colors">
                    <x-table.td class="text-sm font-mono text-slate-700">{{ $entry['account']->code }}</x-table.td>
                    <x-table.td class="text-sm text-text-primary">{{ $entry['account']->name }}</x-table.td>
                    <x-table.td align="right" class="text-sm {{ $entry['balance'] < 0 ? 'text-danger' : 'text-slate-600' }}">{{ number_format($entry['balance'], 0, ',', '.') }}</x-table.td>
                </tr>
            @endforeach
            <x-slot:footer>
                <tr>
                    <x-table.td class="text-xs font-semibold uppercase tracking-wider text-text-secondary" colspan="2">Total Aset</x-table.td>
                    <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ number_format($assetTotal, 0, ',', '.') }}</x-table.td>
                </tr>
            </x-slot:footer>
        </x-table>

        <x-table empty="Tidak ada saldo liabilitas.">
            <x-slot:header>
                <h3 class="font-bold text-text-primary">Liabilitas</h3>
            </x-slot:header>
            <x-slot:head>
                <x-table.th>Kode</x-table.th>
                <x-table.th>Nama Akun</x-table.th>
                <x-table.th align="right">Saldo</x-table.th>
            </x-slot>
            @foreach ($liabilityRows as $entry)
                <tr class="hover:bg-slate-50 transition-colors">
                    <x-table.td class="text-sm font-mono text-slate-700">{{ $entry['account']->code }}</x-table.td>
                    <x-table.td class="text-sm text-text-primary">{{ $entry['account']->name }}</x-table.td>
                    <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($entry['normal_balance'], 0, ',', '.') }}</x-table.td>
                </tr>
            @endforeach
            <x-slot:footer>
                <tr>
                    <x-table.td class="text-xs font-semibold uppercase tracking-wider text-text-secondary" colspan="2">Total Liabilitas</x-table.td>
                    <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ number_format($liabilityTotal, 0, ',', '.') }}</x-table.td>
                </tr>
            </x-slot:footer>
        </x-table>

        <x-table empty="Tidak ada saldo ekuitas.">
            <x-slot:header>
                <h3 class="font-bold text-text-primary">Ekuitas</h3>
            </x-slot:header>
            <x-slot:head>
                <x-table.th>Kode</x-table.th>
                <x-table.th>Nama Akun</x-table.th>
                <x-table.th align="right">Saldo</x-table.th>
            </x-slot>
            @foreach ($equityRows as $entry)
                <tr class="hover:bg-slate-50 transition-colors">
                    <x-table.td class="text-sm font-mono text-slate-700">{{ $entry['account']->code }}</x-table.td>
                    <x-table.td class="text-sm text-text-primary">{{ $entry['account']->name }}</x-table.td>
                    <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($entry['normal_balance'], 0, ',', '.') }}</x-table.td>
                </tr>
            @endforeach
            <tr class="hover:bg-slate-50">
                <x-table.td class="text-sm font-mono text-slate-700">-</x-table.td>
                <x-table.td class="text-sm text-text-primary">Laba Periode Berjalan</x-table.td>
                <x-table.td align="right" class="text-sm {{ $netIncome >= 0 ? 'text-slate-600' : 'text-danger' }}">{{ number_format($netIncome, 0, ',', '.') }}</x-table.td>
            </tr>
            <x-slot:footer>
                <tr>
                    <x-table.td class="text-xs font-semibold uppercase tracking-wider text-text-secondary" colspan="2">Total Ekuitas</x-table.td>
                    <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ number_format($equityTotal, 0, ',', '.') }}</x-table.td>
                </tr>
            </x-slot:footer>
        </x-table>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5">
                <p class="text-xs text-text-secondary mb-1">Total Aset</p>
                <p class="text-xl font-bold text-text-primary">Rp {{ number_format($assetTotal, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5">
                <p class="text-xs text-text-secondary mb-1">Total Liabilitas + Ekuitas</p>
                <p class="text-xl font-bold {{ $grandLiabilityEquity == $assetTotal ? 'text-primary' : 'text-danger' }}">Rp {{ number_format($grandLiabilityEquity, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <script>lucide.createIcons();</script>
@endsection