@extends('layouts.app')

@section('title', ($post->meta_title ?? $post->title) . ' — Blog')
@section('meta_description', $post->meta_description ?? $post->excerpt)

@section('content')
<article>
    <x-page-hero
        :image="$post->featured_image"
        fallback="images/hero-slide-3.jpg"
        :alt="$post->title"
        size="lg"
        class="pb-4"
    >
        <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-brand-300 hover:text-white text-sm mb-4 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Back to Blog
        </a>
        @if($post->category)
            <p class="text-brand-teal-400 text-sm font-medium tracking-widest uppercase mb-2">{{ $post->category->name }}</p>
        @endif
        <h1 class="font-display text-3xl sm:text-4xl lg:text-5xl mb-4 max-w-3xl">{{ $post->title }}</h1>
        <div class="flex flex-wrap items-center gap-3 text-sm text-brand-300">
            @if($post->author)<span>By {{ $post->author }}</span>@endif
            @if($post->published_at)
                <span>·</span>
                <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('F j, Y') }}</time>
            @endif
        </div>
    </x-page-hero>

    <section class="py-10 sm:py-12 lg:py-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 min-w-0">
            @if($post->excerpt)
                <p class="text-base sm:text-lg text-brand-700 font-medium mb-8 leading-relaxed border-l-4 border-brand-teal-500 pl-4">{{ $post->excerpt }}</p>
            @endif
            <x-cms-content class="text-brand-700 text-base sm:text-lg leading-relaxed">
                {!! rich_content($post->body) !!}
            </x-cms-content>
        </div>
    </section>

    @if($relatedPosts->count())
        <section class="py-12 bg-brand-100 border-t border-brand-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="font-display text-2xl text-brand-900 mb-8">Related Articles</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedPosts as $related)
                        <a href="{{ route('blog.show', $related) }}" class="group bg-white rounded-xl border border-brand-200 overflow-hidden hover:shadow-lg transition">
                            <img src="{{ $related->imageUrl() }}" alt="{{ $related->title }}" class="w-full h-40 object-cover">
                            <div class="p-5">
                                <h3 class="font-semibold text-brand-900 group-hover:text-brand-teal-700 transition">{{ $related->title }}</h3>
                                <p class="text-sm text-brand-500 mt-1">{{ $related->published_at?->format('M j, Y') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</article>
@endsection
