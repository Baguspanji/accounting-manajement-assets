@extends('layouts.app')

@section('title', 'Detail Perolehan Aset')
@section('page-title', 'Transaksi')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Transaksi</a>
    <span>/</span>
    <a href="{{ route('acquisitions.index') }}" class="hover:text-primary">Perolehan Aset</a>
    <span>/</span>
    <span class="text-slate-700">Detail</span>
@endsection

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Detail Perolehan Aset</h2>
            <p class="text-text-secondary text-sm">Referensi {{ $acquisition->reference }}.</p>
        </div>
        <a href="{{ route('acquisitions.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 text-sm font-medium">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6">
            <h3 class="font-bold text-text-primary mb-4">Informasi Aset</h3>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center">
                    <i data-lucide="package" class="w-6 h-6 text-primary"></i>
                </div>
                <div>
                    <p class="font-bold text-text-primary">{{ $acquisition->journalable?->name }}</p>
                    <p class="text-sm text-text-secondary">{{ $acquisition->journalable?->asset_number }}</p>
                </div>
            </div>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-text-secondary">Harga Perolehan</dt><dd class="font-medium">Rp {{ number_format($acquisition->journalable?->acquisition_cost ?? 0, 0, ',', '.') }}</dd></div>
                <div class="flex justify-between"><dt class="text-text-secondary">Kategori</dt><dd class="font-medium">{{ $acquisition->journalable?->category?->name ?? '-' }}</dd></div>
                <div class="flex justify-between"><dt class="text-text-secondary">Tanggal</dt><dd class="font-medium">{{ $acquisition->transaction_date->format('d M Y') }}</dd></div>
            </dl>
            <a href="{{ route('assets.show', $acquisition->journalable_id) }}" class="mt-4 flex items-center justify-center gap-2 w-full border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 text-sm font-medium py-2.5">
                <i data-lucide="eye" class="w-4 h-4"></i> Lihat Kartu Aset
            </a>
        </div>

        <div class="lg:col-span-2">
            @include('journals._detail', ['journal' => $acquisition])
        </div>
    </div>

    <script>lucide.createIcons();</script>
@endsection