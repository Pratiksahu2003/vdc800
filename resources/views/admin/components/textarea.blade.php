@props(['name', 'label', 'value' => '', 'rows' => 4])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-brand-700 mb-1">{{ $label }}</label>
    <textarea
        name="{{ $name }}"
        id="{{ $name }}"
        rows="{{ $rows }}"
        {{ $attributes->merge(['class' => 'w-full rounded-lg border-brand-300 shadow-sm focus:border-brand-teal-500 focus:ring-brand-teal-500 text-sm']) }}
    >{{ old($name, $value) }}</textarea>
    @error($name)
        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
