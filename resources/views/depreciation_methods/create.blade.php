@extends('layouts.app')

@section('title', 'Tambah Metode Penyusutan')
@section('page-title', 'Metode Penyusutan')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Home</a>
    <span>/</span>
    <a href="{{ route('depreciation-methods.index') }}" class="hover:text-primary">Metode Penyusutan</a>
    <span>/</span>
    <span class="text-slate-700">Tambah</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-text-primary">Tambah Metode Penyusutan Baru</h2>
        <p class="text-text-secondary text-sm">Lengkapi data metode penyusutan aset.</p>
    </div>

    <div class="bg-surface rounded-2xl shadow-soft border border-slate-100">
        <form action="{{ route('depreciation-methods.store') }}" method="POST">
            @csrf
            <div class="p-6 max-w-2xl space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-forms.label for="code" required>Kode Metode</x-forms.label>
                        <x-forms.input name="code" placeholder="cth. SL" required />
                    </div>
                    <div>
                        <x-forms.label for="name" required>Nama Metode</x-forms.label>
                        <x-forms.input name="name" placeholder="cth. Garis Lurus" required />
                    </div>
                </div>
                <div>
                    <x-forms.label for="formula">Formula</x-forms.label>
                    <x-forms.textarea name="formula" rows="2" placeholder="(Harga Perolehan - Nilai Residu) / Umur Manfaat" />
                </div>
                <div>
                    <x-forms.label for="description">Deskripsi</x-forms.label>
                    <x-forms.textarea name="description" rows="3" placeholder="Deskripsi metode..." />
                </div>
                <div>
                    <x-forms.checkbox name="is_active" value="1" :checked="true">Aktif</x-forms.checkbox>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 p-5 border-t border-slate-100 bg-slate-50 rounded-b-2xl">
                <a href="{{ route('depreciation-methods.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-white transition-colors">
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