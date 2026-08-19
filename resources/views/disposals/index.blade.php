@extends('layouts.app')

@section('title', 'Pelepasan Aset')
@section('page-title', 'Transaksi')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Transaksi</a>
    <span>/</span>
    <span class="text-slate-700">Pelepasan Aset</span>
@endsection

@section('content')
    <div class="flex flex-col md:flex-row justify-between md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Pelepasan Aset</h2>
            <p class="text-text-secondary text-sm">Catat penjualan, penghapusan, atau transfer aset beserta jurnalnya.</p>
        </div>
        <a href="{{ route('disposals.create') }}" class="bg-primary text-white px-4 py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2 hover:bg-primary-dark transition-colors shadow-sm">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Catat Pelepasan
        </a>
    </div>

    @if (Session::has('success'))
        <x-flash type="success">{{ Session::get('success') }}</x-flash>
    @endif
    @if (Session::has('error'))
        <x-flash type="error">{{ Session::get('error') }}</x-flash>
    @endif

    <x-table :items="$disposals" empty="Belum ada pelepasan aset yang dicatat.">
        <x-slot:header>
            <h3 class="font-semibold text-text-primary">Riwayat Pelepasan Aset</h3>
        </x-slot:header>

        <x-slot:head>
            <x-table.th>Aset</x-table.th>
            <x-table.th>Tanggal</x-table.th>
            <x-table.th>Jenis</x-table.th>
            <x-table.th align="right">Nilai Buku</x-table.th>
            <x-table.th align="right">Laba / Rugi</x-table.th>
            <x-table.th align="right">Aksi</x-table.th>
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
                <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($disposal->book_value, 0, ',', '.') }}</x-table.td>
                <x-table.td align="right">
                    @if ($disposal->gain_loss > 0)
                        <span class="text-sm font-medium text-primary">+{{ number_format($disposal->gain_loss, 0, ',', '.') }}</span>
                    @elseif ($disposal->gain_loss < 0)
                        <span class="text-sm font-medium text-danger">{{ number_format($disposal->gain_loss, 0, ',', '.') }}</span>
                    @else
                        <span class="text-sm text-text-secondary">-</span>
                    @endif
                </x-table.td>
                <x-table.td align="right">
                    <a href="{{ route('disposals.show', $disposal->id) }}" class="p-1.5 hover:bg-info-light rounded-lg text-text-secondary hover:text-info">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </a>
                </x-table.td>
            </tr>
        @endforeach
    </x-table>

    <script>lucide.createIcons();</script>
@endsection