<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>Order Confirmed - Skoop Loaders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen bg-gray-50 text-gray-950 flex flex-col">
    @include('partials.header')
    <main class="flex-grow px-4 py-12 sm:px-6">
        <div class="mx-auto max-w-3xl">
            <section class="rounded-3xl border border-gray-200 bg-white p-7 shadow-sm sm:p-10">
                <span class="mb-6 inline-flex h-16 w-16 items-center justify-center rounded-full bg-green-50 text-2xl text-green-600"><i class="fas fa-check"></i></span>
                <p class="mb-2 text-xs font-black uppercase tracking-[0.22em] text-blue-600">Order Received</p>
                <h1 class="text-3xl font-black">Thank you, {{ $order['customer']['name'] }}.</h1>
                <p class="mt-4 text-gray-600">Your equipment order <strong class="text-gray-950">{{ $order['number'] }}</strong> was submitted on {{ $order['placed_at'] }}.</p>

                <div class="mt-8 overflow-hidden rounded-2xl border border-gray-200">
                    @foreach ($order['items'] as $item)
                        <div class="flex items-center justify-between gap-4 border-b border-gray-100 px-5 py-4 last:border-0">
                            <div>
                                <p class="font-bold">{{ $item['name'] }}</p>
                                <p class="text-sm text-gray-500">Quantity: {{ $item['quantity'] }}</p>
                            </div>
                            <p class="whitespace-nowrap font-black">${{ number_format($item['line_total'], 2) }}</p>
                        </div>
                    @endforeach
                    <div class="flex justify-between bg-gray-50 px-5 py-5 text-lg font-black">
                        <span>Subtotal</span>
                        <span>${{ number_format($order['subtotal'], 2) }}</span>
                    </div>
                </div>
                <a href="{{ route('equipment') }}" class="mt-8 inline-flex rounded-xl bg-blue-600 px-7 py-4 text-sm font-black uppercase tracking-wider text-white hover:bg-blue-700">Continue Shopping</a>
            </section>
        </div>
    </main>
    @include('partials.footer')
</body>
</html>
