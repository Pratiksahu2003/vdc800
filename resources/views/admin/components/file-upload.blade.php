@props([
    'name',
    'label',
    'accept' => 'image/*,.pdf,.svg',
    'required' => false,
    'hint' => 'Drag and drop or click to browse',
    'maxSize' => 10,
    'mode' => 'file',
])

<div
    x-data="fileUploader({
        accept: '{{ $accept }}',
        maxSize: {{ $maxSize }} * 1024 * 1024,
        mode: '{{ $mode }}',
    })"
    class="space-y-2"
>
    <label class="block text-sm font-medium text-brand-700">{{ $label }}</label>

    <div
        class="w-full"
        @dragover.prevent="onDragOver"
        @dragleave.prevent="onDragLeave"
        @drop.prevent="onDrop"
    >
        <div
            @click="$refs.fileInput.click()"
            :class="isDragging ? 'border-brand-teal-500 bg-brand-teal-50/60 ring-2 ring-brand-teal-200' : 'border-brand-200 bg-brand-50/40 hover:border-brand-teal-400 hover:bg-brand-teal-50/30'"
            class="relative flex flex-col items-center justify-center gap-2 rounded-xl border-2 border-dashed px-4 py-8 cursor-pointer transition-all duration-200"
        >
            <template x-if="preview && mode === 'image'">
                <div class="w-20 h-20 rounded-lg overflow-hidden border border-brand-200 shadow-sm mb-1">
                    <img :src="preview" alt="Preview" class="w-full h-full object-cover">
                </div>
            </template>

            <template x-if="!preview || mode !== 'image'">
                <div
                    :class="isDragging ? 'bg-brand-teal-100 text-brand-teal-700' : 'bg-white text-brand-teal-600'"
                    class="flex items-center justify-center w-11 h-11 rounded-full shadow-sm transition-colors"
                >
                    <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                </div>
            </template>

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
                accept="{{ $accept }}"
                @if($required) required @endif
                @change="handleFileSelect"
                class="sr-only"
            >
        </div>
    </div>

    @error($name)
        <p class="text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
