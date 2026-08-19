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
                        <x-forms.label for="email" required>Email / Username</x-forms.label>
                        <x-forms.input type="email" name="email" icon="mail" placeholder="admin@akuntansiaset.com" required />
                    </div>

                    <div>
                        <x-forms.label for="password" required>Password</x-forms.label>
                        <x-forms.input type="password" name="password" icon="lock" placeholder="********" required />
                    </div>

                    <div class="flex items-center justify-between">
                        <x-forms.checkbox name="remember" value="1">Ingat saya</x-forms.checkbox>
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
