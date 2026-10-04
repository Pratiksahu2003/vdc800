@props(['item', 'menuKey'])

@php
    use Illuminate\Support\Str;
    $split = $item->usesSplitDropdown();
    $sidebarTabs = $item->sidebarTabs();
    $defaultPanel = $item->defaultSidebarKey() ?? Str::slug($sidebarTabs->first()?->label ?? 'links');
@endphp

<div
    x-show="activeMenu === @js($menuKey)"
    x-cloak
    x-data="{ panel: @js($defaultPanel) }"
    x-effect="if (activeMenu === @js($menuKey)) { panel = @js($defaultPanel); }"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 translate-y-3"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-2"
    class="eq-nav-dropdown-shell"
    @mouseenter="openMenu(@js($menuKey))"
>
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-5">
        <div class="eq-nav-mega @if($split && $sidebarTabs->isNotEmpty()) eq-nav-mega--split @endif">
            @if($split && $sidebarTabs->isNotEmpty())
                <aside class="eq-nav-mega__sidebar" aria-label="Menu categories">
                    <ul class="eq-nav-mega__sidebar-list">
                        @foreach($sidebarTabs as $tab)
                            @php $tabKey = $tab->sidebar_key ?: Str::slug($tab->label); @endphp
                            <li>
                                <button
                                    type="button"
                                    class="eq-nav-sidebar-tab"
                                    :class="panel === @js($tabKey) && 'eq-nav-sidebar-tab--active'"
                                    @mouseenter="panel = @js($tabKey)"
                                    @focus="panel = @js($tabKey)"
                                    @click="panel = @js($tabKey)"
                                >
                                    <span>{{ $tab->label }}</span>
                                    <i data-lucide="chevron-right" class="w-4 h-4 opacity-0 -translate-x-1 transition-all eq-nav-sidebar-tab-icon" :class="panel === @js($tabKey) && 'opacity-60 translate-x-0'"></i>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </aside>

                <div class="eq-nav-mega__main">
                    <div class="eq-nav-mega__scroll">
                        @foreach($sidebarTabs as $tab)
                            @php
                                $tabKey = $tab->sidebar_key ?: Str::slug($tab->label);
                                $panelLinks = $item->panelLinksForSidebar($tabKey);
                                $panelGroups = $panelLinks->groupBy(fn ($l) => $l->group_heading ?: 'Explore');
                            @endphp
                            <div x-show="panel === @js($tabKey)" x-cloak class="eq-nav-mega__panel">
                                @foreach($panelGroups as $groupTitle => $groupLinks)
                                    <div class="eq-nav-mega__group {{ !$loop->last ? 'mb-8' : '' }}">
                                        <p class="eq-nav-mega__eyebrow">{{ $groupTitle }}</p>
                                        <ul class="eq-nav-mega__link-grid">
                                            @foreach($groupLinks as $link)
                                                <li>
                                                    <a
                                                        href="{{ $link->resolvedUrl() ?? '#' }}"
                                                        @if($link->open_in_new_tab) target="_blank" rel="noopener noreferrer" @endif
                                                        class="eq-nav-mega__link group"
                                                        @click="closeMenus()"
                                                    >
                                                        <span class="eq-nav-mega__link-title">{{ $link->label }}</span>
                                                        @if($link->description)
                                                            <span class="eq-nav-mega__link-desc">{{ Str::limit($link->description, 120) }}</span>
                                                        @endif
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>

                    @if($item->promo_title)
                        <a href="{{ $item->promoUrl() ?? route('contact.index') }}" class="eq-nav-mega__promo shrink-0" @click="closeMenus()">
                            <div class="eq-nav-mega__promo-inner">
                                <p class="eq-nav-mega__promo-title">{{ $item->promo_title }}</p>
                                @if($item->promo_cta_label)
                                    <span class="eq-nav-mega__promo-cta">
                                        {{ $item->promo_cta_label }}
                                        <i data-lucide="arrow-right" class="w-4 h-4"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="eq-nav-mega__promo-art" aria-hidden="true"></div>
                        </a>
                    @endif
                </div>
            @else
                @php $groups = $item->childrenGrouped(); @endphp
                <div class="eq-nav-mega__main eq-nav-mega__main--grid-only">
                    <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-{{ min(max($groups->count(), 1), 3) }}">
                        @foreach($groups as $heading => $links)
                            <div>
                                <p class="eq-nav-mega__eyebrow">{{ $heading }}</p>
                                <ul class="eq-nav-mega__links">
                                    @foreach($links as $link)
                                        <li>
                                            <a href="{{ $link->resolvedUrl() ?? '#' }}" class="eq-nav-mega__link group" @click="closeMenus()">
                                                <span class="eq-nav-mega__link-title">{{ $link->label }}</span>
                                                @if($link->description)
                                                    <span class="eq-nav-mega__link-desc">{{ $link->description }}</span>
                                                @endif
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
