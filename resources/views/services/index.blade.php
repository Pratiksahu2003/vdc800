@extends('layouts.app')

@php($seo = seo_for_route('services.index'))
@section('title', $seo['title'])
@section('meta_description', $seo['description'])
@section('meta_keywords', $seo['keywords'])

@section('content')
<x-page-hero fallback="images/hero-datacenter.jpg" alt="Our Services" size="lg" align="center">
    <x-public.hero-heading
        eyebrow="Our Services"
        title="From strategy<br class='hidden sm:block'> to scale."
        description="End-to-end advisory for data centres and AI infrastructure — from opportunity to operations."
    />
</x-page-hero>

@if($services->count())
    <x-public.section tone="muted">
        <h2 class="eq-headline-section text-brand-900 mb-12 max-w-2xl">Explore our services</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($services as $service)
                <a href="{{ route('services.show', $service) }}" class="eq-tile-link group">
                    <h3>{{ $service->title }}</h3>
                    <p>{{ $service->short_description }}</p>
                    <span class="inline-flex items-center gap-2 mt-6 text-sm font-semibold text-brand-teal-700">
                        Learn more <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                    </span>
                </a>
            @endforeach
        </div>
    </x-public.section>

    <x-public.cta-band
        title="One integrated advisory layer"
        description="From early opportunity assessment through engineering, procurement, and delivery coordination."
    />
@else
    <x-public.section>
        <p class="text-brand-600 text-center py-12">Services coming soon.</p>
    </x-public.section>
@endif
@endsection
