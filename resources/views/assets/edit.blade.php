@extends('layouts.app')

@section('title', 'Edit Aset')
@section('page-title', 'Aset')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Home</a>
    <span>/</span>
    <a href="{{ route('assets.index') }}" class="hover:text-primary">Aset</a>
    <span>/</span>
    <span class="text-slate-700">Edit</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-text-primary">Edit Aset</h2>
        <p class="text-text-secondary text-sm">Perbarui data aset tetap.</p>
    </div>

    <div class="bg-surface rounded-2xl shadow-soft border border-slate-100">
        <form action="{{ route('assets.update', $asset->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-4">
                        <div>
                            <x-forms.label for="asset_number" required>Nomor Aset</x-forms.label>
                            <x-forms.input name="asset_number" :value="$asset->asset_number" required />
                        </div>
                        <div>
                            <x-forms.label for="name" required>Nama Aset</x-forms.label>
                            <x-forms.input name="name" :value="$asset->name" required />
                        </div>
                        <div>
                            <x-forms.label for="category_id">Kategori</x-forms.label>
                            <x-forms.select name="category_id">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $asset->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </x-forms.select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-forms.label for="serial_number">Nomor Seri</x-forms.label>
                                <x-forms.input name="serial_number" :value="$asset->serial_number" />
                            </div>
                            <div>
                                <x-forms.label for="location">Lokasi</x-forms.label>
                                <x-forms.input name="location" :value="$asset->location" />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-forms.label for="responsible_person">Penanggung Jawab</x-forms.label>
                                <x-forms.input name="responsible_person" :value="$asset->responsible_person" />
                            </div>
                            <div>
                                <x-forms.label for="supplier">Supplier</x-forms.label>
                                <x-forms.input name="supplier" :value="$asset->supplier" />
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-forms.label for="acquisition_date" required>Tanggal Perolehan</x-forms.label>
                                <x-forms.input type="date" name="acquisition_date" :value="$asset->acquisition_date?->format('Y-m-d')" required />
                            </div>
                            <div>
                                <x-forms.label for="acquisition_cost" required>Harga Perolehan</x-forms.label>
                                <x-forms.input type="number" step="0.01" name="acquisition_cost" :value="$asset->acquisition_cost" required />
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-forms.label for="residual_value" required>Nilai Residu</x-forms.label>
                                <x-forms.input type="number" step="0.01" name="residual_value" :value="$asset->residual_value" required />
                            </div>
                            <div>
                                <x-forms.label for="useful_life" required>Umur Manfaat (tahun)</x-forms.label>
                                <x-forms.input type="number" name="useful_life" :value="$asset->useful_life" required />
                            </div>
                        </div>
                        <div>
                            <x-forms.label for="depreciation_method_id" required>Metode Penyusutan</x-forms.label>
                            <x-forms.select name="depreciation_method_id">
                                @foreach ($depreciationMethods as $method)
                                    <option value="{{ $method->id }}" {{ old('depreciation_method_id', $asset->depreciation_method_id) == $method->id ? 'selected' : '' }}>{{ $method->name }}</option>
                                @endforeach
                            </x-forms.select>
                        </div>
                        <div>
                            <x-forms.label for="production_capacity">Kapasitas Produksi</x-forms.label>
                            <x-forms.input type="number" name="production_capacity" :value="$asset->production_capacity" />
                        </div>
                        <div>
                            <x-forms.label for="status">Status</x-forms.label>
                            <x-forms.select name="status">
                                <option value="active" {{ old('status', $asset->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="maintenance" {{ old('status', $asset->status) === 'maintenance' ? 'selected' : '' }}>Perawatan</option>
                                <option value="disposed" {{ old('status', $asset->status) === 'disposed' ? 'selected' : '' }}>Dilepas</option>
                                <option value="written_off" {{ old('status', $asset->status) === 'written_off' ? 'selected' : '' }}>Dihapus</option>
                            </x-forms.select>
                        </div>
                        <div>
                            <x-forms.label for="notes">Catatan</x-forms.label>
                            <x-forms.textarea name="notes" rows="3" :value="$asset->notes" />
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
                    Perbarui Data
                </button>
            </div>
        </form>
    </div>

    <script>lucide.createIcons();</script>
@endsection