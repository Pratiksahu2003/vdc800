@extends('layouts.app')

@php($seo = seo_for_route('about.index'))
@php($ctaUrl = filled($about->cta_button_url) ? $about->cta_button_url : route('contact.index'))
@section('title', filled($about->meta_title) ? seo_entity_title($about->meta_title, $about->meta_title, 'about') : $seo['title'])
@section('meta_description', seo_description($about->meta_description, settings('company.description') ?: $seo['description']))
@section('meta_keywords', $seo['keywords'])
@if($ogImage = \App\Support\Seo::ogImage($about->og_image ?? null))
@section('og_image', $ogImage)
@endif

@section('content')
<x-page-hero class="eq-about-hero" :image="$about->hero_image" fallback="images/about-technology.jpg" alt="About {{ settings('company.company_name') ?? 'D³ DataCenters' }}" size="xl" align="end">
    <div class="eq-about-hero__copy">
        <p class="eq-about-kicker">About us</p>
        <h1>{{ $about->hero_heading ?? 'Sustainable data centre excellence' }}</h1>
        <div class="eq-about-hero__lede cms-content">
            {!! rich_content($about->hero_description ?? settings('company.about_company') ?? settings('company.description')) !!}
        </div>
        <div class="eq-about-hero__actions">
            <a href="{{ $ctaUrl }}" class="eq-btn-primary">{{ $about->cta_button_text ?? 'Talk with our team' }}</a>
            <a href="#our-story" class="eq-btn-outline-light">Read our story</a>
        </div>
    </div>
</x-page-hero>

@if($statistics->count())
    <div class="eq-about-stats-wrap" data-eq-reveal>
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <dl class="eq-about-stats">
                @foreach($statistics as $stat)
                    <div class="eq-about-stat">
                        <dt class="eq-about-stat__label">{{ $stat->label }}</dt>
                        <dd class="eq-about-stat__number">{{ $stat->number }}</dd>
                        @if($stat->description)
                            <dd class="eq-about-stat__desc">{{ $stat->description }}</dd>
                        @endif
                    </div>
                @endforeach
            </dl>
        </div>
    </div>
@endif

@if($about->mission || $about->vision)
<section class="eq-about-block {{ $statistics->count() ? 'eq-about-block--after-stats' : '' }}" data-eq-reveal>
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="eq-about-statements">
            @if($about->mission)
                <article class="eq-about-statement">
                    <span class="eq-about-statement__index">01</span>
                    <p class="eq-about-kicker eq-about-kicker--dark">Mission</p>
                    <div class="cms-content eq-about-statement__body">{!! rich_content($about->mission) !!}</div>
                </article>
            @endif
            @if($about->vision)
                <article class="eq-about-statement eq-about-statement--dark">
                    <span class="eq-about-statement__index">02</span>
                    <p class="eq-about-kicker">Vision</p>
                    <div class="cms-content eq-about-statement__body">{!! rich_content($about->vision) !!}</div>
                </article>
            @endif
        </div>
    </div>
</section>
@endif

@if($about->story)
<section id="our-story" class="eq-about-story" data-eq-reveal>
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="eq-about-story__grid">
            <div class="eq-about-story__media">
                <img src="{{ asset('images/about-global-network.png') }}" alt="Global data centre network connecting cloud, security, and operations">
            </div>
            <div class="eq-about-story__copy">
                <p class="eq-about-kicker eq-about-kicker--dark">Since the beginning</p>
                <h2 class="eq-headline-section text-brand-900">Our story</h2>
                <div class="cms-content eq-about-story__body">{!! rich_content($about->story) !!}</div>
            </div>
        </div>
    </div>
</section>
@endif

@if($values->count())
<section class="eq-about-block" data-eq-reveal>
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="eq-about-heading">
            <div>
                <p class="eq-about-kicker eq-about-kicker--dark">How we work</p>
                <h2 class="eq-headline-section text-brand-900">Our values</h2>
            </div>
            <p class="eq-about-heading__note">The standards we use when we design, operate, and stand behind every facility.</p>
        </div>
        <div class="eq-about-values">
            @foreach($values as $value)
                <article class="eq-about-value">
                    <div class="eq-about-value__top">
                        <span class="eq-about-value__icon" aria-hidden="true">
                            <i data-lucide="{{ preg_match('/^[a-z0-9-]+$/', (string) $value->icon) ? $value->icon : 'sparkles' }}" class="w-5 h-5"></i>
                        </span>
                        <span class="eq-about-value__index">{{ sprintf('%02d', $loop->iteration) }}</span>
                    </div>
                    <h3>{{ $value->title }}</h3>
                    <p>{{ $value->description }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($facilities->count())
<section class="eq-about-facilities" data-eq-reveal>
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="eq-about-heading">
            <div>
                <p class="eq-about-kicker eq-about-kicker--dark">Network</p>
                <h2 class="eq-headline-section text-brand-900">Facilities we design and operate</h2>
            </div>
            <a href="{{ route('data-centre.index') }}" class="eq-about-link">
                View all projects
                <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </div>
        <div class="eq-about-facility-grid">
            @foreach($facilities as $facility)
                <a href="{{ route('data-centre.show', $facility) }}" class="eq-about-facility">
                    <img src="{{ hero_image_url($facility->hero_image, 'images/data-centre-facility.jpg') }}" alt="{{ $facility->name }}">
                    <span class="eq-about-facility__shade"></span>
                    <span class="eq-about-facility__meta">
                        <strong>{{ $facility->location }}</strong>
                        <em>{{ $facility->name }}</em>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($about->sustainability)
<section class="eq-about-ops" data-eq-reveal>
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="eq-about-ops__grid">
            <div>
                <p class="eq-about-kicker">Operations</p>
                <h2 class="eq-headline-section text-white">Operational excellence</h2>
            </div>
            <div class="cms-content eq-about-ops__body">{!! rich_content($about->sustainability) !!}</div>
        </div>
    </div>
</section>
@endif

<section class="eq-about-close-wrap" data-eq-reveal>
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="eq-about-close">
            <div>
                <p class="eq-about-kicker eq-about-kicker--dark">Work with us</p>
                <h2 class="eq-headline-section text-brand-900">{{ $about->cta_heading ?? 'Join us in building sustainable infrastructure' }}</h2>
                @if($about->cta_description)
                    <div class="cms-content eq-about-close__body">{!! rich_content($about->cta_description) !!}</div>
                @endif
            </div>
            <a href="{{ $ctaUrl }}" class="eq-btn-primary shrink-0">{{ $about->cta_button_text ?? 'Get in touch' }}</a>
        </div>
    </div>
</section>
@endsection
