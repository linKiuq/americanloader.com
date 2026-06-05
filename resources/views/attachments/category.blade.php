<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} - The Power Loader</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
            overflow: hidden;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50 text-gray-950 flex flex-col">
    @include('partials.header')

    <main class="flex-grow">
        <section class="border-b border-gray-200 bg-white">
            <div class="mx-auto max-w-7xl px-4 py-5 text-sm text-gray-500 sm:px-6 lg:px-8">
                <a href="{{ route('welcome') }}" class="hover:text-yellow-600">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('equipment') }}" class="hover:text-yellow-600">Equipment</a>
                <span class="mx-2">/</span>
                <span class="font-semibold text-gray-800">Attachments</span>
            </div>
        </section>

        <section class="border-b border-gray-200 bg-gradient-to-r from-slate-950 to-slate-800 text-white">
            <div class="mx-auto grid max-w-7xl gap-8 px-4 py-12 sm:px-6 lg:grid-cols-[1fr_auto] lg:items-center lg:px-8">
                <div>
                    <p class="mb-3 text-xs font-black uppercase tracking-[0.3em] text-yellow-300">Attachment Shop</p>
                    <h1 class="text-3xl font-black sm:text-5xl">{{ $title }}</h1>
                    <p class="mt-5 max-w-3xl text-base leading-7 text-slate-300">{{ $description }}</p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-2xl border border-white/10 bg-white/10 px-6 py-5 text-center">
                        <p class="text-3xl font-black">{{ $attachmentCounts->sum() }}</p>
                        <p class="mt-1 text-xs uppercase tracking-wider text-slate-300">Products</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/10 px-6 py-5 text-center">
                        <p class="text-3xl font-black">2</p>
                        <p class="mt-1 text-xs uppercase tracking-wider text-slate-300">Categories</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-7 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-800">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                    <a href="{{ route('cart') }}" class="ml-auto whitespace-nowrap font-black text-yellow-700">View Cart</a>
                </div>
            @endif

            <div class="grid gap-8 lg:grid-cols-[270px_1fr]">
                <aside class="space-y-6">
                    <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                        <h2 class="mb-5 text-sm font-black uppercase tracking-[0.2em]">Product Categories</h2>
                        <nav class="space-y-2 text-sm">
                            <a href="{{ route('attachments.index') }}" class="flex items-center justify-between rounded-xl px-3 py-3 {{ request()->routeIs('attachments.index') ? 'bg-yellow-50 font-bold text-yellow-700' : 'text-gray-600 hover:bg-gray-50 hover:text-yellow-700' }}">
                                <span>All Attachments</span>
                                <span>{{ $attachmentCounts->sum() }}</span>
                            </a>
                            <a href="{{ route('attachments.mini-excavator') }}" class="flex items-center justify-between rounded-xl px-3 py-3 {{ request()->routeIs('attachments.mini-excavator*') ? 'bg-yellow-50 font-bold text-yellow-700' : 'text-gray-600 hover:bg-gray-50 hover:text-yellow-700' }}">
                                <span>Mini Excavator</span>
                                <span>{{ $attachmentCounts->get('Mini Excavator Attachments', 0) }}</span>
                            </a>
                            <a href="{{ route('attachments.skid-steer') }}" class="flex items-center justify-between rounded-xl px-3 py-3 {{ request()->routeIs('attachments.skid-steer*') ? 'bg-yellow-50 font-bold text-yellow-700' : 'text-gray-600 hover:bg-gray-50 hover:text-yellow-700' }}">
                                <span>Skid Steer</span>
                                <span>{{ $attachmentCounts->get('Skid Steer Attachments', 0) }}</span>
                            </a>
                        </nav>
                    </div>

                    <div class="rounded-2xl bg-yellow-600 p-6 text-white">
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-yellow-100">Need Compatibility Help?</p>
                        <h2 class="mt-3 text-xl font-black">Find the right fit</h2>
                        <p class="mt-3 text-sm leading-6 text-yellow-100">Our equipment team can confirm couplers, hydraulic flow, and machine compatibility.</p>
                        <a href="{{ route('contact') }}" class="mt-5 inline-flex rounded-lg bg-white px-5 py-3 text-xs font-black uppercase tracking-wider text-yellow-700">Contact Sales</a>
                    </div>
                </aside>

                <section>
                    <form method="GET" action="{{ url()->current() }}" class="mb-7 flex flex-col gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                        <p class="text-sm text-gray-600">
                            @if ($productCount)
                                Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of <strong>{{ $productCount }}</strong> results
                            @else
                                No products found
                            @endif
                        </p>
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <label class="relative">
                                <i class="fas fa-search absolute left-3.5 top-3.5 text-xs text-gray-400"></i>
                                <input name="search" value="{{ $search }}" type="search" placeholder="Search attachments" class="w-full rounded-lg border border-gray-300 py-2.5 pl-9 pr-3 text-sm focus:border-yellow-500 focus:outline-none sm:w-52">
                            </label>
                            <select name="sort" onchange="this.form.submit()" class="rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm focus:border-yellow-500 focus:outline-none">
                                <option value="featured" @selected($sort === 'featured')>Default sorting</option>
                                <option value="price-low" @selected($sort === 'price-low')>Price: low to high</option>
                                <option value="price-high" @selected($sort === 'price-high')>Price: high to low</option>
                                <option value="name" @selected($sort === 'name')>Sort by name</option>
                            </select>
                            <button type="submit" class="rounded-lg bg-gray-950 px-4 py-2.5 text-xs font-black uppercase tracking-wider text-white hover:bg-yellow-700">Filter</button>
                        </div>
                    </form>

                    @if ($products->isEmpty())
                        <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-6 py-20 text-center">
                            <h2 class="text-xl font-black">No matching attachments</h2>
                            <p class="mt-2 text-gray-600">Try a broader search term or browse all available attachments.</p>
                            <a href="{{ route('attachments.index') }}" class="mt-6 inline-flex rounded-lg bg-yellow-600 px-6 py-3 text-sm font-bold text-white">View All Attachments</a>
                        </div>
                    @else
                        <div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                            @foreach ($products as $product)
                                <article class="group flex flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:border-yellow-300 hover:shadow-lg">
                                    <a href="{{ route('product.show', $product['slug']) }}" class="relative flex h-56 items-center justify-center overflow-hidden bg-gray-50 p-5">
                                        <img src="{{ $product['image'] ?? '' }}" alt="{{ $product['name'] }}" loading="lazy" class="max-h-full max-w-full object-contain transition duration-300 group-hover:scale-105">
                                        <span class="absolute left-4 top-4 rounded-full bg-white px-3 py-1 text-[10px] font-black uppercase tracking-wider text-yellow-700 shadow-sm">{{ str_replace(' Attachments', '', $product['category']) }}</span>
                                    </a>
                                    <div class="flex flex-grow flex-col p-5">
                                        <div class="mb-2 text-xs text-amber-500" aria-label="Rated 5 out of 5">
                                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                        </div>
                                        <a href="{{ route('product.show', $product['slug']) }}" class="line-clamp-2 min-h-[3rem] text-sm font-bold leading-6 transition hover:text-yellow-700">{{ $product['name'] }}</a>
                                        <p class="mt-3 text-xl font-black text-gray-500">Quote on request</p>
                                        <div class="mt-auto flex gap-2 pt-5">
                                            <form method="POST" action="{{ route('cart.items.store') }}" class="flex-1">
                                                @csrf
                                                <input type="hidden" name="slug" value="{{ $product['slug'] }}">
                                                <button type="submit" class="w-full rounded-lg bg-yellow-600 px-3 py-3 text-xs font-black uppercase tracking-wider text-white transition hover:bg-yellow-700">Add to Cart</button>
                                            </form>
                                            <a href="{{ $product['checkoutUrl'] ?? route('store') }}" class="flex-1 rounded-lg border border-gray-300 px-3 py-3 text-center text-xs font-black uppercase tracking-wider text-gray-700 transition hover:border-yellow-600 hover:text-yellow-700">Buy Now</a>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        @if ($products->hasPages())
                            <nav class="mt-10 flex items-center justify-between border-t border-gray-200 pt-7" aria-label="Pagination">
                                @if ($products->onFirstPage())
                                    <span class="rounded-lg border border-gray-200 px-5 py-3 text-sm font-bold text-gray-300">Previous</span>
                                @else
                                    <a href="{{ $products->previousPageUrl() }}" class="rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-bold hover:border-yellow-500 hover:text-yellow-700">Previous</a>
                                @endif
                                <span class="text-sm font-semibold text-gray-600">Page {{ $products->currentPage() }} of {{ $products->lastPage() }}</span>
                                @if ($products->hasMorePages())
                                    <a href="{{ $products->nextPageUrl() }}" class="rounded-lg border border-gray-300 bg-white px-5 py-3 text-sm font-bold hover:border-yellow-500 hover:text-yellow-700">Next</a>
                                @else
                                    <span class="rounded-lg border border-gray-200 px-5 py-3 text-sm font-bold text-gray-300">Next</span>
                                @endif
                            </nav>
                        @endif
                    @endif
                </section>
            </div>
        </section>
    </main>

    @include('partials.footer')
</body>
</html>
