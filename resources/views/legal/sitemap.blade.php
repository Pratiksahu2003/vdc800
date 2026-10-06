@extends('layouts.app')

@section('title', 'Sitemap — ' . (settings('company.company_name') ?? 'VDC800'))
@section('meta_description', 'Browse the complete VDC800 website sitemap including services, solutions, data centres, blog articles, and legal pages.')

@section('content')
<x-page-hero fallback="images/hero-datacenter.jpg" alt="VDC800 Sitemap" size="md">
    <p class="text-brand-teal-400 text-sm font-medium tracking-widest uppercase mb-3">Navigation</p>
    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl mb-4">Sitemap</h1>
    <p class="text-brand-200 text-base sm:text-lg max-w-2xl leading-relaxed">
        A structured overview of every major section on the {{ settings('company.company_name') ?? 'VDC800' }} website.
    </p>
</x-page-hero>

<section class="py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 lg:gap-10">
            {{-- Main pages --}}
            <div class="bg-white rounded-2xl border border-brand-200 p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-lg bg-brand-red-100 flex items-center justify-center">
                        <i data-lucide="home" class="w-5 h-5 text-brand-red-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-brand-900">Main Pages</h2>
                </div>
                <ul class="space-y-2.5">
                    @foreach([
                        ['Home', route('home')],
                        ['About Us', route('about.index')],
                        ['Data Centre', route('data-centre.index')],
                        ['Blog', route('blog.index')],
                        ['Contact', route('contact.index')],
                    ] as [$label, $url])
                        <li>
                            <a href="{{ $url }}" class="text-brand-600 hover:text-brand-red-600 transition text-sm">{{ $label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Services --}}
            <div class="bg-white rounded-2xl border border-brand-200 p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-lg bg-brand-teal-100 flex items-center justify-center">
                        <i data-lucide="server" class="w-5 h-5 text-brand-teal-700"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-brand-900">Services</h2>
                </div>
                <ul class="space-y-2.5">
                    <li>
                        <a href="{{ route('services.index') }}" class="text-brand-900 font-medium hover:text-brand-red-600 transition text-sm">All Services</a>
                    </li>
                    @forelse($services as $service)
                        <li>
                            <a href="{{ route('services.show', $service) }}" class="text-brand-600 hover:text-brand-red-600 transition text-sm">{{ $service->title }}</a>
                        </li>
                    @empty
                        <li class="text-sm text-brand-400">No services published yet.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Solutions --}}
            <div class="bg-white rounded-2xl border border-brand-200 p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-lg bg-brand-teal-100 flex items-center justify-center">
                        <i data-lucide="layers" class="w-5 h-5 text-brand-teal-700"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-brand-900">Solutions</h2>
                </div>
                <ul class="space-y-2.5">
                    <li>
                        <a href="{{ route('solutions.index') }}" class="text-brand-900 font-medium hover:text-brand-red-600 transition text-sm">All Solutions</a>
                    </li>
                    @forelse($solutions as $solution)
                        <li>
                            <a href="{{ route('solutions.show', $solution) }}" class="text-brand-600 hover:text-brand-red-600 transition text-sm">{{ $solution->title }}</a>
                        </li>
                    @empty
                        <li class="text-sm text-brand-400">No solutions published yet.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Data centres --}}
            <div class="bg-white rounded-2xl border border-brand-200 p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-lg bg-brand-red-100 flex items-center justify-center">
                        <i data-lucide="building-2" class="w-5 h-5 text-brand-red-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-brand-900">Data Centres</h2>
                </div>
                <ul class="space-y-2.5">
                    <li>
                        <a href="{{ route('data-centre.index') }}" class="text-brand-900 font-medium hover:text-brand-red-600 transition text-sm">All Facilities</a>
                    </li>
                    @forelse($dataCentres as $dataCentre)
                        <li>
                            <a href="{{ route('data-centre.show', $dataCentre) }}" class="text-brand-600 hover:text-brand-red-600 transition text-sm">{{ $dataCentre->name }}</a>
                        </li>
                    @empty
                        <li class="text-sm text-brand-400">No data centres published yet.</li>
                    @endforelse
                </ul>
            </div>

            {{-- Blog --}}
            <div class="bg-white rounded-2xl border border-brand-200 p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-lg bg-brand-teal-100 flex items-center justify-center">
                        <i data-lucide="newspaper" class="w-5 h-5 text-brand-teal-700"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-brand-900">Blog</h2>
                </div>
                <ul class="space-y-2.5 mb-6">
                    <li>
                        <a href="{{ route('blog.index') }}" class="text-brand-900 font-medium hover:text-brand-red-600 transition text-sm">All Articles</a>
                    </li>
                    @foreach($blogCategories as $category)
                        <li>
                            <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="text-brand-600 hover:text-brand-red-600 transition text-sm">{{ $category->name }}</a>
                        </li>
                    @endforeach
                </ul>
                @if($blogPosts->count())
                    <p class="text-xs font-semibold uppercase tracking-wide text-brand-500 mb-3">Recent Articles</p>
                    <ul class="space-y-2.5 max-h-64 overflow-y-auto scrollbar-hide">
                        @foreach($blogPosts->take(12) as $post)
                            <li>
                                <a href="{{ route('blog.show', $post) }}" class="text-brand-600 hover:text-brand-red-600 transition text-sm leading-snug">{{ $post->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- Legal --}}
            <div class="bg-white rounded-2xl border border-brand-200 p-6 lg:p-8">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 rounded-lg bg-brand-100 flex items-center justify-center">
                        <i data-lucide="shield-check" class="w-5 h-5 text-brand-700"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-brand-900">Legal & Policies</h2>
                </div>
                <ul class="space-y-2.5">
                    @foreach([
                        ['Privacy Policy', route('legal.privacy')],
                        ['Terms of Service', route('legal.terms')],
                        ['Cookie Policy', route('legal.cookies')],
                        ['Sitemap', route('legal.sitemap')],
                    ] as [$label, $url])
                        <li>
                            <a href="{{ $url }}" class="text-brand-600 hover:text-brand-red-600 transition text-sm">{{ $label }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="mt-10 p-6 lg:p-8 rounded-2xl bg-brand-100 border border-brand-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h3 class="font-semibold text-brand-900 mb-1">XML Sitemap for Search Engines</h3>
                <p class="text-sm text-brand-600">Search engines can crawl our machine-readable sitemap for indexing.</p>
            </div>
            <a href="{{ url('/sitemap.xml') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition shrink-0">
                <i data-lucide="file-code-2" class="w-4 h-4"></i>
                View sitemap.xml
            </a>
        </div>
    </div>
</section>
@endsection
