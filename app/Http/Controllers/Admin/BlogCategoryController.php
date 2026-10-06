<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = BlogCategory::query()->withCount('posts');

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        return view('admin.blog-categories.index', [
            'categories' => $query->orderBy('sort_order')->paginate(15)->withQueryString(),
        ]);
    }

    public function create()
    {
        return view('admin.blog-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateCategory($request);
        $validated['slug'] = Str::slug($validated['name']);

        BlogCategory::create($validated);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Blog category created successfully.');
    }

    public function edit(BlogCategory $blogCategory)
    {
        return view('admin.blog-categories.edit', compact('blogCategory'));
    }

    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $this->validateCategory($request);
        $validated['slug'] = Str::slug($validated['name']);

        $blogCategory->update($validated);

        return redirect()->route('admin.blog-categories.index')->with('success', 'Blog category updated successfully.');
    }

    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();

        return back()->with('success', 'Blog category deleted successfully.');
    }

    public function toggleStatus(BlogCategory $blogCategory)
    {
        $blogCategory->update([
            'status' => $blogCategory->status === 'published' ? 'draft' : 'published',
        ]);

        return back()->with('success', 'Category status updated.');
    }

    private function validateCategory(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'integer|min:0',
            'status' => 'required|in:draft,published',
        ]);
    }
}
