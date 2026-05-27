<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>Checkout - Skoop Loaders</title>
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
            <div class="grid gap-14 xl:grid-cols-[500px_1fr]">
                <aside>
                    <h1 class="text-4xl font-black tracking-tight">Shopping cart</h1>
                    <p class="mt-3 text-lg text-gray-500">Store <span class="mx-2">/</span> Shopping cart <span class="mx-2">/</span> Checkout</p>
                    <div class="mt-8 divide-y divide-gray-200">
                        @foreach ($items as $item)
                            <div class="flex gap-4 py-5 first:pt-0">
                                <img src="{{ $item['image'] ?? '' }}" alt="{{ $item['name'] }}" class="h-24 w-24 bg-gray-50 object-contain p-2">
                                <div class="min-w-0 flex-grow">
                                    <p class="line-clamp-2 text-base font-semibold">{{ $item['name'] }}</p>
                                    <div class="mt-3 flex justify-between text-base">
                                        <span>Qty: {{ $item['quantity'] }}</span>
                                        <span class="font-semibold">${{ number_format($item['line_total'], 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <dl class="mt-3 space-y-4 border-y border-gray-200 py-7 text-lg">
                        <div class="flex justify-between"><dt>Subtotal</dt><dd>${{ number_format($subtotal, 2) }}</dd></div>
                        <div class="flex justify-between"><dt>Shipping</dt><dd>Free</dd></div>
                        <div class="flex justify-between text-2xl font-black"><dt>TOTAL</dt><dd>${{ number_format($subtotal, 2) }}</dd></div>
                    </dl>
                    <a href="{{ route('cart') }}" class="mt-7 inline-flex text-base font-semibold text-blue-700 hover:text-blue-800"><i class="fas fa-arrow-left mr-3 mt-1"></i>Return to cart</a>
                </aside>

                <section class="max-w-3xl">
                    <h2 class="text-4xl font-black tracking-tight">Checkout</h2>
                    <p class="mt-3 text-lg">Enter your delivery information to complete your equipment order.</p>

                    <form method="POST" action="{{ route('checkout.store') }}" class="mt-8">
                        @csrf
                        @if ($paymentPreference === 'link' || $paymentPreference === 'paypal')
                            <div class="mb-6 rounded border border-blue-100 bg-blue-50 px-5 py-4 text-sm text-blue-800">
                                {{ $paymentPreference === 'link' ? 'Link' : 'PayPal' }} selected. Complete your delivery details to continue with order processing.
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="mb-6 rounded border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">Please complete the required checkout information.</div>
                        @endif

                        <label class="block">
                            <span class="sr-only">Your email address</span>
                            <input type="email" name="email" value="{{ old('email', $email) }}" required placeholder="Your email address" class="h-16 w-full rounded border {{ $errors->has('email') ? 'border-red-400' : 'border-blue-400' }} px-4 text-lg focus:border-blue-600 focus:outline-none">
                            @error('email')<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                        </label>
                        <label class="mt-5 flex items-center gap-3 text-lg">
                            <input type="checkbox" name="offers" value="1" checked class="h-5 w-5 accent-slate-950">
                            <span>Keep me up to date on news and exclusive offers</span>
                        </label>

                        <h3 class="mt-10 border-b border-gray-200 pb-4 text-2xl font-black">Delivery options</h3>
                        <div class="mt-6 grid gap-4 sm:grid-cols-2">
                            @foreach (['name' => 'Full name', 'phone' => 'Phone number', 'company' => 'Company (optional)', 'address' => 'Delivery address', 'city' => 'City', 'state' => 'State', 'zip' => 'ZIP code'] as $field => $label)
                                <label class="{{ $field === 'address' ? 'sm:col-span-2' : '' }}">
                                    <span class="mb-2 block text-sm font-semibold text-gray-700">{{ $label }}</span>
                                    <input type="text" name="{{ $field }}" value="{{ old($field) }}" {{ $field === 'company' ? '' : 'required' }} class="h-13 w-full rounded border {{ $errors->has($field) ? 'border-red-400' : 'border-gray-300' }} px-4 py-3 text-base focus:border-blue-500 focus:outline-none">
                                    @error($field)<span class="mt-1 block text-xs text-red-600">{{ $message }}</span>@enderror
                                </label>
                            @endforeach
                            <label class="sm:col-span-2">
                                <span class="mb-2 block text-sm font-semibold text-gray-700">Order notes (optional)</span>
                                <textarea name="notes" rows="3" class="w-full rounded border border-gray-300 px-4 py-3 text-base focus:border-blue-500 focus:outline-none">{{ old('notes') }}</textarea>
                            </label>
                        </div>

                        <h3 class="mt-9 border-b border-gray-200 pb-4 text-2xl font-black">Order confirmation</h3>
                        <div class="mt-6 grid gap-4 lg:grid-cols-[1fr_auto] lg:items-center">
                            <button type="submit" class="h-16 rounded bg-gray-800 px-10 text-xl font-bold text-white transition hover:bg-gray-950">Place order</button>
                            <p class="flex max-w-sm items-center gap-4 text-base text-gray-500"><i class="fas fa-lock text-2xl text-gray-300"></i>All data is transmitted encrypted via a secure TLS connection</p>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </main>
    @include('partials.footer')
</body>
</html>
