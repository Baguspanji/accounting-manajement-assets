@extends('layouts.app')

@section('title', 'Perolehan Aset')
@section('page-title', 'Transaksi')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Transaksi</a>
    <span>/</span>
    <span class="text-slate-700">Perolehan Aset</span>
@endsection

@section('content')
    <div class="flex flex-col md:flex-row justify-between md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Perolehan Aset</h2>
            <p class="text-text-secondary text-sm">Catat pengakuan perolehan aset tetap beserta jurnalnya.</p>
        </div>
        <a href="{{ route('acquisitions.create') }}" class="bg-primary text-white px-4 py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2 hover:bg-primary-dark transition-colors shadow-sm">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Catat Perolehan
        </a>
    </div>

    @if (Session::has('success'))
        <x-flash type="success">{{ Session::get('success') }}</x-flash>
    @endif
    @if (Session::has('error'))
        <x-flash type="error">{{ Session::get('error') }}</x-flash>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 bg-primary-light rounded-xl flex items-center justify-center">
                    <i data-lucide="package-plus" class="w-5 h-5 text-primary"></i>
                </div>
                <div>
                    <p class="text-xs text-text-secondary">Total Perolehan</p>
                    <p class="text-lg font-bold text-text-primary">{{ $journals->total() }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5">
            <div class="flex items-center gap-4">
                <div class="w-11 h-11 bg-primary-light rounded-xl flex items-center justify-center">
                    <i data-lucide="layers" class="w-5 h-5 text-primary"></i>
                </div>
                <div>
                    <p class="text-xs text-text-secondary">Total Aset Dicatat</p>
                    <p class="text-lg font-bold text-text-primary">{{ $journals->total() }}</p>
                </div>
            </div>
        </div>
    </div>

    <x-table :items="$journals" empty="Belum ada perolehan aset yang dicatat.">
        <x-slot:header>
            <h3 class="font-semibold text-text-primary">Riwayat Perolehan Aset</h3>
        </x-slot:header>

        <x-slot:head>
            <x-table.th>Referensi</x-table.th>
            <x-table.th>Aset</x-table.th>
            <x-table.th>Tanggal</x-table.th>
            <x-table.th>Keterangan</x-table.th>
            <x-table.th align="right">Aksi</x-table.th>
        </x-slot>

        @foreach ($journals as $journal)
            <tr class="hover:bg-slate-50 transition-colors">
                <x-table.td class="text-sm font-mono font-medium text-slate-700">{{ $journal->reference }}</x-table.td>
                <x-table.td>
                    <p class="font-medium text-text-primary text-sm">{{ $journal->journalable?->name }}</p>
                    <p class="text-xs text-text-secondary">{{ $journal->journalable?->asset_number }}</p>
                </x-table.td>
                <x-table.td class="text-sm text-slate-600">{{ $journal->transaction_date->format('d M Y') }}</x-table.td>
                <x-table.td class="text-sm text-slate-600">{{ $journal->description }}</x-table.td>
                <x-table.td align="right">
                    <a href="{{ route('acquisitions.show', $journal->id) }}" class="p-1.5 hover:bg-info-light rounded-lg text-text-secondary hover:text-info">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </a>
                </x-table.td>
            </tr>
        @endforeach
    </x-table>

    <script>lucide.createIcons();</script>
@endsection