@extends('layouts.admin')

@section('title', 'Blog Categories')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-brand-900">Blog Categories</h1>
            <p class="text-sm text-brand-500 mt-1">Organise blog posts into topics.</p>
        </div>
        <a href="{{ route('admin.blog-categories.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
            <i data-lucide="plus" class="w-4 h-4"></i> Add Category
        </a>
    </div>

    <form method="GET" class="bg-white rounded-xl border border-brand-200 p-4 flex flex-col sm:flex-row gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..." class="flex-1 rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500">
        <select name="status" class="rounded-lg border-brand-300 text-sm">
            <option value="">All statuses</option>
            <option value="published" @selected(request('status') === 'published')>Published</option>
            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
        </select>
        <button type="submit" class="px-4 py-2 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm rounded-lg transition">Filter</button>
    </form>

    <div class="bg-white rounded-xl border border-brand-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-brand-50 border-b border-brand-200">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">Category</th>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">Posts</th>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">Status</th>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">Order</th>
                    <th class="text-right px-6 py-3 font-medium text-brand-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($categories as $category)
                    <tr class="hover:bg-brand-50">
                        <td class="px-6 py-4">
                            <p class="font-medium text-brand-900">{{ $category->name }}</p>
                            <p class="text-xs text-brand-500">{{ $category->slug }}</p>
                        </td>
                        <td class="px-6 py-4 text-brand-600">{{ $category->posts_count }}</td>
                        <td class="px-6 py-4">@include('admin.components.status-badge', ['status' => $category->status])</td>
                        <td class="px-6 py-4 text-brand-600">{{ $category->sort_order }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.blog-categories.edit', $category) }}" class="p-2 text-brand-500 hover:text-brand-teal-600 hover:bg-brand-teal-50 rounded-lg"><i data-lucide="pencil" class="w-4 h-4"></i></a>
                                <form method="POST" action="{{ route('admin.blog-categories.toggle', $category) }}">@csrf @method('PATCH')<button type="submit" class="p-2 text-brand-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg"><i data-lucide="toggle-left" class="w-4 h-4"></i></button></form>
                                <form x-ref="deleteForm{{ $category->id }}" method="POST" action="{{ route('admin.blog-categories.destroy', $category) }}" class="hidden">@csrf @method('DELETE')</form>
                                <button @click="$dispatch('open-delete-modal', { form: $refs.deleteForm{{ $category->id }} })" type="button" class="p-2 text-brand-500 hover:text-red-600 hover:bg-red-50 rounded-lg"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-12 text-center text-brand-500">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())<div class="mt-4">{{ $categories->links() }}</div>@endif
    @include('admin.components.delete-modal')
</div>
@endsection
