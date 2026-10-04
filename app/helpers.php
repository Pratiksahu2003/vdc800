<?php

use App\Services\SiteSettingsService;

if (! function_exists('settings')) {
    function settings(?string $key = null, mixed $default = null): mixed
    {
        $service = app(SiteSettingsService::class);

        if ($key === null) {
            return $service->all();
        }

        return $service->get($key, $default);
    }
}

if (! function_exists('setting_url')) {
    function setting_url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        return \Illuminate\Support\Facades\Storage::url($path);
    }
}

if (! function_exists('logo_url')) {
    function logo_url(?string $variant = 'default'): ?string
    {
        $paths = [
            'default' => settings('branding.logo'),
            'dark' => settings('branding.logo_dark'),
            'light' => settings('branding.logo_light'),
            'footer' => settings('branding.footer_logo') ?? settings('branding.logo'),
        ];

        $path = $paths[$variant] ?? $paths['default'];

        if ($path) {
            if (str_starts_with($path, 'Logo/') || str_starts_with($path, 'images/')) {
                return asset($path);
            }

            return setting_url($path);
        }

        return asset('Logo/logo.png');
    }
}

if (! function_exists('favicon_url')) {
    function favicon_url(): string
    {
        $favicon = settings('branding.favicon');

        if (filled($favicon)) {
            if (str_starts_with($favicon, 'http')) {
                return $favicon;
            }

            if (str_starts_with($favicon, 'Logo/') || str_starts_with($favicon, 'images/')) {
                return asset($favicon);
            }

            $storageUrl = setting_url($favicon);
            if ($storageUrl) {
                return $storageUrl;
            }
        }

        return asset('Logo/favicon.png');
    }
}

if (! function_exists('favicon_type')) {
    function favicon_type(): string
    {
        $path = strtolower(parse_url(favicon_url(), PHP_URL_PATH) ?? '');

        return str_ends_with($path, '.ico') ? 'image/x-icon' : 'image/png';
    }
}

if (! function_exists('hero_image_url')) {
    function hero_image_url(?string $path, string $fallback = 'images/hero-datacenter.jpg'): string
    {
        if (blank($path)) {
            return asset($fallback);
        }

        if (str_starts_with($path, 'images/') || str_starts_with($path, 'http')) {
            return str_starts_with($path, 'http') ? $path : asset($path);
        }

        return \Illuminate\Support\Facades\Storage::url($path);
    }
}

if (! function_exists('rich_content')) {
    /**
     * Render CMS text: supports stored HTML or plain text with line breaks.
     */
    function rich_content(?string $content): string
    {
        if (blank($content)) {
            return '';
        }

        $content = trim($content);

        if (preg_match('/<[^>]+>/', $content)) {
            $content = strip_tags($content, '<p><br><strong><b><em><i><ul><ol><li><a><h2><h3><h4><blockquote><span><table><caption><thead><tbody><tr><th><td>');

            // Wrap tables so wide CMS content scrolls horizontally on small screens.
            if (stripos($content, '<table') !== false) {
                $content = preg_replace('/<table\b/i', '<div class="cms-table-wrap"><table', $content);
                $content = preg_replace('/<\/table>/i', '</table></div>', $content);
            }

            return $content;
        }

        return nl2br(e($content));
    }
}

if (! function_exists('company_map_link')) {
    function company_map_link(): ?string
    {
        return app(\App\Services\MapUrlResolver::class)->resolveMapLink(settings('company.map_link'));
    }
}

if (! function_exists('company_map_embed_url')) {
    function company_map_embed_url(): ?string
    {
        return app(\App\Services\MapUrlResolver::class)->resolveEmbedUrl(settings('company.map_link'));
    }
}

if (! function_exists('data_centre_map_link')) {
    function data_centre_map_link(\App\Models\DataCentre $dataCentre): ?string
    {
        if (! $dataCentre->show_map) {
            return null;
        }

        $resolver = app(\App\Services\MapUrlResolver::class);

        if (filled($dataCentre->map_link)) {
            return $resolver->resolveMapLink($dataCentre->map_link);
        }

        if (filled($dataCentre->latitude) && filled($dataCentre->longitude)) {
            return 'https://www.google.com/maps/search/?api=1&query='.urlencode($dataCentre->latitude.','.$dataCentre->longitude);
        }

        $parts = array_values(array_filter([
            $dataCentre->address,
            $dataCentre->location,
            $dataCentre->country,
        ]));

        return $parts === [] ? null : $resolver->resolveMapLink(null, $parts);
    }
}

if (! function_exists('seo_title')) {
    function seo_title(?string $pageTitle): string
    {
        return \App\Support\Seo::title($pageTitle);
    }
}

if (! function_exists('seo_entity_title')) {
    function seo_entity_title(?string $storedMetaTitle, string $name, string $kind): string
    {
        return \App\Support\Seo::entityTitle($storedMetaTitle, $name, $kind);
    }
}

if (! function_exists('seo_description')) {
    function seo_description(?string $text, ?string $fallback = null): string
    {
        return \App\Support\Seo::description($text, $fallback);
    }
}

if (! function_exists('seo_keywords')) {
    function seo_keywords(?string $pageKeywords = null): string
    {
        return \App\Support\Seo::keywords($pageKeywords);
    }
}

if (! function_exists('seo_for_route')) {
    /** @return array{title: string, description: string, keywords: string} */
    function seo_for_route(?string $routeName = null): array
    {
        return \App\Support\Seo::forRoute($routeName ?? optional(request()->route())->getName());
    }
}

if (! function_exists('seo_entity_keywords')) {
    function seo_entity_keywords(string $type, string $primaryLabel): string
    {
        return \App\Support\Seo::entityKeywords($type, $primaryLabel);
    }
}

if (! function_exists('data_centre_map_embed_url')) {
    function data_centre_map_embed_url(\App\Models\DataCentre $dataCentre): ?string
    {
        if (! $dataCentre->show_map) {
            return null;
        }

        $resolver = app(\App\Services\MapUrlResolver::class);

        if (filled($dataCentre->latitude) && filled($dataCentre->longitude)) {
            return $resolver->resolveEmbedFromCoordinates($dataCentre->latitude, $dataCentre->longitude);
        }

        $parts = array_values(array_filter([
            $dataCentre->address,
            $dataCentre->location,
            $dataCentre->country,
        ]));

        return $resolver->resolveEmbedUrl($dataCentre->map_link, $parts ?: null);
    }
}
