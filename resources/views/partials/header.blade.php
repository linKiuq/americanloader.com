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
        max-width: 1280px;
        min-height: 82px;
        margin: 0 auto;
        padding: 0 1.5rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 2.25rem;
    }

    .site-navbar__brand {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        flex-shrink: 0;
        color: #fff;
        font-size: 1.15rem;
        font-weight: 800;
        letter-spacing: 0.045em;
        text-decoration: none;
        text-transform: uppercase;
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
        height: 82px;
        display: flex;
        align-items: stretch;
        gap: clamp(1.5rem, 3vw, 2.75rem);
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

    /* Attachment links use a smaller matching panel without changing the Shop menu. */
    .attachments-dropdown {
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

    .primary-menu__item--attachments:hover .attachments-dropdown,
    .primary-menu__item--attachments:focus-within .attachments-dropdown {
        visibility: visible;
        opacity: 1;
        transform: translateY(0);
    }

    .attachments-dropdown__link {
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

    .attachments-dropdown__link:hover,
    .attachments-dropdown__link:focus-visible {
        color: var(--nav-yellow);
        outline: none;
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
        display: flex;
        align-items: center;
        gap: 0.8rem;
        flex-shrink: 0;
    }

    .site-navbar__cart {
        display: inline-flex;
        align-items: center;
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

    .site-navbar__search-form {
        position: relative;
        display: flex;
        width: clamp(190px, 20vw, 265px);
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

    @media (max-width: 1020px) {
        .site-navbar__brand span {
            display: none;
        }

        .site-navbar__search-form {
            width: 170px;
        }
    }

    @media (max-width: 760px) {
        .site-navbar__inner {
            min-height: 70px;
            padding: 0 1rem;
            gap: 1rem;
        }

        .primary-menu {
            height: 70px;
            gap: 1rem;
        }

        .primary-menu__link {
            font-size: 0.7rem;
            letter-spacing: 0.05em;
        }

        .primary-menu__item:not(.primary-menu__item--dropdown):last-child,
        .site-navbar__cart-label {
            display: none;
        }

        .site-navbar__cart {
            padding: 0 0.65rem;
        }

        .equipment-dropdown {
            left: 0;
            padding-right: 1.15rem;
            padding-left: 1.15rem;
        }

        .site-navbar__search-form {
            width: 128px;
        }

        .site-navbar__search-input {
            padding-left: 0.65rem;
            font-size: 0.72rem;
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
                <ul class="attachments-dropdown" aria-label="Attachment categories">
                    <li><a href="{{ route('attachments.mini-excavator') }}" class="attachments-dropdown__link">Mini Excavator Attachments</a></li>
                    <li><a href="{{ route('attachments.skid-steer') }}" class="attachments-dropdown__link">Skid Steer Attachments</a></li>
                </ul>
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
                <span class="site-navbar__cart-label">Cart</span>
                <span class="site-navbar__count">{{ $cartCount }}</span>
            </a>
            <form action="{{ route('equipment') }}#catalog" method="GET" class="site-navbar__search-form" role="search">
                <label for="navbar-search" class="sr-only">Search products</label>
                <input id="navbar-search" name="search" type="search" value="{{ request('search') }}" placeholder="Search products" class="site-navbar__search-input">
                <button type="submit" class="site-navbar__search-submit" aria-label="Search products">Search</button>
                <svg class="site-navbar__search-icon" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="m21 21-4.4-4.4m2-5.1a7.1 7.1 0 1 1-14.2 0 7.1 7.1 0 0 1 14.2 0Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                </svg>
            </form>
        </div>
    </div>
</nav>
