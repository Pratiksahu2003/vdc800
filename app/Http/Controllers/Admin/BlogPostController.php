<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Traits\HandlesUploads;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    use HandlesUploads;

    public function index(Request $request)
    {
        $query = BlogPost::query()->with('category');

        if ($search = $request->get('search')) {
            $query->where('title', 'like', "%{$search}%");
        }

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($category = $request->get('category')) {
            $query->where('blog_category_id', $category);
        }

        return view('admin.blog-posts.index', [
            'posts' => $query->orderByDesc('published_at')->orderBy('sort_order')->paginate(15)->withQueryString(),
            'categories' => BlogCategory::orderBy('sort_order')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.blog-posts.create', [
            'categories' => BlogCategory::orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validatePost($request);
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadImage($request->file('featured_image'), 'blog');
        }

        BlogPost::create($validated);

        return redirect()->route('admin.blog-posts.index')->with('success', 'Blog post created successfully.');
    }

    public function edit(BlogPost $blogPost)
    {
        return view('admin.blog-posts.edit', [
            'post' => $blogPost,
            'categories' => BlogCategory::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $this->validatePost($request);
        $validated['slug'] = Str::slug($validated['title']);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $this->uploadImage($request->file('featured_image'), 'blog', $blogPost->featured_image);
        }

        $blogPost->update($validated);

        return redirect()->route('admin.blog-posts.index')->with('success', 'Blog post updated successfully.');
    }

    public function destroy(BlogPost $blogPost)
    {
        if ($blogPost->featured_image && ! str_starts_with($blogPost->featured_image, 'images/')) {
            $this->deleteImage($blogPost->featured_image);
        }

        $blogPost->delete();

        return back()->with('success', 'Blog post deleted successfully.');
    }

    public function toggleStatus(BlogPost $blogPost)
    {
        $blogPost->update([
            'status' => $blogPost->status === 'published' ? 'draft' : 'published',
        ]);

        return back()->with('success', 'Post status updated.');
    }

    private function validatePost(Request $request): array
    {
        return $request->validate([
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'body' => 'nullable|string',
            'author' => 'nullable|string|max:100',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'published_at' => 'nullable|date',
            'sort_order' => 'integer|min:0',
            'status' => 'required|in:draft,published',
            'featured_image' => 'nullable|image|max:5120',
        ]);
    }
}
