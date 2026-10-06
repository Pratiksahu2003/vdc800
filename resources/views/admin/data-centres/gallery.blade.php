@extends('layouts.admin')

@section('title', $dataCentre->name . ' — Gallery')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.data-centres.edit', $dataCentre) }}" class="p-2 text-brand-500 hover:bg-brand-100 rounded-lg transition">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h1 class="text-2xl font-semibold text-brand-900">{{ $dataCentre->name }} — Gallery</h1>
                <p class="text-sm text-brand-500 mt-1">Upload and manage gallery images for this facility.</p>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.data-centres.gallery.store', $dataCentre) }}" enctype="multipart/form-data" class="bg-white rounded-xl border border-brand-200 p-6">
        @csrf
        <h3 class="font-medium text-brand-900 mb-4">Upload New Image</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @include('admin.components.file-upload', [
                'name' => 'image',
                'label' => 'Image',
                'accept' => 'image/*',
                'required' => true,
                'mode' => 'image',
                'maxSize' => 5,
                'hint' => 'PNG, JPG, GIF or WebP — max 5MB',
            ])
            @include('admin.components.input', ['name' => 'caption', 'label' => 'Caption', 'value' => ''])
            @include('admin.components.input', ['name' => 'alt_text', 'label' => 'Alt Text', 'value' => ''])
            @include('admin.components.input', ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'value' => 0])
        </div>
        <div class="flex justify-end mt-4">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
                <i data-lucide="upload" class="w-4 h-4"></i> Upload Image
            </button>
        </div>
    </form>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @forelse($gallery as $item)
            <div class="bg-white rounded-xl border border-brand-200 overflow-hidden group">
                <div class="aspect-square relative">
                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->alt_text }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                        <form method="POST" action="{{ route('admin.data-centres.gallery.toggle', [$dataCentre, $item]) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="p-2 bg-white rounded-lg text-brand-700 hover:bg-brand-100" title="Toggle status">
                                <i data-lucide="toggle-left" class="w-4 h-4"></i>
                            </button>
                        </form>
                        <form x-ref="deleteGallery{{ $item->id }}" method="POST" action="{{ route('admin.data-centres.gallery.destroy', [$dataCentre, $item]) }}" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button @click="$dispatch('open-delete-modal', { form: $refs.deleteGallery{{ $item->id }} })" type="button" class="p-2 bg-red-600 rounded-lg text-white hover:bg-red-700">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
                <div class="p-3">
                    <p class="text-sm font-medium text-brand-900 truncate">{{ $item->caption ?? 'Untitled' }}</p>
                    <div class="mt-1">@include('admin.components.status-badge', ['status' => $item->is_active ? 'active' : 'inactive'])</div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl border border-brand-200 p-12 text-center text-brand-500">
                <i data-lucide="images" class="w-12 h-12 mx-auto text-brand-300 mb-3"></i>
                <p>No gallery images yet. Upload your first image above.</p>
            </div>
        @endforelse
    </div>

    @include('admin.components.delete-modal')
</div>
@endsection
