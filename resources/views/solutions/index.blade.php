@extends('layouts.app')

@section('title', 'Solutions — ' . (settings('company.company_name') ?? 'VDC800'))

@section('content')
<x-page-hero fallback="images/data-centre-facility.jpg" alt="Our Solutions" size="md">
    <p class="text-brand-teal-400 text-sm font-medium tracking-widest uppercase mb-3">Tailored Infrastructure</p>
    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl mb-4 max-w-3xl">Our Solutions</h1>
    <p class="text-brand-200 text-base sm:text-lg max-w-2xl leading-relaxed">Scalable data centre solutions designed for enterprises, cloud providers, and mission-critical workloads.</p>
</x-page-hero>

<section class="py-16 lg:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($solutions->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($solutions as $solution)
                    <a href="{{ route('solutions.show', $solution) }}" class="group bg-white rounded-2xl border border-brand-200 p-8 lg:p-10 hover:shadow-xl transition flex gap-6" data-hover-lift>
                        <div class="w-14 h-14 rounded-xl bg-brand-teal-100 flex items-center justify-center shrink-0 group-hover:bg-brand-teal-600 transition">
                            <i data-lucide="{{ $solution->icon ?? 'layers' }}" class="w-7 h-7 text-brand-teal-700 group-hover:text-white transition"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-semibold text-brand-900 mb-3 group-hover:text-brand-teal-700 transition">{{ $solution->title }}</h2>
                            <p class="text-brand-600 leading-relaxed mb-4">{{ $solution->short_description }}</p>
                            @if($solution->benefits)
                                <ul class="space-y-1 mb-4">
                                    @foreach(array_slice($solution->benefits, 0, 3) as $benefit)
                                        <li class="flex items-center gap-2 text-sm text-brand-600">
                                            <i data-lucide="check" class="w-4 h-4 text-brand-teal-600 shrink-0"></i>
                                            {{ $benefit }}
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            <span class="inline-flex items-center gap-2 text-brand-teal-700 font-medium text-sm">
                                Explore solution <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition"></i>
                            </span>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <i data-lucide="layers" class="w-16 h-16 mx-auto text-brand-300 mb-4"></i>
                <p class="text-brand-600">Solutions coming soon.</p>
            </div>
        @endif
    </div>
</section>
@endsection
