<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    @include('partials.seo', [
        'title' => $series['title'] . ' | The Power Loader Attachments',
        'description' => $series['description'] ?? 'Browse The Power Loader skid steer attachment series, Skoop loader attachments, and compact loader attachment packages.',
    ])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white text-gray-950">
    @include('partials.header')

    <main class="py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10 text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-yellow-600">Skid Steer Attachments</p>
                <h1 class="mt-4 text-4xl sm:text-5xl font-black text-gray-950">{{ $series['title'] }}</h1>
                <p class="mt-4 text-gray-600 max-w-3xl mx-auto">{{ $series['description'] }}</p>
            </div>

            <div class="rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
                <h2 class="text-2xl font-bold text-gray-950 mb-6">What you get</h2>
                <ul class="space-y-4 text-gray-600">
                    @foreach($series['details'] as $detail)
                        <li class="flex gap-3">
                            <span class="mt-1 h-3.5 w-3.5 rounded-full bg-yellow-600"></span>
                            <span>{{ $detail }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="mt-8 rounded-3xl border border-gray-200 bg-white p-8 shadow-sm">
                <h2 class="text-2xl font-bold text-gray-950 mb-4">Need this series?</h2>
                <p class="text-gray-600 mb-6">Request details and pricing for the full {{ $series['title'] }} package.</p>
                <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-xl border border-gray-300 bg-gray-50 px-6 py-4 text-sm font-black uppercase tracking-wider text-gray-950 hover:border-yellow-500 hover:text-yellow-700 transition">Request Quote</a>
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
