@extends('layouts.app')

@section('title', 'Detail Pelepasan Aset')
@section('page-title', 'Transaksi')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Transaksi</a>
    <span>/</span>
    <a href="{{ route('disposals.index') }}" class="hover:text-primary">Pelepasan Aset</a>
    <span>/</span>
    <span class="text-slate-700">Detail</span>
@endsection

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
        <div>
            <h2 class="text-xl font-bold text-text-primary">Detail Pelepasan Aset</h2>
            <p class="text-text-secondary text-sm">{{ $disposal->disposal_date->format('d M Y') }}.</p>
        </div>
        <a href="{{ route('disposals.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 text-sm font-medium">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6">
                <h3 class="font-bold text-text-primary mb-4">Informasi Aset</h3>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-primary-light rounded-xl flex items-center justify-center">
                        <i data-lucide="package" class="w-6 h-6 text-primary"></i>
                    </div>
                    <div>
                        <p class="font-bold text-text-primary">{{ $disposal->asset?->name }}</p>
                        <p class="text-sm text-text-secondary">{{ $disposal->asset?->asset_number }}</p>
                    </div>
                </div>
                <dl class="space-y-2 text-sm">
                    <div class="flex justify-between"><dt class="text-text-secondary">Jenis Pelepasan</dt><dd class="font-medium">{{ ucfirst($disposal->disposal_type) }}</dd></div>
                    <div class="flex justify-between"><dt class="text-text-secondary">Harga Perolehan</dt><dd class="font-medium">Rp {{ number_format($disposal->asset?->acquisition_cost ?? 0, 0, ',', '.') }}</dd></div>
                    <div class="flex justify-between"><dt class="text-text-secondary">Akumulasi Penyusutan</dt><dd class="font-medium">Rp {{ number_format($disposal->accumulated_depreciation, 0, ',', '.') }}</dd></div>
                    <div class="flex justify-between border-t border-slate-100 pt-2"><dt class="text-text-secondary">Nilai Buku</dt><dd class="font-bold">Rp {{ number_format($disposal->book_value, 0, ',', '.') }}</dd></div>
                    @if ($disposal->disposal_type === 'sale')
                        <div class="flex justify-between"><dt class="text-text-secondary">Harga Jual</dt><dd class="font-medium">Rp {{ number_format($disposal->sale_price, 0, ',', '.') }}</dd></div>
                    @endif
                    <div class="flex justify-between border-t border-slate-100 pt-2">
                        <dt class="text-text-secondary">Laba / Rugi</dt>
                        <dd class="font-bold {{ $disposal->gain_loss > 0 ? 'text-primary' : ($disposal->gain_loss < 0 ? 'text-danger' : '') }}">
                            {{ $disposal->gain_loss > 0 ? '+' : '' }}{{ number_format($disposal->gain_loss, 0, ',', '.') }}
                        </dd>
                    </div>
                    @if ($disposal->notes)
                        <div class="flex flex-col gap-1"><dt class="text-text-secondary">Catatan</dt><dd class="font-medium text-slate-600">{{ $disposal->notes }}</dd></div>
                    @endif
                </dl>
                <a href="{{ route('assets.show', $disposal->asset_id) }}" class="mt-4 flex items-center justify-center gap-2 w-full border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 text-sm font-medium py-2.5">
                    <i data-lucide="eye" class="w-4 h-4"></i> Lihat Kartu Aset
                </a>
            </div>
        </div>

        <div class="lg:col-span-2">
            @if ($disposal->journals->isNotEmpty())
                @foreach ($disposal->journals as $journal)
                    @include('journals._detail', ['journal' => $journal->load('details.account')])
                @endforeach
            @else
                <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-8 text-center text-text-secondary">
                    Transfer aset tidak menghasilkan jurnal.
                </div>
            @endif
        </div>
    </div>

    <script>lucide.createIcons();</script>
@endsection