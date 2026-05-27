<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        $tags = Tag::withCount('blogPosts')->latest()->paginate(15);

        return view('admin.tags.index', compact('tags'));
    }

    public function create(): View
    {
        return view('admin.tags.create', ['tag' => new Tag]);
    }

    public function store(Request $request): RedirectResponse
    {
        Tag::create($this->validatedAttributes($request));

        return to_route('admin.tags.index')->with('success', 'Tag created.');
    }

    public function edit(Tag $tag): View
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $tag->update($this->validatedAttributes($request, $tag));

        return to_route('admin.tags.index')->with('success', 'Tag updated.');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return to_route('admin.tags.index')->with('success', 'Tag deleted.');
    }

    private function validatedAttributes(Request $request, ?Tag $tag = null): array
    {
        $request->merge(['slug' => Str::slug((string) ($request->input('slug') ?: $request->input('name')))]);

        return $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('tags')->ignore($tag?->id)],
            'slug' => ['required', 'string', 'max:100', Rule::unique('tags')->ignore($tag?->id)],
        ]);
    }
}
