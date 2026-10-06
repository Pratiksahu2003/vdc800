@extends('layouts.app')

@section('title', ($solution->meta_title ?? $solution->title) . ' — ' . (settings('company.company_name') ?? 'VDC800'))
@section('meta_description', $solution->meta_description ?? $solution->short_description)

@section('content')
@php
    $solutionHeroFallbacks = [
        'financial-services' => 'images/hero-slide-4.jpg',
        'research-hpc' => 'images/hero-slide-3.jpg',
        'media-streaming' => 'images/hero-slide-2.jpg',
    ];
    $solutionHeroFallback = $solutionHeroFallbacks[$solution->slug] ?? 'images/data-centre-facility.jpg';
@endphp
<x-page-hero
    :image="$solution->featured_image ?? null"
    :fallback="$solutionHeroFallback"
    :alt="$solution->title"
    size="lg"
>
    <a href="{{ route('solutions.index') }}" class="inline-flex items-center gap-2 text-brand-300 hover:text-white text-sm mb-4 transition">
        <i data-lucide="arrow-left" class="w-4 h-4"></i> All Solutions
    </a>
    <div class="flex items-start gap-3 sm:gap-4 min-w-0">
        @if($solution->icon)
            <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl bg-white/10 backdrop-blur flex items-center justify-center shrink-0 border border-white/20">
                <i data-lucide="{{ $solution->icon }}" class="w-6 h-6 sm:w-7 sm:h-7 text-brand-teal-300"></i>
            </div>
        @endif
        <div class="min-w-0">
            <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl mb-3 max-w-3xl">{{ $solution->title }}</h1>
            <p class="text-brand-200 text-base sm:text-lg max-w-2xl leading-relaxed">{{ $solution->short_description }}</p>
        </div>
    </div>
</x-page-hero>

<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
            <div class="lg:col-span-2 min-w-0 space-y-8">
                <x-cms-content class="text-brand-700 text-base sm:text-lg leading-relaxed">
                    {!! rich_content($solution->description) !!}
                </x-cms-content>

                @if($solution->benefits && count($solution->benefits))
                    <div>
                        <h2 class="font-display text-2xl sm:text-3xl text-brand-900 mb-6">Key Benefits</h2>
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                            @foreach($solution->benefits as $benefit)
                                <li class="flex items-start gap-3 bg-brand-50 rounded-xl p-4">
                                    <div class="w-8 h-8 rounded-lg bg-brand-teal-100 flex items-center justify-center shrink-0 mt-0.5">
                                        <i data-lucide="check" class="w-4 h-4 text-brand-teal-700"></i>
                                    </div>
                                    <span class="text-brand-700">{{ $benefit }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="min-w-0">
                <div class="bg-brand-100 rounded-2xl p-6 sm:p-8 lg:sticky lg:top-28">
                    <h3 class="font-semibold text-brand-900 mb-4">Ready to get started?</h3>
                    <p class="text-brand-600 text-sm mb-6">Discuss how {{ $solution->title }} can meet your infrastructure requirements.</p>
                    <a href="{{ $solution->cta_url ?? route('contact.index') }}" class="flex items-center justify-center gap-2 w-full px-6 py-3.5 bg-brand-teal-600 hover:bg-brand-teal-500 text-white font-medium rounded-full transition">
                        {{ $solution->cta_text ?? 'Contact Us' }}
                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
