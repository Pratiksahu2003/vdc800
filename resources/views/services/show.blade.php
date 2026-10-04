@extends('layouts.app')

@section('title', seo_entity_title($service->meta_title, $service->title, 'service'))
@section('meta_description', seo_description($service->meta_description, $service->short_description))
@section('meta_keywords', seo_entity_keywords('service', $service->title))
@section('og_type', 'article')
@if($ogImage = \App\Support\Seo::ogImage($service->og_image ?? $service->featured_image))
@section('og_image', $ogImage)
@endif

@section('content')
<x-page-hero :image="$service->featured_image" fallback="images/hero-datacenter.jpg" :alt="$service->title" size="lg" align="center">
    <x-public.hero-heading
        :center="true"
        :title="$service->title"
        :description="$service->short_description"
    >
        <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 mt-6 text-sm text-white/70 hover:text-white transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> All services
        </a>
    </x-public.hero-heading>
</x-page-hero>

<x-public.section>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
        <div class="lg:col-span-8 min-w-0 space-y-10">
            @if($service->items)
                <div class="space-y-6 border border-brand-200 divide-y divide-brand-200">
                    @foreach($service->items as $item)
                        <div class="p-6 lg:p-8">
                            <h2 class="text-xl font-bold text-brand-900 mb-2">{{ $item['title'] }}</h2>
                            <p class="text-brand-600 leading-relaxed">{{ $item['description'] }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
            @if($service->full_description)
                <x-cms-content class="cms-content text-brand-700">{!! rich_content($service->full_description) !!}</x-cms-content>
            @endif
        </div>
        <aside class="lg:col-span-4">
            <div class="border border-brand-200 p-6 lg:p-8 lg:sticky lg:top-28">
                <h3 class="text-lg font-bold text-brand-900 mb-3">Interested in this service?</h3>
                <p class="text-sm text-brand-600 mb-6">Tell us what you are planning — strategy, capacity, or delivery support.</p>
                <a href="{{ $service->cta_url ?? route('contact.index') }}" class="eq-btn-primary w-full text-center">
                    {{ $service->cta_text ?? 'Talk to our team' }}
                </a>
            </div>
        </aside>
    </div>
</x-public.section>

<x-public.cta-band :title="'Explore more from ' . (settings('company.short_name') ?? 'D³')" />
@endsection
