@extends('layouts.admin')

@section('title', 'Add Project')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.data-centres.index') }}" class="p-2 text-brand-500 hover:bg-brand-100 rounded-lg transition">
            <i data-lucide="arrow-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="text-2xl font-semibold text-brand-900">Add Project</h1>
            <p class="text-sm text-brand-500 mt-1">Create a new facility. You can add specifications and features after saving.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.data-centres.store') }}" class="bg-white rounded-xl border border-brand-200 p-6 space-y-6">
        @csrf

        @include('admin.components.input', ['name' => 'name', 'label' => 'Project Name', 'value' => old('name'), 'required' => true])
        @include('admin.components.input', ['name' => 'location', 'label' => 'Location', 'value' => old('location'), 'placeholder' => 'Oslo, Norway'])
        @include('admin.components.input', ['name' => 'country', 'label' => 'Country', 'value' => old('country'), 'placeholder' => 'Norway'])
        @include('admin.components.textarea', ['name' => 'short_description', 'label' => 'Short Description', 'value' => old('short_description'), 'rows' => 3])

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'value' => old('sort_order', 0)])
            <div>
                <label for="status" class="block text-sm font-medium text-brand-700 mb-1">Status</label>
                <select name="status" id="status" class="w-full rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500">
                    <option value="published" @selected(old('status', 'published') === 'published')>Published</option>
                    <option value="draft" @selected(old('status') === 'draft')>Draft</option>
                </select>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" name="is_featured" id="is_featured" value="1" @checked(old('is_featured')) class="rounded border-brand-300 text-brand-teal-600">
            <label for="is_featured" class="text-sm text-brand-600">Featured facility (highlighted on listing page)</label>
        </div>

        <div class="flex justify-end pt-4 border-t border-brand-200">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Create Project
            </button>
        </div>
    </form>
</div>
@endsection
