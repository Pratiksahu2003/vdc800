@extends('layouts.app')

@php($seo = seo_for_route('data-centre.index'))
@section('title', $seo['title'])
@section('meta_description', $seo['description'])
@section('meta_keywords', $seo['keywords'])

@section('content')
<x-page-hero fallback="images/hero-datacenter.jpg" alt="Projects" size="lg" align="center">
    <x-public.hero-heading
        eyebrow="Projects &amp; case studies"
        title="Work that moves infrastructure forward"
        description="Real-world advisory across critical power, capacity planning, and data centre strategy."
    />
</x-page-hero>

@if($mapLocations->isNotEmpty())
<x-public.section>
    <x-public.data-centres-map :locations="$mapLocations" />
</x-public.section>
@endif

<x-public.section tone="muted">
    @if($dataCentres->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($dataCentres as $dataCentre)
                <a href="{{ route('data-centre.show', $dataCentre) }}" class="eq-resource-card group">
                    <img src="{{ hero_image_url($dataCentre->hero_image, 'images/hero-datacenter.jpg') }}" alt="{{ $dataCentre->name }}" class="w-full h-52 object-cover">
                    <div class="p-6">
                        @if($dataCentre->location)
                            <p class="text-xs font-bold uppercase tracking-widest text-brand-teal-600 mb-2">{{ $dataCentre->location }}</p>
                        @endif
                        <h2 class="text-lg font-bold text-brand-900 mb-2 group-hover:text-brand-teal-700 transition">{{ $dataCentre->name }}</h2>
                        <p class="text-sm text-brand-600 line-clamp-3">{{ Str::limit(strip_tags($dataCentre->short_description ?? ''), 160) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-brand-600 text-center py-16">No projects published yet.</p>
    @endif
</x-public.section>

<x-public.cta-band title="Discuss your next project with our team" />
@endsection
