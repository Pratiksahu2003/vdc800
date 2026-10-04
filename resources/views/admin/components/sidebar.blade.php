@php
    $sections = [
        [
            'id' => 'overview',
            'title' => 'Overview',
            'icon' => 'layout-grid',
            'collapsible' => false,
            'items' => [
                [
                    'href' => route('admin.dashboard'),
                    'label' => 'Dashboard',
                    'icon' => 'layout-dashboard',
                    'active' => request()->routeIs('admin.dashboard'),
                ],
            ],
        ],
        [
            'id' => 'settings',
            'title' => 'Site settings',
            'icon' => 'settings',
            'collapsible' => true,
            'defaultOpen' => request()->routeIs('admin.settings.*'),
            'items' => [
                ['href' => route('admin.settings.company'), 'label' => 'Company', 'icon' => 'building-2', 'active' => request()->routeIs('admin.settings.company')],
                ['href' => route('admin.settings.branding'), 'label' => 'Branding', 'icon' => 'palette', 'active' => request()->routeIs('admin.settings.branding')],
                ['href' => route('admin.settings.website'), 'label' => 'Website SEO', 'icon' => 'globe', 'active' => request()->routeIs('admin.settings.website')],
                ['href' => route('admin.settings.social-links'), 'label' => 'Social links', 'icon' => 'share-2', 'active' => request()->routeIs('admin.settings.social-links')],
            ],
        ],
        [
            'id' => 'pages',
            'title' => 'Pages',
            'icon' => 'file-text',
            'collapsible' => true,
            'defaultOpen' => request()->routeIs('admin.content.*'),
            'items' => [
                ['href' => route('admin.content.homepage'), 'label' => 'Homepage', 'icon' => 'home', 'active' => request()->routeIs('admin.content.homepage')],
                ['href' => route('admin.content.about'), 'label' => 'About us', 'icon' => 'users', 'active' => request()->routeIs('admin.content.about')],
            ],
        ],
        [
            'id' => 'catalog',
            'title' => 'Catalog',
            'icon' => 'layers',
            'collapsible' => true,
            'defaultOpen' => request()->routeIs('admin.services.*', 'admin.solutions.*', 'admin.data-centres.*'),
            'items' => [
                ['href' => route('admin.services.index'), 'label' => 'Services', 'icon' => 'server', 'active' => request()->routeIs('admin.services.*')],
                ['href' => route('admin.solutions.index'), 'label' => 'Solutions', 'icon' => 'box', 'active' => request()->routeIs('admin.solutions.*')],
                ['href' => route('admin.data-centres.index'), 'label' => 'Data centers', 'icon' => 'database', 'active' => request()->routeIs('admin.data-centres.*')],
            ],
        ],
        [
            'id' => 'blog',
            'title' => 'Blog',
            'icon' => 'newspaper',
            'collapsible' => true,
            'defaultOpen' => request()->routeIs('admin.blog-*'),
            'items' => [
                ['href' => route('admin.blog-posts.index'), 'label' => 'Blog posts', 'icon' => 'file-text', 'active' => request()->routeIs('admin.blog-posts.*')],
                ['href' => route('admin.blog-categories.index'), 'label' => 'Categories', 'icon' => 'folder-open', 'active' => request()->routeIs('admin.blog-categories.*')],
            ],
        ],
        [
            'id' => 'engagement',
            'title' => 'Engagement',
            'icon' => 'message-square',
            'collapsible' => false,
            'items' => [
                [
                    'href' => route('admin.contact-submissions.index'),
                    'label' => 'Contact submissions',
                    'icon' => 'inbox',
                    'active' => request()->routeIs('admin.contact-submissions.*'),
                ],
            ],
        ],
        [
            'id' => 'system',
            'title' => 'System',
            'icon' => 'wrench',
            'collapsible' => false,
            'items' => [
                ['href' => route('admin.media.index'), 'label' => 'Media library', 'icon' => 'image', 'active' => request()->routeIs('admin.media.*')],
                ['href' => route('admin.profile'), 'label' => 'Profile', 'icon' => 'user-circle', 'active' => request()->routeIs('admin.profile')],
            ],
        ],
    ];

    $initialOpen = collect($sections)
        ->filter(fn ($s) => $s['collapsible'] ?? false)
        ->mapWithKeys(fn ($s) => [$s['id'] => $s['defaultOpen'] ?? false])
        ->all();
@endphp

