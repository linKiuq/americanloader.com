<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog - Typhon Machinery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #fff; color: #111827; }
    </style>
</head>
<body class="min-h-screen flex flex-col">
    @include('partials.header')

    <header class="py-16 bg-gradient-to-r from-white to-gray-50 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 style="font-family: 'Archivo Black', sans-serif;" class="text-4xl md:text-5xl font-black uppercase">Explore Our Blog</h1>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">News, updates, and machine walkthroughs from Typhon Machinery.</p>
        </div>
    </header>

    <main id="topics" class="flex-grow py-12">
        <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-6">
            <article class="border border-gray-200 rounded-xl overflow-hidden shadow-sm bg-white">
                <a href="/blog/wheel-loader-demo" class="block h-48 bg-gray-100 overflow-hidden">
                    <img src="https://machinery.online/wp-content/uploads/2026/02/TYPHON-Wheel-Loader-with-Kubota-D1105-engine8-1.jpg" alt="Wheel Loader Demo" class="w-full h-full object-cover">
                </a>
                <div class="p-6">
                    <h3 class="font-bold text-lg"><a href="/blog/wheel-loader-demo" class="hover:text-blue-600">Telescopic Wheel Loader — Field Demo</a></h3>
                    <p class="text-sm text-gray-600 mt-2">See how the new Telescopic Wheel Loader performs on-site with Kubota power and extra reach.</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-xs text-gray-500">May 12, 2026</span>
                        <a href="/blog/wheel-loader-demo" class="text-sm font-black bg-skoopBlue text-white px-3 py-2 rounded">Read</a>
                    </div>
                </div>
            </article>

            <article class="border border-gray-200 rounded-xl overflow-hidden shadow-sm bg-white">
                <a href="/blog/thunder-vi-review" class="block h-48 bg-gray-100 overflow-hidden">
                    <img src="https://machinery.online/wp-content/uploads/2025/03/TYPHON-Thunder-VI-23hp-EPA-BS-Engine-Wheel-Loader-scaled-1.webp" alt="Thunder VI" class="w-full h-full object-cover">
                </a>
                <div class="p-6">
                    <h3 class="font-bold text-lg"><a href="/blog/thunder-vi-review" class="hover:text-blue-600">TYPHON Thunder VI — Compact Review</a></h3>
                    <p class="text-sm text-gray-600 mt-2">An operator-focused review of the Thunder VI and why crews choose it for tight-site work.</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-xs text-gray-500">Apr 8, 2026</span>
                        <a href="/blog/thunder-vi-review" class="text-sm font-black bg-skoopBlue text-white px-3 py-2 rounded">Read</a>
                    </div>
                </div>
            </article>

            <article class="border border-gray-200 rounded-xl overflow-hidden shadow-sm bg-white">
                <a href="/blog/typhon-terror-usecase" class="block h-48 bg-gray-100 overflow-hidden">
                    <img src="https://machinery.online/wp-content/uploads/2025/03/Brand-New-TYPHON-TERROR-4WD-Backhoe-Loader-USA.webp" alt="TYPHON TERROR" class="w-full h-full object-cover">
                </a>
                <div class="p-6">
                    <h3 class="font-bold text-lg"><a href="/blog/typhon-terror-usecase" class="hover:text-blue-600">TYPHON TERROR Use Cases</a></h3>
                    <p class="text-sm text-gray-600 mt-2">How the TERROR 4WD handles heavy-duty yard work, digging, and loading across industries.</p>
                    <div class="mt-4 flex items-center justify-between">
                        <span class="text-xs text-gray-500">Mar 18, 2026</span>
                        <a href="/blog/typhon-terror-usecase" class="text-sm font-black bg-skoopBlue text-white px-3 py-2 rounded">Read</a>
                    </div>
                </div>
            </article>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
