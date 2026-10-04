@extends('layouts.app')

@section('title', ($about->meta_title ?? 'About Us') . ' — ' . (settings('company.company_name') ?? 'D³ DataCenters'))
@section('meta_description', $about->meta_description ?? settings('company.description'))

@section('content')
<x-page-hero :image="$about->hero_image" fallback="images/about-technology.jpg" alt="About" size="lg" align="center">
    <x-public.hero-heading
        eyebrow="Company"
        :title="$about->hero_heading ?? 'Sustainable data centre excellence'"
    >
        <div class="prose-content prose-invert text-white/75 max-w-2xl mx-auto mt-2">
            {!! rich_content($about->hero_description ?? settings('company.about_company') ?? settings('company.description')) !!}
        </div>
    </x-public.hero-heading>
</x-page-hero>

@if($about->mission || $about->vision)
<x-public.section tone="muted">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
        @if($about->mission)
            <div class="eq-tile-link">
                <p class="text-xs font-bold uppercase tracking-widest text-brand-teal-600 mb-3">Mission</p>
                <div class="cms-content text-brand-600">{!! rich_content($about->mission) !!}</div>
            </div>
        @endif
        @if($about->vision)
            <div class="eq-tile-link bg-brand-950 text-white border-brand-800">
                <p class="text-xs font-bold uppercase tracking-widest text-brand-teal-400 mb-3">Vision</p>
                <div class="cms-content text-white/80">{!! rich_content($about->vision) !!}</div>
            </div>
        @endif
    </div>
</x-public.section>
@endif

@if($about->story)
<x-public.section>
    <h2 class="eq-headline-section text-brand-900 mb-8 text-center max-w-2xl mx-auto">Our story</h2>
    <div class="max-w-3xl mx-auto cms-content text-brand-600 text-lg">{!! rich_content($about->story) !!}</div>
</x-public.section>
@endif

@if($values->count())
<x-public.section tone="muted">
    <h2 class="eq-headline-section text-brand-900 mb-12 text-center">Our values</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($values as $value)
            <div class="eq-persona-card">
                <h3 class="text-lg font-bold text-brand-900 mb-2">{{ $value->title }}</h3>
                <p class="text-sm text-brand-600">{{ $value->description }}</p>
            </div>
        @endforeach
    </div>
</x-public.section>
@endif

@if($about->sustainability)
<x-public.section tone="dark">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center relative z-10">
        <div>
            <p class="text-brand-teal-400 text-xs font-bold uppercase tracking-widest mb-4">Operations</p>
            <h2 class="eq-headline-section text-white mb-6">Operational excellence</h2>
            <div class="cms-content text-white/75">{!! rich_content($about->sustainability) !!}</div>
        </div>
    </div>
</x-public.section>
@endif

<x-public.cta-band
    :title="$about->cta_heading ?? 'Join us in building sustainable infrastructure'"
    :description="$about->cta_description ?? 'Partner with D³ DataCenters for data centre solutions that perform brilliantly.'"
    :primary-url="$about->cta_button_url ?? route('contact.index')"
    :primary-label="$about->cta_button_text ?? 'Get in touch'"
/>
@endsection
