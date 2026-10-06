<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use App\Services\MapUrlResolver;
use App\Services\SiteSettingsService;
use Illuminate\Http\Request;

class CompanySettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings.company', [
            'company' => CompanySetting::instance(),
        ]);
    }

    public function update(Request $request, SiteSettingsService $settings, MapUrlResolver $mapUrlResolver)
    {
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'short_name' => 'nullable|string|max:100',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'about_company' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'secondary_phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'map_link' => 'nullable|string|max:2000',
            'founded_year' => 'nullable|string|max:10',
            'vat_number' => 'nullable|string|max:50',
            'business_registration_number' => 'nullable|string|max:50',
        ]);

        $normalizedMapLink = $mapUrlResolver->normalizeInput($validated['map_link'] ?? null);

        if (filled($validated['map_link'] ?? null) && blank($normalizedMapLink)) {
            return back()
                ->withInput()
                ->withErrors(['map_link' => 'Please enter a valid Google Maps link.']);
        }

        $validated['map_link'] = $normalizedMapLink;
        $validated['map_embed_url'] = null;

        CompanySetting::instance()->update($validated);
        $settings->clearCache();

        return back()->with('success', 'Company information updated successfully.');
    }
}
