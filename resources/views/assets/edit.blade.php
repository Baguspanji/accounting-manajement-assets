@extends('layouts.app')

@section('title', 'Edit Aset')
@section('page-title', 'Aset')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Master</a>
    <span>/</span>
    <a href="{{ route('assets.index') }}" class="hover:text-primary">Aset</a>
    <span>/</span>
    <span class="text-slate-700">Edit</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">Edit Aset</h2>
        <p class="text-slate-500 text-sm">Perbarui data aset tetap.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft border border-slate-100">
        <form action="{{ route('assets.update', $asset->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Aset <span class="text-danger">*</span></label>
                            <input type="text" name="asset_number" value="{{ old('asset_number', $asset->asset_number) }}" required
                                class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('asset_number') ? 'border-danger' : 'border-slate-200' }}">
                            @error('asset_number')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Aset <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $asset->name) }}" required
                                class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('name') ? 'border-danger' : 'border-slate-200' }}">
                            @error('name')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori</label>
                            <select name="category_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $asset->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Seri</label>
                                <input type="text" name="serial_number" value="{{ old('serial_number', $asset->serial_number) }}"
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi</label>
                                <input type="text" name="location" value="{{ old('location', $asset->location) }}"
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Penanggung Jawab</label>
                                <input type="text" name="responsible_person" value="{{ old('responsible_person', $asset->responsible_person) }}"
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Supplier</label>
                                <input type="text" name="supplier" value="{{ old('supplier', $asset->supplier) }}"
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Perolehan <span class="text-danger">*</span></label>
                                <input type="date" name="acquisition_date" value="{{ old('acquisition_date', $asset->acquisition_date->format('Y-m-d')) }}" required
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Harga Perolehan <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="acquisition_cost" value="{{ old('acquisition_cost', $asset->acquisition_cost) }}" required
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nilai Residu <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="residual_value" value="{{ old('residual_value', $asset->residual_value) }}" required
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Umur Manfaat (tahun) <span class="text-danger">*</span></label>
                                <input type="number" name="useful_life" value="{{ old('useful_life', $asset->useful_life) }}" required
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Metode Penyusutan <span class="text-danger">*</span></label>
                            <select name="depreciation_method_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                @foreach ($depreciationMethods as $method)
                                    <option value="{{ $method->id }}" {{ old('depreciation_method_id', $asset->depreciation_method_id) == $method->id ? 'selected' : '' }}>{{ $method->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kapasitas Produksi</label>
                            <input type="number" name="production_capacity" value="{{ old('production_capacity', $asset->production_capacity) }}"
                                class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Status</label>
                            <select name="status" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                <option value="active" {{ old('status', $asset->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="maintenance" {{ old('status', $asset->status) === 'maintenance' ? 'selected' : '' }}>Perawatan</option>
                                <option value="disposed" {{ old('status', $asset->status) === 'disposed' ? 'selected' : '' }}>Dilepas</option>
                                <option value="written_off" {{ old('status', $asset->status) === 'written_off' ? 'selected' : '' }}>Dihapus</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Catatan</label>
                            <textarea name="notes" rows="3"
                                class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary resize-none">{{ old('notes', $asset->notes) }}</textarea>
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