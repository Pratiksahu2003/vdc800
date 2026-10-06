<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'website_name', 'website_url', 'default_page_title', 'default_meta_description',
        'default_keywords', 'google_analytics_id', 'google_tag_manager_id',
        'timezone', 'default_language', 'og_image',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate([]);
    }
}
