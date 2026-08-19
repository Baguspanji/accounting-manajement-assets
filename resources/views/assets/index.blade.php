@extends('layouts.app')

@section('title', 'Aset')
@section('page-title', 'Aset')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Master</a>
    <span>/</span>
    <span class="text-slate-700">Aset</span>
@endsection

@section('content')
    <div class="flex flex-col md:flex-row justify-between md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Daftar Aset</h2>
            <p class="text-text-secondary text-sm">Kelola register / kartu aset tetap perusahaan.</p>
        </div>
        <a href="{{ route('assets.create') }}" class="bg-primary text-white px-4 py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2 hover:bg-primary-dark transition-colors shadow-sm">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Tambah Aset
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div class="mb-6 p-4 bg-primary-light border border-primary rounded-xl flex items-start gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-primary shrink-0 mt-0.5"></i>
            <div>
                <p class="font-medium text-text-primary">{{ $message }}</p>
            </div>
        </div>
    @endif

    <x-table :items="$assets" empty="Belum ada data aset.">
        <x-slot:header>
            <div class="border-b border-slate-100 flex flex-col md:flex-row gap-3 md:items-center justify-between">
                <div class="relative w-full md:w-96">
                    <i data-lucide="search" class="w-4 h-4 text-text-secondary absolute left-3 top-1/2 -translate-y-1/2"></i>
                    <input type="text" placeholder="Cari nama / nomor aset..." class="w-full pl-10 pr-4 py-2 text-sm border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30">
                </div>
                <div class="flex items-center gap-2">
                    <button class="flex items-center gap-2 text-sm text-slate-600 border border-slate-200 px-3 py-2 rounded-xl hover:bg-slate-50">
                        <i data-lucide="filter" class="w-4 h-4"></i> Filter
                    </button>
                    <button class="flex items-center gap-2 text-sm text-slate-600 border border-slate-200 px-3 py-2 rounded-xl hover:bg-slate-50">
                        <i data-lucide="download" class="w-4 h-4"></i> Export
                    </button>
                </div>
            </div>
        </x-slot:header>

        <x-slot:head>
            <x-table.th>No. Aset</x-table.th>
            <x-table.th>Nama Aset</x-table.th>
            <x-table.th>Kategori</x-table.th>
            <x-table.th>Harga Perolehan</x-table.th>
            <x-table.th>Umur (th)</x-table.th>
            <x-table.th>Metode</x-table.th>
            <x-table.th>Status</x-table.th>
            <x-table.th align="right">Aksi</x-table.th>
        </x-slot>

        @foreach ($assets as $asset)
            <tr class="hover:bg-slate-50 transition-colors">
                <x-table.td class="text-sm font-medium text-slate-700 font-mono">{{ $asset->asset_number }}</x-table.td>
                <x-table.td>
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 bg-primary-light rounded-lg flex items-center justify-center">
                            <i data-lucide="package" class="w-4 h-4 text-primary"></i>
                        </div>
                        <div>
                            <p class="font-medium text-text-primary text-sm">{{ $asset->name }}</p>
                            <p class="text-xs text-text-secondary">{{ $asset->location }}</p>
                        </div>
                    </div>
                </x-table.td>
                <x-table.td class="text-sm text-slate-600">{{ $asset->category?->name ?? '-' }}</x-table.td>
                <x-table.td class="text-sm text-slate-600">{{ number_format($asset->acquisition_cost, 0, ',', '.') }}</x-table.td>
                <x-table.td class="text-sm text-slate-600">{{ $asset->useful_life }}</x-table.td>
                <x-table.td class="text-sm text-slate-600">{{ $asset->depreciationMethod?->name ?? '-' }}</x-table.td>
                <x-table.td>
                    @php
                        $statusColor = [
                            'active' => 'bg-primary-light text-primary',
                            'disposed' => 'bg-danger-light text-danger',
                            'written_off' => 'bg-slate-100 text-slate-600',
                            'maintenance' => 'bg-warning-light text-warning',
                        ][$asset->status] ?? 'bg-slate-100 text-slate-600';
                    @endphp
                    <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full {{ $statusColor }}">
                        {{ ucwords(str_replace('_', ' ', $asset->status)) }}
                    </span>
                </x-table.td>
                <x-table.td align="right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('assets.show', $asset->id) }}" class="p-1.5 hover:bg-info-light rounded-lg text-text-secondary hover:text-info">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('assets.edit', $asset->id) }}" class="p-1.5 hover:bg-warning-light rounded-lg text-text-secondary hover:text-warning">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 hover:bg-danger-light rounded-lg text-text-secondary hover:text-danger">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </x-table.td>
            </tr>
        @endforeach
    </x-table>

    <script>lucide.createIcons();</script>
@endsection
