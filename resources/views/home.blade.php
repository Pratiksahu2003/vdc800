@extends('layouts.app')

@section('title', settings('website.default_page_title') ?? settings('company.company_name') ?? 'D³ DataCenters')
@section('main_class', 'site-main site-main--home')

@section('content')
<div>
    @include('components.equinix-hero', ['heroSlides' => $heroSlides, 'homepage' => $homepage])

    @include('components.equinix-promo-strip')

    @include('components.equinix-tab-showcase', ['benefits' => $benefits, 'homepage' => $homepage])

    {{-- Solution tiles (Cloud / Data Center / Networking pattern) --}}
    @if($services->count())
    <section class="py-20 lg:py-24 bg-brand-50 border-y border-brand-200" data-eq-reveal>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="eq-headline-section text-brand-900 mb-12 lg:mb-14 max-w-2xl">Explore other solutions</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                @foreach($services as $service)
                    <a href="{{ route('services.show', $service) }}" class="eq-tile-link group">
                        <h3>{{ $service->title }}</h3>
                        <p>{{ Str::limit($service->short_description, 160) }}</p>
                        <span class="inline-flex items-center gap-2 mt-6 text-sm font-semibold text-brand-teal-700 group-hover:gap-3 transition-all">
                            Learn more <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Ecosystem / intro --}}
    @if($homepage->intro_heading || $homepage->intro_description)
    <section class="eq-dark-band py-20 lg:py-28" data-eq-reveal>
        <div class="absolute inset-0 opacity-25" data-eq-parallax>
            <img src="{{ $homepage->intro_image ? Storage::url($homepage->intro_image) : asset('images/hero-slide-1.jpg') }}" alt="" class="w-full h-full object-cover">
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <h2 class="eq-headline-section text-white mb-6">{{ $homepage->intro_heading ?? 'The ecosystem that connects everything.' }}</h2>
                <div class="text-lg text-white/75 leading-relaxed prose-content prose-invert">{!! rich_content($homepage->intro_description) !!}</div>
                <a href="{{ route('about.index') }}" class="eq-btn-outline-light mt-10">Explore {{ settings('company.company_name') ?? 'D³ DataCenters' }}</a>
            </div>
        </div>
    </section>
    @endif

    @include('components.equinix-ecosystem', ['services' => $services])

    @if($homepage->infrastructure_heading || $statistics->count())
        @include('components.equinix-colocation-band', ['homepage' => $homepage, 'statistics' => $statistics])
    @endif

    {{-- Case study / testimonials --}}
    @if($testimonials->count())
        @include('components.reviews-slider', ['testimonials' => $testimonials])
    @endif

    {{-- Persona / solution cards --}}
    @if($solutions->count())
    <section class="py-20 lg:py-28 bg-brand-50" data-eq-reveal>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="eq-headline-section text-brand-900 mb-12 max-w-3xl">Built for the people who build enterprise infrastructure</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($solutions as $solution)
                    <a href="{{ route('solutions.show', $solution) }}" class="eq-persona-card group">
                        <p class="text-xs font-bold uppercase tracking-widest text-brand-teal-600 mb-3">For teams</p>
                        <h3 class="text-xl font-bold text-brand-900 mb-3 group-hover:text-brand-teal-700 transition">{{ $solution->title }}</h3>
                        <p class="text-sm text-brand-600 leading-relaxed flex-1">{{ Str::limit($solution->short_description, 120) }}</p>
                        <span class="inline-flex items-center gap-2 mt-6 text-sm font-semibold text-brand-teal-700">
                            Explore <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Resources --}}
    @if($latestPosts->count())
    <section class="py-20 lg:py-28 bg-white border-t border-brand-200" data-eq-reveal>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="eq-headline-section text-brand-900 mb-12">Resources to get you connected.</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                @foreach($latestPosts->take(3) as $post)
                    <a href="{{ route('blog.show', $post) }}" class="eq-resource-card group">
                        <img src="{{ $post->imageUrl() }}" alt="" class="w-full h-48 object-cover">
                        <div class="p-6">
                            @if($post->category)
                                <p class="text-xs font-bold uppercase tracking-widest text-brand-teal-600 mb-2">{{ $post->category->name }}</p>
                            @endif
                            <h3 class="text-lg font-bold text-brand-900 mb-2 group-hover:text-brand-teal-700 transition">{{ $post->title }}</h3>
                            <p class="text-sm text-brand-600">{{ Str::limit($post->excerpt, 100) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-10">
                <a href="{{ route('blog.index') }}" class="eq-btn-outline">View all resources</a>
            </div>
        </div>
    </section>
    @endif

    {{-- Final CTA band --}}
    <section class="eq-dark-band py-16 lg:py-20" data-eq-reveal>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-2xl lg:text-4xl font-bold text-white mb-4 tracking-tight">
                {{ $homepage->final_cta_heading ?? 'Make ' . (settings('company.short_name') ?? 'D³') . ' your competitive advantage' }}
            </h2>
            <p class="text-white/70 text-lg mb-8 max-w-2xl mx-auto">
                {{ $homepage->final_cta_description ?? 'Partner with D³ DataCenters for Nordic data centre excellence.' }}
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact.index') }}" class="eq-btn-primary">{{ $homepage->final_cta_button_text ?? 'Schedule a discovery session' }}</a>
                <a href="{{ route('contact.index') }}" class="eq-btn-outline-light">Talk to an expert</a>
            </div>
        </div>
    </section>
</div>
@endsection
