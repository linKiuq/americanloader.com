<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attachments - Skoop Loaders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white text-gray-950">
    @include('partials.header')

    <main class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-blue-600">Attachments</p>
                <h1 class="mt-4 text-4xl sm:text-5xl font-black text-gray-950">Premium attachments for every loader and excavator</h1>
                <p class="mt-4 text-gray-600 max-w-3xl mx-auto">Explore category pages for mini excavator attachments, skid steer tools, and specialized worksite equipment built to enhance productivity.</p>
            </div>

            <div class="grid gap-8 xl:grid-cols-3">
                <a href="{{ route('attachments.mini-excavators-2-5-tons') }}" class="group block rounded-3xl border border-gray-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-blue-600 text-xs uppercase tracking-[0.28em] font-black mb-3">Mini Excavator</p>
                            <h2 class="text-2xl font-black text-gray-950">2.5 Tons</h2>
                        </div>
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-blue-50 text-blue-600">2.5T</div>
                    </div>
                    <p class="mt-5 text-gray-600">Heavy-duty buckets, breakers, and tilt rotators designed for 2.5 ton mini excavators.</p>
                </a>

                <a href="{{ route('attachments.mini-excavators-2-tons-and-below') }}" class="group block rounded-3xl border border-gray-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-blue-600 text-xs uppercase tracking-[0.28em] font-black mb-3">Mini Excavator</p>
                            <h2 class="text-2xl font-black text-gray-950">2 Tons & Below</h2>
                        </div>
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-blue-50 text-blue-600">2T</div>
                    </div>
                    <p class="mt-5 text-gray-600">Lightweight landscaping and trenching attachments built for compact maneuverability.</p>
                </a>

                <a href="{{ route('attachments.skid-steer') }}" class="group block rounded-3xl border border-gray-200 bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-blue-600 text-xs uppercase tracking-[0.28em] font-black mb-3">Skid Steer</p>
                            <h2 class="text-2xl font-black text-gray-950">Attachments</h2>
                        </div>
                        <div class="inline-flex h-12 w-12 items-center justify-center rounded-3xl bg-blue-50 text-blue-600">SS</div>
                    </div>
                    <p class="mt-5 text-gray-600">Browse compact and standard skid steer series for landscaping, loading, and site preparation.</p>
                </a>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