<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="admin-sidebar fixed inset-y-0 left-0 z-50 flex flex-col transform transition-transform duration-200 ease-out lg:translate-x-0"
    x-data="{
        query: '',
        open: @js($initialOpen),
        init() {
            this.$watch('query', (value) => {
                if (! value.trim()) return;
                Object.keys(this.open).forEach((key) => { this.open[key] = true; });
            });
        },
        navItemVisible(label) {
            if (! this.query.trim()) return true;
            return label.includes(this.query.trim().toLowerCase());
        },
        hasVisibleNav() {
            if (! this.query.trim()) return true;
            return [...this.$el.querySelectorAll('.admin-nav-link')].some((el) => el.offsetParent !== null);
        },
    }"
>
    <div class="admin-sidebar__head">
        <a href="{{ route('admin.dashboard') }}" class="admin-sidebar__brand">
            <x-logo :link="false" class="h-8 w-auto max-w-[140px]" />
        </a>
        <button type="button" @click="sidebarOpen = false" class="admin-sidebar__close lg:hidden" aria-label="Close menu">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>

    <div class="admin-sidebar__search-wrap">
        <label class="sr-only" for="admin-nav-search">Search menu</label>
        <div class="admin-sidebar__search">
            <i data-lucide="search" class="w-4 h-4 shrink-0 text-brand-400"></i>
            <input
                id="admin-nav-search"
                type="search"
                x-model="query"
                placeholder="Search modules..."
                class="admin-sidebar__search-input"
                autocomplete="off"
            />
            <button type="button" x-show="query.length" x-cloak @click="query = ''" class="admin-sidebar__search-clear" aria-label="Clear search">
                <i data-lucide="x" class="w-3.5 h-3.5"></i>
            </button>
        </div>
    </div>

    <nav class="admin-sidebar__nav flex-1 overflow-y-auto overscroll-contain" aria-label="Admin navigation">
        @foreach($sections as $section)
            <div class="admin-sidebar__section">
                @if($section['collapsible'] ?? false)
                    <button
                        type="button"
                        class="admin-sidebar__module"
                        @click="open['{{ $section['id'] }}'] = !open['{{ $section['id'] }}']"
                        :aria-expanded="open['{{ $section['id'] }}']"
                    >
                        <span class="admin-sidebar__module-icon">
                            <i data-lucide="{{ $section['icon'] ?? 'folder' }}" class="w-4 h-4"></i>
                        </span>
                        <span class="admin-sidebar__module-title">{{ $section['title'] }}</span>
                        <i data-lucide="chevron-down" class="admin-sidebar__module-chevron" :class="open['{{ $section['id'] }}'] && 'is-open'"></i>
                    </button>
                    <div x-show="open['{{ $section['id'] }}']" x-cloak class="admin-sidebar__module-body">
                        @if(isset($section['groups']))
                            @foreach($section['groups'] as $group)
                                <div class="admin-sidebar__subgroup">
                                    <p class="admin-sidebar__group-label">{{ $group['label'] }}</p>
                                    <div class="admin-sidebar__links">
                                        @foreach($group['items'] as $item)
                                            <x-admin.nav-link
                                                :href="$item['href']"
                                                :icon="$item['icon']"
                                                :label="$item['label']"
                                                :active="$item['active']"
                                                nested
                                            />
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="admin-sidebar__links admin-sidebar__links--nested">
                                @foreach($section['items'] as $item)
                                    <x-admin.nav-link
                                        :href="$item['href']"
                                        :icon="$item['icon']"
                                        :label="$item['label']"
                                        :active="$item['active']"
                                        nested
                                    />
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    @if(count($section['items']) === 1 && ($section['id'] ?? '') === 'overview')
                        <div class="admin-sidebar__links">
                            @foreach($section['items'] as $item)
                                <x-admin.nav-link
                                    :href="$item['href']"
                                    :icon="$item['icon']"
                                    :label="$item['label']"
                                    :active="$item['active']"
                                />
                            @endforeach
                        </div>
                    @else
                        <p class="admin-sidebar__section-label">{{ $section['title'] }}</p>
                        <div class="admin-sidebar__links">
                            @foreach($section['items'] as $item)
                                <x-admin.nav-link
                                    :href="$item['href']"
                                    :icon="$item['icon']"
                                    :label="$item['label']"
                                    :active="$item['active']"
                                />
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>
        @endforeach

        <p x-show="query.trim() && !hasVisibleNav()" x-cloak class="admin-sidebar__empty">
            No modules match your search.
        </p>
    </nav>

    <div class="admin-sidebar__foot">
        <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="admin-sidebar__foot-link">
            <i data-lucide="external-link" class="w-4 h-4"></i>
            View website
        </a>
        <p class="admin-sidebar__foot-meta">{{ settings('company.short_name') ?? 'D³' }} · Content Manager</p>
    </div>
</aside>

<div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="admin-sidebar__backdrop lg:hidden" aria-hidden="true"></div>
