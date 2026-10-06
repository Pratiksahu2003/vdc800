@extends('layouts.admin')

@section('title', 'Media Library')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-semibold text-brand-900">Media Library</h1>
        <p class="text-sm text-brand-500 mt-1">Upload and manage media files.</p>
    </div>

    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl border border-brand-200 p-6">
        @csrf
        <h3 class="font-medium text-brand-900 mb-4">Upload File</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @include('admin.components.file-upload', [
                'name' => 'file',
                'label' => 'File',
                'accept' => 'image/*,.pdf,.svg',
                'required' => true,
                'maxSize' => 10,
                'hint' => 'Max 10MB. JPEG, PNG, GIF, WebP, SVG, PDF.',
            ])
            @include('admin.components.input', ['name' => 'alt_text', 'label' => 'Alt Text', 'value' => ''])
        </div>
        <div class="flex justify-end mt-4">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
                <i data-lucide="upload" class="w-4 h-4"></i> Upload
            </button>
        </div>
    </form>

    <form method="GET" action="{{ route('admin.media.index') }}" class="flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search files..." class="flex-1 rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500">
        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm rounded-lg transition">
            <i data-lucide="search" class="w-4 h-4"></i> Search
        </button>
    </form>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @forelse($media as $item)
            <div class="bg-white rounded-xl border border-brand-200 overflow-hidden group" x-data="{ copied: false }">
                <div class="aspect-square bg-brand-50 flex items-center justify-center relative">
                    @if(str_starts_with($item->mime_type ?? '', 'image/'))
                        <img src="{{ Storage::url($item->path) }}" alt="{{ $item->alt_text }}" class="w-full h-full object-cover">
                    @else
                        <i data-lucide="file" class="w-10 h-10 text-brand-400"></i>
                    @endif
                    <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition flex items-center justify-center gap-2">
                        <button @click="navigator.clipboard.writeText('{{ Storage::url($item->path) }}'); copied = true; setTimeout(() => copied = false, 2000)" type="button" class="p-2 bg-white rounded-lg text-brand-700 hover:bg-brand-100" title="Copy URL">
                            <i data-lucide="copy" class="w-4 h-4"></i>
                        </button>
                        <form x-ref="deleteMedia{{ $item->id }}" method="POST" action="{{ route('admin.media.destroy', $item) }}" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                        <button @click="$dispatch('open-delete-modal', { form: $refs.deleteMedia{{ $item->id }} })" type="button" class="p-2 bg-red-600 rounded-lg text-white hover:bg-red-700">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
                <div class="p-2">
                    <p class="text-xs font-medium text-brand-900 truncate" title="{{ $item->filename }}">{{ $item->filename }}</p>
                    <p class="text-xs text-brand-500">{{ number_format($item->size / 1024, 1) }} KB</p>
                    <p x-show="copied" x-cloak class="text-xs text-brand-teal-600 mt-1">URL copied!</p>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-xl border border-brand-200 p-12 text-center text-brand-500">
                <i data-lucide="image" class="w-12 h-12 mx-auto text-brand-300 mb-3"></i>
                <p>No media files yet.</p>
            </div>
        @endforelse
    </div>

    @if($media->hasPages())
        <div class="mt-4">{{ $media->links() }}</div>
    @endif

    @include('admin.components.delete-modal')
</div>
@endsection
