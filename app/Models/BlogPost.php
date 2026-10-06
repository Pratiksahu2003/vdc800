<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    protected $fillable = [
        'blog_category_id', 'title', 'slug', 'excerpt', 'body', 'featured_image',
        'author', 'meta_title', 'meta_description', 'og_image',
        'published_at', 'sort_order', 'status',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (BlogPost $post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function scopePublished($query)
    {
        return $query
            ->where('status', 'published')
            ->where(function ($q) {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            })
            ->orderByDesc('published_at')
            ->orderBy('sort_order');
    }

    public function imageUrl(): string
    {
        if (! $this->featured_image) {
            return asset('images/hero-datacenter.jpg');
        }

        if (str_starts_with($this->featured_image, 'images/')) {
            return asset($this->featured_image);
        }

        return Storage::url($this->featured_image);
    }
}
