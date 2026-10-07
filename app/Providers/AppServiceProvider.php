<?php

namespace App\Providers;

use App\Models\Service;
use App\Models\Solution;
use App\Services\MailConfigService;
use App\Services\NavMenuService;
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
            $navMenu = app(NavMenuService::class);
            $view->with([
                'navMainItems' => $navMenu->mainItems(),
                'navUtilityItems' => $navMenu->utilityItems(),
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
            ]);
        });
    }
}
