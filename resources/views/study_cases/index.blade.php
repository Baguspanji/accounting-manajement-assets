@extends('layouts.app')

@section('title', 'Studi Kasus')
@section('page-title', 'Materi & Studi Kasus')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Home</a>
    <span>/</span>
    <span class="text-slate-700">Studi Kasus</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">Daftar Studi Kasus</h2>
        <p class="text-slate-500 text-sm">Simulasi transaksi akuntansi manajemen aset.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($studyCases as $case)
            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-5 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                        {{ $case['code'] }}
                    </span>
                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full 
                        @switch($case['level'])
                            @case('Pemula') bg-green-100 text-green-700 @break
                            @case('Menengah') bg-yellow-100 text-yellow-700 @break
                            @case('Lanjut') bg-red-100 text-red-700 @break
                        @endswitch">
                        {{ $case['level'] }}
                    </span>
                </div>
                <h3 class="font-bold text-slate-800 mb-2">{{ $case['title'] }}</h3>
                <p class="text-sm text-slate-500 mb-4 line-clamp-2">{{ $case['description'] }}</p>
                <div class="flex flex-col gap-2 mb-4 text-xs text-slate-500">
                    <div class="flex items-center gap-2">
                        <i data-lucide="tag" class="w-3 h-3"></i> Kategori: {{ $case['category'] }}
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="clock" class="w-3 h-3"></i> Durasi: <span class="font-medium text-slate-700">{{ $case['duration'] }}</span>
                    </div>
                </div>
                <a href="{{ route('study-cases.show', $case['id']) }}" class="w-full block text-center bg-primary text-white py-2 rounded-xl text-sm font-semibold hover:bg-primary-dark transition-colors shadow-sm">
                    Kerjakan Kasus
                </a>
            </div>
        @endforeach
    </div>

    <script>lucide.createIcons();</script>
@endsection