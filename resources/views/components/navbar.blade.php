<nav
    x-data="siteNav"
    data-site-nav
    @keydown.escape.window="open = false; closeMenus()"
    @resize.window.debounce.150ms="servicesMenu && positionDropdown($refs.servicesPanel); solutionsMenu && positionDropdown($refs.solutionsPanel); blogMenu && positionDropdown($refs.blogPanel)"
    class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-b border-brand-200/80 shadow-sm transition-[background-color,box-shadow,border-color] duration-300"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-[var(--site-header-height)]">
            <x-logo class="h-14 lg:h-16 w-auto max-w-none shrink-0" />

            <div class="hidden xl:flex items-center gap-4 2xl:gap-6 min-w-0">
                <a href="{{ route('home') }}" class="text-sm font-medium whitespace-nowrap {{ request()->routeIs('home') ? 'text-brand-red-500' : 'text-brand-600 hover:text-brand-teal-600' }} transition">Home</a>

                {{-- Services dropdown --}}
                <div
                    class="relative shrink-0"
                    data-nav-dropdown
                    @mouseenter="openServicesMenu()"
                    @mouseleave="servicesMenu = false"
                    @click.outside="servicesMenu = false"
                    @focusin="openServicesMenu()"
                    @focusout="if (!$el.contains($event.relatedTarget)) servicesMenu = false"
                >
                    <button
                        type="button"
                        @click="openServicesMenu()"
                        class="inline-flex items-center gap-1.5 text-sm font-medium transition whitespace-nowrap"
                        :class="servicesMenu || {{ request()->routeIs('services.*') ? 'true' : 'false' }}
                            ? 'text-brand-red-500'
                            : 'text-brand-600 hover:text-brand-teal-600'"
                        :aria-expanded="servicesMenu"
                    >
                        Services
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="servicesMenu && 'rotate-180'"></i>
                    </button>

                    <x-nav-dropdown-panel show="servicesMenu" panel-ref="servicesPanel" width="compact" :columns="1">
                        @if(($navServicesByCategory ?? collect())->isNotEmpty())
                            @foreach($navServicesByCategory as $category => $categoryServices)
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-brand-900 mb-2 leading-snug">{{ $category }}</p>
                                    <ul class="space-y-1.5">
                                        @foreach($categoryServices as $service)
                                            <li>
                                                <a
                                                    href="{{ route('services.show', $service) }}"
                                                    @click="servicesMenu = false"
                                                    class="block text-sm text-brand-500 hover:text-brand-teal-600 transition leading-snug"
                                                >
                                                    {{ $service->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @else
                            <p class="text-sm text-brand-500">No services published yet.</p>
                        @endif

                        <x-slot:footer>
                            <a
                                href="{{ route('services.index') }}"
                                @click="servicesMenu = false"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600 transition group"
                            >
                                View All Services
                                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform"></i>
                            </a>
                        </x-slot:footer>
                    </x-nav-dropdown-panel>
                </div>

                @if(($navSolutionsByCategory ?? collect())->isNotEmpty())
                {{-- Solutions dropdown --}}
                <div
                    class="relative shrink-0"
                    data-nav-dropdown
                    @mouseenter="openSolutionsMenu()"
                    @mouseleave="solutionsMenu = false"
                    @click.outside="solutionsMenu = false"
                    @focusin="openSolutionsMenu()"
                    @focusout="if (!$el.contains($event.relatedTarget)) solutionsMenu = false"
                >
                    <button
                        type="button"
                        @click="openSolutionsMenu()"
                        class="inline-flex items-center gap-1.5 text-sm font-medium transition whitespace-nowrap"
                        :class="solutionsMenu || {{ request()->routeIs('solutions.*') ? 'true' : 'false' }}
                            ? 'text-brand-red-500'
                            : 'text-brand-600 hover:text-brand-teal-600'"
                        :aria-expanded="solutionsMenu"
                    >
                        Solutions
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="solutionsMenu && 'rotate-180'"></i>
                    </button>

                    <x-nav-dropdown-panel show="solutionsMenu" panel-ref="solutionsPanel" width="wide" :columns="3">
                        @if(($navSolutionsByCategory ?? collect())->isNotEmpty())
                            @foreach($navSolutionsByCategory as $category => $categorySolutions)
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-brand-900 mb-2 leading-snug">{{ $category }}</p>
                                    <ul class="space-y-1.5">
                                        @foreach($categorySolutions as $solution)
                                            <li>
                                                <a
                                                    href="{{ route('solutions.show', $solution) }}"
                                                    @click="solutionsMenu = false"
                                                    class="block text-sm text-brand-500 hover:text-brand-teal-600 transition leading-snug"
                                                >
                                                    {{ $solution->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @endif

                        <x-slot:footer>
                            <a
                                href="{{ route('solutions.index') }}"
                                @click="solutionsMenu = false"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600 transition group"
                            >
                                View All Solutions
                                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform"></i>
                            </a>
                        </x-slot:footer>
                    </x-nav-dropdown-panel>
                </div>
                @endif

                @if(($navBlogByCategory ?? collect())->isNotEmpty())
                {{-- Blog dropdown --}}
                <div
                    class="relative shrink-0"
                    data-nav-dropdown
                    @mouseenter="openBlogMenu()"
                    @mouseleave="blogMenu = false"
                    @click.outside="blogMenu = false"
                    @focusin="openBlogMenu()"
                    @focusout="if (!$el.contains($event.relatedTarget)) blogMenu = false"
                >
                    <button
                        type="button"
                        @click="openBlogMenu()"
                        class="inline-flex items-center gap-1.5 text-sm font-medium transition whitespace-nowrap"
                        :class="blogMenu || {{ request()->routeIs('blog.*') ? 'true' : 'false' }}
                            ? 'text-brand-red-500'
                            : 'text-brand-600 hover:text-brand-teal-600'"
                        :aria-expanded="blogMenu"
                    >
                        Blog
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="blogMenu && 'rotate-180'"></i>
                    </button>

                    <x-nav-dropdown-panel show="blogMenu" panel-ref="blogPanel" width="wide" :columns="3">
                        @if(($navBlogByCategory ?? collect())->isNotEmpty())
                            @foreach($navBlogByCategory as $group)
                                <div class="min-w-0">
                                    <a
                                        href="{{ route('blog.index', ['category' => $group['slug']]) }}"
                                        @click="blogMenu = false"
                                        class="text-sm font-bold text-brand-900 mb-2 leading-snug hover:text-brand-teal-700 transition block"
                                    >
                                        {{ $group['name'] }}
                                    </a>
                                    <ul class="space-y-1.5">
                                        @foreach($group['posts'] as $post)
                                            <li>
                                                <a
                                                    href="{{ route('blog.show', $post) }}"
                                                    @click="blogMenu = false"
                                                    class="block text-sm text-brand-500 hover:text-brand-teal-600 transition leading-snug"
                                                >
                                                    {{ $post->title }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @endif

                        <x-slot:footer>
                            <a
                                href="{{ route('blog.index') }}"
                                @click="blogMenu = false"
                                class="inline-flex items-center gap-2 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600 transition group"
                            >
                                View All Articles
                                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-0.5 transition-transform"></i>
                            </a>
                        </x-slot:footer>
                    </x-nav-dropdown-panel>
                </div>
                @endif

                <a href="{{ route('data-centre.index') }}" class="text-sm font-medium whitespace-nowrap {{ request()->routeIs('data-centre.*') ? 'text-brand-red-500' : 'text-brand-600 hover:text-brand-teal-600' }} transition">Projects</a>
                <a href="{{ route('about.index') }}" class="text-sm font-medium whitespace-nowrap {{ request()->routeIs('about.*') ? 'text-brand-red-500' : 'text-brand-600 hover:text-brand-teal-600' }} transition">About</a>
                <a href="{{ route('contact.index') }}" class="px-4 2xl:px-5 py-2.5 bg-brand-red-500 text-white text-sm font-semibold rounded-sm hover:bg-brand-red-600 transition shadow-sm whitespace-nowrap shrink-0">Contact</a>
            </div>

            <button @click="open = !open" class="xl:hidden p-2 text-brand-700" aria-label="Toggle menu">
                <i data-lucide="menu" class="w-6 h-6" x-show="!open"></i>
                <i data-lucide="x" class="w-6 h-6" x-show="open" x-cloak></i>
            </button>
        </div>
    </div>

    <div x-show="open" x-cloak x-transition class="xl:hidden fixed inset-0 top-[var(--site-header-height)] bg-brand-900/30 backdrop-blur-sm z-40" @click="open = false"></div>
    <div x-show="open" x-cloak x-transition class="xl:hidden absolute top-full left-0 right-0 bg-white border-b border-brand-200 shadow-lg z-50 max-h-[calc(100vh-var(--site-header-height))] overflow-y-auto overscroll-contain">
        <div class="px-4 py-6 space-y-1">
            <a href="{{ route('home') }}" class="block text-brand-700 font-medium py-2.5 hover:text-brand-red-500">Home</a>

            {{-- Mobile Services --}}
            <div class="border-b border-brand-100 pb-2">
                <button
                    type="button"
                    @click="mobileSolutionsOpen = false; mobileBlogOpen = false; mobileServicesOpen = !mobileServicesOpen"
                    class="flex w-full items-center justify-between text-brand-700 font-medium py-2.5 hover:text-brand-red-500"
                >
                    <span>Services</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="mobileServicesOpen && 'rotate-180'"></i>
                </button>
                <div x-show="mobileServicesOpen" x-cloak x-transition class="mt-2 space-y-4 pl-1">
                    @forelse($navServicesByCategory ?? [] as $category => $categoryServices)
                        <div>
                            <p class="text-xs font-bold text-brand-900 uppercase tracking-wide mb-2">{{ $category }}</p>
                            <div class="space-y-1.5 pl-2 border-l-2 border-brand-teal-100">
                                @foreach($categoryServices as $service)
                                    <a href="{{ route('services.show', $service) }}" @click="open = false" class="block text-sm text-brand-600 py-0.5 hover:text-brand-teal-600">
                                        {{ $service->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p class="text-sm text-brand-500">No services published yet.</p>
                    @endforelse
                    <a href="{{ route('services.index') }}" @click="open = false" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 pt-1">
                        View All Services <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>

            @if(($navSolutionsByCategory ?? collect())->isNotEmpty())
            {{-- Mobile Solutions --}}
            <div class="border-b border-brand-100 pb-2">
                <button
                    type="button"
                    @click="mobileServicesOpen = false; mobileBlogOpen = false; mobileSolutionsOpen = !mobileSolutionsOpen"
                    class="flex w-full items-center justify-between text-brand-700 font-medium py-2.5 hover:text-brand-red-500"
                >
                    <span>Solutions</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="mobileSolutionsOpen && 'rotate-180'"></i>
                </button>
                <div x-show="mobileSolutionsOpen" x-cloak x-transition class="mt-2 space-y-4 pl-1">
                    @forelse($navSolutionsByCategory ?? [] as $category => $categorySolutions)
                        <div>
                            <p class="text-xs font-bold text-brand-900 uppercase tracking-wide mb-2">{{ $category }}</p>
                            <div class="space-y-1.5 pl-2 border-l-2 border-brand-teal-100">
                                @foreach($categorySolutions as $solution)
                                    <a href="{{ route('solutions.show', $solution) }}" @click="open = false" class="block text-sm text-brand-600 py-0.5 hover:text-brand-teal-600">
                                        {{ $solution->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforelse
                    <a href="{{ route('solutions.index') }}" @click="open = false" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 pt-1">
                        View All Solutions <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
            @endif

            @if(($navBlogByCategory ?? collect())->isNotEmpty())
            {{-- Mobile Blog --}}
            <div class="border-b border-brand-100 pb-2">
                <button
                    type="button"
                    @click="mobileServicesOpen = false; mobileSolutionsOpen = false; mobileBlogOpen = !mobileBlogOpen"
                    class="flex w-full items-center justify-between text-brand-700 font-medium py-2.5 hover:text-brand-red-500"
                >
                    <span>Blog</span>
                    <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="mobileBlogOpen && 'rotate-180'"></i>
                </button>
                <div x-show="mobileBlogOpen" x-cloak x-transition class="mt-2 space-y-4 pl-1">
                    @forelse($navBlogByCategory ?? [] as $group)
                        <div>
                            <a href="{{ route('blog.index', ['category' => $group['slug']]) }}" @click="open = false" class="text-xs font-bold text-brand-900 uppercase tracking-wide mb-2 block hover:text-brand-teal-700">
                                {{ $group['name'] }}
                            </a>
                            <div class="space-y-1.5 pl-2 border-l-2 border-brand-teal-100">
                                @foreach($group['posts'] as $post)
                                    <a href="{{ route('blog.show', $post) }}" @click="open = false" class="block text-sm text-brand-600 py-0.5 hover:text-brand-teal-600">
                                        {{ $post->title }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endforelse
                    <a href="{{ route('blog.index') }}" @click="open = false" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-red-500 pt-1">
                        View All Articles <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                    </a>
                </div>
            </div>
            @endif

            <a href="{{ route('data-centre.index') }}" class="block text-brand-700 font-medium py-2.5 hover:text-brand-red-500">Projects</a>
            <a href="{{ route('about.index') }}" class="block text-brand-700 font-medium py-2.5 hover:text-brand-red-500">About</a>
            <a href="{{ route('contact.index') }}" class="block text-center mt-4 px-5 py-3 bg-brand-red-500 text-white font-semibold rounded-sm">Contact</a>
        </div>
    </div>
</nav>
