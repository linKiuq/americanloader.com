<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>About - The Power Loader</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white text-gray-950 flex flex-col">
    @include('partials.header')

    <main class="flex-grow">
        <section class="bg-gradient-to-br from-white via-white to-yellow-50 px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <p class="mb-4 text-xs font-black uppercase tracking-[0.3em] text-yellow-600">About Us</p>
                <h1 class="max-w-4xl text-4xl font-black tracking-tight text-gray-950 sm:text-5xl">Typhon machinery information without made-up details</h1>
                <p class="mt-6 max-w-3xl text-lg leading-8 text-gray-600">
                    The Power Loader presents construction equipment and attachments using verified Typhon Machinery information, including mini excavators, compactor rollers, forklifts, wheel loaders, skid steer loaders, attachments, and parts.
                </p>
            </div>
        </section>

        <section class="px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto grid max-w-7xl gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
                <div>
                    <h2 class="text-3xl font-black text-gray-950">About The Equipment</h2>
                    <p class="mt-5 text-base leading-8 text-gray-600">
                        Typhon Machinery describes its catalog as construction equipment and attachments built for productivity, reliability, and jobsite performance. The product range includes compact mini excavators for tight-space digging, skid steer loaders for flexible construction work, and attachments that help expand what excavators and skid steer loaders can do.
                    </p>
                    <p class="mt-5 text-base leading-8 text-gray-600">
                        Product availability, specifications, pricing, delivery, warranty, and compatibility should always be confirmed before purchase. If you need help choosing equipment, use the contact form and include your machine type, intended work, and any attachment requirements.
                    </p>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="border border-gray-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-black text-gray-950">Mini Excavators</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Compact machines designed for digging and excavation work where space is limited.</p>
                    </div>
                    <div class="border border-gray-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-black text-gray-950">Skid Steer Loaders</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Flexible loaders for material handling, site work, landscaping, and daily construction tasks.</p>
                    </div>
                    <div class="border border-gray-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-black text-gray-950">Attachments</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Mini excavator and skid steer attachments organized by machine type, size, and series.</p>
                    </div>
                    <div class="border border-gray-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-black text-gray-950">Support</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Sales and technical questions can be sent through the verified email contacts listed below.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-y border-gray-200 bg-gray-50 px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <h2 class="text-3xl font-black text-gray-950">Verified Contact Information</h2>
                <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                    <div class="border border-gray-200 bg-white p-6">
                        <h3 class="text-sm font-black uppercase tracking-wider text-gray-500">Address</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-700">2522 S Malt Ave. Commerce, CA 90040 United States</p>
                    </div>
                    <div class="border border-gray-200 bg-white p-6">
                        <h3 class="text-sm font-black uppercase tracking-wider text-gray-500">Sales</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-700"><a href="mailto:sales@typhonmachinery.com" class="hover:text-yellow-600">sales@typhonmachinery.com</a></p>
                        <p class="mt-1 text-sm leading-6 text-gray-700"><a href="tel:+12132142203" class="hover:text-yellow-600">+1 213-214-2203</a></p>
                    </div>
                    <div class="border border-gray-200 bg-white p-6">
                        <h3 class="text-sm font-black uppercase tracking-wider text-gray-500">Technical Support</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-700"><a href="mailto:support@typhonmachinery.com" class="hover:text-yellow-600">support@typhonmachinery.com</a></p>
                    </div>
                    <div class="border border-gray-200 bg-white p-6">
                        <h3 class="text-sm font-black uppercase tracking-wider text-gray-500">Certification</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-700">ISO 9001:2015 certified company</p>
                    </div>
                </div>
                <p class="mt-6 max-w-3xl text-sm leading-7 text-gray-600">
                    The site does not add unverified phone numbers, placeholder addresses, fake maps, invented founding dates, or unsupported company statistics.
                </p>
                <a href="{{ route('contact') }}" class="mt-8 inline-flex bg-yellow-400 px-6 py-3 text-sm font-black uppercase tracking-wider text-gray-950 transition hover:bg-yellow-500">Contact Us</a>
            </div>
        </section>
    </main>

    @include('partials.footer')
</body>
</html>
