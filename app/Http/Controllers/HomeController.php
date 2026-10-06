<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\HomepageBenefit;
use App\Models\HomepageHeroSlide;
use App\Models\HomepageSetting;
use App\Models\HomepageStatistic;
use App\Models\HomepageTestimonial;
use App\Models\Service;
use App\Models\Solution;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'homepage' => HomepageSetting::instance(),
            'heroSlides' => HomepageHeroSlide::where('is_active', true)->orderBy('sort_order')->get(),
            'benefits' => HomepageBenefit::where('is_active', true)->orderBy('sort_order')->get(),
            'statistics' => HomepageStatistic::where('is_active', true)->orderBy('sort_order')->get(),
            'testimonials' => HomepageTestimonial::active()->get(),
            'services' => Service::published()->take(3)->get(),
            'solutions' => Solution::published()->take(3)->get(),
            'latestPosts' => BlogPost::published()
                ->with('category')
                ->take(6)
                ->get(),
        ]);
    }
}
