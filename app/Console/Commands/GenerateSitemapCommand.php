<?php

namespace App\Console\Commands;

use App\Services\SitemapGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class GenerateSitemapCommand extends Command
{
    protected $signature = 'sitemap:generate
                            {--robots-only : Only regenerate robots.txt}
                            {--sitemap-only : Only regenerate sitemap.xml}';

    protected $description = 'Generate public/sitemap.xml and SEO-friendly public/robots.txt';

    public function handle(SitemapGenerator $generator): int
    {
        $robotsOnly = (bool) $this->option('robots-only');
        $sitemapOnly = (bool) $this->option('sitemap-only');

        if ($robotsOnly && $sitemapOnly) {
            $this->error('Use only one of --robots-only or --sitemap-only.');

            return self::FAILURE;
        }

        $baseUrl = $generator->baseUrl();
        $this->info('Using site URL: '.$baseUrl);

        if (! $robotsOnly) {
            $sitemapPath = public_path('sitemap.xml');
            $xml = $generator->toXml();
            File::put($sitemapPath, $xml);

            $urlCount = substr_count($xml, '<url>');
            $this->components->info("Wrote sitemap.xml ({$urlCount} URLs) → {$sitemapPath}");
        }

        if (! $sitemapOnly) {
            $robotsPath = public_path('robots.txt');
            File::put($robotsPath, $generator->robotsTxt());
            $this->components->info("Wrote robots.txt → {$robotsPath}");
        }

        $this->newLine();
        $this->line('Submit your sitemap in Google Search Console:');
        $this->line('  '.$baseUrl.'/sitemap.xml');

        return self::SUCCESS;
    }
}
