@extends('layouts.admin')

@section('title', 'Edit Blog Category')

@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.blog-categories.index') }}" class="p-2 text-brand-500 hover:bg-brand-100 rounded-lg"><i data-lucide="arrow-left" class="w-5 h-5"></i></a>
        <div><h1 class="text-2xl font-semibold text-brand-900">Edit Category</h1><p class="text-sm text-brand-500">{{ $blogCategory->name }}</p></div>
    </div>

    <form method="POST" action="{{ route('admin.blog-categories.update', $blogCategory) }}" class="bg-white rounded-xl border border-brand-200 p-6 space-y-5">
        @csrf @method('PUT')
        @include('admin.components.input', ['name' => 'name', 'label' => 'Name', 'value' => $blogCategory->name, 'required' => true])
        @include('admin.components.textarea', ['name' => 'description', 'label' => 'Description', 'value' => $blogCategory->description, 'rows' => 3])
        @include('admin.components.input', ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'value' => $blogCategory->sort_order])
        <div>
            <label for="status" class="block text-sm font-medium text-brand-700 mb-1">Status</label>
            <select name="status" id="status" class="w-full rounded-lg border-brand-300 text-sm">
                <option value="published" @selected($blogCategory->status === 'published')>Published</option>
                <option value="draft" @selected($blogCategory->status === 'draft')>Draft</option>
            </select>
        </div>
        <div class="flex justify-end gap-3 pt-4 border-t border-brand-200">
            <a href="{{ route('admin.blog-categories.index') }}" class="px-5 py-2.5 text-sm text-brand-700 hover:bg-brand-100 rounded-lg">Cancel</a>
            <button type="submit" class="px-5 py-2.5 bg-brand-teal-600 text-white text-sm rounded-lg">Save Changes</button>
        </div>
    </form>
</div>
@endsection
