@extends('layouts.app')

@section('title', 'Data Centres — ' . (settings('company.company_name') ?? 'VDC800'))
@section('meta_description', 'Explore VDC800 Nordic data centre facilities — Tier III+ colocation across Northern Europe.')

@section('content')
<x-page-hero fallback="images/data-centre-facility.jpg" alt="Our Data Centres" size="md">
    <p class="text-brand-teal-400 text-sm font-medium tracking-widest uppercase mb-3">Our Facilities</p>
    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl mb-4 max-w-3xl">Nordic Data Centres</h1>
    <p class="text-brand-200 text-base sm:text-lg max-w-2xl leading-relaxed">Tier III+ facilities engineered for 99.999% uptime across Scandinavia.</p>
</x-page-hero>

<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($dataCentres->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($dataCentres as $dataCentre)
                    <a href="{{ route('data-centre.show', $dataCentre) }}" class="group bg-white rounded-2xl border border-brand-200 overflow-hidden hover:shadow-xl hover:border-brand-teal-200 transition">
                        <div class="relative h-52 overflow-hidden bg-brand-100">
                            <img
                                src="{{ hero_image_url($dataCentre->hero_image, 'images/data-centre-facility.jpg') }}"
                                alt="{{ $dataCentre->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                            >
                            @if($dataCentre->is_featured)
                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-brand-teal-600 text-white text-xs font-medium">Featured</span>
                            @endif
                        </div>
                        <div class="p-6 lg:p-7">
                            @if($dataCentre->location)
                                <p class="text-sm text-brand-teal-600 font-medium mb-2 flex items-center gap-1.5">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                    {{ $dataCentre->location }}@if($dataCentre->country), {{ $dataCentre->country }}@endif
                                </p>
                            @endif
                            <h2 class="text-xl font-semibold text-brand-900 mb-2 group-hover:text-brand-teal-700 transition">{{ $dataCentre->name }}</h2>
                            <p class="text-brand-600 text-sm leading-relaxed">{{ Str::limit($dataCentre->short_description, 140) }}</p>
                            <span class="inline-flex items-center gap-1.5 mt-4 text-sm font-medium text-brand-teal-600 group-hover:gap-2.5 transition-all">
                                View facility <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <p class="text-brand-600">No data centres are published yet. Please check back soon.</p>
            </div>
        @endif
    </div>
</section>
@endsection
