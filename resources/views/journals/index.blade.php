@extends('layouts.app')

@section('title', 'Jurnal')
@section('page-title', 'Akuntansi')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Akuntansi</a>
    <span>/</span>
    <span class="text-slate-700">Jurnal</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-text-primary">Daftar Jurnal</h2>
        <p class="text-text-secondary text-sm">Seluruh jurnal transaksi (readonly, tidak dapat diubah manual).</p>
    </div>

    <x-table :items="$journals" empty="Belum ada jurnal. Catat transaksi perolehan, penyusutan, atau pelepasan terlebih dahulu.">
        <x-slot:header>
            <form method="GET" action="{{ route('journals.index') }}" class="w-full flex flex-col md:flex-row gap-3 md:items-end">
                <div class="w-full md:w-64">
                    <x-forms.label for="search">Cari</x-forms.label>
                    <x-forms.input name="search" :value="request('search')" placeholder="Referensi / keterangan..." icon="search" />
                </div>
                <div class="w-full md:w-44">
                    <x-forms.label for="from">Dari Tanggal</x-forms.label>
                    <x-forms.datepicker name="from" :value="request('from')" />
                </div>
                <div class="w-full md:w-44">
                    <x-forms.label for="to">Sampai Tanggal</x-forms.label>
                    <x-forms.datepicker name="to" :value="request('to')" />
                </div>
                <div class="flex gap-2">
                    <button type="submit" class="px-4 py-2.5 text-sm font-semibold text-white bg-primary rounded-xl hover:bg-primary-dark transition-colors shadow-sm flex items-center gap-2">
                        <i data-lucide="filter" class="w-4 h-4"></i> Filter
                    </button>
                    @if (request()->filled('search') || request()->filled('from') || request()->filled('to'))
                        <a href="{{ route('journals.index') }}" class="px-4 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50 flex items-center gap-2">
                            <i data-lucide="x" class="w-4 h-4"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </x-slot:header>

        <x-slot:head>
            <x-table.th>Referensi</x-table.th>
            <x-table.th>Tanggal</x-table.th>
            <x-table.th>Keterangan</x-table.th>
            <x-table.th>Terkait</x-table.th>
            <x-table.th align="right">Aksi</x-table.th>
        </x-slot>

        @foreach ($journals as $journal)
            <tr class="hover:bg-slate-50 transition-colors">
                <x-table.td class="text-sm font-mono font-medium text-slate-700">{{ $journal->reference }}</x-table.td>
                <x-table.td class="text-sm text-slate-600">{{ $journal->transaction_date->format('d M Y') }}</x-table.td>
                <x-table.td class="text-sm text-text-primary">{{ $journal->description }}</x-table.td>
                <x-table.td class="text-sm text-slate-600">{{ $journal->relatedLabel() ?? '-' }}</x-table.td>
                <x-table.td align="right">
                    <a href="{{ route('journals.show', $journal->id) }}" class="p-1.5 hover:bg-info-light rounded-lg text-text-secondary hover:text-info">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </a>
                </x-table.td>
            </tr>
        @endforeach
    </x-table>

    <script>lucide.createIcons();</script>
@endsection