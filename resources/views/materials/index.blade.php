@extends('layouts.app')

@section('title', 'Materi Pembelajaran')
@section('page-title', 'Materi & Studi Kasus')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Home</a>
    <span>/</span>
    <span class="text-slate-700">Materi</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">Materi Pembelajaran</h2>
        <p class="text-slate-500 text-sm">Pelajari konsep akuntansi manajemen aset.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($materials as $material)
            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full 
                        @switch($material['level'])
                            @case('Pemula') bg-green-100 text-green-700 @break
                            @case('Menengah') bg-yellow-100 text-yellow-700 @break
                            @case('Lanjut') bg-red-100 text-red-700 @break
                        @endswitch">
                        {{ $material['level'] }}
                    </span>
                    <span class="flex items-center gap-1 text-xs text-slate-500">
                        <i data-lucide="clock" class="w-3 h-3"></i> {{ $material['duration'] }}
                    </span>
                </div>
                <h3 class="font-bold text-slate-800 mb-2">{{ $material['title'] }}</h3>
                <p class="text-sm text-slate-500 mb-4 line-clamp-2">{{ $material['description'] }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-xs text-slate-400">{{ $material['category'] }}</span>
                    <a href="{{ route('materials.show', $material['id']) }}" class="text-sm text-primary font-medium hover:underline flex items-center gap-1">
                        Mulai <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <script>lucide.createIcons();</script>
@endsection