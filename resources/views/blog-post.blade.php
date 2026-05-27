<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>{{ $post->title }} - Skoop Loaders Blog</title>
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
            @if ($post->category)
                <p class="mt-10 text-xs font-black uppercase tracking-[0.3em] text-yellow-700">{{ $post->category->name }}</p>
            @endif
            <p class="{{ $post->category ? 'mt-3' : 'mt-10' }} text-xs font-black uppercase tracking-[0.3em] text-yellow-600">{{ $post->published_at->format('F j, Y') }}</p>
            <h1 class="mt-4 text-4xl font-black leading-tight md:text-5xl" style="font-family: 'Montserrat', sans-serif;">{{ $post->title }}</h1>
            <p class="mt-5 text-lg leading-8 text-slate-600">{{ $post->excerpt }}</p>
            @if ($post->tags->isNotEmpty())
                <div class="mt-5 flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold uppercase tracking-wide text-yellow-800">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @endif

            @if ($post->image_url)
                <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="mt-10 h-[420px] w-full rounded-2xl object-cover">
            @endif

            <div class="mt-10 text-base leading-8 text-slate-700">
                {!! nl2br(e($post->content)) !!}
            </div>
        </article>
    </main>

    @include('partials.footer')
</body>
</html>
