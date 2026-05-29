@php
    $currentRoute = Route::currentRouteName();
    $cartCount = array_sum(session('cart.items', []));
    $shopActive = $currentRoute === 'equipment';
    $topicsActive = $currentRoute === 'topics.index' || str_starts_with($currentRoute, 'topics.');
    $shopCategories = [
        'Forklift' => 'Forklifts',
        'Mini Excavators' => 'Mini Excavators',
        'Skid Steer Loader' => 'Skid Steer Loaders',
        'Scissor Lifts' => 'Scissor Lifts',
        'Mini Road Roller' => 'Road Rollers',
        'Wheel Loaders' => 'Wheel Loaders',
    ];
    $attachmentCategoryGroups = [
        'Mini Excavator Attachments' => [
            ['label' => 'X2 Attachments', 'url' => route('attachments.x2')],
            ['label' => 'XXV Attachments', 'url' => route('attachments.xxv')],
            ['label' => '2 Ton and Below Attachments', 'url' => route('attachments.mini-excavators-2-tons-and-below')],
            ['label' => 'Mini Excavator Attachments', 'url' => route('attachments.mini-excavator')],
        ],
        'Skid Steer Loader Attachments' => [
            ['label' => 'Compact Series 501-507 Attachments', 'url' => route('attachments.skid-steer.series', ['series' => 'compact-series'])],
            ['label' => 'Standard Series (X1300-509) Attachments', 'url' => route('attachments.skid-steer.series', ['series' => 'standard-series'])],
        ],
    ];
@endphp

