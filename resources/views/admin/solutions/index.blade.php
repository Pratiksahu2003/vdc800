@extends('layouts.admin')

@section('title', 'Solutions')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-brand-900">Solutions</h1>
            <p class="text-sm text-brand-500 mt-1">Manage your data centre solutions.</p>
        </div>
        <a href="{{ route('admin.solutions.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
            <i data-lucide="plus" class="w-4 h-4"></i> Add Solution
        </a>
    </div>

    <form method="GET" action="{{ route('admin.solutions.index') }}" class="bg-white rounded-xl border border-brand-200 p-4 flex flex-col sm:flex-row gap-3">
        <div class="flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search solutions..." class="w-full rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500">
        </div>
        <select name="status" class="rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500">
            <option value="">All statuses</option>
            <option value="published" @selected(request('status') === 'published')>Published</option>
            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
        </select>
        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm rounded-lg transition">
            <i data-lucide="search" class="w-4 h-4"></i> Filter
        </button>
    </form>

    <div class="bg-white rounded-xl border border-brand-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-brand-50 border-b border-brand-200">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">Solution</th>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">Status</th>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">Order</th>
                    <th class="text-right px-6 py-3 font-medium text-brand-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($solutions as $solution)
                    <tr class="hover:bg-brand-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($solution->featured_image)
                                    <img src="{{ hero_image_url($solution->featured_image) }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-brand-100 flex items-center justify-center">
                                        <i data-lucide="{{ $solution->icon ?? 'layers' }}" class="w-4 h-4 text-brand-400"></i>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-medium text-brand-900">{{ $solution->title }}</p>
                                    <p class="text-brand-500 text-xs">{{ Str::limit($solution->short_description, 60) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">@include('admin.components.status-badge', ['status' => $solution->status])</td>
                        <td class="px-6 py-4 text-brand-600">{{ $solution->sort_order }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.solutions.edit', $solution) }}" class="p-2 text-brand-500 hover:text-brand-teal-600 hover:bg-brand-teal-50 rounded-lg transition">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.solutions.toggle', $solution) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-2 text-brand-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Toggle status">
                                        <i data-lucide="toggle-left" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                <form x-ref="deleteForm{{ $solution->id }}" method="POST" action="{{ route('admin.solutions.destroy', $solution) }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button @click="$dispatch('open-delete-modal', { form: $refs.deleteForm{{ $solution->id }} })" type="button" class="p-2 text-brand-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-brand-500">No solutions found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($solutions->hasPages())
        <div class="mt-4">{{ $solutions->links() }}</div>
    @endif

    @include('admin.components.delete-modal')
</div>
@endsection
