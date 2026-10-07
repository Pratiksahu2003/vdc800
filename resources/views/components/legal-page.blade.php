@props([
    'title',
    'description',
    'lastUpdated' => null,
    'heroLabel' => 'Legal',
])

<x-page-hero fallback="images/hero-slide-4.jpg" :alt="$title" size="md" align="center">
    <x-public.hero-heading :eyebrow="$heroLabel" :title="$title" :description="$description" />
</x-page-hero>

<x-public.section padding="sm">
    <div class="max-w-3xl mx-auto">
        @if($lastUpdated)
            <p class="text-sm text-brand-500 mb-8 pb-8 border-b border-brand-200">
                Last updated: <time datetime="{{ $lastUpdated }}">{{ $lastUpdated }}</time>
            </p>
        @endif

        <div {{ $attributes->merge(['class' => 'legal-content space-y-10']) }}>
            {{ $slot }}
        </div>

        <div class="mt-12 pt-8 border-t border-brand-200 flex flex-wrap gap-3">
            <a href="{{ route('legal.privacy') }}" class="eq-filter-chip">Privacy</a>
            <a href="{{ route('legal.terms') }}" class="eq-filter-chip">Terms</a>
            <a href="{{ route('legal.cookies') }}" class="eq-filter-chip">Cookies</a>
        </div>
    </div>
</x-public.section>
