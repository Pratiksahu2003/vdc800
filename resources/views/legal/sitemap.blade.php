@extends('layouts.app')

@php($seo = seo_for_route('legal.sitemap'))
@section('title', $seo['title'])
@section('meta_description', $seo['description'])
@section('meta_keywords', $seo['keywords'])

@section('content')
<x-page-hero fallback="images/hero-datacenter.jpg" alt="Sitemap" size="md" align="center">
    <x-public.hero-heading eyebrow="Navigation" title="Sitemap" description="Overview of all major sections on this site." />
</x-page-hero>

<x-public.section>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach([
            'Main' => [
                ['Home', route('home')],
                ['About', route('about.index')],
                ['Projects', route('data-centre.index')],
                ['Blog', route('blog.index')],
                ['Contact', route('contact.index')],
            ],
            'Services' => collect($sitemapServices ?? [])->map(fn ($s) => [$s->title, route('services.show', $s)])->prepend(['All services', route('services.index')])->all(),
            'Solutions' => collect($sitemapSolutions ?? [])->map(fn ($s) => [$s->title, route('solutions.show', $s)])->prepend(['All solutions', route('solutions.index')])->all(),
            'Legal' => [
                ['Privacy', route('legal.privacy')],
                ['Terms', route('legal.terms')],
                ['Cookies', route('legal.cookies')],
            ],
        ] as $heading => $links)
            <div class="eq-tile-link">
                <h2 class="text-lg font-bold text-brand-900 mb-4">{{ $heading }}</h2>
                <ul class="space-y-2">
                    @foreach($links as [$label, $url])
                        <li><a href="{{ $url }}" class="text-sm text-brand-teal-700 hover:underline">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</x-public.section>
@endsection
