@props([
    'tone' => 'white',
    'padding' => 'lg',
])

@php
    $tones = [
        'white' => 'bg-white',
        'muted' => 'bg-brand-50 border-y border-brand-200',
        'dark' => 'eq-dark-band text-white',
    ];
    $pads = [
        'sm' => 'py-12 lg:py-16',
        'lg' => 'py-20 lg:py-28',
    ];
@endphp

<section {{ $attributes->merge(['class' => ($tones[$tone] ?? $tones['white']) . ' ' . ($pads[$padding] ?? $pads['lg'])]) }} data-eq-reveal>
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        {{ $slot }}
    </div>
</section>
