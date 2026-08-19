@extends('layouts.app')

@section('title', 'Edit Metode Penyusutan')
@section('page-title', 'Metode Penyusutan')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Home</a>
    <span>/</span>
    <a href="{{ route('depreciation-methods.index') }}" class="hover:text-primary">Metode Penyusutan</a>
    <span>/</span>
    <span class="text-slate-700">Edit</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-text-primary">Edit Metode Penyusutan</h2>
        <p class="text-text-secondary text-sm">Perbarui data metode penyusutan.</p>
    </div>

    <div class="bg-surface rounded-2xl shadow-soft border border-slate-100">
        <form action="{{ route('depreciation-methods.update', $depreciationMethod->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 max-w-2xl space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-forms.label for="code" required>Kode Metode</x-forms.label>
                        <x-forms.input name="code" :value="$depreciationMethod->code" required />
                    </div>
                    <div>
                        <x-forms.label for="name" required>Nama Metode</x-forms.label>
                        <x-forms.input name="name" :value="$depreciationMethod->name" required />
                    </div>
                </div>
                <div>
                    <x-forms.label for="formula">Formula</x-forms.label>
                    <x-forms.textarea name="formula" rows="2" :value="$depreciationMethod->formula" />
                </div>
                <div>
                    <x-forms.label for="description">Deskripsi</x-forms.label>
                    <x-forms.textarea name="description" rows="3" :value="$depreciationMethod->description" />
                </div>
                <div>
                    <x-forms.checkbox name="is_active" value="1" :checked="old('is_active', $depreciationMethod->is_active)">Aktif</x-forms.checkbox>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 p-5 border-t border-slate-100 bg-slate-50 rounded-b-2xl">
                <a href="{{ route('depreciation-methods.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-white transition-colors">
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