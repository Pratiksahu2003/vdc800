<?php

namespace App\Providers;

use App\Models\BlogCategory;
use App\Models\Service;
use App\Models\Solution;
use App\Services\SiteSettingsService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SiteSettingsService::class);
    }

    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('siteSettings', settings());
        });

        View::composer(['components.footer', 'layouts.app', 'components.navbar'], function ($view) {
            $view->with([
                'footerServices' => Service::where('status', 'published')
                    ->orderByDesc('updated_at')
                    ->limit(7)
                    ->get(['id', 'title', 'slug']),
                'footerSolutions' => Solution::where('status', 'published')
                    ->orderByDesc('updated_at')
                    ->limit(7)
                    ->get(['id', 'title', 'slug']),
                'sitemapServices' => Service::published()->get(['id', 'title', 'slug']),
                'sitemapSolutions' => Solution::published()->get(['id', 'title', 'slug']),
                'navServicesByCategory' => Service::groupedForNav(),
                'navSolutionsByCategory' => Solution::groupedForNav(),
                'navBlogByCategory' => BlogCategory::groupedForNav(),
            ]);
        });
    }
}
