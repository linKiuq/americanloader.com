@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="text-xs font-black uppercase tracking-[0.3em] text-yellow-600">Content Management</p>
            <h1 class="mt-3 text-4xl font-black" style="font-family: 'Montserrat', sans-serif;">Admin Dashboard</h1>
            <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600">Manage public blog articles, categories, and tags from one place.</p>
        </div>
        <a href="{{ route('admin.blog.create') }}" class="rounded-lg bg-yellow-400 px-6 py-4 text-center text-sm font-black uppercase tracking-wider text-slate-950 hover:bg-yellow-500">New Post</a>
    </div>

    <div class="grid gap-5 md:grid-cols-2 lg:grid-cols-5">
        <a href="{{ route('admin.blog.index') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:border-yellow-300">
            <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">All Posts</p>
            <p class="mt-4 text-3xl font-black text-slate-950">{{ $totalPosts }}</p>
        </a>
        <a href="{{ route('admin.blog.index') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:border-yellow-300">
            <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">Published</p>
            <p class="mt-4 text-3xl font-black text-green-700">{{ $publishedPosts }}</p>
        </a>
        <a href="{{ route('admin.blog.index') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:border-yellow-300">
            <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">Drafts</p>
            <p class="mt-4 text-3xl font-black text-slate-700">{{ $draftPosts }}</p>
        </a>
        <a href="{{ route('admin.categories.index') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:border-yellow-300">
            <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">Categories</p>
            <p class="mt-4 text-3xl font-black text-slate-950">{{ $categoryCount }}</p>
        </a>
        <a href="{{ route('admin.tags.index') }}" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:border-yellow-300">
            <p class="text-xs font-black uppercase tracking-[0.24em] text-slate-500">Tags</p>
            <p class="mt-4 text-3xl font-black text-slate-950">{{ $tagCount }}</p>
        </a>
    </div>

    <section class="mt-10 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col justify-between gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center">
            <div>
                <h2 class="text-xl font-black">Recent Articles</h2>
                <p class="mt-1 text-sm text-slate-500">Latest blog updates in the admin area.</p>
            </div>
            <a href="{{ route('admin.blog.index') }}" class="text-sm font-bold text-yellow-700 hover:text-yellow-600">Manage all posts</a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse ($recentPosts as $post)
                <div class="flex flex-col gap-4 px-6 py-5 md:flex-row md:items-center md:justify-between">
                    <div>
                        <p class="font-bold text-slate-950">{{ $post->title }}</p>
                        <p class="mt-1 text-xs text-slate-500">/blog/{{ $post->slug }} - {{ $post->category?->name ?? 'Uncategorized' }}</p>
                    </div>
                    <div class="flex items-center gap-4 text-sm">
                        <span class="rounded-full px-3 py-1 text-xs font-bold {{ $post->is_published ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $post->is_published ? 'Published' : 'Draft' }}
                        </span>
                        <a href="{{ route('admin.blog.edit', $post) }}" class="font-bold text-yellow-700 hover:text-yellow-600">Edit</a>
                    </div>
                </div>
            @empty
                <p class="px-6 py-12 text-center text-slate-500">No blog posts have been created.</p>
            @endforelse
        </div>
    </section>
@endsection
