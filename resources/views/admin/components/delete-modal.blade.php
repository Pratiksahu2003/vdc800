@props(['title' => 'Confirm Delete', 'message' => 'Are you sure you want to delete this item? This action cannot be undone.'])

<div x-data="{ show: false, form: null }" x-on:open-delete-modal.window="show = true; form = $event.detail.form" x-cloak>
    <div x-show="show" class="fixed inset-0 z-[60] flex items-center justify-center p-4">
        <div class="fixed inset-0 bg-black/50" @click="show = false"></div>
        <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6" @click.stop>
            <h3 class="text-lg font-semibold text-brand-900 mb-2">{{ $title }}</h3>
            <p class="text-sm text-brand-600 mb-6">{{ $message }}</p>
            <div class="flex justify-end gap-3">
                <button @click="show = false" type="button" class="px-4 py-2 text-sm font-medium text-brand-700 hover:bg-brand-100 rounded-lg transition">Cancel</button>
                <button @click="if(form) form.submit(); show = false" type="button" class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-lg transition">Delete</button>
            </div>
        </div>
    </div>
</div>
