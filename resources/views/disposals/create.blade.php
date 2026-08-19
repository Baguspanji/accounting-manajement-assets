@extends('layouts.app')

@section('title', 'Catat Pelepasan Aset')
@section('page-title', 'Transaksi')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Transaksi</a>
    <span>/</span>
    <a href="{{ route('disposals.index') }}" class="hover:text-primary">Pelepasan Aset</a>
    <span>/</span>
    <span class="text-slate-700">Catat</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-text-primary">Catat Pelepasan Aset</h2>
        <p class="text-text-secondary text-sm">Pilih aset aktif yang akan dilepas, sistem menghitung nilai buku dan laba/rugi otomatis.</p>
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
        <form action="{{ route('disposals.store') }}" method="POST">
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
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <x-forms.label for="disposal_date" required>Tanggal Pelepasan</x-forms.label>
                        <x-forms.input type="date" name="disposal_date" :value="old('disposal_date', now()->format('Y-m-d'))" required />
                    </div>
                    <div>
                        <x-forms.label for="disposal_type" required>Jenis Pelepasan</x-forms.label>
                        <x-forms.select name="disposal_type" id="disposal_type">
                            <option value="sale" {{ old('disposal_type', 'sale') === 'sale' ? 'selected' : '' }}>Penjualan</option>
                            <option value="write_off" {{ old('disposal_type') === 'write_off' ? 'selected' : '' }}>Penghapusan (Rugi)</option>
                            <option value="transfer" {{ old('disposal_type') === 'transfer' ? 'selected' : '' }}>Transfer (Tanpa Jurnal)</option>
                        </x-forms.select>
                    </div>
                </div>
                <div id="sale-price-field">
                    <x-forms.label for="sale_price">Harga Jual</x-forms.label>
                    <x-forms.input type="number" step="0.01" name="sale_price" :value="old('sale_price', 0)" />
                </div>
                <div>
                    <x-forms.label for="notes">Catatan</x-forms.label>
                    <x-forms.textarea name="notes" rows="3" placeholder="Alasan pelepasan, pembeli, dll." />
                </div>

                <div class="bg-primary-light/50 border border-primary/20 rounded-xl p-4">
                    <p class="text-sm font-medium text-text-primary mb-2">Perhitungan Otomatis</p>
                    <ul class="space-y-1 text-sm text-text-secondary">
                        <li>- Nilai buku = Harga perolehan - Akumulasi penyusutan</li>
                        <li>- Laba/rugi = Harga jual - Nilai buku (penjualan)</li>
                        <li>- Penjualan: Debit Akumulasi & Kas / Kredit Aset (+/- Laba/Rugi)</li>
                        <li>- Penghapusan: Debit Akumulasi & Rugi / Kredit Aset</li>
                    </ul>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 p-5 border-t border-slate-100 bg-slate-50 rounded-b-2xl">
                <a href="{{ route('disposals.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-white transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-primary rounded-xl hover:bg-primary-dark transition-colors shadow-sm flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan & Buat Jurnal
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('disposal_type')?.addEventListener('change', function () {
            document.getElementById('sale-price-field').style.display = this.value === 'sale' ? '' : 'none';
        });
        lucide.createIcons();
    </script>
@endsection