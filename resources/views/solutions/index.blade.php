@extends('layouts.app')

@section('title', 'Solutions — ' . (settings('company.company_name') ?? 'D³ DataCenters'))

@section('content')
<x-page-hero fallback="images/data-centre-facility.jpg" alt="Our Solutions" size="lg" align="center">
    <x-public.hero-heading
        eyebrow="Solutions"
        title="Tailored infrastructure for every scale"
        description="Scalable data centre solutions for enterprises, cloud providers, and mission-critical workloads."
    />
</x-page-hero>

<x-public.section>
    @if($solutions->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($solutions as $solution)
                <a href="{{ route('solutions.show', $solution) }}" class="eq-persona-card group">
                    <p class="text-xs font-bold uppercase tracking-widest text-brand-teal-600 mb-3">Solution</p>
                    <h3 class="text-xl font-bold text-brand-900 mb-3 group-hover:text-brand-teal-700 transition">{{ $solution->title }}</h3>
                    <p class="text-sm text-brand-600 leading-relaxed flex-1">{{ $solution->short_description }}</p>
                    <span class="inline-flex items-center gap-2 mt-6 text-sm font-semibold text-brand-teal-700">
                        Explore <i data-lucide="arrow-right" class="w-4 h-4"></i>
                    </span>
                </a>
            @endforeach
        </div>
    @else
        <p class="text-brand-600 text-center py-16">Solutions coming soon.</p>
    @endif
</x-public.section>

<x-public.cta-band title="Find the right solution for your team" />
@endsection
