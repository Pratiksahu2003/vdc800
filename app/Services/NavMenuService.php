<?php

namespace App\Services;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\NavMenuItem;
use App\Models\Service;
use App\Models\Solution;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class NavMenuService
{
    public function mainItems(): Collection
    {
        return NavMenuItem::treeForZone('main')
            ->map(fn (NavMenuItem $item) => $this->applyDynamicSubmenu($item))
            ->map(fn (?NavMenuItem $item) => $item ? $this->withoutRemovedRoutes($item) : null)
            ->filter()
            ->values();
    }

    public function utilityItems(): Collection
    {
        return NavMenuItem::treeForZone('utility')
            ->reject(fn ($item) => $item->slug === 'login' || $item->route_name === 'admin.login')
            ->values();
    }

    private function withoutRemovedRoutes(NavMenuItem $parent): NavMenuItem
    {
        $children = $parent->activeChildren
            ->reject(fn (NavMenuItem $child) => $child->route_name === 'legal.sitemap')
            ->values();

        $parent->setRelation('children', $children);
        $parent->setRelation('activeChildren', $children);

        return $parent;
    }

    private function applyDynamicSubmenu(NavMenuItem $parent): ?NavMenuItem
    {
        $children = match ($parent->slug) {
            'services' => $this->buildServicesChildren($parent),
            'solutions' => $this->buildSolutionsChildren($parent),
            'blog' => $this->buildBlogChildren($parent),
            default => null,
        };

        if ($children === null) {
            return $parent;
        }

        if ($children->isEmpty()) {
            return null;
        }

        $parent->setRelation('children', $children);
        $parent->setRelation('activeChildren', $children);

        return $parent;
    }

    private function buildServicesChildren(NavMenuItem $parent): Collection
    {
        $services = Service::published()->get();

        if ($services->isEmpty()) {
            return collect();
        }

        $items = collect();
        $categories = $services->groupBy(fn (Service $s) => $s->category ?: 'Advisory Services');

        $tabOrder = 1;
        foreach ($categories as $categoryName => $categoryServices) {
            $key = Str::slug($categoryName);

            $items->push($this->childFromParent($parent, [
                'is_sidebar_tab' => true,
                'sidebar_key' => $key,
                'label' => $categoryName,
                'sort_order' => $tabOrder++,
            ]));

            $items->push($this->childFromParent($parent, [
                'sidebar_key' => $key,
                'group_heading' => 'Services',
                'label' => 'All services',
                'description' => 'Browse every advisory service we offer.',
                'route_name' => 'services.index',
                'sort_order' => 5,
            ]));

            $linkOrder = 10;
            foreach ($categoryServices as $service) {
                $items->push($this->childFromParent($parent, [
                    'sidebar_key' => $key,
                    'group_heading' => 'Services',
                    'label' => $service->title,
                    'description' => $service->short_description,
                    'route_name' => 'services.show',
                    'route_params' => ['service' => $service->slug],
                    'sort_order' => $linkOrder++,
                ]));
            }
        }

        return $items->sortBy('sort_order')->values();
    }

    private function buildSolutionsChildren(NavMenuItem $parent): Collection
    {
        $solutions = Solution::published()->get();

        if ($solutions->isEmpty()) {
            return collect();
        }

        $items = collect([
            $this->childFromParent($parent, [
                'is_sidebar_tab' => true,
                'sidebar_key' => 'all',
                'label' => 'All solutions',
                'sort_order' => 1,
            ]),
            $this->childFromParent($parent, [
                'sidebar_key' => 'all',
                'group_heading' => 'Solutions',
                'label' => 'Solutions overview',
                'description' => 'Compare offerings for cloud, AI, and enterprise workloads.',
                'route_name' => 'solutions.index',
                'sort_order' => 10,
            ]),
        ]);

        $order = 11;
        foreach ($solutions as $solution) {
            $items->push($this->childFromParent($parent, [
                'sidebar_key' => 'all',
                'group_heading' => 'Solutions',
                'label' => $solution->title,
                'description' => $solution->short_description,
                'route_name' => 'solutions.show',
                'route_params' => ['solution' => $solution->slug],
                'sort_order' => $order++,
            ]));
        }

        return $items->sortBy('sort_order')->values();
    }

    private function buildBlogChildren(NavMenuItem $parent): Collection
    {
        $posts = BlogPost::query()
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->limit(8)
            ->get();

        $categories = BlogCategory::query()
            ->where('status', 'published')
            ->orderBy('sort_order')
            ->get();

        if ($posts->isEmpty() && $categories->isEmpty()) {
            return collect();
        }

        $items = collect();

        if ($posts->isNotEmpty()) {
            $items->push($this->childFromParent($parent, [
                'is_sidebar_tab' => true,
                'sidebar_key' => 'posts',
                'label' => 'Blog posts',
                'sort_order' => 1,
            ]));

            $items->push($this->childFromParent($parent, [
                'sidebar_key' => 'posts',
                'group_heading' => 'Blog posts',
                'label' => 'All blog posts',
                'description' => 'Articles, guides, and updates from our team.',
                'route_name' => 'blog.index',
                'sort_order' => 10,
            ]));

            $postOrder = 11;
            foreach ($posts as $post) {
                $items->push($this->childFromParent($parent, [
                    'sidebar_key' => 'posts',
                    'group_heading' => 'Blog posts',
                    'label' => $post->title,
                    'description' => Str::limit(strip_tags($post->excerpt ?? ''), 120),
                    'route_name' => 'blog.show',
                    'route_params' => ['post' => $post->slug],
                    'sort_order' => $postOrder++,
                ]));
            }
        }

        if ($categories->isNotEmpty()) {
            $items->push($this->childFromParent($parent, [
                'is_sidebar_tab' => true,
                'sidebar_key' => 'categories',
                'label' => 'Blog categories',
                'sort_order' => $posts->isNotEmpty() ? 2 : 1,
            ]));

            $catOrder = 10;
            foreach ($categories as $category) {
                $items->push($this->childFromParent($parent, [
                    'sidebar_key' => 'categories',
                    'group_heading' => 'Blog categories',
                    'label' => $category->name,
                    'description' => $category->description,
                    'route_name' => 'blog.index',
                    'route_params' => ['category' => $category->slug],
                    'sort_order' => $catOrder++,
                ]));
            }
        }

        return $items->sortBy('sort_order')->values();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function childFromParent(NavMenuItem $parent, array $attributes): NavMenuItem
    {
        static $virtualId = 1_000_000;

        return new NavMenuItem(array_merge([
            'id' => $virtualId++,
            'parent_id' => $parent->id,
            'zone' => $parent->zone,
            'is_active' => true,
            'is_sidebar_tab' => false,
            'dropdown_layout' => null,
        ], $attributes));
    }
}
