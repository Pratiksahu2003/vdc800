@extends('layouts.app')

@section('title', 'Projects — ' . (settings('company.company_name') ?? 'VDC800'))
@section('meta_description', 'Explore VDC800 projects and case studies — strategy, design, and infrastructure advisory.')

@section('content')
<div class="relative bg-[#0b1211]">
    {{-- Background image + layered gradients --}}
    <div class="absolute inset-0">
        <img src="/images/hero-datacenter.jpg" alt="Projects" class="w-full h-full object-cover object-center opacity-25">
        <div class="absolute inset-0 bg-gradient-to-r from-[#0b1211] via-[#0b1211]/90 to-[#0b1211]/40"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#0b1211]/80 via-transparent to-transparent"></div>
    </div>

    {{-- Subtle glowing orb accent --}}
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-brand-teal-600/10 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-8 py-20 lg:py-24">
            {{-- Left: text --}}
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-brand-teal-500/10 border border-brand-teal-500/30 mb-5">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand-mint-400 animate-pulse"></span>
                    <span class="text-brand-mint-400 text-[11px] font-bold tracking-[0.18em] uppercase">Projects & Case Studies</span>
                </div>
                <h1 class="font-display text-4xl sm:text-5xl lg:text-[3.5rem] text-white leading-[1.15] tracking-tight mb-4 pb-1">
                    Work that moves <br class="hidden sm:block"><span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-teal-400 to-brand-mint-300 inline-block">infrastructure forward.</span>
                </h1>
                <p class="text-brand-300 text-base sm:text-lg leading-relaxed max-w-xl">
                    Real-world solutions across critical power, capacity planning, and data centre advisory.
                </p>
            </div>

            {{-- Right: stat strip --}}
            <div class="flex flex-row lg:flex-col gap-px lg:gap-0 shrink-0 rounded-2xl overflow-hidden border border-white/10 bg-white/5 backdrop-blur-md">
                @php
                    $stats = [
                        ['value' => '3+', 'label' => 'Active Projects'],
                        ['value' => '100%', 'label' => 'Client Satisfaction'],
                        ['value' => 'MVA', 'label' => 'Scale Delivered'],
                    ];
                @endphp
                @foreach($stats as $stat)
                    <div class="px-6 py-4 lg:border-b border-white/10 last:border-0 text-center lg:text-left min-w-[120px]">
                        <p class="font-display text-2xl text-white leading-none">{{ $stat['value'] }}</p>
                        <p class="text-white/50 text-[11px] font-medium tracking-wide uppercase mt-1">{{ $stat['label'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<section class="py-20 lg:py-32 bg-[#f4f3ef]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($dataCentres->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($dataCentres as $dataCentre)
                    <a href="{{ route('data-centre.show', $dataCentre) }}" class="group relative rounded-2xl overflow-hidden bg-white border border-brand-200 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(8,126,118,0.15)] flex flex-col h-full min-h-[420px]">
                        <div class="absolute inset-0 z-10" style="background: linear-gradient(to bottom, rgba(0,0,0,0.05) 0%, rgba(0,0,0,0.15) 30%, rgba(0,0,0,0.6) 55%, rgba(0,0,0,0.92) 100%);"></div>
                        <img
                            src="{{ hero_image_url($dataCentre->hero_image, 'images/hero-datacenter.jpg') }}"
                            alt="{{ $dataCentre->name }}"
                            class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out"
                        >
                        @if($dataCentre->is_featured)
                            <div class="absolute top-4 left-4 z-20">
                                <span class="backdrop-blur-md bg-white/20 border border-white/30 text-white px-3 py-1.5 rounded-full text-xs font-bold tracking-wider uppercase">Featured</span>
                            </div>
                        @endif
                        <div class="relative z-20 mt-auto p-6 lg:p-8 flex flex-col">
                            @if($dataCentre->location)
                                <p class="text-brand-mint-300 text-xs font-bold tracking-[0.1em] uppercase mb-3" style="text-shadow: 0 1px 4px rgba(0,0,0,0.8);">
                                    {{ $dataCentre->location }}
                                </p>
                            @endif
                            <h2 class="text-2xl font-display text-white mb-2 leading-tight" style="text-shadow: 0 2px 8px rgba(0,0,0,0.9);">{{ $dataCentre->name }}</h2>
                            <p class="text-white/80 text-sm leading-relaxed mb-5 line-clamp-2" style="text-shadow: 0 1px 4px rgba(0,0,0,0.8);">{{ $dataCentre->short_description }}</p>
                            
                            <div class="mt-auto pt-4 border-t border-white/20 flex items-center justify-between text-white group-hover:text-brand-mint-300 transition-colors">
                                <span class="text-sm font-semibold tracking-wide">View Project</span>
                                <div class="w-8 h-8 rounded-full border border-current flex items-center justify-center transform group-hover:translate-x-1 transition-transform">
                                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-3xl border border-brand-200">
                <i data-lucide="folder-open" class="w-16 h-16 text-brand-300 mx-auto mb-4"></i>
                <p class="text-brand-600 text-lg">No projects are published yet. Please check back soon.</p>
            </div>
        @endif
    </div>
</section>
@endsection
