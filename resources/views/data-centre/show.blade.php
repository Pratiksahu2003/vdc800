@extends('layouts.app')

@section('title', ($dataCentre->meta_title ?? $dataCentre->name ?? 'Data Centre') . ' — ' . (settings('company.company_name') ?? 'VDC800'))
@section('meta_description', $dataCentre->meta_description ?? $dataCentre->short_description)

@section('content')
<x-page-hero
    :image="$dataCentre->hero_image"
    fallback="images/data-centre-facility.jpg"
    :alt="$dataCentre->name ?? 'Data Centre'"
    size="xl"
>
    <a href="{{ route('data-centre.index') }}" class="inline-flex items-center gap-2 text-brand-300 hover:text-white text-sm mb-4 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> All Data Centres
    </a>
    @if($dataCentre->location)
        <p class="text-brand-teal-400 text-sm font-medium tracking-widest uppercase mb-3 flex items-center gap-2">
            <i data-lucide="map-pin" class="w-4 h-4"></i>
            {{ $dataCentre->location }}@if($dataCentre->country), {{ $dataCentre->country }}@endif
        </p>
    @endif
    <h1 class="font-display text-4xl sm:text-5xl lg:text-7xl mb-4 max-w-4xl">{{ $dataCentre->name ?? 'Nordic Data Centre' }}</h1>
    <p class="text-brand-200 text-base sm:text-lg max-w-2xl leading-relaxed">{{ $dataCentre->short_description ?? 'State-of-the-art sustainable data centre infrastructure in the Nordic region.' }}</p>
</x-page-hero>

@if($specifications->count())
<section class="py-12 sm:py-16 lg:py-20 bg-white border-b border-brand-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-6 sm:gap-8">
            @foreach($specifications as $spec)
                <div class="text-center px-2">
                    <div class="w-12 h-12 rounded-xl bg-brand-teal-100 flex items-center justify-center mx-auto mb-3 sm:mb-4">
                        <i data-lucide="{{ $spec->icon ?? 'gauge' }}" class="w-6 h-6 text-brand-teal-700"></i>
                    </div>
                    <p class="font-display text-2xl sm:text-3xl lg:text-4xl text-brand-900 mb-1 break-words">
                        {{ $spec->value }}@if($spec->unit)<span class="text-lg sm:text-xl text-brand-teal-600">{{ $spec->unit }}</span>@endif
                    </p>
                    <p class="font-medium text-brand-700 text-sm sm:text-base">{{ $spec->label }}</p>
                    @if($spec->description)
                        <p class="text-sm text-brand-500 mt-1">{{ $spec->description }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($dataCentre->full_description)
<section class="py-16 lg:py-24 xl:py-32">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 xl:gap-20 items-start">
            <div class="min-w-0">
                <h2 class="font-display text-3xl sm:text-4xl text-brand-900 mb-6">About This Facility</h2>
                <x-cms-content class="text-brand-600 text-base sm:text-lg">
                    {!! rich_content($dataCentre->full_description) !!}
                </x-cms-content>
            </div>
            @if($dataCentre->address || ($dataCentre->latitude && $dataCentre->longitude))
                <div class="bg-brand-100 rounded-2xl p-6 sm:p-8 min-w-0">
                    <h3 class="font-semibold text-brand-900 mb-4 flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-5 h-5 text-brand-teal-600"></i> Location
                    </h3>
                    @if($dataCentre->address)
                        <p class="text-brand-600 mb-4">{{ $dataCentre->address }}</p>
                    @endif
                    @if($dataCentre->latitude && $dataCentre->longitude)
                        <a href="https://maps.google.com/?q={{ $dataCentre->latitude }},{{ $dataCentre->longitude }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-brand-teal-700 font-medium hover:text-brand-teal-600 transition">
                            View on map <i data-lucide="external-link" class="w-4 h-4"></i>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>
@endif

@if($features->count())
<section class="py-24 bg-brand-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <h2 class="font-display text-4xl text-brand-900 mb-4">Facility Features</h2>
            <p class="text-brand-600">Enterprise-grade infrastructure designed for reliability, security, and scale.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($features as $feature)
                <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition">
                    @if($feature->image)
                        <img src="{{ Storage::url($feature->image) }}" alt="{{ $feature->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-brand-200 flex items-center justify-center">
                            <i data-lucide="{{ $feature->icon ?? 'shield' }}" class="w-12 h-12 text-brand-400"></i>
                        </div>
                    @endif
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-brand-900 mb-2">{{ $feature->title }}</h3>
                        <p class="text-brand-600">{{ $feature->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($gallery->count())
<section class="py-24" x-data="{ lightbox: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-display text-4xl text-brand-900 mb-12 text-center">Gallery</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($gallery as $item)
                <button @click="lightbox = '{{ Storage::url($item->image) }}'" type="button" class="aspect-square rounded-xl overflow-hidden group relative">
                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->alt_text ?? $item->caption }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @if($item->caption)
                        <div class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent p-3 opacity-0 group-hover:opacity-100 transition">
                            <p class="text-white text-sm">{{ $item->caption }}</p>
                        </div>
                    @endif
                </button>
            @endforeach
        </div>
    </div>

    <div x-show="lightbox" x-cloak @click="lightbox = null" @keydown.escape.window="lightbox = null" class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4">
        <button @click="lightbox = null" class="absolute top-4 right-4 text-white/70 hover:text-white">
            <i data-lucide="x" class="w-8 h-8"></i>
        </button>
        <img :src="lightbox" alt="" class="max-w-full max-h-[90vh] rounded-lg" @click.stop>
    </div>
</section>
@endif

@if($dataCentre->hero_video_url)
<section class="py-24 bg-brand-900">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="aspect-video rounded-2xl overflow-hidden shadow-2xl">
            <iframe src="{{ $dataCentre->hero_video_url }}" class="w-full h-full" allowfullscreen loading="lazy" title="Data centre video"></iframe>
        </div>
    </div>
</section>
@endif

<section class="py-24 lg:py-32">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="font-display text-4xl lg:text-5xl text-brand-900 mb-6">
            {{ $dataCentre->cta_heading ?? 'Tour our facility' }}
        </h2>
        <p class="text-lg text-brand-600 mb-10 max-w-2xl mx-auto">
            {{ $dataCentre->cta_description ?? 'Schedule a visit or speak with our team about colocation and infrastructure options.' }}
        </p>
        <a href="{{ $dataCentre->cta_button_url ?? route('contact.index') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-brand-teal-600 hover:bg-brand-teal-500 text-white font-medium rounded-full transition">
            {{ $dataCentre->cta_button_text ?? 'Contact Us' }}
            <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
</section>
@endsection
