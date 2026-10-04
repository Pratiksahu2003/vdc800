@php
    $slidesData = $heroSlides->map(fn ($s) => [
        'category' => $s->category,
        'title' => $s->title,
        'description' => $s->description,
        'cta_text' => $s->cta_text,
        'cta_url' => $s->cta_url,
    ])->values();
    $heroVideo = asset('Video/home-hero.mp4');
    $heroPoster = asset('images/hero-datacenter.jpg');
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
    <div class="absolute inset-0 z-0" data-eq-hero-media>
        <video
            x-ref="heroVideo"
            class="eq-hero__video"
            autoplay
            muted
            loop
            playsinline
            preload="auto"
            poster="{{ $heroPoster }}"
            disablepictureinpicture
            aria-hidden="true"
        >
            <source src="{{ $heroVideo }}" type="video/mp4">
        </video>
        <div class="eq-hero__overlay" aria-hidden="true"></div>
        <div class="eq-hero__glow eq-hero__glow--left" aria-hidden="true"></div>
        <div class="eq-hero__glow eq-hero__glow--right" aria-hidden="true"></div>
        <div class="eq-hero-grid" aria-hidden="true"></div>
        <div class="eq-hero-noise" aria-hidden="true"></div>
    </div>

    <div class="relative z-10 flex-1 flex items-center eq-hero__body">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="max-w-4xl mx-auto text-center lg:text-left lg:mx-0">
                <p
                    class="eq-hero__eyebrow"
                    data-eq-hero-line
                    x-text="slides.length && current().category ? 'Capability ' + current().category : @js((settings('company.short_name') ?? 'D³') . ' DataCenters')"
                >
                    {{ settings('company.short_name') ?? 'D³' }} DataCenters
                </p>

                <h1 class="eq-headline-hero eq-hero__title mb-5 lg:mb-7" data-eq-hero-line>
                    <span class="block text-white">{{ $headline }}</span>
                    <span class="block eq-gradient-text-hero mt-2 lg:mt-3">{{ $headlineAccent }}</span>
                </h1>

                <div class="eq-hero__description-wrap mb-8 lg:mb-10 min-h-[4.5rem] sm:min-h-[5rem] lg:min-h-[5.5rem]">
                    <template x-if="slides.length">
                        <div>
                            <template x-for="(slide, index) in slides" :key="'hero-desc-' + index">
                                <p
                                    x-show="active === index"
                                    x-cloak
                                    x-transition:enter="transition ease-out duration-500"
                                    x-transition:enter-start="opacity-0 translate-y-3"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    class="eq-hero__description"
                                    x-text="slide.description || @js(Str::limit($subcopy, 260))"
                                ></p>
                            </template>
                        </div>
                    </template>
                    <template x-if="!slides.length">
                        <p class="eq-hero__description" data-eq-hero-line>{{ Str::limit($subcopy, 260) }}</p>
                    </template>
                </div>

                <div class="flex flex-col sm:flex-row items-center lg:items-start justify-center lg:justify-start gap-3 sm:gap-4" data-eq-hero-cta>
                    <a href="{{ $primaryCtaUrl }}" class="eq-hero__btn eq-hero__btn--primary">
                        {{ $primaryCtaText }}
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                    <a href="{{ $secondaryCtaUrl }}" class="eq-hero__btn eq-hero__btn--ghost">
                        {{ $secondaryCtaText }}
                    </a>
                </div>

                @if($heroStats->isNotEmpty())
                    <ul class="eq-hero__stats mt-12 lg:mt-14" data-eq-hero-line aria-label="Key metrics">
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

    <a href="#home-continue" class="eq-hero__scroll-hint" aria-label="Scroll to content">
        <span class="eq-hero__scroll-line"></span>
    </a>

    <div class="relative z-10 eq-hero__dock" x-show="slides.length > 1" x-cloak>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4 lg:pb-5">
            <div class="eq-hero__dock-panel">
                <div class="flex overflow-x-auto scrollbar-hide snap-x snap-mandatory">
                    <template x-for="(slide, index) in slides" :key="'eq-tab-' + index">
                        <button
                            type="button"
                            @click="goTo(index)"
                            class="eq-hero__tab snap-start"
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
    </div>
</section>
