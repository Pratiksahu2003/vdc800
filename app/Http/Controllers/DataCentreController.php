<?php

namespace App\Http\Controllers;

use App\Models\DataCentre;

class DataCentreController extends Controller
{
    public function index()
    {
        $dataCentres = DataCentre::published()->get();

        return view('data-centre.index', compact('dataCentres'));
    }

    public function show(DataCentre $dataCentre)
    {
        abort_unless($dataCentre->status === 'published', 404);

        return view('data-centre.show', [
            'dataCentre' => $dataCentre,
            'specifications' => $dataCentre->specifications()->where('is_active', true)->get(),
            'features' => $dataCentre->features()->where('is_active', true)->get(),
            'gallery' => $dataCentre->gallery()->where('is_active', true)->get(),
        ]);
    }
}
