<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::with('category')
            ->published()
            ->latest('published_at')
            ->get()
            ->map(fn($post) => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'excerpt' => $post->excerpt,
                'category' => $post->category?->name,
                'content' => $post->content,
                'featured_image' => $post->image_url,
                'featured_image_alt' => $post->title,
                'author' => $post->author?->name ?? 'Admin',
                'publish_date' => $post->published_at?->toDateString(),
            ]);

        return view('blog', compact('posts'));
    }

    public function show(string $slug): View
    {
        $post = BlogPost::with(['category', 'author'])
            ->where('slug', $slug)
            ->published()
            ->first();

        abort_if(! $post, 404);

        $postArray = [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'excerpt' => $post->excerpt,
            'category' => $post->category?->name,
            'content' => $post->content,
            'featured_image' => $post->image_url,
            'featured_image_alt' => $post->title,
            'author' => $post->author?->name ?? 'Admin',
            'publish_date' => $post->published_at?->toDateString(),
            'seo_title' => $post->title,
            'seo_description' => $post->excerpt,
        ];

        return view('blog-post', ['post' => $postArray]);
    }

    public function category(string $categoryName): View
    {
        $category = Category::where('name', $categoryName)->first();
        $posts = $category 
            ? BlogPost::with('category')
                ->where('category_id', $category->id)
                ->published()
                ->latest('published_at')
                ->get()
                ->map(fn($post) => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'excerpt' => $post->excerpt,
                    'category' => $post->category?->name,
                    'content' => $post->content,
                    'featured_image' => $post->image_url,
                    'featured_image_alt' => $post->title,
                    'author' => $post->author?->name ?? 'Admin',
                    'publish_date' => $post->published_at?->toDateString(),
                ])->toArray()
            : [];

        return view('blog', [
            'posts' => $posts,
            'activeCategory' => $categoryName,
        ]);
    }
}
