<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class NavMenuItem extends Model
{
    protected $fillable = [
        'parent_id',
        'slug',
        'zone',
        'dropdown_layout',
        'is_sidebar_tab',
        'sidebar_key',
        'group_heading',
        'label',
        'description',
        'route_name',
        'route_params',
        'url',
        'sort_order',
        'is_active',
        'is_cta',
        'open_in_new_tab',
        'promo_title',
        'promo_cta_label',
        'promo_route_name',
        'promo_route_params',
    ];

    protected $casts = [
        'route_params' => 'array',
        'promo_route_params' => 'array',
        'is_active' => 'boolean',
        'is_cta' => 'boolean',
        'is_sidebar_tab' => 'boolean',
        'open_in_new_tab' => 'boolean',
    ];

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    public function activeChildren(): HasMany
    {
        return $this->children()->where('is_active', true);
    }

    public function resolvedUrl(): ?string
    {
        if ($this->route_name) {
            try {
                $params = $this->route_params ?? [];

                return route($this->route_name, $params);
            } catch (\Throwable) {
                return $this->url;
            }
        }

        return $this->url;
    }

    public function isActiveRoute(): bool
    {
        $url = $this->resolvedUrl();
        if (! $url) {
            return false;
        }

        return url()->current() === $url;
    }

    public static function treeForZone(string $zone): Collection
    {
        $items = static::query()
            ->where('zone', $zone)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->with(['children' => fn ($q) => $q->where('is_active', true)->orderBy('sort_order')])
            ->get();

        return $items;
    }

    public function childrenGrouped(): Collection
    {
        return $this->activeChildren->groupBy(fn (self $child) => $child->group_heading ?: 'Links');
    }

    public function usesSplitDropdown(): bool
    {
        if ($this->dropdown_layout === 'split') {
            return true;
        }

        return $this->activeChildren->contains(fn (self $child) => $child->is_sidebar_tab);
    }

    public function sidebarTabs(): Collection
    {
        $tabs = $this->activeChildren->where('is_sidebar_tab', true)->values();

        if ($tabs->isNotEmpty()) {
            return $tabs;
        }

        return $this->activeChildren
            ->where('is_sidebar_tab', false)
            ->groupBy(fn (self $child) => $child->group_heading ?: 'Links')
            ->keys()
            ->map(fn (string $heading, int $index) => new self([
                'id' => $index,
                'label' => $heading,
                'sidebar_key' => Str::slug($heading),
                'is_sidebar_tab' => true,
            ]));
    }

    public function panelLinksForSidebar(?string $sidebarKey): Collection
    {
        $links = $this->activeChildren->where('is_sidebar_tab', false);

        if ($this->activeChildren->where('is_sidebar_tab', true)->isNotEmpty()) {
            if ($sidebarKey) {
                $filtered = $links->where('sidebar_key', $sidebarKey);

                return $filtered->isNotEmpty() ? $filtered->values() : $links->values();
            }

            return $links->values();
        }

        if ($sidebarKey) {
            return $links
                ->filter(fn (self $child) => Str::slug($child->group_heading ?: 'Links') === $sidebarKey)
                ->values();
        }

        return $links->values();
    }

    public function defaultSidebarKey(): ?string
    {
        $tab = $this->sidebarTabs()->first();

        return $tab?->sidebar_key ?? ($tab ? Str::slug($tab->label) : null);
    }

    public function promoUrl(): ?string
    {
        if (! $this->promo_route_name) {
            return null;
        }

        try {
            return route($this->promo_route_name, $this->promo_route_params ?? []);
        } catch (\Throwable) {
            return null;
        }
    }
}
