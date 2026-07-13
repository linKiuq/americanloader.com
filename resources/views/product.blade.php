<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    @php
        $productDescription = \Illuminate\Support\Str::limit(strip_tags($product['fullDesc'] ?? $product['desc'] ?? 'Heavy equipment for sale from The Power Loader.'), 155);
    @endphp
    @include('partials.seo', [
        'title' => $product['name'] . ' | The Power Loader',
        'description' => $productDescription,
        'type' => 'product',
        'image' => $product['image'] ?? null,
        'jsonLd' => [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product['name'],
            'description' => $productDescription,
            'image' => $product['images'] ?? [$product['image'] ?? config('seo.default_image')],
            'brand' => [
                '@type' => 'Brand',
                'name' => 'TYPHON',
            ],
            'category' => $product['category'] ?? 'Heavy Equipment',
            'url' => config('seo.site_url') . '/product/' . $product['slug'],
        ],
    ])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-white text-gray-950 flex flex-col">
    @include('partials.header')

    <main class="flex-grow px-4 py-10 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            @if (session('success'))
                <div class="mb-7 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-800">{{ session('success') }}</div>
            @endif
            <div class="mb-8">
                <a href="{{ route('equipment') }}" class="text-sm font-bold text-yellow-600 transition hover:text-yellow-700"><i class="fas fa-arrow-left mr-2"></i>Back to Equipment</a>
            </div>
            <div class="grid grid-cols-1 items-start gap-10 lg:grid-cols-[1.25fr_0.95fr]">
                <section>
                    @php $images = $product['images'] ?? [$product['image'] ?? null]; @endphp
                    <div class="rounded-[2rem] border border-gray-200 bg-gray-50 p-4 shadow-sm">
                        @if ($images[0] ?? null)
                            <img id="main-product-image" src="{{ $images[0] }}" alt="{{ $product['name'] }}" class="w-full rounded-[1.5rem] object-contain">
                        @else
                            <div class="flex h-[440px] items-center justify-center rounded-[1.5rem] bg-white text-6xl text-gray-300"><i class="fas fa-truck-monster"></i></div>
                        @endif
                    </div>
                    @if (count($images) > 1)
                        <div class="mt-4 grid grid-cols-4 gap-3">
                            @foreach ($images as $image)
                                <button type="button" class="gallery-thumb rounded-3xl border {{ $loop->first ? 'border-yellow-500' : 'border-gray-200' }} bg-white p-2 transition" data-image="{{ $image }}">
                                    <img src="{{ $image }}" alt="{{ $product['name'] }} image {{ $loop->iteration }}" class="h-20 w-full rounded-xl object-contain">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </section>
                <section>
                    <p class="mb-3 text-sm font-semibold uppercase tracking-[0.28em] text-yellow-600">{{ $product['category'] ?? 'Product' }}</p>
                    <h1 class="text-4xl font-black leading-tight">{{ $product['name'] }}</h1>
                    <p class="mt-4 text-3xl font-black text-gray-500">Quote on request</p>
                    <div class="mt-8 space-y-6 text-gray-600">
                        <div>
                            <h2 class="mb-3 text-lg font-bold text-gray-950">Overview</h2>
                            <p class="leading-relaxed">{{ $product['fullDesc'] ?? $product['desc'] ?? 'High quality equipment designed for reliable daily work.' }}</p>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2">
                            <div class="rounded-3xl border border-gray-200 bg-white p-5">
                                <p class="text-sm uppercase tracking-[0.24em] text-gray-500">Category</p>
                                <p class="mt-3 font-semibold text-gray-950">{{ $product['category'] ?? 'Equipment' }}</p>
                            </div>
                            <div class="rounded-3xl border border-gray-200 bg-white p-5">
                                <p class="text-sm uppercase tracking-[0.24em] text-gray-500">Condition</p>
                                <p class="mt-3 font-semibold text-gray-950">New</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-10 flex flex-col gap-3 sm:flex-row">
                        <form method="POST" action="{{ route('cart.items.store') }}">
                            @csrf
                            <input type="hidden" name="slug" value="{{ $product['slug'] }}">
                            <button type="submit" class="inline-flex w-full items-center justify-center rounded-2xl border border-gray-950 bg-gray-950 px-7 py-4 text-sm font-black uppercase tracking-wider text-white transition hover:bg-gray-800">Add to Cart</button>
                        </form>
                        <a href="{{ $product['checkoutUrl'] ?? route('store') }}" class="inline-flex items-center justify-center rounded-2xl bg-yellow-600 px-7 py-4 text-sm font-black uppercase tracking-wider text-white transition hover:bg-yellow-700">Buy Now</a>
                        <a href="{{ route('cart') }}" class="inline-flex items-center justify-center rounded-2xl border border-gray-300 bg-white px-7 py-4 text-sm font-black uppercase tracking-wider text-gray-950 transition hover:border-yellow-500">View Cart</a>
                    </div>
                </section>
            </div>

            @if ($relatedProducts->isNotEmpty())
                <section class="mt-16">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-yellow-600">Related Equipment</p>
                            <h2 class="mt-3 text-3xl font-black">You may also like</h2>
                        </div>
                        <a href="{{ route('equipment') }}" class="text-sm font-bold text-yellow-600 hover:text-yellow-800">Browse all equipment</a>
                    </div>
                    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($relatedProducts as $related)
                            <article class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-yellow-500 hover:shadow-lg">
                                <a href="{{ route('product.show', $related['slug']) }}" class="block overflow-hidden rounded-2xl bg-gray-50">
                                    <img src="{{ $related['image'] ?? '' }}" alt="{{ $related['name'] }}" class="h-48 w-full object-contain">
                                </a>
                                <a href="{{ route('product.show', $related['slug']) }}" class="mt-5 block text-lg font-bold hover:text-yellow-600">{{ $related['name'] }}</a>
                                <div class="mt-5 flex items-center justify-between">
                                    <span class="font-black text-gray-500">Quote on request</span>
                                    <a href="{{ route('product.show', $related['slug']) }}" class="text-sm font-semibold text-yellow-600">View</a>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </main>

    @include('partials.footer')

    <script>
        document.querySelectorAll('.gallery-thumb').forEach(button => {
            button.addEventListener('click', () => {
                document.getElementById('main-product-image').src = button.dataset.image;
                document.querySelectorAll('.gallery-thumb').forEach(thumb => thumb.classList.remove('border-yellow-500'));
                button.classList.add('border-yellow-500');
            });
        });
    </script>
</body>
</html>
