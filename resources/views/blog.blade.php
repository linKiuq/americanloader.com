<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    @include('partials.seo', [
        'title' => (isset($activeCategory) ? $activeCategory . ' Equipment Articles' : config('seo.site_name') . ' Heavy Equipment Blog'),
        'description' => 'Read American Loader guides about wheel loaders, skid steer loaders, STORM mini excavators, forklifts, road rollers, scissor lifts, and attachments.',
        'keywords' => 'American Loader blog, wheel loader guides, skid steer articles, mini excavator guides, forklift articles, road roller advice, scissor lift guides, attachment tips',
    ])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white text-[#071d38] antialiased">
    @include('partials.header')

    <header class="border-b border-red-500/15 bg-[#071d38] py-16 text-white">
        <div class="mx-auto max-w-7xl px-6 text-center">
            <p class="mb-4 text-xs font-black uppercase tracking-[0.35em] text-red-500">Equipment Journal</p>
            <h1 class="text-4xl font-black uppercase md:text-5xl" style="font-family: 'Montserrat', sans-serif;">{{ $activeCategory ?? 'Explore Our Blog' }}</h1>
            <p class="mx-auto mt-4 max-w-2xl text-slate-300">News, equipment insights, and machine walkthroughs from The Power Loader.</p>
        </div>
    </header>

    <main id="topics" class="py-14">
        <div class="mx-auto grid max-w-7xl gap-10 px-6 lg:grid-cols-[minmax(0,1fr)_320px] lg:items-start">
            <div class="grid grid-cols-1 gap-7 md:grid-cols-2">
                @forelse ($posts as $post)
                    <article class="flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                        @if (! empty($post['featured_image']))
                            <a href="{{ route('blog.show', $post['slug']) }}" class="block h-56 overflow-hidden bg-slate-100">
                                <img src="{{ $post['featured_image'] }}" alt="{{ $post['featured_image_alt'] ?? $post['title'] }}" class="h-full w-full object-cover transition duration-500 hover:scale-105" loading="lazy">
                            </a>
                        @endif
                        <div class="flex flex-1 flex-col p-6">
                            @if (! empty($post['category']))
                                <a href="{{ route('blog.category', $post['category_slug'] ?? \Illuminate\Support\Str::slug($post['category'])) }}" class="mb-2 text-xs font-black uppercase tracking-[0.2em] text-red-800 transition hover:text-red-700">{{ $post['category'] }}</a>
                            @endif
                            @if (! empty($post['publish_date']))
                                <p class="mb-3 text-xs font-bold uppercase tracking-[0.2em] text-slate-400">{{ \Illuminate\Support\Carbon::parse($post['publish_date'])->format('M j, Y') }}</p>
                            @endif
                            <h2 class="text-xl font-black leading-snug">
                                <a href="{{ route('blog.show', $post['slug']) }}" class="transition hover:text-red-700">{{ $post['title'] }}</a>
                            </h2>
                            @if (! empty($post['excerpt']))
                                <p class="mt-3 flex-1 text-sm leading-7 text-slate-600">{{ $post['excerpt'] }}</p>
                            @endif
                            <a href="{{ route('blog.show', $post['slug']) }}" class="mt-6 inline-flex items-center gap-2 self-start text-xs font-black uppercase tracking-[0.16em] text-[#071d38] transition hover:text-red-700">Read article <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                @empty
                    <p class="col-span-full rounded-xl border border-slate-200 bg-slate-50 p-8 text-center text-slate-600">No published articles are available yet.</p>
                @endforelse
            </div>

            <aside class="space-y-9 lg:sticky lg:top-28" aria-label="Blog sidebar">
                <form action="{{ route('blog.index') }}" method="GET" class="flex overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm" role="search">
                    <label for="blog-search" class="sr-only">Search articles</label>
                    <input id="blog-search" name="search" type="search" value="{{ request('search') }}" placeholder="Search articles..." class="min-w-0 flex-1 px-4 py-3 text-sm outline-none placeholder:text-slate-400 focus:bg-slate-50">
                    <button type="submit" class="bg-[#071d38] px-4 text-xs font-black uppercase tracking-wider text-white transition hover:bg-red-700">Search</button>
                </form>

                <section aria-labelledby="recent-posts-heading">
                    <div class="flex items-center justify-between border-b-2 border-[#071d38] pb-3">
                        <h2 id="recent-posts-heading" class="text-lg font-black uppercase tracking-tight text-[#071d38]">Recent Posts</h2>
                        <span class="text-xs font-black text-red-700">{{ $recentPosts->count() }}</span>
                    </div>
                    <div class="divide-y divide-slate-200">
                        @foreach ($recentPosts as $recentPost)
                            <article class="grid grid-cols-[72px_1fr] gap-3 py-4">
                                <a href="{{ route('blog.show', $recentPost['slug']) }}" class="h-16 overflow-hidden rounded-md bg-slate-100">
                                    @if (! empty($recentPost['featured_image']))
                                        <img src="{{ $recentPost['featured_image'] }}" alt="{{ $recentPost['featured_image_alt'] ?? $recentPost['title'] }}" class="h-full w-full object-cover" loading="lazy" decoding="async">
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

                <section aria-labelledby="popular-categories-heading">
                    <div class="border-b-2 border-[#071d38] pb-3">
                        <h2 id="popular-categories-heading" class="text-lg font-black uppercase tracking-tight text-[#071d38]">Popular Categories</h2>
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
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
