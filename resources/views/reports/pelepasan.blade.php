@extends('layouts.app')

@section('title', 'Laporan Pelepasan Aset')
@section('page-title', 'Laporan')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Laporan</a>
    <span>/</span>
    <a href="{{ route('reports.index') }}" class="hover:text-primary">Semua Laporan</a>
    <span>/</span>
    <span class="text-slate-700">Pelepasan Aset</span>
@endsection

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Laba/Rugi Pelepasan Aset</h2>
            <p class="text-text-secondary text-sm">Seluruh penjualan, penghapusan, dan transfer aset beserta laba/ruginya.</p>
        </div>
        <a href="{{ route('reports.pelepasan.pdf') }}" target="_blank"
            class="px-4 py-2.5 text-sm font-semibold text-primary bg-primary-light rounded-xl hover:bg-primary/15 transition-colors flex items-center gap-2">
            <i data-lucide="file-down" class="w-4 h-4"></i> Export PDF
        </a>
    </div>

    <x-table :items="$disposals" empty="Belum ada pelepasan aset.">
        <x-slot:head>
            <x-table.th>Aset</x-table.th>
            <x-table.th>Tanggal</x-table.th>
            <x-table.th>Jenis</x-table.th>
            <x-table.th align="right">Harga Jual</x-table.th>
            <x-table.th align="right">Nilai Buku</x-table.th>
            <x-table.th align="right">Laba / Rugi</x-table.th>
        </x-slot>

        @foreach ($disposals as $disposal)
            <tr class="hover:bg-slate-50 transition-colors">
                <x-table.td>
                    <p class="font-medium text-text-primary text-sm">{{ $disposal->asset?->name }}</p>
                    <p class="text-xs text-text-secondary">{{ $disposal->asset?->asset_number }}</p>
                </x-table.td>
                <x-table.td class="text-sm text-slate-600">{{ $disposal->disposal_date->format('d M Y') }}</x-table.td>
                <x-table.td>
                    @php
                        $typeLabel = ['sale' => 'Penjualan', 'write_off' => 'Penghapusan', 'transfer' => 'Transfer'];
                    @endphp
                    <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-slate-100 text-slate-600">
                        {{ $typeLabel[$disposal->disposal_type] ?? $disposal->disposal_type }}
                    </span>
                </x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ $disposal->sale_price > 0 ? number_format($disposal->sale_price, 0, ',', '.') : '-' }}</x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($disposal->book_value, 0, ',', '.') }}</x-table.td>
                <x-table.td align="right">
                    @if ($disposal->gain_loss > 0)
                        <span class="text-sm font-semibold text-primary">+{{ number_format($disposal->gain_loss, 0, ',', '.') }}</span>
                    @elseif ($disposal->gain_loss < 0)
                        <span class="text-sm font-semibold text-danger">{{ number_format($disposal->gain_loss, 0, ',', '.') }}</span>
                    @else
                        <span class="text-sm text-text-secondary">-</span>
                    @endif
                </x-table.td>
            </tr>
        @endforeach

        <x-slot:footer>
            <tr>
                <x-table.td class="text-xs font-semibold uppercase tracking-wider text-text-secondary" colspan="5">Total Laba / Rugi</x-table.td>
                <x-table.td align="right">
                    <span class="text-sm font-bold {{ $totalGainLoss >= 0 ? 'text-primary' : 'text-danger' }}">
                        {{ $totalGainLoss > 0 ? '+' : '' }}{{ number_format($totalGainLoss, 0, ',', '.') }}
                    </span>
                </x-table.td>
            </tr>
        </x-slot:footer>
    </x-table>

    <script>lucide.createIcons();</script>
@endsection