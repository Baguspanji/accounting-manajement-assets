<aside id="sidebar" class="w-64 bg-white border-r border-slate-200 flex flex-col transition-all duration-300 ease-in-out -translate-x-full md:translate-x-0 absolute md:relative z-40 h-full">
    <div class="h-16 flex items-center justify-between px-4 border-b border-slate-200">
        <div class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-primary rounded-xl flex items-center justify-center text-white">
                <i data-lucide="box" class="w-5 h-5"></i>
            </div>
            <span class="font-bold text-slate-800 hidden md:block">Akuntansi Aset</span>
        </div>
        <button onclick="toggleSidebar()" class="md:hidden text-slate-500"><i data-lucide="x"></i></button>
    </div>

    <nav class="flex-1 overflow-y-auto custom-scroll py-4 px-3 space-y-1">
        <p class="px-3 text-xs font-semibold text-slate-400 uppercase mb-1">Menu Utama</p>
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('dashboard') ? 'bg-primary-light text-primary-dark font-medium' : 'text-slate-600 hover:bg-slate-100' }} transition-colors">
            <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
            <span class="text-sm">Dashboard</span>
        </a>

        <p class="px-3 text-xs font-semibold text-slate-400 uppercase mt-4 mb-1">Master Data</p>
        <a href="{{ route('assets.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('assets.*') ? 'bg-primary-light text-primary-dark font-medium' : 'text-slate-600 hover:bg-slate-100' }} transition-colors">
            <i data-lucide="package" class="w-5 h-5"></i>
            <span class="text-sm">Aset</span>
        </a>
        <a href="{{ route('asset-categories.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('asset-categories.*') ? 'bg-primary-light text-primary-dark font-medium' : 'text-slate-600 hover:bg-slate-100' }} transition-colors">
            <i data-lucide="folder" class="w-5 h-5"></i>
            <span class="text-sm">Kategori Aset</span>
        </a>
        <a href="{{ route('depreciation-methods.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('depreciation-methods.*') ? 'bg-primary-light text-primary-dark font-medium' : 'text-slate-600 hover:bg-slate-100' }} transition-colors">
            <i data-lucide="calculator" class="w-5 h-5"></i>
            <span class="text-sm">Metode Penyusutan</span>
        </a>
        <a href="{{ route('accounts.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('accounts.*') ? 'bg-primary-light text-primary-dark font-medium' : 'text-slate-600 hover:bg-slate-100' }} transition-colors">
            <i data-lucide="list" class="w-5 h-5"></i>
            <span class="text-sm">Chart of Account</span>
        </a>

        <p class="px-3 text-xs font-semibold text-slate-400 uppercase mt-4 mb-1">Transaksi</p>
        <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
            <i data-lucide="package-plus" class="w-5 h-5"></i>
            <span class="text-sm">Perolehan Aset</span>
        </a>
        <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
            <i data-lucide="trending-down" class="w-5 h-5"></i>
            <span class="text-sm">Penyusutan</span>
        </a>
        <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
            <i data-lucide="package-minus" class="w-5 h-5"></i>
            <span class="text-sm">Pelepasan Aset</span>
        </a>

        <p class="px-3 text-xs font-semibold text-slate-400 uppercase mt-4 mb-1">Akuntansi</p>
        <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
            <i data-lucide="book-open" class="w-5 h-5"></i>
            <span class="text-sm">Jurnal</span>
        </a>
        <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
            <i data-lucide="gantt-chart-square" class="w-5 h-5"></i>
            <span class="text-sm">Buku Besar</span>
        </a>
        <a href="#" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
            <i data-lucide="scale" class="w-5 h-5"></i>
            <span class="text-sm">Neraca Saldo</span>
        </a>

        <p class="px-3 text-xs font-semibold text-slate-400 uppercase mt-4 mb-1">Pembelajaran</p>
                <a href="{{ route('materials.index') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-xl {{ request()->routeIs('materials.*', 'study-cases.*') ? 'bg-primary-light text-primary-dark font-medium' : 'text-slate-600 hover:bg-slate-100' }} transition-colors">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                    <span class="text-sm">Materi & Studi Kasus</span>
                </a>
    </nav>
</aside>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    sidebar.classList.toggle('-translate-x-full');
}
</script>
