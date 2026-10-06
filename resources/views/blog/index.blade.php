@extends('layouts.app')

@section('title', 'Blog — ' . (settings('company.company_name') ?? 'VDC800'))

@section('content')
<x-page-hero fallback="images/hero-slide-3.jpg" alt="Blog" size="sm">
    <p class="text-brand-teal-400 text-sm font-medium tracking-widest uppercase mb-3">Insights & News</p>
    <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl mb-3">Blog</h1>
    <p class="text-brand-200 text-base sm:text-lg max-w-2xl">Expert perspectives on sustainable data centres, cloud infrastructure, and Nordic digital innovation.</p>
</x-page-hero>

<section class="py-12 lg:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($categories->count())
            <div class="flex flex-wrap gap-2 mb-10">
                <a href="{{ route('blog.index') }}" class="px-4 py-2 rounded-full text-sm font-medium transition {{ !$activeCategory ? 'bg-brand-red-500 text-white' : 'bg-brand-100 text-brand-700 hover:bg-brand-200' }}">All</a>
                @foreach($categories as $category)
                    <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="px-4 py-2 rounded-full text-sm font-medium transition {{ ($activeCategory?->id === $category->id) ? 'bg-brand-red-500 text-white' : 'bg-brand-100 text-brand-700 hover:bg-brand-200' }}">
                        {{ $category->name }} ({{ $category->posts_count }})
                    </a>
                @endforeach
            </div>
        @endif

        @if($posts->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                @foreach($posts as $post)
                    <article class="group bg-white rounded-2xl border border-brand-200 overflow-hidden hover:shadow-xl hover:border-brand-teal-200 transition flex flex-col">
                        <a href="{{ route('blog.show', $post) }}" class="block overflow-hidden">
                            <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-500">
                        </a>
                        <div class="p-6 flex flex-col flex-1">
                            <div class="flex items-center gap-2 text-xs text-brand-500 mb-2">
                                @if($post->category)
                                    <span class="text-brand-teal-600 font-semibold uppercase tracking-wide">{{ $post->category->name }}</span>
                                    <span>·</span>
                                @endif
                                <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->format('M j, Y') }}</time>
                            </div>
                            <h2 class="text-xl font-semibold text-brand-900 mb-2 group-hover:text-brand-teal-700 transition">
                                <a href="{{ route('blog.show', $post) }}">{{ $post->title }}</a>
                            </h2>
                            <p class="text-brand-600 text-sm leading-relaxed mb-4 flex-1">{{ $post->excerpt }}</p>
                            <a href="{{ route('blog.show', $post) }}" class="inline-flex items-center gap-2 text-brand-teal-700 font-medium text-sm">
                                Read article <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition"></i>
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
            <div class="mt-10">{{ $posts->links() }}</div>
        @else
            <div class="text-center py-16">
                <i data-lucide="newspaper" class="w-16 h-16 mx-auto text-brand-300 mb-4"></i>
                <p class="text-brand-600">No blog posts found in this category.</p>
            </div>
        @endif
    </div>
</section>
@endsection
