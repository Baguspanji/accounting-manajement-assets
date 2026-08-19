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
            <i data-lucide="check-circle" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"></i>
            <p class="font-medium text-text-primary">{{ $message }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100 sticky top-0">
                    <tr>
                        <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider">Kode</th>
                        <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider">Nama Kategori</th>
                        <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider">Akun Aset</th>
                        <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider">Umur (th)</th>
                        <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider">Status</th>
                        <th class="py-3 px-4 text-xs font-semibold text-text-secondary uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 text-sm font-medium text-slate-700 font-mono">{{ $category->code }}</td>
                            <td class="py-3 px-4 text-sm font-medium text-text-primary">{{ $category->name }}</td>
                            <td class="py-3 px-4 text-sm text-slate-600">{{ $category->assetAccount?->name ?? '-' }}</td>
                            <td class="py-3 px-4 text-sm text-slate-600">{{ $category->default_useful_life ?? '-' }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full {{ $category->is_active ? 'bg-primary-light text-primary' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $category->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
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
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 px-4 text-center text-text-secondary">Belum ada data kategori aset.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($categories->count() > 0)
            <div>{{ $categories->links() }}</div>
        @endif
    </div>

    <script>lucide.createIcons();</script>
@endsection