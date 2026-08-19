@extends('layouts.app')

@section('title', 'Tambah Kategori Aset')
@section('page-title', 'Kategori Aset')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Master</a>
    <span>/</span>
    <a href="{{ route('asset-categories.index') }}" class="hover:text-primary">Kategori Aset</a>
    <span>/</span>
    <span class="text-slate-700">Tambah</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">Tambah Kategori Aset Baru</h2>
        <p class="text-slate-500 text-sm">Lengkapi data kategori aset tetap.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft border border-slate-100">
        <form action="{{ route('asset-categories.store') }}" method="POST">
            @csrf
            <div class="p-6 max-w-3xl space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Kode Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="code" value="{{ old('code') }}" placeholder="cth. KDN" required
                            class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('code') ? 'border-danger' : 'border-slate-200' }}">
                        @error('code')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="cth. Kendaraan" required
                            class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('name') ? 'border-danger' : 'border-slate-200' }}">
                        @error('name')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Akun Aset</label>
                        <select name="asset_account_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                            <option value="">Pilih Akun</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" {{ old('asset_account_id') == $account->id ? 'selected' : '' }}>{{ $account->code }} - {{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Akun Beban Penyusutan</label>
                        <select name="depreciation_expense_account_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                            <option value="">Pilih Akun</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" {{ old('depreciation_expense_account_id') == $account->id ? 'selected' : '' }}>{{ $account->code }} - {{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Akun Akumulasi Penyusutan</label>
                        <select name="accumulated_depreciation_account_id" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                            <option value="">Pilih Akun</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" {{ old('accumulated_depreciation_account_id') == $account->id ? 'selected' : '' }}>{{ $account->code }} - {{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Umur Manfaat Default (tahun)</label>
                        <input type="number" name="default_useful_life" value="{{ old('default_useful_life') }}" placeholder="cth. 8"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nilai Residu Default</label>
                        <input type="number" step="0.01" name="default_residual_value" value="{{ old('default_residual_value', 0) }}"
                            class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary">
                    </div>
                </div>
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/30">
                        <span class="text-sm text-slate-600">Aktif</span>
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 p-5 border-t border-slate-100 bg-slate-50 rounded-b-2xl">
                <a href="{{ route('asset-categories.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-white transition-colors">
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