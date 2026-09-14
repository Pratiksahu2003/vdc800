<footer class="bg-white border-t border-brand-200" data-site-footer>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        {{-- Brand + CTA --}}
        <div class="pb-10 lg:pb-12 border-b border-brand-100">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-stretch" data-footer-brand>
                <div class="min-w-0 flex flex-col h-full">
                    <x-logo class="h-12 lg:h-14 w-auto max-w-none mb-4" />
                    <p class="text-brand-teal-600 font-medium text-sm lg:text-base">{{ settings('company.tagline') ?? 'IS FUTURE OF DCs' }}</p>
                    <p class="text-brand-500 text-sm lg:text-base mt-2 max-w-lg leading-relaxed">{{ Str::limit(settings('company.description'), 180) }}</p>
                    @if(count(settings('social_links') ?? []) > 0)
                        <div class="flex flex-wrap gap-2 mt-5">
                            @foreach(settings('social_links') ?? [] as $link)
                                @if($link['is_active'] ?? false)
                                    <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" title="{{ $link['platform'] }}"
                                        class="w-8 h-8 rounded-full border border-brand-200 flex items-center justify-center text-brand-600 hover:text-brand-teal-600 hover:border-brand-teal-300 hover:bg-brand-teal-50 transition">
                                        <x-social-icon :name="$link['icon'] ?? $link['platform'] ?? 'link'" class="w-3.5 h-3.5" />
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-8 grid grid-cols-2 gap-3 flex-1 content-start">
                        @foreach([
                            ['icon' => 'activity', 'title' => '24/7 NOC', 'desc' => 'Always-on operations support'],
                            ['icon' => 'shield-check', 'title' => 'Tier III+ Design', 'desc' => 'Enterprise-grade infrastructure'],
                            ['icon' => 'compass', 'title' => 'Advisory Expertise', 'desc' => 'Strategy through delivery'],
                            ['icon' => 'zap', 'title' => '99.999% Uptime', 'desc' => 'Mission-critical reliability'],
                        ] as $highlight)
                            <div class="rounded-xl border border-brand-200 bg-brand-50/60 p-3.5 h-full hover:border-brand-teal-200 hover:bg-brand-teal-50/30 transition">
                                <div class="w-8 h-8 rounded-lg bg-brand-teal-100 flex items-center justify-center mb-2.5">
                                    <i data-lucide="{{ $highlight['icon'] }}" class="w-4 h-4 text-brand-teal-700"></i>
                                </div>
                                <p class="text-sm font-semibold text-brand-900 leading-snug">{{ $highlight['title'] }}</p>
                                <p class="text-xs text-brand-500 mt-0.5 leading-relaxed">{{ $highlight['desc'] }}</p>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-6 pt-2 flex flex-wrap gap-2 lg:mt-auto">
                        <a href="{{ route('services.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full border border-brand-200 bg-white text-xs font-medium text-brand-700 hover:border-brand-teal-300 hover:text-brand-teal-700 transition">
                            <i data-lucide="briefcase" class="w-3.5 h-3.5"></i>
                            Our Services
                        </a>
                        <a href="{{ route('data-centre.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full border border-brand-200 bg-white text-xs font-medium text-brand-700 hover:border-brand-teal-300 hover:text-brand-teal-700 transition">
                            <i data-lucide="server" class="w-3.5 h-3.5"></i>
                            Data Centre
                        </a>
                        <a href="{{ route('about.index') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-full border border-brand-200 bg-white text-xs font-medium text-brand-700 hover:border-brand-teal-300 hover:text-brand-teal-700 transition">
                            <i data-lucide="building-2" class="w-3.5 h-3.5"></i>
                            About Us
                        </a>
                    </div>
                </div>

                <div class="rounded-2xl border border-brand-200 bg-gradient-to-br from-brand-50 via-white to-brand-teal-50/40 p-6 lg:p-8 shadow-sm h-full flex flex-col">
                    <p class="text-brand-teal-600 text-xs font-semibold uppercase tracking-widest mb-2">Get in Touch</p>
                    <h3 class="font-display text-xl lg:text-2xl text-brand-900 mb-3 leading-snug">
                        Have an infrastructure decision to make?
                    </h3>
                    <p class="text-brand-600 text-sm leading-relaxed mb-5">
                        Whether you need advisory support, technical assessment, or capacity planning — tell us what you are planning and we will help identify the next step.
                    </p>

                    <ul class="space-y-2.5 mb-6">
                        @if(settings('company.email'))
                            <li class="flex items-center gap-2.5 text-sm">
                                <span class="w-8 h-8 rounded-lg bg-brand-teal-100 flex items-center justify-center shrink-0">
                                    <i data-lucide="mail" class="w-4 h-4 text-brand-teal-700"></i>
                                </span>
                                <a href="mailto:{{ settings('company.email') }}" class="text-brand-700 hover:text-brand-teal-700 transition break-all">{{ settings('company.email') }}</a>
                            </li>
                        @endif
                        @if(settings('company.phone'))
                            <li class="flex items-center gap-2.5 text-sm">
                                <span class="w-8 h-8 rounded-lg bg-brand-teal-100 flex items-center justify-center shrink-0">
                                    <i data-lucide="phone" class="w-4 h-4 text-brand-teal-700"></i>
                                </span>
                                <a href="tel:{{ preg_replace('/\s+/', '', settings('company.phone')) }}" class="text-brand-700 hover:text-brand-teal-700 transition">{{ settings('company.phone') }}</a>
                            </li>
                        @endif
                        @if(settings('company.city') || settings('company.country'))
                            <li class="flex items-center gap-2.5 text-sm">
                                <span class="w-8 h-8 rounded-lg bg-brand-teal-100 flex items-center justify-center shrink-0">
                                    <i data-lucide="map-pin" class="w-4 h-4 text-brand-teal-700"></i>
                                </span>
                                <span class="text-brand-600">
                                    {{ collect([settings('company.city'), settings('company.country')])->filter()->join(', ') }}
                                </span>
                            </li>
                        @endif
                    </ul>

                    <div class="flex flex-wrap gap-2 mb-5">
                        @foreach(['Strategy', 'Investment', 'Engineering', 'Procurement'] as $tag)
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-white border border-brand-200 text-xs font-medium text-brand-700">
                                {{ $tag }}
                            </span>
                        @endforeach
                    </div>

                    <div class="flex-1 rounded-xl border border-brand-200/80 bg-white/80 p-4 lg:p-5 mb-5">
                        <p class="text-xs font-semibold uppercase tracking-wide text-brand-teal-700 mb-3">What we can help with</p>
                        <ul class="space-y-2.5">
                            @foreach([
                                'Data center strategy, feasibility & site evaluation',
                                'Investment analysis & technical due diligence',
                            ] as $topic)
                                <li class="flex items-start gap-2.5 text-sm text-brand-600 leading-snug">
                                    <i data-lucide="check" class="w-4 h-4 text-brand-teal-600 shrink-0 mt-0.5"></i>
                                    <span>{{ $topic }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <p class="flex items-center gap-2 mt-4 pt-4 border-t border-brand-100 text-xs text-brand-500">
                            <i data-lucide="clock" class="w-3.5 h-3.5 text-brand-teal-600 shrink-0"></i>
                            We typically respond within one business day.
                        </p>
                    </div>

                    <div class="mt-auto pt-2 border-t border-brand-200/80">
                    <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center gap-2 w-full px-6 py-3 bg-brand-red-500 hover:bg-brand-red-600 text-white text-sm font-semibold rounded-full transition shadow-sm">
                        Start a Conversation
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Link columns --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-10 pt-10 lg:pt-12" data-footer-links>
            <div>
                <h4 class="text-brand-900 font-bold text-sm lg:text-base mb-3">Company</h4>
                <ul class="space-y-2">
                    @foreach([
                        ['label' => 'Home', 'url' => route('home')],
                        ['label' => 'About Us', 'url' => route('about.index')],
                        ['label' => 'Our Data Centre', 'url' => route('data-centre.index')],
                        ['label' => 'Blog', 'url' => route('blog.index')],
                        ['label' => 'Contact Us', 'url' => route('contact.index')],
                        ['label' => 'All Services', 'url' => route('services.index')],
                        ['label' => 'All Solutions', 'url' => route('solutions.index')],
                    ] as $item)
                        <li>
                            <a href="{{ $item['url'] }}" class="text-sm text-brand-600 hover:text-brand-red-500 transition">{{ $item['label'] }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div>
                <h4 class="text-brand-900 font-bold text-sm lg:text-base mb-3">Services</h4>
                <ul class="space-y-2">
                    @forelse($footerServices ?? [] as $service)
                        <li>
                            <a href="{{ route('services.show', $service) }}" class="text-sm text-brand-600 hover:text-brand-red-500 transition">{{ $service->title }}</a>
                        </li>
                    @empty
                        <li class="text-sm text-brand-400">No services yet.</li>
                    @endforelse
                </ul>
                <a href="{{ route('services.index') }}" class="inline-flex items-center gap-1.5 mt-3 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600 transition group">
                    View All Services
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                </a>
            </div>

            <div>
                <h4 class="text-brand-900 font-bold text-sm lg:text-base mb-3">Solutions</h4>
                <ul class="space-y-2">
                    @forelse($footerSolutions ?? [] as $solution)
                        <li>
                            <a href="{{ route('solutions.show', $solution) }}" class="text-sm text-brand-600 hover:text-brand-red-500 transition">{{ $solution->title }}</a>
                        </li>
                    @empty
                        <li class="text-sm text-brand-400">No solutions yet.</li>
                    @endforelse
                </ul>
                <a href="{{ route('solutions.index') }}" class="inline-flex items-center gap-1.5 mt-3 text-sm font-semibold text-brand-red-500 hover:text-brand-red-600 transition group">
                    View All Solutions
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform"></i>
                </a>
            </div>

            <div>
                <h4 class="text-brand-900 font-bold text-sm lg:text-base mb-3">Contact</h4>
                <ul class="space-y-2.5">
                    @if(settings('company.address') || settings('company.city'))
                        <li class="flex items-start gap-2 text-sm text-brand-600">
                            <i data-lucide="map-pin" class="w-3.5 h-3.5 text-brand-red-500 shrink-0 mt-0.5"></i>
                            <span class="leading-snug">
                                @if(settings('company.address')){{ settings('company.address') }}@endif
                                @if(settings('company.city'))
                                    @if(settings('company.address'))<br>@endif
                                    {{ settings('company.city') }}@if(settings('company.postal_code')), {{ settings('company.postal_code') }}@endif
                                @endif
                                @if(settings('company.country'))<br>{{ settings('company.country') }}@endif
                            </span>
                        </li>
                    @endif
                    @if(settings('company.phone'))
                        <li class="flex items-center gap-2 text-sm">
                            <i data-lucide="phone" class="w-3.5 h-3.5 text-brand-red-500 shrink-0"></i>
                            <a href="tel:{{ preg_replace('/\s+/', '', settings('company.phone')) }}" class="text-brand-600 hover:text-brand-red-500 transition">{{ settings('company.phone') }}</a>
                        </li>
                    @endif
                    @if(settings('company.secondary_phone'))
                        <li class="flex items-center gap-2 text-sm">
                            <i data-lucide="phone" class="w-3.5 h-3.5 text-brand-red-500 shrink-0"></i>
                            <a href="tel:{{ preg_replace('/\s+/', '', settings('company.secondary_phone')) }}" class="text-brand-600 hover:text-brand-red-500 transition">{{ settings('company.secondary_phone') }}</a>
                        </li>
                    @endif
                    @if(settings('company.email'))
                        <li class="flex items-center gap-2 text-sm">
                            <i data-lucide="mail" class="w-3.5 h-3.5 text-brand-red-500 shrink-0"></i>
                            <a href="mailto:{{ settings('company.email') }}" class="text-brand-600 hover:text-brand-red-500 transition break-all">{{ settings('company.email') }}</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- Sitemap --}}
        <div id="sitemap" class="mt-10 lg:mt-12 pt-8 border-t border-brand-100 scroll-mt-[calc(var(--site-header-height)+1rem)]">
            <div class="flex items-center justify-between gap-4 mb-2">
                <h4 class="text-brand-900 font-bold text-xs uppercase tracking-wide">Quick Sitemap</h4>
                <a href="{{ route('legal.sitemap') }}" class="text-xs font-semibold text-brand-red-500 hover:text-brand-red-600 transition">View full sitemap</a>
            </div>
            <div class="flex flex-wrap gap-x-3 gap-y-1 text-sm leading-relaxed">
                <a href="{{ route('home') }}" class="text-brand-500 hover:text-brand-red-500 transition">Home</a>
                <span class="text-brand-300 select-none">·</span>
                <a href="{{ route('about.index') }}" class="text-brand-500 hover:text-brand-red-500 transition">About</a>
                <span class="text-brand-300 select-none">·</span>
                <a href="{{ route('data-centre.index') }}" class="text-brand-500 hover:text-brand-red-500 transition">Data Centre</a>
                <span class="text-brand-300 select-none">·</span>
                <a href="{{ route('blog.index') }}" class="text-brand-500 hover:text-brand-red-500 transition">Blog</a>
                <span class="text-brand-300 select-none">·</span>
                <a href="{{ route('services.index') }}" class="text-brand-500 hover:text-brand-red-500 transition">Services</a>
                @foreach($sitemapServices ?? [] as $service)
                    <span class="text-brand-300 select-none">·</span>
                    <a href="{{ route('services.show', $service) }}" class="text-brand-500 hover:text-brand-red-500 transition">{{ $service->title }}</a>
                @endforeach
                <span class="text-brand-300 select-none">·</span>
                <a href="{{ route('solutions.index') }}" class="text-brand-500 hover:text-brand-red-500 transition">Solutions</a>
                @foreach($sitemapSolutions ?? [] as $solution)
                    <span class="text-brand-300 select-none">·</span>
                    <a href="{{ route('solutions.show', $solution) }}" class="text-brand-500 hover:text-brand-red-500 transition">{{ $solution->title }}</a>
                @endforeach
                <span class="text-brand-300 select-none">·</span>
                <a href="{{ route('contact.index') }}" class="text-brand-500 hover:text-brand-red-500 transition">Contact</a>
            </div>
        </div>
    </div>

    {{-- Sub-footer --}}
    <div class="border-t border-brand-200 bg-brand-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 lg:py-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 text-xs sm:text-sm">
                <div class="text-center sm:text-left">
                    <p class="text-brand-700">
                        &copy; {{ date('Y') }}
                        <span class="font-semibold text-brand-900">{{ settings('company.company_name') ?? 'VDC800' }}</span>.
                        All rights reserved.
                    </p>
                    @if(settings('company.founded_year'))
                        <p class="text-brand-500 text-xs mt-0.5">Serving clients worldwide since {{ settings('company.founded_year') }}</p>
                    @endif
                </div>

                <div class="flex flex-wrap items-center justify-center gap-4">
                    <button
                        type="button"
                        onclick="window.scrollTo({ top: 0, behavior: 'smooth' })"
                        class="inline-flex items-center gap-1.5 text-brand-600 hover:text-brand-red-500 font-medium transition"
                    >
                        <i data-lucide="arrow-up" class="w-3.5 h-3.5"></i>
                        Back to Top
                    </button>
                    <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-1.5 text-brand-600 hover:text-brand-red-500 font-medium transition">
                        <i data-lucide="message-circle" class="w-3.5 h-3.5"></i>
                        Get Quote
                    </a>
                    <span class="hidden sm:inline text-brand-300">|</span>
                    <a href="{{ route('legal.privacy') }}" class="text-brand-500 hover:text-brand-red-500 transition">Privacy</a>
                    <a href="{{ route('legal.terms') }}" class="text-brand-500 hover:text-brand-red-500 transition">Terms</a>
                    <a href="{{ route('legal.cookies') }}" class="text-brand-500 hover:text-brand-red-500 transition">Cookies</a>
                    <a href="{{ route('legal.sitemap') }}" class="text-brand-500 hover:text-brand-red-500 transition">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>
