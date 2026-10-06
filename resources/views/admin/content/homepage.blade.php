@extends('layouts.admin')

@section('title', 'Homepage Content')

@section('content')
<div class="space-y-6" x-data="{ tab: 'hero', benefitModal: false, statModal: false, editingBenefit: null, editingStat: null }">
    <div>
        <h1 class="text-2xl font-semibold text-brand-900">Homepage Content</h1>
        <p class="text-sm text-brand-500 mt-1">Manage hero, sections, benefits, and statistics.</p>
    </div>

    <div class="flex flex-wrap gap-2 border-b border-brand-200 pb-4">
        @foreach(['hero' => 'Hero', 'intro' => 'Intro', 'sustainability' => 'Sustainability', 'infrastructure' => 'Infrastructure', 'cta' => 'Final CTA', 'benefits' => 'Benefits', 'statistics' => 'Statistics'] as $key => $label)
            <button type="button" @click="tab = '{{ $key }}'" :class="tab === '{{ $key }}' ? 'bg-brand-teal-600 text-white' : 'bg-white text-brand-600 hover:bg-brand-50'" class="px-4 py-2 text-sm font-medium rounded-lg border border-brand-200 transition">{{ $label }}</button>
        @endforeach
    </div>

    <form method="POST" action="{{ route('admin.content.homepage') }}" enctype="multipart/form-data" class="bg-white rounded-xl border border-brand-200 p-6 space-y-6">
        @csrf
        @method('PUT')

        <div x-show="tab === 'hero'" class="space-y-4">
            @include('admin.components.input', ['name' => 'hero_heading', 'label' => 'Hero Heading', 'value' => $homepage->hero_heading])
            @include('admin.components.input', ['name' => 'hero_subtitle', 'label' => 'Hero Subtitle', 'value' => $homepage->hero_subtitle])
            @include('admin.components.textarea', ['name' => 'hero_description', 'label' => 'Hero Description', 'value' => $homepage->hero_description, 'rows' => 4])
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @include('admin.components.input', ['name' => 'hero_cta_text', 'label' => 'Primary CTA Text', 'value' => $homepage->hero_cta_text])
                @include('admin.components.input', ['name' => 'hero_cta_url', 'label' => 'Primary CTA URL', 'value' => $homepage->hero_cta_url])
                @include('admin.components.input', ['name' => 'hero_secondary_cta_text', 'label' => 'Secondary CTA Text', 'value' => $homepage->hero_secondary_cta_text])
                @include('admin.components.input', ['name' => 'hero_secondary_cta_url', 'label' => 'Secondary CTA URL', 'value' => $homepage->hero_secondary_cta_url])
            </div>
            @include('admin.components.image-upload', ['name' => 'hero_background_image', 'label' => 'Hero Background Image', 'existing' => $homepage->hero_background_image])
        </div>

        <div x-show="tab === 'intro'" x-cloak class="space-y-4">
            @include('admin.components.input', ['name' => 'intro_heading', 'label' => 'Intro Heading', 'value' => $homepage->intro_heading])
            @include('admin.components.textarea', ['name' => 'intro_description', 'label' => 'Intro Description', 'value' => $homepage->intro_description, 'rows' => 4])
            @include('admin.components.image-upload', ['name' => 'intro_image', 'label' => 'Intro Image', 'existing' => $homepage->intro_image])
        </div>

        <div x-show="tab === 'sustainability'" x-cloak class="space-y-4">
            @include('admin.components.input', ['name' => 'sustainability_heading', 'label' => 'Sustainability Heading', 'value' => $homepage->sustainability_heading])
            @include('admin.components.textarea', ['name' => 'sustainability_description', 'label' => 'Sustainability Description', 'value' => $homepage->sustainability_description, 'rows' => 4])
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @include('admin.components.input', ['name' => 'sustainability_cta_text', 'label' => 'CTA Text', 'value' => $homepage->sustainability_cta_text])
                @include('admin.components.input', ['name' => 'sustainability_cta_url', 'label' => 'CTA URL', 'value' => $homepage->sustainability_cta_url])
            </div>
            @include('admin.components.image-upload', ['name' => 'sustainability_image', 'label' => 'Sustainability Image', 'existing' => $homepage->sustainability_image])
        </div>

        <div x-show="tab === 'infrastructure'" x-cloak class="space-y-4">
            @include('admin.components.input', ['name' => 'infrastructure_heading', 'label' => 'Infrastructure Heading', 'value' => $homepage->infrastructure_heading])
            @include('admin.components.textarea', ['name' => 'infrastructure_description', 'label' => 'Infrastructure Description', 'value' => $homepage->infrastructure_description, 'rows' => 4])
            @include('admin.components.image-upload', ['name' => 'infrastructure_image', 'label' => 'Infrastructure Image', 'existing' => $homepage->infrastructure_image])
        </div>

        <div x-show="tab === 'cta'" x-cloak class="space-y-4">
            @include('admin.components.input', ['name' => 'final_cta_heading', 'label' => 'Final CTA Heading', 'value' => $homepage->final_cta_heading])
            @include('admin.components.textarea', ['name' => 'final_cta_description', 'label' => 'Final CTA Description', 'value' => $homepage->final_cta_description, 'rows' => 3])
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @include('admin.components.input', ['name' => 'final_cta_button_text', 'label' => 'Button Text', 'value' => $homepage->final_cta_button_text])
                @include('admin.components.input', ['name' => 'final_cta_button_url', 'label' => 'Button URL', 'value' => $homepage->final_cta_button_url])
            </div>
        </div>

        <div x-show="!['benefits', 'statistics'].includes(tab)" class="flex justify-end pt-4 border-t border-brand-200">
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
                <i data-lucide="save" class="w-4 h-4"></i> Save Homepage
            </button>
        </div>
    </form>

    {{-- Benefits Tab --}}
    <div x-show="tab === 'benefits'" x-cloak class="bg-white rounded-xl border border-brand-200">
        <div class="flex items-center justify-between px-6 py-4 border-b border-brand-200">
            <h2 class="font-semibold text-brand-900">Homepage Benefits</h2>
            <button @click="editingBenefit = null; benefitModal = true" type="button" class="inline-flex items-center gap-2 px-3 py-2 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm rounded-lg transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Add Benefit
            </button>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($benefits as $benefit)
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center gap-3">
                        <i data-lucide="{{ $benefit->icon ?? 'check-circle' }}" class="w-5 h-5 text-brand-teal-600"></i>
                        <div>
                            <p class="font-medium text-brand-900">{{ $benefit->title }}</p>
                            <p class="text-sm text-brand-500">{{ Str::limit($benefit->description, 80) }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        @include('admin.components.status-badge', ['status' => $benefit->is_active ? 'active' : 'inactive'])
                        <button @click="editingBenefit = @js($benefit); benefitModal = true" type="button" class="p-2 text-brand-500 hover:text-brand-teal-600 rounded-lg"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                        <form x-ref="deleteBenefit{{ $benefit->id }}" method="POST" action="{{ route('admin.content.homepage.benefits.destroy', $benefit) }}" class="hidden">@csrf @method('DELETE')</form>
                        <button @click="$dispatch('open-delete-modal', { form: $refs.deleteBenefit{{ $benefit->id }} })" type="button" class="p-2 text-brand-500 hover:text-red-600 rounded-lg"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </div>
                </div>
            @empty
                <p class="px-6 py-8 text-sm text-brand-500 text-center">No benefits added yet.</p>
            @endforelse
        </div>
    </div>

    {{-- Statistics Tab --}}
    <div x-show="tab === 'statistics'" x-cloak class="bg-white rounded-xl border border-brand-200">
        <div class="flex items-center justify-between px-6 py-4 border-b border-brand-200">
            <h2 class="font-semibold text-brand-900">Homepage Statistics</h2>
            <button @click="editingStat = null; statModal = true" type="button" class="inline-flex items-center gap-2 px-3 py-2 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm rounded-lg transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Add Statistic
            </button>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse($statistics as $stat)
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <p class="text-2xl font-semibold text-brand-teal-600">{{ $stat->number }}</p>
                        <p class="font-medium text-brand-900">{{ $stat->label }}</p>
                        @if($stat->description)<p class="text-sm text-brand-500">{{ $stat->description }}</p>@endif
                    </div>
                    <div class="flex items-center gap-2">
                        @include('admin.components.status-badge', ['status' => $stat->is_active ? 'active' : 'inactive'])
                        <button @click="editingStat = @js($stat); statModal = true" type="button" class="p-2 text-brand-500 hover:text-brand-teal-600 rounded-lg"><i data-lucide="pencil" class="w-4 h-4"></i></button>
                        <form x-ref="deleteStat{{ $stat->id }}" method="POST" action="{{ route('admin.content.homepage.statistics.destroy', $stat) }}" class="hidden">@csrf @method('DELETE')</form>
                        <button @click="$dispatch('open-delete-modal', { form: $refs.deleteStat{{ $stat->id }} })" type="button" class="p-2 text-brand-500 hover:text-red-600 rounded-lg"><i data-lucide="trash-2" class="w-4 h-4"></i></button>
                    </div>
                </div>
            @empty
                <p class="px-6 py-8 text-sm text-brand-500 text-center">No statistics added yet.</p>
            @endforelse
        </div>
    </div>

    {{-- Benefit Modal --}}
    <div x-show="benefitModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50" @click="benefitModal = false"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full p-6" @click.stop>
            <h3 class="text-lg font-semibold text-brand-900 mb-4" x-text="editingBenefit ? 'Edit Benefit' : 'Add Benefit'"></h3>
            <form method="POST" :action="editingBenefit ? '{{ url('admin/content/homepage/benefits') }}/' + editingBenefit.id : '{{ route('admin.content.homepage.benefits.store') }}'" class="space-y-4">
                @csrf
                <template x-if="editingBenefit"><input type="hidden" name="_method" value="PUT"></template>
                <div><label class="block text-sm font-medium text-brand-700 mb-1">Title</label><input type="text" name="title" :value="editingBenefit?.title ?? ''" required class="w-full rounded-lg border-brand-300 text-sm"></div>
                <div><label class="block text-sm font-medium text-brand-700 mb-1">Description</label><textarea name="description" rows="3" class="w-full rounded-lg border-brand-300 text-sm" x-text="editingBenefit?.description ?? ''"></textarea></div>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-brand-700 mb-1">Icon</label><input type="text" name="icon" :value="editingBenefit?.icon ?? ''" placeholder="leaf" class="w-full rounded-lg border-brand-300 text-sm"></div>
                    <div><label class="block text-sm font-medium text-brand-700 mb-1">Sort Order</label><input type="number" name="sort_order" :value="editingBenefit?.sort_order ?? 0" min="0" class="w-full rounded-lg border-brand-300 text-sm"></div>
                </div>
                <div class="flex items-center gap-2"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" :checked="editingBenefit ? editingBenefit.is_active : true" class="rounded border-brand-300 text-brand-teal-600"><label class="text-sm text-brand-600">Active</label></div>
                <div class="flex justify-end gap-3"><button @click="benefitModal = false" type="button" class="px-4 py-2 text-sm text-brand-700 hover:bg-brand-100 rounded-lg">Cancel</button><button type="submit" class="px-4 py-2 text-sm text-white bg-brand-teal-600 hover:bg-brand-teal-700 rounded-lg">Save</button></div>
            </form>
        </div>
    </div>

    {{-- Statistic Modal --}}
    <div x-show="statModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50" @click="statModal = false"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full p-6" @click.stop>
            <h3 class="text-lg font-semibold text-brand-900 mb-4" x-text="editingStat ? 'Edit Statistic' : 'Add Statistic'"></h3>
            <form method="POST" :action="editingStat ? '{{ url('admin/content/homepage/statistics') }}/' + editingStat.id : '{{ route('admin.content.homepage.statistics.store') }}'" class="space-y-4">
                @csrf
                <template x-if="editingStat"><input type="hidden" name="_method" value="PUT"></template>
                <div class="grid grid-cols-2 gap-4">
                    <div><label class="block text-sm font-medium text-brand-700 mb-1">Number</label><input type="text" name="number" :value="editingStat?.number ?? ''" required class="w-full rounded-lg border-brand-300 text-sm"></div>
                    <div><label class="block text-sm font-medium text-brand-700 mb-1">Sort Order</label><input type="number" name="sort_order" :value="editingStat?.sort_order ?? 0" min="0" class="w-full rounded-lg border-brand-300 text-sm"></div>
                </div>
                <div><label class="block text-sm font-medium text-brand-700 mb-1">Label</label><input type="text" name="label" :value="editingStat?.label ?? ''" required class="w-full rounded-lg border-brand-300 text-sm"></div>
                <div><label class="block text-sm font-medium text-brand-700 mb-1">Description</label><input type="text" name="description" :value="editingStat?.description ?? ''" class="w-full rounded-lg border-brand-300 text-sm"></div>
                <div class="flex items-center gap-2"><input type="hidden" name="is_active" value="0"><input type="checkbox" name="is_active" value="1" :checked="editingStat ? editingStat.is_active : true" class="rounded border-brand-300 text-brand-teal-600"><label class="text-sm text-brand-600">Active</label></div>
                <div class="flex justify-end gap-3"><button @click="statModal = false" type="button" class="px-4 py-2 text-sm text-brand-700 hover:bg-brand-100 rounded-lg">Cancel</button><button type="submit" class="px-4 py-2 text-sm text-white bg-brand-teal-600 hover:bg-brand-teal-700 rounded-lg">Save</button></div>
            </form>
        </div>
    </div>

    @include('admin.components.delete-modal')
</div>
@endsection
