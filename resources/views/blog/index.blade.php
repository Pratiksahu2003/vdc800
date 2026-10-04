@extends('layouts.app')

@section('title', 'Blog — ' . (settings('company.company_name') ?? 'D³ DataCenters'))

@section('content')
<x-page-hero fallback="images/hero-slide-3.jpg" alt="Blog" size="md" align="center">
    <x-public.hero-heading
        eyebrow="Resources"
        title="Insights &amp; news"
        description="Expert perspectives on data centres, cloud infrastructure, and digital innovation."
    />
</x-page-hero>

<x-public.section>
    @if($categories->count())
        <div class="flex flex-wrap gap-2 mb-12">
            <a href="{{ route('blog.index') }}" class="eq-filter-chip {{ !$activeCategory ? 'eq-filter-chip--active' : '' }}">All</a>
            @foreach($categories as $category)
                <a href="{{ route('blog.index', ['category' => $category->slug]) }}" class="eq-filter-chip {{ ($activeCategory?->id === $category->id) ? 'eq-filter-chip--active' : '' }}">
                    {{ $category->name }} ({{ $category->posts_count }})
                </a>
            @endforeach
        </div>
    @endif

    @if($posts->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
            @foreach($posts as $post)
                <a href="{{ route('blog.show', $post) }}" class="eq-resource-card group">
                    <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    <div class="p-6">
                        @if($post->category)
                            <p class="text-xs font-bold uppercase tracking-widest text-brand-teal-600 mb-2">{{ $post->category->name }}</p>
                        @endif
                        <h2 class="text-lg font-bold text-brand-900 mb-2 group-hover:text-brand-teal-700 transition">{{ $post->title }}</h2>
                        <p class="text-sm text-brand-600 mb-2">{{ Str::limit($post->excerpt, 100) }}</p>
                        @if($post->published_at)
                            <time class="text-xs text-brand-500" datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('M j, Y') }}</time>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
        <div class="mt-12">{{ $posts->links() }}</div>
    @else
        <p class="text-brand-600 text-center py-16">No articles in this category.</p>
    @endif
</x-public.section>
@endsection
