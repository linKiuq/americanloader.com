<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>{{ isset($activeCategory) ? $activeCategory . ' - ' : '' }}Blog - The Power Loader</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white text-slate-950 antialiased">
    @include('partials.header')

    <header class="border-b border-yellow-400/15 bg-slate-950 py-16 text-white">
        <div class="mx-auto max-w-7xl px-6 text-center">
            <p class="mb-4 text-xs font-black uppercase tracking-[0.35em] text-yellow-400">Equipment Journal</p>
            <h1 class="text-4xl font-black uppercase md:text-5xl" style="font-family: 'Montserrat', sans-serif;">{{ $activeCategory ?? 'Explore Our Blog' }}</h1>
            <p class="mx-auto mt-4 max-w-2xl text-slate-300">News, equipment insights, and machine walkthroughs from The Power Loader.</p>
        </div>
    </header>

    <main id="topics" class="py-14">
        <div class="mx-auto grid max-w-7xl grid-cols-1 gap-7 px-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($posts as $post)
                <article class="flex flex-col overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    @if (! empty($post['featured_image']))
                        <a href="{{ route('blog.show', $post['slug']) }}" class="block h-52 overflow-hidden bg-slate-100">
                            <img src="{{ $post['featured_image'] }}" alt="{{ $post['featured_image_alt'] ?? $post['title'] }}" class="h-full w-full object-cover transition duration-500 hover:scale-105" loading="lazy">
                        </a>
                    @endif
                    <div class="flex flex-1 flex-col p-6">
                        @if (! empty($post['category']))
                            <a href="{{ route('blog.category', $post['category']) }}" class="mb-2 text-xs font-black uppercase tracking-[0.2em] text-yellow-700 transition hover:text-yellow-600">{{ $post['category'] }}</a>
                        @endif
                        @if (! empty($post['publish_date']))
                            <p class="mb-3 text-xs font-bold uppercase tracking-[0.28em] text-yellow-600">{{ \Illuminate\Support\Carbon::parse($post['publish_date'])->format('M j, Y') }}</p>
                        @endif
                        <h2 class="text-xl font-black leading-snug">
                            <a href="{{ route('blog.show', $post['slug']) }}" class="transition hover:text-yellow-600">{{ $post['title'] }}</a>
                        </h2>
                        @if (! empty($post['excerpt']))
                            <p class="mt-3 flex-1 text-sm leading-7 text-slate-600">{{ $post['excerpt'] }}</p>
                        @endif
                        <a href="{{ route('blog.show', $post['slug']) }}" class="mt-6 inline-flex self-start rounded bg-yellow-400 px-5 py-3 text-xs font-black uppercase tracking-wider text-slate-950 transition hover:bg-yellow-500">Read article</a>
                    </div>
                </article>
            @empty
                <p class="col-span-full rounded-xl border border-slate-200 bg-slate-50 p-8 text-center text-slate-600">No published articles are available yet.</p>
            @endforelse
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
