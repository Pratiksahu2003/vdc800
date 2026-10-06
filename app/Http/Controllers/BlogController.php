<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $categorySlug = request('category');

        $postsQuery = BlogPost::published()->with('category');

        if ($categorySlug) {
            $postsQuery->whereHas('category', fn ($q) => $q->where('slug', $categorySlug)->where('status', 'published'));
        }

        return view('blog.index', [
            'posts' => $postsQuery->paginate(9)->withQueryString(),
            'categories' => BlogCategory::published()->withCount(['posts' => fn ($q) => $q->published()])->get(),
            'activeCategory' => $categorySlug ? BlogCategory::where('slug', $categorySlug)->first() : null,
        ]);
    }

    public function show(BlogPost $post)
    {
        abort_unless($post->status === 'published', 404);

        return view('blog.show', [
            'post' => $post->load('category'),
            'relatedPosts' => BlogPost::published()
                ->where('id', '!=', $post->id)
                ->when($post->blog_category_id, fn ($q) => $q->where('blog_category_id', $post->blog_category_id))
                ->limit(3)
                ->get(),
        ]);
    }
}
