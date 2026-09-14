@extends('layouts.admin')

@section('title', $dataCentre->name ?? 'Edit Project')

@section('content')
<div class="space-y-6" x-data="{ tab: 'info', specModal: false, featureModal: false, editingSpec: null, editingFeature: null }">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.data-centres.index') }}" class="p-2 text-brand-500 hover:bg-brand-100 rounded-lg transition">
                <i data-lucide="arrow-left" class="w-5 h-5"></i>
            </a>
            <div>
                <h1 class="text-2xl font-semibold text-brand-900">{{ $dataCentre->name ?? 'Project' }}</h1>
                <p class="text-sm text-brand-500 mt-1">Manage facility information, specifications, and features.</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('data-centre.show', $dataCentre) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-brand-200 text-brand-700 text-sm font-medium rounded-lg hover:bg-brand-50 transition">
                <i data-lucide="external-link" class="w-4 h-4"></i> Preview
            </a>
            <a href="{{ route('admin.data-centres.gallery', $dataCentre) }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
                <i data-lucide="images" class="w-4 h-4"></i> Gallery
            </a>
        </div>
    </div>

    <div class="flex flex-wrap gap-2 border-b border-brand-200 pb-4">
        @foreach(['info' => 'Information', 'specs' => 'Specifications', 'features' => 'Features'] as $key => $label)
            <button type="button" @click="tab = '{{ $key }}'" :class="tab === '{{ $key }}' ? 'bg-brand-teal-600 text-white' : 'bg-white text-brand-600 hover:bg-brand-50'" class="px-4 py-2 text-sm font-medium rounded-lg border border-brand-200 transition">{{ $label }}</button>
        @endforeach
    </div>

    <form method="POST" action="{{ route('admin.data-centres.update', $dataCentre) }}" enctype="multipart/form-data" class="bg-white rounded-xl border border-brand-200 p-6 space-y-6" x-show="tab === 'info'">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'name', 'label' => 'Project Name', 'value' => $dataCentre->name])
            @include('admin.components.input', ['name' => 'slug', 'label' => 'URL Slug', 'value' => $dataCentre->slug])
            @include('admin.components.input', ['name' => 'location', 'label' => 'Location', 'value' => $dataCentre->location])
            @include('admin.components.input', ['name' => 'country', 'label' => 'Country', 'value' => $dataCentre->country])
            @include('admin.components.input', ['name' => 'hero_video_url', 'label' => 'Hero Video URL', 'type' => 'url', 'value' => $dataCentre->hero_video_url])
            @include('admin.components.input', ['name' => 'sort_order', 'label' => 'Sort Order', 'type' => 'number', 'value' => $dataCentre->sort_order])
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="status" class="block text-sm font-medium text-brand-700 mb-1">Status</label>
                <select name="status" id="status" class="w-full rounded-lg border-brand-300 text-sm focus:border-brand-teal-500 focus:ring-brand-teal-500">
                    <option value="published" @selected($dataCentre->status === 'published')>Published</option>
                    <option value="draft" @selected($dataCentre->status === 'draft')>Draft</option>
                </select>
            </div>
            <div class="flex items-end pb-2">
                <div class="flex items-center gap-2">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" id="is_featured" value="1" @checked($dataCentre->is_featured) class="rounded border-brand-300 text-brand-teal-600">
                    <label for="is_featured" class="text-sm text-brand-600">Featured facility</label>
                </div>
            </div>
        </div>

        @include('admin.components.textarea', ['name' => 'address', 'label' => 'Address', 'value' => $dataCentre->address, 'rows' => 2])
        @include('admin.components.textarea', ['name' => 'short_description', 'label' => 'Short Description', 'value' => $dataCentre->short_description, 'rows' => 2])
        @include('admin.components.textarea', ['name' => 'full_description', 'label' => 'Full Description', 'value' => $dataCentre->full_description, 'rows' => 6])

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'latitude', 'label' => 'Latitude', 'type' => 'number', 'value' => $dataCentre->latitude])
            @include('admin.components.input', ['name' => 'longitude', 'label' => 'Longitude', 'type' => 'number', 'value' => $dataCentre->longitude])
        </div>

        @include('admin.components.image-upload', ['name' => 'hero_image', 'label' => 'Hero Image', 'existing' => $dataCentre->hero_image])

        <hr class="border-brand-200">

        <h3 class="font-medium text-brand-900">Call to Action</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'cta_heading', 'label' => 'CTA Heading', 'value' => $dataCentre->cta_heading])
            @include('admin.components.input', ['name' => 'cta_button_text', 'label' => 'Button Text', 'value' => $dataCentre->cta_button_text])
            @include('admin.components.input', ['name' => 'cta_button_url', 'label' => 'Button URL', 'value' => $dataCentre->cta_button_url])
        </div>
        @include('admin.components.textarea', ['name' => 'cta_description', 'label' => 'CTA Description', 'value' => $dataCentre->cta_description, 'rows' => 2])

        <hr class="border-brand-200">

        <h3 class="font-medium text-brand-900">SEO</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'meta_title', 'label' => 'Meta Title', 'value' => $dataCentre->meta_title])
            @include('admin.components.textarea', ['name' => 'meta_description', 'label' => 'Meta Description', 'value' => $dataCentre->meta_description, 'rows' => 2])
        </div>

        <div class="flex justify-end pt-4 border-t border-brand-200">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
                <i data-lucide="save" class="w-4 h-4"></i> Save Project
            </button>
        </div>
    </form>

    <div x-show="tab === 'specs'" x-cloak class="bg-white rounded-xl border border-brand-200">
        <div class="flex items-center justify-between px-6 py-4 border-b border-brand-200">
            <h2 class="font-semibold text-brand-900">Specifications</h2>
            <button @click="editingSpec = null; specModal = true" type="button" class="inline-flex items-center gap-2 px-3 py-2 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm rounded-lg transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Add Specification
            </button>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($specifications as $spec)
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-3">
                        <i data-lucide="{{ $spec->icon ?? 'gauge' }}" class="w-5 h-5 text-brand-teal-600"></i>
                        <div>
                            <p class="font-medium text-brand-900">{{ $spec->label }}</p>
                            <p class="text-sm text-brand-teal-600 font-semibold">{{ $spec->value }}@if($spec->unit) {{ $spec->unit }}@endif</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @include('admin.components.status-badge', ['status' => $spec->is_active ? 'active' : 'inactive'])
                        <button @click="editingSpec = @js($spec); specModal = true" type="button" class="p-2 text-brand-500 hover:text-brand-teal-600 rounded-lg"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                        <form x-ref="deleteSpec{{ $spec->id }}" method="POST" action="{{ route('admin.data-centres.specifications.destroy', [$dataCentre, $spec]) }}" class="hidden">@csrf @method('DELETE')</form>
                        <button @click="$dispatch('open-delete-modal', { form: $refs.deleteSpec{{ $spec->id }} })" type="button" class="p-2 text-brand-500 hover:text-red-600 rounded-lg"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </div>
                </div>
            @empty
                <p class="px-6 py-8 text-sm text-brand-500 text-center">No specifications added yet.</p>
            @endforelse
        </div>
    </div>

    <div x-show="tab === 'features'" x-cloak class="bg-white rounded-xl border border-brand-200">
        <div class="flex items-center justify-between px-6 py-4 border-b border-brand-200">
            <h2 class="font-semibold text-brand-900">Features</h2>
            <button @click="editingFeature = null; featureModal = true" type="button" class="inline-flex items-center gap-2 px-3 py-2 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm rounded-lg transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Add Feature
            </button>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($features as $feature)
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if($feature->image)
                            <img src="{{ Storage::url($feature->image) }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <i data-lucide="{{ $feature->icon ?? 'shield' }}" class="w-5 h-5 text-brand-teal-600"></i>
                        @endif
                        <div>
                            <p class="font-medium text-brand-900">{{ $feature->title }}</p>
                            <p class="text-sm text-brand-500">{{ Str::limit($feature->description, 80) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @include('admin.components.status-badge', ['status' => $feature->is_active ? 'active' : 'inactive'])
                        <button @click="editingFeature = @js($feature); featureModal = true" type="button" class="p-2 text-brand-500 hover:text-brand-teal-600 rounded-lg"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                        <form x-ref="deleteFeature{{ $feature->id }}" method="POST" action="{{ route('admin.data-centres.features.destroy', [$dataCentre, $feature]) }}" class="hidden">@csrf @method('DELETE')</form>
                        <button @click="$dispatch('open-delete-modal', { form: $refs.deleteFeature{{ $feature->id }} })" type="button" class="p-2 text-brand-500 hover:text-red-600 rounded-lg"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </div>
                </div>
            @empty
                <p class="px-6 py-8 text-sm text-brand-500 text-center">No features added yet.</p>
            @endforelse
        </div>
    </div>

    <div x-show="specModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50" @click="specModal = false"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full p-6 max-h-[90vh] overflow-y-auto" @click.stop>
            <h3 class="text-lg font-semibold text-brand-900 mb-4" x-text="editingSpec ? 'Edit Specification' : 'Add Specification'"></h3>
            <form method="POST" :action="editingSpec ? '{{ url('admin/data-centres/'.$dataCentre->slug.'/specifications') }}/' + editingSpec.id : '{{ route('admin.data-centres.specifications.store', $dataCentre) }}'" class="space-y-4">
                @csrf
                <template x-if="editingSpec"><input type="hidden" name="_method" value="PUT"></template>
                <div><label class="block text-sm font-medium text-brand-700 mb-1">Label</label><input type="text" name="label" :value="editingSpec?.label ?? ''" required class="w-full rounded-lg border-brand-300 text-sm"></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-brand-700 mb-1">Value</label><input type="text" name="value" :value="editingSpec?.value ?? ''" required class="w-full rounded-lg border-brand-300 text-sm"></div>
                    <div><label class="block text-sm font-medium text-brand-700 mb-1">Unit</label><input type="text" name="unit" :value="editingSpec?.unit ?? ''" placeholder="MW" class="w-full rounded-lg border-brand-300 text-sm"></div>
                </div>
                <div><label class="block text-sm font-medium text-brand-700 mb-1">Description</label><textarea name="description" rows="2" class="w-full rounded-lg border-brand-300 text-sm" x-text="editingSpec?.description ?? ''"></textarea></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-brand-700 mb-1">Icon</label><input type="text" name="icon" :value="editingSpec?.icon ?? ''" class="w-full rounded-lg border-brand-300 text-sm"></div>
                    <div><label class="block text-sm font-medium text-brand-700 mb-1">Sort Order</label><input type="number" name="sort_order" :value="editingSpec?.sort_order ?? 0" min="0" class="w-full rounded-lg border-brand-300 text-sm"></div>
                </div>
                <div class="flex items-center gap-2"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" :checked="editingSpec ? editingSpec.is_active : true" class="rounded border-brand-300 text-brand-teal-600"><label class="text-sm text-brand-600">Active</label></div>
                <div class="flex justify-end gap-3"><button @click="specModal = false" type="button" class="px-4 py-2 text-sm text-brand-700 hover:bg-brand-100 rounded-lg">Cancel</button><button type="submit" class="px-4 py-2 text-sm text-white bg-brand-teal-600 hover:bg-brand-teal-700 rounded-lg">Save</button></div>
            </form>
        </div>
    </div>

    <div x-show="featureModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50" @click="featureModal = false"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full p-6 max-h-[90vh] overflow-y-auto" @click.stop>
            <h3 class="text-lg font-semibold text-brand-900 mb-4" x-text="editingFeature ? 'Edit Feature' : 'Add Feature'"></h3>
            <form method="POST" enctype="multipart/form-data" :action="editingFeature ? '{{ url('admin/data-centres/'.$dataCentre->slug.'/features') }}/' + editingFeature.id : '{{ route('admin.data-centres.features.store', $dataCentre) }}'" class="space-y-4">
                @csrf
                <template x-if="editingFeature"><input type="hidden" name="_method" value="PUT"></template>
                <div><label class="block text-sm font-medium text-brand-700 mb-1">Title</label><input type="text" name="title" :value="editingFeature?.title ?? ''" required class="w-full rounded-lg border-brand-300 text-sm"></div>
                <div><label class="block text-sm font-medium text-brand-700 mb-1">Description</label><textarea name="description" rows="3" class="w-full rounded-lg border-brand-300 text-sm" x-text="editingFeature?.description ?? ''"></textarea></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-brand-700 mb-1">Icon</label><input type="text" name="icon" :value="editingFeature?.icon ?? ''" class="w-full rounded-lg border-brand-300 text-sm"></div>
                    <div><label class="block text-sm font-medium text-brand-700 mb-1">Sort Order</label><input type="number" name="sort_order" :value="editingFeature?.sort_order ?? 0" min="0" class="w-full rounded-lg border-brand-300 text-sm"></div>
                </div>
                @include('admin.components.file-upload', [
                    'name' => 'image',
                    'label' => 'Image',
                    'accept' => 'image/*',
                    'mode' => 'image',
                    'maxSize' => 5,
                    'hint' => 'PNG, JPG, GIF or WebP — max 5MB',
                ])
                <div class="flex items-center gap-2"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" :checked="editingFeature ? editingFeature.is_active : true" class="rounded border-brand-300 text-brand-teal-600"><label class="text-sm text-brand-600">Active</label></div>
                <div class="flex justify-end gap-3"><button @click="featureModal = false" type="button" class="px-4 py-2 text-sm text-brand-700 hover:bg-brand-100 rounded-lg">Cancel</button><button type="submit" class="px-4 py-2 text-sm text-white bg-brand-teal-600 hover:bg-brand-teal-700 rounded-lg">Save</button></div>
            </form>
        </div>
    </div>

    @include('admin.components.delete-modal')
</div>
@endsection
