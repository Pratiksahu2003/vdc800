@props([
    'title',
    'description' => null,
    'primaryUrl' => null,
    'primaryLabel' => 'Schedule a discovery session',
    'secondaryUrl' => null,
    'secondaryLabel' => 'Talk to an expert',
])

<section class="eq-dark-band py-16 lg:py-20" data-eq-reveal>
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="eq-headline-section text-white mb-4 max-w-3xl mx-auto">{{ $title }}</h2>
        @if($description)
            <p class="text-white/70 text-lg mb-8 max-w-2xl mx-auto">{{ $description }}</p>
        @endif
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ $primaryUrl ?? route('contact.index') }}" class="eq-btn-primary">{{ $primaryLabel }}</a>
            <a href="{{ $secondaryUrl ?? route('contact.index') }}" class="eq-btn-outline-light">{{ $secondaryLabel }}</a>
        </div>
    </div>
</section>
