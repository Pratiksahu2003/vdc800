@props([
    'image' => null,
    'fallback' => 'images/hero-datacenter.jpg',
    'alt' => '',
    'size' => 'md',
    'align' => 'end',
])

@php
    $heights = [
        'sm' => 'min-h-[38vh]',
        'md' => 'min-h-[42vh]',
        'lg' => 'min-h-[50vh]',
        'xl' => 'min-h-[70vh]',
    ];
    $heightClass = $heights[$size] ?? $heights['md'];
    $alignClass = $align === 'center' ? 'items-center' : 'items-end';
@endphp

<section class="page-hero-section relative pt-8 lg:pt-10 pb-16 lg:pb-20 bg-brand-900 text-white overflow-hidden {{ $heightClass }} flex {{ $alignClass }}">
    <div class="absolute inset-0 overflow-hidden">
        <img src="{{ hero_image_url($image, $fallback) }}" alt="{{ $alt }}" class="w-full h-full object-cover scale-105" data-hero-parallax>
        <div class="absolute inset-0 bg-gradient-to-r from-black/90 via-black/65 to-black/35"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/75 via-transparent to-black/25"></div>
    </div>
    <div {{ $attributes->merge(['class' => 'relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full pb-2']) }} data-page-hero-content>
        {{ $slot }}
    </div>
</section>
