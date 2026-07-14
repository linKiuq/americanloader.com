<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $posts = $this->publishedPosts();

        return view('blog', compact('posts'));
    }

    public function show(string $slug): View
    {
        $post = BlogPost::with(['category', 'author'])
            ->where('slug', $slug)
            ->published()
            ->first();

        abort_if(! $post, 404);

        return view('blog-post', ['post' => $this->postToArray($post)]);
    }

    public function category(string $categoryName): View
    {
        $category = Category::where('slug', $categoryName)
            ->orWhere('name', $categoryName)
            ->first();
        $categorySlug = $category?->slug ?? $categoryName;
        $posts = $this->publishedPosts()
            ->filter(fn (array $post): bool => ($post['category_slug'] ?? null) === $categorySlug || ($post['category'] ?? null) === $categoryName)
            ->values();

        return view('blog', [
            'posts' => $posts,
            'activeCategory' => $category?->name ?? $categoryName,
        ]);
    }

    private function publishedPosts(): Collection
    {
        return BlogPost::with(['category', 'author'])
            ->published()
            ->latest('published_at')
            ->get()
            ->map(fn ($post) => $this->postToArray($post))
            ->values();
    }

    private function postToArray(BlogPost $post): array
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'excerpt' => $post->excerpt,
            'category' => $post->category?->name,
            'category_slug' => $post->category?->slug,
            'content' => $post->content,
            'featured_image' => $post->image_url,
            'featured_image_alt' => $post->title,
            'author' => $post->author?->name ?? 'Admin',
            'publish_date' => $post->published_at?->toDateString(),
            'seo_title' => $post->title,
            'seo_description' => $post->excerpt,
        ];
    }

}
