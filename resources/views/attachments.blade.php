<!DOCTYPE html>
<html lang="en">
@php
    $attachmentSections = [
        [
            'type' => 'Mini Excavator',
            'title' => 'X2 Attachments',
            'badge' => 'X2',
            'description' => 'Browse high-performance machinery and professional attachment solutions in the X2 Attachments collection.',
            'url' => route('attachments.x2'),
        ],
        [
            'type' => 'Mini Excavator',
            'title' => 'XXV Attachments',
            'badge' => 'XXV',
            'description' => 'Professional attachment solutions built for Terror XXV mini excavator jobs.',
            'url' => route('attachments.xxv'),
        ],
        [
            'type' => 'Mini Excavator',
            'title' => '2 Ton and Below Attachments',
            'badge' => '2T',
            'description' => 'Maneuverable attachments for compact excavation, landscaping, trenching, and site cleanup.',
            'url' => route('attachments.mini-excavators-2-tons-and-below'),
        ],
        [
            'type' => 'Mini Excavator',
            'title' => 'Mini Excavator Attachments',
            'badge' => 'ME',
            'description' => 'Browse all buckets, breakers, augers, grapples, couplers, and mini excavator packages.',
            'url' => route('attachments.mini-excavator'),
        ],
        [
            'type' => 'Skid Steer Loader',
            'title' => 'Compact Series 501-507 Attachments',
            'badge' => '501',
            'description' => 'Compact skid steer attachment solutions for tight jobsites and material handling.',
            'url' => route('attachments.skid-steer.series', ['series' => 'compact-series']),
        ],
        [
            'type' => 'Skid Steer Loader',
            'title' => 'Standard Series (X1300-509) Attachments',
            'badge' => 'X13',
            'description' => 'Standard series attachments for STOMP X1300 and STOMP 509 skid steer loader workflows.',
            'url' => route('attachments.skid-steer.series', ['series' => 'standard-series']),
        ],
    ];
@endphp
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>Attachments - Skoop Loaders</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white text-gray-950">
    @include('partials.header')

    <main class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-yellow-600">Attachments</p>
                <h1 class="mt-4 text-4xl sm:text-5xl font-black text-gray-950">Premium attachments for every loader and excavator</h1>
                <p class="mt-4 text-gray-600 max-w-3xl mx-auto">Explore category pages for mini excavator attachments, skid steer tools, and specialized worksite equipment built to enhance productivity.</p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($attachmentSections as $section)
                    <a href="{{ $section['url'] }}" class="group block border border-gray-200 bg-white p-7 shadow-sm transition hover:-translate-y-1 hover:border-yellow-400 hover:shadow-lg">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-yellow-600 text-xs uppercase tracking-[0.28em] font-black mb-3">{{ $section['type'] }}</p>
                                <h2 class="text-2xl font-black text-gray-950">{{ $section['title'] }}</h2>
                            </div>
                            <div class="inline-flex h-12 w-12 shrink-0 items-center justify-center bg-yellow-50 text-sm font-black text-yellow-700">{{ $section['badge'] }}</div>
                        </div>
                        <p class="mt-5 text-gray-600">{{ $section['description'] }}</p>
                    </a>
                @endforeach
            </div>
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
