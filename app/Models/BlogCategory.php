<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class BlogCategory extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'sort_order', 'status',
    ];

    protected static function booted(): void
    {
        static::creating(function (BlogCategory $category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function posts(): HasMany
    {
        return $this->hasMany(BlogPost::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->orderBy('sort_order');
    }

    public static function groupedForNav(int $limitPerCategory = 4): \Illuminate\Support\Collection
    {
        $categories = static::published()->get(['id', 'name', 'slug', 'sort_order']);

        if ($categories->isEmpty()) {
            return collect();
        }

        $postsByCategory = BlogPost::published()
            ->whereIn('blog_category_id', $categories->pluck('id'))
            ->get(['id', 'title', 'slug', 'blog_category_id'])
            ->groupBy('blog_category_id');

        return $categories
            ->filter(fn (self $category) => $postsByCategory->has($category->id))
            ->map(fn (self $category) => [
                'name' => $category->name,
                'slug' => $category->slug,
                'posts' => $postsByCategory->get($category->id)->take($limitPerCategory)->values(),
            ])
            ->values();
    }
}
