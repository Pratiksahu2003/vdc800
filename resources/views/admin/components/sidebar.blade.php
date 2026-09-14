<aside
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-72 bg-white text-brand-700 border-r border-brand-200 shadow-sm transform transition-transform duration-200 ease-in-out lg:translate-x-0 flex flex-col"
>
    <div class="flex items-center justify-between h-16 px-4 border-b border-brand-200 bg-white">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 min-w-0">
            <x-logo :link="false" class="h-7 w-auto" />
        </a>
        <button @click="sidebarOpen = false" class="lg:hidden text-brand-500 hover:text-brand-900 shrink-0">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>

    @php
        $navLink = fn (bool $active, string $activeStyle = 'teal') => $active
            ? ($activeStyle === 'red' ? 'bg-brand-red-50 text-brand-red-600 font-medium' : 'bg-brand-teal-50 text-brand-teal-700 font-medium')
            : 'text-brand-600 hover:bg-brand-50 hover:text-brand-900';
    @endphp

    <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-6" x-data="{ website: {{ request()->routeIs('admin.settings.*') ? 'true' : 'false' }}, content: {{ request()->routeIs('admin.content.*', 'admin.services.*', 'admin.solutions.*', 'admin.data-centres.*', 'admin.blog-*') ? 'true' : 'false' }} }">
        <div>
            <p class="px-3 text-xs font-semibold text-brand-teal-600 uppercase tracking-wider mb-2">Main</p>
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $navLink(request()->routeIs('admin.dashboard'), 'red') }}">
                <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
            </a>
        </div>

        <div>
            <button @click="website = !website" class="flex items-center justify-between w-full px-3 text-xs font-semibold text-brand-teal-600 uppercase tracking-wider mb-2">
                Website <i data-lucide="chevron-down" class="w-3 h-3 transition-transform" :class="website && 'rotate-180'"></i>
            </button>
            <div x-show="website" class="space-y-1">
                <a href="{{ route('admin.settings.company') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $navLink(request()->routeIs('admin.settings.company')) }}">
                    <i data-lucide="building-2" class="w-4 h-4"></i> Company
                </a>
                <a href="{{ route('admin.settings.branding') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $navLink(request()->routeIs('admin.settings.branding')) }}">
                    <i data-lucide="palette" class="w-4 h-4"></i> Branding
                </a>
                <a href="{{ route('admin.settings.website') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $navLink(request()->routeIs('admin.settings.website')) }}">
                    <i data-lucide="globe" class="w-4 h-4"></i> Website SEO
                </a>
                <a href="{{ route('admin.settings.social-links') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $navLink(request()->routeIs('admin.settings.social-links')) }}">
                    <i data-lucide="share-2" class="w-4 h-4"></i> Social Links
                </a>
            </div>
        </div>

        <div>
            <button @click="content = !content" class="flex items-center justify-between w-full px-3 text-xs font-semibold text-brand-teal-600 uppercase tracking-wider mb-2">
                Content <i data-lucide="chevron-down" class="w-3 h-3 transition-transform" :class="content && 'rotate-180'"></i>
            </button>
            <div x-show="content" class="space-y-1">
                <a href="{{ route('admin.content.homepage') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $navLink(request()->routeIs('admin.content.homepage')) }}">
                    <i data-lucide="home" class="w-4 h-4"></i> Homepage
                </a>
                <a href="{{ route('admin.services.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $navLink(request()->routeIs('admin.services.*')) }}">
                    <i data-lucide="server" class="w-4 h-4"></i> Services
                </a>
                <a href="{{ route('admin.solutions.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $navLink(request()->routeIs('admin.solutions.*')) }}">
                    <i data-lucide="layers" class="w-4 h-4"></i> Solutions
                </a>
                <a href="{{ route('admin.data-centres.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $navLink(request()->routeIs('admin.data-centres.*')) }}">
                    <i data-lucide="database" class="w-4 h-4"></i> Projects
                </a>
                <a href="{{ route('admin.content.about') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $navLink(request()->routeIs('admin.content.about')) }}">
                    <i data-lucide="users" class="w-4 h-4"></i> About Us
                </a>
                <a href="{{ route('admin.blog-posts.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $navLink(request()->routeIs('admin.blog-posts.*')) }}">
                    <i data-lucide="newspaper" class="w-4 h-4"></i> Blog Posts
                </a>
                <a href="{{ route('admin.blog-categories.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $navLink(request()->routeIs('admin.blog-categories.*')) }}">
                    <i data-lucide="folder-open" class="w-4 h-4"></i> Blog Categories
                </a>
            </div>
        </div>

        <div>
            <p class="px-3 text-xs font-semibold text-brand-teal-600 uppercase tracking-wider mb-2">Leads</p>
            <a href="{{ route('admin.contact-submissions.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $navLink(request()->routeIs('admin.contact-submissions.*'), 'red') }}">
                <i data-lucide="mail" class="w-4 h-4"></i> Contact Submissions
            </a>
        </div>

        <div>
            <p class="px-3 text-xs font-semibold text-brand-teal-600 uppercase tracking-wider mb-2">System</p>
            <a href="{{ route('admin.media.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $navLink(request()->routeIs('admin.media.*')) }}">
                <i data-lucide="image" class="w-4 h-4"></i> Media
            </a>
            <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm {{ $navLink(request()->routeIs('admin.profile')) }}">
                <i data-lucide="user" class="w-4 h-4"></i> Profile
            </a>
        </div>
    </nav>

    <div class="p-4 border-t border-brand-200 bg-brand-50/50">
        <p class="text-xs text-brand-500 text-center">VDC800 CMS</p>
    </div>
</aside>

<div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-black/30 z-40 lg:hidden"></div>
