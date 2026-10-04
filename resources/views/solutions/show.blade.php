@extends('layouts.app')

@section('title', ($solution->meta_title ?? $solution->title) . ' — ' . (settings('company.company_name') ?? 'D³ DataCenters'))
@section('meta_description', $solution->meta_description ?? $solution->short_description)

@section('content')
@php
    $solutionHeroFallback = match ($solution->slug) {
        'financial-services' => 'images/hero-slide-4.jpg',
        'research-hpc' => 'images/hero-slide-3.jpg',
        'media-streaming' => 'images/hero-slide-2.jpg',
        default => 'images/data-centre-facility.jpg',
    };
@endphp

<x-page-hero :image="$solution->featured_image ?? null" :fallback="$solutionHeroFallback" :alt="$solution->title" size="lg" align="center">
    <x-public.hero-heading :title="$solution->title" :description="$solution->short_description">
        <a href="{{ route('solutions.index') }}" class="inline-flex items-center gap-2 mt-6 text-sm text-white/70 hover:text-white transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> All solutions
        </a>
    </x-public.hero-heading>
</x-page-hero>

<x-public.section>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <div class="lg:col-span-8 min-w-0">
            <x-cms-content class="cms-content">{!! rich_content($solution->description) !!}</x-cms-content>
            @if($solution->benefits && count($solution->benefits))
                <h2 class="eq-headline-section text-brand-900 text-2xl mt-12 mb-6">Key benefits</h2>
                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($solution->benefits as $benefit)
                        <li class="border border-brand-200 p-4 text-sm text-brand-700 flex gap-2">
                            <i data-lucide="check" class="w-4 h-4 text-brand-teal-600 shrink-0 mt-0.5"></i>
                            {{ $benefit }}
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <aside class="lg:col-span-4">
            <div class="border border-brand-200 p-6 lg:p-8 lg:sticky lg:top-28">
                <h3 class="text-lg font-bold text-brand-900 mb-3">Next step</h3>
                <p class="text-sm text-brand-600 mb-6">Discuss how this solution fits your infrastructure roadmap.</p>
                <a href="{{ route('contact.index') }}" class="eq-btn-primary w-full text-center">Talk to an expert</a>
            </div>
        </aside>
    </div>
</x-public.section>

<x-public.cta-band title="Built for teams who ship at scale" />
@endsection
