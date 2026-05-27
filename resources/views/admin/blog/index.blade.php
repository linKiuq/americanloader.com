@extends('admin.layout')

@section('title', 'Manage Blog')

@section('content')
    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="text-xs font-black uppercase tracking-[0.3em] text-yellow-600">Content Management</p>
            <h1 class="mt-3 text-4xl font-black" style="font-family: 'Montserrat', sans-serif;">Blog Posts</h1>
        </div>
        <a href="{{ route('admin.blog.create') }}" class="rounded-lg bg-yellow-400 px-6 py-4 text-center text-sm font-black uppercase tracking-wider text-slate-950 hover:bg-yellow-500">New Post</a>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-950 text-xs uppercase tracking-wider text-slate-300">
                <tr>
                    <th class="px-6 py-4">Article</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="hidden px-6 py-4 md:table-cell">Published</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($posts as $post)
                    <tr>
                        <td class="px-6 py-5">
                            <p class="font-bold text-slate-950">{{ $post->title }}</p>
                            <p class="mt-1 text-xs text-slate-500">/blog/{{ $post->slug }}</p>
                            <p class="mt-2 text-xs font-semibold uppercase tracking-wide text-yellow-700">{{ $post->category?->name ?? 'Uncategorized' }}</p>
                        </td>
                        <td class="px-6 py-5">
                            <span class="rounded-full px-3 py-1 text-xs font-bold {{ $post->is_published ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ $post->is_published ? 'Published' : 'Draft' }}
                            </span>
                        </td>
                        <td class="hidden px-6 py-5 text-slate-500 md:table-cell">
                            <p>{{ $post->published_at?->format('M j, Y') ?? '-' }}</p>
                            <p class="mt-1 text-xs">{{ $post->author?->name ?? 'Imported content' }}</p>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex justify-end gap-3">
                                @if ($post->is_published)
                                    <a href="{{ route('blog.show', $post->slug) }}" class="font-bold text-slate-500 hover:text-yellow-600">View</a>
                                @endif
                                <a href="{{ route('admin.blog.edit', $post) }}" class="font-bold text-yellow-600 hover:text-yellow-700">Edit</a>
                                <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" onsubmit="return confirm('Delete this post?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="font-bold text-red-600 hover:text-red-700">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-12 text-center text-slate-500">No blog posts have been created.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($posts->hasPages())
        <div class="mt-8">{{ $posts->links() }}</div>
    @endif
@endsection
