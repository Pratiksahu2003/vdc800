@php
    $sections = [
        [
            'id' => 'overview',
            'title' => 'Overview',
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
            'id' => 'content',
            'title' => 'Content',
            'collapsible' => true,
            'defaultOpen' => request()->routeIs(
                'admin.content.*',
                'admin.services.*',
                'admin.solutions.*',
                'admin.data-centres.*',
                'admin.blog-*'
            ),
            'groups' => [
                [
                    'label' => 'Pages',
                    'items' => [
                        ['href' => route('admin.content.homepage'), 'label' => 'Homepage', 'icon' => 'home', 'active' => request()->routeIs('admin.content.homepage')],
                        ['href' => route('admin.content.about'), 'label' => 'About us', 'icon' => 'users', 'active' => request()->routeIs('admin.content.about')],
                    ],
                ],
                [
                    'label' => 'Catalog',
                    'items' => [
                        ['href' => route('admin.services.index'), 'label' => 'Services', 'icon' => 'server', 'active' => request()->routeIs('admin.services.*')],
                        ['href' => route('admin.solutions.index'), 'label' => 'Solutions', 'icon' => 'layers', 'active' => request()->routeIs('admin.solutions.*')],
                        ['href' => route('admin.data-centres.index'), 'label' => 'Data centers', 'icon' => 'database', 'active' => request()->routeIs('admin.data-centres.*')],
                    ],
                ],
                [
                    'label' => 'Blog',
                    'items' => [
                        ['href' => route('admin.blog-posts.index'), 'label' => 'Blog posts', 'icon' => 'newspaper', 'active' => request()->routeIs('admin.blog-posts.*')],
                        ['href' => route('admin.blog-categories.index'), 'label' => 'Categories', 'icon' => 'folder-open', 'active' => request()->routeIs('admin.blog-categories.*')],
                    ],
                ],
            ],
        ],
        [
            'id' => 'engagement',
            'title' => 'Engagement',
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
    class="admin-sidebar fixed inset-y-0 left-0 z-50 w-[17.5rem] flex flex-col transform transition-transform duration-200 ease-out lg:translate-x-0"
>
    <div class="admin-sidebar__head">
        <a href="{{ route('admin.dashboard') }}" class="admin-sidebar__brand min-w-0">
            <x-logo :link="false" class="h-7 w-auto brightness-0 invert opacity-95" />
        </a>
        <span class="admin-sidebar__badge">Admin</span>
        <button type="button" @click="sidebarOpen = false" class="admin-sidebar__close lg:hidden" aria-label="Close menu">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>

    <nav
        class="admin-sidebar__nav flex-1 overflow-y-auto overscroll-contain"
        x-data="{ open: @js($initialOpen) }"
        aria-label="Admin navigation"
    >
        @foreach($sections as $section)
            <div class="admin-sidebar__section">
                @if($section['collapsible'] ?? false)
                    <button
                        type="button"
                        class="admin-sidebar__section-toggle"
                        @click="open['{{ $section['id'] }}'] = !open['{{ $section['id'] }}']"
                        :aria-expanded="open['{{ $section['id'] }}']"
                    >
                        <span>{{ $section['title'] }}</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="open['{{ $section['id'] }}'] && 'rotate-180'"></i>
                    </button>
                    <div x-show="open['{{ $section['id'] }}']" x-cloak class="admin-sidebar__section-body">
                        @if(isset($section['groups']))
                            @foreach($section['groups'] as $group)
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
                            @endforeach
                        @else
                            <div class="admin-sidebar__links">
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
            </div>
        @endforeach
    </nav>

    <div class="admin-sidebar__foot">
        <a href="{{ route('home') }}" target="_blank" rel="noopener noreferrer" class="admin-sidebar__foot-link">
            <i data-lucide="external-link" class="w-4 h-4"></i>
            View website
        </a>
        <p class="admin-sidebar__foot-meta">{{ settings('company.company_name') ?? 'D³ DataCenters' }} CMS</p>
    </div>
</aside>

<div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-brand-950/60 backdrop-blur-sm lg:hidden" aria-hidden="true"></div>
