<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'website_name', 'website_url', 'default_page_title', 'default_meta_description',
        'default_keywords', 'google_analytics_id', 'google_tag_manager_id',
        'timezone', 'default_language', 'og_image',
        'mail_mailer', 'mail_host', 'mail_port', 'mail_username', 'mail_password',
        'mail_encryption', 'mail_from_address', 'mail_from_name', 'mail_ehlo_domain',
    ];

    protected function casts(): array
    {
        return [
            'mail_password' => 'encrypted',
            'mail_port' => 'integer',
        ];
    }

    public static function instance(): self
    {
        return static::firstOrCreate([]);
    }
}
