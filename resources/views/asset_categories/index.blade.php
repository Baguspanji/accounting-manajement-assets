@extends('layouts.app')

@section('title', 'Kategori Aset')
@section('page-title', 'Kategori Aset')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Master</a>
    <span>/</span>
    <span class="text-slate-700">Kategori Aset</span>
@endsection

@section('content')
    <div class="flex flex-col md:flex-row justify-between md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Daftar Kategori Aset</h2>
            <p class="text-text-secondary text-sm">Kelola kategori aset tetap (Tanah, Bangunan, Kendaraan, dll).</p>
        </div>
        <a href="{{ route('asset-categories.create') }}" class="bg-primary text-white px-4 py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2 hover:bg-primary-dark transition-colors shadow-sm">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Tambah Kategori
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div class="mb-6 p-4 bg-primary-light border border-primary rounded-xl flex items-start gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-primary shrink-0 mt-0.5"></i>
            <p class="font-medium text-text-primary">{{ $message }}</p>
        </div>
    @endif

    <x-table :items="$categories" empty="Belum ada data kategori aset.">
        <x-slot:head>
            <x-table.th>Kode</x-table.th>
            <x-table.th>Nama Kategori</x-table.th>
            <x-table.th>Akun Aset</x-table.th>
            <x-table.th>Umur (th)</x-table.th>
            <x-table.th>Status</x-table.th>
            <x-table.th align="right">Aksi</x-table.th>
        </x-slot>

        @foreach ($categories as $category)
            <tr class="hover:bg-slate-50 transition-colors">
                <x-table.td class="text-sm font-medium text-slate-700 font-mono">{{ $category->code }}</x-table.td>
                <x-table.td class="text-sm font-medium text-text-primary">{{ $category->name }}</x-table.td>
                <x-table.td class="text-sm text-slate-600">{{ $category->assetAccount?->name ?? '-' }}</x-table.td>
                <x-table.td class="text-sm text-slate-600">{{ $category->default_useful_life ?? '-' }}</x-table.td>
                <x-table.td>
                    <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full {{ $category->is_active ? 'bg-primary-light text-primary' : 'bg-slate-100 text-slate-600' }}">
                        {{ $category->is_active ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </x-table.td>
                <x-table.td align="right">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('asset-categories.show', $category->id) }}" class="p-1.5 hover:bg-info-light rounded-lg text-text-secondary hover:text-info">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('asset-categories.edit', $category->id) }}" class="p-1.5 hover:bg-warning-light rounded-lg text-text-secondary hover:text-warning">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('asset-categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
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
