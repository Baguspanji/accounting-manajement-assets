@extends('layouts.app')

@section('title', 'Jadwal Penyusutan')
@section('page-title', 'Laporan')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Laporan</a>
    <span>/</span>
    <a href="{{ route('reports.index') }}" class="hover:text-primary">Semua Laporan</a>
    <span>/</span>
    <span class="text-slate-700">Jadwal Penyusutan</span>
@endsection

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Jadwal Penyusutan</h2>
            <p class="text-text-secondary text-sm">Beban penyusutan seluruh aset per periode.</p>
        </div>
        <a href="{{ route('reports.jadwal-penyusutan.pdf') }}" target="_blank"
            class="px-4 py-2.5 text-sm font-semibold text-primary bg-primary-light rounded-xl hover:bg-primary/15 transition-colors flex items-center gap-2">
            <i data-lucide="file-down" class="w-4 h-4"></i> Export PDF
        </a>
    </div>

    <x-table :items="$depreciations" empty="Belum ada jadwal penyusutan.">
        <x-slot:head>
            <x-table.th>Aset</x-table.th>
            <x-table.th>Periode</x-table.th>
            <x-table.th>Metode</x-table.th>
            <x-table.th align="right">Beban Penyusutan</x-table.th>
            <x-table.th align="right">Akumulasi</x-table.th>
            <x-table.th align="right">Nilai Buku</x-table.th>
            <x-table.th>Status</x-table.th>
        </x-slot>

        @foreach ($depreciations as $depreciation)
            <tr class="hover:bg-slate-50 transition-colors">
                <x-table.td>
                    <p class="font-medium text-text-primary text-sm">{{ $depreciation->asset?->name }}</p>
                    <p class="text-xs text-text-secondary">{{ $depreciation->asset?->asset_number }}</p>
                </x-table.td>
                <x-table.td class="text-sm font-mono text-slate-600">{{ $depreciation->period }}</x-table.td>
                <x-table.td class="text-sm text-slate-600">{{ $depreciation->asset?->depreciationMethod?->name ?? '-' }}</x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($depreciation->expense_amount, 0, ',', '.') }}</x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($depreciation->accumulated_after, 0, ',', '.') }}</x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($depreciation->book_value_after, 0, ',', '.') }}</x-table.td>
                <x-table.td>
                    @if ($depreciation->status === 'posted')
                        <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-primary-light text-primary">Posted</span>
                    @else
                        <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-warning-light text-warning">Pending</span>
                    @endif
                </x-table.td>
            </tr>
        @endforeach

        <x-slot:footer>
            <tr>
                <x-table.td class="text-xs font-semibold uppercase tracking-wider text-text-secondary" colspan="3">Total Beban Penyusutan</x-table.td>
                <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ number_format($totalExpense, 0, ',', '.') }}</x-table.td>
                <x-table.td colspan="3"></x-table.td>
            </tr>
        </x-slot:footer>
    </x-table>

    <script>lucide.createIcons();</script>
@endsection