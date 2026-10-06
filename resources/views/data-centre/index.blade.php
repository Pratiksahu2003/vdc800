@extends('layouts.app')

@section('title', 'Projects — ' . (settings('company.company_name') ?? 'VDC800'))
@section('meta_description', 'Explore VDC800 projects and case studies — strategy, design, and infrastructure advisory.')

@section('content')
<div class="relative bg-[#08100f] overflow-hidden">

    {{-- Background image --}}
    <div class="absolute inset-0">
        <img src="/images/hero-datacenter.jpg" alt="Projects" class="w-full h-full object-cover object-center opacity-20">
        {{-- Strong left fade so text always has a dark base --}}
        <div class="absolute inset-0" style="background: linear-gradient(105deg, #08100f 0%, #08100f 35%, rgba(8,16,15,0.85) 60%, rgba(8,16,15,0.45) 100%);"></div>
        <div class="absolute inset-0" style="background: linear-gradient(to top, #08100f 0%, transparent 50%);"></div>
    </div>

    {{-- Glowing accent orbs --}}
    <div class="absolute top-[-80px] right-[10%] w-[420px] h-[420px] bg-brand-teal-500/15 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-[20%] w-[300px] h-[200px] bg-brand-mint-400/8 rounded-full blur-[80px] pointer-events-none"></div>

    {{-- Bottom border accent --}}
    <div class="absolute left-0 right-0 bottom-0 h-px bg-gradient-to-r from-transparent via-brand-teal-500/40 to-transparent"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-12 lg:gap-16">

            {{-- Left: text content --}}
            <div class="flex-1 min-w-0">
                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-brand-teal-500/10 border border-brand-teal-500/25 mb-6">
                    <span class="w-1.5 h-1.5 rounded-full bg-brand-mint-400 animate-pulse flex-shrink-0"></span>
                    <span class="text-brand-mint-400 text-[11px] font-bold tracking-[0.2em] uppercase">Projects &amp; Case Studies</span>
                </div>

                {{-- Headline — inline style avoids Tailwind bg-clip-text clipping bug --}}
                <h1 class="font-display text-white tracking-tight mb-6" style="font-size: clamp(2.25rem, 5vw, 3.5rem); line-height: 1.15;">
                    Work that moves<br>
                    <span style="background: linear-gradient(90deg, #4ecca3 0%, #a7f3d0 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; padding-bottom: 4px; display: inline-block;">infrastructure forward.</span>
                </h1>

                <p class="text-white/60 text-lg leading-relaxed max-w-lg mb-8">
                    Real-world solutions across critical power, capacity planning, and data centre advisory.
                </p>

                {{-- Decorative divider --}}
                <div class="w-16 h-0.5 bg-gradient-to-r from-brand-teal-400 to-transparent rounded-full"></div>
            </div>

            {{-- Right: stat cards --}}
            <div class="flex flex-row lg:flex-col gap-3 shrink-0">
                @php
                    $stats = [
                        ['value' => '3+',   'label' => 'Active Projects',    'icon' => 'folder-open'],
                        ['value' => '100%', 'label' => 'Client Satisfaction','icon' => 'star'],
                        ['value' => 'MVA',  'label' => 'Scale Delivered',    'icon' => 'zap'],
                    ];
                @endphp
                @foreach($stats as $stat)
                    <div class="flex items-center gap-4 px-5 py-4 rounded-xl border border-white/10 bg-white/5 backdrop-blur-md min-w-[160px] lg:min-w-[180px]">
                        <div class="w-9 h-9 rounded-lg bg-brand-teal-500/15 border border-brand-teal-500/20 flex items-center justify-center shrink-0">
                            <i data-lucide="{{ $stat['icon'] }}" class="w-4 h-4 text-brand-mint-400"></i>
                        </div>
                        <div>
                            <p class="font-display text-2xl text-white leading-none font-bold">{{ $stat['value'] }}</p>
                            <p class="text-white/45 text-[10px] font-semibold tracking-[0.15em] uppercase mt-1">{{ $stat['label'] }}</p>
                        </div>
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
