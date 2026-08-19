@extends('layouts.app')

@section('title', 'Detail Aset')
@section('page-title', 'Aset')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Master</a>
    <span>/</span>
    <a href="{{ route('assets.index') }}" class="hover:text-primary">Aset</a>
    <span>/</span>
    <span class="text-slate-700">Detail</span>
@endsection

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Detail Aset</h2>
            <p class="text-text-secondary text-sm">Informasi lengkap kartu aset.</p>
        </div>
        <a href="{{ route('assets.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 text-sm font-medium">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="col-span-1">
            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6 flex flex-col items-center text-center">
                <div class="w-24 h-24 bg-primary-light rounded-2xl flex items-center justify-center mb-4">
                    <i data-lucide="package" class="w-12 h-12 text-primary"></i>
                </div>
                <h3 class="text-lg font-bold text-text-primary">{{ $asset->name }}</h3>
                <p class="text-sm text-text-secondary mb-4">{{ $asset->asset_number }}</p>
                @php
                    $statusColor = [
                        'active' => 'bg-primary-light text-primary',
                        'disposed' => 'bg-danger-light text-danger',
                        'written_off' => 'bg-slate-100 text-slate-600',
                        'maintenance' => 'bg-warning-light text-warning',
                    ][$asset->status] ?? 'bg-slate-100 text-slate-600';
                @endphp
                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                    {{ ucwords(str_replace('_', ' ', $asset->status)) }}
                </span>
            </div>
            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5 mt-6">
                <h3 class="font-bold text-text-primary text-sm mb-3">Nilai</h3>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between"><dt class="text-text-secondary">Harga Perolehan</dt><dd class="font-medium">Rp {{ number_format($asset->acquisition_cost, 0, ',', '.') }}</dd></div>
                    <div class="flex justify-between"><dt class="text-text-secondary">Nilai Residu</dt><dd class="font-medium">Rp {{ number_format($asset->residual_value, 0, ',', '.') }}</dd></div>
                    <div class="flex justify-between"><dt class="text-text-secondary">Jumlah Disusutkan</dt><dd class="font-medium">Rp {{ number_format($asset->depreciableAmount(), 0, ',', '.') }}</dd></div>
                    <div class="flex justify-between"><dt class="text-text-secondary">Penyusutan / Tahun</dt><dd class="font-medium">Rp {{ number_format($asset->annualDepreciation(), 0, ',', '.') }}</dd></div>
                </dl>
            </div>
        </div>
        <div class="col-span-1 md:col-span-2">
            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden">
                <div class="p-5 border-b border-slate-100">
                    <h3 class="font-bold text-text-primary">Informasi Aset</h3>
                </div>
                <div class="p-0">
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50">
                                <x-table.label>Kategori</x-table.label>
                                <x-table.td relaxed class="text-text-primary">{{ $asset->category?->name ?? '-' }}</x-table.td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <x-table.label>Tanggal Perolehan</x-table.label>
                                <x-table.td relaxed class="text-text-primary">{{ $asset->acquisition_date->format('d M Y') }}</x-table.td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <x-table.label>Umur Manfaat</x-table.label>
                                <x-table.td relaxed class="text-text-primary">{{ $asset->useful_life }} tahun</x-table.td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <x-table.label>Metode Penyusutan</x-table.label>
                                <x-table.td relaxed class="text-text-primary">{{ $asset->depreciationMethod?->name ?? '-' }}</x-table.td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <x-table.label>Nomor Seri</x-table.label>
                                <x-table.td relaxed class="text-text-primary">{{ $asset->serial_number ?? '-' }}</x-table.td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <x-table.label>Lokasi</x-table.label>
                                <x-table.td relaxed class="text-text-primary">{{ $asset->location ?? '-' }}</x-table.td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <x-table.label>Penanggung Jawab</x-table.label>
                                <x-table.td relaxed class="text-text-primary">{{ $asset->responsible_person ?? '-' }}</x-table.td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <x-table.label>Supplier</x-table.label>
                                <x-table.td relaxed class="text-text-primary">{{ $asset->supplier ?? '-' }}</x-table.td>
                            </tr>
                            @if ($asset->notes)
                            <tr class="hover:bg-slate-50">
                                <x-table.label>Catatan</x-table.label>
                                <x-table.td relaxed class="text-text-primary">{{ $asset->notes }}</x-table.td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 flex gap-3">
                <a href="{{ route('assets.edit', $asset->id) }}" class="flex-1 bg-warning text-white py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2 hover:bg-warning/90 transition-colors">
                    <i data-lucide="edit" class="w-4 h-4"></i> Edit Data
                </a>
            </div>
        </div>
    </div>

    <script>lucide.createIcons();</script>
@endsection