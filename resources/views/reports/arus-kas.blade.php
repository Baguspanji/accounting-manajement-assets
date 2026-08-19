@extends('layouts.app')

@section('title', 'Laporan Arus Kas')
@section('page-title', 'Laporan')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Laporan</a>
    <span>/</span>
    <a href="{{ route('reports.index') }}" class="hover:text-primary">Semua Laporan</a>
    <span>/</span>
    <span class="text-slate-700">Arus Kas</span>
@endsection

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Arus Kas</h2>
            <p class="text-text-secondary text-sm">Arus kas masuk dan keluar dari akun Kas per periode.</p>
        </div>
        <a href="{{ route('reports.arus-kas.pdf') }}" target="_blank"
            class="px-4 py-2.5 text-sm font-semibold text-primary bg-primary-light rounded-xl hover:bg-primary/15 transition-colors flex items-center gap-2">
            <i data-lucide="file-down" class="w-4 h-4"></i> Export PDF
        </a>
    </div>

    <x-table :items="$rows" empty="Belum ada mutasi kas.">
        <x-slot:header>
            <h3 class="font-semibold text-text-primary">Mutasi Kas per Periode</h3>
        </x-slot:header>
        <x-slot:head>
            <x-table.th>Periode</x-table.th>
            <x-table.th align="right">Saldo Awal</x-table.th>
            <x-table.th align="right">Kas Masuk</x-table.th>
            <x-table.th align="right">Kas Keluar</x-table.th>
            <x-table.th align="right">Arus Kas Bersih</x-table.th>
            <x-table.th align="right">Saldo Akhir</x-table.th>
        </x-slot>

        @foreach ($rows as $row)
            <tr class="hover:bg-slate-50 transition-colors">
                <x-table.td class="text-sm font-mono font-medium text-slate-700">{{ $row['period'] }}</x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($row['opening'], 0, ',', '.') }}</x-table.td>
                <x-table.td align="right">
                    <span class="text-sm font-medium text-primary">+{{ number_format($row['inflow'], 0, ',', '.') }}</span>
                </x-table.td>
                <x-table.td align="right">
                    <span class="text-sm font-medium text-danger">-{{ number_format($row['outflow'], 0, ',', '.') }}</span>
                </x-table.td>
                <x-table.td align="right">
                    <span class="text-sm font-semibold {{ $row['net'] >= 0 ? 'text-primary' : 'text-danger' }}">
                        {{ $row['net'] >= 0 ? '+' : '-' }}{{ number_format(abs($row['net']), 0, ',', '.') }}
                    </span>
                </x-table.td>
                <x-table.td align="right">
                    <span class="text-sm font-semibold text-text-primary">{{ number_format($row['closing'], 0, ',', '.') }}</span>
                </x-table.td>
            </tr>
        @endforeach

        <x-slot:footer>
            <tr>
                <x-table.td class="text-xs font-semibold uppercase tracking-wider text-text-secondary">Total</x-table.td>
                <x-table.td></x-table.td>
                <x-table.td align="right" class="text-sm font-bold text-primary">+{{ number_format($totalInflow, 0, ',', '.') }}</x-table.td>
                <x-table.td align="right" class="text-sm font-bold text-danger">-{{ number_format($totalOutflow, 0, ',', '.') }}</x-table.td>
                <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ number_format($totalInflow - $totalOutflow, 0, ',', '.') }}</x-table.td>
                <x-table.td></x-table.td>
            </tr>
        </x-slot:footer>
    </x-table>

    <script>lucide.createIcons();</script>
@endsection