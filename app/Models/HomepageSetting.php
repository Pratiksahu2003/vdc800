<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSetting extends Model
{
    protected $fillable = [
        'hero_heading', 'hero_subtitle', 'hero_description', 'hero_background_image',
        'hero_cta_text', 'hero_cta_url', 'hero_secondary_cta_text', 'hero_secondary_cta_url',
        'intro_heading', 'intro_description', 'intro_image',
        'sustainability_heading', 'sustainability_description', 'sustainability_image',
        'sustainability_cta_text', 'sustainability_cta_url',
        'infrastructure_heading', 'infrastructure_description', 'infrastructure_image',
        'final_cta_heading', 'final_cta_description', 'final_cta_button_text', 'final_cta_button_url',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate([]);
    }
}
