<?php

namespace App\Services;

use App\Models\CompanySetting;
use App\Models\SiteSetting;
use App\Models\SocialLink;
use Illuminate\Support\Facades\Cache;

class SiteSettingsService
{
    public function get(string $key, mixed $default = null): mixed
    {
        $all = $this->all();

        return data_get($all, $key, $default);
    }

    public function all(): array
    {
        return Cache::remember('site_settings_all', 3600, function () {
            $company = CompanySetting::instance();
            $website = SiteSetting::instance();
            $social = SocialLink::active()->get();

            return [
                'company' => $company->toArray(),
                'branding' => [
                    'logo' => $company->logo,
                    'logo_dark' => $company->logo_dark,
                    'logo_light' => $company->logo_light,
                    'favicon' => $company->favicon,
                    'footer_logo' => $company->footer_logo,
                ],
                'website' => $website->toArray(),
                'social' => $social->keyBy('platform')->toArray(),
                'social_links' => $social->toArray(),
            ];
        });
    }

    public function clearCache(): void
    {
        Cache::forget('site_settings_all');
    }
}
