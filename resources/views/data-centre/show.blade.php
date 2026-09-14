@extends('layouts.app')

@section('title', ($dataCentre->meta_title ?? $dataCentre->name ?? 'Project') . ' — ' . (settings('company.company_name') ?? 'VDC800'))
@section('meta_description', $dataCentre->meta_description ?? $dataCentre->short_description)

@section('content')
<div class="relative bg-[#0b1211] overflow-hidden">
    {{-- Background image --}}
    <div class="absolute inset-0">
        <img src="{{ hero_image_url($dataCentre->hero_image, 'images/hero-datacenter.jpg') }}" alt="{{ $dataCentre->name }}" class="w-full h-full object-cover object-center opacity-30">
        <div class="absolute inset-0 bg-gradient-to-r from-[#0b1211] via-[#0b1211]/85 to-[#0b1211]/50"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0b1211] via-transparent to-transparent"></div>
    </div>
    {{-- Teal glow accent --}}
    <div class="absolute -top-40 right-20 w-[400px] h-[400px] bg-brand-teal-600/15 rounded-full blur-[90px] pointer-events-none"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb bar --}}
        <div class="pt-8 pb-0 border-b border-white/10">
            <a href="{{ route('data-centre.index') }}" class="inline-flex items-center gap-1.5 text-white/50 hover:text-brand-mint-400 text-xs font-semibold tracking-widest uppercase transition group pb-4">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5 transform group-hover:-translate-x-0.5 transition-transform"></i>
                All Projects
            </a>
        </div>

        {{-- Main hero content --}}
        <div class="flex flex-col lg:flex-row lg:items-end gap-8 lg:gap-16 py-14 lg:py-16">
            {{-- Left: title block --}}
            <div class="flex-1 min-w-0">
                @if($dataCentre->location)
                    <p class="text-brand-teal-400 text-[11px] font-bold tracking-[0.2em] uppercase mb-3 flex items-center gap-2">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                        {{ $dataCentre->location }}@if($dataCentre->country), {{ $dataCentre->country }}@endif
                    </p>
                @endif
                <h1 class="font-display text-4xl sm:text-5xl lg:text-[3.25rem] text-white leading-[1.1] tracking-tight mb-4 max-w-2xl">
                    {{ $dataCentre->name ?? 'Project Overview' }}
                </h1>
                <p class="text-brand-300 text-base sm:text-lg leading-relaxed max-w-xl font-light">
                    {{ $dataCentre->short_description }}
                </p>
            </div>

            {{-- Right: specs card --}}
            @if($specifications->count())
            <div class="shrink-0 w-full lg:w-72 xl:w-80">
                <div class="rounded-2xl border border-white/10 bg-white/5 backdrop-blur-md overflow-hidden">
                    <div class="px-5 py-3 border-b border-white/10 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-mint-400 animate-pulse"></span>
                        <p class="text-brand-mint-400 text-[10px] font-bold uppercase tracking-[0.18em]">Key Metrics</p>
                    </div>
                    <div class="divide-y divide-white/10">
                        @foreach($specifications->take(4) as $spec)
                        <div class="flex items-center justify-between px-5 py-3">
                            <span class="text-white/55 text-sm">{{ $spec->label }}</span>
                            <span class="text-white font-semibold text-sm">{{ $spec->value }}@if($spec->unit)<span class="text-brand-mint-300 ml-0.5 text-xs">{{ $spec->unit }}</span>@endif</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@if($dataCentre->full_description)
<section class="py-20 lg:py-32 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-24">
            <div class="lg:col-span-4">
                <div class="sticky top-32">
                    <h2 class="font-display text-3xl sm:text-4xl text-brand-900 mb-6">About the <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-teal-600 to-brand-teal-400">Project</span></h2>
                    <p class="text-brand-600 leading-relaxed mb-8">
                        We approached this project with a focus on scalability, resilience, and efficiency to meet the exact demands of modern infrastructure.
                    </p>
                    @if($dataCentre->address || ($dataCentre->latitude && $dataCentre->longitude))
                        <div class="bg-brand-50 rounded-2xl p-6">
                            <h3 class="font-semibold text-brand-900 mb-4 flex items-center gap-2">
                                <i data-lucide="map-pin" class="w-5 h-5 text-brand-teal-600"></i> Location
                            </h3>
                            @if($dataCentre->address)
                                <p class="text-brand-600 mb-4 text-sm">{{ $dataCentre->address }}</p>
                            @endif
                            @if($dataCentre->latitude && $dataCentre->longitude)
                                <a href="https://maps.google.com/?q={{ $dataCentre->latitude }},{{ $dataCentre->longitude }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-brand-teal-700 text-sm font-medium hover:text-brand-teal-600 transition">
                                    View on map <i data-lucide="external-link" class="w-4 h-4"></i>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
            <div class="lg:col-span-8 prose prose-lg prose-brand max-w-none">
                <x-cms-content class="text-brand-700 leading-relaxed">
                    {!! rich_content($dataCentre->full_description) !!}
                </x-cms-content>
            </div>
        </div>
    </div>