<style>
    /* Main navigation: restrained spacing and a strong, consistent brand field. */
    .site-navbar {
        --nav-bg: #0b101a;
        --nav-panel: #111827;
        --nav-yellow: #facc15;
        position: sticky;
        top: 0;
        z-index: 50;
        background: var(--nav-bg);
        border-bottom: 1px solid rgba(250, 204, 21, 0.18);
        box-shadow: 0 12px 32px rgba(0, 0, 0, 0.28);
        font-family: "Inter", Arial, "Helvetica Neue", sans-serif;
    }

    .site-navbar__inner {
        max-width: 1680px;
        min-height: 82px;
        margin: 0 auto;
        padding: 0 clamp(1rem, 2vw, 1.5rem);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: clamp(1.25rem, 2.4vw, 3rem);
        min-width: 0;
    }

    .site-navbar__brand {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        flex: 0 0 auto;
        color: #fff;
        font-size: clamp(1rem, 1.35vw, 1.15rem);
        font-weight: 800;
        letter-spacing: 0.045em;
        text-decoration: none;
        text-transform: uppercase;
        white-space: nowrap;
        font-family: "Montserrat", "Inter", sans-serif;
    }

    .site-navbar__logo {
        width: 60px;
        height: 60px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
    }

    .site-navbar__logo img {
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .primary-menu,
    .equipment-dropdown,
    .attachments-dropdown {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .primary-menu {
        flex: 1 1 auto;
        min-width: 0;
        margin-left: clamp(0.75rem, 1.8vw, 2.25rem);
        height: 82px;
        display: flex;
        align-items: stretch;
        justify-content: flex-start;
        gap: clamp(1.15rem, 2vw, 2.5rem);
    }

    .primary-menu__item {
        position: relative;
        display: flex;
        align-items: stretch;
    }

    .primary-menu__link {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        padding: 0 0.1rem;
        color: #e2e8f0;
        font-size: 0.875rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-decoration: none;
        text-transform: uppercase;
        white-space: nowrap;
        transition: color 180ms ease;
    }

    .primary-menu__link:hover,
    .primary-menu__link:focus-visible,
    .primary-menu__link.is-active {
        color: #fff;
    }

    .primary-menu__link::after {
        content: "";
        position: absolute;
        right: 0;
        bottom: 0;
        left: 0;
        height: 4px;
        background: var(--nav-yellow);
        opacity: 0;
        transform: scaleX(0.45);
        transition: opacity 180ms ease, transform 180ms ease;
    }

    .primary-menu__item:hover .primary-menu__link::after,
    .primary-menu__item:focus-within .primary-menu__link::after,
    .primary-menu__link.is-active::after {
        opacity: 1;
        transform: scaleX(1);
    }

    .primary-menu__chevron {
        width: 11px;
        height: 7px;
        margin-top: 1px;
        flex-shrink: 0;
    }

    /* Hover label is kept above the dropdown padding so both can appear together. */
    .equipment-tooltip {
        position: absolute;
        top: calc(100% + 10px);
        left: 50%;
        z-index: 2;
        padding: 0.45rem 0.65rem;
        color: var(--nav-bg);
        background: var(--nav-yellow);
        font-size: 0.68rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        opacity: 0;
        pointer-events: none;
        transform: translate(-50%, -4px);
        transition: opacity 150ms ease, transform 150ms ease;
    }

    .primary-menu__item--dropdown:hover .equipment-tooltip,
    .primary-menu__item--dropdown:focus-within .equipment-tooltip {
        opacity: 1;
        transform: translate(-50%, 0);
    }

    /* Dropdown menus carry the same dark industrial surface as the hero. */
    .equipment-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        width: min(390px, calc(100vw - 2rem));
        padding: 2rem 2.35rem 1.5rem;
        visibility: hidden;
        opacity: 0;
        background: var(--nav-panel);
        border: 1px solid rgba(250, 204, 21, 0.2);
        border-top: 2px solid var(--nav-yellow);
        border-radius: 0;
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.17), 0 5px 12px rgba(15, 23, 42, 0.08);
        transform: translateY(8px);
        transition: opacity 180ms ease, transform 180ms ease, visibility 180ms ease;
    }

    .primary-menu__item--dropdown:hover .equipment-dropdown,
    .primary-menu__item--dropdown:focus-within .equipment-dropdown {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }

    .equipment-dropdown__list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .equipment-dropdown__link {
        display: block;
        padding: 1rem 0;
        color: #e2e8f0;
        font-size: 0.96rem;
        font-weight: 500;
        letter-spacing: 0.045em;
        text-decoration: none;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        transition: color 160ms ease;
    }

    .equipment-dropdown__link:hover,
    .equipment-dropdown__link:focus-visible {
        color: var(--nav-yellow);
        outline: none;
    }

    .attachments-dropdown {
        position: absolute;
        top: 100%;
        left: 50%;
        width: min(900px, calc(100vw - 2rem));
        padding: 0;
        visibility: hidden;
        opacity: 0;
        background: var(--nav-panel);
        border: 1px solid rgba(250, 204, 21, 0.2);
        border-top: 4px solid var(--nav-yellow);
        border-radius: 0;
        box-shadow: 0 26px 54px rgba(0, 0, 0, 0.34), 0 8px 18px rgba(0, 0, 0, 0.18);
        transform: translate(-50%, 8px);
        transition: opacity 180ms ease, transform 180ms ease, visibility 180ms ease;
    }

    .primary-menu__item--attachments:hover .attachments-dropdown,
    .primary-menu__item--attachments:focus-within .attachments-dropdown {
        visibility: visible;
        opacity: 1;
        transform: translate(-50%, 0);
    }

    .attachments-dropdown__header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1.25rem;
        padding: 1.55rem 2rem 1.35rem;
        background: var(--nav-panel);
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    .attachments-dropdown__eyebrow {
        margin: 0;
        color: #f8fafc;
        font-size: 1.05rem;
        font-weight: 900;
        letter-spacing: 0.18em;
        text-transform: uppercase;
    }

    .attachments-dropdown__subcopy {
        margin: 0.35rem 0 0;
        color: #94a3b8;
        font-size: 0.94rem;
    }

    .attachments-dropdown__all {
        display: inline-flex;
        align-items: center;
        gap: 0.65rem;
        min-height: 46px;
        padding: 0 1.05rem;
        color: #0b101a;
        background: var(--nav-yellow);
        border: 2px solid var(--nav-yellow);
        font-size: 0.86rem;
        font-weight: 900;
        letter-spacing: 0.04em;
        text-decoration: none;
        text-transform: uppercase;
        white-space: nowrap;
        transition: background-color 160ms ease, color 160ms ease;
    }

    .attachments-dropdown__all:hover,
    .attachments-dropdown__all:focus-visible {
        color: #f8fafc;
        background: transparent;
        outline: none;
    }

    .attachments-dropdown__all svg {
        width: 18px;
        height: 18px;
        transition: transform 160ms ease;
    }

    .attachments-dropdown__all:hover svg,
    .attachments-dropdown__all:focus-visible svg {
        transform: translateX(3px);
    }

    .attachments-dropdown__grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .attachments-dropdown__group {
        min-width: 0;
        background: var(--nav-panel);
    }

    .attachments-dropdown__group + .attachments-dropdown__group {
        border-left: 1px solid rgba(255, 255, 255, 0.08);
    }

    .attachments-dropdown__heading {
        min-height: 96px;
        padding: 1.45rem 2rem;
        color: #e2e8f0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        font-size: 1rem;
        font-weight: 900;
        letter-spacing: 0.16em;
        line-height: 1.45;
        text-transform: uppercase;
    }

    .attachments-dropdown__items {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .attachments-dropdown__link {
        display: flex;
        align-items: center;
        min-height: 82px;
        padding: 1rem 2rem;
        color: #e2e8f0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        font-size: 1rem;
        font-weight: 700;
        line-height: 1.45;
        text-decoration: none;
        transition: background-color 160ms ease, color 160ms ease, padding-left 160ms ease;
    }

    .attachments-dropdown__link:hover,
    .attachments-dropdown__link:focus-visible {
        color: var(--nav-yellow);
        background: rgba(250, 204, 21, 0.06);
        outline: none;
        padding-left: 2.2rem;
    }

    .topics-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        min-width: 300px;
        padding: 1.25rem 1.75rem;
        visibility: hidden;
        opacity: 0;
        background: var(--nav-panel);
        border: 1px solid rgba(250, 204, 21, 0.2);
        border-top: 2px solid var(--nav-yellow);
        border-radius: 0;
        box-shadow: 0 18px 38px rgba(15, 23, 42, 0.17), 0 5px 12px rgba(15, 23, 42, 0.08);
        transform: translateY(8px);
        transition: opacity 180ms ease, transform 180ms ease, visibility 180ms ease;
    }

    .primary-menu__item--topics:hover .topics-dropdown,
    .primary-menu__item--topics:focus-within .topics-dropdown {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }

    .topics-dropdown__link {
        display: block;
        padding: 1rem 0;
        color: #e2e8f0;
        font-size: 0.9rem;
        font-weight: 500;
        letter-spacing: 0.045em;
        text-decoration: none;
        text-transform: uppercase;
        border-bottom: 1px solid rgba(255, 255, 255, 0.07);
        transition: color 160ms ease;
    }

    .topics-dropdown__link:hover,
    .topics-dropdown__link:focus-visible {
        color: var(--nav-yellow);
        outline: none;
    }

    .site-navbar__actions {
        position: relative;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        flex-shrink: 0;
        margin-left: auto;
        min-width: 0;
    }

    .site-navbar__cart {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        min-height: 44px;
        padding: 0 1rem;
        color: #fff;
        border: 1px solid rgba(250, 204, 21, 0.55);
        font-size: 0.75rem;
        font-weight: 700;
        letter-spacing: 0.09em;
        text-decoration: none;
        text-transform: uppercase;
        transition: background-color 160ms ease, color 160ms ease;
    }

    .site-navbar__cart-icon {
        display: none;
        width: 18px;
        height: 18px;
    }

    .site-navbar__cart:hover {
        color: var(--nav-bg);
        background: var(--nav-yellow);
    }

    .site-navbar__count {
        min-width: 1.35rem;
        padding: 0.2rem 0.35rem;
        color: var(--nav-bg);
        background: var(--nav-yellow);
        text-align: center;
    }

    .site-navbar__search-shell {
        position: relative;
        flex: 0 1 auto;
    }

    .site-navbar__search-toggle {
        display: none;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        color: var(--nav-yellow);
        background: transparent;
        border: 1px solid rgba(250, 204, 21, 0.55);
        cursor: pointer;
        transition: background-color 160ms ease, color 160ms ease;
    }

    .site-navbar__search-toggle:hover,
    .site-navbar__search-toggle:focus-visible,
    .site-navbar__search-shell.is-open .site-navbar__search-toggle {
        color: var(--nav-bg);
        background: var(--nav-yellow);
        outline: none;
    }

    .site-navbar__search-toggle svg {
        width: 18px;
        height: 18px;
    }

    .site-navbar__search-form {
        position: relative;
        display: flex;
        flex: 1 1 auto;
        width: clamp(220px, 18vw, 320px);
        max-width: 320px;
        min-width: 0;
        height: 44px;
    }

    .site-navbar__search-input {
        flex: 1;
        min-width: 0;
        padding: 0 2.65rem 0 0.9rem;
        color: #fff;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(250, 204, 21, 0.3);
        font-size: 0.82rem;
    }

    .site-navbar__search-input::placeholder {
        color: #94a3b8;
    }

    .site-navbar__search-input:focus {
        border-color: var(--nav-yellow);
        outline: none;
        box-shadow: 0 0 0 2px rgba(250, 204, 21, 0.16);
    }

    .site-navbar__search-icon {
        position: absolute;
        top: 50%;
        right: 0.85rem;
        width: 17px;
        height: 17px;
        color: var(--nav-yellow);
        transform: translateY(-50%);
        pointer-events: none;
    }

    .site-navbar__search-submit {
        position: absolute;
        top: 0;
        right: 0;
        width: 44px;
        height: 44px;
        color: transparent;
        background: transparent;
        border: 0;
        cursor: pointer;
    }

    .site-navbar__search-submit:focus-visible {
        outline: 2px solid var(--nav-yellow);
        outline-offset: -2px;
    }

    @media (max-width: 1500px) {
        .site-navbar__inner {
            gap: 1.1rem;
        }

        .primary-menu {
            margin-left: 0.5rem;
            gap: clamp(0.9rem, 1.35vw, 1.45rem);
        }

        .primary-menu__link {
            font-size: 0.78rem;
            letter-spacing: 0.08em;
        }

        .site-navbar__cart-label {
            display: none;
        }

        .site-navbar__cart {
            min-width: 44px;
            justify-content: center;
            padding: 0 0.65rem;
        }

        .site-navbar__cart-icon {
            display: block;
        }

        .site-navbar__search-toggle {
            display: inline-flex;
        }

        .site-navbar__search-form {
            position: absolute;
            top: calc(100% + 0.65rem);
            right: 0;
            z-index: 4;
            width: min(340px, calc(100vw - 2rem));
            max-width: none;
            height: 50px;
            visibility: hidden;
            opacity: 0;
            pointer-events: none;
            transform: translateY(-6px);
            transition: opacity 160ms ease, transform 160ms ease, visibility 160ms ease;
        }

        .site-navbar__search-shell.is-open .site-navbar__search-form,
        .site-navbar__search-shell:focus-within .site-navbar__search-form {
            visibility: visible;
            opacity: 1;
            pointer-events: auto;
            transform: translateY(0);
        }

        .site-navbar__search-input {
            background: #fff;
            color: #111827;
            border-color: var(--nav-yellow);
            box-shadow: 0 18px 38px rgba(0, 0, 0, 0.28);
        }

        .site-navbar__search-input::placeholder {
            color: #64748b;
        }
    }

    @media (max-width: 1080px) {
        .site-navbar__inner {
            flex-wrap: wrap;
            row-gap: 0;
            column-gap: 1.25rem;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
        }

        .site-navbar__brand span {
            display: none;
        }

        .primary-menu {
            order: 3;
            flex: 0 0 100%;
            width: 100%;
            margin-left: 0;
            height: 46px;
            justify-content: flex-start;
            gap: 1.35rem;
            overflow-x: auto;
            overflow-y: visible;
            scrollbar-width: none;
            -webkit-overflow-scrolling: touch;
        }

        .primary-menu::-webkit-scrollbar {
            display: none;
        }

        .site-navbar__actions {
            margin-left: auto;
            flex: 0 0 auto;
            justify-content: flex-end;
        }
    }

    @media (max-width: 760px) {
        .site-navbar {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.22);
        }

        .site-navbar__inner {
            min-height: 0;
            padding: 0 0.75rem 0.45rem;
            display: grid;
            grid-template-columns: auto minmax(0, 1fr);
            gap: 0 0.65rem;
            align-items: center;
        }

        .site-navbar__brand {
            grid-column: 1 / 2;
            grid-row: 1;
            min-height: 50px;
        }

        .site-navbar__logo {
            width: 44px;
            height: 44px;
        }

        .primary-menu {
            grid-column: 1 / 2;
            grid-row: 2;
            order: initial;
            height: 40px;
            width: auto;
            margin: 0;
            padding: 0;
            align-items: center;
            gap: 0.35rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background: transparent;
            max-width: calc(100vw - 7.6rem);
        }

        .primary-menu__link {
            min-height: 30px;
            padding: 0 0.52rem;
            border: 1px solid rgba(255, 255, 255, 0.08);
            color: #cbd5e1;
            background: rgba(255, 255, 255, 0.03);
            font-size: 0.6rem;
            letter-spacing: 0.045em;
        }

        .primary-menu__link.is-active {
            color: var(--nav-bg);
            background: var(--nav-yellow);
            border-color: var(--nav-yellow);
        }

        .primary-menu__link::after {
            display: none;
        }

        .primary-menu__chevron {
            width: 9px;
            height: 6px;
        }

        .primary-menu__item:not(.primary-menu__item--dropdown):last-child,
        .site-navbar__cart-label {
            display: none;
        }

        .site-navbar__actions {
            grid-column: 2 / 3;
            grid-row: 2;
            justify-self: end;
            justify-content: flex-end;
            width: auto;
            margin: 0;
            padding: 0;
            margin-left: 0;
            gap: 0.35rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            background: transparent;
        }

        .site-navbar__cart,
        .site-navbar__search-toggle {
            width: 34px;
            height: 34px;
            min-height: 34px;
            background: rgba(255, 255, 255, 0.03);
            border-color: rgba(250, 204, 21, 0.45);
        }

        .site-navbar__cart {
            min-width: 34px;
            padding: 0;
        }

        .site-navbar__cart-icon,
        .site-navbar__search-toggle svg {
            width: 15px;
            height: 15px;
        }

        .site-navbar__count {
            position: absolute;
            top: -6px;
            right: -6px;
            min-width: 1rem;
            padding: 0.08rem 0.24rem;
            border: 2px solid var(--nav-bg);
            font-size: 0.58rem;
            line-height: 1;
        }

        .equipment-dropdown {
            left: 0;
            padding-right: 1.15rem;
            padding-left: 1.15rem;
        }

        .attachments-dropdown {
            width: min(560px, calc(100vw - 1rem));
        }

        .attachments-dropdown__header {
            align-items: flex-start;
            flex-direction: column;
            padding: 1.15rem;
        }

        .attachments-dropdown__grid {
            grid-template-columns: 1fr;
        }

        .attachments-dropdown__group + .attachments-dropdown__group {
            border-left: 0;
        }

        .attachments-dropdown__heading,
        .attachments-dropdown__link {
            padding-right: 1.15rem;
            padding-left: 1.15rem;
        }

        .attachments-dropdown__link:hover,
        .attachments-dropdown__link:focus-visible {
            padding-left: 1.3rem;
        }

        .site-navbar__search-form {
            position: fixed;
            top: 96px;
            right: 0.75rem;
            left: 0.75rem;
            width: auto;
            max-width: none;
        }

        .site-navbar__search-input {
            padding-left: 0.65rem;
            font-size: 0.82rem;
        }
    }

    @media (max-width: 420px) {
        .site-navbar__logo {
            width: 40px;
            height: 40px;
        }

        .site-navbar__brand {
            min-height: 48px;
        }

        .primary-menu {
            height: 38px;
            gap: 0.3rem;
        }

        .primary-menu__link {
            min-height: 28px;
            padding: 0 0.48rem;
            font-size: 0.58rem;
        }

        .site-navbar__actions {
            gap: 0.4rem;
        }

        .site-navbar__search-input {
            padding-right: 2.25rem;
        }
    }
