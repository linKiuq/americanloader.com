<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>{{ ($post['seo_title'] ?? null) ?: $post['title'] }} - The Power Loader Blog</title>
    <meta name="description" content="{{ ($post['seo_description'] ?? null) ?: ($post['excerpt'] ?? '') }}">
    <meta property="og:title" content="{{ $post['title'] }}">
    <meta property="og:type" content="article">
    @if (! empty($post['featured_image']))
        <meta property="og:image" content="{{ $post['featured_image'] }}">
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white text-slate-950 antialiased">
    @include('partials.header')

    <main class="flex-grow">
        <article class="mx-auto max-w-4xl px-6 py-12">
            <a href="{{ route('blog.index') }}" class="text-sm font-bold uppercase tracking-wider text-yellow-600 transition hover:text-yellow-700">&larr; Back to Blog</a>
            @if (! empty($post['category']))
                <a href="{{ route('blog.category', $post['category']) }}" class="mt-10 inline-block text-xs font-black uppercase tracking-[0.3em] text-yellow-700 transition hover:text-yellow-600">{{ $post['category'] }}</a>
            @endif
            @if (! empty($post['publish_date']))
                <p class="{{ ! empty($post['category']) ? 'mt-3' : 'mt-10' }} text-xs font-black uppercase tracking-[0.3em] text-yellow-600">{{ \Illuminate\Support\Carbon::parse($post['publish_date'])->format('F j, Y') }}</p>
            @endif
            <h1 class="mt-4 text-4xl font-black leading-tight md:text-5xl" style="font-family: 'Montserrat', sans-serif;">{{ $post['title'] }}</h1>
            @if (! empty($post['excerpt']))
                <p class="mt-5 text-lg leading-8 text-slate-600">{{ $post['excerpt'] }}</p>
            @endif

            @if (! empty($post['featured_image']))
                <img src="{{ $post['featured_image'] }}" alt="{{ $post['featured_image_alt'] ?? $post['title'] }}" class="mt-10 h-[420px] w-full rounded-2xl object-cover">
            @endif

            <div class="mt-10 max-w-none text-base leading-8 text-slate-700 [&_a]:font-semibold [&_a]:text-yellow-700 [&_blockquote]:border-l-4 [&_blockquote]:border-yellow-400 [&_blockquote]:pl-5 [&_blockquote]:text-slate-600 [&_h2]:mt-10 [&_h2]:text-3xl [&_h2]:font-black [&_h3]:mt-8 [&_h3]:text-2xl [&_h3]:font-black [&_li]:my-2 [&_ol]:list-decimal [&_ol]:pl-6 [&_p]:my-5 [&_ul]:list-disc [&_ul]:pl-6">
                {!! \Illuminate\Support\Str::markdown($post['content'] ?? '') !!}
            </div>
        </article>
    </main>

    @include('partials.footer')
</body>
</html>
