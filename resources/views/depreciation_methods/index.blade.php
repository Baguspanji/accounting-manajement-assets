@extends('layouts.app')

@section('title', 'Metode Penyusutan')
@section('page-title', 'Metode Penyusutan')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Master</a>
    <span>/</span>
    <span class="text-slate-700">Metode Penyusutan</span>
@endsection

@section('content')
    <div class="flex flex-col md:flex-row justify-between md:items-center mb-6 gap-4">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Daftar Metode Penyusutan</h2>
            <p class="text-slate-500 text-sm">Kelola metode penyusutan aset (garis lurus, saldo menurun, dll).</p>
        </div>
        <a href="{{ route('depreciation-methods.create') }}" class="bg-primary text-white px-4 py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2 hover:bg-primary-dark transition-colors shadow-sm">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Tambah Metode
        </a>
    </div>

    @if ($message = Session::get('success'))
        <div class="mb-6 p-4 bg-primary-light border border-primary rounded-xl flex items-start gap-3">
            <i data-lucide="check-circle" class="w-5 h-5 text-primary flex-shrink-0 mt-0.5"></i>
            <p class="font-medium text-slate-800">{{ $message }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-slate-100 sticky top-0">
                    <tr>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Kode</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama Metode</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Formula</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="py-3 px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($methods as $method)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-3 px-4 text-sm font-medium text-slate-700 font-mono">{{ $method->code }}</td>
                            <td class="py-3 px-4 text-sm font-medium text-slate-800">{{ $method->name }}</td>
                            <td class="py-3 px-4 text-sm text-slate-600">{{ $method->formula ?? '-' }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full {{ $method->is_active ? 'bg-primary-light text-primary' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $method->is_active ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('depreciation-methods.show', $method->id) }}" class="p-1.5 hover:bg-info-light rounded-lg text-slate-500 hover:text-info">
                                        <i data-lucide="eye" class="w-4 h-4"></i>
                                    </a>
                                    <a href="{{ route('depreciation-methods.edit', $method->id) }}" class="p-1.5 hover:bg-warning-light rounded-lg text-slate-500 hover:text-warning">
                                        <i data-lucide="edit" class="w-4 h-4"></i>
                                    </a>
                                    <form action="{{ route('depreciation-methods.destroy', $method->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 hover:bg-danger-light rounded-lg text-slate-500 hover:text-danger">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 px-4 text-center text-slate-500">Belum ada data metode penyusutan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($methods->count() > 0)
            <div>{{ $methods->links() }}</div>
        @endif
    </div>

    <script>lucide.createIcons();</script>
@endsection