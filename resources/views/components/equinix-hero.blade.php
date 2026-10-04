@php
    $slidesData = $heroSlides->map(fn ($s) => [
        'category' => $s->category,
        'title' => $s->title,
        'description' => $s->description,
        'cta_text' => $s->cta_text,
        'cta_url' => $s->cta_url,
    ])->values();
    $heroVideo = asset('Video/home-hero.mp4');
    $primarySlide = $heroSlides->first();
    $headline = $homepage->hero_heading ?? $primarySlide?->title ?? 'Infrastructure built for what comes next.';
    $headlineAccent = $homepage->hero_subtitle ?? 'Connected. Sovereign. Ready to scale.';
    $subcopy = Str::limit(strip_tags($homepage->hero_description ?? $primarySlide?->description ?? settings('company.description') ?? ''), 220);
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
            class="absolute inset-0 w-full h-full object-cover pointer-events-none opacity-90"
            autoplay
            muted
            loop
            playsinline
            preload="auto"
            disablepictureinpicture
        >
            <source src="{{ $heroVideo }}" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-gradient-to-b from-black/55 via-black/45 to-black/85"></div>
        <div class="absolute inset-0 eq-hero-grid opacity-60"></div>
    </div>

    <div class="relative z-10 flex-1 flex items-center pt-10 pb-16 lg:pt-14 lg:pb-20">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 w-full text-center">
            <template x-if="slides.length">
                <div :key="active">
                    <h1 class="eq-headline-hero mb-6 lg:mb-8">
                        <span class="block text-white" data-eq-hero-line x-text="current().title || @js($headline)"></span>
                        <span class="block eq-gradient-text mt-1" data-eq-hero-line x-text="current().category || @js($headlineAccent)"></span>
                    </h1>
                    <p
                        class="text-base sm:text-lg lg:text-xl text-white/80 max-w-3xl mx-auto leading-relaxed mb-10"
                        data-eq-hero-line
                        x-text="current().description || @js($subcopy)"
                    ></p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4" data-eq-hero-cta>
                        <a href="{{ route('services.index') }}" class="eq-btn-primary min-w-[12rem]">Explore solutions</a>
                        <a href="{{ route('contact.index') }}" class="eq-btn-outline-light min-w-[12rem]">Talk to our team</a>
                    </div>
                </div>
            </template>
            <template x-if="!slides.length">
                <div>
                    <h1 class="eq-headline-hero mb-6 lg:mb-8">
                        <span class="block text-white" data-eq-hero-line>{{ $headline }}</span>
                        <span class="block eq-gradient-text mt-1" data-eq-hero-line>{{ $headlineAccent }}</span>
                    </h1>
                    <p class="text-base sm:text-lg lg:text-xl text-white/80 max-w-3xl mx-auto leading-relaxed mb-10" data-eq-hero-line>
                        {{ Str::limit(strip_tags($subcopy ?? ''), 220) }}
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4" data-eq-hero-cta>
                        <a href="{{ route('services.index') }}" class="eq-btn-primary min-w-[12rem]">Explore solutions</a>
                        <a href="{{ route('contact.index') }}" class="eq-btn-outline-light min-w-[12rem]">Talk to our team</a>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <div class="relative z-10 border-t border-white/15 bg-black/50 backdrop-blur-md" x-show="slides.length > 1" x-cloak>
        <div class="max-w-7xl mx-auto">
            <div class="flex overflow-x-auto scrollbar-hide">
                <template x-for="(slide, index) in slides" :key="'eq-tab-' + index">
                    <button
                        type="button"
                        @click="goTo(index)"
                        class="relative flex-shrink-0 w-[min(100%,280px)] lg:flex-1 text-left px-5 py-4 border-r border-white/10 last:border-r-0 hover:bg-white/5 transition-colors"
                        :class="active === index ? 'bg-white/5' : ''"
                    >
                        <div class="absolute top-0 left-0 right-0 h-[3px] bg-white/15 overflow-hidden">
                            <div class="h-full bg-brand-red-500" :style="active === index ? `width: ${progress}%` : 'width: 0%'"></div>
                        </div>
                        <p class="text-[11px] uppercase tracking-widest mb-1 truncate" :class="active === index ? 'text-brand-red-400' : 'text-white/45'" x-text="slide.category"></p>
                        <p class="text-sm leading-snug line-clamp-2" :class="active === index ? 'text-white font-semibold' : 'text-white/60'" x-text="slide.title"></p>
                    </button>
                </template>
            </div>
        </div>
    </div>
</section>
