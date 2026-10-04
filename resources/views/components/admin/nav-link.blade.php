@props([
    'href',
    'icon',
    'label',
    'active' => false,
    'nested' => false,
])

<a
    href="{{ $href }}"
    data-nav-label="{{ strtolower($label) }}"
    @class([
        'admin-nav-link',
        'admin-nav-link--active' => $active,
        'admin-nav-link--nested' => $nested,
    ])
    @if($active) aria-current="page" @endif
    x-show="navItemVisible(@js(strtolower($label)))"
>
    <span class="admin-nav-link__icon" aria-hidden="true">
        <i data-lucide="{{ $icon }}" class="w-[17px] h-[17px]"></i>
    </span>
    <span class="admin-nav-link__label">{{ $label }}</span>
    @if($active)
        <span class="admin-nav-link__active-dot" aria-hidden="true"></span>
    @endif
</a>
