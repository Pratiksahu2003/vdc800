<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use App\Services\SiteSettingsService;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        return view('admin.settings.social-links', [
            'links' => SocialLink::orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request, SiteSettingsService $settings)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:50',
            'url' => 'required|url|max:255',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        SocialLink::create($validated);
        $settings->clearCache();

        return back()->with('success', 'Social link added successfully.');
    }

    public function update(Request $request, SocialLink $socialLink, SiteSettingsService $settings)
    {
        $validated = $request->validate([
            'platform' => 'required|string|max:50',
            'url' => 'required|url|max:255',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $socialLink->update($validated);
        $settings->clearCache();

        return back()->with('success', 'Social link updated successfully.');
    }

    public function destroy(SocialLink $socialLink, SiteSettingsService $settings)
    {
        $socialLink->delete();
        $settings->clearCache();

        return back()->with('success', 'Social link deleted successfully.');
    }

    public function toggle(SocialLink $socialLink, SiteSettingsService $settings)
    {
        $socialLink->update(['is_active' => ! $socialLink->is_active]);
        $settings->clearCache();

        return back()->with('success', 'Social link status updated.');
    }
}
