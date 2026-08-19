@extends('layouts.app')

@section('title', 'Buku Besar - '.$account->name)
@section('page-title', 'Akuntansi')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Akuntansi</a>
    <span>/</span>
    <a href="{{ route('ledger.index') }}" class="hover:text-primary">Buku Besar</a>
    <span>/</span>
    <span class="text-slate-700">Detail Akun</span>
@endsection

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-text-primary">{{ $account->code }} - {{ $account->name }}</h2>
            <p class="text-text-secondary text-sm">Mutasi akun dengan saldo berjalan.</p>
        </div>
        <a href="{{ route('ledger.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 text-sm font-medium">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5">
            <p class="text-xs text-text-secondary mb-1">Total Debit</p>
            <p class="text-lg font-bold text-text-primary">Rp {{ number_format($totalDebit, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5">
            <p class="text-xs text-text-secondary mb-1">Total Kredit</p>
            <p class="text-lg font-bold text-text-primary">Rp {{ number_format($totalCredit, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5">
            <p class="text-xs text-text-secondary mb-1">Saldo Akhir</p>
            <p class="text-lg font-bold {{ $rows->last()['balance'] ?? 0 < 0 ? 'text-danger' : 'text-text-primary' }}">
                Rp {{ number_format(abs($rows->last()['balance'] ?? 0), 0, ',', '.') }}
                {{ ($rows->last()['balance'] ?? 0) < 0 ? 'K' : 'D' }}
            </p>
        </div>
    </div>

    <x-table :items="$rows" empty="Belum ada mutasi untuk akun ini.">
        <x-slot:head>
            <x-table.th>Tanggal</x-table.th>
            <x-table.th>Referensi</x-table.th>
            <x-table.th>Keterangan</x-table.th>
            <x-table.th align="right">Debit</x-table.th>
            <x-table.th align="right">Kredit</x-table.th>
            <x-table.th align="right">Saldo</x-table.th>
        </x-slot>

        @foreach ($rows as $row)
            <tr class="hover:bg-slate-50 transition-colors">
                <x-table.td class="text-sm text-slate-600">{{ $row['journal']->transaction_date->format('d M Y') }}</x-table.td>
                <x-table.td class="text-sm font-mono text-slate-700">{{ $row['journal']->reference }}</x-table.td>
                <x-table.td class="text-sm text-text-primary">{{ $row['journal']->description }}</x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ $row['debit'] > 0 ? number_format($row['debit'], 0, ',', '.') : '-' }}</x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ $row['credit'] > 0 ? number_format($row['credit'], 0, ',', '.') : '-' }}</x-table.td>
                <x-table.td align="right">
                    <span class="text-sm font-semibold {{ $row['balance'] < 0 ? 'text-danger' : 'text-text-primary' }}">
                        {{ number_format(abs($row['balance']), 0, ',', '.') }}
                        {{ $row['balance'] < 0 ? 'K' : 'D' }}
                    </span>
                </x-table.td>
            </tr>
        @endforeach
    </x-table>

    <script>lucide.createIcons();</script>
@endsection