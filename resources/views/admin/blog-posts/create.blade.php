@extends('layouts.admin')

@section('title', 'Create Blog Post')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.blog-posts.index') }}" class="p-2 text-brand-500 hover:bg-brand-100 rounded-lg"><i data-lucide="arrow-left" class="w-5 h-5"></i></a>
        <div><h1 class="text-2xl font-semibold text-brand-900">Create Blog Post</h1></div>
    </div>

    <form method="POST" action="{{ route('admin.blog-posts.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl border border-brand-200 p-6 space-y-5">
        @csrf
        @include('admin.components.input', ['name' => 'title', 'label' => 'Title', 'value' => old('title'), 'required' => true])
        <div>
            <label for="blog_category_id" class="block text-sm font-medium text-brand-700 mb-1">Category</label>
            <select name="blog_category_id" id="blog_category_id" class="w-full rounded-lg border-brand-300 text-sm">
                <option value="">Uncategorised</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('blog_category_id') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        @include('admin.components.textarea', ['name' => 'excerpt', 'label' => 'Excerpt', 'value' => old('excerpt'), 'rows' => 2])
        @include('admin.components.ckeditor', ['name' => 'body', 'label' => 'Content', 'value' => old('body'), 'required' => true])
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'author', 'label' => 'Author', 'value' => old('author', 'VDC800 Team')])
            @include('admin.components.input', ['name' => 'published_at', 'label' => 'Published At', 'type' => 'datetime-local', 'value' => old('published_at')])
        </div>
        @include('admin.components.image-upload', ['name' => 'featured_image', 'label' => 'Featured Image', 'existing' => null])
        <hr class="border-brand-200">
        <h3 class="font-medium text-brand-900">SEO</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'meta_title', 'label' => 'Meta Title', 'value' => old('meta_title')])
            @include('admin.components.textarea', ['name' => 'meta_description', 'label' => 'Meta Description', 'value' => old('meta_description'), 'rows' => 2])
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'value' => old('sort_order', 0)])
            <div>
                <label for="status" class="block text-sm font-medium text-brand-700 mb-1">Status</label>
                <select name="status" id="status" class="w-full rounded-lg border-brand-300 text-sm">
                    <option value="draft" @selected(old('status', 'draft') === 'draft')>Draft</option>
                    <option value="published" @selected(old('status') === 'published')>Published</option>
                </select>
            </div>
        </div>
        <div class="flex justify-end gap-3 pt-4 border-t border-brand-200">
            <a href="{{ route('admin.blog-posts.index') }}" class="px-5 py-2.5 text-sm text-brand-700 hover:bg-brand-100 rounded-lg">Cancel</a>
            <button type="submit" class="px-5 py-2.5 bg-brand-teal-600 text-white text-sm rounded-lg">Create Post</button>
        </div>
    </form>
</div>
@endsection
