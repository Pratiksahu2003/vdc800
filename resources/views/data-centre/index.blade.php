@extends('layouts.app')

@section('title', 'Projects — ' . (settings('company.company_name') ?? 'VDC800'))
@section('meta_description', 'Explore VDC800 projects and case studies — strategy, design, and infrastructure advisory.')

@section('content')
<div class="relative bg-[#0b1211] overflow-hidden">
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-brand-teal-900/40 via-[#0b1211] to-[#0b1211]"></div>
        <div class="absolute inset-0 bg-[url('/images/grid.svg')] bg-center [mask-image:linear-gradient(180deg,white,rgba(255,255,255,0))]"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
        <div class="max-w-3xl">
            <p class="text-brand-mint-400 text-sm font-bold tracking-[0.15em] uppercase mb-4 flex items-center gap-2">
                <span class="w-8 h-[2px] bg-brand-mint-400"></span> Projects
            </p>
            <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl mb-6 text-white leading-[1.1] tracking-tight">
                Representative work across the <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-teal-400 to-brand-mint-300">infrastructure stack.</span>
            </h1>
            <p class="text-brand-300 text-lg sm:text-xl max-w-2xl leading-relaxed font-light">
                Selected examples of the technical and commercial problems we solve — from critical power to capacity planning.
            </p>
        </div>
    </div>
</div>

<section class="py-20 lg:py-32 bg-[#f4f3ef]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($dataCentres->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($dataCentres as $dataCentre)
                    <a href="{{ route('data-centre.show', $dataCentre) }}" class="group relative rounded-2xl overflow-hidden bg-white border border-brand-200 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_40px_-15px_rgba(8,126,118,0.15)] flex flex-col h-full min-h-[420px]">
                        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/80 z-10"></div>
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
                                <p class="text-brand-mint-300 text-xs font-bold tracking-[0.1em] uppercase mb-3 drop-shadow-md">
                                    {{ $dataCentre->location }}
                                </p>
                            @endif
                            <h2 class="text-2xl font-display text-white mb-2 leading-tight drop-shadow-md">{{ $dataCentre->name }}</h2>
                            <p class="text-brand-100 text-sm leading-relaxed mb-5 line-clamp-2 drop-shadow-md">{{ $dataCentre->short_description }}</p>
                            
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
