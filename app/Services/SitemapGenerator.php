<?php

namespace App\Services;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\DataCentre;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Solution;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

class SitemapGenerator
{
    /** @return array<int, array{loc: string, lastmod: ?string, changefreq: string, priority: string}> */
    public function urls(): array
    {
        $base = $this->baseUrl();
        \Illuminate\Support\Facades\URL::forceRootUrl($base);

        $scheme = parse_url($base, PHP_URL_SCHEME) ?: 'https';
        \Illuminate\Support\Facades\URL::forceScheme($scheme);

        $urls = [];

        $this->add($urls, route('home'), now(), 'daily', '1.0');
        $this->add($urls, route('services.index'), now(), 'weekly', '0.9');
        $this->add($urls, route('solutions.index'), now(), 'weekly', '0.9');
        $this->add($urls, route('data-centre.index'), now(), 'weekly', '0.9');
        $this->add($urls, route('about.index'), now(), 'monthly', '0.8');
        $this->add($urls, route('blog.index'), now(), 'daily', '0.8');
        $this->add($urls, route('contact.index'), now(), 'monthly', '0.7');
        $this->add($urls, route('legal.privacy'), now(), 'yearly', '0.3');
        $this->add($urls, route('legal.terms'), now(), 'yearly', '0.3');
        $this->add($urls, route('legal.cookies'), now(), 'yearly', '0.3');
        $this->add($urls, route('legal.sitemap'), now(), 'monthly', '0.5');

        Service::published()->get(['slug', 'updated_at'])->each(function (Service $service) use (&$urls) {
            $this->add($urls, route('services.show', $service), $service->updated_at, 'weekly', '0.8');
        });

        Solution::published()->get(['slug', 'updated_at'])->each(function (Solution $solution) use (&$urls) {
            $this->add($urls, route('solutions.show', $solution), $solution->updated_at, 'weekly', '0.8');
        });

        DataCentre::published()->get(['slug', 'updated_at'])->each(function (DataCentre $dataCentre) use (&$urls) {
            $this->add($urls, route('data-centre.show', $dataCentre), $dataCentre->updated_at, 'weekly', '0.8');
        });

        BlogCategory::published()
            ->whereHas('posts', fn ($q) => $q->published())
            ->get(['slug', 'updated_at'])
            ->each(function (BlogCategory $category) use (&$urls) {
                $this->add(
                    $urls,
                    route('blog.index', ['category' => $category->slug]),
                    $category->updated_at,
                    'weekly',
                    '0.6'
                );
            });

        BlogPost::published()->get(['slug', 'updated_at', 'published_at'])->each(function (BlogPost $post) use (&$urls) {
            $lastmod = $post->updated_at ?? $post->published_at;
            $this->add($urls, route('blog.show', $post), $lastmod, 'monthly', '0.7');
        });

        return $this->deduplicate($urls);
    }

    public function toXml(): string
    {
        $urls = $this->urls();

        $lines = [
            '<?xml version="1.0" encoding="UTF-8"?>',
            '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">',
        ];

        foreach ($urls as $entry) {
            $lines[] = '  <url>';
            $lines[] = '    <loc>'.htmlspecialchars($entry['loc'], ENT_XML1 | ENT_QUOTES, 'UTF-8').'</loc>';

            if ($entry['lastmod']) {
                $lines[] = '    <lastmod>'.$entry['lastmod'].'</lastmod>';
            }

            $lines[] = '    <changefreq>'.$entry['changefreq'].'</changefreq>';
            $lines[] = '    <priority>'.$entry['priority'].'</priority>';
            $lines[] = '  </url>';
        }

        $lines[] = '</urlset>';

        return implode(PHP_EOL, $lines).PHP_EOL;
    }

    public function robotsTxt(): string
    {
        $baseUrl = $this->baseUrl();
        $sitemapUrl = $baseUrl.'/sitemap.xml';

        return implode(PHP_EOL, [
            '# VDC800 — robots.txt',
            '# Generated for search engine crawlers. Regenerate with: php artisan sitemap:generate',
            '',
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            'Disallow: /admin/',
            'Disallow: /storage/',
            'Disallow: /vendor/',
            'Disallow: /build/',
            '',
            'User-agent: Googlebot',
            'Allow: /',
            'Disallow: /admin',
            '',
            'User-agent: Bingbot',
            'Allow: /',
            'Disallow: /admin',
            '',
            'User-agent: GPTBot',
            'Disallow: /',
            '',
            'User-agent: CCBot',
            'Disallow: /',
            '',
            'Sitemap: '.$sitemapUrl,
            '',
        ]);
    }

    public function baseUrl(): string
    {
        $fromSettings = SiteSetting::query()->value('website_url');
        $fromConfig = config('app.url');

        $url = $fromSettings;

        if (blank($url) || $url === 'http://localhost') {
            $url = $fromConfig ?: 'http://localhost';
        }

        return rtrim((string) $url, '/');
    }

    /**
     * @param  array<int, array{loc: string, lastmod: ?string, changefreq: string, priority: string}>  $urls
     */
    private function add(array &$urls, string $loc, mixed $lastmod, string $changefreq, string $priority): void
    {
        $urls[] = [
            'loc' => $this->absoluteUrl($loc),
            'lastmod' => $this->formatLastmod($lastmod),
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    }

    private function absoluteUrl(string $url): string
    {
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        return $this->baseUrl().'/'.ltrim($url, '/');
    }

    private function formatLastmod(mixed $date): ?string
    {
        if ($date instanceof CarbonInterface) {
            return $date->toAtomString();
        }

        return null;
    }

    /**
     * @param  array<int, array{loc: string, lastmod: ?string, changefreq: string, priority: string}>  $urls
     * @return array<int, array{loc: string, lastmod: ?string, changefreq: string, priority: string}>
     */
    private function deduplicate(array $urls): array
    {
        return Collection::make($urls)
            ->unique('loc')
            ->values()
            ->all();
    }
}
