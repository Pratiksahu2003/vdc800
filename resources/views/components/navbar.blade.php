<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-[100] focus:px-4 focus:py-2 focus:bg-white focus:text-brand-900 focus:shadow-lg">
    Skip to main content
</a>

<nav
    x-data="siteNav"
    data-site-nav
    @keydown.escape.window="closeAllMenus()"
    class="eq-site-nav fixed top-0 left-0 right-0 z-50 transition-[box-shadow,background-color] duration-300"
    :class="{
        'eq-site-nav--scrolled': navScrolled,
        'eq-site-nav--mega-open': activeMenu,
        'eq-site-nav--mobile-open': mobileOpen,
    }"
>
    <div class="eq-site-nav__bar relative z-[52] border-b border-brand-200/80 bg-white/95 backdrop-blur-md supports-[backdrop-filter]:bg-white/90">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-[var(--site-header-height)] gap-3 sm:gap-4">
                <a href="{{ route('home') }}" class="shrink-0 rounded-md focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-teal-600" @click="closeAllMenus()">
                    <x-logo :link="false" class="h-12 sm:h-14 lg:h-16 w-auto max-w-[min(100%,14rem)] sm:max-w-[min(100%,16rem)] lg:max-w-[min(100%,18rem)]" />
                </a>

                <div class="hidden xl:flex items-center flex-1 justify-end gap-0.5 min-w-0">
                    @foreach($navMainItems ?? [] as $item)
                        @php $menuKey = $item->slug ?? 'menu-'.$item->id; @endphp
                        @if($item->activeChildren->isNotEmpty())
                            <div
                                class="relative shrink-0"
                                data-nav-dropdown
                                @mouseenter="openMenu(@js($menuKey))"
                                @focusin="openMenu(@js($menuKey))"
                            >
                                <button
                                    type="button"
                                    class="eq-nav-link"
                                    :class="activeMenu === @js($menuKey) && 'eq-nav-link--active'"
                                    :aria-expanded="activeMenu === @js($menuKey)"
                                    @click="toggleMenu(@js($menuKey))"
                                >
                                    {{ $item->label }}
                                    <i data-lucide="chevron-down" class="w-4 h-4 opacity-70 transition-transform duration-200" :class="activeMenu === @js($menuKey) && 'rotate-180'"></i>
                                </button>
                            </div>
                        @else
                            <a href="{{ $item->resolvedUrl() ?? '#' }}" class="eq-nav-link {{ $item->isActiveRoute() ? 'eq-nav-link--active' : '' }}">
                                {{ $item->label }}
                            </a>
                        @endif
                    @endforeach

                    <div class="w-px h-6 bg-brand-200/90 mx-2 shrink-0" aria-hidden="true"></div>

                    @foreach($navUtilityItems ?? [] as $item)
                        @if($item->is_cta)
                            <a href="{{ $item->resolvedUrl() ?? route('contact.index') }}" class="eq-nav-contact-btn">{{ $item->label }}</a>
                        @else
                            <a href="{{ $item->resolvedUrl() ?? '#' }}" class="eq-nav-link">{{ $item->label }}</a>
                        @endif
                    @endforeach
                </div>

                <button
                    type="button"
                    @click="toggleMobileMenu()"
                    class="xl:hidden eq-nav-mobile-toggle"
                    :aria-expanded="mobileOpen"
                    :aria-label="mobileOpen ? 'Close navigation' : 'Open navigation'"
                >
                    <i data-lucide="menu" class="w-6 h-6" x-show="!mobileOpen"></i>
                    <i data-lucide="x" class="w-6 h-6" x-show="mobileOpen" x-cloak></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Desktop backdrop --}}
    <div
        x-show="activeMenu && !mobileOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="eq-nav-backdrop eq-nav-backdrop--ghost hidden xl:block fixed inset-0 top-[var(--site-header-height)] z-[48]"
        @click="closeMenus()"
        aria-hidden="true"
    ></div>

    {{-- Desktop mega menus --}}
    <div
        class="hidden xl:block absolute left-0 right-0 top-full z-[51] pointer-events-none"
        @mouseleave="closeMenus()"
    >
        <div class="pointer-events-auto eq-nav-mega-bridge">
            @foreach($navMainItems ?? [] as $item)
                @if($item->activeChildren->isNotEmpty())
                    <x-nav-menu-dropdown :item="$item" :menu-key="$item->slug ?? 'menu-'.$item->id" />
                @endif
            @endforeach
        </div>
    </div>

    {{-- Mobile drawer --}}
    <div
        x-show="mobileOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-250"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"
        class="xl:hidden eq-nav-mobile-drawer border-t border-brand-200 bg-white shadow-lg"
    >
        <div class="max-h-[calc(100dvh-var(--site-header-height))] overflow-y-auto overscroll-contain px-4 py-4 sm:px-6">
            @foreach($navMainItems ?? [] as $item)
                @if($item->activeChildren->isNotEmpty())
                    <div x-data="{ open: false }" class="eq-nav-mobile-section">
                        <button
                            type="button"
                            @click="open = !open"
                            class="eq-nav-mobile-section-toggle"
                            :aria-expanded="open"
                        >
                            <span>{{ $item->label }}</span>
                            <i data-lucide="chevron-down" class="w-5 h-5 transition-transform duration-200" :class="open && 'rotate-180'"></i>
                        </button>
                        <div x-show="open" x-cloak x-transition class="eq-nav-mobile-section-body">
                            <x-nav-menu-mobile :item="$item" />
                        </div>
                    </div>
                @else
                    <a href="{{ $item->resolvedUrl() ?? '#' }}" @click="closeAllMenus()" class="eq-nav-mobile-section-link">{{ $item->label }}</a>
                @endif
            @endforeach

            <div class="mt-6 pt-6 border-t border-brand-100 flex flex-col gap-3 pb-8">
                @foreach($navUtilityItems ?? [] as $item)
                    @if($item->is_cta)
                        <a href="{{ $item->resolvedUrl() ?? route('contact.index') }}" class="eq-nav-contact-btn w-full text-center" @click="closeAllMenus()">{{ $item->label }}</a>
                    @elseif($item->resolvedUrl())
                        <a href="{{ $item->resolvedUrl() }}" class="eq-nav-mobile-section-link text-center" @click="closeAllMenus()">{{ $item->label }}</a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</nav>
