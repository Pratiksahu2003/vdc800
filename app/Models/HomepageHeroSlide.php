<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageHeroSlide extends Model
{
    protected $fillable = [
        'category', 'title', 'description', 'image',
        'cta_text', 'cta_url', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function imageUrl(): string
    {
        if (str_starts_with($this->image, 'http') || str_starts_with($this->image, '/')) {
            return str_starts_with($this->image, '/') ? asset(ltrim($this->image, '/')) : $this->image;
        }

        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }

        return \Illuminate\Support\Facades\Storage::url($this->image);
    }
}