</style>

<nav class="site-navbar" aria-label="Main navigation">
    <div class="site-navbar__inner">
        <a href="{{ route('welcome') }}" class="site-navbar__brand" aria-label="The Power Loader home">
            <span class="site-navbar__logo" aria-hidden="true">
                <img src="{{ asset('power-loader-logo.png') }}" alt="">
            </span>
            <span>The Power Loader</span>
        </a>

        <ul class="primary-menu">
            <li class="primary-menu__item">
                <a href="{{ route('welcome') }}" class="primary-menu__link {{ $currentRoute === 'welcome' ? 'is-active' : '' }}" @if($currentRoute === 'welcome') aria-current="page" @endif>Home</a>
            </li>
            <li class="primary-menu__item primary-menu__item--dropdown">
                <a href="{{ route('equipment') }}" class="primary-menu__link {{ $shopActive ? 'is-active' : '' }}" @if($shopActive) aria-current="page" @endif>
                    Shop
                    <svg class="primary-menu__chevron" viewBox="0 0 11 7" fill="none" aria-hidden="true">
                        <path d="M1 1 5.5 5.5 10 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </a>
                <span class="equipment-tooltip" aria-hidden="true">Shop</span>
                <div class="equipment-dropdown">
                    <ul class="equipment-dropdown__list" aria-label="Equipment categories">
                        @foreach ($shopCategories as $label => $category)
                            <li>
                                <a href="{{ route('equipment', ['category' => $category]) }}#catalog" class="equipment-dropdown__link">
                                    {{ $label }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li class="primary-menu__item primary-menu__item--attachments">
                <a href="{{ route('attachments.index') }}" class="primary-menu__link {{ str_starts_with($currentRoute, 'attachments.') ? 'is-active' : '' }}" @if(str_starts_with($currentRoute, 'attachments.')) aria-current="page" @endif>
                    Attachments
                    <svg class="primary-menu__chevron" viewBox="0 0 11 7" fill="none" aria-hidden="true">
                        <path d="M1 1 5.5 5.5 10 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </a>
                <div class="attachments-dropdown" aria-label="Attachment categories">
                    <div class="attachments-dropdown__header">
                        <div>
                            <p class="attachments-dropdown__eyebrow">Attachment Catalog</p>
                            <p class="attachments-dropdown__subcopy">Browse attachments by machine type</p>
                        </div>
                        <a href="{{ route('attachments.index') }}" class="attachments-dropdown__all">
                            View All
                            <svg viewBox="0 0 20 20" fill="none" aria-hidden="true">
                                <path d="M4 10h11m-4-4 4 4-4 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                    <div class="attachments-dropdown__grid">
                        @foreach ($attachmentCategoryGroups as $groupTitle => $items)
                            <section class="attachments-dropdown__group" aria-labelledby="attachment-group-{{ Str::slug($groupTitle) }}">
                                <h2 id="attachment-group-{{ Str::slug($groupTitle) }}" class="attachments-dropdown__heading">{{ $groupTitle }}</h2>
                                <ul class="attachments-dropdown__items">
                                    @foreach ($items as $item)
                                        <li>
                                            <a href="{{ $item['url'] }}" class="attachments-dropdown__link">
                                                <span>{{ $item['label'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </section>
                        @endforeach
                    </div>
                </div>
            </li>
            <li class="primary-menu__item primary-menu__item--topics">
                <a href="{{ route('topics.index') }}" class="primary-menu__link {{ $topicsActive ? 'is-active' : '' }}" @if($topicsActive) aria-current="page" @endif>
                    Topics
                    <svg class="primary-menu__chevron" viewBox="0 0 11 7" fill="none" aria-hidden="true">
                        <path d="M1 1 5.5 5.5 10 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    </svg>
                </a>
                <ul class="topics-dropdown" aria-label="Topics categories">
                    <li><a href="{{ route('blog.index') }}" class="topics-dropdown__link">Blog</a></li>
                    <li><a href="{{ route('topics.show', 'buy-guides') }}" class="topics-dropdown__link">Buy Guides</a></li>
                    <li><a href="{{ route('topics.show', 'features') }}" class="topics-dropdown__link">Features</a></li>
                    <li><a href="{{ route('topics.show', 'workspace') }}" class="topics-dropdown__link">Workspace</a></li>
                    <li><a href="{{ route('topics.show', 'safety') }}" class="topics-dropdown__link">Safety</a></li>
                </ul>
            </li>
            <li class="primary-menu__item">
                <a href="{{ route('about') }}" class="primary-menu__link {{ $currentRoute === 'about' ? 'is-active' : '' }}" @if($currentRoute === 'about') aria-current="page" @endif>About</a>
            </li>
            <li class="primary-menu__item">
                <a href="{{ route('contact') }}" class="primary-menu__link {{ $currentRoute === 'contact' ? 'is-active' : '' }}" @if($currentRoute === 'contact') aria-current="page" @endif>Contact</a>
            </li>
        </ul>

        <div class="site-navbar__actions">
            <a href="{{ route('cart') }}" class="site-navbar__cart">
                <svg class="site-navbar__cart-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M6.5 7.5h12l-1.1 7.1a2 2 0 0 1-2 1.7H9.1a2 2 0 0 1-2-1.6L5.6 4.8H3.8" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M9.3 20h.1m6.2 0h.1" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                </svg>
                <span class="site-navbar__cart-label">Cart</span>
                <span class="site-navbar__count">{{ $cartCount }}</span>
            </a>
            <div class="site-navbar__search-shell">
                <button type="button" class="site-navbar__search-toggle" aria-expanded="false" aria-controls="navbar-search-panel" aria-label="Open product search">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="m21 21-4.4-4.4m2-5.1a7.1 7.1 0 1 1-14.2 0 7.1 7.1 0 0 1 14.2 0Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </button>
                <form id="navbar-search-panel" action="{{ route('equipment') }}#catalog" method="GET" class="site-navbar__search-form" role="search">
                    <label for="navbar-search" class="sr-only">Search products</label>
                    <input id="navbar-search" name="search" type="search" value="{{ request('search') }}" placeholder="Search products" class="site-navbar__search-input">
                    <button type="submit" class="site-navbar__search-submit" aria-label="Search products">Search</button>
                    <svg class="site-navbar__search-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="m21 21-4.4-4.4m2-5.1a7.1 7.1 0 1 1-14.2 0 7.1 7.1 0 0 1 14.2 0Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                    </svg>
                </form>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.site-navbar__search-shell').forEach((shell) => {
            const toggle = shell.querySelector('.site-navbar__search-toggle');
            const input = shell.querySelector('.site-navbar__search-input');

            if (! toggle || ! input) {
                return;
            }

            const setOpen = (open) => {
                shell.classList.toggle('is-open', open);
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');

                if (open) {
                    window.requestAnimationFrame(() => input.focus());
                }
            };

            toggle.addEventListener('click', (event) => {
                event.stopPropagation();
                setOpen(! shell.classList.contains('is-open'));
            });

            document.addEventListener('click', (event) => {
                if (! shell.contains(event.target)) {
                    setOpen(false);
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    setOpen(false);
                    toggle.focus();
                }
            });
        });
    });
</script>
