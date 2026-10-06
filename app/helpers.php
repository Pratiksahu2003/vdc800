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

        return asset('favicon.ico');
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
