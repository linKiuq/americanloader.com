<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BlogPostController extends Controller
{
    public function index(): View
    {
        $posts = BlogPost::latest('updated_at')->paginate(15);

        return view('admin.blog.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.blog.create', ['post' => new BlogPost]);
    }

    public function store(Request $request): RedirectResponse
    {
        $post = BlogPost::create($this->validatedAttributes($request));

        return to_route('admin.blog.edit', $post)->with('success', 'Blog post created.');
    }

    public function edit(BlogPost $post): View
    {
        return view('admin.blog.edit', compact('post'));
    }

    public function update(Request $request, BlogPost $post): RedirectResponse
    {
        $post->update($this->validatedAttributes($request, $post));

        return to_route('admin.blog.edit', $post)->with('success', 'Blog post updated.');
    }

    public function destroy(BlogPost $post): RedirectResponse
    {
        $post->delete();

        return to_route('admin.blog.index')->with('success', 'Blog post deleted.');
    }

    private function validatedAttributes(Request $request, ?BlogPost $post = null): array
    {
        $slug = Str::slug((string) ($request->input('slug') ?: $request->input('title')));
        $request->merge(['slug' => $slug]);

        $attributes = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'string', 'max:180', Rule::unique('blog_posts', 'slug')->ignore($post?->id)],
            'excerpt' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string', 'max:50000'],
            'image_url' => ['nullable', 'url', 'max:2048'],
        ]);

        $attributes['is_published'] = $request->boolean('is_published');
        $attributes['published_at'] = $attributes['is_published']
            ? ($post?->published_at ?? now())
            : null;

        return $attributes;
    }
}
