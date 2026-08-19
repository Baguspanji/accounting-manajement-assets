@extends('layouts.app')

@section('title', 'Buku Besar')
@section('page-title', 'Akuntansi')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Akuntansi</a>
    <span>/</span>
    <span class="text-slate-700">Buku Besar</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-text-primary">Buku Besar</h2>
        <p class="text-text-secondary text-sm">Ringkasan mutasi seluruh akun. Klik akun untuk melihat rincian.</p>
    </div>

    <x-table :items="$accounts" empty="Belum ada mutasi akun.">
        <x-slot:head>
            <x-table.th>Kode</x-table.th>
            <x-table.th>Nama Akun</x-table.th>
            <x-table.th>Kategori</x-table.th>
            <x-table.th align="right">Total Debit</x-table.th>
            <x-table.th align="right">Total Kredit</x-table.th>
            <x-table.th align="right">Saldo</x-table.th>
            <x-table.th align="right">Aksi</x-table.th>
        </x-slot>

        @foreach ($accounts as $entry)
            <tr class="hover:bg-slate-50 transition-colors">
                <x-table.td class="text-sm font-mono font-medium text-slate-700">{{ $entry['account']->code }}</x-table.td>
                <x-table.td class="text-sm font-medium text-text-primary">{{ $entry['account']->name }}</x-table.td>
                <x-table.td class="text-sm text-slate-600">{{ ucfirst($entry['account']->category) }}</x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ $entry['debit'] > 0 ? number_format($entry['debit'], 0, ',', '.') : '-' }}</x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ $entry['credit'] > 0 ? number_format($entry['credit'], 0, ',', '.') : '-' }}</x-table.td>
                <x-table.td align="right">
                    <span class="text-sm font-semibold {{ $entry['balance'] < 0 ? 'text-danger' : 'text-text-primary' }}">
                        {{ number_format(abs($entry['balance']), 0, ',', '.') }}
                        {{ $entry['balance'] < 0 ? 'K' : 'D' }}
                    </span>
                </x-table.td>
                <x-table.td align="right">
                    <a href="{{ route('ledger.show', $entry['account']->id) }}" class="p-1.5 hover:bg-info-light rounded-lg text-text-secondary hover:text-info">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </a>
                </x-table.td>
            </tr>
        @endforeach
    </x-table>

    <script>lucide.createIcons();</script>
@endsection