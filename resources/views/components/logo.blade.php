@props([
    'variant' => 'default',
    'class' => 'h-12 lg:h-14 w-auto max-w-none',
    'link' => true,
])

@php
    $url = logo_url($variant);
    $alt = settings('company.company_name') ?? 'VDC800';
    $tagline = settings('company.tagline');
@endphp

@if($link)
    <a href="{{ route('home') }}" {{ $attributes->merge(['class' => 'flex items-center gap-3 shrink-0']) }}>
        <img src="{{ $url }}" alt="{{ $alt }}" class="{{ $class }} object-contain object-left">
        @if($slot->isNotEmpty())
            {{ $slot }}
        @endif
    </a>
@else
    <img src="{{ $url }}" alt="{{ $alt }}" {{ $attributes->merge(['class' => $class . ' object-contain object-left']) }}>
@endif
