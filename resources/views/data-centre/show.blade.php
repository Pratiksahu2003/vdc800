@extends('layouts.app')

@section('title', seo_entity_title($dataCentre->meta_title, $dataCentre->name ?? 'Data Centre Project', 'data_centre'))
@section('meta_description', seo_description($dataCentre->meta_description, $dataCentre->short_description))
@section('meta_keywords', seo_entity_keywords('data_centre', $dataCentre->name ?? 'Data centre project'))
@section('og_type', 'article')
@if($ogImage = \App\Support\Seo::ogImage($dataCentre->og_image ?? $dataCentre->featured_image))
@section('og_image', $ogImage)
@endif

@section('content')
@php
    $mapEmbed = data_centre_map_embed_url($dataCentre);
    $mapLink = data_centre_map_link($dataCentre);
@endphp
<x-page-hero :image="$dataCentre->hero_image" fallback="images/hero-datacenter.jpg" :alt="$dataCentre->name" size="lg" align="center">
    <x-public.hero-heading :title="$dataCentre->name">
        @if($dataCentre->short_description)
            <div class="text-white/75 text-base sm:text-lg leading-relaxed max-w-2xl mx-auto cms-content">{!! rich_content($dataCentre->short_description) !!}</div>
        @endif
        @if($dataCentre->location)
            <p class="text-brand-teal-400 text-xs font-bold uppercase tracking-widest mt-4">{{ $dataCentre->location }}@if($dataCentre->country), {{ $dataCentre->country }}@endif</p>
        @endif
        <a href="{{ route('data-centre.index') }}" class="inline-flex items-center gap-2 mt-6 text-sm text-white/70 hover:text-white transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> All projects
        </a>
    </x-public.hero-heading>
</x-page-hero>

@if($specifications->count())
<x-public.section tone="muted" padding="sm">
    <h2 class="text-sm font-bold uppercase tracking-widest text-brand-teal-600 mb-6">Key metrics</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($specifications as $spec)
            <div class="border border-brand-200 bg-white p-5">
                <p class="text-xs text-brand-500 mb-1">{{ $spec->label }}</p>
                <p class="text-2xl font-bold text-brand-900">{{ $spec->value }}@if($spec->unit)<span class="text-sm text-brand-teal-600 ml-1">{{ $spec->unit }}</span>@endif</p>
            </div>
        @endforeach
    </div>
</x-public.section>
@endif

@if($dataCentre->full_description || $dataCentre->address || $dataCentre->location)
<x-public.section>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <div class="lg:col-span-4">
            <h2 class="eq-headline-section text-brand-900 text-2xl mb-4">About the project</h2>
            @if($dataCentre->location || $dataCentre->country)
                <p class="text-xs font-bold uppercase tracking-widest text-brand-teal-600 mb-3">
                    {{ $dataCentre->location }}@if($dataCentre->country && $dataCentre->location), @endif{{ $dataCentre->country }}
                </p>
            @endif
            @if($dataCentre->address)
                <div class="text-sm text-brand-600 leading-relaxed cms-content">
                    <i data-lucide="map-pin" class="w-4 h-4 inline text-brand-teal-600 -mt-0.5"></i>
                    {!! rich_content($dataCentre->address) !!}
                </div>
            @endif
            @if($mapLink)
                <a href="{{ $mapLink }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-brand-teal-700 hover:text-brand-teal-600 transition">
                    <i data-lucide="navigation" class="w-4 h-4"></i>
                    Open in Google Maps
                </a>
            @endif
        </div>
        @if($dataCentre->full_description)
            <div class="lg:col-span-8 cms-content">{!! rich_content($dataCentre->full_description) !!}</div>
        @endif
    </div>
</x-public.section>
@endif

@if($mapEmbed)
<x-public.section tone="muted" padding="sm">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6">
        <div>
            <p class="text-brand-teal-600 text-xs font-bold tracking-widest uppercase mb-2">Location</p>
            <h2 class="eq-headline-section text-brand-900 text-2xl">Find this facility</h2>
            <p class="text-brand-600 mt-2 max-w-xl">Explore the project location and get directions to the data centre site.</p>
        </div>
        @if($mapLink)
            <a href="{{ $mapLink }}" target="_blank" rel="noopener noreferrer" class="eq-btn-outline shrink-0">
                <i data-lucide="navigation" class="w-4 h-4"></i>
                Get directions
            </a>
        @endif
    </div>
    <div class="overflow-hidden rounded-2xl border border-brand-200 bg-white shadow-sm">
        <iframe
            src="{{ $mapEmbed }}"
            title="{{ $dataCentre->name }} location map"
            class="w-full h-[320px] sm:h-[400px] lg:h-[440px] border-0"
            allowfullscreen
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
        ></iframe>
    </div>
</x-public.section>
@endif

@if($features->count())
<x-public.section tone="dark">
    <h2 class="eq-headline-section text-white mb-10">Technical capabilities</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">
        @foreach($features as $feature)
            <div class="border border-white/15 p-8">
                <h3 class="text-lg font-bold text-white mb-2">{{ $feature->title }}</h3>
                <div class="text-white/70 text-sm cms-content">{!! rich_content($feature->description) !!}</div>
            </div>
        @endforeach
    </div>
</x-public.section>
@endif

@if($gallery->count())
<x-public.section x-data="{ lightbox: null }">
    <h2 class="eq-headline-section text-brand-900 mb-10 text-center">Project gallery</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($gallery as $item)
            <button type="button" @click="lightbox = '{{ Storage::url($item->image) }}'" class="aspect-square overflow-hidden border border-brand-200 focus:outline-none focus:ring-2 focus:ring-brand-teal-500">
                <img src="{{ Storage::url($item->image) }}" alt="{{ $item->alt_text ?? $item->caption }}" class="w-full h-full object-cover hover:scale-105 transition duration-500">
            </button>
        @endforeach
    </div>
    <div x-show="lightbox" x-cloak @click="lightbox = null" class="fixed inset-0 z-[80] bg-black/90 flex items-center justify-center p-4">
        <img :src="lightbox" alt="" class="max-w-full max-h-[90vh]" @click.stop>
    </div>
</x-public.section>
@endif

<x-public.cta-band
    :title="$dataCentre->cta_heading ?? 'Discuss your next project'"
    :description="$dataCentre->cta_description ?? 'Contact our advisory team to explore your infrastructure strategy.'"
    :primary-url="$dataCentre->cta_button_url ?? route('contact.index')"
    :primary-label="$dataCentre->cta_button_text ?? 'Start a conversation'"
/>
@endsection
