@extends('layouts.admin')

@section('title', 'About Page')

@section('content')
<div class="space-y-6" x-data="{ valueModal: false, editingValue: null }">
    <div>
        <h1 class="text-2xl font-semibold text-brand-900">About Page Content</h1>
        <p class="text-sm text-brand-500 mt-1">Manage about page content and company values.</p>
    </div>

    <form method="POST" action="{{ route('admin.content.about') }}" enctype="multipart/form-data" class="bg-white rounded-xl border border-brand-200 p-6 space-y-6">
        @csrf
        @method('PUT')

        <h3 class="font-medium text-brand-900">Hero Section</h3>
        @include('admin.components.input', ['name' => 'hero_heading', 'label' => 'Hero Heading', 'value' => $about->hero_heading])
        @include('admin.components.textarea', ['name' => 'hero_description', 'label' => 'Hero Description', 'value' => $about->hero_description, 'rows' => 3])
        @include('admin.components.image-upload', ['name' => 'hero_image', 'label' => 'Hero Image', 'existing' => $about->hero_image])

        <hr class="border-brand-200">

        <h3 class="font-medium text-brand-900">Mission & Vision</h3>
        @include('admin.components.textarea', ['name' => 'mission', 'label' => 'Mission', 'value' => $about->mission, 'rows' => 4])
        @include('admin.components.textarea', ['name' => 'vision', 'label' => 'Vision', 'value' => $about->vision, 'rows' => 4])
        @include('admin.components.textarea', ['name' => 'story', 'label' => 'Our Story', 'value' => $about->story, 'rows' => 5])
        @include('admin.components.textarea', ['name' => 'sustainability', 'label' => 'Sustainability Commitment', 'value' => $about->sustainability, 'rows' => 4])

        <hr class="border-brand-200">

        <h3 class="font-medium text-brand-900">Call to Action</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'cta_heading', 'label' => 'CTA Heading', 'value' => $about->cta_heading])
            @include('admin.components.input', ['name' => 'cta_button_text', 'label' => 'Button Text', 'value' => $about->cta_button_text])
            @include('admin.components.input', ['name' => 'cta_button_url', 'label' => 'Button URL', 'value' => $about->cta_button_url])
        </div>
        @include('admin.components.textarea', ['name' => 'cta_description', 'label' => 'CTA Description', 'value' => $about->cta_description, 'rows' => 2])

        <hr class="border-brand-200">

        <h3 class="font-medium text-brand-900">SEO</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @include('admin.components.input', ['name' => 'meta_title', 'label' => 'Meta Title', 'value' => $about->meta_title])
            @include('admin.components.textarea', ['name' => 'meta_description', 'label' => 'Meta Description', 'value' => $about->meta_description, 'rows' => 2])
        </div>

        <div class="flex justify-end pt-4 border-t border-brand-200">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
                <i data-lucide="save" class="w-4 h-4"></i> Save About Page
            </button>
        </div>
    </form>

    <div class="bg-white rounded-xl border border-brand-200">
        <div class="flex items-center justify-between px-6 py-4 border-b border-brand-200">
            <h2 class="font-semibold text-brand-900">Company Values</h2>
            <button @click="editingValue = null; valueModal = true" type="button" class="inline-flex items-center gap-2 px-3 py-2 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm rounded-lg transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Add Value
            </button>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($values as $value)
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-3">
                        <i data-lucide="{{ $value->icon ?? 'heart' }}" class="w-5 h-5 text-brand-teal-600"></i>
                        <div>
                            <p class="font-medium text-brand-900">{{ $value->title }}</p>
                            <p class="text-sm text-brand-500">{{ Str::limit($value->description, 80) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @include('admin.components.status-badge', ['status' => $value->is_active ? 'active' : 'inactive'])
                        <button @click="editingValue = @js($value); valueModal = true" type="button" class="p-2 text-brand-500 hover:text-brand-teal-600 rounded-lg"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                        <form x-ref="deleteValue{{ $value->id }}" method="POST" action="{{ route('admin.content.about.values.destroy', $value) }}" class="hidden">@csrf @method('DELETE')</form>
                        <button @click="$dispatch('open-delete-modal', { form: $refs.deleteValue{{ $value->id }} })" type="button" class="p-2 text-brand-500 hover:text-red-600 rounded-lg"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </div>
                </div>
            @empty
                <p class="px-6 py-8 text-sm text-brand-500 text-center">No values added yet.</p>
            @endforelse
        </div>
    </div>

    <div x-show="valueModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50" @click="valueModal = false"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full p-6" @click.stop>
            <h3 class="text-lg font-semibold text-brand-900 mb-4" x-text="editingValue ? 'Edit Value' : 'Add Value'"></h3>
            <form method="POST" :action="editingValue ? '{{ url('admin/content/about/values') }}/' + editingValue.id : '{{ route('admin.content.about.values.store') }}'" class="space-y-4">
                @csrf
                <template x-if="editingValue"><input type="hidden" name="_method" value="PUT"></template>
                <div><label class="block text-sm font-medium text-brand-700 mb-1">Title</label><input type="text" name="title" :value="editingValue?.title ?? ''" required class="w-full rounded-lg border-brand-300 text-sm"></div>
                <div><label class="block text-sm font-medium text-brand-700 mb-1">Description</label><textarea name="description" rows="3" class="w-full rounded-lg border-brand-300 text-sm" x-text="editingValue?.description ?? ''"></textarea></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-brand-700 mb-1">Icon</label><input type="text" name="icon" :value="editingValue?.icon ?? ''" class="w-full rounded-lg border-brand-300 text-sm"></div>
                    <div><label class="block text-sm font-medium text-brand-700 mb-1">Sort Order</label><input type="number" name="sort_order" :value="editingValue?.sort_order ?? 0" min="0" class="w-full rounded-lg border-brand-300 text-sm"></div>
                </div>
                <div class="flex items-center gap-2"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" :checked="editingValue ? editingValue.is_active : true" class="rounded border-brand-300 text-brand-teal-600"><label class="text-sm text-brand-600">Active</label></div>
                <div class="flex justify-end gap-3"><button @click="valueModal = false" type="button" class="px-4 py-2 text-sm text-brand-700 hover:bg-brand-100 rounded-lg">Cancel</button><button type="submit" class="px-4 py-2 text-sm text-white bg-brand-teal-600 hover:bg-brand-teal-700 rounded-lg">Save</button></div>
            </form>
        </div>
    </div>

    @include('admin.components.delete-modal')
</div>
@endsection
