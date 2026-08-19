<header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-30">
    <div class="flex items-center space-x-4">
        <button onclick="toggleSidebar()" class="md:hidden text-slate-600"><i data-lucide="menu"></i></button>
        <div>
            <h1 class="text-lg font-bold text-text-primary">@yield('page-title', 'Dashboard')</h1>
            @hasSection('breadcrumb')
            <div class="text-xs text-text-secondary flex items-center gap-1">
                @yield('breadcrumb')
            </div>
            @endif
        </div>
    </div>

    <div class="flex items-center space-x-4">
        <!-- <div class="hidden md:flex items-center bg-slate-100 rounded-xl px-3 py-2 w-64">
            <i data-lucide="search" class="w-4 h-4 text-text-secondary mr-2"></i>
            <input type="text" placeholder="Cari data aset, akun..." class="bg-transparent text-sm outline-none w-full">
        </div>
        <button class="relative p-2 rounded-xl hover:bg-slate-100">
            <i data-lucide="bell" class="w-5 h-5 text-slate-600"></i>
            <span class="absolute top-1 right-1 w-2 h-2 bg-danger rounded-full"></span>
        </button> -->
        <div class="flex items-center space-x-2 cursor-pointer hover:bg-slate-100 p-1 rounded-xl">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=2563eb&color=fff" alt="User" class="w-8 h-8 rounded-lg">
            <div class="hidden md:block">
                <p class="text-sm font-medium">{{ auth()->user()->name ?? 'Admin User' }}</p>
                <p class="text-xs text-text-secondary">Administrator</p>
            </div>
            <i data-lucide="chevron-down" class="w-4 h-4 text-text-secondary hidden md:block"></i>
        </div>
    </div>
</header>
