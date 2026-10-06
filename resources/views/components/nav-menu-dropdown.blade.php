@props(['item', 'menuKey'])

@php
    use Illuminate\Support\Str;
    $split = $item->usesSplitDropdown();
    $sidebarTabs = $item->sidebarTabs();
    $defaultPanel = $item->defaultSidebarKey() ?? Str::slug($sidebarTabs->first()?->label ?? 'links');
    $showSidebar = $split && $sidebarTabs->count() > 1;
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
    <div class="eq-nav-mega-panel">
        <div class="eq-nav-mega eq-nav-mega--split @if($showSidebar) eq-nav-mega--has-sidebar @endif">
            @if($split && $sidebarTabs->isNotEmpty())
                @if($showSidebar)
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
                                        <i data-lucide="chevron-right" class="w-4 h-4 eq-nav-sidebar-tab-icon" :class="panel === @js($tabKey) && 'opacity-60'"></i>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </aside>
                @endif

                <div class="eq-nav-mega__main @if(!$showSidebar) eq-nav-mega__main--single @endif">
                    <div class="eq-nav-mega__scroll">
                        @foreach($sidebarTabs as $tab)
                            @php
                                $tabKey = $tab->sidebar_key ?: Str::slug($tab->label);
                                $panelLinks = $item->panelLinksForSidebar($tabKey);
                                $panelGroups = $panelLinks->groupBy(fn ($l) => $l->group_heading ?: 'Explore');
                            @endphp
                            <div x-show="panel === @js($tabKey)" x-cloak class="eq-nav-mega__panel">
                                @foreach($panelGroups as $groupTitle => $groupLinks)
                                    <div class="eq-nav-mega__group {{ !$loop->last ? 'mb-3' : '' }}">
                                        @if($panelGroups->count() > 1)
                                            <p class="eq-nav-mega__eyebrow">{{ $groupTitle }}</p>
                                        @endif
                                        <ul class="eq-nav-mega__link-grid">
                                            @foreach($groupLinks as $link)
                                                <li class="min-w-0">
                                                    <a
                                                        href="{{ $link->resolvedUrl() ?? '#' }}"
                                                        @if($link->open_in_new_tab) target="_blank" rel="noopener noreferrer" @endif
                                                        class="eq-nav-mega__link group"
                                                        @click="closeMenus()"
                                                    >
                                                        <span class="eq-nav-mega__link-title">{{ $link->label }}</span>
                                                        @if($link->description)
                                                            <span class="eq-nav-mega__link-desc">{{ Str::limit($link->description, 100) }}</span>
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
                        <a href="{{ $item->promoUrl() ?? route('contact.index') }}" class="eq-nav-mega__promo eq-nav-mega__promo--compact shrink-0" @click="closeMenus()">
                            <p class="eq-nav-mega__promo-title">{{ $item->promo_title }}</p>
                            @if($item->promo_cta_label)
                                <span class="eq-nav-mega__promo-cta">
                                    {{ $item->promo_cta_label }}
                                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                                </span>
                            @endif
                        </a>
                    @endif
                </div>
            @else
                @php $groups = $item->childrenGrouped(); @endphp
                <div class="eq-nav-mega__main eq-nav-mega__main--grid-only">
                    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-{{ min(max($groups->count(), 1), 3) }}">
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