</section>
@endif

@if($features->count())
<section class="py-24 bg-[#0b1211] text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-16">
            <div class="max-w-2xl">
                <p class="text-brand-mint-400 text-sm font-bold tracking-[0.15em] uppercase mb-4">Key Features</p>
                <h2 class="font-display text-4xl sm:text-5xl mb-4 text-white">Technical Capabilities</h2>
                <p class="text-brand-300 text-lg">Designed for mission-critical reliability and performance.</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($features as $feature)
                <div class="group bg-white/5 border border-white/10 rounded-3xl p-8 hover:bg-white/10 transition-colors duration-300">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-brand-teal-500 to-brand-teal-700 flex items-center justify-center mb-6 shadow-lg shadow-brand-teal-900/50">
                        <i data-lucide="{{ $feature->icon ?? 'shield' }}" class="w-7 h-7 text-white"></i>
                    </div>
                    <h3 class="text-2xl font-display text-white mb-3">{{ $feature->title }}</h3>
                    <p class="text-brand-300 leading-relaxed">{{ $feature->description }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($specifications->count() > 3)
<section class="py-24 bg-[#f4f3ef]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="font-display text-4xl text-brand-900 mb-12 text-center">Full Specifications</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($specifications as $spec)
                <div class="bg-white rounded-2xl p-6 border border-brand-200 shadow-sm hover:shadow-md transition">
                    <i data-lucide="{{ $spec->icon ?? 'gauge' }}" class="w-6 h-6 text-brand-teal-600 mb-4"></i>
                    <p class="font-medium text-brand-600 text-sm mb-1">{{ $spec->label }}</p>
                    <p class="text-2xl font-display text-brand-900">
                        {{ $spec->value }}@if($spec->unit)<span class="text-brand-teal-600 ml-1 text-lg">{{ $spec->unit }}</span>@endif
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@if($gallery->count())
<section class="py-24 bg-white" x-data="{ lightbox: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="font-display text-4xl text-brand-900 mb-4">Project Gallery</h2>
            <p class="text-brand-600 max-w-2xl mx-auto">Visual overview of the infrastructure and deployment.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
            @foreach($gallery as $item)
                <button @click="lightbox = '{{ Storage::url($item->image) }}'" type="button" class="aspect-square rounded-2xl overflow-hidden group relative focus:outline-none focus:ring-4 focus:ring-brand-teal-500/30">
                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->alt_text ?? $item->caption }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-700 ease-out">
                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                            <i data-lucide="zoom-in" class="w-5 h-5 text-white"></i>
                        </div>
                    </div>
                </button>
            @endforeach
        </div>
    </div>

    <div x-show="lightbox" x-cloak @click="lightbox = null" @keydown.escape.window="lightbox = null" class="fixed inset-0 z-50 bg-[#0b1211]/95 backdrop-blur-sm flex items-center justify-center p-4">
        <button @click="lightbox = null" class="absolute top-6 right-6 text-white/50 hover:text-white transition bg-white/10 w-12 h-12 rounded-full flex items-center justify-center">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>
        <img :src="lightbox" alt="" class="max-w-full max-h-[90vh] rounded-xl shadow-2xl" @click.stop>
    </div>
</section>
@endif

@if($dataCentre->hero_video_url)
<section class="py-24 bg-[#0b1211]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="aspect-video rounded-3xl overflow-hidden shadow-2xl border border-white/10 relative group">
            <iframe src="{{ $dataCentre->hero_video_url }}" class="w-full h-full absolute inset-0 z-10" allowfullscreen loading="lazy" title="Project video"></iframe>
            <div class="absolute inset-0 bg-brand-teal-900/20 animate-pulse pointer-events-none"></div>
        </div>
    </div>
</section>
@endif

<section class="relative py-32 bg-brand-teal-900 overflow-hidden">
    <div class="absolute inset-0 bg-[url('/images/grid.svg')] opacity-20"></div>
    <div class="absolute top-0 right-0 w-[800px] h-[800px] bg-brand-mint-500/20 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center z-10">
        <h2 class="font-display text-4xl sm:text-5xl lg:text-6xl text-white mb-6 leading-tight">
            {{ $dataCentre->cta_heading ?? 'Discuss your next project.' }}
        </h2>
        <p class="text-xl text-brand-teal-100 mb-10 max-w-2xl mx-auto font-light">
            {{ $dataCentre->cta_description ?? 'Contact our advisory team to explore how we can support your infrastructure strategy.' }}
        </p>
        <a href="{{ $dataCentre->cta_button_url ?? route('contact.index') }}" class="inline-flex items-center gap-2 px-10 py-5 bg-white text-brand-teal-900 font-bold rounded-full hover:scale-105 hover:shadow-xl hover:shadow-white/20 transition-all duration-300">
            {{ $dataCentre->cta_button_text ?? 'Start a Conversation' }}
            <i data-lucide="arrow-right" class="w-5 h-5"></i>
        </a>
    </div>
</section>
@endsection
