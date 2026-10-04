@props([
    'href',
    'icon',
    'label',
    'active' => false,
    'nested' => false,
])

<a
    href="{{ $href }}"
    @class([
        'admin-nav-link',
        'admin-nav-link--active' => $active,
        'admin-nav-link--nested' => $nested,
    ])
    @if($active) aria-current="page" @endif
>
    <span class="admin-nav-link__icon">
        <i data-lucide="{{ $icon }}" class="w-[18px] h-[18px]"></i>
    </span>
    <span class="admin-nav-link__label">{{ $label }}</span>
</a>
