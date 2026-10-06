@props(['status'])

@php
    $classes = match($status) {
        'published', 'active' => 'bg-green-100 text-green-800',
        'draft', 'inactive' => 'bg-brand-100 text-brand-600',
        'new' => 'bg-blue-100 text-blue-800',
        'contacted' => 'bg-amber-100 text-amber-800',
        'closed' => 'bg-brand-100 text-brand-600',
        default => 'bg-brand-100 text-brand-600',
    };
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $classes }}">
    {{ ucfirst($status) }}
</span>
