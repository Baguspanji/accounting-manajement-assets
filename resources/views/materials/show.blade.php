@extends('layouts.app')

@section('title', 'Materi - Perbedaan Simpan Pinjam Konvensional dan Syariah')
@section('page-title', 'Materi Pembelajaran')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Home</a>
    <span>/</span>
    <a href="{{ route('materials.index') }}" class="hover:text-primary">Materi</a>
    <span>/</span>
    <span class="text-slate-700">Perbedaan Simpan Pinjam Konvensional dan Syariah</span>
@endsection

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">Pemula</span>
                <span class="flex items-center gap-1 text-sm text-slate-500">
                    <i data-lucide="clock" class="w-4 h-4"></i> 45 menit
                </span>
            </div>
            <h1 class="text-3xl font-bold text-slate-800">Perbedaan Simpan Pinjam Konvensional dan Syariah</h1>
        </div>
        <a href="{{ route('materials.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 text-sm font-medium">
            Kembali
        </a>
    </div>

    <div class="prose prose-slate max-w-none">
        @include('materials.content.material-1')
    </div>

    <div class="mt-8 pt-6 border-t border-slate-200 flex items-center justify-between">
        <div class="flex items-center gap-2">
            <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center">
                <i data-lucide="check-circle" class="w-6 h-6 text-primary"></i>
            </div>
            <div>
                <p class="text-sm text-slate-500">Materi selesai</p>
                <p class="font-medium text-slate-800">Anda telah menyelesaikan materi ini</p>
            </div>
        </div>
        <a href="{{ route('study-cases.index') }}" class="px-6 py-2.5 bg-primary text-white rounded-xl font-semibold hover:bg-primary-dark transition-colors shadow-sm flex items-center gap-2">
            Ke Studi Kasus <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>

    <script>lucide.createIcons();</script>
@endsection