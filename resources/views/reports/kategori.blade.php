@extends('layouts.app')

@section('title', 'Nilai Buku per Kategori')
@section('page-title', 'Laporan')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Laporan</a>
    <span>/</span>
    <a href="{{ route('reports.index') }}" class="hover:text-primary">Semua Laporan</a>
    <span>/</span>
    <span class="text-slate-700">Nilai Buku per Kategori</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-text-primary">Nilai Buku per Kategori</h2>
        <p class="text-text-secondary text-sm">Ringkasan harga perolehan, akumulasi penyusutan, dan nilai buku aset per kategori.</p>
    </div>

    @php
        $grandCost = $categories->sum('cost');
        $grandAccumulated = $categories->sum('accumulated');
        $grandBookValue = $categories->sum('book_value');
    @endphp

    <x-table :items="$categories" empty="Belum ada kategori aset.">
        <x-slot:head>
            <x-table.th>Kode</x-table.th>
            <x-table.th>Kategori</x-table.th>
            <x-table.th align="right">Jumlah Aset</x-table.th>
            <x-table.th align="right">Harga Perolehan</x-table.th>
            <x-table.th align="right">Akumulasi Penyusutan</x-table.th>
            <x-table.th align="right">Nilai Buku</x-table.th>
        </x-slot>

        @foreach ($categories as $item)
            <tr class="hover:bg-slate-50 transition-colors">
                <x-table.td class="text-sm font-mono text-slate-700">{{ $item['category']->code }}</x-table.td>
                <x-table.td class="text-sm font-medium text-text-primary">{{ $item['category']->name }}</x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ $item['count'] }}</x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($item['cost'], 0, ',', '.') }}</x-table.td>
                <x-table.td align="right" class="text-sm text-slate-600">{{ number_format($item['accumulated'], 0, ',', '.') }}</x-table.td>
                <x-table.td align="right">
                    <span class="text-sm font-semibold text-text-primary">{{ number_format($item['book_value'], 0, ',', '.') }}</span>
                </x-table.td>
            </tr>
        @endforeach

        <x-slot:footer>
            <tr>
                <x-table.td class="text-xs font-semibold uppercase tracking-wider text-text-secondary" colspan="2">Total</x-table.td>
                <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ $categories->sum('count') }}</x-table.td>
                <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ number_format($grandCost, 0, ',', '.') }}</x-table.td>
                <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ number_format($grandAccumulated, 0, ',', '.') }}</x-table.td>
                <x-table.td align="right" class="text-sm font-bold text-text-primary">{{ number_format($grandBookValue, 0, ',', '.') }}</x-table.td>
            </tr>
        </x-slot:footer>
    </x-table>

    <script>lucide.createIcons();</script>
@endsection