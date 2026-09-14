@extends('layouts.app')

@section('title', ($about->meta_title ?? 'About Us') . ' — ' . (settings('company.company_name') ?? 'VDC800'))
@section('meta_description', $about->meta_description ?? settings('company.description'))

@section('content')
<x-page-hero
    :image="$about->hero_image"
    fallback="images/about-technology.jpg"
    alt="About VDC800"
    size="lg"
    align="center"
>
    <p class="text-brand-teal-400 text-sm font-medium tracking-widest uppercase mb-3">About VDC800</p>
    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl mb-4 max-w-3xl">
        {{ $about->hero_heading ?? 'Sustainable Nordic Data Centre Excellence' }}
    </h1>
    <div class="text-brand-200 text-base sm:text-lg max-w-2xl prose-content">
        {!! rich_content($about->hero_description ?? settings('company.about_company') ?? settings('company.description')) !!}
    </div>
</x-page-hero>

{{-- Mission & Vision --}}
<section class="py-24 lg:py-32" data-reveal="split">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20">
            @if($about->mission)
                <div class="bg-brand-100 rounded-2xl p-8 lg:p-10" data-reveal-text data-hover-lift>
                    <div class="w-12 h-12 rounded-xl bg-brand-teal-600 flex items-center justify-center mb-6">
                        <i data-lucide="target" class="w-6 h-6 text-white"></i>
                    </div>
                    <h2 class="font-display text-3xl text-brand-900 mb-4">Our Mission</h2>
                    <div class="prose-content text-brand-600 text-lg">{!! rich_content($about->mission) !!}</div>
                </div>
            @endif
            @if($about->vision)
                <div class="bg-brand-900 text-white rounded-2xl p-8 lg:p-10" data-reveal-media data-hover-lift>
                    <div class="w-12 h-12 rounded-xl bg-brand-teal-600 flex items-center justify-center mb-6">
                        <i data-lucide="eye" class="w-6 h-6 text-white"></i>
                    </div>
                    <h2 class="font-display text-3xl mb-4">Our Vision</h2>
                    <div class="prose-content text-brand-300 text-lg">{!! rich_content($about->vision) !!}</div>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- Story --}}
@if($about->story)
<section class="py-24 bg-brand-100">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-display text-4xl text-brand-900 mb-8 text-center">Our Story</h2>
        <div class="prose-content text-brand-600 text-lg leading-relaxed">{!! rich_content($about->story) !!}</div>
    </div>
</section>
@endif

{{-- Values --}}
@if($values->count())
<section class="py-24 lg:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="font-display text-4xl text-brand-900 mb-4">Our Values</h2>
            <p class="text-brand-600">The principles that guide everything we do at VDC800.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($values as $value)
                <div class="text-center p-8">
                    <div class="w-14 h-14 rounded-full bg-brand-teal-100 flex items-center justify-center mx-auto mb-5">
                        <i data-lucide="{{ $value->icon ?? 'heart' }}" class="w-7 h-7 text-brand-teal-700"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-brand-900 mb-3">{{ $value->title }}</h3>
                    <p class="text-brand-600 leading-relaxed">{{ $value->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Sustainability --}}
@if($about->sustainability)
<section class="py-24 bg-brand-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
            <div>
                <p class="text-brand-teal-400 text-sm font-medium tracking-widest uppercase mb-4">Operations</p>
                <h2 class="font-display text-4xl mb-6">Committed to Operational Excellence</h2>
                <div class="prose-content text-brand-300 text-lg">{!! rich_content($about->sustainability) !!}</div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-brand-800 rounded-2xl p-6 text-center">
                    <i data-lucide="activity" class="w-8 h-8 text-brand-teal-400 mx-auto mb-3"></i>
                    <p class="font-medium">99.999% Uptime</p>
                </div>
                <div class="bg-brand-800 rounded-2xl p-6 text-center">
                    <i data-lucide="thermometer" class="w-8 h-8 text-brand-teal-400 mx-auto mb-3"></i>
                    <p class="font-medium">Free Cooling</p>
                </div>
                <div class="bg-brand-800 rounded-2xl p-6 text-center">
                    <i data-lucide="recycle" class="w-8 h-8 text-brand-teal-400 mx-auto mb-3"></i>
                    <p class="font-medium">Heat Recovery</p>
                </div>
                <div class="bg-brand-800 rounded-2xl p-6 text-center">
                    <i data-lucide="award" class="w-8 h-8 text-brand-teal-400 mx-auto mb-3"></i>
                    <p class="font-medium">Security Assured</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- CTA --}}
<section class="py-24 lg:py-32">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-display text-4xl lg:text-5xl text-brand-900 mb-6">
            {{ $about->cta_heading ?? 'Join us in building sustainable infrastructure' }}
        </h2>
        <p class="text-lg text-brand-600 mb-10 max-w-2xl mx-auto">
            {{ $about->cta_description ?? 'Partner with VDC800 for data centre solutions that perform brilliantly and respect the planet.' }}
        </p>
        <a href="{{ $about->cta_button_url ?? route('contact.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-brand-900 hover:bg-brand-800 text-white font-medium rounded-full transition">
            {{ $about->cta_button_text ?? 'Get in Touch' }}
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
</section>
@endsection
