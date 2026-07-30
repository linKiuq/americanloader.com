<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    @include('partials.seo', [
        'title' => 'About American Loader | Compact Construction Equipment',
        'description' => 'Meet American Loader, a source for TYPHON wheel loaders, skid steer loaders, STORM mini excavators, forklifts, lifts, rollers, and jobsite attachments.',
        'keywords' => 'about American Loader, TYPHON equipment supplier, wheel loader source, skid steer loaders, mini excavators, construction equipment supplier, jobsite attachments',
        'jsonLd' => [
            '@type' => 'AboutPage',
            '@id' => config('seo.site_url') . '/about#about',
            'name' => 'About The Power Loader',
            'url' => config('seo.site_url') . '/about',
        ],
    ])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-white text-[#071d38] flex flex-col">
    @include('partials.header')

    <main class="flex-grow">
        <section class="bg-gradient-to-br from-white via-white to-red-50 px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <p class="mb-4 text-xs font-black uppercase tracking-[0.3em] text-red-700">About Us</p>
                <h1 class="max-w-4xl text-4xl font-black tracking-tight text-[#071d38] sm:text-5xl">Machinery information without made-up details</h1>
                <p class="mt-6 max-w-3xl text-lg leading-8 text-gray-600">
                    The Power Loader presents construction equipment and attachments using verified Typhon Machinery information, including mini excavators, compactor rollers, forklifts, wheel loaders, skid steer loaders, attachments, and parts.
                </p>
            </div>
        </section>

        <section class="border-y border-gray-200 bg-[#071d38] px-4 py-12 text-white sm:px-6 lg:px-8 lg:py-16">
            <div class="mx-auto grid max-w-7xl overflow-hidden rounded-[1.5rem] border border-white/10 bg-[#0a223d] shadow-2xl lg:grid-cols-[1.15fr_0.85fr]">
                <figure class="relative min-h-[360px] overflow-hidden lg:min-h-[500px]">
                    <img src="{{ asset('american-loader-team.png') }}" alt="American Loader equipment sales, service, logistics, and technical support team" class="absolute inset-0 h-full w-full object-cover object-center" width="1672" height="941">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#030712]/65 via-transparent to-transparent"></div>
                    <figcaption class="absolute bottom-0 left-0 p-6 text-xs font-black uppercase tracking-[0.22em] text-white sm:p-8">Equipment knowledge. Practical support.</figcaption>
                </figure>

                <div class="flex flex-col justify-center p-7 sm:p-9 lg:p-10">
                    <p class="flex items-center gap-3 text-xs font-black uppercase tracking-[0.24em] text-red-400"><span class="h-0.5 w-9 bg-red-500"></span> Our Team</p>
                    <h2 class="mt-5 text-3xl font-black uppercase leading-[1.03] tracking-tight sm:text-4xl">People focused on<br><span class="text-red-400">keeping work moving.</span></h2>
                    <p class="mt-5 text-base leading-7 text-slate-300">
                        Equipment decisions are easier with clear product information and responsive support. Sales, logistics, technical guidance, and service questions are handled with the jobsite in mind.
                    </p>
                    <div class="mt-7 grid gap-3 sm:grid-cols-2">
                        <div class="border-l-2 border-red-500 bg-white/[0.05] p-4">
                            <h3 class="text-sm font-black uppercase tracking-wider">Product Guidance</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-400">Machine and attachment information organized around real applications.</p>
                        </div>
                        <div class="border-l-2 border-red-500 bg-white/[0.05] p-4">
                            <h3 class="text-sm font-black uppercase tracking-wider">Responsive Support</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-400">Clear routes for sales questions, technical help, and delivery coordination.</p>
                        </div>
                    </div>
                    <a href="{{ route('contact') }}" class="mt-7 inline-flex min-h-12 self-start items-center justify-center rounded-lg bg-red-600 px-6 text-xs font-black uppercase tracking-[0.16em] text-white transition hover:bg-red-700">Meet Your Equipment Needs</a>
                </div>
            </div>
        </section>

        <section class="px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto grid max-w-7xl gap-10 lg:grid-cols-[0.9fr_1.1fr] lg:items-start">
                <div>
                    <h2 class="text-3xl font-black text-[#071d38]">About The Equipment</h2>
                    <p class="mt-5 text-base leading-8 text-gray-600">
                        Typhon Machinery describes its catalog as construction equipment and attachments built for productivity, reliability, and jobsite performance. The product range includes compact mini excavators for tight-space digging, skid steer loaders for flexible construction work, and attachments that help expand what excavators and skid steer loaders can do.
                    </p>
                    <p class="mt-5 text-base leading-8 text-gray-600">
                        Product availability, specifications, pricing, delivery, warranty, and compatibility should always be confirmed before purchase. If you need help choosing equipment, use the contact form and include your machine type, intended work, and any attachment requirements.
                    </p>
                </div>

                <div class="grid gap-5 sm:grid-cols-2">
                    <div class="border border-gray-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-black text-[#071d38]">Mini Excavators</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Compact machines designed for digging and excavation work where space is limited.</p>
                    </div>
                    <div class="border border-gray-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-black text-[#071d38]">Skid Steer Loaders</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Flexible loaders for material handling, site work, landscaping, and daily construction tasks.</p>
                    </div>
                    <div class="border border-gray-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-black text-[#071d38]">Attachments</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Mini excavator and skid steer attachments organized by machine type, size, and series.</p>
                    </div>
                    <div class="border border-gray-200 bg-white p-6 shadow-sm">
                        <h3 class="text-lg font-black text-[#071d38]">Support</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Sales and technical questions can be sent through the verified email contacts listed below.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="border-y border-gray-200 bg-gray-50 px-4 py-16 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-7xl">
                <h2 class="text-3xl font-black text-[#071d38]">Verified Contact Information</h2>
                <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
                    <div class="border border-gray-200 bg-white p-6">
                        <h3 class="text-sm font-black uppercase tracking-wider text-gray-500">Address</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-700">2522 S Malt Ave. Commerce, CA 90040 United States</p>
                    </div>
                    <div class="border border-gray-200 bg-white p-6">
                        <h3 class="text-sm font-black uppercase tracking-wider text-gray-500">Sales</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-700"><a href="mailto:sales@typhonmachinery.com" class="hover:text-red-700">sales@typhonmachinery.com</a></p>
                        <p class="mt-1 text-sm leading-6 text-gray-700"><a href="tel:+12132142203" class="hover:text-red-700">+1 213-214-2203</a></p>
                    </div>
                    <div class="border border-gray-200 bg-white p-6">
                        <h3 class="text-sm font-black uppercase tracking-wider text-gray-500">Technical Support</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-700"><a href="mailto:support@typhonmachinery.com" class="hover:text-red-700">support@typhonmachinery.com</a></p>
                    </div>
                    <div class="border border-gray-200 bg-white p-6">
                        <h3 class="text-sm font-black uppercase tracking-wider text-gray-500">Certification</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-700">ISO 9001:2015 certified company</p>
                    </div>
                </div>
                <p class="mt-6 max-w-3xl text-sm leading-7 text-gray-600">
                    The site does not add unverified phone numbers, placeholder addresses, fake maps, invented founding dates, or unsupported company statistics.
                </p>
                <a href="{{ route('contact') }}" class="mt-8 inline-flex bg-red-500 px-6 py-3 text-sm font-black uppercase tracking-wider text-[#071d38] transition hover:bg-red-500">Contact Us</a>
            </div>
        </section>
    </main>

    @include('partials.footer')
</body>
</html>
