@extends('layouts.app')

@section('title', 'Detail Metode Penyusutan')
@section('page-title', 'Metode Penyusutan')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Master</a>
    <span>/</span>
    <a href="{{ route('depreciation-methods.index') }}" class="hover:text-primary">Metode Penyusutan</a>
    <span>/</span>
    <span class="text-slate-700">Detail</span>
@endsection

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Detail Metode Penyusutan</h2>
            <p class="text-text-secondary text-sm">Informasi lengkap metode penyusutan.</p>
        </div>
        <a href="{{ route('depreciation-methods.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 text-sm font-medium">
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden max-w-3xl">
        <div class="p-5 border-b border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center">
                <i data-lucide="calculator" class="w-6 h-6 text-primary"></i>
            </div>
            <div>
                <h3 class="text-lg font-bold text-text-primary">{{ $depreciationMethod->name }}</h3>
                <p class="text-sm text-text-secondary font-mono">{{ $depreciationMethod->code }}</p>
            </div>
        </div>
        <div class="p-0">
            <table class="w-full text-sm text-left">
                <tbody class="divide-y divide-slate-100">
                    <tr class="hover:bg-slate-50">
                        <th class="w-1/3 py-4 px-5 font-medium text-text-secondary">Formula</th>
                        <td class="py-4 px-5 text-text-primary">{{ $depreciationMethod->formula ?? '-' }}</td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <th class="py-4 px-5 font-medium text-text-secondary">Deskripsi</th>
                        <td class="py-4 px-5 text-text-primary">{{ $depreciationMethod->description ?? '-' }}</td>
                    </tr>
                    <tr class="hover:bg-slate-50">
                        <th class="py-4 px-5 font-medium text-text-secondary">Status</th>
                        <td class="py-4 px-5">
                            <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full {{ $depreciationMethod->is_active ? 'bg-primary-light text-primary' : 'bg-slate-100 text-slate-600' }}">
                                {{ $depreciationMethod->is_active ? 'Aktif' : 'Non-Aktif' }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script>lucide.createIcons();</script>
@endsection