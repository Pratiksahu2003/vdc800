@extends('layouts.app')

@section('title', 'Our Services — ' . (settings('company.company_name') ?? 'VDC800'))
@section('meta_description', 'End-to-end advisory services for data centers and AI infrastructure — from opportunity to operations.')

@section('content')
<x-page-hero fallback="images/hero-datacenter.jpg" alt="Our Services" size="lg" align="center">
    <div class="text-center max-w-4xl mx-auto">
        <p class="text-brand-teal-400 text-sm font-medium tracking-widest uppercase mb-4">Our Services</p>
        <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl xl:text-7xl mb-6 leading-tight">
            From Strategy<br class="hidden sm:block"> to Scale.
        </h1>
        <p class="text-brand-200 text-base sm:text-lg lg:text-xl max-w-2xl mx-auto leading-relaxed">
            End-to-end advisory services for data centers and AI infrastructure — from opportunity to operations.
        </p>
    </div>
</x-page-hero>

@if($services->count())
<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
            @foreach($services as $index => $service)
                <article
                    x-data="{ expanded: false }"
                    class="group bg-white rounded-2xl border border-brand-200 overflow-hidden hover:shadow-xl hover:border-brand-teal-200 transition flex flex-col h-full"
                    data-hover-lift
                    :class="expanded && 'ring-2 ring-brand-teal-500/20 border-brand-teal-200 shadow-lg'"
                >
                    @if($service->featured_image)
                        <div class="block overflow-hidden">
                            <img
                                src="{{ hero_image_url($service->featured_image) }}"
                                alt="{{ $service->title }}"
                                class="w-full h-44 sm:h-48 object-cover group-hover:scale-105 transition duration-500"
                            >
                        </div>
                    @else
                        <div class="w-full h-44 sm:h-48 bg-gradient-to-br from-brand-100 to-brand-teal-50 flex items-center justify-center">
                            <i data-lucide="{{ $service->icon ?? 'compass' }}" class="w-14 h-14 text-brand-teal-500/70"></i>
                        </div>
                    @endif

                    <div class="p-6 lg:p-8 flex flex-col flex-1">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-brand-teal-50 text-brand-teal-700 text-xs font-bold tabular-nums">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            @if($service->icon)
                                <div class="w-10 h-10 rounded-xl bg-brand-teal-100 flex items-center justify-center group-hover:bg-brand-teal-600 transition">
                                    <i data-lucide="{{ $service->icon }}" class="w-5 h-5 text-brand-teal-700 group-hover:text-white transition"></i>
                                </div>
                            @endif
                        </div>

                        <h2 class="font-display text-xl sm:text-2xl font-semibold text-brand-900 mb-3">
                            {{ $service->title }}
                        </h2>

                        <p class="text-brand-600 text-sm sm:text-base leading-relaxed">
                            {{ $service->short_description }}
                        </p>

                        @if($service->items)
                            <div class="mt-6 flex-1 flex flex-col">
                                <button
                                    type="button"
                                    @click="expanded = !expanded"
                                    class="inline-flex items-center gap-2 text-brand-teal-700 font-medium text-sm hover:text-brand-teal-600 transition w-fit"
                                    :aria-expanded="expanded"
                                >
                                    <span x-text="expanded ? 'View Less' : 'View More'"></span>
                                    <i
                                        data-lucide="chevron-down"
                                        class="w-4 h-4 transition-transform duration-300"
                                        :class="expanded && 'rotate-180'"
                                    ></i>
                                </button>

                                <div
                                    x-show="expanded"
                                    x-cloak
                                    x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 -translate-y-1"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 translate-y-0"
                                    x-transition:leave-end="opacity-0 -translate-y-1"
                                    class="mt-5 flex flex-col flex-1"
                                >
                                    <ul class="space-y-4 flex-1">
                                        @foreach($service->items as $item)
                                            <li class="flex gap-3 border-l-2 border-brand-teal-200 pl-4">
                                                <div class="min-w-0">
                                                    <p class="text-sm font-semibold text-brand-900 leading-snug">{{ $item['title'] }}</p>
                                                    <p class="text-xs sm:text-sm text-brand-500 leading-relaxed mt-1">{{ $item['description'] }}</p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <div class="mt-6 pt-5 border-t border-brand-200">
                                        <a
                                            href="{{ route('services.show', $service) }}"
                                            class="inline-flex items-center justify-center gap-2 w-full sm:w-auto px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-500 text-white text-sm font-medium rounded-full transition shadow-sm group/details"
                                        >
                                            View Complete Details
                                            <i data-lucide="arrow-right" class="w-4 h-4 group-hover/details:translate-x-0.5 transition-transform"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mt-6 pt-5 border-t border-brand-200">
                                <a
                                    href="{{ route('services.show', $service) }}"
                                    class="inline-flex items-center gap-2 text-brand-teal-700 font-medium text-sm hover:text-brand-teal-600 transition group/link"
                                >
                                    View Complete Details
                                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover/link:translate-x-1 transition-transform"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="py-16 lg:py-20 bg-brand-900 text-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <p class="text-lg sm:text-xl lg:text-2xl leading-relaxed text-brand-100">
            <strong class="text-white font-semibold">One integrated advisory layer.</strong>
            We can support a project from early opportunity assessment through engineering, procurement and delivery coordination — bringing commercial and technical decisions together.
        </p>
        <a href="{{ route('contact.index') }}" class="inline-flex items-center gap-2 mt-8 px-7 py-3.5 bg-brand-teal-600 hover:bg-brand-teal-500 text-white text-sm font-medium rounded-full transition shadow-lg">
            Start a Conversation <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
    </div>
</section>
@else
<section class="py-24">
    <div class="max-w-3xl mx-auto px-4 text-center">
        <i data-lucide="compass" class="w-16 h-16 mx-auto text-brand-300 mb-4"></i>
        <p class="text-brand-600">Services coming soon.</p>
    </div>
</section>
@endif
@endsection
