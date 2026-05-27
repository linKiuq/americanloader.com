<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::published()
            ->latest('published_at')
            ->paginate(9);

        return view('blog', compact('posts'));
    }

    public function show(string $slug): View
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('blog-post', compact('post'));
    }
}
