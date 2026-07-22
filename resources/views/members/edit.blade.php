@extends('layouts.app')

@section('title', 'Edit Anggota')
@section('page-title', 'Anggota')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Master</a>
    <span>/</span>
    <a href="{{ route('members.index') }}" class="hover:text-primary">Anggota</a>
    <span>/</span>
    <span class="text-slate-700">Edit</span>
@endsection

@section('content')
    <div class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">Edit Anggota</h2>
        <p class="text-slate-500 text-sm">Perbarui data anggota.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-soft border border-slate-100">
        <form action="{{ route('members.update', $member->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Anggota <span class="text-danger">*</span></label>
                            <input type="text" name="member_number" value="{{ old('member_number', $member->member_number) }}" required
                                class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('member_number') ? 'border-danger' : 'border-slate-200' }}">
                            @error('member_number')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $member->name) }}" required
                                class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('name') ? 'border-danger' : 'border-slate-200' }}">
                            @error('name')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                            <input type="email" name="email" value="{{ old('email', $member->email) }}"
                                class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('email') ? 'border-danger' : 'border-slate-200' }}">
                            @error('email')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Nomor Telepon <span class="text-danger">*</span></label>
                            <input type="text" name="phone" value="{{ old('phone', $member->phone) }}" required
                                class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('phone') ? 'border-danger' : 'border-slate-200' }}">
                            @error('phone')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Tanggal Bergabung <span class="text-danger">*</span></label>
                            <input type="date" name="joined_date" value="{{ old('joined_date', $member->joined_date->format('Y-m-d')) }}" required
                                class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary {{ $errors->has('joined_date') ? 'border-danger' : 'border-slate-200' }}">
                            @error('joined_date')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Alamat Domisili</label>
                            <textarea name="address" rows="4"
                                class="w-full px-4 py-2.5 border rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary resize-none {{ $errors->has('address') ? 'border-danger' : 'border-slate-200' }}">{{ old('address', $member->address) }}</textarea>
                            @error('address')<p class="text-xs text-danger mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Status Keanggotaan</label>
                            <select name="status" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary bg-white">
                                <option value="active" {{ old('status', $member->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                                <option value="inactive" {{ old('status', $member->status) === 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 p-5 border-t border-slate-100 bg-slate-50 rounded-b-2xl">
                <a href="{{ route('members.index') }}" class="px-5 py-2.5 text-sm font-medium text-slate-600 border border-slate-200 rounded-xl hover:bg-white transition-colors">
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