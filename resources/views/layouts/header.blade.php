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
        <div class="relative">
            <button id="user-menu-button" type="button" onclick="toggleUserMenu()"
                class="flex items-center space-x-2 cursor-pointer hover:bg-slate-100 p-1 rounded-xl transition-colors" aria-haspopup="menu" aria-expanded="false">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name ?? 'Admin') }}&background=2563eb&color=fff" alt="User" class="w-8 h-8 rounded-lg">
                <div class="hidden md:block text-left">
                    <p class="text-sm font-medium">{{ auth()->user()->name ?? 'Admin User' }}</p>
                    <p class="text-xs text-text-secondary">Administrator</p>
                </div>
                <i data-lucide="chevron-down" class="w-4 h-4 text-text-secondary hidden md:block"></i>
            </button>

            <div id="user-menu" role="menu"
                class="hidden absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-lg border border-slate-100 py-2 z-50">
                <div class="px-4 py-2 border-b border-slate-100 md:hidden">
                    <p class="text-sm font-medium text-text-primary">{{ auth()->user()->name ?? 'Admin User' }}</p>
                    <p class="text-xs text-text-secondary">{{ auth()->user()->email }}</p>
                </div>
                <a href="{{ route('profile.show') }}" role="menuitem"
                    class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 transition-colors">
                    <i data-lucide="user" class="w-4 h-4"></i> Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" role="menuitem"
                        class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-danger hover:bg-danger-light transition-colors text-left">
                        <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleUserMenu() {
        const menu = document.getElementById('user-menu');
        const button = document.getElementById('user-menu-button');
        const isHidden = menu.classList.contains('hidden');
        menu.classList.toggle('hidden', !isHidden);
        button.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
    }

    document.addEventListener('click', function (event) {
        const menu = document.getElementById('user-menu');
        if (!menu) return;
        const isInside = menu.contains(event.target) || document.getElementById('user-menu-button').contains(event.target);
        if (!isInside) {
            menu.classList.add('hidden');
            document.getElementById('user-menu-button').setAttribute('aria-expanded', 'false');
        }
    });
</script>