<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\DataCentre;
use App\Models\Service;
use App\Models\Solution;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'stats' => [
                'services' => Service::count(),
                'solutions' => Solution::count(),
                'data_centres' => DataCentre::count(),
                'contact_enquiries' => ContactSubmission::count(),
            ],
            'recentContacts' => ContactSubmission::latest()->take(5)->get(),
        ]);
    }
}
