<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.head-favicon')
    @include('partials.seo', [
        'title' => 'American Loader | Wheel Loaders, Skid Steers & Mini Excavators',
        'description' => 'Explore TYPHON wheel loaders, skid steer loaders, STORM mini excavators, forklifts, road rollers, scissor lifts, and machine attachments from American Loader.',
        'keywords' => config('seo.keywords'),
        'imageAlt' => 'American Loader wheel loaders and compact construction equipment',
        'jsonLd' => [
            '@graph' => [
                [
                    '@type' => 'ItemList',
                    '@id' => config('seo.site_url') . '/#featured-equipment',
                    'name' => 'American Loader equipment categories',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'TYPHON Wheel Loaders', 'url' => config('seo.site_url') . '/equipment?category=Wheel%20Loaders'],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Skid Steer Loaders', 'url' => config('seo.site_url') . '/equipment?category=Skid%20Steer%20Loaders'],
                        ['@type' => 'ListItem', 'position' => 3, 'name' => 'STORM Mini Excavators', 'url' => config('seo.site_url') . '/equipment?category=Mini%20Excavators'],
                        ['@type' => 'ListItem', 'position' => 4, 'name' => 'Mini Excavator Attachments', 'url' => config('seo.site_url') . '/equipment?category=Mini%20Excavator%20Attachments'],
                        ['@type' => 'ListItem', 'position' => 5, 'name' => 'Skid Steer Attachments', 'url' => config('seo.site_url') . '/equipment?category=Skid%20Steer%20Attachments'],
                        ['@type' => 'ListItem', 'position' => 6, 'name' => 'Electric Forklifts', 'url' => config('seo.site_url') . '/equipment?category=Forklifts'],
                        ['@type' => 'ListItem', 'position' => 7, 'name' => 'Road Rollers', 'url' => config('seo.site_url') . '/equipment?category=Road%20Rollers'],
                        ['@type' => 'ListItem', 'position' => 8, 'name' => 'Scissor Lifts', 'url' => config('seo.site_url') . '/equipment?category=Scissor%20Lifts'],
                    ],
                ],
            ],
        ],
    ])
    <link rel="preload" as="image" href="{{ asset('american-loader-hero-poster.jpg') }}" fetchpriority="high">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Inter:wght@400;500;600;700;900&family=Montserrat:wght@700;800;900&family=Oswald:wght@600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        skoopYellow: '#c91f2c',
                        skoopDark: '#0f172a',
                    }
                }
            }
        }
    </script>
    <style>
        /* --- ATTACHMENT ECOSYSTEM SHOWCASE --- */
        .skp-showcase-container {
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
            position: relative;
            height: clamp(430px, 48vw, 540px);
        }

        .skp-feature-card {
            position: absolute;
            inset: 0;
            opacity: 0;
            visibility: hidden;
            transform: translate3d(34px, 0, 0) scale(0.985);
            transition: opacity 0.65s cubic-bezier(0.22, 1, 0.36, 1),
                        transform 0.65s cubic-bezier(0.22, 1, 0.36, 1),
                        visibility 0.65s;
            z-index: 1;
        }

        .skp-feature-card.active-card {
            opacity: 1;
            visibility: visible;
            transform: scale(1) translateY(0);
            z-index: 10;
        }

        #attachments {
            position: relative;
            isolation: isolate;
            overflow: hidden;
            background:
                radial-gradient(circle at 8% 12%, rgba(201, 31, 44, 0.2), transparent 25rem),
                radial-gradient(circle at 94% 80%, rgba(30, 64, 175, 0.2), transparent 28rem),
                #071d38;
        }

        #attachments::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            opacity: 0.18;
            background-image:
                linear-gradient(rgba(255,255,255,.09) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,.09) 1px, transparent 1px);
            background-size: 72px 72px;
            mask-image: linear-gradient(to bottom, black, transparent 82%);
        }

        .skp-attachments-heading {
            max-width: 1280px;
            margin: 0 auto 1.5rem;
        }

        .skp-attachments-kicker {
            display: inline-flex;
            align-items: center;
            gap: .65rem;
            color: #f0444f;
        }

        .skp-attachments-kicker::before {
            content: "";
            width: 42px;
            height: 2px;
            background: currentColor;
        }

        .skp-attachment-controls > button {
            display: grid;
            width: 3rem;
            height: 3rem;
            place-items: center;
            border: 1px solid rgba(255,255,255,.2);
            border-radius: 999px;
            color: white;
            transition: .25s ease;
        }

        .skp-attachment-controls > button:hover {
            border-color: #c91f2c;
            background: #c91f2c;
            transform: translateY(-2px);
        }

        #attachments .skp-feature-card {
            background: #0f172a !important;
            border: 1px solid rgba(255, 255, 255, 0.16) !important;
            border-radius: 1.75rem;
            box-shadow: 0 36px 90px rgba(0, 0, 0, 0.42);
        }

        #attachments .skp-feature-card > div:first-child {
            position: relative;
            inset: auto;
            flex: 1 1 auto;
            min-height: 0;
            background: #08182b !important;
            border: 0 !important;
            overflow: hidden;
        }

        #attachments .skp-feature-card > div:first-child img {
            filter: brightness(0.82) saturate(1.08);
            object-fit: contain !important;
            object-position: center;
            transform: none;
        }

        #attachments .skp-feature-card.active-card > div:first-child img {
            animation: none;
        }

        #attachments .skp-feature-card > div:last-child {
            position: relative;
            inset: auto;
            z-index: 2;
            flex: 0 0 auto;
            background: #0b172b !important;
            backdrop-filter: none !important;
            gap: 1rem;
            padding: 1.4rem 1.75rem !important;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        #attachments .skp-feature-card > div:last-child div:first-child span {
            color: #fde047 !important;
            font-size: 0.65rem;
        }

        #attachments .skp-feature-card > div:last-child h3 {
            color: #ffffff !important;
            font-size: clamp(1.8rem, 4vw, 3.25rem);
            line-height: .95;
        }

        #attachments .skp-feature-card > div:last-child > div:last-child > span:first-child {
            color: #94a3b8 !important;
            font-size: 0.65rem;
        }

        #attachments .skp-feature-card > div:last-child > div:last-child > span:last-child {
            background: #c91f2c !important;
            color: #ffffff !important;
            border-color: rgba(255, 255, 255, 0.16) !important;
            font-size: 0.65rem;
            padding: 0.8rem 1.1rem !important;
            border-radius: 999px;
        }

        #mo-mosaic-stories [role="listitem"] {
            display: flex;
            flex-direction: column;
            box-shadow: 0 12px 32px rgba(7, 29, 56, 0.08);
        }

        #mo-mosaic-stories [role="listitem"] > div:first-of-type {
            aspect-ratio: 4 / 3 !important;
        }

        #mo-mosaic-stories [role="listitem"] > div:last-child {
            flex: 1 1 auto;
            border-top-width: 2px !important;
        }

        #mo-mosaic-stories .delivery-slider {
            display: flex;
            gap: 1.1rem;
            overflow-x: auto;
            padding: 0.25rem 0.15rem 1.25rem;
            scroll-behavior: smooth;
            scroll-snap-type: x mandatory;
            scrollbar-color: #c91f2c #e2e8f0;
            scrollbar-width: thin;
        }

        #mo-mosaic-stories .delivery-slider::-webkit-scrollbar {
            height: 7px;
        }

        #mo-mosaic-stories .delivery-slider::-webkit-scrollbar-track {
            border-radius: 999px;
            background: #e2e8f0;
        }

        #mo-mosaic-stories .delivery-slider::-webkit-scrollbar-thumb {
            border-radius: 999px;
            background: #c91f2c;
        }

        #mo-mosaic-stories .delivery-slider [role="listitem"] {
            position: relative;
            display: flex;
            min-height: 560px;
            flex: 0 0 clamp(290px, 29vw, 360px);
            flex-direction: column;
            padding-bottom: 2.8rem;
            scroll-snap-align: start;
            border-top: 3px solid #c91f2c;
            border-radius: 1rem;
            background: #fff;
        }

        #mo-mosaic-stories .delivery-slider [role="listitem"] > div:first-of-type {
            position: relative;
            top: auto;
            left: auto;
            z-index: 1;
            width: 100%;
            height: 280px;
            flex: 0 0 280px;
            aspect-ratio: auto !important;
            border: 0;
            border-bottom: 1px solid #e2e8f0;
            border-radius: 0;
            background: #eef2f7;
        }

        #mo-mosaic-stories .delivery-slider [role="listitem"] > div:first-of-type img {
            object-fit: contain !important;
            opacity: 1 !important;
        }

        #mo-mosaic-stories .delivery-slider [role="listitem"] > div:last-child {
            border: 0 !important;
            padding: 1.35rem;
        }

        #mo-mosaic-stories .delivery-slider [role="listitem"] span[itemprop="name"],
        #mo-mosaic-stories .delivery-slider [role="listitem"] h3 {
            display: block;
            margin-left: 0;
        }

        #mo-mosaic-stories .delivery-slider [role="listitem"] h3 {
            min-height: 3.25rem;
            margin-top: 0.35rem;
            padding-right: 1.5rem;
        }

        #mo-mosaic-stories .delivery-slider [role="listitem"] h3::after {
            content: "★★★★★";
            display: block;
            margin-top: 0.25rem;
            color: #c91f2c;
            font-size: 0.72rem;
            letter-spacing: 0.12em;
        }

        #mo-mosaic-stories .delivery-slider [role="listitem"] p {
            margin-top: 1.2rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        #mo-mosaic-stories .delivery-slider [role="listitem"]::before {
            content: "“";
            position: absolute;
            top: 17.9rem;
            right: 1rem;
            color: rgba(201, 31, 44, 0.12);
            font-family: Georgia, serif;
            font-size: 4.5rem;
            line-height: 1;
        }

        #mo-mosaic-stories .delivery-slider [role="listitem"]::after {
            content: "✓  Verified handover";
            position: absolute;
            right: 1.35rem;
            bottom: 1.15rem;
            color: #64748b;
            font-size: 0.68rem;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
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
            height: clamp(680px, calc(100svh - 96px), 920px);
            min-height: 0;
            isolation: isolate;
            overflow: hidden;
            background:
                linear-gradient(180deg, rgba(7, 29, 56, 0.42) 0%, rgba(7, 29, 56, 0.34) 38%, rgba(7, 29, 56, 0.78) 100%),
                radial-gradient(circle at 50% 42%, rgba(201, 31, 44, 0.16), transparent 34%),
                url('{{ asset('hero-power-loader.png') }}') no-repeat center 42% !important;
            background-size: cover !important;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: clamp(1.75rem, 3.5vh, 3rem) clamp(1rem, 4vw, 4.5rem);
            box-sizing: border-box;
        }

        .industrial-hero-section::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background:
                linear-gradient(90deg, rgba(7, 29, 56, 0.5), transparent 25%, transparent 75%, rgba(7, 29, 56, 0.48)),
                linear-gradient(0deg, rgba(7, 29, 56, 0.52), transparent 32%);
            pointer-events: none;
        }

        .industrial-hero-section::after {
            content: "";
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201, 31, 44, 0.65), transparent);
            pointer-events: none;
        }

        /* --- Global Grid Workspace Framework --- */
        .hero-main-layout {
            display: grid;
            grid-template-columns: 1fr;
            gap: clamp(1rem, 2.5vh, 1.75rem);
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
            background: rgba(201, 31, 44, 0.14);
            color: #c91f2c;
            border: 1px solid rgba(201, 31, 44, 0.34);
            padding: 6px 14px;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.75rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            margin-bottom: 14px;
            border-radius: 999px;
            backdrop-filter: blur(12px);
        }

        .hero-title {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(2.5rem, 4.8vw, 4.6rem);
            font-weight: 900;
            line-height: 0.98;
            text-transform: uppercase;
            letter-spacing: 0;
            margin-bottom: 16px;
            color: #ffffff !important;
            text-shadow: 0 14px 36px rgba(0, 0, 0, 0.42);
        }

        .hero-title span {
            color: #c91f2c !important;
        }

        .hero-sub-description {
            font-size: clamp(0.95rem, 1.15vw, 1.05rem);
            line-height: 1.55;
            color: #ffffff !important;
            margin: 0 auto 22px;
            max-width: 900px;
            max-height: none;
            overflow: visible;
            padding-right: 0;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.54);
        }

        .hero-sub-description::-webkit-scrollbar {
            width: 4px;
        }
        .hero-sub-description::-webkit-scrollbar-thumb {
            background: #c91f2c;
            border-radius: 4px;
        }

        .button-group {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .btn-yellow {
            background-color: #c91f2c;
            color: #0b101a !important;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 14px 28px;
            border: none;
            border-radius: 999px;
            cursor: pointer;
            transition: 0.2s;
            text-decoration: none;
            box-shadow: 0 18px 36px rgba(201, 31, 44, 0.2);
        }

        .btn-yellow:hover {
            background-color: #a91521;
        }

        .btn-outline {
            background: transparent;
            color: #ffffff !important;
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 14px 28px;
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
            gap: 10px;
            width: 100%;
            max-width: 920px;
        }

        .main-hero-card {
            background: rgba(7, 29, 56, 0.48);
            border: 1px solid rgba(201, 31, 44, 0.32);
            border-radius: 14px;
            padding: 13px 18px;
            backdrop-filter: blur(12px);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .main-hero-card-tag {
            color: #c91f2c;
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
            margin-bottom: 0;
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
            padding: 11px;
            text-align: center;
            cursor: pointer;
            backdrop-filter: blur(8px);
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 84px;
        }

        .spec-selection-button:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.25);
        }

        .spec-selection-button.active-feature {
            background: rgba(201, 31, 44, 0.14);
            border-color: #c91f2c;
        }

        .spec-btn-icon {
            color: #c91f2c;
            font-size: 1.3rem;
            margin-bottom: 6px;
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
                height: auto;
                min-height: calc(100svh - 72px);
                padding-top: 3rem;
                padding-bottom: 3rem;
                background-position: center 36% !important;
            }
            .hero-main-layout { gap: 36px; }
            .left-content-panel { max-width: 100%; }
            .secondary-cards-grid { grid-template-columns: repeat(3, minmax(0, 1fr)); }
            .stats-footer-bar { gap: 30px; justify-content: center; }
        }

        @media (max-width: 600px) {
            .industrial-hero-section {
                height: auto;
                min-height: calc(100svh - 70px);
                padding: 3rem 1rem 1.5rem;
            }
            .secondary-cards-grid { grid-template-columns: 1fr 1fr; }
            .main-hero-card {
                align-items: flex-start;
                flex-direction: column;
            }
            .stats-footer-bar { flex-wrap: wrap; gap: 18px; }
            .stat-node { width: 100%; }
            .skp-showcase-container { height: 440px; }
            #attachments .skp-feature-card > div:last-child {
                align-items: flex-start;
                flex-direction: column;
                padding: 1.1rem 1.25rem !important;
            }
            #attachments .skp-feature-card > div:last-child > div:last-child {
                align-items: flex-start;
                text-align: left;
            }
        }

        .brand-hero {
            background: #fff;
            padding: clamp(0.65rem, 1vw, 1rem);
        }

        .brand-hero__grid {
            display: grid;
            grid-template-columns: minmax(0, 2fr) minmax(320px, 1fr);
            gap: clamp(1rem, 1.5vw, 1.5rem);
            width: 100%;
            max-width: 1280px;
            margin: 0 auto;
        }

        .brand-hero__panel {
            position: relative;
            min-height: clamp(420px, calc(100svh - 330px), 500px);
            overflow: hidden;
            border: 1px solid rgba(7, 29, 56, 0.12);
            border-radius: 22px;
            background: #071d38;
            box-shadow: 0 22px 55px rgba(7, 29, 56, 0.16);
            isolation: isolate;
        }

        .brand-hero__poster {
            background-image:
                linear-gradient(180deg, rgba(3, 7, 18, 0.18), rgba(3, 7, 18, 0.9)),
                url('{{ asset('american-loader-hero-poster.jpg') }}');
            background-position: 68% center;
            background-size: cover;
        }

        .brand-hero__content {
            position: absolute;
            inset: 0;
            z-index: 2;
            display: flex;
            max-width: none;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            padding: clamp(1.4rem, 2.1vw, 2.15rem);
            color: #fff;
        }

        .brand-hero__eyebrow {
            margin-bottom: 1rem;
            color: #ef3443;
            font-family: "Oswald", "Arial Narrow", sans-serif;
            font-size: clamp(0.72rem, 1vw, 0.9rem);
            font-weight: 900;
            letter-spacing: 0.22em;
            text-transform: uppercase;
        }

        .brand-hero__title {
            max-width: 690px;
            color: #fff;
            font-family: "Oswald", "Arial Narrow", sans-serif;
            font-size: clamp(2.4rem, 3vw, 3.9rem);
            font-weight: 700;
            letter-spacing: -0.025em;
            line-height: 0.94;
            text-transform: uppercase;
            text-wrap: balance;
        }

        .brand-hero__description {
            max-width: 520px;
            margin-top: 1.15rem;
            color: #e2e8f0;
            font-size: clamp(0.95rem, 1.05vw, 1.08rem);
            line-height: 1.55;
        }

        .brand-hero__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 0.85rem;
            margin-top: 1.5rem;
        }

        .brand-hero__button {
            display: inline-flex;
            min-height: 52px;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            padding: 0.9rem 1.5rem;
            font-family: "Oswald", "Arial Narrow", sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-decoration: none;
            text-transform: uppercase;
            transition: transform 180ms ease, background-color 180ms ease, border-color 180ms ease;
        }

        .brand-hero__button:hover {
            transform: translateY(-2px);
        }

        .brand-hero__button--primary {
            color: #fff;
            background: #c91f2c;
            border: 1px solid #c91f2c;
        }

        .brand-hero__button--primary:hover {
            background: #a91521;
            border-color: #a91521;
        }

        .brand-hero__button--secondary {
            color: #fff;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(10px);
        }

        .brand-hero__button--secondary:hover {
            border-color: #fff;
            background: rgba(255, 255, 255, 0.14);
        }

        .brand-hero__video {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .brand-hero__video-panel::after {
            content: "";
            position: absolute;
            inset: 0;
            z-index: 1;
            background: linear-gradient(180deg, rgba(7, 29, 56, 0.1), rgba(7, 29, 56, 0.88));
            pointer-events: none;
        }

        .brand-hero__video-content {
            position: absolute;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 2;
            padding: clamp(1.35rem, 2.2vw, 2rem);
            color: #fff;
        }

        .brand-hero__shipping {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            width: 100%;
            max-width: 1280px;
            margin: 0.75rem auto 0;
            border-radius: 18px;
            padding: clamp(0.9rem, 1.25vw, 1.2rem) clamp(1.15rem, 2.25vw, 2.25rem);
            color: #fff;
            background: #c91f2c;
        }

        .brand-hero__shipping-message {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .brand-hero__shipping-icon {
            width: 40px;
            height: 40px;
            flex: none;
        }

        .brand-hero__shipping strong {
            display: block;
            font-family: "Oswald", "Arial Narrow", sans-serif;
            font-size: clamp(1.25rem, 1.7vw, 1.65rem);
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .brand-hero__shipping span {
            display: block;
            margin-top: 0.15rem;
            color: rgba(255, 255, 255, 0.86);
            font-size: 0.9rem;
        }

        .brand-hero__shipping-link {
            display: inline-flex;
            min-height: 50px;
            flex: none;
            align-items: center;
            justify-content: center;
            border: 2px solid rgba(255, 255, 255, 0.88);
            border-radius: 9px;
            padding: 0.75rem 1.6rem;
            color: #fff;
            font-family: "Oswald", "Arial Narrow", sans-serif;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.09em;
            text-decoration: none;
            text-transform: uppercase;
            transition: background-color 180ms ease, color 180ms ease;
        }

        .brand-hero__shipping-link:hover {
            color: #c91f2c;
            background: #fff;
        }

        .brand-hero__video-label {
            color: #ef3443;
            font-family: "Oswald", "Arial Narrow", sans-serif;
            font-size: 0.72rem;
            font-weight: 900;
            letter-spacing: 0.18em;
            text-transform: uppercase;
        }

        .brand-hero__video-title {
            margin-top: 0.65rem;
            color: #fff;
            font-family: "Oswald", "Arial Narrow", sans-serif;
            font-size: clamp(2.7rem, 3.3vw, 4.4rem);
            font-weight: 700;
            line-height: 0.98;
            text-transform: uppercase;
        }

        .brand-hero__finance {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(2rem, 3.5vw, 4rem);
            color: #071d38;
            background: #f6f1e7;
        }

        .brand-hero__finance-inner {
            width: 100%;
            max-width: 390px;
        }

        .brand-hero__finance-label {
            color: #c91f2c;
            font-family: "Oswald", "Arial Narrow", sans-serif;
            font-size: 0.85rem;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
        }

        .brand-hero__finance-title {
            margin-top: 0.8rem;
            color: #071d38;
            font-family: "Oswald", "Arial Narrow", sans-serif;
            font-size: clamp(3rem, 4vw, 5rem);
            font-weight: 700;
            letter-spacing: -0.035em;
            line-height: 0.92;
            text-transform: uppercase;
        }

        .brand-hero__finance-copy {
            margin-top: 1.3rem;
            color: #64748b;
            font-size: clamp(1rem, 1.25vw, 1.2rem);
            line-height: 1.55;
        }

        .brand-hero__finance .brand-hero__button {
            margin-top: 2rem;
        }

        @media (max-width: 1200px) {
            .brand-hero__grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .brand-hero__panel {
                min-height: 480px;
            }

            .brand-hero__finance {
                grid-column: 1 / -1;
                min-height: 360px;
            }
        }

        @media (max-width: 760px) {
            .brand-hero {
                padding: 0.75rem;
            }

            .brand-hero__grid {
                grid-template-columns: 1fr;
            }

            .brand-hero__panel {
                min-height: 470px;
                border-radius: 18px;
            }

            .brand-hero__poster {
                background-position: 62% center;
            }

            .brand-hero__content {
                justify-content: flex-end;
                padding: 1.5rem;
                background: linear-gradient(180deg, rgba(7, 29, 56, 0.1), rgba(7, 29, 56, 0.95));
            }

            .brand-hero__title {
                font-size: clamp(2.3rem, 12vw, 3.4rem);
            }

            .brand-hero__description {
                margin-top: 1rem;
                font-size: 0.95rem;
                line-height: 1.5;
            }

            .brand-hero__actions,
            .brand-hero__button {
                width: 100%;
            }

            .brand-hero__video-panel {
                min-height: 340px;
            }

            .brand-hero__finance {
                grid-column: auto;
                min-height: 420px;
            }

            .brand-hero__shipping {
                align-items: stretch;
                flex-direction: column;
            }

            .brand-hero__shipping-link {
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .brand-hero__video {
                display: none;
            }

            .brand-hero__video-panel {
                background:
                    linear-gradient(180deg, rgba(7, 29, 56, 0.25), rgba(7, 29, 56, 0.92)),
                    url('{{ asset('american-loader-hero-poster.jpg') }}') center / cover;
            }
        }
    </style>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-white text-[#071d38] font-sans antialiased selection:bg-red-700 selection:text-white">

    @include('partials.header')

    <section class="brand-hero" aria-labelledby="homepage-hero-title">
        <div class="brand-hero__grid">
            <article class="brand-hero__panel brand-hero__poster">
                <div class="brand-hero__content">
                    <p class="brand-hero__eyebrow">Heavy Equipment, Delivered</p>
                    <h1 class="brand-hero__title" id="homepage-hero-title">Equipment Ready for Real Work</h1>
                    <p class="brand-hero__description">Wheel loaders, compact machines, and worksite attachments available for construction, material handling, farm, and yard operations.</p>
                    <div class="brand-hero__actions">
                        <a href="{{ route('equipment') }}#catalog" class="brand-hero__button brand-hero__button--primary">Shop Equipment</a>
                    </div>
                </div>
            </article>

            <article class="brand-hero__panel brand-hero__video-panel">
                <video class="brand-hero__video" autoplay muted loop playsinline preload="auto" poster="{{ asset('american-loader-hero-poster.jpg') }}" aria-label="Wheel loader scooping and dumping gravel">
                    <source src="{{ asset('wheel-loader-gravel.mp4') }}" type="video/mp4">
                </video>
                <div class="brand-hero__video-content">
                    <p class="brand-hero__video-label">See It in Action</p>
                    <h2 class="brand-hero__video-title">Wheel Loaders in Action</h2>
                    <a href="{{ route('equipment', ['category' => 'Wheel Loaders']) }}#catalog" class="brand-hero__button brand-hero__button--primary mt-5">Shop Wheel Loaders</a>
                </div>
            </article>

        </div>

        <div class="brand-hero__shipping">
            <div class="brand-hero__shipping-message">
                <svg class="brand-hero__shipping-icon" viewBox="0 0 48 48" fill="none" aria-hidden="true">
                    <path d="M5 11h25v22H5V11Zm25 8h7l6 7v7H30V19Z" stroke="currentColor" stroke-width="3"/>
                    <circle cx="14" cy="37" r="4" stroke="currentColor" stroke-width="3"/>
                    <circle cx="36" cy="37" r="4" stroke="currentColor" stroke-width="3"/>
                </svg>
                <div>
                    <strong>Fast Free Shipping</strong>
                    <span>Available on qualifying orders shipped from US warehouses.</span>
                </div>
            </div>
            <a href="{{ route('equipment') }}#catalog" class="brand-hero__shipping-link">Shop All</a>
        </div>
    </section>

    <section id="wheel-loader-solutions" class="border-y border-slate-200 bg-white py-8 sm:py-10 lg:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h2 class="sr-only">Wheel Loader Solutions</h2>
            <div class="grid auto-rows-fr gap-4 lg:grid-cols-3">
                <article class="group relative h-full min-h-[400px] overflow-hidden rounded-[1.35rem] bg-[#071d38] sm:min-h-[440px]">
                    <img
                        src="{{ asset('wheel-loader-solutions-red.png') }}"
                        alt="Red American Loader wheel loaders moving soil"
                        class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-[#030712]/95 via-[#071d38]/45 to-[#071d38]/10"></div>
                    <div class="absolute inset-x-0 bottom-0 p-6 sm:p-7">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-red-400">Material Handling</p>
                        <h3 class="mt-2 text-3xl font-bold uppercase leading-none text-white sm:text-4xl" style="font-family: 'Oswald', sans-serif;">Wheel Loaders</h3>
                        <p class="mt-3 max-w-md text-sm leading-6 text-slate-200">Powerful loading, carrying, and placement for yards, farms, construction sites, and aggregate work.</p>
                        <a href="{{ route('equipment', ['category' => 'Wheel Loaders']) }}#catalog" class="mt-5 inline-flex min-h-12 items-center justify-center rounded-lg bg-red-700 px-6 text-xs font-black uppercase tracking-wider text-white transition hover:bg-red-800">Shop Wheel Loaders</a>
                    </div>
                </article>

                <article class="group relative h-full min-h-[400px] overflow-hidden rounded-[1.35rem] bg-[#071d38] sm:min-h-[440px]">
                    <img
                        src="{{ asset('wheel-loader-applications.png') }}"
                        alt="Red American Loader wheel loaders working across quarry, forestry, farming, snow, and construction sites"
                        class="absolute inset-0 h-full w-full object-cover transition duration-700 group-hover:scale-105"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-[#030712]/95 via-[#071d38]/45 to-[#071d38]/10"></div>
                    <div class="absolute inset-x-0 bottom-0 p-6 sm:p-7">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-red-400">Expand Your Capability</p>
                        <h3 class="mt-2 text-3xl font-bold uppercase leading-none text-white sm:text-4xl" style="font-family: 'Oswald', sans-serif;">Worksite Attachments</h3>
                        <p class="mt-3 max-w-md text-sm leading-6 text-slate-200">Buckets, grapples, augers, breakers, and tools selected for productive equipment configurations.</p>
                        <a href="{{ route('attachments.index') }}" class="mt-5 inline-flex min-h-12 items-center justify-center rounded-lg bg-red-700 px-6 text-xs font-black uppercase tracking-wider text-white transition hover:bg-red-800">Shop Attachments</a>
                    </div>
                </article>

                <article class="flex h-full min-h-[400px] items-center overflow-hidden rounded-[1.35rem] border border-[#e8e1d5] bg-[#f6f1e7] p-7 sm:min-h-[440px] sm:p-8">
                    <div class="max-w-md">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-red-700">Buy Now, Pay Over Time</p>
                        <h3 class="mt-3 text-4xl font-bold uppercase leading-[0.92] text-[#071d38] sm:text-5xl" style="font-family: 'Oswald', sans-serif;">Financing Available</h3>
                        <p class="mt-5 text-base leading-7 text-slate-600">Ask our team about equipment purchasing options and find a solution that fits your operation.</p>
                        <a href="{{ route('contact') }}" class="mt-6 inline-flex min-h-12 items-center justify-center rounded-lg bg-red-700 px-6 text-xs font-black uppercase tracking-wider text-white transition hover:bg-red-800">See Options</a>
                    </div>
                </article>
            </div>
        </div>
    </section>


    <section id="jobsite-applications" class="overflow-hidden border-b border-gray-200 bg-slate-50 py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 grid gap-5 lg:grid-cols-[1.05fr_0.95fr] lg:items-end">
                <div>
                    <span class="mb-3 flex items-center gap-3 text-xs font-black uppercase tracking-[0.24em] text-red-700">
                        <span class="h-0.5 w-9 bg-red-700"></span> Jobsite Applications
                    </span>
                    <h2 style="font-family: 'Archivo Black', sans-serif;" class="max-w-3xl text-3xl font-black uppercase leading-[1.02] tracking-tight text-[#071d38] md:text-4xl">
                        One compact loader.<br><span class="text-red-700">Built for every workday.</span>
                    </h2>
                </div>
                <p class="max-w-xl text-base leading-7 text-slate-600 lg:justify-self-end">
                    From construction and farming to material yards and landscape work, configure a capable machine around the jobs your crew handles every day.
                </p>
            </div>

            <div class="grid overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white shadow-[0_24px_70px_rgba(7,29,56,0.12)] lg:grid-cols-[0.9fr_1.1fr]">
                <article class="relative min-h-[430px] overflow-hidden lg:min-h-full">
                    <img src="{{ asset('jobsite-applications-loader.png') }}" alt="Red American Loader wheel loader dumping soil at a landscaping jobsite" class="absolute inset-0 h-full w-full object-cover object-center">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#030712]/95 via-[#071d38]/30 to-transparent"></div>
                    <div class="absolute inset-x-0 bottom-0 p-7 sm:p-8">
                        <p class="text-xs font-black uppercase tracking-[0.24em] text-red-400">Ready where work happens</p>
                        <h3 class="mt-3 max-w-md text-3xl font-black uppercase leading-none text-white md:text-4xl" style="font-family: 'Archivo Black', sans-serif;">Compact footprint. Serious capability.</h3>
                        <p class="mt-4 max-w-md text-sm leading-6 text-slate-200">Practical lift power, fast attachment changes, and maneuverability for demanding spaces.</p>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('equipment') }}#catalog" class="inline-flex min-h-12 items-center justify-center rounded-lg bg-red-700 px-6 text-xs font-black uppercase tracking-[0.16em] text-white transition hover:bg-red-800">Browse Equipment</a>
                            <a href="{{ route('topics.show', 'buy-guides') }}" class="inline-flex min-h-12 items-center justify-center rounded-lg border border-white/50 bg-white/10 px-6 text-xs font-black uppercase tracking-[0.16em] text-white backdrop-blur-sm transition hover:bg-white hover:text-[#071d38]">Buyer Guide</a>
                        </div>
                    </div>
                </article>

                <div class="grid gap-px bg-slate-200 sm:grid-cols-2">
                    <article class="group bg-white p-6 transition hover:bg-slate-50 sm:p-7">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-700 transition group-hover:bg-red-700 group-hover:text-white">
                                <i data-lucide="hard-hat" class="h-5 w-5"></i>
                            </div>
                            <span class="text-xs font-black tracking-[0.18em] text-slate-300">01</span>
                        </div>
                        <h3 class="mt-7 text-lg font-black uppercase tracking-tight text-[#071d38]">Construction sites</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Move aggregate, backfill trenches, clear debris, stage pallets, and support crews in confined work zones.</p>
                        <div class="mt-6 h-0.5 w-10 bg-red-700 transition-all group-hover:w-20"></div>
                    </article>

                    <article class="group bg-white p-6 transition hover:bg-slate-50 sm:p-7">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-700 transition group-hover:bg-red-700 group-hover:text-white">
                                <i data-lucide="tractor" class="h-5 w-5"></i>
                            </div>
                            <span class="text-xs font-black tracking-[0.18em] text-slate-300">02</span>
                        </div>
                        <h3 class="mt-7 text-lg font-black uppercase tracking-tight text-[#071d38]">Farms and land work</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Handle feed, soil, mulch, gravel, fencing supplies, logs, and everyday property maintenance.</p>
                        <div class="mt-6 h-0.5 w-10 bg-red-700 transition-all group-hover:w-20"></div>
                    </article>

                    <article class="group bg-white p-6 transition hover:bg-slate-50 sm:p-7">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-700 transition group-hover:bg-red-700 group-hover:text-white">
                                <i data-lucide="warehouse" class="h-5 w-5"></i>
                            </div>
                            <span class="text-xs font-black tracking-[0.18em] text-slate-300">03</span>
                        </div>
                        <h3 class="mt-7 text-lg font-black uppercase tracking-tight text-[#071d38]">Yards and warehouses</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Support loading docks, outdoor storage, equipment staging, and efficient pallet movement.</p>
                        <div class="mt-6 h-0.5 w-10 bg-red-700 transition-all group-hover:w-20"></div>
                    </article>

                    <article class="group bg-white p-6 transition hover:bg-slate-50 sm:p-7">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-700 transition group-hover:bg-red-700 group-hover:text-white">
                                <i data-lucide="trees" class="h-5 w-5"></i>
                            </div>
                            <span class="text-xs font-black tracking-[0.18em] text-slate-300">04</span>
                        </div>
                        <h3 class="mt-7 text-lg font-black uppercase tracking-tight text-[#071d38]">Landscaping crews</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Load mulch, carry stone, remove brush, prep surfaces, and switch attachments quickly.</p>
                        <div class="mt-6 h-0.5 w-10 bg-red-700 transition-all group-hover:w-20"></div>
                    </article>
                </div>
            </div>
        </div>
    </section>


    <section id="loader-buying-support" class="py-12 lg:py-16 bg-[#071d38] border-b border-white/10 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid gap-12 lg:grid-cols-12 lg:items-center">
                <div class="lg:col-span-6">
                    <span class="text-red-500 font-black text-xs uppercase tracking-widest mb-3 block">// BUY WITH CLARITY</span>
                    <h2 style="font-family: 'Archivo Black', sans-serif;" class="text-3xl md:text-4xl font-black uppercase tracking-tight leading-tight">
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
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-500 text-sm font-black text-white">01</span>
                                <div>
                                    <h3 class="text-lg font-black uppercase tracking-tight">Match the work</h3>
                                    <p class="mt-2 text-sm leading-6 text-slate-400">Start with the materials you move, travel distance, lift height, bucket size, ground conditions, and how often you need attachments.</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6">
                            <div class="flex gap-4">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-500 text-sm font-black text-white">02</span>
                                <div>
                                    <h3 class="text-lg font-black uppercase tracking-tight">Compare real specs</h3>
                                    <p class="mt-2 text-sm leading-6 text-slate-400">Review engine type, rated load, dump height, gradeability, hydraulic performance, operating weight, dimensions, and attachment compatibility.</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6">
                            <div class="flex gap-4">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-500 text-sm font-black text-white">03</span>
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



    <section class="py-12 lg:py-16 bg-slate-50 border-t border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-skoopYellow font-black text-xs uppercase tracking-widest mb-2 block">// EXPLORE OUR FLEET</span>
                <h2 style="font-family: 'Archivo Black', sans-serif;" class="text-3xl md:text-4xl uppercase tracking-tight">Featured Wheel Loader Models</h2>
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
                        <h3 class="text-lg font-black uppercase tracking-tight text-[#071d38] mb-3">New TYPHON Telescopic Wheel Loader</h3>
                        <p class="text-sm text-gray-600 mb-6">Kubota D1105 engine, 25 hp, 1 ton load capacity, built for tight site loading and reliable material handling.</p>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-[#071d38] text-lg font-black">Quote on request</span>
                            <a href="{{ route('product.show', 'new-typhon-telescopic-wheel-loader-with-kubota-d1105-engine-25-hp-1-ton-load-usa') }}" class="inline-flex items-center justify-center bg-skoopYellow hover:bg-red-800 text-white text-sm font-black uppercase tracking-[0.18em] px-4 py-3 rounded-2xl transition">View</a>
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
                        <h3 class="text-lg font-black uppercase tracking-tight text-[#071d38] mb-3">TYPHON Thunder VI 23hp</h3>
                        <p class="text-sm text-gray-600 mb-6">EPA B&S engine wheel loader engineered for agile site work, fast loading, and reliable performance.</p>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-[#071d38] text-lg font-black">Quote on request</span>
                            <a href="{{ route('product.show', 'typhon-thunder-vi-23hp-epa-b-s-engine-wheel-loader-usa') }}" class="inline-flex items-center justify-center bg-skoopYellow hover:bg-red-800 text-white text-sm font-black uppercase tracking-[0.18em] px-4 py-3 rounded-2xl transition">View</a>
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
                        <h3 class="text-lg font-black uppercase tracking-tight text-[#071d38] mb-3">TYPHON TERROR 4WD Backhoe Loader</h3>
                        <p class="text-sm text-gray-600 mb-6">Heavy-duty 4WD backhoe loader for tough digging, loading, and yard-moving jobs.</p>
                        <div class="flex items-center justify-between gap-4">
                            <span class="text-[#071d38] text-lg font-black">Quote on request</span>
                            <a href="{{ route('product.show', 'brand-new-typhon-terror-4wd-backhoe-loader-usa') }}" class="inline-flex items-center justify-center bg-skoopYellow hover:bg-red-800 text-white text-sm font-black uppercase tracking-[0.18em] px-4 py-3 rounded-2xl transition">View</a>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </section>



    <section id="attachments" class="py-10 lg:py-14 border-t border-b border-white/10 text-white">
        <div class="skp-attachments-heading grid gap-5 px-4 sm:px-6 lg:grid-cols-[1fr_0.9fr] lg:items-end lg:px-8">
            <div>
                <span class="skp-attachments-kicker text-red-500 font-black text-xs uppercase tracking-[0.25em] mb-4">Equipment Ecosystem</span>
                <h2 style="font-family: 'Montserrat', sans-serif;" class="max-w-3xl text-3xl md:text-4xl font-black tracking-[-0.05em] text-white leading-[0.95]">
                    One machine.<br><span class="text-red-500">More ways to work.</span>
                </h2>
            </div>
            <div class="lg:pb-1">
                <p class="max-w-xl text-sm leading-6 text-slate-300">Build the right setup for every job. Explore purpose-built tools for clearing, grading, digging, sweeping, and material handling.</p>
                <a href="{{ route('attachments.index') }}" class="mt-3 inline-flex items-center gap-2 text-xs font-black uppercase tracking-[0.18em] text-white transition hover:text-red-400">
                    Browse all attachments <i data-lucide="arrow-up-right" class="h-4 w-4"></i>
                </a>
            </div>
        </div>

        <div class="skp-showcase-container px-4 sm:px-6 lg:px-8">

            <div class="skp-feature-card active-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8017" data-title="Ditching Machine" data-img="https://minexcavators.com/wp-content/uploads/2026/05/430332ee-3571-46c6-99b1-89a47c2629e9.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/430332ee-3571-46c6-99b1-89a47c2629e9.png" alt="TYPHON compact loader ditching machine attachment" class="w-full h-full object-cover transition duration-500" loading="lazy" decoding="async">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-01</span>
                        <h3 class="font-black uppercase tracking-tight text-[#071d38] text-3xl">Ditching Machine</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8017</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-red-500/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>


            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8012" data-title="Enclosed Sweeper" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_37_17-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_37_17-PM.png" alt="TYPHON compact loader enclosed sweeper attachment" class="w-full h-full object-cover transition duration-500" loading="lazy" decoding="async">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-02</span>
                        <h3 class="font-black uppercase tracking-tight text-[#071d38] text-3xl">Enclosed Sweeper</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8012</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-red-500/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8006" data-title="4-in-1 Bucket" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_44_57-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_44_57-PM.png" alt="TYPHON compact loader 4-in-1 bucket attachment" class="w-full h-full object-cover transition duration-500" loading="lazy" decoding="async">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-03</span>
                        <h3 class="font-black uppercase tracking-tight text-[#071d38] text-3xl">4-in-1 Bucket</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8006</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-red-500/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8005" data-title="Hydraulic Fork" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_50_17-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_50_17-PM.png" alt="TYPHON compact loader hydraulic fork attachment" class="w-full h-full object-cover transition duration-500" loading="lazy" decoding="async">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-04</span>
                        <h3 class="font-black uppercase tracking-tight text-[#071d38] text-3xl">Hydraulic Fork</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8005</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-red-500/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8008" data-title="Grass Grapple" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_55_29-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_55_29-PM.png" alt="TYPHON compact loader grass grapple attachment" class="w-full h-full object-cover transition duration-500" loading="lazy" decoding="async">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-05</span>
                        <h3 class="font-black uppercase tracking-tight text-[#071d38] text-3xl">Grass Grapple</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8008</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-red-500/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8009" data-title="Drilling Rig" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_58_15-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-02_58_15-PM.png" alt="TYPHON compact loader drilling rig attachment" class="w-full h-full object-cover transition duration-500" loading="lazy" decoding="async">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-06</span>
                        <h3 class="font-black uppercase tracking-tight text-[#071d38] text-3xl">Drilling Rig</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8009</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-red-500/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8007" data-title="Log Grapple" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_00_54-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_00_54-PM.png" alt="TYPHON compact loader log grapple attachment" class="w-full h-full object-cover transition duration-500" loading="lazy" decoding="async">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-07</span>
                        <h3 class="font-black uppercase tracking-tight text-[#071d38] text-3xl">Log Grapple</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8007</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-red-500/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8023" data-title="Lawn Mower" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_03_17-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_03_17-PM.png" alt="TYPHON compact loader lawn mower attachment" class="w-full h-full object-cover transition duration-500" loading="lazy" decoding="async">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-08</span>
                        <h3 class="font-black uppercase tracking-tight text-[#071d38] text-3xl">Lawn Mower</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8023</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-red-500/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8026" data-title="Reclamation Tool" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_05_08-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_05_08-PM.png" alt="TYPHON compact loader land reclamation attachment" class="w-full h-full object-cover transition duration-500" loading="lazy" decoding="async">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-09</span>
                        <h3 class="font-black uppercase tracking-tight text-[#071d38] text-3xl">Reclamation Tool</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8026</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-red-500/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

            <div class="skp-feature-card bg-gradient-to-br from-white to-white border border-gray-200 rounded-3xl overflow-hidden shadow-2xl shadow-gray-200 flex flex-col h-full cursor-pointer" data-sku="TYPH-8013" data-title="Hydraulic Breaker" data-img="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_12_47-PM.png">
                <div class="w-full flex-1 bg-white/40 flex items-center justify-center border-b border-gray-200 border-l-8 border-skoopYellow relative">
                    <img src="https://minexcavators.com/wp-content/uploads/2026/05/ChatGPT-Image-May-29-2026-03_12_47-PM.png" alt="TYPHON compact loader hydraulic breaker attachment" class="w-full h-full object-cover transition duration-500" loading="lazy" decoding="async">
                </div>
                <div class="p-8 bg-white/90 backdrop-blur-md flex justify-between items-center">
                    <div>
                        <span class="block text-xs font-black text-skoopYellow tracking-widest uppercase mb-1">// SYSTEM BLUEPRINT MODULE: SEC-10</span>
                        <h3 class="font-black uppercase tracking-tight text-[#071d38] text-3xl">Hydraulic Breaker</h3>
                    </div>
                    <div class="text-right flex flex-col items-end gap-2">
                        <span class="text-xs font-bold text-gray-500 tracking-widest">REGISTRY // TYPH-8013</span>
                        <span class="bg-skoopYellow text-white font-black text-xs px-5 py-2.5 rounded-md tracking-widest uppercase flex items-center gap-2 border border-red-500/20">Analyze Hardware <i data-lucide="scan-eye" class="w-4 h-4"></i></span>
                    </div>
                </div>
            </div>

        </div>

        <div class="skp-attachment-controls mt-5 flex items-center justify-center gap-4">
            <button id="attachment-prev" type="button" aria-label="Previous attachment"><i data-lucide="arrow-left" class="h-5 w-5"></i></button>
            <div class="flex justify-center gap-2" id="rotation-dots"></div>
            <button id="attachment-next" type="button" aria-label="Next attachment"><i data-lucide="arrow-right" class="h-5 w-5"></i></button>
        </div>
    </section>

     <section id="why-choose" class="border-b border-gray-200 bg-white py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid overflow-hidden rounded-[1.5rem] border border-slate-200 bg-slate-100 gap-px shadow-[0_22px_65px_rgba(7,29,56,0.09)] lg:grid-cols-[0.85fr_1.15fr]">
                <div class="flex flex-col justify-center bg-[#f7f9fc] p-7 sm:p-9 lg:p-10">
                    <span class="flex items-center gap-3 text-xs font-black uppercase tracking-[0.24em] text-red-700"><span class="h-0.5 w-9 bg-red-700"></span> Equipment Features</span>
                    <h2 style="font-family: 'Archivo Black', sans-serif;" class="mt-5 text-3xl font-black uppercase leading-[1.02] tracking-tight text-[#071d38] md:text-4xl">
                        Compact by design.<br><span class="text-red-700">Capable by nature.</span>
                    </h2>
                    <p class="mt-5 max-w-lg text-base leading-7 text-slate-600">The TYPHON SKOOP combines a compact chassis with rugged lift capacity, quick attachment changes, and dependable diesel power for demanding work in tight spaces.</p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('equipment') }}#catalog" class="inline-flex min-h-12 items-center justify-center rounded-lg bg-[#071d38] px-6 text-xs font-black uppercase tracking-[0.16em] text-white transition hover:bg-[#0b2d55]">Explore Equipment</a>
                        <a href="{{ route('contact') }}" class="inline-flex min-h-12 items-center justify-center rounded-lg border border-slate-300 bg-white px-6 text-xs font-black uppercase tracking-[0.16em] text-[#071d38] transition hover:border-red-700 hover:text-red-700">Ask a Specialist</a>
                    </div>
                </div>

                <div class="grid gap-px bg-slate-200 sm:grid-cols-2">
                    <article class="group bg-white p-6 transition hover:bg-slate-50 sm:p-7">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-700"><i data-lucide="gauge" class="h-5 w-5"></i></div>
                            <span class="text-xs font-black tracking-[0.18em] text-slate-300">01</span>
                        </div>
                        <h3 class="mt-6 text-sm font-black uppercase tracking-[0.14em] text-[#071d38]">Dependable performance</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Kubota D1105 water-cooled diesel output supports steady torque, long runtime, and consistent jobsite operation.</p>
                        <div class="mt-5 h-0.5 w-10 bg-red-700 transition-all group-hover:w-20"></div>
                    </article>

                    <article class="group bg-white p-6 transition hover:bg-slate-50 sm:p-7">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-700"><i data-lucide="weight" class="h-5 w-5"></i></div>
                            <span class="text-xs font-black tracking-[0.18em] text-slate-300">02</span>
                        </div>
                        <h3 class="mt-6 text-sm font-black uppercase tracking-[0.14em] text-[#071d38]">1,760 lb load capacity</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Strong hydraulic lift performance supports practical material handling, transport, and loading tasks.</p>
                        <div class="mt-5 h-0.5 w-10 bg-red-700 transition-all group-hover:w-20"></div>
                    </article>

                    <article class="group bg-white p-6 transition hover:bg-slate-50 sm:p-7">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-700"><i data-lucide="blocks" class="h-5 w-5"></i></div>
                            <span class="text-xs font-black tracking-[0.18em] text-slate-300">03</span>
                        </div>
                        <h3 class="mt-6 text-sm font-black uppercase tracking-[0.14em] text-[#071d38]">Attachment versatility</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Fast attachment swaps move the SKOOP from bucket to grapple, fork, breaker, and more.</p>
                        <div class="mt-5 h-0.5 w-10 bg-red-700 transition-all group-hover:w-20"></div>
                    </article>

                    <article class="group bg-white p-6 transition hover:bg-slate-50 sm:p-7">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-700"><i data-lucide="arrow-up-to-line" class="h-5 w-5"></i></div>
                            <span class="text-xs font-black tracking-[0.18em] text-slate-300">04</span>
                        </div>
                        <h3 class="mt-6 text-sm font-black uppercase tracking-[0.14em] text-[#071d38]">2,825 mm lift reach</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Useful dump height and compact reach make loading trucks, bins, and stacked material easier.</p>
                        <div class="mt-5 h-0.5 w-10 bg-red-700 transition-all group-hover:w-20"></div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section id="specs" class="border-y border-white/10 bg-[#071d38] py-12 text-white lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 grid gap-5 lg:grid-cols-[1fr_0.8fr] lg:items-end">
                <div>
                    <span class="flex items-center gap-3 text-xs font-black uppercase tracking-[0.24em] text-red-400"><span class="h-0.5 w-9 bg-red-500"></span> Performance at a glance</span>
                    <h2 style="font-family: 'Archivo Black', sans-serif;" class="mt-4 text-3xl font-black uppercase leading-none tracking-tight md:text-4xl">The power inside</h2>
                </div>
                <p class="max-w-xl text-sm leading-6 text-slate-300 lg:justify-self-end">Core specifications selected to deliver confident lifting, dependable power, and stable operation across demanding jobsites.</p>
            </div>
            <div class="grid overflow-hidden rounded-[1.4rem] border border-white/10 bg-white/10 gap-px sm:grid-cols-2 lg:grid-cols-4">
                <article class="group bg-[#0a223d] p-6 transition hover:bg-[#102d4c]">
                    <div class="flex items-start justify-between gap-4"><i data-lucide="arrow-up-to-line" class="h-7 w-7 text-red-400"></i><strong class="text-2xl font-black text-white">2,825<span class="ml-1 text-xs text-slate-400">mm</span></strong></div>
                    <h3 class="mt-7 text-sm font-black uppercase tracking-[0.12em] text-white">Telescopic lift power</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-400">Maximum dump height for clearing high truck beds and material bins.</p>
                </article>
                <article class="group bg-[#0a223d] p-6 transition hover:bg-[#102d4c]">
                    <div class="flex items-start justify-between gap-4"><i data-lucide="zap" class="h-7 w-7 text-red-400"></i><strong class="text-2xl font-black text-white">D1105</strong></div>
                    <h3 class="mt-7 text-sm font-black uppercase tracking-[0.12em] text-white">Kubota diesel power</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-400">Water-cooled industrial engine designed for dependable daily operation.</p>
                </article>
                <article class="group bg-[#0a223d] p-6 transition hover:bg-[#102d4c]">
                    <div class="flex items-start justify-between gap-4"><i data-lucide="weight" class="h-7 w-7 text-red-400"></i><strong class="text-2xl font-black text-white">4,600<span class="ml-1 text-xs text-slate-400">lbs</span></strong></div>
                    <h3 class="mt-7 text-sm font-black uppercase tracking-[0.12em] text-white">Heavy-duty stability</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-400">Balanced machine weight supports planted, controlled material handling.</p>
                </article>
                <article class="group bg-[#0a223d] p-6 transition hover:bg-[#102d4c]">
                    <div class="flex items-start justify-between gap-4"><i data-lucide="mountain-snow" class="h-7 w-7 text-red-400"></i><strong class="text-2xl font-black text-white">30<span class="ml-1 text-xs text-slate-400">%</span></strong></div>
                    <h3 class="mt-7 text-sm font-black uppercase tracking-[0.12em] text-white">Maximum gradeability</h3>
                    <p class="mt-3 text-sm leading-6 text-slate-400">Capability for loose, uneven, and sloped jobsite terrain.</p>
                </article>
            </div>
        </div>
    </section>

    <section id="kubota-reliability" class="border-b border-gray-200 bg-slate-50 py-12 lg:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white shadow-[0_22px_65px_rgba(7,29,56,0.1)] lg:grid-cols-[0.88fr_1.12fr]">
                <div class="relative flex flex-col justify-between overflow-hidden bg-[#071d38] p-7 text-white sm:p-9 lg:p-10">
                    <div class="pointer-events-none absolute -right-20 -top-20 h-64 w-64 rounded-full bg-red-600/15 blur-3xl"></div>
                    <div class="relative">
                        <span class="flex items-center gap-3 text-xs font-black uppercase tracking-[0.22em] text-red-400"><span class="h-0.5 w-8 bg-red-500"></span> Kubota D1105 reliability core</span>
                        <h2 style="font-family: 'Archivo Black', sans-serif;" class="mt-5 text-3xl font-black uppercase leading-[1.03] tracking-tight md:text-4xl">
                            Diesel confidence<br><span class="text-red-400">for every shift.</span>
                        </h2>
                        <p class="mt-5 max-w-lg text-base leading-7 text-slate-300">
                            Steady torque, predictable water cooling, and practical service access make the D1105 a dependable platform for repeated loader work.
                        </p>
                    </div>
                    <div class="relative mt-8 border-l-2 border-red-500 bg-white/[0.06] p-5">
                        <div class="flex items-start gap-3">
                            <i data-lucide="message-square-text" class="h-5 w-5 flex-none text-red-400"></i>
                            <p class="text-sm font-semibold leading-6 text-slate-300">Supported by familiar Kubota service routines and broad parts availability.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-px bg-slate-200 sm:grid-cols-2">
                    <article class="group bg-white p-6 transition hover:bg-slate-50 sm:p-7">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-700"><i data-lucide="fuel" class="h-5 w-5"></i></div>
                        <h3 class="mt-6 text-sm font-black uppercase tracking-[0.12em] text-[#071d38]">Fuel efficiency</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">A compact three-cylinder layout helps crews control operating costs through long workdays.</p>
                    </article>
                    <article class="group bg-white p-6 transition hover:bg-slate-50 sm:p-7">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-700"><i data-lucide="shield-check" class="h-5 w-5"></i></div>
                        <h3 class="mt-6 text-sm font-black uppercase tracking-[0.12em] text-[#071d38]">Industrial durability</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Steady low-speed torque supports repeated loading, lifting, travel, and attachment cycles.</p>
                    </article>
                    <article class="group bg-white p-6 transition hover:bg-slate-50 sm:p-7">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-700"><i data-lucide="wrench" class="h-5 w-5"></i></div>
                        <h3 class="mt-6 text-sm font-black uppercase tracking-[0.12em] text-[#071d38]">Straightforward service</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Practical access simplifies routine checks, fluid service, and common parts replacement.</p>
                    </article>
                    <article class="group bg-white p-6 transition hover:bg-slate-50 sm:p-7">
                        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-50 text-red-700"><i data-lucide="droplets" class="h-5 w-5"></i></div>
                        <h3 class="mt-6 text-sm font-black uppercase tracking-[0.12em] text-[#071d38]">Water-cooled consistency</h3>
                        <p class="mt-3 text-sm leading-6 text-slate-600">Stable operating temperatures support consistent delivery during stop-and-go material work.</p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section id="field-loader-showcase" class="relative overflow-hidden border-b border-white/10 bg-[#061a31] py-12 text-white lg:py-16">
        <div class="pointer-events-none absolute -left-32 top-1/3 h-80 w-80 rounded-full bg-red-700/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-32 bottom-0 h-96 w-96 rounded-full bg-blue-500/10 blur-3xl"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative grid overflow-hidden rounded-[1.6rem] border border-white/10 bg-[#0a223d] shadow-[0_30px_80px_rgba(0,0,0,0.35)] lg:grid-cols-[1.03fr_0.97fr]">
                <figure class="relative min-h-[440px] overflow-hidden lg:min-h-[560px]">
                    <img src="{{ asset('wheel-loader-field-showcase.jpg') }}" alt="Heavy wheel loader with large bucket working on sandy jobsite" class="absolute inset-0 h-full w-full object-cover object-center" width="1080" height="1208" loading="lazy" decoding="async">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#020a14]/85 via-transparent to-transparent"></div>
                    <figcaption class="absolute inset-x-0 bottom-0 flex items-end justify-between gap-5 p-6 sm:p-8">
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.24em] text-red-400">American Loader capability</p>
                            <p class="mt-2 max-w-sm text-xl font-black uppercase leading-tight text-white">Made to keep material moving</p>
                        </div>
                        <div class="hidden rounded-xl border border-white/20 bg-[#071d38]/90 px-5 py-4 text-right backdrop-blur-sm sm:block">
                            <strong class="block text-2xl font-black text-white">4</strong>
                            <span class="text-[0.62rem] font-black uppercase tracking-[0.2em] text-slate-300">Core advantages</span>
                        </div>
                    </figcaption>
                </figure>

                <div class="relative flex flex-col justify-center p-7 sm:p-9 lg:p-10">
                    <span class="flex items-center gap-3 text-xs font-black uppercase tracking-[0.24em] text-red-400">
                        <span class="h-0.5 w-9 bg-red-500"></span> Heavy Material Handling
                    </span>
                    <h2 style="font-family: 'Archivo Black', sans-serif;" class="mt-4 text-3xl font-black uppercase leading-[1.02] tracking-tight md:text-4xl">
                        Power through<br><span class="text-red-400">every load cycle.</span>
                    </h2>
                    <p class="mt-5 max-w-xl text-base leading-7 text-slate-300">
                        Confident bucket work starts with the right balance of traction, lift geometry, responsive hydraulics, and machine stability.
                    </p>

                    <div class="mt-7 divide-y divide-white/10 border-y border-white/10">
                        <article class="group grid grid-cols-[auto_1fr] gap-4 py-4">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-500 text-xs font-black text-white">01</span>
                            <div>
                                <h3 class="text-sm font-black uppercase tracking-[0.14em] text-white">High-volume loading</h3>
                                <p class="mt-1.5 text-sm leading-6 text-slate-400">Efficient dig, carry, and dump cycles for sand, gravel, soil, aggregate, and debris.</p>
                            </div>
                        </article>
                        <article class="group grid grid-cols-[auto_1fr] gap-4 py-4">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-500 text-xs font-black text-white">02</span>
                            <div>
                                <h3 class="text-sm font-black uppercase tracking-[0.14em] text-white">Stable jobsite control</h3>
                                <p class="mt-1.5 text-sm leading-6 text-slate-400">A wide stance and strong loader geometry support control across loose and uneven surfaces.</p>
                            </div>
                        </article>
                        <article class="group grid grid-cols-[auto_1fr] gap-4 py-4">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-500 text-xs font-black text-white">03</span>
                            <div>
                                <h3 class="text-sm font-black uppercase tracking-[0.14em] text-white">Responsive hydraulics</h3>
                                <p class="mt-1.5 text-sm leading-6 text-slate-400">Predictable lift and bucket response help operators work smoothly through repetitive cycles.</p>
                            </div>
                        </article>
                    </div>

                    <div class="mt-7 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('equipment', ['category' => 'Wheel Loaders']) }}#catalog" class="inline-flex min-h-12 items-center justify-center rounded-lg bg-red-600 px-6 text-xs font-black uppercase tracking-[0.16em] text-white transition hover:bg-red-700">
                            Explore Wheel Loaders
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex min-h-12 items-center justify-center rounded-lg border border-white/25 px-6 text-xs font-black uppercase tracking-[0.16em] text-white transition hover:border-white hover:bg-white hover:text-[#071d38]">
                            Talk to Our Team
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="videos" class="py-12 lg:py-16 bg-white border-t border-b border-gray-100">
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

    <section id="mo-mosaic-stories" class="border-y border-gray-200 bg-slate-50 py-12 lg:py-16" aria-labelledby="mo-delivery-title" itemscope itemtype="https://schema.org/ItemList">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8 grid gap-6 lg:grid-cols-[1fr_0.85fr] lg:items-end">
                <div>
                    <span class="flex items-center gap-3 text-xs font-black uppercase tracking-[0.24em] text-red-700"><span class="h-0.5 w-9 bg-red-700"></span> Customer handovers</span>
                    <h2 id="mo-delivery-title" itemprop="name" style="font-family: 'Archivo Black', sans-serif;" class="mt-4 text-3xl uppercase leading-none tracking-tight text-[#071d38] md:text-4xl">Delivered to the jobsite.<br><span class="text-red-700">Ready for the first shift.</span></h2>
                </div>
                <div class="grid grid-cols-[auto_1fr] overflow-hidden rounded-xl border border-slate-200 bg-white lg:justify-self-end">
                    <div class="flex min-w-24 items-center justify-center bg-[#071d38] px-5 py-4 text-center">
                        <strong class="text-3xl font-black text-white">8</strong>
                    </div>
                    <p itemprop="description" class="max-w-sm px-5 py-4 text-sm leading-6 text-slate-600">Real delivery moments with operators, crews, and equipment prepared for work.</p>
                </div>
            </div>

            <div class="delivery-slider" role="list" aria-label="Verified customer handovers">
                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="1">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="{{ asset('customer-handover-apex.webp') }}" alt="Skid steer delivery for Apex Excavation Group" class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-red-500 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-red-700">Skidsteers</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-[#071d38]">Apex Excavation Group</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">We were losing time on deep trenching. First look at the steel frame and the hydraulic lines, I knew this beast would handle the site.</p>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="2">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="{{ asset('customer-handover-civil.webp') }}" alt="Skid steer loader delivery for Civil Pro Builders" class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-red-500 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-red-700">Skid Steer</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-[#071d38]">Civil Pro Builders</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">It just felt rugged. As soon as I stepped into the cage, the visibility and solid frame reassured the crew.</p>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="3">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="{{ asset('customer-handover-logistics.jpeg') }}" alt="Warehouse forklift delivery for Regional Logistics" class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-red-500 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-red-700">Warehouse Forklift</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-[#071d38]">Regional Logistics</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Silent mast operation was the first thing we tested. Huge relief for the narrow aisles in our facility.</p>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="4">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="{{ asset('customer-handover-steelcore.webp') }}" alt="Typhon Series Loader delivery for Steelcore Mining Ops" class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-red-500 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-red-700">Typhon Series Loader</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-[#071d38]">Steelcore Mining Ops</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">You don't realize how big the bucket is until you're standing next to the tires. This will cut our material loading times in half.</p>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="5">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="{{ asset('customer-handover-valley.webp') }}" alt="Agri Utility Series delivery for Valley Cultivators" class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-red-500 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-red-700">Agri/Utility Series</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-[#071d38]">Valley Cultivators</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">We needed torque without the massive footprint. The build quality on this unit is immaculate.</p>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="6">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="{{ asset('customer-handover-urban.webp') }}" alt="Skidsteers delivery for Urban Development" class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-red-500 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-red-700">Skidsteers</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-[#071d38]">Urban Development</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">Perfect for city infrastructure. Narrow enough for alleys, but zero compromise on the lifting power.</p>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="7">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="{{ asset('customer-handover-forklift.webp') }}" alt="Electric forklift handover to a customer" class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-red-500 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-red-700">Electric Forklift</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-[#071d38]">Warehouse Operations</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">The controls felt familiar immediately, and the compact chassis is ready for daily material handling work.</p>
                    </div>
                </article>

                <article class="group overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl" role="listitem" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                    <meta itemprop="position" content="8">
                    <div class="aspect-[3/4] overflow-hidden bg-slate-900">
                        <img src="{{ asset('customer-handover-fleet.webp') }}" alt="Electric forklift fleet prepared for customer delivery" class="h-full w-full object-cover opacity-95 transition duration-700 group-hover:scale-105 group-hover:opacity-80" width="700" height="933" loading="lazy" decoding="async">
                    </div>
                    <div class="border-t-4 border-red-500 p-5">
                        <span itemprop="name" class="text-[11px] font-black uppercase tracking-[0.22em] text-red-700">Forklift Fleet</span>
                        <h3 class="mt-2 text-lg font-black tracking-tight text-[#071d38]">Distribution Center</h3>
                        <p class="mt-3 text-sm leading-6 text-gray-600">A full fleet prepared together gives the team consistent controls, capacity, and service planning from the first shift.</p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <section id="feedback" class="py-12 lg:py-16 bg-white border-t border-b border-gray-100">
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
                                <div class="text-red-500 font-black">★★★★★</div>
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
                                <div class="text-red-500 font-black">★★★★★</div>
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
                                <div class="text-red-500 font-black">★★★★★</div>
                            </div>
                        </div>
                    </div>
                </blockquote>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <div id="skp-modal" class="skp-modal-overlay">
        <div class="bg-[#071d38] border-2 border-red-500 rounded-2xl w-[90%] max-w-[750px] shadow-2xl overflow-hidden relative transform translate-y-8 scale-95 transition-all duration-300" id="skp-modal-content">
            <span class="absolute top-3 right-6 text-white text-4xl font-black cursor-pointer hover:text-red-500 transition z-10" id="skp-close-btn">&times;</span>
            <div class="bg-slate-900 p-6 flex items-center justify-center border-b border-white/10 h-[420px]">
                <img id="skp-modal-img" src="" alt="Blueprint Technical High Res View" class="w-full h-full object-contain">
            </div>
            <div class="p-6 text-center bg-[#071d38]">
                <span id="skp-modal-sku" class="block text-sm font-black text-red-500 tracking-widest uppercase mb-1"></span>
                <h3 id="skp-modal-title" class="text-2xl font-black uppercase text-white tracking-tight"></h3>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();

            const cards = document.querySelectorAll('.skp-feature-card');
            const dotsContainer = document.getElementById('rotation-dots');
            const previousButton = document.getElementById('attachment-prev');
            const nextButton = document.getElementById('attachment-next');
            let currentIndex = 0;
            let rotationTimer;

            // Generate Nav dots precisely for all 10 hardware nodes
            cards.forEach((_, index) => {
                const dot = document.createElement('button');
                dot.className = `w-3 h-3 rounded-full transition-all duration-300 ${index === 0 ? 'bg-red-500 w-8' : 'bg-slate-600'}`;
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
                dots[currentIndex].classList.remove('bg-red-500', 'w-8');
                dots[currentIndex].classList.add('bg-slate-600');

                currentIndex = index;

                cards[currentIndex].classList.add('active-card');
                dots[currentIndex].classList.remove('bg-slate-600');
                dots[currentIndex].classList.add('bg-red-500', 'w-8');
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

            previousButton?.addEventListener('click', () => {
                goToSlide((currentIndex - 1 + cards.length) % cards.length);
                resetTimer();
            });

            nextButton?.addEventListener('click', () => {
                goToSlide((currentIndex + 1) % cards.length);
                resetTimer();
            });

            startTimer();

            const deliverySlider = document.querySelector('#mo-mosaic-stories .delivery-slider');
            let deliveryTimer;

            function startDeliverySlider() {
                if (!deliverySlider) {
                    return;
                }

                clearInterval(deliveryTimer);
                deliveryTimer = setInterval(() => {
                    const firstCard = deliverySlider.querySelector('[role="listitem"]');
                    if (!firstCard) return;

                    const gap = parseFloat(getComputedStyle(deliverySlider).gap) || 0;
                    const step = firstCard.getBoundingClientRect().width + gap;
                    const atEnd = deliverySlider.scrollLeft + deliverySlider.clientWidth >= deliverySlider.scrollWidth - step / 2;

                    deliverySlider.scrollTo({
                        left: atEnd ? 0 : deliverySlider.scrollLeft + step,
                        behavior: 'smooth',
                    });
                }, 2800);
            }

            deliverySlider?.addEventListener('touchstart', () => clearInterval(deliveryTimer), { passive: true });
            deliverySlider?.addEventListener('touchend', startDeliverySlider, { passive: true });
            startDeliverySlider();

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
