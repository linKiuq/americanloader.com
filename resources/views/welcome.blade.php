<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.head-favicon')
    @include('partials.seo', [
        'title' => 'The Power Loader | Skoop Loader, Wheel Loader & Heavy Equipment',
        'description' => 'Shop The Power Loader at cwqv.com for Skoop loader and wheel loader equipment, skid steer loaders, mini excavators, attachments, forklifts, scissor lifts, and jobsite equipment for sale in the USA.',
        'keywords' => 'The Power Loader, Power Loader equipment, cwqv, cwqv.com, Skoop loader, wheel loader, Skoop wheel loader, wheel loaders for sale, compact wheel loader, skid steer loader attachments, mini excavators for sale',
        'jsonLd' => [
            '@graph' => [
                [
                    '@type' => 'ItemList',
                    '@id' => config('seo.site_url') . '/#featured-equipment',
                    'name' => 'Featured Skoop loader and wheel loader equipment categories',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Skoop loader equipment', 'url' => config('seo.site_url') . '/equipment'],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Compact wheel loaders', 'url' => config('seo.site_url') . '/equipment'],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => 'Skid steer attachments', 'url' => config('seo.site_url') . '/attachments'],
                        ['@type' => 'ListItem', 'position' => 4, 'name' => 'Forklifts and lifts', 'url' => config('seo.site_url') . '/equipment'],
                    ],
                ],
            ],
        ],
    ])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Inter:wght@400;500;600;700;900&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        skoopYellow: '#facc15',
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
            max-width: 940px;
            margin: 0 auto;
            position: relative;
            height: 510px;
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

        #attachments {
            background: #0b101a;
        }

        #attachments .skp-feature-card {
            background: #0f172a !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            border-radius: 1rem;
            box-shadow: 0 26px 60px rgba(0, 0, 0, 0.35);
        }

        #attachments .skp-feature-card > div:first-child {
            background: #111827 !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            border-left-color: #facc15 !important;
            border-left-width: 4px;
            overflow: hidden;
        }

        #attachments .skp-feature-card > div:first-child img {
            filter: brightness(0.88);
        }

        #attachments .skp-feature-card > div:last-child {
            background: rgba(15, 23, 42, 0.96) !important;
            gap: 1rem;
            padding: 1.25rem 1.5rem !important;
        }

        #attachments .skp-feature-card > div:last-child div:first-child span {
            color: #fde047 !important;
            font-size: 0.65rem;
        }

        #attachments .skp-feature-card > div:last-child h3 {
            color: #ffffff !important;
            font-size: clamp(1.15rem, 2.2vw, 1.45rem);
        }

        #attachments .skp-feature-card > div:last-child > div:last-child > span:first-child {
            color: #94a3b8 !important;
            font-size: 0.65rem;
        }

        #attachments .skp-feature-card > div:last-child > div:last-child > span:last-child {
            background: #facc15 !important;
            color: #0b101a !important;
            border-color: rgba(255, 255, 255, 0.16) !important;
            font-size: 0.65rem;
            padding: 0.55rem 0.9rem !important;
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
            min-height: calc(100svh - 82px);
            isolation: isolate;
            overflow: hidden;
            background:
                linear-gradient(180deg, rgba(3, 7, 18, 0.42) 0%, rgba(3, 7, 18, 0.34) 38%, rgba(3, 7, 18, 0.78) 100%),
                radial-gradient(circle at 50% 42%, rgba(250, 204, 21, 0.16), transparent 34%),
                url('{{ asset('hero-power-loader.png') }}') no-repeat center 42% !important;
            background-size: cover !important;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: clamp(4rem, 7vw, 7rem) clamp(1rem, 4vw, 4.5rem) clamp(2rem, 4vw, 3.75rem);
            box-sizing: border-box;
        }

        .industrial-hero-section::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background:
                linear-gradient(90deg, rgba(3, 7, 18, 0.5), transparent 25%, transparent 75%, rgba(3, 7, 18, 0.48)),
                linear-gradient(0deg, rgba(3, 7, 18, 0.52), transparent 32%);
            pointer-events: none;
        }

        .industrial-hero-section::after {
            content: "";
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(250, 204, 21, 0.65), transparent);
            pointer-events: none;
        }

        /* --- Global Grid Workspace Framework --- */
        .hero-main-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: clamp(1.75rem, 4vw, 3rem);
            align-items: center;
            justify-items: center;
            margin-top: auto;
            margin-bottom: auto;
            width: 100%;
            max-width: 1180px;
            align-self: center;
        }

        /* --- Left Column Content Side Styles --- */
        .left-content-panel {
            max-width: 980px;
            text-align: center;
        }

        .tag-pill {
            display: inline-flex;
            align-items: center;
            background: rgba(250, 204, 21, 0.14);
            color: #facc15;
            border: 1px solid rgba(250, 204, 21, 0.34);
            padding: 6px 14px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            margin-bottom: 22px;
            border-radius: 999px;
            backdrop-filter: blur(12px);
        }

        .hero-title {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(2.6rem, 6vw, 5.8rem);
            font-weight: 900;
            line-height: 0.98;
            text-transform: uppercase;
            letter-spacing: 0;
            margin-bottom: 24px;
            color: #ffffff !important;
            text-shadow: 0 14px 36px rgba(0, 0, 0, 0.42);
        }

        .hero-title span {
            color: #facc15 !important;
        }

        .hero-sub-description {
            font-size: clamp(1rem, 1.45vw, 1.2rem);
            line-height: 1.7;
            color: #ffffff !important;
            margin: 0 auto 34px;
            max-width: 820px;
            max-height: none;
            overflow: visible;
            padding-right: 0;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.54);
        }

        .hero-sub-description::-webkit-scrollbar {
            width: 4px;
        }
        .hero-sub-description::-webkit-scrollbar-thumb {
            background: #facc15;
            border-radius: 4px;
        }

        .button-group {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn-yellow {
            background-color: #facc15;
            color: #0b101a !important;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 18px 34px;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            transition: 0.2s;
            text-decoration: none;
            box-shadow: 0 18px 36px rgba(250, 204, 21, 0.2);
        }

        .btn-yellow:hover {
            background-color: #eab308;
        }

        .btn-outline {
            background: transparent;
            color: #ffffff !important;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 18px 34px;
            border: 1.5px solid rgba(255, 255, 255, 0.4);
            border-radius: 999px;
            cursor: pointer;
            transition: 0.2s;
            text-decoration: none;
            backdrop-filter: blur(12px);
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
            max-width: 920px;
        }

        .main-hero-card {
            background: rgba(3, 7, 18, 0.48);
            border: 1px solid rgba(250, 204, 21, 0.32);
            border-radius: 14px;
            padding: 18px 22px;
            backdrop-filter: blur(12px);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .main-hero-card-tag {
            color: #facc15;
            font-size: 0.68rem;
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
            font-size: clamp(1.05rem, 2vw, 1.35rem);
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
            grid-template-columns: repeat(6, minmax(0, 1fr));
            gap: 10px;
        }

        .spec-selection-button {
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            cursor: pointer;
            backdrop-filter: blur(8px);
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 112px;
        }

        .spec-selection-button:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.25);
        }

        .spec-selection-button.active-feature {
            background: rgba(250, 204, 21, 0.14);
            border-color: #facc15;
        }

        .spec-btn-icon {
            color: #facc15;
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
            gap: clamp(2rem, 8vw, 6rem);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 24px;
            margin-top: 34px;
            width: 100%;
            max-width: 1080px;
            align-self: center;
            justify-content: center;
            text-align: center;
        }

        .stat-node {
            display: flex;
            flex-direction: column;
        }

        .stat-number {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(1rem, 1.6vw, 1.2rem);
            font-weight: 800;
            letter-spacing: 0.03em;
            text-transform: uppercase;
            color: #ffffff !important;
        }

        .stat-label {
            font-size: 0.9rem;
            letter-spacing: 0.02em;
            color: #e2e8f0 !important;
            margin-top: 6px;
        }

        @media (max-width: 1024px) {
            .industrial-hero-section {
                min-height: calc(100svh - 82px);
                background-position: center 36% !important;
            }
            .hero-main-layout { gap: 36px; }
            .left-content-panel { max-width: 100%; }
            .secondary-cards-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .stats-footer-bar { gap: 30px; justify-content: center; }
        }

        @media (max-width: 600px) {
            .industrial-hero-section {
                min-height: calc(100svh - 74px);
                padding: 3rem 1rem 1.5rem;
            }
            .secondary-cards-grid { grid-template-columns: 1fr 1fr; }
            .main-hero-card {
                align-items: flex-start;
                flex-direction: column;
            }
            .stats-footer-bar { flex-wrap: wrap; gap: 18px; }
            .stat-node { width: 100%; }
            .skp-showcase-container { height: 400px; }
            #attachments .skp-feature-card > div:last-child {
                align-items: flex-start;
                flex-direction: column;
                padding: 1rem !important;
            }
        }
    </style>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-white text-gray-950 font-sans antialiased selection:bg-yellow-600 selection:text-white">

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
                    <a href="{{ route('equipment', ['category' => 'Wheel Loaders']) }}#catalog" class="btn-yellow" id="primary-action-btn">Shop Power Loader</a>
                    <a href="#specs" class="btn-outline">View All Specs</a>
                </div>
            </div>

            <div class="right-interactive-menu">
                <div class="main-hero-card">
                    <div class="main-hero-card-tag">// Active Selected Feature</div>
                    <div class="main-hero-card-title" id="card-feature-title">Engine Power and Torque</div>
                    <div class="main-hero-card-sub" id="card-feature-sub">Base Value — Torque Rise Parameters</div>
                    <a href="{{ route('product.show', 'new-typhon-telescopic-wheel-loader-with-kubota-d1105-engine-25-hp-1-ton-load-usa') }}" class="btn-yellow" style="display: inline-block; padding: 10px 20px; font-size: 0.75rem;" id="secondary-action-btn">Configure Asset &rarr;</a>
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
                <div class="stat-number">Shipping Sitewide</div>
                <div class="stat-label">Free US shipping</div>
            </div>
            <div class="stat-node">
                <div class="stat-number">Return Policy</div>
                <div class="stat-label">30 Days return &amp; Exchange</div>
            </div>
            <div class="stat-node">
                <div class="stat-number">1 Year Warranty</div>
                <div class="stat-label">On all equipment purchases</div>
            </div>
        </div>
    </section>

    <section id="wheel-loader-solutions" class="overflow-hidden border-b border-yellow-400/10 bg-slate-950 py-20 text-white lg:py-28">
        <div class="mx-auto max-w-7xl px-6 lg:px-12">
            <div class="grid items-center gap-12 lg:grid-cols-12 lg:gap-16">
                <div class="relative flex flex-col justify-center lg:col-span-5">
                    <div class="aspect-[4/5] w-full overflow-hidden rounded-3xl border border-white/10 bg-slate-900 shadow-2xl lg:h-[620px]">
                        <img
                            src="https://electricforklift.org/wp-content/uploads/2026/05/ChatGPT-Image-May-27-2026-02_03_58-PM.png"
                            alt="TYPHON wheel loader machine"
                            class="h-full w-full object-cover transition duration-700 hover:scale-105"
                        >
                    </div>
                    <div class="absolute -bottom-6 left-4 w-[205px] rounded-3xl border border-yellow-200/30 bg-yellow-400 p-6 text-slate-950 shadow-2xl sm:-right-6 sm:left-auto sm:w-[245px] sm:p-8">
                        <h3 class="text-4xl font-black sm:text-5xl">15+</h3>
                        <p class="mt-2 text-sm font-bold leading-snug sm:text-base">
                            Years of Heavy Equipment Experience
                        </p>
                    </div>
                </div>

                <div class="mt-10 flex flex-col justify-center lg:col-span-7 lg:mt-0">
                    <div class="mb-4 inline-flex items-center gap-3">
                        <span class="h-[3px] w-12 bg-yellow-400"></span>
                        <p class="text-xs font-bold uppercase tracking-[4px] text-yellow-400 sm:text-sm">
                            Wheel Loader Solutions
                        </p>
                    </div>

                    <h2 class="mb-6 text-4xl font-black leading-tight text-white lg:text-5xl xl:text-6xl" style="font-family: 'Montserrat', sans-serif;">
                        Powerful Wheel Loaders <br>
                        <span class="text-yellow-400">Built for Serious Work</span>
                    </h2>

                    <p class="mb-8 max-w-2xl text-base leading-relaxed text-slate-300 sm:text-lg">
                        Our wheel loaders are engineered for strength, durability, and productivity across construction, agriculture, mining, and industrial jobsites. Designed for operator control and dependable output, these machines stay productive in demanding conditions.
                    </p>

                    <div class="mb-10 grid gap-4 sm:grid-cols-2 sm:gap-5">
                        <div class="flex items-start gap-4 rounded-2xl border border-white/10 bg-white/[0.04] p-4 transition hover:border-yellow-400/40 hover:bg-white/[0.07]">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-yellow-400 text-xl font-bold text-slate-950">+</div>
                            <div>
                                <h3 class="mb-1 text-lg font-bold text-white">High Performance</h3>
                                <p class="text-sm leading-relaxed text-slate-400">Built to handle demanding workloads with powerful lifting capacity.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 rounded-2xl border border-white/10 bg-white/[0.04] p-4 transition hover:border-yellow-400/40 hover:bg-white/[0.07]">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-yellow-400 text-xl font-bold text-slate-950">01</div>
                            <div>
                                <h3 class="mb-1 text-lg font-bold text-white">Reliable Technology</h3>
                                <p class="text-sm leading-relaxed text-slate-400">Advanced engineering supports efficiency and long-term durability.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 rounded-2xl border border-white/10 bg-white/[0.04] p-4 transition hover:border-yellow-400/40 hover:bg-white/[0.07]">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-yellow-400 text-xl font-bold text-slate-950">HD</div>
                            <div>
                                <h3 class="mb-1 text-lg font-bold text-white">Heavy Duty Design</h3>
                                <p class="text-sm leading-relaxed text-slate-400">Tough construction built for harsh, continuous operations.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 rounded-2xl border border-white/10 bg-white/[0.04] p-4 transition hover:border-yellow-400/40 hover:bg-white/[0.07]">
                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-yellow-400 text-xl font-bold text-slate-950">04</div>
                            <div>
                                <h3 class="mb-1 text-lg font-bold text-white">Multiple Applications</h3>
                                <p class="text-sm leading-relaxed text-slate-400">Suitable for construction, farming, and material handling.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-4 sm:flex-row">
                        <a href="{{ route('equipment', ['category' => 'Wheel Loaders']) }}#catalog" class="rounded-lg bg-yellow-400 px-8 py-4 text-center text-sm font-bold uppercase tracking-wider text-slate-950 shadow-lg transition hover:bg-yellow-500 sm:py-5">
                            Explore Wheel Loaders
                        </a>
                        <a href="{{ route('contact') }}" class="rounded-lg border border-white/40 px-8 py-4 text-center text-sm font-bold uppercase tracking-wider text-white transition hover:border-yellow-400 hover:text-yellow-300 sm:py-5">
                            Contact Our Team
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="jobsite-applications" class="py-24 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:items-start">
                <div class="lg:col-span-5">
                    <span class="text-skoopYellow font-black text-xs uppercase tracking-widest mb-3 block">// JOBSITE APPLICATIONS</span>
                    <h2 style="font-family: 'Archivo Black', sans-serif;" class="text-3xl md:text-5xl font-black uppercase tracking-tight leading-tight text-slate-950">
                        Compact loaders built for the work you actually do
                    </h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Picture the machine in your own yard, farm, warehouse, or construction site. Power Loader equipments are positioned for crews that need practical lift power, compact movement, attachment flexibility, and fast support before and after purchase.
                    </p>
                    <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                        <a href="{{ route('equipment') }}#catalog" class="inline-flex items-center justify-center rounded-lg bg-slate-950 px-7 py-4 text-sm font-black uppercase tracking-[0.18em] text-white transition hover:bg-slate-800">
                            Browse Equipment
                        </a>
                        <a href="{{ route('topics.show', 'buy-guides') }}" class="inline-flex items-center justify-center rounded-lg border border-slate-300 px-7 py-4 text-sm font-black uppercase tracking-[0.18em] text-slate-950 transition hover:border-yellow-400 hover:text-yellow-600">
                            Read Buyer Guide
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <article class="rounded-2xl border border-gray-200 bg-slate-50 p-6">
                            <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-400 text-slate-950">
                                <i data-lucide="hard-hat" class="h-6 w-6"></i>
                            </div>
                            <h3 class="text-lg font-black uppercase tracking-tight text-slate-950">Construction sites</h3>
                            <p class="mt-3 text-sm leading-6 text-gray-600">Move aggregate, backfill trenches, clear debris, stage pallets, and support crews where a full-size loader takes up too much space.</p>
                        </article>

                        <article class="rounded-2xl border border-gray-200 bg-slate-50 p-6">
                            <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-400 text-slate-950">
                                <i data-lucide="tractor" class="h-6 w-6"></i>
                            </div>
                            <h3 class="text-lg font-black uppercase tracking-tight text-slate-950">Farms and land work</h3>
                            <p class="mt-3 text-sm leading-6 text-gray-600">Handle feed, soil, mulch, gravel, fencing supplies, logs, and general property maintenance with a compact machine that is easy to maneuver.</p>
                        </article>

                        <article class="rounded-2xl border border-gray-200 bg-slate-50 p-6">
                            <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-400 text-slate-950">
                                <i data-lucide="warehouse" class="h-6 w-6"></i>
                            </div>
                            <h3 class="text-lg font-black uppercase tracking-tight text-slate-950">Yards and warehouses</h3>
                            <p class="mt-3 text-sm leading-6 text-gray-600">Support daily material handling, outdoor storage, loading docks, equipment staging, and pallet movement without tying up larger machines.</p>
                        </article>

                        <article class="rounded-2xl border border-gray-200 bg-slate-50 p-6">
                            <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-400 text-slate-950">
                                <i data-lucide="trees" class="h-6 w-6"></i>
                            </div>
                            <h3 class="text-lg font-black uppercase tracking-tight text-slate-950">Landscaping crews</h3>
                            <p class="mt-3 text-sm leading-6 text-gray-600">Load mulch, prep surfaces, carry stone, remove brush, and switch attachments quickly during residential or commercial outdoor projects.</p>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="loader-buying-support" class="py-24 bg-slate-950 border-b border-white/10 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:items-center">
                <div class="lg:col-span-6">
                    <span class="text-yellow-400 font-black text-xs uppercase tracking-widest mb-3 block">// BUY WITH CLARITY</span>
                    <h2 style="font-family: 'Archivo Black', sans-serif;" class="text-3xl md:text-5xl font-black uppercase tracking-tight leading-tight">
                        From loader selection to delivery planning
                    </h2>
                    <p class="mt-6 text-lg leading-8 text-slate-300">
                        Choosing the right Skoop loader or wheel loader is easier when the machine is matched to your material, lift height, surface conditions, attachments, and transport needs. Our site brings equipment details, product pages, application guidance, and contact support together so buyers can make a confident decision.
                    </p>
                </div>

                <div class="lg:col-span-6">
                    <div class="grid gap-4">
                        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6">
                            <div class="flex gap-4">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-yellow-400 text-sm font-black text-slate-950">01</span>
                                <div>
                                    <h3 class="text-lg font-black uppercase tracking-tight">Match the work</h3>
                                    <p class="mt-2 text-sm leading-6 text-slate-400">Start with the materials you move, travel distance, lift height, bucket size, ground conditions, and how often you need attachments.</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6">
                            <div class="flex gap-4">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-yellow-400 text-sm font-black text-slate-950">02</span>
                                <div>
                                    <h3 class="text-lg font-black uppercase tracking-tight">Compare real specs</h3>
                                    <p class="mt-2 text-sm leading-6 text-slate-400">Review engine type, rated load, dump height, gradeability, hydraulic performance, operating weight, dimensions, and attachment compatibility.</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6">
                            <div class="flex gap-4">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-yellow-400 text-sm font-black text-slate-950">03</span>
                                <div>
                                    <h3 class="text-lg font-black uppercase tracking-tight">Plan support early</h3>
                                    <p class="mt-2 text-sm leading-6 text-slate-400">Ask about delivery timing, warranty coverage, parts availability, maintenance routines, and which attachments should be ordered with the machine.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section class="py-24 bg-slate-50 border-t border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-skoopYellow font-black text-xs uppercase tracking-widest mb-2 block">// EXPLORE OUR FLEET</span>
                <h2 style="font-family: 'Archivo Black', sans-serif;" class="text-4xl md:text-5xl uppercase tracking-tight">Featured Wheel Loader Models</h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Shop the top loader machines from our equipment catalog, including the new Telescopic Wheel Loader, Thunder VI, and TYPHON TERROR Backhoe Loader.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <article class="group bg-white border border-gray-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-lg transition duration-300">
                    <div class="relative overflow-hidden h-72 bg-gray-100">
                        <img src="https://machinery.online/wp-content/uploads/2026/02/TYPHON-Wheel-Loader-with-Kubota-D1105-engine8-1.jpg" alt="New TYPHON Telescopic Wheel Loader" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        <span class="absolute top-4 left-4 bg-skoopYellow text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full">Wheel Loaders</span>
                    </div>
                    <div class="p-6">
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-3">Equipment</p>
                        <h3 class="text-lg font-black uppercase tracking-tight text-gray-950 mb-3">New TYPHON Telescopic Wheel Loader</h3>
                        <p class="text-sm text-gray-600 mb-6">Kubota D1105 engine, 25 hp, 1 ton load capacity, built for tight site loading and reliable material handling.</p>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-gray-950 text-lg font-black">Quote on request</span>
                            <a href="{{ route('product.show', 'new-typhon-telescopic-wheel-loader-with-kubota-d1105-engine-25-hp-1-ton-load-usa') }}" class="inline-flex items-center justify-center bg-skoopYellow hover:bg-yellow-700 text-white text-sm font-black uppercase tracking-[0.18em] px-4 py-3 rounded-2xl transition">View</a>
                        </div>
                    </div>
                </article>

                <article class="group bg-white border border-gray-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-lg transition duration-300">
                    <div class="relative overflow-hidden h-72 bg-gray-100">
                        <img src="https://machinery.online/wp-content/uploads/2025/03/TYPHON-Thunder-VI-23hp-EPA-BS-Engine-Wheel-Loader-scaled-1.webp" alt="TYPHON Thunder VI Wheel Loader" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        <span class="absolute top-4 left-4 bg-skoopYellow text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full">Wheel Loaders</span>
                    </div>
                    <div class="p-6">
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-3">Equipment</p>
                        <h3 class="text-lg font-black uppercase tracking-tight text-gray-950 mb-3">TYPHON Thunder VI 23hp</h3>
                        <p class="text-sm text-gray-600 mb-6">EPA B&S engine wheel loader engineered for agile site work, fast loading, and reliable performance.</p>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-gray-950 text-lg font-black">Quote on request</span>
                            <a href="{{ route('product.show', 'typhon-thunder-vi-23hp-epa-b-s-engine-wheel-loader-usa') }}" class="inline-flex items-center justify-center bg-skoopYellow hover:bg-yellow-700 text-white text-sm font-black uppercase tracking-[0.18em] px-4 py-3 rounded-2xl transition">View</a>
                        </div>
                    </div>
                </article>

                <article class="group bg-white border border-gray-200 rounded-3xl overflow-hidden shadow-sm hover:shadow-lg transition duration-300">
                    <div class="relative overflow-hidden h-72 bg-gray-100">
                        <img src="https://machinery.online/wp-content/uploads/2025/03/Brand-New-TYPHON-TERROR-4WD-Backhoe-Loader-USA.webp" alt="Brand New TYPHON TERROR 4WD Backhoe Loader" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                        <span class="absolute top-4 left-4 bg-skoopYellow text-white text-[10px] font-black uppercase tracking-widest px-3 py-1 rounded-full">Wheel Loaders</span>
                    </div>
                    <div class="p-6">
                        <p class="text-xs uppercase tracking-[0.3em] text-gray-500 mb-3">Equipment</p>
                        <h3 class="text-lg font-black uppercase tracking-tight text-gray-950 mb-3">TYPHON TERROR 4WD Backhoe Loader</h3>
                        <p class="text-sm text-gray-600 mb-6">Heavy-duty 4WD backhoe loader for tough digging, loading, and yard-moving jobs.</p>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-gray-950 text-lg font-black">Quote on request</span>
                            <a href="{{ route('product.show', 'brand-new-typhon-terror-4wd-backhoe-loader-usa') }}" class="inline-flex items-center justify-center bg-skoopYellow hover:bg-yellow-700 text-white text-sm font-black uppercase tracking-[0.18em] px-4 py-3 rounded-2xl transition">View</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>



    <section id="attachments" class="py-16 lg:py-20 bg-slate-950 border-t border-b border-white/10 text-white">
        <div class="flex flex-col items-center justify-center mb-10 px-4 text-center">
            <span class="text-yellow-400 font-black text-xs uppercase tracking-widest mb-2">// CORE ECOSYSTEM CONFIGURATOR</span>
            <h2 style="font-family: 'Montserrat', sans-serif;" class="text-3xl md:text-5xl font-black uppercase tracking-tight text-white">System Attachments</h2>
            <div class="w-24 h-1 bg-yellow-400 rounded mt-4"></div>
        </div>

        <div class="skp-showcase-container px-6">

            <div class="skp-feature-card active-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8017" data-title="Ditching Machine" data-img="https://minexcavators.com/wp-content/uploads/2026/05/430332ee-3571-46c6-99b1-89a47c2629e9.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/430332ee-3571-46c6-99b1-89a47c2629e9.png" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-01</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Ditching Machine</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8017</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-yellow-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>




            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8001" data-title="Wheel Loader" data-img="{{ $originalHeroImage }}" data-fallback-img="{{ $heroFallbackImage }}">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="{{ $originalHeroImage }}" onerror="this.onerror=null; this.src='{{ $heroFallbackImage }}';" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-00</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Wheel Loader</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8001</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-yellow-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8012" data-title="Enclosed Sweeper" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_37_17-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_37_17-PM.png" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-02</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Enclosed Sweeper</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8012</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-yellow-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8006" data-title="4-in-1 Bucket" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_44_57-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_44_57-PM.png" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-03</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">4-in-1 Bucket</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8006</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-yellow-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8005" data-title="Hydraulic Fork" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_50_17-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_50_17-PM.png" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-04</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Hydraulic Fork</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8005</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-yellow-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8008" data-title="Grass Grapple" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_55_29-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_55_29-PM.png" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-05</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Grass Grapple</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8008</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-yellow-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8009" data-title="Drilling Rig" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_58_15-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_58_15-PM.png" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-06</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Drilling Rig</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8009</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-yellow-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8007" data-title="Log Grapple" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_00_54-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_00_54-PM.png" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-07</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Log Grapple</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8007</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-yellow-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8023" data-title="Lawn Mower" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_03_17-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_03_17-PM.png" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-08</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Lawn Mower</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8023</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-yellow-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8026" data-title="Reclamation Tool" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_05_08-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_05_08-PM.png" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-09</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Reclamation Tool</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8026</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-yellow-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8013" data-title="Hydraulic Breaker" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_12_47-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_12_47-PM.png" class="w-full h-full object-cover transition duration-500">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-10</span>
                        <h3 class="font-black uppercase tracking-tight text-gray-950 text-3xl">Hydraulic Breaker</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8013</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-yellow-400/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

        </div>

        <div class="flex justify-center gap-3 mt-7" id="rotation-dots"></div>
    </section>

     <section id="why-choose" class="py-24 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-5xl space-y-8">
                    <div>
                        <span class="inline-flex items-center gap-2 rounded-full bg-skoopYellow/10 px-4 py-2 text-skoopYellow text-xs font-black uppercase tracking-[0.35em]">Equipment Features</span>
                        <h2 style="font-family: 'Archivo Black', sans-serif;" class="mt-6 text-4xl md:text-5xl font-black tracking-tight text-slate-950 leading-tight">Why choose the SKOOP for compact loader work?</h2>
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
    </section>

    <section id="specs" class="py-20 bg-gray-50 border-t border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-12 text-center">
                <h2 style="font-family: 'Archivo Black', sans-serif;" class="text-3xl md:text-5xl font-extrabold uppercase tracking-tight">The Power Inside</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-8 rounded-xl border border-gray-200 hover:border-skoopYellow transition duration-300 group">
                    <i data-lucide="arrow-up-to-line" class="text-skoopYellow w-10 h-10 mb-6 group-hover:scale-110 transition"></i>
                    <h3 class="text-xl font-bold uppercase mb-2">Telescopic Lift Power</h3>
                    <p class="text-gray-600">2,825mm max dump height for clearing high truck beds easily.</p>
                </div>
                <div class="bg-white p-8 rounded-xl border border-gray-200 hover:border-skoopYellow transition duration-300 group">
                    <i data-lucide="zap" class="text-skoopYellow w-10 h-10 mb-6 group-hover:scale-110 transition"></i>
                    <h3 class="text-xl font-bold uppercase mb-2">Kubota Diesel Engines</h3>
                    <p class="text-gray-600">Reliable water-cooled D1105 engines built for heavy industrial endurance.</p>
                </div>
                <div class="bg-white p-8 rounded-xl border border-gray-200 hover:border-skoopYellow transition duration-300 group">
                    <i data-lucide="weight" class="text-skoopYellow w-10 h-10 mb-6 group-hover:scale-110 transition"></i>
                    <h3 class="text-xl font-bold uppercase mb-2">Heavy-Duty Stability</h3>
                    <p class="text-gray-600">Up to 4,600 lbs machine weight distribution preventing standard tipping risks.</p>
                </div>
                <div class="bg-white p-8 rounded-xl border border-gray-200 hover:border-skoopYellow transition duration-300 group">
                    <i data-lucide="mountain-snow" class="text-skoopYellow w-10 h-10 mb-6 group-hover:scale-110 transition"></i>
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
                    <span class="text-skoopYellow font-black text-xs uppercase tracking-widest mb-3 block">// KUBOTA D1105 RELIABILITY CORE</span>
                    <h2 style="font-family: 'Archivo Black', sans-serif;" class="text-3xl md:text-5xl font-black uppercase tracking-tight leading-tight mb-6">
                        How the Kubota D1105 Engine Makes the TYPHON SKOOP Reliable for Daily Work
                    </h2>
                    <p class="text-lg text-gray-600 font-medium mb-8">
                        Daily loader work needs steady torque, predictable cooling, and serviceable parts. The Kubota D1105 gives the SKOOP a proven diesel platform built for long shifts, repeat starts, and practical upkeep.
                    </p>
                    <div class="bg-gray-50 border-l-8 border-skoopYellow p-6 rounded-r-xl">
                        <div class="flex items-start gap-4">
                            <i data-lucide="message-square-text" class="text-skoopYellow w-8 h-8 flex-shrink-0"></i>
                            <p class="text-gray-700 font-semibold">
                                Community discussions often mention Kubota engines for their long-term serviceability and parts availability.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="bg-white p-7 rounded-xl border border-gray-200 hover:border-skoopYellow transition duration-300 group">
                        <i data-lucide="fuel" class="text-skoopYellow w-9 h-9 mb-5 group-hover:scale-110 transition"></i>
                        <h3 class="text-lg font-black uppercase mb-2">Fuel Efficiency</h3>
                        <p class="text-gray-600">The compact three-cylinder diesel layout is tuned for practical jobsite fuel use, helping crews keep operating costs controlled through long workdays.</p>
                    </div>
                    <div class="bg-white p-7 rounded-xl border border-gray-200 hover:border-skoopYellow transition duration-300 group">
                        <i data-lucide="shield-check" class="text-skoopYellow w-9 h-9 mb-5 group-hover:scale-110 transition"></i>
                        <h3 class="text-lg font-black uppercase mb-2">Durability</h3>
                        <p class="text-gray-600">Kubota's industrial diesel design supports steady low-speed torque and dependable operation under repeated loading, lifting, and travel cycles.</p>
                    </div>
                    <div class="bg-white p-7 rounded-xl border border-gray-200 hover:border-skoopYellow transition duration-300 group">
                        <i data-lucide="wrench" class="text-skoopYellow w-9 h-9 mb-5 group-hover:scale-110 transition"></i>
                        <h3 class="text-lg font-black uppercase mb-2">Easy Maintenance</h3>
                        <p class="text-gray-600">Straightforward service access and widely understood Kubota maintenance routines make routine checks, fluid service, and parts replacement simpler.</p>
                    </div>
                    <div class="bg-white p-7 rounded-xl border border-gray-200 hover:border-skoopYellow transition duration-300 group">
                        <i data-lucide="badge-check" class="text-skoopYellow w-9 h-9 mb-5 group-hover:scale-110 transition"></i>
                        <h3 class="text-lg font-black uppercase mb-2">Trusted Kubota Performance</h3>
                        <p class="text-gray-600">Kubota engines have a strong reputation across compact equipment, giving operators confidence in parts support and familiar service standards.</p>
                    </div>
                    <div class="sm:col-span-2 bg-skoopDark p-7 rounded-xl border border-slate-700 shadow-xl">
                        <div class="flex flex-col sm:flex-row sm:items-start gap-5">
                            <i data-lucide="droplets" class="text-yellow-300 w-10 h-10 flex-shrink-0"></i>
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

    <section id="field-loader-showcase" class="py-24 bg-slate-950 border-b border-white/10 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:items-center">
                <div class="lg:col-span-7">
                    <div class="overflow-hidden rounded-2xl border border-white/10 bg-slate-900 shadow-2xl">
                        <img src="{{ asset('wheel-loader-field-showcase.jpg') }}" alt="Heavy wheel loader with large bucket working on sandy jobsite" class="h-full w-full object-cover" width="1080" height="1208" loading="lazy" decoding="async">
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <span class="text-yellow-400 font-black text-xs uppercase tracking-widest mb-3 block">// HEAVY MATERIAL HANDLING</span>
                    <h2 style="font-family: 'Archivo Black', sans-serif;" class="text-3xl md:text-5xl font-black uppercase tracking-tight leading-tight">
                        Built for bucket work, stockpiles, and rough ground
                    </h2>
                    <p class="mt-6 text-lg leading-8 text-slate-300">
                        Large bucket work demands traction, stable lift geometry, responsive hydraulics, and enough machine weight to stay planted while moving dense material. This is the kind of jobsite environment where a wheel loader earns its place every shift.
                    </p>

                    <div class="mt-8 grid gap-4">
                        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5">
                            <h3 class="text-sm font-black uppercase tracking-[0.24em] text-yellow-300">High-volume loading</h3>
                            <p class="mt-3 text-sm leading-6 text-slate-400">Move sand, gravel, soil, aggregate, and debris with a bucket profile designed for repeated dig, carry, and dump cycles.</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5">
                            <h3 class="text-sm font-black uppercase tracking-[0.24em] text-yellow-300">Stable jobsite control</h3>
                            <p class="mt-3 text-sm leading-6 text-slate-400">A wide stance, large tires, and strong loader arms help operators stay confident across loose surfaces and uneven haul paths.</p>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-5">
                            <h3 class="text-sm font-black uppercase tracking-[0.24em] text-yellow-300">Daily production focus</h3>
                            <p class="mt-3 text-sm leading-6 text-slate-400">For contractors, farms, yards, and material sites, the right loader reduces handling time and keeps trucks, bins, and stockpiles moving.</p>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                        <a href="{{ route('equipment', ['category' => 'Wheel Loaders']) }}#catalog" class="inline-flex items-center justify-center rounded-lg bg-yellow-400 px-7 py-4 text-sm font-black uppercase tracking-[0.18em] text-slate-950 transition hover:bg-yellow-300">
                            View Loaders
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-lg border border-white/30 px-7 py-4 text-sm font-black uppercase tracking-[0.18em] text-white transition hover:border-yellow-400 hover:text-yellow-300">
                            Ask About Fit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="videos" class="py-20 bg-white border-t border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <span class="text-skoopYellow font-black text-xs uppercase tracking-widest mb-2 block">// VIDEO SHOWCASE</span>
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

    <section id="mo-mosaic-stories" class="py-24 bg-white border-t border-b border-gray-200" aria-labelledby="mo-delivery-title" itemscope itemtype="https://schema.org/ItemList">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-auto mb-14 max-w-3xl text-center">
                <span class="inline-flex items-center rounded-full bg-yellow-400/10 px-4 py-2 text-xs font-black uppercase tracking-[0.28em] text-yellow-600">First Encounter</span>
                <h2 id="mo-delivery-title" itemprop="name" style="font-family: 'Archivo Black', sans-serif;" class="mt-5 text-4xl md:text-5xl uppercase tracking-tight text-slate-950">Our Deliveries</h2>
                <p itemprop="description" class="mt-5 text-lg leading-8 text-gray-600">Raw moments from the field. We capture the exact moment operators and site managers take delivery of their engineered machinery.</p>
            </div>

            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4" role="list" aria-label="Machinery delivery gallery">
                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="1">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="https://skidsteers.org/wp-content/uploads/2026/05/image2-scaled.webp" alt="Skid steer delivery for Apex Excavation Group" class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-yellow-400 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-yellow-600">Skidsteers</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-slate-950">Apex Excavation Group</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">We were losing time on deep trenching. First look at the steel frame and the hydraulic lines, I knew this beast would handle the site.</p>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="2">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="https://machinery.org/wp-content/uploads/2026/03/machinery-delivery-skid-steer-loader-scaled.webp" alt="Skid steer loader delivery for Civil Pro Builders" class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-yellow-400 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-yellow-600">Skid Steer</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-slate-950">Civil Pro Builders</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">It just felt rugged. As soon as I stepped into the cage, the visibility and solid frame reassured the crew.</p>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="3">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="https://skidsteers.org/wp-content/uploads/2026/05/march-typhon-machinery-deliverys-7-1.jpeg" alt="Warehouse forklift delivery for Regional Logistics" class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-yellow-400 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-yellow-600">Warehouse Forklift</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-slate-950">Regional Logistics</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Silent mast operation was the first thing we tested. Huge relief for the narrow aisles in our facility.</p>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="4">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="https://skidsteers.org/wp-content/uploads/2026/05/image5.webp" alt="Typhon Series Loader delivery for Steelcore Mining Ops" class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-yellow-400 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-yellow-600">Typhon Series Loader</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-slate-950">Steelcore Mining Ops</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">You don't realize how big the bucket is until you're standing next to the tires. This will cut our material loading times in half.</p>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="5">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="https://skidsteers.org/wp-content/uploads/2026/05/image4.webp" alt="Agri Utility Series delivery for Valley Cultivators" class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-yellow-400 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-yellow-600">Agri/Utility Series</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-slate-950">Valley Cultivators</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">We needed torque without the massive footprint. The build quality on this unit is immaculate.</p>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="6">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="https://skidsteers.org/wp-content/uploads/2026/05/image3.webp" alt="Skidsteers delivery for Urban Development" class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-yellow-400 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-yellow-600">Skidsteers</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-slate-950">Urban Development</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Perfect for city infrastructure. Narrow enough for alleys, but zero compromise on the lifting power.</p>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="7">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="https://machinery.org/wp-content/uploads/2026/03/machinery-delivery-road-roller-scaled.webp" alt="Double drum roller delivery for Highway Tech Inc." class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-yellow-400 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-yellow-600">Double Drum Roller</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-slate-950">Highway Tech Inc.</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">The drum thickness is what sold us originally. Seeing it come off the trailer today confirmed it is built for serious road work.</p>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="8">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="https://machinery.org/wp-content/uploads/2026/03/machinery-delivery-skid-steer-scaled.webp" alt="Tracked skid steer delivery for Timber Supply Co." class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-yellow-400 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-yellow-600">Tracked Skid Steer</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-slate-950">Timber Supply Co.</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Needed raw power to punch through the mud. The undercarriage and track design are exactly what we ordered.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section id="feedback" class="py-20 bg-white border-t border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-skoopYellow font-black text-xs uppercase tracking-widest mb-2 block">// CUSTOMER FEEDBACK</span>
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

    <section id="home-faq" class="py-20 bg-slate-50 border-t border-gray-200">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-skoopYellow font-black text-xs uppercase tracking-widest mb-2 block">// COMMON BUYER QUESTIONS</span>
                <h2 style="font-family: 'Archivo Black', sans-serif;" class="text-3xl md:text-4xl uppercase tracking-tight text-slate-950">Helpful details before you choose a loader</h2>
            </div>

            <div class="divide-y divide-gray-200 rounded-2xl border border-gray-200 bg-white">
                <div class="p-6">
                    <h3 class="text-lg font-black text-slate-950">What size loader should I choose?</h3>
                    <p class="mt-3 text-sm leading-6 text-gray-600">Choose by your jobsite access, lift height, loaded bucket weight, terrain, and attachment needs. Compact loaders are a strong fit when maneuverability matters as much as power.</p>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-black text-slate-950">Can one loader handle multiple jobs?</h3>
                    <p class="mt-3 text-sm leading-6 text-gray-600">Yes. A loader with the right coupler and hydraulic setup can move between bucket work, fork handling, sweeping, grappling, light drilling, mowing, and cleanup tasks.</p>
                </div>
                <div class="p-6">
                    <h3 class="text-lg font-black text-slate-950">What should I ask before ordering?</h3>
                    <p class="mt-3 text-sm leading-6 text-gray-600">Confirm machine dimensions, operating weight, engine platform, rated load, dump height, warranty coverage, delivery details, parts support, and attachment compatibility.</p>
                </div>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <div id="skp-modal" class="skp-modal-overlay">
        <div class="bg-slate-950 border-2 border-yellow-400 rounded-2xl w-[90%] max-w-[750px] shadow-2xl overflow-hidden relative transform translate-y-8 scale-95 transition-all duration-300" id="skp-modal-content">
            <span class="absolute top-3 right-6 text-white text-4xl font-black cursor-pointer hover:text-yellow-400 transition z-10" id="skp-close-btn">&times;</span>
            <div class="bg-slate-900 p-6 flex items-center justify-center border-b border-white/10 h-[420px]">
                <img id="skp-modal-img" src="" alt="Blueprint Technical High Res View" class="w-full h-full object-contain">
            </div>
            <div class="p-6 text-center bg-slate-950">
                <span id="skp-modal-sku" class="block text-sm font-black text-yellow-400 tracking-widest uppercase mb-1"></span>
                <h3 id="skp-modal-title" class="text-2xl font-black uppercase text-white tracking-tight"></h3>
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
                dot.className = `w-3 h-3 rounded-full transition-all duration-300 ${index === 0 ? 'bg-yellow-400 w-8' : 'bg-slate-600'}`;
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
                dots[currentIndex].classList.remove('bg-yellow-400', 'w-8');
                dots[currentIndex].classList.add('bg-slate-600');

                currentIndex = index;

                cards[currentIndex].classList.add('active-card');
                dots[currentIndex].classList.remove('bg-slate-600');
                dots[currentIndex].classList.add('bg-yellow-400', 'w-8');
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
                price: "Base Value",
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
