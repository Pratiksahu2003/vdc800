<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Services\SiteSettingsService;
use App\Traits\HandlesUploads;
use Illuminate\Http\Request;

class WebsiteSettingController extends Controller
{
    use HandlesUploads;

    public function edit()
    {
        return view('admin.settings.website', [
            'website' => SiteSetting::instance(),
        ]);
    }

    public function update(Request $request, SiteSettingsService $settings)
    {
        $validated = $request->validate([
            'website_name' => 'nullable|string|max:255',
            'website_url' => 'nullable|url|max:255',
            'default_page_title' => 'nullable|string|max:255',
            'default_meta_description' => 'nullable|string|max:500',
            'default_keywords' => 'nullable|string|max:500',
            'google_analytics_id' => 'nullable|string|max:50',
            'google_tag_manager_id' => 'nullable|string|max:50',
            'timezone' => 'nullable|string|max:50',
            'default_language' => 'nullable|string|max:10',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $site = SiteSetting::instance();

        if ($request->hasFile('og_image')) {
            $validated['og_image'] = $this->uploadImage($request->file('og_image'), 'seo', $site->og_image);
        } elseif ($request->boolean('remove_og_image')) {
            $this->deleteImage($site->og_image);
            $validated['og_image'] = null;
        } else {
            unset($validated['og_image']);
        }

        $site->update($validated);
        $settings->clearCache();

        return back()->with('success', 'Website settings updated successfully.');
    }
}
