@extends('layouts.app')

@section('title', 'Catat Perolehan Aset')
@section('page-title', 'Transaksi')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Transaksi</a>
    <span>/</span>
    <a href="{{ route('acquisitions.index') }}" class="hover:text-primary">Perolehan Aset</a>
    <span>/</span>
    <span class="text-slate-700">Catat</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-text-primary">Catat Perolehan Aset</h2>
        <p class="text-text-secondary text-sm">Jurnal: Debit Aset Tetap / Kredit Kas atau Utang Usaha.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-danger-light border border-danger rounded-xl flex items-start gap-3">
            <i data-lucide="alert-circle" class="w-5 h-5 text-danger flex-shrink-0 mt-0.5"></i>
            <div class="space-y-1">
                <p class="font-medium text-text-primary">Periksa kembali data berikut:</p>
                @foreach ($errors->all() as $error)
                    <p class="text-sm text-slate-600">- {{ $error }}</p>
                @endforeach
            </div>
        </div>
    @endif

    @if (Session::has('error'))
        <x-flash type="error">{{ Session::get('error') }}</x-flash>
    @endif

    <div class="bg-surface rounded-2xl shadow-soft border border-slate-100">
        <form action="{{ route('acquisitions.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-5">
                <div>
                    <x-forms.label for="asset_id" required>Aset</x-forms.label>
                    <x-forms.select name="asset_id">
                        <option value="">Pilih Aset</option>
                        @foreach ($assets as $asset)
                            <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                {{ $asset->name }} ({{ $asset->asset_number }}) - Rp {{ number_format($asset->acquisition_cost, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </x-forms.select>
                    @if ($assets->isEmpty())
                        <p class="text-xs text-text-secondary mt-1">Semua aset aktif sudah dicatat perolehannya.</p>
                    @endif
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <x-forms.label for="transaction_date" required>Tanggal Transaksi</x-forms.label>
                        <x-forms.input type="date" name="transaction_date" :value="old('transaction_date', now()->format('Y-m-d'))" required />
                    </div>
                    <div>
                        <x-forms.label for="source" required>Sumber Dana</x-forms.label>
                        <x-forms.select name="source">
                            <option value="kas" {{ old('source', 'kas') === 'kas' ? 'selected' : '' }}>Kas (Tunai)</option>
                            <option value="utang" {{ old('source') === 'utang' ? 'selected' : '' }}>Utang Usaha (Kredit)</option>
                        </x-forms.select>
                    </div>
                </div>

                <div class="bg-primary-light/50 border border-primary/20 rounded-xl p-4">
                    <p class="text-sm font-medium text-text-primary mb-2">Ringkasan Jurnal</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm">
                        <p class="text-text-secondary">Debit: <span class="font-medium text-text-primary">Aset Tetap sesuai kategori</span></p>
                        <p class="text-text-secondary">Kredit: <span class="font-medium text-text-primary">Kas atau Utang Usaha</span></p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 p-5 border-t border-slate-100 bg-slate-50 rounded-b-2xl">
                <a href="{{ route('acquisitions.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-white transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-primary rounded-xl hover:bg-primary-dark transition-colors shadow-sm flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan & Buat Jurnal
                </button>
            </div>
        </form>
    </div>

    <script>lucide.createIcons();</script>
@endsection