<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageBenefit;
use App\Models\HomepageSetting;
use App\Models\HomepageStatistic;
use App\Traits\HandlesUploads;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    use HandlesUploads;

    public function edit()
    {
        return view('admin.content.homepage', [
            'homepage' => HomepageSetting::instance(),
            'benefits' => HomepageBenefit::orderBy('sort_order')->get(),
            'statistics' => HomepageStatistic::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_heading' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_cta_text' => 'nullable|string|max:100',
            'hero_cta_url' => 'nullable|string|max:255',
            'hero_secondary_cta_text' => 'nullable|string|max:100',
            'hero_secondary_cta_url' => 'nullable|string|max:255',
            'intro_heading' => 'nullable|string|max:255',
            'intro_description' => 'nullable|string',
            'sustainability_heading' => 'nullable|string|max:255',
            'sustainability_description' => 'nullable|string',
            'sustainability_cta_text' => 'nullable|string|max:100',
            'sustainability_cta_url' => 'nullable|string|max:255',
            'infrastructure_heading' => 'nullable|string|max:255',
            'infrastructure_description' => 'nullable|string',
            'final_cta_heading' => 'nullable|string|max:255',
            'final_cta_description' => 'nullable|string',
            'final_cta_button_text' => 'nullable|string|max:100',
            'final_cta_button_url' => 'nullable|string|max:255',
            'hero_background_image' => 'nullable|image|max:5120',
            'intro_image' => 'nullable|image|max:5120',
            'sustainability_image' => 'nullable|image|max:5120',
            'infrastructure_image' => 'nullable|image|max:5120',
        ]);

        $homepage = HomepageSetting::instance();
        $imageFields = ['hero_background_image', 'intro_image', 'sustainability_image', 'infrastructure_image'];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $this->uploadImage($request->file($field), 'homepage', $homepage->$field);
            } else {
                unset($validated[$field]);
            }
        }

        $homepage->update($validated);

        return back()->with('success', 'Homepage content updated successfully.');
    }

    public function storeBenefit(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        HomepageBenefit::create($validated);

        return back()->with('success', 'Benefit added successfully.');
    }

    public function updateBenefit(Request $request, HomepageBenefit $benefit)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $benefit->update($validated);

        return back()->with('success', 'Benefit updated successfully.');
    }

    public function destroyBenefit(HomepageBenefit $benefit)
    {
        $benefit->delete();

        return back()->with('success', 'Benefit deleted successfully.');
    }

    public function storeStatistic(Request $request)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:50',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        HomepageStatistic::create($validated);

        return back()->with('success', 'Statistic added successfully.');
    }

    public function updateStatistic(Request $request, HomepageStatistic $statistic)
    {
        $validated = $request->validate([
            'number' => 'required|string|max:50',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $statistic->update($validated);

        return back()->with('success', 'Statistic updated successfully.');
    }

    public function destroyStatistic(HomepageStatistic $statistic)
    {
        $statistic->delete();

        return back()->with('success', 'Statistic deleted successfully.');
    }
}
