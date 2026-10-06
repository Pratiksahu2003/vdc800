@props(['name', 'label', 'value' => '', 'type' => 'text', 'required' => false])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-brand-700 mb-1">{{ $label }}</label>
    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        {{ $attributes->merge(['class' => 'w-full rounded-lg border-brand-300 shadow-sm focus:border-brand-teal-500 focus:ring-brand-teal-500 text-sm']) }}
    >
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
