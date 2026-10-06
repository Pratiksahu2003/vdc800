<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DataCentre;
use App\Models\DataCentreFeature;
use App\Models\DataCentreGallery;
use App\Models\DataCentreSpecification;
use App\Traits\HandlesUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DataCentreController extends Controller
{
    use HandlesUploads;

    public function index(Request $request)
    {
        $query = DataCentre::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%")
                    ->orWhere('country', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        return view('admin.data-centres.index', [
            'dataCentres' => $query->orderBy('sort_order')->paginate(15)->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('admin.data-centres.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'short_description' => 'nullable|string',
            'sort_order' => 'integer|min:0',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
        ]);

        $validated['slug'] = DataCentre::uniqueSlug(Str::slug($validated['name']));
        $validated['is_featured'] = $request->boolean('is_featured');

        $dataCentre = DataCentre::create($validated);

        return redirect()
            ->route('admin.data-centres.edit', $dataCentre)
            ->with('success', 'Data centre created. Add specifications, features, and gallery images below.');
    }

    public function edit(DataCentre $dataCentre)
    {
        return view('admin.data-centres.edit', [
            'dataCentre' => $dataCentre,
            'specifications' => $dataCentre->specifications()->get(),
            'features' => $dataCentre->features()->get(),
        ]);
    }

    public function update(Request $request, DataCentre $dataCentre)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:data_centres,slug,'.$dataCentre->id,
            'location' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'short_description' => 'nullable|string',
            'full_description' => 'nullable|string',
            'hero_video_url' => 'nullable|url|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'cta_heading' => 'nullable|string|max:255',
            'cta_description' => 'nullable|string',
            'cta_button_text' => 'nullable|string|max:100',
            'cta_button_url' => 'nullable|string|max:255',
            'sort_order' => 'integer|min:0',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'hero_image' => 'nullable|image|max:5120',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');

        if (filled($validated['slug'] ?? null)) {
            $validated['slug'] = Str::slug($validated['slug']);
        } elseif (filled($validated['name'] ?? null)) {
            $validated['slug'] = DataCentre::uniqueSlug(Str::slug($validated['name']), $dataCentre->id);
        }

        if ($request->hasFile('hero_image')) {
            $validated['hero_image'] = $this->uploadImage($request->file('hero_image'), 'data-centre', $dataCentre->hero_image);
        } else {
            unset($validated['hero_image']);
        }

        $dataCentre->update($validated);

        return back()->with('success', 'Data centre updated successfully.');
    }

    public function destroy(DataCentre $dataCentre)
    {
        $this->deleteImage($dataCentre->hero_image);

        foreach ($dataCentre->features as $feature) {
            $this->deleteImage($feature->image);
        }

        foreach ($dataCentre->gallery as $item) {
            $this->deleteImage($item->image);
        }

        $dataCentre->delete();

        return redirect()
            ->route('admin.data-centres.index')
            ->with('success', 'Data centre deleted successfully.');
    }

    public function toggleStatus(DataCentre $dataCentre)
    {
        $dataCentre->update([
            'status' => $dataCentre->status === 'published' ? 'draft' : 'published',
        ]);

        return back()->with('success', 'Data centre status updated.');
    }

    public function storeSpecification(Request $request, DataCentre $dataCentre)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:100',
            'unit' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['data_centre_id'] = $dataCentre->id;
        DataCentreSpecification::create($validated);

        return back()->with('success', 'Specification added successfully.');
    }

    public function updateSpecification(Request $request, DataCentre $dataCentre, DataCentreSpecification $specification)
    {
        abort_unless($specification->data_centre_id === $dataCentre->id, 404);

        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'value' => 'required|string|max:100',
            'unit' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
        ]);

        $specification->update($validated);

        return back()->with('success', 'Specification updated successfully.');
    }

    public function destroySpecification(DataCentre $dataCentre, DataCentreSpecification $specification)
    {
        abort_unless($specification->data_centre_id === $dataCentre->id, 404);
        $specification->delete();

        return back()->with('success', 'Specification deleted successfully.');
    }

    public function storeFeature(Request $request, DataCentre $dataCentre)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:5120',
        ]);

        $validated['data_centre_id'] = $dataCentre->id;
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'data-centre/features');
        }

        DataCentreFeature::create($validated);

        return back()->with('success', 'Feature added successfully.');
    }

    public function updateFeature(Request $request, DataCentre $dataCentre, DataCentreFeature $feature)
    {
        abort_unless($feature->data_centre_id === $dataCentre->id, 404);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean',
            'image' => 'nullable|image|max:5120',
        ]);

        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'), 'data-centre/features', $feature->image);
        } else {
            unset($validated['image']);
        }

        $feature->update($validated);

        return back()->with('success', 'Feature updated successfully.');
    }

    public function destroyFeature(DataCentre $dataCentre, DataCentreFeature $feature)
    {
        abort_unless($feature->data_centre_id === $dataCentre->id, 404);
        $this->deleteImage($feature->image);
        $feature->delete();

        return back()->with('success', 'Feature deleted successfully.');
    }

    public function gallery(DataCentre $dataCentre)
    {
        return view('admin.data-centres.gallery', [
            'dataCentre' => $dataCentre,
            'gallery' => $dataCentre->gallery()->orderBy('sort_order')->get(),
        ]);
    }

    public function storeGallery(Request $request, DataCentre $dataCentre)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
            'caption' => 'nullable|string|max:255',
            'alt_text' => 'nullable|string|max:255',
            'sort_order' => 'integer|min:0',
        ]);

        $path = $this->uploadImage($request->file('image'), 'data-centre/gallery');

        DataCentreGallery::create([
            'data_centre_id' => $dataCentre->id,
            'image' => $path,
            'caption' => $request->caption,
            'alt_text' => $request->alt_text,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => true,
        ]);

        return back()->with('success', 'Gallery image uploaded successfully.');
    }

    public function destroyGallery(DataCentre $dataCentre, DataCentreGallery $gallery)
    {
        abort_unless($gallery->data_centre_id === $dataCentre->id, 404);
        $this->deleteImage($gallery->image);
        $gallery->delete();

        return back()->with('success', 'Gallery image deleted successfully.');
    }

    public function toggleGallery(DataCentre $dataCentre, DataCentreGallery $gallery)
    {
        abort_unless($gallery->data_centre_id === $dataCentre->id, 404);
        $gallery->update(['is_active' => ! $gallery->is_active]);

        return back()->with('success', 'Gallery image status updated.');
    }
}
