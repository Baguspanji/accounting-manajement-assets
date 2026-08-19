@extends('layouts.app')

@section('title', 'Profil')
@section('page-title', 'Akun')
@section('breadcrumb')
    <a href="{{ route('dashboard') }}" class="hover:text-primary">Akun</a>
    <span>/</span>
    <span class="text-slate-700">Profil</span>
@endsection

@section('content')
    @if (Session::get('success'))
        <x-flash type="success">{{ Session::get('success') }}</x-flash>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center gap-4">
                <div class="w-16 h-16 bg-primary-light rounded-2xl flex items-center justify-center">
                    <i data-lucide="user" class="w-8 h-8 text-primary"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-text-primary">{{ $user->name }}</h3>
                    <p class="text-sm text-text-secondary">{{ $user->email }}</p>
                </div>
            </div>
            <div class="p-6 space-y-4 text-sm">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <span class="text-text-secondary">Nama Lengkap</span>
                    <span class="font-medium text-text-primary">{{ $user->name }}</span>
                </div>
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <span class="text-text-secondary">Alamat Email</span>
                    <span class="font-medium text-text-primary">{{ $user->email }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-text-secondary">Peran</span>
                    <span class="px-2.5 py-1 inline-flex text-xs font-semibold rounded-full bg-primary-light text-primary">Administrator</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-soft border border-slate-100 p-6">
            <h3 class="text-lg font-bold text-text-primary mb-1">Ganti Kata Sandi</h3>
            <p class="text-sm text-text-secondary mb-6">Ganti kata sandi secara berkala untuk menjaga keamanan akun.</p>

            <form method="POST" action="{{ route('profile.password') }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <x-forms.label for="current_password">Kata Sandi Saat Ini</x-forms.label>
                    <x-forms.input type="password" name="current_password" id="current_password" required autocomplete="current-password" />
                </div>

                <div>
                    <x-forms.label for="password">Kata Sandi Baru</x-forms.label>
                    <x-forms.input type="password" name="password" id="password" required autocomplete="new-password" />
                </div>

                <div>
                    <x-forms.label for="password_confirmation">Konfirmasi Kata Sandi Baru</x-forms.label>
                    <x-forms.input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password" />
                </div>

                <button type="submit" class="w-full px-4 py-2.5 text-sm font-semibold text-white bg-primary rounded-xl hover:bg-primary-dark transition-colors shadow-sm flex items-center justify-center gap-2">
                    <i data-lucide="key-round" class="w-4 h-4"></i> Perbarui Kata Sandi
                </button>
            </form>
        </div>
    </div>

    <script>lucide.createIcons();</script>
@endsection
