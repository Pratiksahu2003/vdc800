<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = [
        'company_name', 'short_name', 'tagline', 'description', 'about_company',
        'email', 'phone', 'secondary_phone', 'address', 'city', 'state', 'country',
        'postal_code', 'map_link', 'map_embed_url', 'founded_year', 'vat_number', 'business_registration_number',
        'logo', 'logo_dark', 'logo_light', 'favicon', 'footer_logo',
    ];

    public static function instance(): self
    {
        return static::firstOrCreate([]);
    }
}
