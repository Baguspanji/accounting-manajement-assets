<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akuntansi Aset - Manajemen Aset Tetap Otomatis</title>
    <meta name="description"
        content="Aplikasi akuntansi manajemen aset tetap: pencatatan perolehan, penyusutan, pelepasan, jurnal otomatis, dan laporan keuangan.">
    <link rel="icon" type="image/svg+xml" href="{{ asset('images/favicon.svg') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        html {
            scroll-behavior: smooth;
        }

        .custom-scroll::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-background text-text-primary antialiased">

    {{-- Navbar --}}
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-primary rounded-xl flex items-center justify-center text-white">
                    <i data-lucide="box" class="w-5 h-5"></i>
                </div>
                <span class="font-bold text-text-primary">Akuntansi Aset</span>
            </a>

            <nav class="hidden md:flex items-center gap-1 text-sm">
                <a href="#fitur"
                    class="px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">Fitur</a>
                <a href="#modul"
                    class="px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">Modul</a>
                <a href="#laporan"
                    class="px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">Laporan</a>
                <a href="#mulai"
                    class="px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">Mulai</a>
            </nav>

            <div class="flex items-center gap-2">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-primary rounded-xl hover:bg-primary-dark transition-colors shadow-sm">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="px-4 py-2 text-sm font-medium text-slate-600 hover:text-primary transition-colors">Masuk</a>
                @endauth
            </div>
        </div>
    </header>

    {{-- Hero --}}
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-linear-to-br from-primary/10 via-background to-info/10"></div>
        <div class="relative max-w-6xl mx-auto px-4 py-20 md:py-28 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <span
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-primary-light text-primary-dark text-xs font-semibold">
                    <i data-lucide="sparkles" class="w-3.5 h-3.5"></i> Jurnal akuntansi otomatis
                </span>
                <h1 class="mt-5 text-4xl md:text-5xl font-extrabold leading-tight text-text-primary">
                    Kelola Aset Tetap.<br>
                    <span class="text-primary">Buku Besar Otomatis.</span>
                </h1>
                <p class="mt-5 text-text-secondary leading-relaxed">
                    Catat perolehan, hitung penyusutan, dan lepaskan aset dalam satu alur.
                    Setiap transaksi langsung menghasilkan jurnal, buku besar, dan laporan keuangan yang siap diunduh.
                </p>
                <dl class="mt-10 grid grid-cols-3 gap-4 max-w-md">
                    @foreach ([['4', 'Metode Penyusutan'], ['6', 'Laporan Keuangan'], ['3', 'Alur Transaksi']] as [$value, $label])
                        <div class="bg-white rounded-2xl border border-slate-100 p-4 shadow-soft">
                            <dt class="text-2xl font-bold text-primary">{{ $value }}</dt>
                            <dd class="text-xs text-text-secondary mt-1">{{ $label }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            <div class="relative">
                <div
                    class="absolute -inset-4 bg-linear-to-br from-primary/20 to-info/20 rounded-3xl blur-2xl hidden md:block">
                </div>
                <div class="relative bg-white rounded-2xl border border-slate-200 shadow-xl overflow-hidden">
                    <img src="{{ asset('images/dashboard.png') }}" alt="Tampilan dashboard Akuntansi Aset"
                        class="w-full" loading="lazy" decoding="async">
                </div>
                <div
                    class="relative mt-4 flex items-center gap-3 p-3.5 rounded-xl bg-primary-light border border-primary/20">
                    <i data-lucide="book-open-check" class="w-4 h-4 text-primary-dark shrink-0"></i>
                    <p class="text-xs text-primary-dark">Jurnal &amp; buku besar terbentuk otomatis, tanpa input manual.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Fitur --}}
    <section id="fitur" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-bold text-text-primary">Semua yang dibutuhkan untuk aset tetap</h2>
                <p class="mt-3 text-text-secondary">Dari master data hingga pelaporan, tanpa aplikasi terpisah.</p>
            </div>
            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ([['box', 'Master Data Lengkap', 'Kelola aset, kategori aset, metode penyusutan, dan chart of account dengan kode akun yang konsisten.'], ['calculator', 'Penyusutan Fleksibel', 'Garis lurus, saldo menurun, jumlah angka tahun, dan unit of production dengan umur manfaat serta nilai residu.'], ['notebook-pen', 'Jurnal Otomatis', 'Setiap perolehan, penyusutan, dan pelepasan menghasilkan jurnal berpasangan yang siap diposting.'], ['gantt-chart-square', 'Buku Besar & Neraca Saldo', 'Pantau saldo per akun dan uji seimbang seluruh entri sebelum tutup periode.'], ['file-text', 'Laporan siap PDF', 'Neraca, laba rugi, arus kas, jadwal penyusutan, dan kartu aset dapat diunduh dalam format PDF.'], ['book-open', 'Panduan Pemakaian', 'Dokumentasi tertanam di dalam aplikasi agar alur kerja mudah dipelajari tim Anda.']] as [$icon, $title, $desc])
                    <article
                        class="p-5 rounded-2xl border border-slate-200 bg-background hover:border-primary transition-colors">
                        <span
                            class="w-10 h-10 rounded-xl bg-primary-light text-primary-dark flex items-center justify-center">
                            <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
                        </span>
                        <h3 class="mt-4 font-semibold text-text-primary">{{ $title }}</h3>
                        <p class="mt-2 text-sm text-text-secondary leading-relaxed">{{ $desc }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Modul --}}
    <section id="modul" class="py-20">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-text-primary">Modul Aplikasi</h2>
            <p class="mt-3 text-text-secondary">Menu yang persis sama dengan aplikasi di dalam dashboard.</p>

            <div class="mt-10 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                @foreach ([['layout-dashboard', 'Dashboard', 'Ringkasan nilai perolehan, nilai buku, akumulasi penyusutan, dan aktivitas terbaru.'], ['boxes', 'Master Data', 'Aset, kategori aset, metode penyusutan, dan chart of account.'], ['shopping-cart', 'Perolehan Aset', 'Input aset baru lengkap dengan tanggal perolehan dan sumber dana.'], ['trending-down', 'Penyusutan', 'Jalankan dan posting penyusutan per periode dalam satu klik.'], ['package-check', 'Pelepasan Aset', 'Catat aset yang dijual atau dihapus beserta hasil dan laba/rugi.'], ['notebook-pen', 'Akuntansi', 'Jurnal, buku besar, dan neraca saldo sebagai sumber kebenaran data.']] as [$icon, $title, $desc])
                    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-soft flex gap-4">
                        <span
                            class="w-10 h-10 shrink-0 rounded-xl bg-primary text-white flex items-center justify-center">
                            <i data-lucide="{{ $icon }}" class="w-5 h-5"></i>
                        </span>
                        <div>
                            <h3 class="font-semibold text-text-primary">{{ $title }}</h3>
                            <p class="mt-1.5 text-sm text-text-secondary leading-relaxed">{{ $desc }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Laporan --}}
    <section id="laporan" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-text-primary">Laporan keuangan siap pakai</h2>
                <p class="mt-3 text-text-secondary">
                    Tujuh laporan tersedia di layar dan dapat diunduh sebagai PDF kapan saja,
                    berdasarkan data jurnal yang sudah diposting.
                </p>
                <ul class="mt-8 space-y-3">
                    @foreach (['Neraca', 'Laba Rugi', 'Nilai Buku per Kategori', 'Kartu Aset', 'Jadwal Penyusutan', 'Pelepasan Aset', 'Arus Kas'] as $report)
                        <li class="flex items-center gap-3 text-sm text-text-primary">
                            <i data-lucide="check-circle-2"
                                class="w-4 h-4 text-primary shrink-0"></i>{{ $report }}
                            <span class="text-xs text-text-secondary">· PDF</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-background p-6 shadow-soft">
                <div class="bg-white rounded-xl border border-slate-100 overflow-hidden">
                    <div class="px-4 py-3 border-b border-slate-100 text-sm font-semibold text-text-primary">Jadwal
                        Penyusutan</div>
                    <table class="w-full text-xs">
                        <thead class="bg-background text-text-secondary">
                            <tr>
                                <th class="text-left font-medium px-4 py-2">Periode</th>
                                <th class="text-right font-medium px-4 py-2">Beban</th>
                                <th class="text-right font-medium px-4 py-2">Akumulasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ([['Jan 2026', 25.0, 25.0], ['Feb 2026', 25.0, 50.0], ['Mar 2026', 25.0, 75.0], ['Apr 2026', 25.0, 100.0]] as [$periode, $beban, $akumulasi])
                                <tr>
                                    <td class="px-4 py-2.5 text-text-primary">{{ $periode }}</td>
                                    <td class="px-4 py-2.5 text-right text-text-secondary">
                                        {{ number_format($beban, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2.5 text-right font-medium text-text-primary">
                                        {{ number_format($akumulasi, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="mt-3 text-xs text-text-secondary">* Contoh tampilan, bukan data sebenarnya.</p>
            </div>
        </div>
    </section>

    <footer class="border-t border-slate-200 bg-white">
        <div
            class="max-w-6xl mx-auto px-4 py-8 flex flex-col sm:flex-row items-center justify-between gap-3 text-sm text-text-secondary">
            <div class="flex items-center gap-2">
                <div class="w-7 h-7 bg-primary rounded-lg flex items-center justify-center text-white">
                    <i data-lucide="box" class="w-4 h-4"></i>
                </div>
                <span class="font-semibold text-text-primary">Akuntansi Aset</span>
            </div>
            <p>&copy; {{ date('Y') }} Aplikasi Akuntansi Manajemen Aset.</p>
        </div>
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
