@extends('layouts.admin')

@section('title', 'Edit Solution')

@section('content')
<div class="max-w-4xl space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.solutions.index') }}" class="p-2 text-brand-500 hover:bg-brand-100 rounded-lg transition">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-semibold text-brand-900">Edit Solution</h1>
            <p class="text-sm text-brand-500 mt-1">{{ $solution->title }}</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.solutions.update', $solution) }}" enctype="multipart/form-data" class="bg-white rounded-xl border border-brand-200 p-6 space-y-6">
        @csrf
        @method('PUT')

        @include('admin.components.input', ['name' => 'title', 'label' => 'Title', 'value' => $solution->title, 'required' => true])
        @include('admin.components.textarea', ['name' => 'short_description', 'label' => 'Short Description', 'value' => $solution->short_description, 'rows' => 2])
        @include('admin.components.textarea', ['name' => 'description', 'label' => 'Description', 'value' => $solution->description, 'rows' => 6])

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'icon', 'label' => 'Lucide Icon', 'value' => $solution->icon])
            @include('admin.components.input', ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'value' => $solution->sort_order])
        </div>

        <div x-data="benefitsManager(@js(old('benefits', $solution->benefits ?? [''])))" class="space-y-3">
            <div class="flex items-center justify-between">
                <label class="block text-sm font-medium text-brand-700">Benefits</label>
                <button type="button" @click="add()" class="inline-flex items-center gap-1 text-sm text-brand-teal-600 hover:text-brand-teal-700">
                    <i data-lucide="plus" class="w-4 h-4"></i> Add Benefit
                </button>
            </div>
            <template x-for="(benefit, index) in benefits" :key="index">
                <div class="flex gap-2">
                    <input type="text" :name="'benefits[' + index + ']'" x-model="benefits[index]" placeholder="Benefit description" class="flex-1 rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500">
                    <button type="button" @click="remove(index)" x-show="benefits.length > 1" class="p-2 text-red-500 hover:bg-red-50 rounded-lg">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            </template>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'cta_text', 'label' => 'CTA Text', 'value' => $solution->cta_text])
            @include('admin.components.input', ['name' => 'cta_url', 'label' => 'CTA URL', 'value' => $solution->cta_url])
        </div>

        @include('admin.components.image-upload', ['name' => 'featured_image', 'label' => 'Featured Image', 'existing' => $solution->featured_image])

        <hr class="border-brand-200">

        <h3 class="font-medium text-brand-900">SEO</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'meta_title', 'label' => 'Meta Title', 'value' => $solution->meta_title])
            @include('admin.components.textarea', ['name' => 'meta_description', 'label' => 'Meta Description', 'value' => $solution->meta_description, 'rows' => 2])
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-brand-700 mb-1">Status</label>
            <select name="status" id="status" required class="w-full rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500">
                <option value="draft" @selected($solution->status === 'draft')>Draft</option>
                <option value="published" @selected($solution->status === 'published')>Published</option>
            </select>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-brand-200">
            <a href="{{ route('admin.solutions.index') }}" class="px-5 py-2.5 text-sm font-medium text-brand-700 hover:bg-brand-100 rounded-lg transition">Cancel</a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
                <i data-lucide="save" class="w-4 h-4"></i> Update Solution
            </button>
        </div>
    </form>
</div>
@endsection
