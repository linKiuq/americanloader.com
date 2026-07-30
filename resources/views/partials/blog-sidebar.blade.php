<aside class="space-y-9 lg:sticky lg:top-28" aria-label="Blog sidebar">
    <form action="{{ route('blog.index') }}" method="GET" class="flex overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm" role="search">
        <label for="article-sidebar-search" class="sr-only">Search articles</label>
        <input id="article-sidebar-search" name="search" type="search" value="{{ request('search') }}" placeholder="Search articles..." class="min-w-0 flex-1 px-4 py-3 text-sm outline-none placeholder:text-slate-400 focus:bg-slate-50">
        <button type="submit" class="bg-[#071d38] px-4 text-xs font-black uppercase tracking-wider text-white transition hover:bg-red-700">Search</button>
    </form>

    <section aria-labelledby="article-recent-posts-heading">
        <div class="flex items-center justify-between border-b-2 border-[#071d38] pb-3">
            <h2 id="article-recent-posts-heading" class="text-lg font-black uppercase tracking-tight text-[#071d38]">Recent Posts</h2>
            <span class="text-xs font-black text-red-700">{{ $recentPosts->count() }}</span>
        </div>
        <div class="divide-y divide-slate-200">
            @foreach ($recentPosts as $recentPost)
                <article class="grid grid-cols-[72px_1fr] gap-3 py-4">
                    <a href="{{ route('blog.show', $recentPost['slug']) }}" class="h-16 overflow-hidden rounded-md bg-slate-100">
                        @if (! empty($recentPost['featured_image']))
                            <img src="{{ $recentPost['featured_image'] }}" alt="" class="h-full w-full object-cover" loading="lazy">
                        @endif
                    </a>
                    <div class="min-w-0">
                        <h3 class="line-clamp-2 text-sm font-black leading-5 text-[#071d38]">
                            <a href="{{ route('blog.show', $recentPost['slug']) }}" class="transition hover:text-red-700">{{ $recentPost['title'] }}</a>
                        </h3>
                        @if (! empty($recentPost['publish_date']))
                            <p class="mt-1 text-[11px] font-semibold uppercase tracking-wider text-slate-400">{{ \Illuminate\Support\Carbon::parse($recentPost['publish_date'])->format('M j, Y') }}</p>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </section>

    <section aria-labelledby="article-popular-categories-heading">
        <div class="border-b-2 border-[#071d38] pb-3">
            <h2 id="article-popular-categories-heading" class="text-lg font-black uppercase tracking-tight text-[#071d38]">Popular Categories</h2>
        </div>
        <ul class="mt-2 divide-y divide-slate-200">
            @foreach ($popularCategories as $category)
                <li>
                    <a href="{{ route('blog.category', $category['slug']) }}" class="flex items-center justify-between gap-4 py-3 text-sm font-semibold text-slate-700 transition hover:text-red-700">
                        <span>{{ $category['name'] }}</span>
                        <span class="inline-flex min-w-7 items-center justify-center rounded-full bg-slate-100 px-2 py-1 text-[11px] font-black text-[#071d38]">{{ $category['count'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </section>
</aside>
