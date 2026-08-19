@extends('layouts.app')

@section('title', 'Edit Metode Penyusutan')
@section('page-title', 'Metode Penyusutan')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Master</a>
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

    <div class="bg-white rounded-2xl shadow-soft border border-slate-100">
        <form action="{{ route('depreciation-methods.update', $depreciationMethod->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 max-w-2xl space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Kode Metode <span class="text-danger">*</span></label>
                        <input type="text" name="code" value="{{ old('code', $depreciationMethod->code) }}" required
                            class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('code') ? 'border-danger' : 'border-slate-200' }}">
                        @error('code')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Metode <span class="text-danger">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $depreciationMethod->name) }}" required
                            class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('name') ? 'border-danger' : 'border-slate-200' }}">
                        @error('name')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Formula</label>
                    <textarea name="formula" rows="2"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary resize-none">{{ old('formula', $depreciationMethod->formula) }}</textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1.5">Deskripsi</label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary resize-none">{{ old('description', $depreciationMethod->description) }}</textarea>
                </div>
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $depreciationMethod->is_active) ? 'checked' : '' }} class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/30">
                        <span class="text-sm text-slate-600">Aktif</span>
                    </label>
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