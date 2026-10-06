<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use App\Models\AboutValue;
use App\Traits\HandlesUploads;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    use HandlesUploads;

    public function edit()
    {
        return view('admin.content.about', [
            'about' => AboutSection::instance(),
            'values' => AboutValue::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'hero_heading' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'story' => 'nullable|string',
            'sustainability' => 'nullable|string',
            'cta_heading' => 'nullable|string|max:255',
            'cta_description' => 'nullable|string',
            'cta_button_text' => 'nullable|string|max:100',
            'cta_button_url' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'hero_image' => 'nullable|image|max:5120',
        ]);

        $about = AboutSection::instance();

        if ($request->hasFile('hero_image')) {
            $validated['hero_image'] = $this->uploadImage($request->file('hero_image'), 'about', $about->hero_image);
        } else {
            unset($validated['hero_image']);
        }

        $about->update($validated);

        return back()->with('success', 'About page updated successfully.');
    }

    public function storeValue(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        AboutValue::create($validated);

        return back()->with('success', 'Value added successfully.');
    }

    public function updateValue(Request $request, AboutValue $value)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $value->update($validated);

        return back()->with('success', 'Value updated successfully.');
    }

    public function destroyValue(AboutValue $value)
    {
        $value->delete();

        return back()->with('success', 'Value deleted successfully.');
    }
}
