<?php

namespace App\Http\Controllers;

use App\Models\DataCentre;

class DataCentreController extends Controller
{
    public function index()
    {
        $dataCentres = DataCentre::published()->get();

        $mapLocations = $dataCentres
            ->filter(fn (DataCentre $dataCentre) => filled($dataCentre->latitude) && filled($dataCentre->longitude))
            ->map(fn (DataCentre $dataCentre) => [
                'name' => $dataCentre->name,
                'location' => $dataCentre->location,
                'lat' => (float) $dataCentre->latitude,
                'lng' => (float) $dataCentre->longitude,
                'url' => route('data-centre.show', $dataCentre),
                'image' => hero_image_url($dataCentre->hero_image, 'images/hero-datacenter.jpg'),
            ])
            ->values();

        return view('data-centre.index', compact('dataCentres', 'mapLocations'));
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
