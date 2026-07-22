@extends('layouts.app')

@section('title', 'Detail Anggota')
@section('page-title', 'Anggota')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Master</a>
    <span>/</span>
    <a href="{{ route('members.index') }}" class="hover:text-primary">Anggota</a>
    <span>/</span>
    <span class="text-slate-700">Detail</span>
@endsection

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Detail Anggota</h2>
            <p class="text-slate-500 text-sm">Informasi lengkap nasabah.</p>
        </div>
        <a href="{{ route('members.index') }}" class="px-4 py-2 border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 text-sm font-medium">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="col-span-1">
            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6 flex flex-col items-center text-center">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=2563eb&color=fff&size=100" class="w-24 h-24 rounded-2xl mb-4" alt="Avatar">
                <h3 class="text-lg font-bold text-slate-800">{{ $member->name }}</h3>
                <p class="text-sm text-slate-500 mb-4">{{ $member->member_number }}</p>
                <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $member->status === 'active' ? 'bg-primary-light text-primary' : 'bg-slate-100 text-slate-600' }}">
                    {{ $member->status === 'active' ? 'Aktif' : 'Non-Aktif' }}
                </span>
            </div>
        </div>
        <div class="col-span-1 md:col-span-2">
            <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden">
                <div class="p-5 border-b border-slate-100">
                    <h3 class="font-bold text-slate-800">Informasi Kontak & Personal</h3>
                </div>
                <div class="p-0">
                    <table class="w-full text-sm text-left">
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50">
                                <th class="w-1/3 py-4 px-5 font-medium text-slate-500">Email</th>
                                <td class="py-4 px-5 text-slate-800">{{ $member->email ?? '-' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <th class="py-4 px-5 font-medium text-slate-500">Nomor Telepon</th>
                                <td class="py-4 px-5 text-slate-800">{{ $member->phone }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <th class="py-4 px-5 font-medium text-slate-500">Tanggal Bergabung</th>
                                <td class="py-4 px-5 text-slate-800">{{ $member->joined_date->format('d M Y') }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <th class="py-4 px-5 font-medium text-slate-500 align-top">Alamat Domisili</th>
                                <td class="py-4 px-5 text-slate-800">{{ $member->address ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-6 flex gap-3">
                <a href="{{ route('members.edit', $member->id) }}" class="flex-1 bg-warning text-white py-2.5 rounded-xl font-semibold flex items-center justify-center gap-2 hover:bg-warning/90 transition-colors">
                    <i data-lucide="edit" class="w-4 h-4"></i> Edit Data
                </a>
            </div>
        </div>
    </div>

    <script>lucide.createIcons();</script>
@endsection