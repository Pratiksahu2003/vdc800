@props(['item'])

@php
    $split = $item->usesSplitDropdown();
    $sidebarTabs = $item->sidebarTabs();
    $defaultPanel = $item->defaultSidebarKey() ?? Str::slug($sidebarTabs->first()?->label ?? 'links');
@endphp

<div x-data="{ panel: @js($defaultPanel) }" class="eq-nav-mobile-panel pb-4">
    @if($split && $sidebarTabs->count() > 1)
        <div class="eq-nav-mobile-tabs" role="tablist">
            @foreach($sidebarTabs as $tab)
                @php $tabKey = $tab->sidebar_key ?: Str::slug($tab->label); @endphp
                <button
                    type="button"
                    role="tab"
                    class="eq-nav-mobile-tab"
                    :class="panel === @js($tabKey) && 'eq-nav-mobile-tab--active'"
                    :aria-selected="panel === @js($tabKey)"
                    @click="panel = @js($tabKey)"
                >
                    {{ $tab->label }}
                </button>
            @endforeach
        </div>
    @endif

    @foreach($sidebarTabs as $tab)
        @php
            $tabKey = $tab->sidebar_key ?: Str::slug($tab->label);
            $panelLinks = $item->panelLinksForSidebar($tabKey);
            $panelGroups = $panelLinks->groupBy(fn ($l) => $l->group_heading ?: 'Explore');
        @endphp
        <div x-show="panel === @js($tabKey)" x-cloak class="space-y-5 pt-3">
            @foreach($panelGroups as $groupTitle => $groupLinks)
                <div>
                    <p class="eq-nav-mobile-eyebrow">{{ $groupTitle }}</p>
                    <ul class="space-y-1">
                        @foreach($groupLinks as $link)
                            <li>
                                <a
                                    href="{{ $link->resolvedUrl() ?? '#' }}"
                                    class="eq-nav-mobile-link group"
                                    @click="closeAllMenus()"
                                >
                                    <span class="eq-nav-mobile-link-title">{{ $link->label }}</span>
                                    @if($link->description)
                                        <span class="eq-nav-mobile-link-desc">{{ Str::limit($link->description, 140) }}</span>
                                    @endif
                                    <i data-lucide="chevron-right" class="eq-nav-mobile-link-icon w-4 h-4 shrink-0 opacity-40 group-hover:opacity-100"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    @endforeach

    @if($sidebarTabs->isEmpty())
        @foreach($item->childrenGrouped() as $heading => $links)
            <div class="pt-2">
                <p class="eq-nav-mobile-eyebrow">{{ $heading }}</p>
                <ul class="space-y-1">
                    @foreach($links as $link)
                        <li>
                            <a href="{{ $link->resolvedUrl() ?? '#' }}" class="eq-nav-mobile-link" @click="closeAllMenus()">
                                <span class="eq-nav-mobile-link-title">{{ $link->label }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    @endif

    @if($item->promo_title)
        <a href="{{ $item->promoUrl() ?? route('contact.index') }}" class="eq-nav-mobile-promo" @click="closeAllMenus()">
            <p class="font-semibold text-sm leading-snug">{{ $item->promo_title }}</p>
            @if($item->promo_cta_label)
                <span class="inline-flex items-center gap-1.5 mt-2 text-xs font-semibold text-white/90">
                    {{ $item->promo_cta_label }}
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5"></i>
                </span>
            @endif
        </a>
    @endif
</div>
