@props([
    'name',
    'label',
    'existing' => null,
    'required' => false,
    'hint' => 'PNG, JPG, GIF or WebP — max 5MB',
])

@php
    $existingUrl = $existing;
    if ($existingUrl && ! str_starts_with($existingUrl, 'http')) {
        $existingUrl = str_starts_with($existingUrl, 'images/')
            ? asset($existingUrl)
            : Storage::url($existingUrl);
    }
@endphp

<div
    x-data="imageUploader({ maxSize: 5 * 1024 * 1024 })"
    data-existing="{{ $existingUrl ?? '' }}"
    class="space-y-2"
>
    <label class="block text-sm font-medium text-brand-700">{{ $label }}</label>

    <div class="flex flex-col sm:flex-row items-start gap-4">
        <div
            x-show="preview"
            x-cloak
            class="relative w-28 h-28 shrink-0 rounded-xl overflow-hidden border border-brand-200 bg-brand-50 shadow-sm"
        >
            <img :src="preview" alt="Preview" class="w-full h-full object-cover">
            <button
                type="button"
                @click="remove"
                class="absolute top-1.5 right-1.5 p-1 rounded-md bg-white/90 text-brand-500 hover:text-red-600 hover:bg-white shadow-sm transition"
                title="Remove image"
            >
                <i data-lucide="x" class="w-3.5 h-3.5"></i>
            </button>
        </div>

        <div
            class="flex-1 w-full"
            @dragover.prevent="onDragOver"
            @dragleave.prevent="onDragLeave"
            @drop.prevent="onDrop"
        >
            <div
                @click="$refs.fileInput.click()"
                :class="isDragging ? 'border-brand-teal-500 bg-brand-teal-50/60 ring-2 ring-brand-teal-200' : 'border-brand-200 bg-brand-50/40 hover:border-brand-teal-400 hover:bg-brand-teal-50/30'"
                class="relative flex flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed px-4 py-8 cursor-pointer transition-all duration-200"
            >
                <div
                    :class="isDragging ? 'bg-brand-teal-100 text-brand-teal-700' : 'bg-white text-brand-teal-600'"
                    class="flex items-center justify-center w-11 h-11 rounded-full shadow-sm transition-colors"
                >
                    <i data-lucide="image-up" class="w-5 h-5"></i>
                </div>

                <div class="text-center">
                    <p class="text-sm font-medium text-brand-800">
                        <span class="text-brand-teal-600">Click to upload</span>
                        <span class="text-brand-500"> or drag and drop</span>
                    </p>
                    <p class="text-xs text-brand-500 mt-1">{{ $hint }}</p>
                </div>

                <p x-show="fileName" x-text="fileName" class="text-xs font-medium text-brand-teal-700 truncate max-w-full px-2"></p>

                <input
                    type="file"
                    x-ref="fileInput"
                    name="{{ $name }}"
                    accept="image/*"
                    @if($required) required @endif
                    @change="handleFileSelect"
                    class="sr-only"
                >
            </div>

            <input type="hidden" name="remove_{{ $name }}" value="0" x-ref="removeField">
        </div>
    </div>

    @error($name)
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
