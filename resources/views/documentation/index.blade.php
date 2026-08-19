@extends('layouts.app')

@section('title', 'Dokumentasi')
@section('page-title', 'Dokumentasi Pemakaian')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Home</a>
    <span>/</span>
    <span class="text-text-secondary">Dokumentasi</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-text-primary">Dokumentasi Pemakaian</h2>
        <p class="text-text-secondary text-sm">Panduan penggunaan aplikasi akuntansi manajemen aset.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($documents as $document)
            <a href="{{ route('documentation.show', $document['id']) }}" class="bg-surface rounded-2xl shadow-soft border border-slate-100 p-5 hover:shadow-md hover:border-primary/30 transition-all">
                <div class="flex items-start justify-between mb-3">
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-primary-light text-primary">
                        {{ $document['category'] }}
                    </span>
                    <span class="flex items-center gap-1 text-xs text-text-secondary">
                        <i data-lucide="clock" class="w-3 h-3"></i> {{ $document['updated_at'] }}
                    </span>
                </div>
                <div class="w-10 h-10 bg-primary-light rounded-xl flex items-center justify-center mb-3">
                    <i data-lucide="{{ $document['icon'] }}" class="w-5 h-5 text-primary"></i>
                </div>
                <h3 class="font-bold text-text-primary mb-2">{{ $document['title'] }}</h3>
                <p class="text-sm text-text-secondary mb-4 line-clamp-2">{{ $document['description'] }}</p>
                <span class="text-sm text-primary font-medium inline-flex items-center gap-1">
                    Baca Panduan <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </span>
            </a>
        @endforeach
    </div>

    <script>lucide.createIcons();</script>
@endsection