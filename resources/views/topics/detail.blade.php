<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>{{ $title }} - Topics - Typhon Machinery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #fff; color: #111827; }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    @include('partials.header')

    <header class="py-16 bg-gradient-to-r from-white to-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 style="font-family: 'Archivo Black', sans-serif;" class="text-4xl md:text-5xl font-black uppercase">{{ $title }}</h1>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">{{ $description }}</p>
        </div>
    </header>

    <main class="flex-grow py-12">
        <div class="max-w-5xl mx-auto px-4 space-y-8">
            <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
                <h2 class="text-2xl font-bold">What you’ll learn</h2>
                <ul class="mt-6 space-y-4 text-gray-600 list-disc list-inside">
                    @foreach ($highlights as $highlight)
                        <li>{{ $highlight }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
                <h2 class="text-2xl font-bold">More topics</h2>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <a href="{{ route('topics.index') }}" class="block rounded-2xl border border-gray-200 bg-slate-50 p-6 text-sm font-semibold text-slate-900 hover:border-slate-300">All Topics</a>
                    <a href="{{ route('blog.index') }}" class="block rounded-2xl border border-gray-200 bg-slate-50 p-6 text-sm font-semibold text-slate-900 hover:border-slate-300">Blog</a>
                </div>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
