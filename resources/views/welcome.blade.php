<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.head-favicon')
    <title>TYPHON SKOOP | Heavy Machinery Ecosystem</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Inter:wght@400;500;600;700;900&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
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

        /* --- Global Reset & Variables --- */
        .industrial-hero-section {
            position: relative;
            width: 100%;
            min-height: 100vh;
            background: linear-gradient(rgba(11, 16, 26, 0.85), rgba(11, 16, 26, 0.85)),
                        url('https://minexcavators.com/wp-content/uploads/2026/05/image.webp') no-repeat center center !important;
            background-size: cover !important;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 80px 6%;
            box-sizing: border-box;
        }

        /* --- Global Grid Workspace Framework --- */
        .hero-main-layout {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 50px;
            align-items: center;
            margin-top: auto;
            margin-bottom: auto;
            width: 100%;
            max-width: 1440px;
        }

        /* --- Left Column Content Side Styles --- */
        .left-content-panel {
            max-width: 680px;
            text-align: left;
        }

        .tag-pill {
            display: inline-flex;
            align-items: center;
            background: rgba(230, 126, 34, 0.2);
            color: #e67e22;
            border: 1px solid rgba(230, 126, 34, 0.3);
            padding: 6px 14px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 25px;
            border-radius: 3px;
        }

        .hero-title {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(2.5rem, 4.5vw, 4rem);
            font-weight: 900;
            line-height: 1.1;
            text-transform: uppercase;
            letter-spacing: -1.5px;
            margin-bottom: 25px;
            color: #ffffff !important;
        }

        .hero-title span {
            color: #e67e22 !important;
        }

        .hero-sub-description {
            font-size: 1.05rem;
            line-height: 1.6;
            color: #ffffff !important;
            margin-bottom: 35px;
            max-height: 180px;
            overflow-y: auto;
            padding-right: 15px;
        }

        .hero-sub-description::-webkit-scrollbar {
            width: 4px;
        }
        .hero-sub-description::-webkit-scrollbar-thumb {
            background: #e67e22;
            border-radius: 4px;
        }

        .button-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .btn-orange {
            background-color: #e67e22;
            color: #ffffff !important;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 18px 36px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: 0.2s;
            text-decoration: none;
        }

        .btn-orange:hover {
            background-color: #d35400;
        }

        .btn-outline {
            background: transparent;
            color: #ffffff !important;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 18px 36px;
            border: 1.5px solid rgba(255, 255, 255, 0.4);
            border-radius: 4px;
            cursor: pointer;
            transition: 0.2s;
            text-decoration: none;
        }

        .btn-outline:hover {
            border-color: #ffffff;
            background: rgba(255, 255, 255, 0.05);
        }

        /* --- Right Column Interactive Menu Grid --- */
        .right-interactive-menu {
            display: grid;
            grid-template-columns: 1fr;
            gap: 15px;
            width: 100%;
        }

        .main-hero-card {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(230, 126, 34, 0.4);
            border-radius: 6px;
            padding: 25px;
            backdrop-filter: blur(12px);
            position: relative;
        }

        .main-hero-card-tag {
            color: #e67e22;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .main-hero-card-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 6px;
            color: #ffffff !important;
        }

        .main-hero-card-sub {
            font-size: 0.85rem;
            color: #e2e8f0 !important;
            margin-bottom: 15px;
        }

        /* Core Dynamic Secondary Grid layout from template */
        .secondary-cards-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .spec-selection-button {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 6px;
            padding: 20px;
            text-align: left;
            cursor: pointer;
            backdrop-filter: blur(8px);
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 120px;
        }

        .spec-selection-button:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.25);
        }

        .spec-selection-button.active-feature {
            background: rgba(230, 126, 34, 0.15);
            border-color: #e67e22;
        }

        .spec-btn-icon {
            color: #e67e22;
            font-size: 1.3rem;
            margin-bottom: 12px;
            font-weight: bold;
        }

        .spec-btn-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.95rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            line-height: 1.2;
            color: #ffffff !important;
        }

        .spec-btn-sub {
            font-size: 0.75rem;
            color: #e2e8f0 !important;
            margin-top: 4px;
        }

        /* --- Footer Statistics Bar Panel --- */
        .stats-footer-bar {
            display: flex;
            gap: 50px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 30px;
            margin-top: 40px;
            width: 100%;
            max-width: 1440px;
        }

        .stat-node {
            display: flex;
            flex-direction: column;
        }

        .stat-number {
            font-family: 'Montserrat', sans-serif;
            font-size: 1.8rem;
            font-weight: 900;
            color: #ffffff !important;
        }

        .stat-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #e2e8f0 !important;
            margin-top: 2px;
        }

        @media (max-width: 1024px) {
            .hero-main-layout { grid-template-columns: 1fr; gap: 40px; }
            .left-content-panel { max-width: 100%; }
            .stats-footer-bar { gap: 30px; justify-content: space-between; }
        }

        @media (max-width: 600px) {
            .secondary-cards-grid { grid-template-columns: 1fr; }
            .stats-footer-bar { flex-wrap: wrap; gap: 20px; }
            .stat-node { width: 45%; }
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

    <section class="industrial-hero-section">
        <div class="hero-main-layout">
            <div class="left-content-panel">
                <div class="tag-pill">Professional Grade Equipment</div>
                <h1 class="hero-title" id="main-title-view">Power Your <span>Next Project</span> With Confidence</h1>

                <div class="hero-sub-description" id="main-desc-view">
                    Choosing a wheel loader based on size or brand alone leaves money on the table. The machines that consistently deliver on the job share a set of core performance features that determine how much material they move, how efficiently they operate, and how well they hold up under real working conditions. Understanding these specs helps you move beyond the brochure and make a decision grounded in actual jobsite output.
                </div>

                <div class="button-group">
                    <a href="{{ route('equipment', ['category' => 'Wheel Loaders']) }}#catalog" class="btn-orange" id="primary-action-btn">Shop Skoop Loader</a>
                    <a href="#specs" class="btn-outline">View All Specs</a>
                </div>
            </div>

            <div class="right-interactive-menu">
                <div class="main-hero-card">
                    <div class="main-hero-card-tag">🔥 Active Selected Feature</div>
                    <div class="main-hero-card-title" id="card-feature-title">Engine Power and Torque</div>
                    <div class="main-hero-card-sub" id="card-feature-sub">$17,848.95 Base Value — Torque Rise Parameters</div>
                    <a href="{{ route('product.show', 'new-typhon-telescopic-wheel-loader-with-kubota-d1105-engine-25-hp-1-ton-load-usa') }}" class="btn-orange" style="display: inline-block; padding: 10px 20px; font-size: 0.75rem;" id="secondary-action-btn">Configure Asset &rarr;</a>
                </div>

                <div class="secondary-cards-grid">
                    <div class="spec-selection-button active-feature" onclick="swapFeatureContext(0, this)">
                        <div class="spec-btn-icon">⚙️</div>
                        <div>
                            <div class="spec-btn-title">Engine Power</div>
                            <div class="spec-btn-sub">Torque Rise Spec</div>
                        </div>
                    </div>

                    <div class="spec-selection-button" onclick="swapFeatureContext(1, this)">
                        <div class="spec-btn-icon">💥</div>
                        <div>
                            <div class="spec-btn-title">Breakout Force</div>
                            <div class="spec-btn-sub">Cylinder Crowding</div>
                        </div>
                    </div>

                    <div class="spec-selection-button" onclick="swapFeatureContext(2, this)">
                        <div class="spec-btn-icon">🏋️</div>
                        <div>
                            <div class="spec-btn-title">Lift Capacity</div>
                            <div class="spec-btn-sub">Rated Load Tipping</div>
                        </div>
                    </div>

                    <div class="spec-selection-button" onclick="swapFeatureContext(3, this)">
                        <div class="spec-btn-icon">🪣</div>
                        <div>
                            <div class="spec-btn-title">Bucket Fill</div>
                            <div class="spec-btn-sub">Volumetric Metrics</div>
                        </div>
                    </div>

                    <div class="spec-selection-button" onclick="swapFeatureContext(4, this)">
                        <div class="spec-btn-icon">💧</div>
                        <div>
                            <div class="spec-btn-title">Hydraulic Flow</div>
                            <div class="spec-btn-sub">Load Sensing Pump</div>
                        </div>
                    </div>

                    <div class="spec-selection-button" onclick="swapFeatureContext(5, this)">
                        <div class="spec-btn-icon">⏱️</div>
                        <div>
                            <div class="spec-btn-title">Cycle Times</div>
                            <div class="spec-btn-sub">Raise & Dump Speeds</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="stats-footer-bar">
            <div class="stat-node">
                <div class="stat-number">500+</div>
                <div class="stat-label">Products Active</div>
            </div>
            <div class="stat-node">
                <div class="stat-number">12K+</div>
                <div class="stat-label">Customers Served</div>
            </div>
            <div class="stat-node">
                <div class="stat-number">4.9★</div>
                <div class="stat-label">Rating Index</div>
            </div>
            <div class="stat-node">
                <div class="stat-number">10yr</div>
                <div class="stat-label">In Business Ops</div>
            </div>
        </div>
    </section>

    <section id="wheel-loader-solutions" class="overflow-hidden border-b border-orange-500/10 bg-slate-950 py-20 text-white lg:py-28">
        <div class="mx-auto max-w-7xl px-6 lg:px-12">
            <div class="grid items-center gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="relative flex flex-col justify-center lg:col-span-5">
                    <div class="aspect-[4/5] w-full overflow-hidden rounded-3xl border border-white/10 bg-slate-900 shadow-2xl lg:h-[620px]">
                        <img
                            src="https://machinery.online/wp-content/uploads/2026/02/TYPHON-Wheel-Loader-with-Kubota-D1105-engine8-1.jpg"
                            alt="TYPHON wheel loader machine"
                            class="h-full w-full object-cover transition duration-700 hover:scale-105"
                        >
                    </div>
                    <div class="absolute -bottom-6 left-4 w-[205px] rounded-3xl border border-orange-300/30 bg-orange-500 p-6 text-slate-950 shadow-2xl sm:-right-6 sm:left-auto sm:w-[245px] sm:p-8">
                        <h3 class="text-4xl font-black sm:text-5xl">15+</h3>
                        <p class="mt-2 text-sm font-bold leading-snug sm:text-base">
                            Years of Heavy Equipment Experience
                        </p>
                    </div>
                </div>

                <div class="mt-10 flex flex-col justify-center lg:col-span-7 lg:mt-0">
                    <div class="mb-4 inline-flex items-center gap-3">
                        <span class="h-[3px] w-12 bg-orange-500"></span>
                        <p class="text-xs font-bold uppercase tracking-[4px] text-orange-400 sm:text-sm">
                            Wheel Loader Solutions
                        </p>
                    </div>

                    <h2 class="mb-6 text-4xl font-black leading-tight text-white lg:text-5xl xl:text-6xl" style="font-family: 'Montserrat', sans-serif;">
                        Powerful Wheel Loaders <br>
                        <span class="text-orange-400">Built for Serious Work</span>
                    </h2>

                    <p class="mb-8 max-w-2xl text-base leading-relaxed text-slate-300 sm:text-lg">
                        Our wheel loaders are engineered for strength, durability, and productivity across construction, agriculture, mining, and industrial jobsites. Designed for operator control and dependable output, these machines stay productive in demanding conditions.
                    </p>

                    <div class="mb-10 grid gap-4 sm:grid-cols-2 sm:gap-5">
                        <div class="flex items-start gap-4 rounded-2xl border border-white/10 bg-white/[0.04] p-4 transition hover:border-orange-500/40 hover:bg-white/[0.07]">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-orange-500 text-xl font-bold text-slate-950">+</div>
                            <div>
                                <h3 class="mb-1 text-lg font-bold text-white">High Performance</h3>
                                <p class="text-sm leading-relaxed text-slate-400">Built to handle demanding workloads with powerful lifting capacity.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 rounded-2xl border border-white/10 bg-white/[0.04] p-4 transition hover:border-orange-500/40 hover:bg-white/[0.07]">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-orange-500 text-xl font-bold text-slate-950">01</div>
                            <div>
                                <h3 class="mb-1 text-lg font-bold text-white">Reliable Technology</h3>
                                <p class="text-sm leading-relaxed text-slate-400">Advanced engineering supports efficiency and long-term durability.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 rounded-2xl border border-white/10 bg-white/[0.04] p-4 transition hover:border-orange-500/40 hover:bg-white/[0.07]">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-orange-500 text-xl font-bold text-slate-950">HD</div>
                            <div>
                                <h3 class="mb-1 text-lg font-bold text-white">Heavy Duty Design</h3>
                                <p class="text-sm leading-relaxed text-slate-400">Tough construction built for harsh, continuous operations.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 rounded-2xl border border-white/10 bg-white/[0.04] p-4 transition hover:border-orange-500/40 hover:bg-white/[0.07]">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-orange-500 text-xl font-bold text-slate-950">04</div>
                            <div>
                                <h3 class="mb-1 text-lg font-bold text-white">Multiple Applications</h3>
                                <p class="text-sm leading-relaxed text-slate-400">Suitable for construction, farming, and material handling.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row">
                        <a href="{{ route('equipment', ['category' => 'Wheel Loaders']) }}#catalog" class="rounded-lg bg-orange-500 px-8 py-4 text-center text-sm font-bold uppercase tracking-wider text-white shadow-lg transition hover:bg-orange-600 sm:py-5">
                            Explore Wheel Loaders
                        </a>
                        <a href="{{ route('contact') }}" class="rounded-lg border border-white/40 px-8 py-4 text-center text-sm font-bold uppercase tracking-wider text-white transition hover:border-orange-400 hover:text-orange-300 sm:py-5">
                            Contact Our Team
                        </a>
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

    <script>
        const operationalSpecs = [
            {
                title: "Engine Power and Torque",
                sub: "Torque Rise Parameters",
                price: "$17,848.95 Base Value",
                desc: "Engine horsepower sets the ceiling for what a wheel loader can do, but torque is what actually gets material moving. High torque at low engine speeds gives the loader the pulling force needed to penetrate dense material, push into heavy piles, and maintain momentum without bogging down the drivetrain. A well-matched engine delivers strong torque across a broad RPM range rather than only at peak RPM. This means the machine responds immediately when the operator drives into a pile instead of requiring the engine to rev before producing useful force. When comparing engine performance, pay attention to: Peak torque and the RPM range where it is available; Torque rise — how much torque increases as load rises and engine speed drops; Engine response time under sudden load changes. An engine with strong torque rise maintains productivity during demanding cycles, while a less capable engine forces operators to slow down or take smaller bites of material."
            },
            {
                title: "Breakout Force Execution",
                sub: "Hydraulic Cylinder Push",
                price: "Premium Rigging Included",
                desc: "Breakout force is the measure of how powerfully the bucket can penetrate and lift material from a static position. It directly determines how aggressively the machine can attack a stockpile, dig into compacted material, or strip a surface. Higher breakout force means shorter dig cycles, less wheel spin, and better material fill on each pass. In practical terms, it is the difference between a loader that attacks a pile decisively and one that struggles to fill the bucket cleanly. Two numbers define breakout performance: Bucket breakout force (The force generated by the bucket tilt cylinders when crowding the bucket) and Lift arm breakout force (The force produced by the lift cylinders when raising the boom). Both matter. A machine with strong bucket breakout but weak lift performance will fill the bucket efficiently but struggle to carry heavy loads at height — a real limitation when loading tall haul trucks."
            },
            {
                title: "Lift Capacity & Rated Payload",
                sub: "Tipping Safety Margin",
                price: "1-Ton Stability Standard",
                desc: "Lift capacity defines how much weight the loader can safely pick up and carry. The rated operating capacity (ROC) is typically set at 50 percent of the tipping load, providing a working margin that keeps the machine stable during normal operation. Running a loader at or beyond its ROC continuously stresses the frame, axles, and tires and degrades long-term reliability. Matching the machine's lift capacity to your typical loaded bucket weight keeps performance consistent and protects the drivetrain. For operations where the loader frequently works at height — feeding elevated hoppers or loading high-sided trucks — evaluate the machine's lift capacity at full height, not just at ground level. Capacity ratings often drop as the boom extends to maximum height."
            },
            {
                title: "Bucket Capacity & Fill Performance",
                sub: "Volumetric Yield Metrics",
                price: "Custom Duty Material Fit",
                desc: "Rated bucket capacity gives you the volumetric baseline, but actual productivity depends on how consistently the machine fills that bucket in real material. Fill factor — the percentage of rated capacity actually achieved in working conditions — varies significantly by material type and bucket design. A well-designed bucket for your specific material improves fill performance without overloading the machine. For example: Rock and shot material requires a heavy-duty, low-profile bucket with reinforced cutting edges; Loose aggregate and sand benefits from a high-capacity general-purpose bucket; Silage and light bulk materials may call for a high-tip bucket with extended capacity. Evaluate bucket options carefully alongside the machine. The right bucket matched to your material can meaningfully improve material moved per hour without increasing machine size or fuel consumption."
            },
            {
                title: "Hydraulic Flow Performance",
                sub: "Load Sensing Variable Valve",
                price: "Responsive Pilot Pressure",
                desc: "The hydraulic system is the foundation of a wheel loader's work capability. It powers the lift arms, controls bucket movement, and drives attachments. Hydraulic performance directly determines how fast and responsive the machine feels during a full work cycle. Key hydraulic specifications include: Maximum hydraulic flow rate (Higher flow means faster, more responsive movement and supports more demanding attachments); System pressure (Higher operating pressure enables greater breakout and lift force); Load-sensing hydraulics. These systems adjust flow based on actual demand rather than running at constant pressure, reducing energy waste and improving fuel efficiency. A load-sensing hydraulic system is a significant performance advantage. It allows the loader to dedicate full hydraulic energy to the active function rather than dissipating unused pressure as heat, which improves both response and efficiency across the work cycle."
            },
            {
                title: "Cycle Times & Quick Response",
                sub: "Continuous Load & Carry",
                price: "High-Speed Loop Configuration",
                desc: "Cycle time — the time it takes to complete one full load, carry, dump, and return sequence — is one of the clearest measures of productive output. Faster cycle times mean more material moved per hour, which translates directly to higher project efficiency and lower cost per ton. The hydraulic system, transmission response, and machine articulation all affect cycle time. A machine with fast hydraulic response raises and dumps the bucket quickly. A transmission that shifts smoothly without hesitation minimizes time lost between load and carry phases. When evaluating cycle times, consider: Raise time (How quickly the boom lifts from ground level to full dump height); Dump time (How fast the bucket tilts to release material); Return time (How quickly the boom lowers and the bucket rolls back to dig position). Shaving seconds off each cycle adds up significantly over an eight-hour shift, especially in high-production loading environments."
            }
        ];

        function swapFeatureContext(specIdx, targetCard) {
            document.querySelectorAll('.spec-selection-button').forEach(btn => {
                btn.classList.remove('active-feature');
            });
            targetCard.classList.add('active-feature');

            const currentItem = operationalSpecs[specIdx];
            document.getElementById('main-title-view').innerHTML = `OPTIMIZED <span>${currentItem.title.toUpperCase()}</span> PROFILE`;
            document.getElementById('main-desc-view').innerHTML = currentItem.desc;
            document.getElementById('card-feature-title').innerText = currentItem.title;
            document.getElementById('card-feature-sub').innerText = currentItem.price + " — " + currentItem.sub;
            document.getElementById('primary-action-btn').innerText = "Shop " + currentItem.title;
            document.getElementById('secondary-action-btn').innerText = "Configure " + currentItem.title + " →";
        }
    </script>
</body>
</html>
