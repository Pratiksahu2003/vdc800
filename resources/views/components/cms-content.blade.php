@props([
    'class' => '',
])

<div {{ $attributes->merge(['class' => trim('cms-content min-w-0 ' . $class)]) }}>
    {{ $slot }}
</div>
