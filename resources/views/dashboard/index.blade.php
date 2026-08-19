@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb')
    <a href="#" class="hover:text-primary">Home</a>
    <span>/</span>
    <span class="text-slate-700">Dashboard</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800">Selamat Datang, {{ auth()->user()->name ?? 'Admin' }}</h2>
        <p class="text-slate-500">Ringkasan manajemen aset tetap hari ini.</p>
    </div>

    @php
        $totalAssets = \App\Models\Asset::count();
        $totalCost = \App\Models\Asset::where('status', 'active')->sum('acquisition_cost');
        $totalAccumulated = \App\Models\Depreciation::where('status', 'posted')->sum('accumulated_after');
        $bookValue = max($totalCost - $totalAccumulated, 0);
    @endphp

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-5 rounded-2xl shadow-soft border border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-primary-light rounded-xl">
                    <i data-lucide="package" class="w-6 h-6 text-primary"></i>
                </div>
                <span class="text-xs font-medium text-primary bg-primary-light px-2 py-1 rounded-full">Register</span>
            </div>
            <h3 class="text-slate-500 text-sm">Total Aset</h3>
            <p class="text-2xl font-bold text-slate-800">{{ $totalAssets }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-soft border border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-info-light rounded-xl">
                    <i data-lucide="badge-dollar-sign" class="w-6 h-6 text-info"></i>
                </div>
            </div>
            <h3 class="text-slate-500 text-sm">Nilai Perolehan</h3>
            <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalCost, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-soft border border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-warning-light rounded-xl">
                    <i data-lucide="trending-down" class="w-6 h-6 text-warning"></i>
                </div>
            </div>
            <h3 class="text-slate-500 text-sm">Akumulasi Penyusutan</h3>
            <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($totalAccumulated, 0, ',', '.') }}</p>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-soft border border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-slate-100 rounded-xl">
                    <i data-lucide="scale" class="w-6 h-6 text-slate-600"></i>
                </div>
            </div>
            <h3 class="text-slate-500 text-sm">Nilai Buku</h3>
            <p class="text-2xl font-bold text-slate-800">Rp {{ number_format($bookValue, 0, ',', '.') }}</p>
        </div>
    </div>
@endsection