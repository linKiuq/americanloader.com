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
        'title' => $product['name'] . ' | American Loader',
        'description' => $productDescription,
        'type' => 'product',
        'image' => $product['image'] ?? null,
        'imageAlt' => ($product['name'] ?? 'American Loader equipment') . ' product image',
        'keywords' => array_filter([
            $product['name'] ?? null,
            $product['category'] ?? null,
            'American Loader',
            'TYPHON equipment',
            ($product['category'] ?? 'heavy equipment') . ' for sale',
        ]),
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
            'sku' => $product['sku'] ?? null,
            'itemCondition' => 'https://schema.org/NewCondition',
        ],
    ])
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .product-description h2 {
            margin: 2.25rem 0 0.85rem;
            color: #071d38;
            font-size: clamp(1.45rem, 2vw, 2rem);
            font-weight: 900;
            line-height: 1.2;
        }
        .product-description h2:first-child { margin-top: 0; }
        .product-description h3 {
            margin: 1.75rem 0 0.65rem;
            color: #0b2d55;
            font-size: 1.2rem;
            font-weight: 800;
            line-height: 1.35;
        }
        .product-description h4 {
            margin: 1.35rem 0 0.5rem;
            color: #1f2937;
            font-size: 1rem;
            font-weight: 800;
        }
        .product-description p {
            margin: 0.85rem 0;
            color: #4b5563;
            line-height: 1.85;
        }
        .product-description ul,
        .product-description ol {
            margin: 1rem 0 1.4rem 1.35rem;
            color: #4b5563;
        }
        .product-description ul { list-style: disc; }
        .product-description ol { list-style: decimal; }
        .product-description li {
            margin: 0.55rem 0;
            padding-left: 0.35rem;
            line-height: 1.7;
        }
        .product-description strong { color: #0b2d55; font-weight: 800; }
    </style>
</head>
<body class="min-h-screen bg-white text-[#071d38] flex flex-col">
    @include('partials.header')

    <main class="flex-grow px-4 py-8 sm:px-6 lg:px-10 lg:py-10 2xl:px-14">
        <div class="mx-auto w-full max-w-[1536px]">
            @if (session('success'))
                <div class="mb-7 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-800">{{ session('success') }}</div>
            @endif
            <div class="mb-8">
                <a href="{{ route('equipment') }}" class="text-sm font-bold text-red-700 transition hover:text-red-800"><i class="fas fa-arrow-left mr-2"></i>Back to Equipment</a>
            </div>
            @php $images = array_values(array_filter($product['images'] ?? [$product['image'] ?? null])); @endphp
            <div class="grid grid-cols-1 items-start gap-8 xl:grid-cols-[minmax(0,1.25fr)_minmax(400px,0.75fr)] 2xl:gap-12">
                <section>
                    <div class="grid gap-4 lg:grid-cols-[88px_minmax(0,1fr)]">
                        @if (count($images) > 1)
                            <div class="order-2 flex gap-3 overflow-x-auto pb-2 lg:order-1 lg:max-h-[560px] lg:flex-col lg:overflow-x-visible lg:overflow-y-auto lg:pr-1">
                                @foreach ($images as $image)
                                    <button type="button" class="gallery-thumb h-20 w-20 flex-none rounded-xl border-2 {{ $loop->first ? 'border-red-500' : 'border-gray-200' }} bg-white p-1.5 transition hover:border-red-500" data-image="{{ $image }}">
                                        <img src="{{ $image }}" alt="{{ $product['name'] }} image {{ $loop->iteration }}" class="h-full w-full rounded-lg object-contain">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                        <div class="{{ count($images) > 1 ? 'order-1 lg:order-2' : 'lg:col-span-2' }} flex min-h-[420px] items-center justify-center rounded-2xl border border-gray-200 bg-white p-5 shadow-sm lg:min-h-[560px] 2xl:min-h-[640px]">
                            @if ($images[0] ?? null)
                                <img id="main-product-image" src="{{ $images[0] }}" alt="{{ $product['name'] }}" class="max-h-[520px] w-full rounded-xl object-contain 2xl:max-h-[600px]">
                            @else
                                <div class="flex h-[440px] items-center justify-center text-6xl text-gray-300"><i class="fas fa-truck-monster"></i></div>
                            @endif
                        </div>
                    </div>
                    <div class="mt-4 grid grid-cols-1 overflow-hidden rounded-xl border border-gray-200 bg-gray-50 sm:grid-cols-3">
                        <div class="flex items-center justify-center gap-2 border-b border-gray-200 px-4 py-3 text-xs font-bold text-gray-700 sm:border-b-0 sm:border-r">
                            <i class="fas fa-shield-halved text-red-700"></i> Genuine Equipment
                        </div>
                        <div class="flex items-center justify-center gap-2 border-b border-gray-200 px-4 py-3 text-xs font-bold text-gray-700 sm:border-b-0 sm:border-r">
                            <i class="fas fa-tags text-red-700"></i> Quote Support
                        </div>
                        <div class="flex items-center justify-center gap-2 px-4 py-3 text-xs font-bold text-gray-700">
                            <i class="fas fa-lock text-red-700"></i> Secure Checkout
                        </div>
                    </div>
                    <div class="mt-4 flex flex-col gap-4 rounded-xl border border-red-200 bg-red-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
                        <div class="flex items-start gap-3">
                            <span class="mt-0.5 flex h-9 w-9 flex-none items-center justify-center rounded-full bg-red-500 text-[#071d38]">
                                <i class="fas fa-headset"></i>
                            </span>
                            <div>
                                <h3 class="font-black text-[#071d38]">Need help choosing the right configuration?</h3>
                                <p class="mt-1 text-sm leading-6 text-gray-600">Our equipment team can help confirm machine details, attachments, and compatibility.</p>
                            </div>
                        </div>
                        <a href="{{ route('contact') }}" class="inline-flex flex-none items-center justify-center rounded-lg border border-[#071d38] bg-[#071d38] px-5 py-3 text-xs font-black uppercase tracking-wider text-white transition hover:bg-[#0b2d55]">
                            Contact Us
                        </a>
                    </div>
                </section>

                <section class="xl:sticky xl:top-28">
                    <p class="mb-3 inline-flex rounded bg-red-100 px-2 py-1 text-xs font-black uppercase tracking-[0.22em] text-red-800">{{ $product['category'] ?? 'Product' }}</p>
                    <h1 class="text-3xl font-black leading-tight sm:text-4xl">{{ $product['name'] }}</h1>
                    <div class="mt-7 border-l-4 border-red-500 pl-5">
                        <h2 class="text-lg font-black text-[#071d38]">Product Overview</h2>
                        <p class="mt-2 leading-relaxed text-gray-600">{{ $product['desc'] ?? 'High quality equipment designed for reliable daily work.' }}</p>
                    </div>
                    <p class="mt-6 text-2xl font-black text-gray-500">Quote on request</p>

                    <div class="mt-7 grid gap-3 sm:grid-cols-2">
                        <div class="rounded-xl border border-gray-200 bg-white p-4">
                            <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">Category</h3>
                            <p class="mt-2 font-semibold text-[#071d38]">{{ $product['category'] ?? 'Equipment' }}</p>
                        </div>
                        <div class="rounded-xl border border-gray-200 bg-white p-4">
                            <h3 class="text-xs font-semibold uppercase tracking-[0.2em] text-gray-500">Condition</h3>
                            <p class="mt-2 font-semibold text-[#071d38]">New</p>
                        </div>
                    </div>

                    <div class="mt-7 space-y-3 border-t border-gray-200 pt-7">
                        <a href="{{ $product['checkoutUrl'] ?? route('store') }}" class="inline-flex w-full items-center justify-center rounded-lg bg-red-700 px-7 py-4 text-sm font-black uppercase tracking-wider text-white transition hover:bg-red-800">Explore Product</a>
                        <div class="grid grid-cols-2 gap-3">
                            <form method="POST" action="{{ route('cart.items.store') }}">
                                @csrf
                                <input type="hidden" name="slug" value="{{ $product['slug'] }}">
                                <button type="submit" class="inline-flex w-full items-center justify-center rounded-lg border border-[#071d38] bg-[#071d38] px-5 py-3.5 text-xs font-black uppercase tracking-wider text-white transition hover:bg-[#0b2d55]">Add to Cart</button>
                            </form>
                            <a href="{{ route('cart') }}" class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-5 py-3.5 text-xs font-black uppercase tracking-wider text-[#071d38] transition hover:border-red-500">View Cart</a>
                        </div>
                    </div>
                    <div class="mt-5 rounded-xl bg-gray-50 px-5 py-4 text-center text-xs font-semibold text-gray-600">
                        <i class="fas fa-shield-halved mr-2 text-red-700"></i>Guaranteed safe and secure checkout
                    </div>
                </section>
            </div>

            <section class="mt-10 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 bg-gray-50 px-4 sm:px-6">
                    <h2 class="inline-block border-b-2 border-red-500 px-2 py-5 text-sm font-black uppercase tracking-wider text-[#071d38]">Description</h2>
                </div>
                <div class="p-5 sm:p-8 lg:p-10">
                    <div class="product-description max-w-none">
                        @if (!empty($product['fullDescHtml']))
                            {!! $product['fullDescHtml'] !!}
                        @else
                            <p>{{ $product['fullDesc'] ?? $product['desc'] ?? 'High quality equipment designed for reliable daily work.' }}</p>
                        @endif
                    </div>
                </div>
            </section>

            @if ($relatedProducts->isNotEmpty())
                <section class="mt-16">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.28em] text-red-700">Related Equipment</p>
                            <h2 class="mt-3 text-3xl font-black">You may also like</h2>
                        </div>
                        <a href="{{ route('equipment') }}" class="text-sm font-bold text-red-700 hover:text-red-900">Browse all equipment</a>
                    </div>
                    <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($relatedProducts as $related)
                            <article class="rounded-3xl border border-gray-200 bg-white p-5 shadow-sm transition hover:border-red-500 hover:shadow-lg">
                                <a href="{{ route('product.show', $related['slug']) }}" class="block overflow-hidden rounded-2xl bg-gray-50">
                                    <img src="{{ $related['image'] ?? '' }}" alt="{{ $related['name'] }}" class="h-48 w-full object-contain">
                                </a>
                                <a href="{{ route('product.show', $related['slug']) }}" class="mt-5 block text-lg font-bold hover:text-red-700">{{ $related['name'] }}</a>
                                <div class="mt-5 flex items-center justify-between">
                                    <span class="font-black text-gray-500">Quote on request</span>
                                    <a href="{{ route('product.show', $related['slug']) }}" class="text-sm font-semibold text-red-700">View</a>
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
                document.querySelectorAll('.gallery-thumb').forEach(thumb => thumb.classList.remove('border-red-500'));
                button.classList.add('border-red-500');
            });
        });
    </script>
</body>
</html>
