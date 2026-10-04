@extends('layouts.app')

@section('title', ($post->meta_title ?? $post->title) . ' — Blog')
@section('meta_description', $post->meta_description ?? $post->excerpt)

@section('content')
<article>
    <x-page-hero :image="$post->featured_image" fallback="images/hero-slide-3.jpg" :alt="$post->title" size="lg" align="center">
        <x-public.hero-heading :title="$post->title">
            @if($post->category)
                <p class="text-brand-teal-400 text-xs font-bold uppercase tracking-widest mb-2">{{ $post->category->name }}</p>
            @endif
            <div class="flex flex-wrap justify-center gap-3 text-sm text-white/60 mt-2">
                @if($post->author)<span>{{ $post->author }}</span>@endif
                @if($post->published_at)
                    <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('F j, Y') }}</time>
                @endif
            </div>
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 mt-6 text-sm text-white/70 hover:text-white transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> All resources
            </a>
        </x-public.hero-heading>
    </x-page-hero>

    <x-public.section padding="sm">
        <div class="max-w-3xl mx-auto min-w-0">
            @if($post->excerpt)
                <p class="text-lg text-brand-800 border-l-4 border-brand-teal-600 pl-4 mb-8">{{ $post->excerpt }}</p>
            @endif
            <x-cms-content class="cms-content">{!! rich_content($post->body) !!}</x-cms-content>
        </div>
    </x-public.section>

    @if($relatedPosts->count())
        <x-public.section tone="muted">
            <h2 class="eq-headline-section text-brand-900 text-2xl mb-8">Related articles</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($relatedPosts as $related)
                    <a href="{{ route('blog.show', $related) }}" class="eq-resource-card group">
                        <img src="{{ $related->imageUrl() }}" alt="" class="w-full h-40 object-cover">
                        <div class="p-5">
                            <h3 class="font-bold text-brand-900 group-hover:text-brand-teal-700 transition">{{ $related->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </x-public.section>
    @endif
</article>
@endsection
