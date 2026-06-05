<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>Shopping Cart - The Power Loader</title>
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
<body class="min-h-screen bg-white text-slate-950 flex flex-col">
    @include('partials.header')

    <main class="flex-grow px-4 py-12 sm:px-6 lg:px-8 lg:py-16">
        <div class="mx-auto max-w-7xl">
            @if (session('success'))
                <div class="mb-8 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-800">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="mb-8 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-semibold text-red-800">{{ session('error') }}</div>
            @endif

            @if (! $items)
                <div class="rounded-2xl border border-gray-200 px-6 py-20 text-center">
                    <h1 class="text-4xl font-black">Shopping cart</h1>
                    <p class="mt-4 text-lg text-gray-500">Your cart is empty.</p>
                    <a href="{{ route('attachments.index') }}" class="mt-8 inline-flex rounded-lg bg-yellow-600 px-7 py-4 text-sm font-black uppercase tracking-wider text-white hover:bg-yellow-700">Continue Shopping</a>
                </div>
            @else
                <div class="grid gap-14 xl:grid-cols-[500px_1fr]">
                    <section>
                        <h1 class="text-4xl font-black tracking-tight">Shopping cart</h1>
                        <p class="mt-3 text-lg text-gray-500">Store <span class="mx-2">/</span> Shopping cart</p>

                        <div class="mt-8 divide-y divide-gray-200">
                            @foreach ($items as $item)
                                <article class="flex gap-5 py-5 first:pt-0">
                                    <a href="{{ route('product.show', $item['slug']) }}" class="flex h-28 w-28 flex-shrink-0 items-center justify-center bg-gray-50 p-2">
                                        <img src="{{ $item['image'] ?? '' }}" alt="{{ $item['name'] }}" class="max-h-full max-w-full object-contain">
                                    </a>
                                    <div class="min-w-0 flex-grow">
                                        <div class="flex items-start gap-3">
                                            <a href="{{ route('product.show', $item['slug']) }}" class="line-clamp-2 flex-grow text-lg font-semibold leading-7 hover:text-yellow-700">{{ $item['name'] }}</a>
                                            <form method="POST" action="{{ route('cart.items.destroy') }}">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="slug" value="{{ $item['slug'] }}">
                                                <button type="submit" aria-label="Remove item" class="px-1 text-2xl font-light leading-none text-gray-300 transition hover:text-gray-700">&times;</button>
                                            </form>
                                        </div>
                                        <div class="mt-3 flex items-center justify-between gap-4">
                                            <form method="POST" action="{{ route('cart.items.update') }}" class="flex items-center gap-2 text-base">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="slug" value="{{ $item['slug'] }}">
                                                <label for="qty-{{ $loop->index }}" class="font-medium">Qty:</label>
                                                <select id="qty-{{ $loop->index }}" name="quantity" onchange="this.form.submit()" class="bg-transparent py-1 font-medium focus:outline-none">
                                                    @for ($quantity = 1; $quantity <= max(10, $item['quantity']); $quantity++)
                                                        <option value="{{ $quantity }}" @selected($item['quantity'] === $quantity)>{{ $quantity }}</option>
                                                    @endfor
                                                </select>
                                            </form>
                                            <p class="text-sm font-semibold text-gray-500">Pricing hidden in cart</p>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div class="mt-3 rounded-2xl border border-gray-200 bg-gray-50 p-6 text-sm text-gray-600">
                            <p class="font-semibold">Pricing is hidden in the shopping cart.</p>
                            <p class="mt-2">Full order pricing will be available during checkout.</p>
                        </div>

                        <div class="border-b border-gray-200 py-8">
                            <h2 class="text-xl font-black">Apply a promo coupon</h2>
                            <div class="mt-4 flex items-center gap-3 text-base">
                                <i class="fas fa-gift text-gray-500"></i>
                                <span>Promo coupon</span>
                                <span class="font-semibold text-gray-700">Redeem</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-3 py-7 text-base">
                            <a href="{{ route('attachments.index') }}" class="hover:text-yellow-700">Looking for more? <span class="font-semibold">Continue shopping</span></a>
                            <form method="POST" action="{{ route('cart.clear') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-gray-500 hover:text-red-600">Clear cart</button>
                            </form>
                        </div>
                    </section>

                    <section class="max-w-3xl">
                        <h2 class="text-4xl font-black tracking-tight">Checkout</h2>
                        <p class="mt-3 text-lg">Enter your email address. This address will be used to send you order status updates.</p>
                        <form method="GET" action="{{ route('checkout.show') }}" class="mt-8">
                            <label for="checkout-email" class="sr-only">Your email address</label>
                            <input id="checkout-email" type="email" name="email" required placeholder="Your email address" class="h-16 w-full rounded border border-yellow-400 px-4 text-lg focus:border-yellow-600 focus:outline-none">
                            <label class="mt-6 flex items-center gap-3 text-base sm:text-lg">
                                <input type="checkbox" name="offers" value="1" checked class="h-5 w-5 accent-slate-950">
                                <span>Keep me up to date on news and exclusive offers</span>
                            </label>

                            <div class="mt-8 grid gap-5 lg:grid-cols-[540px_1fr] lg:items-start">
                                <div class="space-y-3">
                                    <button type="submit" class="h-16 w-full rounded bg-gray-800 px-10 text-xl font-bold text-white transition hover:bg-gray-950">Checkout</button>
                                    <button type="submit" name="payment" value="link" class="flex h-16 w-full items-center justify-center rounded bg-[#00d66f] px-10 text-xl font-medium text-gray-950 transition hover:bg-[#00c664]">
                                        Pay with <span class="ml-2 font-black"><span class="mr-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-gray-950 text-sm text-white">&#8250;</span>link</span>
                                    </button>
                                    <button type="submit" name="payment" value="paypal" class="flex h-16 w-full items-center justify-center rounded bg-[#ffc439] px-10 text-xl font-semibold text-[#142c8e] transition hover:bg-[#ffb91f]">
                                        <span class="mr-2 text-2xl font-black italic">PayPal</span><span class="text-gray-800">Checkout</span>
                                    </button>
                                </div>
                                <p class="mt-4 flex max-w-sm items-center gap-4 text-base text-gray-500 lg:mt-4"><i class="fas fa-lock text-2xl text-gray-300"></i>All data is transmitted encrypted via a secure TLS connection</p>
                            </div>
                        </form>

                        <div class="mt-14">
                            <h3 class="text-2xl font-black">Next</h3>
                            <div class="mt-4 divide-y divide-gray-200 border-t border-gray-200 text-lg">
                                <div class="py-5"><p class="font-medium">Delivery options</p><p class="text-gray-500">Select how you'll be receiving your order.</p></div>
                                <div class="py-5"><p class="font-medium">Payment information</p><p class="text-gray-500">Choose a payment method and enter your payment details.</p></div>
                                <div class="py-5"><p class="font-medium">Order confirmation</p><p class="text-gray-500">Place your order and receive a confirmation email.</p></div>
                            </div>
                        </div>
                    </section>
                </div>

                @if ($recommendations->isNotEmpty())
                    <section class="mt-16 border-t border-gray-200 pt-12">
                        <h2 class="text-3xl font-black">You may also like</h2>
                        <div class="mt-7 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($recommendations as $product)
                                <article class="flex gap-4 rounded-xl border border-gray-200 p-4">
                                    <a href="{{ route('product.show', $product['slug']) }}" class="flex h-24 w-24 flex-shrink-0 items-center justify-center bg-gray-50 p-2">
                                        <img src="{{ $product['image'] ?? '' }}" alt="{{ $product['name'] }}" class="max-h-full max-w-full object-contain">
                                    </a>
                                    <div class="min-w-0">
                                        <a href="{{ route('product.show', $product['slug']) }}" class="line-clamp-2 text-sm font-bold hover:text-yellow-700">{{ $product['name'] }}</a>
                                        <p class="mt-2 font-black text-gray-500">Quote on request</p>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </section>
                @endif
            @endif
        </div>
    </main>

    @include('partials.footer')
</body>
</html>
