<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AboutSection extends Model
{
    protected $fillable = [
        'hero_heading', 'hero_description', 'hero_image', 'mission', 'vision', 'story',
        'sustainability', 'cta_heading', 'cta_description', 'cta_button_text',
        'cta_button_url', 'meta_title', 'meta_description', 'og_image',
    ];

    public function values(): HasMany
    {
        return $this->hasMany(AboutValue::class)->orderBy('sort_order');
    }

    public static function instance(): self
    {
        return static::firstOrCreate([]);
    }
}
