<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\DataCentre;
use App\Models\Service;
use App\Models\Solution;

class LegalController extends Controller
{
    public function privacy()
    {
        return view('legal.privacy', [
            'lastUpdated' => 'September 8, 2026',
        ]);
    }

    public function terms()
    {
        return view('legal.terms', [
            'lastUpdated' => 'September 8, 2026',
        ]);
    }

    public function cookies()
    {
        return view('legal.cookies', [
            'lastUpdated' => 'September 8, 2026',
        ]);
    }

    public function sitemap()
    {
        return view('legal.sitemap', [
            'services' => Service::published()->orderBy('title')->get(['title', 'slug']),
            'solutions' => Solution::published()->orderBy('title')->get(['title', 'slug']),
            'dataCentres' => DataCentre::published()->orderBy('name')->get(['name', 'slug']),
            'blogCategories' => BlogCategory::published()
                ->whereHas('posts', fn ($q) => $q->published())
                ->orderBy('name')
                ->get(['name', 'slug']),
            'blogPosts' => BlogPost::published()->latest('published_at')->get(['title', 'slug']),
        ]);
    }
}
