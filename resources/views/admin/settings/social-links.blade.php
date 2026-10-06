@extends('layouts.admin')

@section('title', 'Social Links')

@section('content')
<div class="space-y-6" x-data="{
    showModal: false,
    editing: null,
    openCreate() { this.editing = null; this.showModal = true; },
    openEdit(link) { this.editing = link; this.showModal = true; }
}">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold text-brand-900">Social Links</h1>
            <p class="text-sm text-brand-500 mt-1">Manage social media profiles displayed on your website.</p>
        </div>
        <button @click="openCreate()" type="button" class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand-teal-600 hover:bg-brand-teal-700 text-white text-sm font-medium rounded-lg transition">
            <i data-lucide="plus" class="w-4 h-4"></i> Add Link
        </button>
    </div>

    <div class="bg-white rounded-xl border border-brand-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-brand-50 border-b border-brand-200">
                <tr>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">Platform</th>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">URL</th>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">Icon</th>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">Order</th>
                    <th class="text-left px-6 py-3 font-medium text-brand-600">Status</th>
                    <th class="text-right px-6 py-3 font-medium text-brand-600">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($links as $link)
                    <tr class="hover:bg-brand-50">
                        <td class="px-6 py-4 font-medium text-brand-900">{{ $link->platform }}</td>
                        <td class="px-6 py-4 text-brand-600 truncate max-w-xs">{{ $link->url }}</td>
                        <td class="px-6 py-4">
                            <x-social-icon :name="$link->icon ?? $link->platform ?? 'link'" class="w-4 h-4 text-brand-500" />
                        </td>
                        <td class="px-6 py-4 text-brand-600">{{ $link->sort_order }}</td>
                        <td class="px-6 py-4">
                            @include('admin.components.status-badge', ['status' => $link->is_active ? 'active' : 'inactive'])
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="openEdit(@js($link))" type="button" class="p-2 text-brand-500 hover:text-brand-teal-600 hover:bg-brand-teal-50 rounded-lg transition">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                </button>
                                <form method="POST" action="{{ route('admin.settings.social-links.toggle', $link) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="p-2 text-brand-500 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Toggle status">
                                        <i data-lucide="toggle-left" class="w-4 h-4"></i>
                                    </button>
                                </form>
                                <form x-ref="deleteForm{{ $link->id }}" method="POST" action="{{ route('admin.settings.social-links.destroy', $link) }}" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button @click="$dispatch('open-delete-modal', { form: $refs.deleteForm{{ $link->id }} })" type="button" class="p-2 text-brand-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-brand-500">No social links yet. Add your first link.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Create / Edit Modal --}}
    <div x-show="showModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50" @click="showModal = false"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full p-6" @click.stop>
            <h3 class="text-lg font-semibold text-brand-900 mb-4" x-text="editing ? 'Edit Social Link' : 'Add Social Link'"></h3>

            <form method="POST" :action="editing ? '{{ url('admin/settings/social-links') }}/' + editing.id : '{{ route('admin.settings.social-links') }}'" class="space-y-4">
                @csrf
                <template x-if="editing">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-sm font-medium text-brand-700 mb-1">Platform</label>
                    <input type="text" name="platform" :value="editing?.platform ?? ''" required class="w-full rounded-lg border-brand-300 shadow-sm focus:border-brand-teal-500 focus:ring-brand-teal-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-brand-700 mb-1">URL</label>
                    <input type="url" name="url" :value="editing?.url ?? ''" required class="w-full rounded-lg border-brand-300 shadow-sm focus:border-brand-teal-500 focus:ring-brand-teal-500 text-sm">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-brand-700 mb-1">Lucide Icon</label>
                        <input type="text" name="icon" :value="editing?.icon ?? ''" placeholder="linkedin" class="w-full rounded-lg border-brand-300 shadow-sm focus:border-brand-teal-500 focus:ring-brand-teal-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-brand-700 mb-1">Sort Order</label>
                        <input type="number" name="sort_order" :value="editing?.sort_order ?? 0" min="0" class="w-full rounded-lg border-brand-300 shadow-sm focus:border-brand-teal-500 focus:ring-brand-teal-500 text-sm">
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" :checked="editing ? editing.is_active : true" class="rounded border-brand-300 text-brand-teal-600 focus:ring-brand-teal-500">
                    <label class="text-sm text-brand-600">Active</label>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button @click="showModal = false" type="button" class="px-4 py-2 text-sm font-medium text-brand-700 hover:bg-brand-100 rounded-lg transition">Cancel</button>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-brand-teal-600 hover:bg-brand-teal-700 rounded-lg transition">Save</button>
                </div>
            </form>
        </div>
    </div>

    @include('admin.components.delete-modal')
</div>
@endsection
