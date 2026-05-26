<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TYPHON SKOOP | Heavy Machinery Ecosystem</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        skoopBlue: '#2563eb',
                        skoopDark: '#0f172a',
                    }
                }
            }
        }
    </script>
    <style>
        /* --- SINGLE MASSIVE HIGHLIGHT ROTATOR CONTROLS --- */
        .skp-showcase-container {
            width: 100%;
            max-w: 1140px;
            margin: 0 auto;
            position: relative;
            height: 680px; /* Enhanced vertical frame visibility */
        }

        .skp-feature-card {
            position: absolute;
            inset: 0;
            opacity: 0;
            visibility: hidden;
            transform: scale(0.97) translateY(15deg);
            transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1),
                        transform 0.8s cubic-bezier(0.4, 0, 0.2, 1),
                        visibility 0.8s;
            z-index: 1;
        }

        .skp-feature-card.active-card {
            opacity: 1;
            visibility: visible;
            transform: scale(1) translateY(0);
            z-index: 10;
        }

        /* --- POPUP MODAL ARCHITECTURE --- */
        .skp-modal-overlay {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.94);
            backdrop-filter: blur(10px);
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .skp-modal-overlay.show-modal {
            display: flex;
            opacity: 1;
        }
    </style>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-white text-gray-950 font-sans antialiased selection:bg-blue-600 selection:text-white">

    @include('partials.header')

    @php
        $originalHeroImage = 'https://palegoldenrod-stork-751299.hostingersite.com/wp-content/uploads/2026/05/hero1wheel-loader-scaled.webp';
        $heroFallbackImage = 'https://machinery.online/wp-content/uploads/2026/02/TYPHON-Wheel-Loader-with-Kubota-D1105-engine8-1.jpg';
    @endphp

    <section class="relative pt-32 pb-16 lg:pt-48 lg:pb-24 overflow-hidden bg-gradient-to-b from-white via-gray-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="lg:grid lg:grid-cols-12 lg:gap-16 items-center">
                <div class="lg:col-span-6 text-center lg:text-left mb-12 lg:mb-0">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-blue-500/10 border border-blue-500/30 rounded text-skoopBlue text-xs font-black uppercase tracking-widest mb-6">
                        // Heavy Duty Forward Moving Power
                    </div>
                    <h1 style="font-family: 'Archivo Black', sans-serif;" class="text-5xl lg:text-7xl font-black tracking-tight uppercase leading-none mb-6">
                        Built to <span class="text-skoopBlue">Lift More</span>
                    </h1>
                    <p class="mt-4 text-xl text-gray-600 mb-8 max-w-2xl mx-auto lg:mx-0 font-medium">
                        Compact, heavy-duty wheel loaders for farming, construction, and tight-space material handling. Explore our premium lineup of diesel, gas, and electric high-capacity articulator frameworks.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="/product/new-typhon-telescopic-wheel-loader-with-kubota-d1105-engine-25-hp-1-ton-load-usa" class="bg-skoopBlue hover:bg-blue-700 text-white px-8 py-4 rounded font-black uppercase tracking-wider transition shadow-lg shadow-blue-500/30 text-center text-sm">
                            Shop Loaders
                        </a>

                    </div>
                </div>
                <div class="lg:col-span-6">
                    <div class="relative rounded-2xl p-2 border border-blue-500/10 bg-white/40 shadow-2xl shadow-blue-500/5">
                        <img src="{{ $originalHeroImage }}" onerror="this.onerror=null; this.src='{{ $heroFallbackImage }}';" alt="Typhon Skoop Loader" class="w-full object-cover rounded-xl border border-gray-200 relative z-10">
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="py-24 bg-slate-50 border-t border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-skoopBlue font-black text-xs uppercase tracking-widest mb-2 block">// EXPLORE OUR FLEET</span>
                <h2 style="font-family: 'Archivo Black', sans-serif;" class="text-4xl md:text-5xl uppercase tracking-tight">Featured Wheel Loader Models</h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Shop the top loader machines from our equipment catalog, including the new Telescopic Wheel Loader, Thunder VI, and TYPHON TERROR Backhoe Loader.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <article class="group bg-white border border-gray-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-lg transition duration-300">
                    <div class="relative overflow-hidden h-72 bg-gray-100">
                        <img src="https://machinery.online/wp-content/uploads/2026/02/TYPHON-Wheel-Loader-with-Kubota-D1105-engine8-1.jpg" alt="New TYPHON Telescopic Wheel Loader" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        <span class="absolute top-4 left-4 bg-skoopBlue text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full">Wheel Loaders</span>
                    </div>
                    <div class="p-6">
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-3">Equipment</p>
                        <h3 class="text-lg font-black uppercase tracking-tight text-gray-950 mb-3">New TYPHON Telescopic Wheel Loader</h3>
                        <p class="text-sm text-gray-600 mb-6">Kubota D1105 engine, 25 hp, 1 ton load capacity, built for tight site loading and reliable material handling.</p>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-gray-950 text-lg font-black">$16,999</span>
                            <a href="{{ route('product.show', 'new-typhon-telescopic-wheel-loader-with-kubota-d1105-engine-25-hp-1-ton-load-usa') }}" class="inline-flex items-center justify-center bg-skoopBlue hover:bg-blue-700 text-white text-sm font-black uppercase tracking-[0.18em] px-4 py-3 rounded-2xl transition">View</a>
                        </div>
                    </div>
                </article>

                <article class="group bg-white border border-gray-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-lg transition duration-300">
                    <div class="relative overflow-hidden h-72 bg-gray-100">
                        <img src="https://machinery.online/wp-content/uploads/2025/03/TYPHON-Thunder-VI-23hp-EPA-BS-Engine-Wheel-Loader-scaled-1.webp" alt="TYPHON Thunder VI Wheel Loader" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        <span class="absolute top-4 left-4 bg-skoopBlue text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full">Wheel Loaders</span>
                    </div>
                    <div class="p-6">
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-3">Equipment</p>
                        <h3 class="text-lg font-black uppercase tracking-tight text-gray-950 mb-3">TYPHON Thunder VI 23hp</h3>
                        <p class="text-sm text-gray-600 mb-6">EPA B&S engine wheel loader engineered for agile site work, fast loading, and reliable performance.</p>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-gray-950 text-lg font-black">$10,798</span>
                            <a href="{{ route('product.show', 'typhon-thunder-vi-23hp-epa-b-s-engine-wheel-loader-usa') }}" class="inline-flex items-center justify-center bg-skoopBlue hover:bg-blue-700 text-white text-sm font-black uppercase tracking-[0.18em] px-4 py-3 rounded-2xl transition">View</a>
                        </div>
                    </div>
                </article>

                <article class="group bg-white border border-gray-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-lg transition duration-300">
                    <div class="relative overflow-hidden h-72 bg-gray-100">
                        <img src="https://machinery.online/wp-content/uploads/2025/03/Brand-New-TYPHON-TERROR-4WD-Backhoe-Loader-USA.webp" alt="Brand New TYPHON TERROR 4WD Backhoe Loader" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        <span class="absolute top-4 left-4 bg-skoopBlue text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full">Wheel Loaders</span>
                    </div>
                    <div class="p-6">
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-3">Equipment</p>
                        <h3 class="text-lg font-black uppercase tracking-tight text-gray-950 mb-3">TYPHON TERROR 4WD Backhoe Loader</h3>
                        <p class="text-sm text-gray-600 mb-6">Heavy-duty 4WD backhoe loader for tough digging, loading, and yard-moving jobs.</p>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-gray-950 text-lg font-black">$37,080</span>
                            <a href="{{ route('product.show', 'brand-new-typhon-terror-4wd-backhoe-loader-usa') }}" class="inline-flex items-center justify-center bg-skoopBlue hover:bg-blue-700 text-white text-sm font-black uppercase tracking-[0.18em] px-4 py-3 rounded-2xl transition">View</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>



    <section id="attachments" class="py-24 bg-white border-t border-b border-gray-200">
        <div class="flex flex-col items-center justify-center mb-16 px-4 text-center">
            <span class="text-skoopBlue font-black text-xs uppercase tracking-widest mb-2">// CORE ECOSYSTEM CONFIGURATOR</span>
            <h2 style="font-family: 'Archivo Black', sans-serif;" class="text-4xl md:text-6xl uppercase tracking-tight">System Attachments</h2>
            <div class="w-32 h-1.5 bg-skoopBlue rounded mt-4"></div>
        </div>

        <div class="skp-showcase-container max-w-6xl px-6">

            <div class="skp-feature-card active-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8017" data-title="Ditching Machine" data-img="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/Ditching_Machine_please_202604280920.webp">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopBlue relative">
                    <img src="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/Ditching_Machine_please_202604280920.webp" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopBlue tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-01</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Ditching Machine</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8017</span>
                        <span class="bg-skoopBlue text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-blue-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>




            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8001" data-title="Wheel Loader" data-img="{{ $originalHeroImage }}" data-fallback-img="{{ $heroFallbackImage }}">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopBlue relative">
                    <img src="{{ $originalHeroImage }}" onerror="this.onerror=null; this.src='{{ $heroFallbackImage }}';" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopBlue tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-00</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Wheel Loader</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8001</span>
                        <span class="bg-skoopBlue text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-blue-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8012" data-title="Enclosed Sweeper" data-img="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/Gemini_Generated_Image_zgbjg0zgbjg0zgbj-1-1.webp">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopBlue relative">
                    <img src="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/Gemini_Generated_Image_zgbjg0zgbjg0zgbj-1-1.webp" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopBlue tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-02</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Enclosed Sweeper</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8012</span>
                        <span class="bg-skoopBlue text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-blue-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8006" data-title="4-in-1 Bucket" data-img="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/Gemini_Generated_Image_zgbjg0zgbjg0zgbj-1-2.webp">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopBlue relative">
                    <img src="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/Gemini_Generated_Image_zgbjg0zgbjg0zgbj-1-2.webp" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopBlue tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-03</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">4-in-1 Bucket</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8006</span>
                        <span class="bg-skoopBlue text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-blue-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8005" data-title="Hydraulic Fork" data-img="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/please_make_this_202604280903.webp">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopBlue relative">
                    <img src="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/please_make_this_202604280903.webp" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopBlue tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-04</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Hydraulic Fork</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8005</span>
                        <span class="bg-skoopBlue text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-blue-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8008" data-title="Grass Grapple" data-img="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/dense-type_Grass_Grapple_202604280911.webp">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopBlue relative">
                    <img src="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/dense-type_Grass_Grapple_202604280911.webp" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopBlue tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-05</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Grass Grapple</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8008</span>
                        <span class="bg-skoopBlue text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-blue-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8009" data-title="Drilling Rig" data-img="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/Rotary_Drilling_Rig_202604280917.webp">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopBlue relative">
                    <img src="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/Rotary_Drilling_Rig_202604280917.webp" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopBlue tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-06</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Drilling Rig</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8009</span>
                        <span class="bg-skoopBlue text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-blue-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8007" data-title="Log Grapple" data-img="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/please_make_this_202604280906.webp">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopBlue relative">
                    <img src="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/please_make_this_202604280906.webp" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopBlue tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-07</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Log Grapple</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8007</span>
                        <span class="bg-skoopBlue text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-blue-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8023" data-title="Lawn Mower" data-img="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/Lawn_Mower_please_202604280922.webp">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopBlue relative">
                    <img src="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/Lawn_Mower_please_202604280922.webp" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopBlue tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-08</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Lawn Mower</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8023</span>
                        <span class="bg-skoopBlue text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-blue-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8026" data-title="Reclamation Tool" data-img="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/Reclamation_Machine_please_202604280925.webp">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopBlue relative">
                    <img src="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/Reclamation_Machine_please_202604280925.webp" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopBlue tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-09</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Reclamation Tool</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8026</span>
                        <span class="bg-skoopBlue text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-blue-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8013" data-title="Hydraulic Breaker" data-img="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/Hydraulic_Breaker_please_202604280927.webp">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopBlue relative">
                    <img src="https://slategray-lyrebird-947003.hostingersite.com/wp-content/uploads/2026/04/Hydraulic_Breaker_please_202604280927.webp" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopBlue tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-10</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Hydraulic Breaker</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8013</span>
                        <span class="bg-skoopBlue text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-blue-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

        </div>

        <div class="flex justify-center gap-3 mt-10" id="rotation-dots"></div>
    </section>

     <section id="why-choose" class="py-24 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-10 lg:grid-cols-[1.05fr_0.95fr] items-center">
                <div class="relative rounded-[2rem] overflow-hidden border border-slate-200 shadow-[0_45px_120px_rgba(15,23,42,0.08)] bg-slate-950">
                    <img src="https://wheelloader.org/wp-content/uploads/2026/03/0801-1.png" alt="TYPHON SKOOP compact loader" class="w-full h-[520px] object-cover brightness-[0.92]">
                    <div class="absolute bottom-6 left-6 rounded-[1.5rem] bg-gradient-to-r from-skoopBlue to-sky-500/90 p-5 shadow-2xl text-white max-w-xs">
                        <p class="text-[0.75rem] font-semibold uppercase tracking-[0.35em] text-slate-100/80">Kubota diesel engine</p>
                        <p class="mt-2 text-4xl font-black tracking-tight leading-none">25HP</p>
                    </div>
                </div>

                <div class="space-y-8">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full bg-skoopBlue/10 px-4 py-2 text-skoopBlue text-xs font-black uppercase tracking-[0.35em]">Equipment Features</span>
                        <h2 style="font-family: 'Archivo Black', sans-serif;" class="mt-6 text-4xl md:text-5xl font-black tracking-tight text-slate-950 leading-tight">Why choose the TYPHON SKOOP for compact loader work?</h2>
                        <p class="mt-5 text-gray-600 max-w-2xl text-base leading-8">Designed for busy sites where space is tight, the TYPHON SKOOP pairs a compact chassis with rugged lift capacity, quick attachment changeover, and reliable diesel power for tough loading jobs.</p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-6">
                            <h3 class="text-sm font-black uppercase tracking-[0.25em] text-slate-900">Performance</h3>
                            <p class="mt-3 text-sm leading-6 text-slate-600">Kubota D1105 water-cooled diesel output tuned for steady torque, long runtime, and dependable jobsite performance.</p>
                        </div>

                        <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-6">
                            <h3 class="text-sm font-black uppercase tracking-[0.25em] text-slate-900">Load capacity</h3>
                            <p class="mt-3 text-sm leading-6 text-slate-600">Rated for up to 1,760 lbs with strong hydraulic lift strength for material handling and transport.</p>
                        </div>

                        <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-6">
                            <h3 class="text-sm font-black uppercase tracking-[0.25em] text-slate-900">Versatility</h3>
                            <p class="mt-3 text-sm leading-6 text-slate-600">Fast attachment swaps let the SKOOP switch from bucket to grapple or breaker quickly, so the machine does more on every shift.</p>
                        </div>

                        <div class="rounded-[1.5rem] border border-slate-200 bg-slate-50 p-6">
                            <h3 class="text-sm font-black uppercase tracking-[0.25em] text-slate-900">Lift reach</h3>
                            <p class="mt-3 text-sm leading-6 text-slate-600">Achieve a 2,825mm dump height and tight reach for loading trucks, bins, and stacking material in narrow spaces.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="specs" class="py-20 bg-gray-50 border-t border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <h2 style="font-family: 'Archivo Black', sans-serif;" class="text-3xl md:text-5xl font-extrabold uppercase tracking-tight">The Power Inside</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-8 rounded-xl border border-gray-200 hover:border-skoopBlue transition duration-300 group">
                    <i data-lucide="arrow-up-to-line" class="text-skoopBlue w-10 h-10 mb-6 group-hover:scale-110 transition"></i>
                    <h3 class="text-xl font-bold uppercase mb-2">Telescopic Lift Power</h3>
                    <p class="text-gray-600">2,825mm max dump height for clearing high truck beds easily.</p>
                </div>
                <div class="bg-white p-8 rounded-xl border border-gray-200 hover:border-skoopBlue transition duration-300 group">
                    <i data-lucide="zap" class="text-skoopBlue w-10 h-10 mb-6 group-hover:scale-110 transition"></i>
                    <h3 class="text-xl font-bold uppercase mb-2">Kubota Diesel Engines</h3>
                    <p class="text-gray-600">Reliable water-cooled D1105 engines built for heavy industrial endurance.</p>
                </div>
                <div class="bg-white p-8 rounded-xl border border-gray-200 hover:border-skoopBlue transition duration-300 group">
                    <i data-lucide="weight" class="text-skoopBlue w-10 h-10 mb-6 group-hover:scale-110 transition"></i>
                    <h3 class="text-xl font-bold uppercase mb-2">Heavy-Duty Stability</h3>
                    <p class="text-gray-600">Up to 4,600 lbs machine weight distribution preventing standard tipping risks.</p>
                </div>
                <div class="bg-white p-8 rounded-xl border border-gray-200 hover:border-skoopBlue transition duration-300 group">
                    <i data-lucide="mountain-snow" class="text-skoopBlue w-10 h-10 mb-6 group-hover:scale-110 transition"></i>
                    <h3 class="text-xl font-bold uppercase mb-2">Max Gradeability</h3>
                    <p class="text-gray-600">30% steep incline capability for navigating tough, loose, uneven hillside terrain.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="kubota-reliability" class="py-24 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <div class="lg:col-span-5">
                    <span class="text-skoopBlue font-black text-xs uppercase tracking-widest mb-3 block">// KUBOTA D1105 RELIABILITY CORE</span>
                    <h2 style="font-family: 'Archivo Black', sans-serif;" class="text-3xl md:text-5xl font-black uppercase tracking-tight leading-tight mb-6">
                        How the Kubota D1105 Engine Makes the TYPHON SKOOP Reliable for Daily Work
                    </h2>
                    <p class="text-lg text-gray-600 font-medium mb-8">
                        Daily loader work needs steady torque, predictable cooling, and serviceable parts. The Kubota D1105 gives the SKOOP a proven diesel platform built for long shifts, repeat starts, and practical upkeep.
                    </p>
                    <div class="bg-gray-50 border-l-8 border-skoopBlue p-6 rounded-r-xl">
                        <div class="flex items-start gap-4">
                            <i data-lucide="message-square-text" class="text-skoopBlue w-8 h-8 flex-shrink-0"></i>
                            <p class="text-gray-700 font-semibold">
                                Community discussions often mention Kubota engines for their long-term serviceability and parts availability.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-white p-7 rounded-xl border border-gray-200 hover:border-skoopBlue transition duration-300 group">
                        <i data-lucide="fuel" class="text-skoopBlue w-9 h-9 mb-5 group-hover:scale-110 transition"></i>
                        <h3 class="text-lg font-black uppercase mb-2">Fuel Efficiency</h3>
                        <p class="text-gray-600">The compact three-cylinder diesel layout is tuned for practical jobsite fuel use, helping crews keep operating costs controlled through long workdays.</p>
                    </div>
                    <div class="bg-white p-7 rounded-xl border border-gray-200 hover:border-skoopBlue transition duration-300 group">
                        <i data-lucide="shield-check" class="text-skoopBlue w-9 h-9 mb-5 group-hover:scale-110 transition"></i>
                        <h3 class="text-lg font-black uppercase mb-2">Durability</h3>
                        <p class="text-gray-600">Kubota's industrial diesel design supports steady low-speed torque and dependable operation under repeated loading, lifting, and travel cycles.</p>
                    </div>
                    <div class="bg-white p-7 rounded-xl border border-gray-200 hover:border-skoopBlue transition duration-300 group">
                        <i data-lucide="wrench" class="text-skoopBlue w-9 h-9 mb-5 group-hover:scale-110 transition"></i>
                        <h3 class="text-lg font-black uppercase mb-2">Easy Maintenance</h3>
                        <p class="text-gray-600">Straightforward service access and widely understood Kubota maintenance routines make routine checks, fluid service, and parts replacement simpler.</p>
                    </div>
                    <div class="bg-white p-7 rounded-xl border border-gray-200 hover:border-skoopBlue transition duration-300 group">
                        <i data-lucide="badge-check" class="text-skoopBlue w-9 h-9 mb-5 group-hover:scale-110 transition"></i>
                        <h3 class="text-lg font-black uppercase mb-2">Trusted Kubota Performance</h3>
                        <p class="text-gray-600">Kubota engines have a strong reputation across compact equipment, giving operators confidence in parts support and familiar service standards.</p>
                    </div>
                    <div class="sm:col-span-2 bg-skoopDark p-7 rounded-xl border border-slate-700 shadow-xl">
                        <div class="flex flex-col sm:flex-row sm:items-start gap-5">
                            <i data-lucide="droplets" class="text-blue-300 w-10 h-10 flex-shrink-0"></i>
                            <div>
                                <h3 class="text-xl font-black uppercase mb-2 text-white">Water-Cooled Diesel Advantages</h3>
                                <p class="text-slate-300">Water cooling helps stabilize operating temperature during stop-and-go loader work, supporting consistent power delivery when the SKOOP is moving material, climbing grades, or running attachments.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="videos" class="py-20 bg-white border-t border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <span class="text-skoopBlue font-black text-xs uppercase tracking-widest mb-2 block">// VIDEO SHOWCASE</span>
                <h2 style="font-family: 'Archivo Black', sans-serif;" class="text-3xl md:text-4xl uppercase tracking-tight">Watch Product Walkarounds</h2>
                <p class="mt-3 text-gray-600 max-w-2xl mx-auto">Two short demos highlighting the Telescopic Wheel Loader and compact loader performance.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm p-4">
                    <div class="w-full" style="padding-top:56.25%; position:relative;">
                        <iframe src="https://www.youtube.com/embed/0LH2wDXxqnc" title="Telescopic Wheel Loader Demo" class="absolute inset-0 w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-black text-gray-900 uppercase text-sm">Telescopic Wheel Loader — Demo</h3>
                        <p class="text-xs text-gray-500">Quick overview and on-site demo.</p>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm p-4">
                    <div class="w-full" style="padding-top:56.25%; position:relative;">
                        <iframe src="https://www.youtube.com/embed/AIuKmoUrCFY" title="Compact Loader Highlights" class="absolute inset-0 w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="mt-4">
                        <h3 class="font-black text-gray-900 uppercase text-sm">Compact Loader Highlights</h3>
                        <p class="text-xs text-gray-500">Performance and attachment walkthrough.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="feedback" class="py-20 bg-white border-t border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-skoopBlue font-black text-xs uppercase tracking-widest mb-2 block">// CUSTOMER FEEDBACK</span>
                <h2 style="font-family: 'Archivo Black', sans-serif;" class="text-3xl md:text-4xl uppercase tracking-tight">What Our Customers Say</h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Real feedback from customers using our loaders and attachments in the field.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <blockquote class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="flex items-start gap-4">
                        <img src="https://i.pravatar.cc/96?img=12" alt="Customer avatar" class="w-16 h-16 rounded-full object-cover border border-gray-200">
                        <div>
                            <p class="text-gray-700 italic text-sm">"The Telescopic Wheel Loader changed our workflow — reach and stability let us load trucks faster and handle awkward loads with confidence."</p>
                            <div class="mt-4 flex items-center justify-between">
                                <div>
                                    <div class="font-black text-gray-900">Jordan Miles</div>
                                    <div class="text-xs text-gray-500">Site Supervisor — Blue Ridge Farms</div>
                                </div>
                                <div class="text-yellow-400 font-black">★★★★★</div>
                            </div>
                        </div>
                    </div>
                </blockquote>

                <blockquote class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="flex items-start gap-4">
                        <img src="https://i.pravatar.cc/96?img=47" alt="Customer avatar" class="w-16 h-16 rounded-full object-cover border border-gray-200">
                        <div>
                            <p class="text-gray-700 italic text-sm">"TYPHON Thunder VI is nimble and reliable — best compact loader we've used for tight jobsite tasks."</p>
                            <div class="mt-4 flex items-center justify-between">
                                <div>
                                    <div class="font-black text-gray-900">Aisha Khan</div>
                                    <div class="text-xs text-gray-500">Owner — Khan Landscaping</div>
                                </div>
                                <div class="text-yellow-400 font-black">★★★★★</div>
                            </div>
                        </div>
                    </div>
                </blockquote>

                <blockquote class="p-6 bg-white border border-gray-200 rounded-xl shadow-sm">
                    <div class="flex items-start gap-4">
                        <img src="https://i.pravatar.cc/96?img=5" alt="Customer avatar" class="w-16 h-16 rounded-full object-cover border border-gray-200">
                        <div>
                            <p class="text-gray-700 italic text-sm">"The TYPHON TERROR handled our toughest digging and loading tasks without missing a beat. Great support and delivery."</p>
                            <div class="mt-4 flex items-center justify-between">
                                <div>
                                    <div class="font-black text-gray-900">Miguel Alvarez</div>
                                    <div class="text-xs text-gray-500">Foreman — Coastal Construction</div>
                                </div>
                                <div class="text-yellow-400 font-black">★★★★★</div>
                            </div>
                        </div>
                    </div>
                </blockquote>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <div id="skp-modal" class="skp-modal-overlay">
        <div class="bg-gray-50 border-2 border-skoopBlue rounded-2xl w-[90%] max-w-[750px] shadow-2xl overflow-hidden relative transform translate-y-8 scale-95 transition-all duration-300" id="skp-modal-content">
            <span class="absolute top-3 right-6 text-gray-950 text-4xl font-black cursor-pointer hover:text-skoopBlue transition z-10" id="skp-close-btn">&times;</span>
            <div class="bg-white p-6 flex items-center justify-center border-b-4 border-gray-200 h-[450px]">
                <img id="skp-modal-img" src="" alt="Blueprint Technical High Res View" class="w-full h-full object-contain">
            </div>
            <div class="p-8 text-center bg-gray-50">
                <span id="skp-modal-sku" class="block text-sm font-black text-skoopBlue tracking-widest uppercase mb-1"></span>
                <h3 id="skp-modal-title" class="text-2xl font-black uppercase text-gray-950 tracking-tight"></h3>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            const cards = document.querySelectorAll('.skp-feature-card');
            const dotsContainer = document.getElementById('rotation-dots');
            let currentIndex = 0;
            let rotationTimer;

            // Generate Nav dots precisely for all 10 hardware nodes
            cards.forEach((_, index) => {
                const dot = document.createElement('button');
                dot.className = `w-3 h-3 rounded-full transition-all duration-300 ${index === 0 ? 'bg-skoopBlue w-8' : 'bg-gray-300'}`;
                dot.setAttribute('aria-label', `Go to attachment slide ${index + 1}`);
                dot.addEventListener('click', () => {
                    goToSlide(index);
                    resetTimer();
                });
                dotsContainer.appendChild(dot);
            });

            const dots = dotsContainer.querySelectorAll('button');

            function goToSlide(index) {
                cards[currentIndex].classList.remove('active-card');
                dots[currentIndex].classList.remove('bg-skoopBlue', 'w-8');
                dots[currentIndex].classList.add('bg-gray-300');

                currentIndex = index;

                cards[currentIndex].classList.add('active-card');
                dots[currentIndex].classList.remove('bg-gray-300');
                dots[currentIndex].classList.add('bg-skoopBlue', 'w-8');
            }

            function startTimer() {
                rotationTimer = setInterval(() => {
                    let nextIndex = (currentIndex + 1) % cards.length;
                    goToSlide(nextIndex);
                }, 4000);
            }

            function resetTimer() {
                clearInterval(rotationTimer);
                startTimer();
            }

            startTimer();

            // Lightbox Modal Setup
            const modal = document.getElementById('skp-modal');
            const modalContent = document.getElementById('skp-modal-content');
            const modalImg = document.getElementById('skp-modal-img');
            const modalTitle = document.getElementById('skp-modal-title');
            const modalSku = document.getElementById('skp-modal-sku');
            const closeBtn = document.getElementById('skp-close-btn');

            cards.forEach(card => {
                card.addEventListener('click', function() {
                    clearInterval(rotationTimer);

                    const sku = this.getAttribute('data-sku');
                    const title = this.getAttribute('data-title');
                    const img = this.getAttribute('data-img');
                    const fallbackImg = this.getAttribute('data-fallback-img');

                    modalImg.onerror = fallbackImg ? () => {
                        modalImg.onerror = null;
                        modalImg.src = fallbackImg;
                    } : null;
                    modalImg.src = img;
                    modalTitle.innerText = title;
                    modalSku.innerText = sku;

                    modal.classList.add('show-modal');
                    setTimeout(() => {
                        modalContent.classList.remove('translate-y-8', 'scale-95');
                    }, 50);
                });
            });

            function closeModal() {
                modalContent.classList.add('translate-y-8', 'scale-95');
                setTimeout(() => {
                    modal.classList.remove('show-modal');
                    startTimer();
                }, 150);
            }

            closeBtn.addEventListener('click', closeModal);
            modal.addEventListener('click', function(e) {
                if (e.target === modal) closeModal();
            });
        });
    </script>
</body>
</html>
