<?php

namespace App\Http\Controllers;

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
}
