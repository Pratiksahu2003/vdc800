@props([
    'title',
    'description',
    'lastUpdated' => null,
    'heroLabel' => 'Legal',
])

<x-page-hero fallback="images/hero-slide-4.jpg" :alt="$title" size="md">
    <p class="text-brand-teal-400 text-sm font-medium tracking-widest uppercase mb-3">{{ $heroLabel }}</p>
    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl mb-4">{{ $title }}</h1>
    <p class="text-brand-200 text-base sm:text-lg max-w-2xl leading-relaxed">{{ $description }}</p>
</x-page-hero>

<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            @if($lastUpdated)
                <p class="text-sm text-brand-500 mb-8 pb-8 border-b border-brand-200">
                    Last updated: <time datetime="{{ $lastUpdated }}">{{ $lastUpdated }}</time>
                </p>
            @endif

            <div {{ $attributes->merge(['class' => 'legal-content space-y-10']) }}>
                {{ $slot }}
            </div>

            <div class="mt-12 pt-8 border-t border-brand-200">
                <p class="text-sm font-semibold text-brand-900 mb-4">Related policies</p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('legal.privacy') }}" class="px-4 py-2 rounded-full text-sm font-medium border border-brand-200 text-brand-700 hover:border-brand-red-300 hover:text-brand-red-600 transition">Privacy Policy</a>
                    <a href="{{ route('legal.terms') }}" class="px-4 py-2 rounded-full text-sm font-medium border border-brand-200 text-brand-700 hover:border-brand-red-300 hover:text-brand-red-600 transition">Terms of Service</a>
                    <a href="{{ route('legal.cookies') }}" class="px-4 py-2 rounded-full text-sm font-medium border border-brand-200 text-brand-700 hover:border-brand-red-300 hover:text-brand-red-600 transition">Cookie Policy</a>
                    <a href="{{ route('legal.sitemap') }}" class="px-4 py-2 rounded-full text-sm font-medium border border-brand-200 text-brand-700 hover:border-brand-red-300 hover:text-brand-red-600 transition">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</section>
