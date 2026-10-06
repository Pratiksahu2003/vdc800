<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use App\Services\SiteSettingsService;
use App\Traits\HandlesUploads;
use Illuminate\Http\Request;

class BrandingController extends Controller
{
    use HandlesUploads;

    public function edit()
    {
        return view('admin.settings.branding', [
            'company' => CompanySetting::instance(),
        ]);
    }

    public function update(Request $request, SiteSettingsService $settings)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'logo_dark' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'logo_light' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg,ico|max:2048',
            'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:5120',
        ]);

        $company = CompanySetting::instance();
        $data = [];

        foreach (['logo', 'logo_dark', 'logo_light', 'favicon', 'footer_logo'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $this->uploadImage($request->file($field), 'branding', $company->$field);
            } elseif ($request->boolean('remove_'.$field)) {
                $this->deleteImage($company->$field);
                $data[$field] = null;
            }
        }

        $company->update($data);
        $settings->clearCache();

        return back()->with('success', 'Branding updated successfully.');
    }
}
