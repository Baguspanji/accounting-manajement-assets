@extends('layouts.app')

@section('title', 'Edit Kategori Aset')
@section('page-title', 'Kategori Aset')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Home</a>
    <span>/</span>
    <a href="{{ route('asset-categories.index') }}" class="hover:text-primary">Kategori Aset</a>
    <span>/</span>
    <span class="text-slate-700">Edit</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-text-primary">Edit Kategori Aset</h2>
        <p class="text-text-secondary text-sm">Perbarui data kategori aset.</p>
    </div>

    <div class="bg-surface rounded-2xl shadow-soft border border-slate-100">
        <form action="{{ route('asset-categories.update', $assetCategory->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 max-w-5xl space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-forms.label for="code" required>Kode Kategori</x-forms.label>
                        <x-forms.input name="code" :value="$assetCategory->code" required />
                    </div>
                    <div>
                        <x-forms.label for="name" required>Nama Kategori</x-forms.label>
                        <x-forms.input name="name" :value="$assetCategory->name" required />
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-forms.label for="asset_account_id">Akun Aset</x-forms.label>
                        <x-forms.select name="asset_account_id">
                            <option value="">Pilih Akun</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" {{ old('asset_account_id', $assetCategory->asset_account_id) == $account->id ? 'selected' : '' }}>{{ $account->code }} - {{ $account->name }}</option>
                            @endforeach
                        </x-forms.select>
                    </div>
                    <div>
                        <x-forms.label for="depreciation_expense_account_id">Akun Beban Penyusutan</x-forms.label>
                        <x-forms.select name="depreciation_expense_account_id">
                            <option value="">Pilih Akun</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" {{ old('depreciation_expense_account_id', $assetCategory->depreciation_expense_account_id) == $account->id ? 'selected' : '' }}>{{ $account->code }} - {{ $account->name }}</option>
                            @endforeach
                        </x-forms.select>
                    </div>
                    <div>
                        <x-forms.label for="accumulated_depreciation_account_id">Akun Akumulasi Penyusutan</x-forms.label>
                        <x-forms.select name="accumulated_depreciation_account_id">
                            <option value="">Pilih Akun</option>
                            @foreach ($accounts as $account)
                                <option value="{{ $account->id }}" {{ old('accumulated_depreciation_account_id', $assetCategory->accumulated_depreciation_account_id) == $account->id ? 'selected' : '' }}>{{ $account->code }} - {{ $account->name }}</option>
                            @endforeach
                        </x-forms.select>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-forms.label for="default_useful_life">Umur Manfaat Default (tahun)</x-forms.label>
                        <x-forms.input type="number" name="default_useful_life" :value="$assetCategory->default_useful_life" />
                    </div>
                    <div>
                        <x-forms.label for="default_residual_value">Nilai Residu Default</x-forms.label>
                        <x-forms.input type="number" step="0.01" name="default_residual_value" :value="$assetCategory->default_residual_value" />
                    </div>
                </div>
                <div>
                    <x-forms.checkbox name="is_active" value="1" :checked="old('is_active', $assetCategory->is_active)">Aktif</x-forms.checkbox>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 p-5 border-t border-slate-100 bg-slate-50 rounded-b-2xl">
                <a href="{{ route('asset-categories.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-white transition-colors">
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
