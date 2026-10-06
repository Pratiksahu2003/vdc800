<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        return view('services.index', [
            'services' => Service::published()->get(),
        ]);
    }

    public function show(Service $service)
    {
        abort_unless($service->status === 'published', 404);

        return view('services.show', compact('service'));
    }
}
