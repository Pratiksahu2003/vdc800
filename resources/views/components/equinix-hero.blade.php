@php
    $heroVideoPath = public_path('Video/home-hero.mp4');
    $videoVersion = is_file($heroVideoPath) ? (string) filemtime($heroVideoPath) : '1';
    $defaultVideo = asset('Video/home-hero.mp4').'?v='.$videoVersion;
    $slidesData = $heroSlides->map(fn ($s) => [
        'category' => $s->category,
        'title' => $s->title,
        'description' => $s->description,
        'cta_text' => $s->cta_text,
        'cta_url' => $s->cta_url,
    ])->values();
    $primarySlide = $heroSlides->first();
    $headline = $homepage->hero_heading ?? $primarySlide?->title ?? 'Infrastructure built for what comes next.';
    $headlineAccent = $homepage->hero_subtitle ?? 'Connected. Sovereign. Ready to scale.';
    $subcopy = strip_tags($homepage->hero_description ?? $primarySlide?->description ?? settings('company.description') ?? '');
    $primaryCtaText = $homepage->hero_cta_text ?? 'Explore solutions';
    $primaryCtaUrl = $homepage->hero_cta_url ?? route('services.index');
    $secondaryCtaText = $homepage->hero_secondary_cta_text ?? 'Talk to our team';
    $secondaryCtaUrl = $homepage->hero_secondary_cta_url ?? route('contact.index');
    $heroStats = isset($statistics) ? $statistics->take(3) : collect();
@endphp

<section
    class="eq-hero relative flex flex-col text-white overflow-hidden bg-brand-950"
    data-eq-hero
    x-data="heroCarousel(@js($slidesData))"
    @mouseenter="stopAutoplay()"
    @mouseleave="slides.length > 1 && startAutoplay()"
>
    <div class="absolute inset-0 z-0 eq-hero__media" data-eq-hero-media>
        <div class="eq-hero__video-wrap">
            <video
                x-ref="heroVideo"
                class="eq-hero__video"
                autoplay
                muted
                loop
                playsinline
                preload="auto"
                disablepictureinpicture
                aria-hidden="true"
            >
                <source src="{{ $defaultVideo }}" type="video/mp4">
            </video>
        </div>
        <div class="eq-hero__overlay" aria-hidden="true"></div>
        <div class="eq-hero__vignette" aria-hidden="true"></div>
        <div class="eq-hero-grid" aria-hidden="true"></div>
        <div class="eq-hero-noise" aria-hidden="true"></div>
    </div>

    <div class="relative z-10 flex-1 flex items-center eq-hero__body" :class="slides.length && 'eq-hero__body--with-tabs'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="eq-hero__layout">
                <div class="eq-hero__content">
                    <p class="eq-hero__eyebrow" data-eq-hero-line>
                        <span>{{ settings('company.short_name') ?? 'D³' }} DataCenters</span>
                        <template x-if="slides.length && current().category">
                            <span class="eq-hero__eyebrow-divider" aria-hidden="true"></span>
                        </template>
                        <span
                            x-show="slides.length && current().category"
                            x-cloak
                            x-text="current().category"
                            class="text-brand-teal-300"
                        ></span>
                    </p>

                    <div class="eq-hero__title-wrap mb-5 lg:mb-6 min-h-[3.5rem] sm:min-h-[4rem] lg:min-h-[4.5rem]">
                        <template x-if="slides.length">
                            <div>
                                <template x-for="(slide, index) in slides" :key="'hero-title-' + index">
                                    <h1
                                        x-show="active === index"
                                        x-cloak
                                        x-transition:enter="transition ease-out duration-500"
                                        x-transition:enter-start="opacity-0 translate-y-4"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        class="eq-headline-hero eq-hero__title text-white"
                                        x-text="slide.title"
                                    ></h1>
                                </template>
                            </div>
                        </template>
                        <template x-if="!slides.length">
                            <h1 class="eq-headline-hero eq-hero__title" data-eq-hero-line>
                                <span class="block text-white">{{ $headline }}</span>
                                <span class="block eq-gradient-text-hero mt-2 lg:mt-3">{{ $headlineAccent }}</span>
                            </h1>
                        </template>
                    </div>

                    <div class="eq-hero__description-wrap mb-8 lg:mb-9 min-h-[4.25rem] sm:min-h-[4.75rem]">
                        <template x-if="slides.length">
                            <div>
                                <template x-for="(slide, index) in slides" :key="'hero-desc-' + index">
                                    <p
                                        x-show="active === index"
                                        x-cloak
                                        x-transition:enter="transition ease-out duration-500 delay-75"
                                        x-transition:enter-start="opacity-0 translate-y-3"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        class="eq-hero__description"
                                        x-text="slide.description"
                                    ></p>
                                </template>
                            </div>
                        </template>
                        <template x-if="!slides.length">
                            <p class="eq-hero__description" data-eq-hero-line>{{ Str::limit($subcopy, 280) }}</p>
                        </template>
                    </div>

                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 sm:gap-4" data-eq-hero-cta>
                        <template x-if="slides.length && current().cta_url">
                            <a
                                :href="current().cta_url.startsWith('http') ? current().cta_url : (current().cta_url.startsWith('/') ? current().cta_url : '/' + current().cta_url)"
                                class="eq-hero__btn eq-hero__btn--primary group"
                            >
                                <span x-text="current().cta_text || 'Read more'"></span>
                                <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-0.5"></i>
                            </a>
                        </template>
                        <template x-if="!slides.length || !current().cta_url">
                            <a href="{{ $primaryCtaUrl }}" class="eq-hero__btn eq-hero__btn--primary group">
                                <span>{{ $primaryCtaText }}</span>
                                <i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-0.5"></i>
                            </a>
                        </template>
                        <a href="{{ $secondaryCtaUrl }}" class="eq-hero__btn eq-hero__btn--ghost">
                            {{ $secondaryCtaText }}
                        </a>
                    </div>

                    @if($heroStats->isNotEmpty())
                        <ul class="eq-hero__stats mt-10 lg:mt-12" data-eq-hero-line aria-label="Key metrics">
                            @foreach($heroStats as $stat)
                                <li class="eq-hero__stat">
                                    <span class="eq-hero__stat-value">{{ $stat->number }}</span>
                                    <span class="eq-hero__stat-label">{{ $stat->label }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <a href="#home-continue" class="eq-hero__scroll-hint" x-show="!slides.length" aria-label="Scroll to content">
        <span class="eq-hero__scroll-label">Scroll</span>
        <span class="eq-hero__scroll-line"></span>
    </a>

    <div class="relative z-10 eq-hero__tabstrip" x-show="slides.length" x-cloak>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 eq-hero__tabstrip-inner">
            <div class="eq-hero__tabstrip-track scrollbar-hide" role="tablist" aria-label="Hero capabilities">
            <template x-for="(slide, index) in slides" :key="'eq-tab-' + index">
                <button
                    type="button"
                    role="tab"
                    @click="goTo(index)"
                    class="eq-hero__tab"
                    :class="active === index ? 'is-active' : ''"
                    :aria-selected="active === index ? 'true' : 'false'"
                >
                    <span class="eq-hero__tab-progress" aria-hidden="true">
                        <span class="eq-hero__tab-progress-fill" :style="active === index ? `width: ${progress}%` : 'width: 0%'"></span>
                    </span>
                    <span class="eq-hero__tab-index" x-text="slide.category || String(index + 1).padStart(2, '0')"></span>
                    <span class="eq-hero__tab-title" x-text="slide.title"></span>
                </button>
            </template>
            </div>
        </div>
    </div>
</section>
