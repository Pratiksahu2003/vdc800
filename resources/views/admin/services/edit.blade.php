@extends('layouts.admin')

@section('title', 'Edit Service')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.services.index') }}" class="p-2 text-brand-500 hover:bg-brand-100 rounded-lg transition">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-semibold text-brand-900">Edit Service</h1>
            <p class="text-sm text-brand-500 mt-1">{{ $service->title }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data" class="bg-white rounded-xl border border-brand-200 p-6 space-y-6">
        @csrf
        @method('PUT')

        @include('admin.components.input', ['name' => 'title', 'label' => 'Title', 'value' => $service->title, 'required' => true])
        <div>
            <label for="category" class="block text-sm font-medium text-brand-700 mb-1">Category</label>
            <select name="category" id="category" class="w-full rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500">
                <option value="">Select category</option>
                @foreach(\App\Models\Service::CATEGORIES as $category)
                    <option value="{{ $category }}" @selected(old('category', $service->category) === $category)>{{ $category }}</option>
                @endforeach
            </select>
            <p class="text-xs text-brand-500 mt-1">Used to group this service in the navigation submenu.</p>
        </div>
        @include('admin.components.textarea', ['name' => 'short_description', 'label' => 'Short Description', 'value' => $service->short_description, 'rows' => 2])
        @include('admin.components.textarea', ['name' => 'full_description', 'label' => 'Full Description', 'value' => $service->full_description, 'rows' => 6])

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'icon', 'label' => 'Lucide Icon', 'value' => $service->icon])
            @include('admin.components.input', ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'value' => $service->sort_order])
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'cta_text', 'label' => 'CTA Text', 'value' => $service->cta_text])
            @include('admin.components.input', ['name' => 'cta_url', 'label' => 'CTA URL', 'value' => $service->cta_url])
        </div>

        @include('admin.components.image-upload', ['name' => 'featured_image', 'label' => 'Featured Image', 'existing' => $service->featured_image])

        <hr class="border-brand-200">

        <h3 class="font-medium text-brand-900">SEO</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'meta_title', 'label' => 'Meta Title', 'value' => $service->meta_title])
            @include('admin.components.textarea', ['name' => 'meta_description', 'label' => 'Meta Description', 'value' => $service->meta_description, 'rows' => 2])
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-brand-700 mb-1">Status</label>
            <select name="status" id="status" required class="w-full rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500">
                <option value="draft" @selected($service->status === 'draft')>Draft</option>
                <option value="published" @selected($service->status === 'published')>Published</option>
            </select>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-brand-200">
            <a href="{{ route('admin.services.index') }}" class="px-5 py-2.5 text-sm font-medium text-brand-700 hover:bg-brand-100 rounded-lg transition">Cancel</a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
                <i data-lucide="save" class="w-4 h-4"></i> Update Service
            </button>
        </div>
    </form>
</div>
@endsection
