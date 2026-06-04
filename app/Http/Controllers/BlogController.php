<?php

namespace App\Http\Controllers;

use App\Services\SupabaseCmsService;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function __construct(private SupabaseCmsService $cms)
    {
    }

    public function index(): View
    {
        $posts = $this->cms->getPublishedPosts();

        return view('blog', compact('posts'));
    }

    public function show(string $slug): View
    {
        $post = $this->cms->getPostBySlug($slug);

        abort_if(! $post, 404);

        return view('blog-post', compact('post'));
    }

    public function category(string $category): View
    {
        return view('blog', [
            'posts' => $this->cms->getPostsByCategory($category),
            'activeCategory' => $category,
        ]);
    }
}
