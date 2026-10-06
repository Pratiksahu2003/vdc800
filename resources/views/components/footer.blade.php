<footer class="bg-white border-t border-brand-200" data-site-footer>
    {{-- Pre-footer CTA --}}
    <div class="eq-dark-band py-14 lg:py-16 border-b border-brand-800" data-eq-footer-block>
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8">
            <div>
                <h2 class="text-2xl lg:text-3xl font-bold text-white tracking-tight max-w-xl">
                    Make {{ settings('company.short_name') ?? 'D³' }} your competitive advantage
                </h2>
                <p class="text-white/65 mt-3 max-w-lg">Infrastructure advisory built for enterprise scale.</p>
            </div>
            <div class="flex flex-col sm:flex-row gap-3 shrink-0">
                <a href="{{ route('contact.index') }}" class="eq-btn-primary text-center">Schedule a discovery session</a>
                <a href="{{ route('contact.index') }}" class="eq-btn-outline-light text-center">Talk to an expert</a>
            </div>
        </div>
    </div>

    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16" data-eq-footer-block>
        @if(count(settings('social_links') ?? []) > 0)
            <div class="flex flex-wrap gap-3 mb-10 pb-10 border-b border-brand-200">
                @foreach(settings('social_links') ?? [] as $link)
                    @if($link['is_active'] ?? false)
                        <a href="{{ $link['url'] }}" target="_blank" rel="noopener noreferrer" title="{{ $link['platform'] }}"
                            class="eq-social-btn">
                            <x-social-icon :name="$link['icon'] ?? $link['platform'] ?? 'link'" class="w-4 h-4" />
                        </a>
                    @endif
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12" data-footer-links x-data="{ open: null }">
            <div>
                <button type="button" class="eq-footer-heading" @click="open = open === 'co' ? null : 'co'">
                    Company <i data-lucide="chevron-down" class="w-4 h-4 lg:hidden transition-transform" :class="open === 'co' && 'rotate-180'"></i>
                </button>
                <ul class="eq-footer-list" :class="open !== 'co' && 'max-lg:hidden'">
                    <li><a href="{{ route('about.index') }}">About</a></li>
                    <li><a href="{{ route('data-centre.index') }}">Projects</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                    <li><a href="{{ route('contact.index') }}">Contact</a></li>
                </ul>
            </div>
            <div>
                <button type="button" class="eq-footer-heading" @click="open = open === 'pr' ? null : 'pr'">
                    Products <i data-lucide="chevron-down" class="w-4 h-4 lg:hidden transition-transform" :class="open === 'pr' && 'rotate-180'"></i>
                </button>
                <ul class="eq-footer-list" :class="open !== 'pr' && 'max-lg:hidden'">
                    @forelse($footerServices ?? [] as $service)
                        <li><a href="{{ route('services.show', $service) }}">{{ $service->title }}</a></li>
                    @empty
                        <li><a href="{{ route('services.index') }}">Services</a></li>
                    @endforelse
                </ul>
            </div>
            <div>
                <button type="button" class="eq-footer-heading" @click="open = open === 'so' ? null : 'so'">
                    Solutions <i data-lucide="chevron-down" class="w-4 h-4 lg:hidden transition-transform" :class="open === 'so' && 'rotate-180'"></i>
                </button>
                <ul class="eq-footer-list" :class="open !== 'so' && 'max-lg:hidden'">
                    @forelse($footerSolutions ?? [] as $solution)
                        <li><a href="{{ route('solutions.show', $solution) }}">{{ $solution->title }}</a></li>
                    @empty
                        <li><a href="{{ route('solutions.index') }}">Solutions</a></li>
                    @endforelse
                </ul>
            </div>
            <div>
                <button type="button" class="eq-footer-heading" @click="open = open === 'lg' ? null : 'lg'">
                    Legal <i data-lucide="chevron-down" class="w-4 h-4 lg:hidden transition-transform" :class="open === 'lg' && 'rotate-180'"></i>
                </button>
                <ul class="eq-footer-list" :class="open !== 'lg' && 'max-lg:hidden'">
                    <li><a href="{{ route('legal.privacy') }}">Privacy</a></li>
                    <li><a href="{{ route('legal.terms') }}">Terms</a></li>
                    <li><a href="{{ route('legal.cookies') }}">Cookie preferences</a></li>
                    <li><a href="{{ route('legal.sitemap') }}">Sitemap</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-12 pt-8 border-t border-brand-200 flex flex-col lg:flex-row lg:items-end lg:justify-between gap-4 text-sm text-brand-600">
            <x-logo class="h-10 w-auto opacity-90" :link="false" />
            <div class="flex flex-col gap-1.5 lg:items-end lg:text-right">
                <p>&copy; {{ date('Y') }} {{ settings('company.company_name') ?? 'D³ DataCenters' }}. All rights reserved.</p>
                <p class="text-brand-500">
                    Designed and developed by
                    <a href="https://www.vedmint.com/" target="_blank" rel="noopener noreferrer" class="font-medium text-brand-teal-700 hover:text-brand-teal-800 underline-offset-2 hover:underline">VedMint Consultancy Services</a>
                </p>
            </div>
        </div>
    </div>
</footer>
