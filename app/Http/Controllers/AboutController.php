<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\AboutValue;

class AboutController extends Controller
{
    public function index()
    {
        return view('about.index', [
            'about' => AboutSection::instance(),
            'values' => AboutValue::where('is_active', true)->orderBy('sort_order')->get(),
        ]);
    }
}
