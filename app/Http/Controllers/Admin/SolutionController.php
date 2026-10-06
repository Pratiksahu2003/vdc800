<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Solution;
use App\Traits\HandlesUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SolutionController extends Controller
{
    use HandlesUploads;

    public function index(Request $request)
    {
        $query = Solution::query();

        if ($search = $request->get('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        return view('admin.solutions.index', [
            'solutions' => $query->orderBy('sort_order')->paginate(15)->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('admin.solutions.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateSolution($request);
        $validated['slug'] = Str::slug($validated['title']);
        $validated['benefits'] = array_values(array_filter($request->input('benefits', [])));

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadImage($request->file('featured_image'), 'solutions');
        }

        Solution::create($validated);

        return redirect()->route('admin.solutions.index')->with('success', 'Solution created successfully.');
    }

    public function edit(Solution $solution)
    {
        return view('admin.solutions.edit', compact('solution'));
    }

    public function update(Request $request, Solution $solution)
    {
        $validated = $this->validateSolution($request);
        $validated['slug'] = Str::slug($validated['title']);
        $validated['benefits'] = array_values(array_filter($request->input('benefits', [])));

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadImage($request->file('featured_image'), 'solutions', $solution->featured_image);
        }

        $solution->update($validated);

        return redirect()->route('admin.solutions.index')->with('success', 'Solution updated successfully.');
    }

    public function destroy(Solution $solution)
    {
        $this->deleteImage($solution->featured_image);
        $solution->delete();

        return back()->with('success', 'Solution deleted successfully.');
    }

    public function toggleStatus(Solution $solution)
    {
        $solution->update([
            'status' => $solution->status === 'published' ? 'draft' : 'published',
        ]);

        return back()->with('success', 'Solution status updated.');
    }

    private function validateSolution(Request $request): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'benefits' => 'nullable|array',
            'benefits.*' => 'nullable|string|max:255',
            'cta_text' => 'nullable|string|max:100',
            'cta_url' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'sort_order' => 'integer|min:0',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|max:5120',
        ]);
    }
}
