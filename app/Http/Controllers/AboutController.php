<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\AboutValue;
use App\Models\DataCentre;
use App\Models\HomepageStatistic;

class AboutController extends Controller
{
    public function index()
    {
        return view('about.index', [
            'about' => AboutSection::instance(),
            'values' => AboutValue::where('is_active', true)->orderBy('sort_order')->get(),
            'statistics' => HomepageStatistic::query()->where('is_active', true)->orderBy('sort_order')->get(),
            'facilities' => DataCentre::published()->limit(6)->get(),
        ]);
    }
}
