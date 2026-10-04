<?php

namespace App\Providers;

use App\Models\NavMenuItem;
use App\Models\Service;
use App\Models\Solution;
use App\Services\MailConfigService;
use App\Services\SiteSettingsService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        RateLimiter::for('contact', function (Request $request) {
            $perMinute = max(1, (int) config('contact.rate_limit.per_minute', 5));

            return Limit::perMinute($perMinute)->by($request->ip());
        });

        MailConfigService::applyFromDatabase();

        View::composer('*', function ($view) {
            $view->with('siteSettings', settings());
        });

        View::composer(['components.navbar'], function ($view) {
            $view->with([
                'navMainItems' => NavMenuItem::treeForZone('main'),
                'navUtilityItems' => NavMenuItem::treeForZone('utility')
                    ->reject(fn ($item) => $item->slug === 'login' || $item->route_name === 'admin.login')
                    ->values(),
            ]);
        });

        View::composer(['components.footer', 'layouts.app'], function ($view) {
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
            ]);
        });
    }
}
