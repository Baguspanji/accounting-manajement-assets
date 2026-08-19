<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Akuntansi Aset</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-background text-text-primary antialiased">
    <div class="min-h-screen flex items-center justify-center p-4 bg-linear-to-br from-primary/10 via-background to-info/10">
        <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden grid md:grid-cols-2 border border-slate-100">

            <div class="hidden md:flex flex-col justify-between bg-primary p-8 text-white">
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <i data-lucide="box" class="w-6 h-6"></i>
                    </div>
                    <span class="font-bold text-lg">Akuntansi Aset</span>
                </div>
                <div>
                    <h2 class="text-3xl font-bold mb-2">Aplikasi Akuntansi Manajemen Aset</h2>
                    <p class="text-white/80 text-sm">Kelola aset tetap, penyusutan, dan pelaporan keuangan secara praktis.</p>
                </div>
                <div class="text-xs text-white/60">&copy; {{ date('Y') }} Akuntansi Aset.</div>
            </div>

            <div class="p-8 md:p-12 flex flex-col justify-center">
                <div class="md:hidden flex items-center space-x-2 mb-8">
                    <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white">
                        <i data-lucide="box" class="w-6 h-6"></i>
                    </div>
                    <span class="font-bold text-lg text-text-primary">Akuntansi Aset</span>
                </div>

                <h1 class="text-2xl font-bold text-text-primary mb-2">Selamat Datang Kembali</h1>
                <p class="text-text-secondary mb-8 text-sm">Silakan masukkan kredensial Anda untuk mengakses dashboard.</p>

                <form action="{{ route('login') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Email / Username</label>
                        <div class="relative">
                            <i data-lucide="mail" class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="admin@akuntansiaset.com" required
                                class="w-full pl-10 pr-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all {{ $errors->has('email') ? 'border-danger' : 'border-slate-200' }}">
                        </div>
                        @error('email')
                            <p class="text-xs text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
                        <div class="relative">
                            <i data-lucide="lock" class="w-5 h-5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2"></i>
                            <input type="password" name="password" placeholder="********" required
                                class="w-full pl-10 pr-4 py-2.5 border rounded-xl focus:ring-2 focus:ring-primary/30 focus:border-primary outline-none transition-all {{ $errors->has('password') ? 'border-danger' : 'border-slate-200' }}">
                        </div>
                        @error('password')
                            <p class="text-xs text-danger mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center space-x-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary/30">
                            <span class="text-sm text-slate-600">Ingat saya</span>
                        </label>
                        <!-- <a href="#" class="text-sm text-primary font-medium hover:underline">Lupa password?</a> -->
                    </div>

                    <button type="submit" class="w-full bg-primary text-white py-2.5 rounded-xl font-semibold hover:bg-primary-dark transition-colors shadow-sm flex items-center justify-center gap-2">
                        Masuk ke Dashboard
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
    <script>lucide.createIcons();</script>
</body>
</html>
