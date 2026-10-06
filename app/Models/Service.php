<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = [
        'title', 'slug', 'category', 'short_description', 'full_description', 'items', 'featured_image',
        'icon', 'cta_text', 'cta_url', 'meta_title', 'meta_description', 'og_image',
        'sort_order', 'status',
    ];

    protected $casts = [
        'items' => 'array',
    ];

    public const CATEGORIES = [
        'Advisory Services',
    ];

    protected static function booted(): void
    {
        static::creating(function (Service $service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->orderBy('sort_order');
    }

    public static function groupedForNav()
    {
        return static::published()
            ->get(['id', 'title', 'slug', 'category', 'sort_order'])
            ->groupBy(fn (self $service) => $service->category ?: 'Other Services')
            ->sortKeys();
    }
}
