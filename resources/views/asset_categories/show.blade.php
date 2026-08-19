@extends('layouts.app')

@section('title', 'Detail Kategori Aset')
@section('page-title', 'Kategori Aset')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Master</a>
    <span>/</span>
    <a href="{{ route('asset-categories.index') }}" class="hover:text-primary">Kategori Aset</a>
    <span>/</span>
    <span class="text-slate-700">Detail</span>
@endsection

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Detail Kategori Aset</h2>
            <p class="text-text-secondary text-sm">Informasi lengkap kategori aset.</p>
        </div>
        <a href="{{ route('asset-categories.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 text-sm font-medium">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="col-span-1">
            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6 flex flex-col items-center text-center">
                <div class="w-24 h-24 bg-primary-light rounded-2xl flex items-center justify-center mb-4">
                    <i data-lucide="folder" class="w-12 h-12 text-primary"></i>
                </div>
                <h3 class="text-lg font-bold text-text-primary">{{ $assetCategory->name }}</h3>
                <p class="text-sm text-text-secondary mb-4 font-mono">{{ $assetCategory->code }}</p>
                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $assetCategory->is_active ? 'bg-primary-light text-primary' : 'bg-slate-100 text-slate-600' }}">
                    {{ $assetCategory->is_active ? 'Aktif' : 'Non-Aktif' }}
                </span>
            </div>
        </div>
        <div class="col-span-1 md:col-span-2">
            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden">
                <div class="p-5 border-b border-slate-100">
                    <h3 class="font-bold text-text-primary">Konfigurasi Akun & Default</h3>
                </div>
                <div class="p-0">
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50">
                                <th class="w-1/3 py-4 px-5 font-medium text-text-secondary">Akun Aset</th>
                                <td class="py-4 px-5 text-text-primary">{{ $assetCategory->assetAccount?->name ?? '-' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <th class="py-4 px-5 font-medium text-text-secondary">Akun Beban Penyusutan</th>
                                <td class="py-4 px-5 text-text-primary">{{ $assetCategory->depreciationExpenseAccount?->name ?? '-' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <th class="py-4 px-5 font-medium text-text-secondary">Akun Akumulasi Penyusutan</th>
                                <td class="py-4 px-5 text-text-primary">{{ $assetCategory->accumulatedDepreciationAccount?->name ?? '-' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <th class="py-4 px-5 font-medium text-text-secondary">Umur Manfaat Default</th>
                                <td class="py-4 px-5 text-text-primary">{{ $assetCategory->default_useful_life ? $assetCategory->default_useful_life.' tahun' : '-' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <th class="py-4 px-5 font-medium text-text-secondary">Nilai Residu Default</th>
                                <td class="py-4 px-5 text-text-primary">Rp {{ number_format($assetCategory->default_residual_value, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <th class="py-4 px-5 font-medium text-text-secondary">Jumlah Aset</th>
                                <td class="py-4 px-5 text-text-primary">{{ $assetCategory->assets->count() }} aset</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('asset-categories.edit', $assetCategory->id) }}" class="flex-1 bg-warning text-white py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2 hover:bg-warning/90 transition-colors">
                    <i data-lucide="edit" class="w-4 h-4"></i> Edit Data
                </a>
            </div>
        </div>
    </div>

    <script>lucide.createIcons();</script>
@endsection