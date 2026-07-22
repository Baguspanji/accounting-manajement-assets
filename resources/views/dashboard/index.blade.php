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
        <h2 class="text-2xl font-bold text-slate-800">Selamat Datang, {{ auth()->user()->name ?? 'Admin' }} 👋</h2>
        <p class="text-slate-500">Ringkasan aktivitas simpan pinjam syariah hari ini.</p>
    </div>

    <!-- Copied directly from the ui-reference.html stat cards... -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-5 rounded-2xl shadow-soft border border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-primary-light rounded-xl">
                    <i data-lucide="users" class="w-6 h-6 text-primary"></i>
                </div>
                <span class="text-xs font-medium text-primary bg-primary-light px-2 py-1 rounded-full">Data</span>
            </div>
            <h3 class="text-slate-500 text-sm">Total Anggota</h3>
            <p class="text-2xl font-bold text-slate-800">{{ \App\Models\Member::count() }}</p>
        </div>
        
        <div class="bg-white p-5 rounded-2xl shadow-soft border border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-info-light rounded-xl">
                    <i data-lucide="wallet" class="w-6 h-6 text-info"></i>
                </div>
            </div>
            <h3 class="text-slate-500 text-sm">Total Simpanan</h3>
            <p class="text-2xl font-bold text-slate-800">Rp 0</p>
        </div>
        
        <div class="bg-white p-5 rounded-2xl shadow-soft border border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-warning-light rounded-xl">
                    <i data-lucide="banknote" class="w-6 h-6 text-warning"></i>
                </div>
            </div>
            <h3 class="text-slate-500 text-sm">Total Pembiayaan</h3>
            <p class="text-2xl font-bold text-slate-800">Rp 0</p>
        </div>
        
        <div class="bg-white p-5 rounded-2xl shadow-soft border border-slate-100">
            <div class="flex justify-between items-start mb-4">
                <div class="p-2 bg-slate-100 rounded-xl">
                    <i data-lucide="wallet" class="w-6 h-6 text-slate-600"></i>
                </div>
            </div>
            <h3 class="text-slate-500 text-sm">Total Kas</h3>
            <p class="text-2xl font-bold text-slate-800">Rp 0</p>
        </div>
    </div>
@endsection