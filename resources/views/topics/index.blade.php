<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    @include('partials.seo', [
        'title' => 'The Power Loader Equipment Topics & Wheel Loader Buying Guides',
        'description' => 'Explore Power Loader buying guides, Skoop loader explainers, wheel loader workspace planning advice, and safety topics for compact construction equipment.',
        'keywords' => 'Power Loader guides, Power Loader equipment topics, Skoop loader guide, wheel loader buying guide, wheel loader safety',
    ])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white text-gray-950">
    @include('partials.header')

    <main>
        <header class="border-b border-gray-200 bg-gradient-to-r from-white to-gray-50 py-16">
            <div class="mx-auto max-w-7xl px-4 text-center">
                <p class="mb-3 text-xs font-black uppercase tracking-[0.3em] text-yellow-600">Equipment Knowledge</p>
                <h1 class="text-4xl font-black uppercase tracking-tight md:text-5xl">Topics</h1>
                <p class="mx-auto mt-4 max-w-2xl text-gray-600">Guides, machine features, workspace planning, and operating safety for compact equipment owners.</p>
            </div>
        </header>

        <section class="mx-auto grid max-w-7xl gap-6 px-4 py-14 md:grid-cols-2 lg:grid-cols-5">
            <a href="{{ route('blog.index') }}" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-yellow-500 hover:shadow-md">
                <h2 class="font-black uppercase text-gray-950">Blog</h2>
                <p class="mt-3 text-sm text-gray-600">News and machine walkthroughs.</p>
            </a>
            <a href="{{ route('topics.show', 'buy-guides') }}" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-yellow-500 hover:shadow-md">
                <h2 class="font-black uppercase text-gray-950">Buy Guides</h2>
                <p class="mt-3 text-sm text-gray-600">Choose the right equipment.</p>
            </a>
            <a href="{{ route('topics.show', 'features') }}" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-yellow-500 hover:shadow-md">
                <h2 class="font-black uppercase text-gray-950">Features</h2>
                <p class="mt-3 text-sm text-gray-600">Understand capabilities.</p>
            </a>
            <a href="{{ route('topics.show', 'workspace') }}" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-yellow-500 hover:shadow-md">
                <h2 class="font-black uppercase text-gray-950">Workspace</h2>
                <p class="mt-3 text-sm text-gray-600">Plan site operations.</p>
            </a>
            <a href="{{ route('topics.show', 'safety') }}" class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-yellow-500 hover:shadow-md">
                <h2 class="font-black uppercase text-gray-950">Safety</h2>
                <p class="mt-3 text-sm text-gray-600">Operate with confidence.</p>
            </a>
        </section>
    </main>

    @include('partials.footer')
</body>
</html>
