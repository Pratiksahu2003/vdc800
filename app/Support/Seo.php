<?php

namespace App\Support;

use Illuminate\Support\Str;

class Seo
{
    public static function companyName(): string
    {
        return settings('company.company_name') ?? 'D³ DataCenters';
    }

    public static function title(?string $pageTitle): string
    {
        if (blank($pageTitle)) {
            return self::ensureTitleLength(
                settings('website.default_page_title') ?? self::companyName()
            );
        }

        if (str_contains($pageTitle, self::companyName()) || str_contains($pageTitle, '|')) {
            return self::ensureTitleLength($pageTitle);
        }

        return self::ensureTitleLength(rtrim($pageTitle).' — '.self::companyName());
    }

    public static function entityTitle(?string $storedMetaTitle, string $name, string $kind): string
    {
        if (filled($storedMetaTitle)) {
            return self::ensureTitleLength($storedMetaTitle);
        }

        $patterns = config('seo.entity_title_patterns', []);
        $pattern = $patterns[$kind] ?? '{name} | {company}';
        $title = str_replace(
            ['{name}', '{company}'],
            [trim($name), self::companyName()],
            $pattern
        );

        return self::ensureTitleLength($title);
    }

    public static function ensureTitleLength(string $title): string
    {
        $min = (int) config('seo.min_title_length', 60);
        $max = (int) config('seo.max_title_length', 70);

        $title = trim(preg_replace('/\s+/u', ' ', strip_tags($title)) ?? '');

        if ($title === '') {
            $title = self::companyName();
        }

        if (mb_strlen($title) >= $min) {
            return self::truncateTitle($title, $max);
        }

        foreach (config('seo.title_boosters', []) as $booster) {
            $separator = str_contains($title, '|') ? ' — ' : ' | ';
            $candidate = $title.$separator.$booster;
            if (mb_strlen($candidate) >= $min) {
                $title = $candidate;
                break;
            }
        }

        if (mb_strlen($title) < $min) {
            $title .= ' | Premium Nordic Data Centre Infrastructure';
        }

        return self::truncateTitle($title, $max);
    }

    protected static function truncateTitle(string $title, int $max): string
    {
        if (mb_strlen($title) <= $max) {
            return $title;
        }

        $trimmed = mb_substr($title, 0, $max);
        $lastSpace = mb_strrpos($trimmed, ' ');

        if ($lastSpace !== false && $lastSpace > (int) ($max * 0.55)) {
            $trimmed = mb_substr($trimmed, 0, $lastSpace);
        }

        return rtrim($trimmed, ' |—-');
    }

    public static function description(?string $text, ?string $fallback = null): string
    {
        $raw = filled($text) ? $text : ($fallback ?? settings('website.default_meta_description') ?? '');

        return Str::limit(trim(strip_tags((string) $raw)), 160, '…');
    }

    public static function keywords(?string $pageKeywords = null): string
    {
        $default = trim((string) (settings('website.default_keywords') ?? ''));

        if (blank($pageKeywords)) {
            return $default;
        }

        $pageKeywords = trim($pageKeywords);

        if ($default === '') {
            return $pageKeywords;
        }

        return $pageKeywords.', '.$default;
    }

    /**
     * @return array{title: string, description: string, keywords: string}
     */
    public static function forRoute(?string $routeName): array
    {
        $pages = config('seo.pages', []);
        $page = ($routeName && is_array($pages)) ? ($pages[$routeName] ?? []) : [];

        $configuredTitle = $page['title'] ?? null;
        if (filled($configuredTitle)) {
            $title = self::ensureTitleLength($configuredTitle);
        } else {
            $title = self::title(null);
        }

        return [
            'title' => $title,
            'description' => self::description(
                $page['description'] ?? null,
                settings('website.default_meta_description')
            ),
            'keywords' => self::keywords($page['keywords'] ?? null),
        ];
    }

    public static function entityKeywords(string $type, string $primaryLabel): string
    {
        $extras = config("seo.entity_keywords.{$type}", []);
        $parts = array_values(array_unique(array_filter([$primaryLabel, ...$extras])));

        return self::keywords(implode(', ', $parts));
    }

    public static function ogImage(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        if (str_starts_with($path, 'Logo/') || str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return setting_url($path);
    }
}
