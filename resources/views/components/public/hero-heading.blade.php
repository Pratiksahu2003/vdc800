@props([
    'eyebrow' => null,
    'title',
    'description' => null,
    'center' => true,
])

<div @class([
    'max-w-4xl',
    'mx-auto text-center' => $center,
    'max-w-3xl' => ! $center,
])>
    @if($eyebrow)
        <p class="text-brand-teal-400 text-xs font-bold tracking-widest uppercase mb-4">{{ $eyebrow }}</p>
    @endif
    @if(isset($title) && ! ($title instanceof \Illuminate\View\ComponentSlot))
        <h1 class="eq-headline-hero text-white mb-6">{!! $title !!}</h1>
    @elseif(isset($title))
        <h1 class="eq-headline-hero text-white mb-6">{{ $title }}</h1>
    @endif
    @if($description)
        <div class="text-white/75 text-base sm:text-lg leading-relaxed max-w-2xl {{ $center ? 'mx-auto' : '' }}">
            @if($description instanceof \Illuminate\View\ComponentSlot)
                {{ $description }}
            @else
                <p>{{ $description }}</p>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>
