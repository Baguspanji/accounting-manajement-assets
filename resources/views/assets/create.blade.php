@extends('layouts.app')

@section('title', 'Tambah Aset')
@section('page-title', 'Aset')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Master</a>
    <span>/</span>
    <a href="{{ route('assets.index') }}" class="hover:text-primary">Aset</a>
    <span>/</span>
    <span class="text-slate-700">Tambah</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">Tambah Aset Baru</h2>
        <p class="text-slate-500 text-sm">Lengkapi data aset tetap yang diperoleh.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft border border-slate-100">
        <form action="{{ route('assets.store') }}" method="POST">
            @csrf
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Aset <span class="text-danger">*</span></label>
                            <input type="text" name="asset_number" value="{{ old('asset_number') }}" placeholder="cth. AST-00001" required
                                class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('asset_number') ? 'border-danger' : 'border-slate-200' }}">
                            @error('asset_number')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Aset <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="cth. Toyota Avanza" required
                                class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('name') ? 'border-danger' : 'border-slate-200' }}">
                            @error('name')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kategori</label>
                            <select name="category_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                <option value="">Pilih Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Seri</label>
                                <input type="text" name="serial_number" value="{{ old('serial_number') }}" placeholder="SN-0000"
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Lokasi</label>
                                <input type="text" name="location" value="{{ old('location') }}" placeholder="Kantor Pusat"
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Penanggung Jawab</label>
                                <input type="text" name="responsible_person" value="{{ old('responsible_person') }}" placeholder="Budi Santoso"
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Supplier</label>
                                <input type="text" name="supplier" value="{{ old('supplier') }}" placeholder="PT. Sumber Makmur"
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Perolehan <span class="text-danger">*</span></label>
                                <input type="date" name="acquisition_date" value="{{ old('acquisition_date', now()->format('Y-m-d')) }}" required
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                @error('acquisition_date')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Harga Perolehan <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="acquisition_cost" value="{{ old('acquisition_cost') }}" placeholder="250000000" required
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                @error('acquisition_cost')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Nilai Residu <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" name="residual_value" value="{{ old('residual_value', 0) }}" required
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                @error('residual_value')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Umur Manfaat (tahun) <span class="text-danger">*</span></label>
                                <input type="number" name="useful_life" value="{{ old('useful_life') }}" placeholder="8" required
                                    class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                                @error('useful_life')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Metode Penyusutan <span class="text-danger">*</span></label>
                            <select name="depreciation_method_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                @foreach ($depreciationMethods as $method)
                                    <option value="{{ $method->id }}" {{ old('depreciation_method_id') == $method->id ? 'selected' : '' }}>{{ $method->name }}</option>
                                @endforeach
                            </select>
                            @error('depreciation_method_id')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Kapasitas Produksi (untuk metode unit produksi)</label>
                            <input type="number" name="production_capacity" value="{{ old('production_capacity') }}" placeholder="cth. 100000 unit"
                                class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                            @error('production_capacity')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Status</label>
                                <select name="status" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Perawatan</option>
                                    <option value="disposed" {{ old('status') === 'disposed' ? 'selected' : '' }}>Dilepas</option>
                                    <option value="written_off" {{ old('status') === 'written_off' ? 'selected' : '' }}>Dihapus</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Catatan</label>
                            <textarea name="notes" rows="3" placeholder="Catatan tambahan..."
                                class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary resize-none">{{ old('notes') }}</textarea>
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