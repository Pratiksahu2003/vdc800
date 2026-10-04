<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Solution extends Model
{
    protected $fillable = [
        'title', 'slug', 'short_description', 'description', 'featured_image',
        'icon', 'benefits', 'cta_text', 'cta_url', 'meta_title', 'meta_description',
        'og_image', 'sort_order', 'status',
    ];

    protected function casts(): array
    {
        return ['benefits' => 'array'];
    }

    protected static function booted(): void
    {
        static::creating(function (Solution $solution) {
            if (empty($solution->slug)) {
                $solution->slug = Str::slug($solution->title);
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')->orderBy('sort_order');
    }
}
