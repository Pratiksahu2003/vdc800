@extends('layouts.app')

@section('title', ($dataCentre->meta_title ?? $dataCentre->name ?? 'Project') . ' — ' . (settings('company.company_name') ?? 'D³ DataCenters'))
@section('meta_description', $dataCentre->meta_description ?? $dataCentre->short_description)

@section('content')
<x-page-hero :image="$dataCentre->hero_image" fallback="images/hero-datacenter.jpg" :alt="$dataCentre->name" size="lg" align="center">
    <x-public.hero-heading :title="$dataCentre->name" :description="$dataCentre->short_description">
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

@if($dataCentre->full_description)
<x-public.section>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <div class="lg:col-span-4">
            <h2 class="eq-headline-section text-brand-900 text-2xl mb-4">About the project</h2>
            @if($dataCentre->address)
                <p class="text-sm text-brand-600"><i data-lucide="map-pin" class="w-4 h-4 inline text-brand-teal-600"></i> {{ $dataCentre->address }}</p>
            @endif
        </div>
        <div class="lg:col-span-8 cms-content">{!! rich_content($dataCentre->full_description) !!}</div>
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
                <p class="text-white/70 text-sm">{{ $feature->description }}</p>
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
