@extends('layouts.app')

@section('title', 'Tambah Aset')
@section('page-title', 'Aset')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Home</a>
    <span>/</span>
    <a href="{{ route('assets.index') }}" class="hover:text-primary">Aset</a>
    <span>/</span>
    <span class="text-slate-700">Tambah</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-text-primary">Tambah Aset Baru</h2>
        <p class="text-text-secondary text-sm">Lengkapi data aset tetap yang diperoleh.</p>
    </div>

    <div class="bg-surface rounded-2xl shadow-soft border border-slate-100">
        <form action="{{ route('assets.store') }}" method="POST">
            @csrf
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-4">
                        <div>
                            <x-forms.label for="asset_number" required>Nomor Aset</x-forms.label>
                            <x-forms.input name="asset_number" placeholder="cth. AST-00001" required />
                        </div>
                        <div>
                            <x-forms.label for="name" required>Nama Aset</x-forms.label>
                            <x-forms.input name="name" placeholder="cth. Toyota Avanza" required />
                        </div>
                        <div>
                            <x-forms.label for="category_id">Kategori</x-forms.label>
                            <x-forms.select name="category_id">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </x-forms.select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-forms.label for="serial_number">Nomor Seri</x-forms.label>
                                <x-forms.input name="serial_number" placeholder="SN-0000" />
                            </div>
                            <div>
                                <x-forms.label for="location">Lokasi</x-forms.label>
                                <x-forms.input name="location" placeholder="Kantor Pusat" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-forms.label for="responsible_person">Penanggung Jawab</x-forms.label>
                                <x-forms.input name="responsible_person" placeholder="Budi Santoso" />
                            </div>
                            <div>
                                <x-forms.label for="supplier">Supplier</x-forms.label>
                                <x-forms.input name="supplier" placeholder="PT. Sumber Makmur" />
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-forms.label for="acquisition_date" required>Tanggal Perolehan</x-forms.label>
                                <x-forms.input type="date" name="acquisition_date" :value="now()->format('Y-m-d')" required />
                            </div>
                            <div>
                                <x-forms.label for="acquisition_cost" required>Harga Perolehan</x-forms.label>
                                <x-forms.input type="number" step="0.01" name="acquisition_cost" placeholder="250000000" required />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-forms.label for="residual_value" required>Nilai Residu</x-forms.label>
                                <x-forms.input type="number" step="0.01" name="residual_value" :value="0" required />
                            </div>
                            <div>
                                <x-forms.label for="useful_life" required>Umur Manfaat (tahun)</x-forms.label>
                                <x-forms.input type="number" name="useful_life" placeholder="8" required />
                            </div>
                        </div>
                        <div>
                            <x-forms.label for="depreciation_method_id" required>Metode Penyusutan</x-forms.label>
                            <x-forms.select name="depreciation_method_id">
                                @foreach ($depreciationMethods as $method)
                                    <option value="{{ $method->id }}" {{ old('depreciation_method_id') == $method->id ? 'selected' : '' }}>{{ $method->name }}</option>
                                @endforeach
                            </x-forms.select>
                        </div>
                        <div>
                            <x-forms.label for="production_capacity">Kapasitas Produksi (untuk metode unit produksi)</x-forms.label>
                            <x-forms.input type="number" name="production_capacity" placeholder="cth. 100000 unit" />
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-forms.label for="status">Status</x-forms.label>
                                <x-forms.select name="status">
                                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Perawatan</option>
                                    <option value="disposed" {{ old('status') === 'disposed' ? 'selected' : '' }}>Dilepas</option>
                                    <option value="written_off" {{ old('status') === 'written_off' ? 'selected' : '' }}>Dihapus</option>
                                </x-forms.select>
                            </div>
                        </div>
                        <div>
                            <x-forms.label for="notes">Catatan</x-forms.label>
                            <x-forms.textarea name="notes" rows="3" placeholder="Catatan tambahan..." />
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 p-5 border-t border-slate-100 bg-slate-50 rounded-b-2xl">
                <a href="{{ route('assets.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-white transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-primary rounded-xl hover:bg-primary-dark transition-colors shadow-sm flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Data
                </button>
            </div>
        </form>
    </div>

    <script>lucide.createIcons();</script>
@endsection