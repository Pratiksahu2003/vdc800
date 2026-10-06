<header class="sticky top-0 z-30 bg-white border-b border-brand-200 lg:pl-72">
    <div class="flex items-center justify-between h-16 px-4 sm:px-6">
        <button @click="sidebarOpen = true" class="lg:hidden p-2 text-brand-600 hover:bg-brand-100 rounded-lg">
            <i data-lucide="menu" class="w-5 h-5"></i>
        </button>

        <div class="flex-1"></div>

        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" target="_blank" class="hidden sm:flex items-center gap-2 px-3 py-2 text-sm text-brand-600 hover:bg-brand-100 rounded-lg transition">
                <i data-lucide="external-link" class="w-4 h-4"></i> View Website
            </a>

            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="flex items-center gap-2 px-3 py-2 text-sm hover:bg-brand-100 rounded-lg">
                    <div class="w-8 h-8 bg-brand-red-500 rounded-full flex items-center justify-center text-white text-xs font-medium">
                        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                    </div>
                    <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                </button>
                <div x-show="open" @click.outside="open = false" x-cloak x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-brand-200 py-1 z-50">
                    <a href="{{ route('admin.profile') }}" class="flex items-center gap-2 px-4 py-2 text-sm hover:bg-brand-50">
                        <i data-lucide="user" class="w-4 h-4"></i> Profile
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            <i data-lucide="log-out" class="w-4 h-4"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
