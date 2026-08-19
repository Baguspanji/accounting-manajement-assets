@extends('layouts.app')

@section('title', 'Neraca Saldo')
@section('page-title', 'Akuntansi')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Akuntansi</a>
    <span>/</span>
    <span class="text-slate-700">Neraca Saldo</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-text-primary">Neraca Saldo</h2>
        <p class="text-text-secondary text-sm">Dihasilkan otomatis dari seluruh jurnal. Total debit harus sama dengan total kredit.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5">
            <p class="text-xs text-text-secondary mb-1">Total Debit</p>
            <p class="text-lg font-bold text-text-primary">Rp {{ number_format($totalDebit, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5">
            <p class="text-xs text-text-secondary mb-1">Total Kredit</p>
            <p class="text-lg font-bold text-text-primary">Rp {{ number_format($totalCredit, 0, ',', '.') }}</p>
        </div>
    </div>

    <x-table :items="$entries" empty="Belum ada jurnal, neraca saldo kosong.">
        <x-slot:head>
            <x-table.th>Kode</x-table.th>
            <x-table.th>Nama Akun</x-table.th>
            <x-table.th align="right">Debit</x-table.th>
            <x-table.th align="right">Kredit</x-table.th>
            <x-table.th align="right">Saldo</x-table.th>
        </x-slot>

        @foreach ($entries as $entry)
            <tr class="hover:bg-slate-50 transition-colors">
                <x-table.td class="text-sm font-mono font-medium text-slate-700">{{ $entry['account']->code }}</x-table.td>
                <x-table.td class="text-sm font-medium text-text-primary">{{ $entry['account']->name }}</x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ $entry['debit'] > 0 ? number_format($entry['debit'], 0, ',', '.') : '-' }}</x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ $entry['credit'] > 0 ? number_format($entry['credit'], 0, ',', '.') : '-' }}</x-table.td>
                <x-table.td align="right">
                    <span class="text-sm font-semibold {{ $entry['balance'] < 0 ? 'text-danger' : 'text-text-primary' }}">
                        {{ number_format(abs($entry['balance']), 0, ',', '.') }}
                        {{ $entry['balance'] < 0 ? 'K' : 'D' }}
                    </span>
                </x-table.td>
            </tr>
        @endforeach

        <x-slot:footer>
            <tr>
                <x-table.td class="text-xs font-semibold uppercase tracking-wider text-text-secondary" colspan="2">Total</x-table.td>
                <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ number_format($totalDebit, 0, ',', '.') }}</x-table.td>
                <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ number_format($totalCredit, 0, ',', '.') }}</x-table.td>
                <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ number_format(abs($totalDebit - $totalCredit), 0, ',', '.') }}</x-table.td>
            </tr>
        </x-slot:footer>
    </x-table>

    <script>lucide.createIcons();</script>
@endsection