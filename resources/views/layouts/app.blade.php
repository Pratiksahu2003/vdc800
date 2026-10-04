<!DOCTYPE html>
<html lang="{{ settings('website.default_language') ?? 'en' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#8cc63f">
    <title>@yield('title', seo_title(null))</title>
    <meta name="description" content="@yield('meta_description', seo_description(null))">
    <meta name="keywords" content="@yield('meta_keywords', seo_keywords())">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">
    <meta property="og:site_name" content="{{ settings('website.website_name') ?? settings('company.company_name') ?? 'D³ DataCenters' }}">
    <meta property="og:title" content="@yield('title', seo_title(null))">
    <meta property="og:description" content="@yield('meta_description', seo_description(null))">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:url" content="@yield('canonical_url', url()->current())">
    <meta property="og:locale" content="{{ str_replace('_', '-', settings('website.default_language') ?? 'en') }}">
    <meta property="og:image" content="@yield('og_image', settings('website.og_image') ? setting_url(settings('website.og_image')) : logo_url())">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', seo_title(null))">
    <meta name="twitter:description" content="@yield('meta_description', seo_description(null))">
    <meta name="twitter:image" content="@yield('og_image', settings('website.og_image') ? setting_url(settings('website.og_image')) : logo_url())">
    @include('components.favicon')
    @if(settings('website.google_tag_manager_id'))
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{{ settings('website.google_tag_manager_id') }}');</script>
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,300;0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;1,14..32,400&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,600;0,9..40,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="equinix-public font-sans bg-white text-brand-900 antialiased overflow-x-hidden">
    @if(settings('website.google_tag_manager_id'))
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ settings('website.google_tag_manager_id') }}" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    @endif

    @include('components.navbar')

    <main id="main-content" data-public-ui class="@yield('main_class', 'site-main')">@yield('content')</main>

    @include('components.footer')

    <a href="{{ route('contact.index') }}" class="eq-chat-fab" aria-label="Contact us">
        <i data-lucide="message-circle" class="w-5 h-5"></i>
        <span class="hidden sm:inline text-sm font-semibold">Let&rsquo;s chat</span>
    </a>

    <div x-data="{ show: !localStorage.getItem('cookie_accepted') }" x-show="show" x-cloak @show-cookie-notice.window="show = true" class="fixed inset-x-0 bottom-0 z-50 p-4 sm:p-6 pointer-events-none">
        <div class="eq-cookie-sheet pointer-events-auto max-w-4xl mx-auto p-6 lg:p-8 flex flex-col lg:flex-row lg:items-end gap-6">
            <div class="flex-1 min-w-0">
                <p class="text-lg font-bold text-brand-900 mb-2">Your choices regarding cookies on this site</p>
                <p class="text-sm text-brand-600 leading-relaxed">We use cookies to improve your experience, analyse traffic, and support secure website functionality. See our <a href="{{ route('legal.cookies') }}" class="text-brand-teal-700 underline underline-offset-2">Cookie Policy</a>.</p>
            </div>
            <div class="flex flex-wrap gap-3 shrink-0">
                <button @click="show=false" class="eq-btn-outline px-5">Privacy settings</button>
                <button @click="localStorage.setItem('cookie_accepted','1'); show=false" class="eq-btn-primary px-5">Agree to all</button>
                <button @click="show=false" class="eq-btn-primary px-5 bg-brand-950 hover:bg-brand-900">Reject all</button>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
