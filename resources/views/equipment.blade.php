<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.head-favicon')
    <title>Equipment - The Power Loader</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #ffffff;
            color: #111827;
        }
        .sticky-nav {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(148, 163, 184, 0.35);
        }
        .hero-bg {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 58%, #fffbeb 100%);
        }
        .btn-primary {
            background: #facc15;
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background: #eab308;
            box-shadow: 0 0 18px rgba(250, 204, 21, 0.35);
        }
        .tab-btn.active {
            border-color: #facc15;
            color: #eab308;
            background-color: rgba(250, 204, 21, 0.12);
        }
        .product-card {
            min-height: 360px;
        }
        #catalog {
            scroll-margin-top: 82px;
        }
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col scroll-smooth">
    @include('partials.header')

    <section class="hero-bg py-14 px-4 sm:px-6 lg:px-8 border-b border-gray-200">
        <div class="max-w-7xl mx-auto grid lg:grid-cols-[1.2fr_0.8fr] gap-8 items-end">
            <div>
                <p class="text-yellow-400 text-sm font-bold uppercase tracking-[0.25em] mb-3">Equipment Catalog</p>
                <h1 class="text-4xl sm:text-5xl font-black text-gray-950 mb-4">Shop Typhon machinery and attachments</h1>
                <p class="text-lg text-gray-600 max-w-3xl">Browse <span id="hero-product-description-count">products</span>, add the equipment you need, and submit everything together in one streamlined checkout.</p>
            </div>
            <div class="grid grid-cols-3 gap-3 text-center">
                <div class="border border-gray-200 bg-white rounded-lg p-4 shadow-sm">
                    <div class="text-2xl font-black text-gray-950" id="hero-product-count">--</div>
                    <div class="text-[11px] text-gray-500 uppercase tracking-wider mt-1">Products</div>
                </div>
                <div class="border border-gray-200 bg-white rounded-lg p-4 shadow-sm">
                    <div class="text-2xl font-black text-gray-950" id="hero-category-count">0</div>
                    <div class="text-[11px] text-gray-500 uppercase tracking-wider mt-1">Categories</div>
                </div>
                <div class="border border-gray-200 bg-white rounded-lg p-4 shadow-sm">
                    <div class="text-2xl font-black text-gray-950">One</div>
                    <div class="text-[11px] text-gray-500 uppercase tracking-wider mt-1">Checkout</div>
                </div>
            </div>
        </div>
    </section>

    <section id="catalog" class="py-12 px-4 sm:px-6 lg:px-8 bg-white flex-grow">
        <div class="max-w-7xl mx-auto">
            @if (session('success'))
                <div class="mb-8 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-semibold text-green-800">{{ session('success') }}</div>
            @endif
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8 pb-6 border-b border-gray-200">
                <div>
                    <h2 class="text-2xl font-black text-gray-950 uppercase tracking-wide">Product Directory</h2>
                    <p class="text-gray-600 text-sm mt-2">Add multiple products to your cart and place one combined order.</p>
                </div>
                <div class="flex flex-col sm:flex-row items-stretch gap-4">
                    <div class="relative min-w-full sm:min-w-[300px]">
                        <i class="fas fa-search absolute left-4 top-3.5 text-gray-500 text-sm"></i>
                        <input type="search" id="search-box" value="{{ request('search') }}" placeholder="Search product name..." class="w-full bg-white border border-gray-300 rounded-lg pl-10 pr-4 py-2.5 text-gray-950 text-sm focus:outline-none focus:border-yellow-500 transition">
                    </div>
                    <div class="relative">
                        <select id="sort-box" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2.5 text-gray-950 text-sm focus:outline-none focus:border-yellow-500 transition appearance-none cursor-pointer pr-10">
                            <option value="default">Default Sort</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="alpha">Alphabetical</option>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-4 text-gray-500 text-xs pointer-events-none"></i>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap gap-2 mb-8" id="category-tabs"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="catalog-grid"></div>

            <div id="empty-state" class="hidden text-center py-16 border border-dashed border-gray-300 rounded-lg bg-gray-50">
                <i class="fas fa-magnifying-glass text-gray-600 text-3xl mb-3"></i>
                <h3 class="text-lg font-bold text-gray-950">No products found</h3>
                <p class="text-sm text-gray-500 mt-2">Try another search or category.</p>
            </div>

            <div class="flex justify-center items-center gap-4 mt-12 pt-6 border-t border-gray-200" id="pagination-bar">
                <button id="btn-prev" class="px-4 py-2 bg-white border border-gray-300 hover:border-yellow-500 rounded-lg text-xs font-bold uppercase text-gray-900 disabled:opacity-30 disabled:hover:border-gray-300 transition">Prev</button>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Page <span id="current-page-num" class="text-yellow-500">1</span> of <span id="total-pages-num">1</span></span>
                <button id="btn-next" class="px-4 py-2 bg-white border border-gray-300 hover:border-yellow-500 rounded-lg text-xs font-bold uppercase text-gray-900 disabled:opacity-30 disabled:hover:border-gray-300 transition">Next</button>
            </div>
        </div>
    </section>

    <section class="py-12 px-4 sm:px-6 lg:px-8 bg-white border-t border-gray-200">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-center mb-3"><i class="fas fa-shipping-fast text-yellow-500 text-xl mr-3"></i><h3 class="text-lg font-bold text-gray-950">Fast Shipping</h3></div>
                <p class="text-gray-600 text-sm">Reliable delivery support for machinery, attachments, and parts.</p>
            </div>
            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-center mb-3"><i class="fas fa-headset text-yellow-500 text-xl mr-3"></i><h3 class="text-lg font-bold text-gray-950">Expert Support</h3></div>
                <p class="text-gray-600 text-sm">Our team can help buyers select the correct equipment configuration.</p>
            </div>
            <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                <div class="flex items-center mb-3"><i class="fas fa-shield-alt text-yellow-500 text-xl mr-3"></i><h3 class="text-lg font-bold text-gray-950">Warranty Protected</h3></div>
                <p class="text-gray-600 text-sm">Equipment options include service and warranty coverage.</p>
            </div>
        </div>
    </section>

    @include('partials.footer')

    <script>
        let productsInventory = [];
        let filteredProducts = [];
        let activeCategory = 'All';
        const itemsPerPage = 12;
        let currentPage = 1;

        const currencyFormatter = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD', maximumFractionDigits: 0 });

        function escapeHtml(value) {
            return String(value || '').replace(/[&<>'"]/g, char => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                "'": '&#39;',
                '"': '&quot;'
            }[char]));
        }

        function categoryId(category) {
            return `cat-${category.replace(/[^a-z0-9]+/gi, '-').replace(/^-|-$/g, '') || 'all'}`;
        }

        function uniqueProducts(products) {
            const names = new Set();
            const storeIds = new Set();

            return products.filter(product => {
                const name = String(product.name || '').trim().toLowerCase();
                const storeId = String(product.hash || product.checkoutUrl || '');
                const isDuplicate = (name && names.has(name)) || (storeId && storeIds.has(storeId));

                if (name) names.add(name);
                if (storeId) storeIds.add(storeId);

                return !isDuplicate;
            });
        }

        function selectedCategoryFromUrl() {
            const requestedCategory = new URLSearchParams(window.location.search).get('category');
            return productsInventory.some(product => product.category === requestedCategory) ? requestedCategory : 'All';
        }

        function updateCatalogUrl(category) {
            const url = new URL(window.location.href);

            if (category === 'All') {
                url.searchParams.delete('category');
            } else {
                url.searchParams.set('category', category);
            }

            url.hash = 'catalog';
            window.history.replaceState({}, '', url);
        }

        function productStoreUrl(productHash) {
            if (!productHash) return '/store#!/';
            if (productHash.startsWith('http') || productHash.startsWith('/product/')) return productHash;
            if (productHash.startsWith('/')) return productHash;
            return `/store${productHash}`;
        }

        function productDetailUrl(product) {
            return product.detailUrl || productStoreUrl(product.hash);
        }

        function productCheckoutUrl(product) {
            return product.checkoutUrl || productStoreUrl(product.hash);
        }

        async function initializeCatalog() {
            const response = await fetch('/equipment-products.json');
            productsInventory = uniqueProducts(await response.json());
            activeCategory = selectedCategoryFromUrl();
            filteredProducts = [...productsInventory];
            document.getElementById('hero-product-count').textContent = productsInventory.length;
            document.getElementById('hero-product-description-count').textContent = `${productsInventory.length} products`;
            renderCategoryTabs();
            bindCatalogControls();
            applyFiltersAndRender();
        }

        function renderCategoryTabs() {
            const counts = productsInventory.reduce((acc, product) => {
                acc[product.category] = (acc[product.category] || 0) + 1;
                return acc;
            }, { All: productsInventory.length });

            const categories = ['All', ...Object.keys(counts).filter(category => category !== 'All').sort((a, b) => a.localeCompare(b))];
            document.getElementById('hero-category-count').textContent = categories.length - 1;

            document.getElementById('category-tabs').innerHTML = categories.map(category => `
                <button type="button" id="${categoryId(category)}" class="tab-btn ${category === activeCategory ? 'active' : ''} px-4 py-2 bg-white border border-gray-300 text-gray-700 text-xs font-bold uppercase tracking-wider rounded-lg transition shadow-sm" data-category="${escapeHtml(category)}" aria-pressed="${category === activeCategory}">
                    ${escapeHtml(category)} <span class="text-gray-500">(${counts[category]})</span>
                </button>
            `).join('');

            document.getElementById('category-tabs').addEventListener('click', event => {
                const button = event.target.closest('button[data-category]');
                if (!button) return;
                activeCategory = button.dataset.category;
                currentPage = 1;
                document.querySelectorAll('#category-tabs .tab-btn').forEach(tab => {
                    const selected = tab === button;
                    tab.classList.toggle('active', selected);
                    tab.setAttribute('aria-pressed', String(selected));
                });
                updateCatalogUrl(activeCategory);
                applyFiltersAndRender();
            });
        }

        function bindCatalogControls() {
            document.getElementById('search-box').addEventListener('input', () => {
                currentPage = 1;
                applyFiltersAndRender();
            });
            document.getElementById('sort-box').addEventListener('change', () => {
                currentPage = 1;
                applyFiltersAndRender();
            });
            document.getElementById('btn-prev').addEventListener('click', () => changePage(-1));
            document.getElementById('btn-next').addEventListener('click', () => changePage(1));
        }

        function applyFiltersAndRender() {
            const searchQuery = document.getElementById('search-box').value.toLowerCase().trim();
            const sortSelection = document.getElementById('sort-box').value;

            filteredProducts = productsInventory.filter(product => {
                const matchesCategory = activeCategory === 'All' || product.category === activeCategory;
                const matchesQuery = !searchQuery || `${product.name} ${product.desc}`.toLowerCase().includes(searchQuery);
                return matchesCategory && matchesQuery;
            });

            if (sortSelection === 'price-low') {
                filteredProducts.sort((a, b) => a.price - b.price);
            } else if (sortSelection === 'price-high') {
                filteredProducts.sort((a, b) => b.price - a.price);
            } else if (sortSelection === 'alpha') {
                filteredProducts.sort((a, b) => a.name.localeCompare(b.name));
            }

            renderGrid();
        }

        function renderGrid() {
            const gridContainer = document.getElementById('catalog-grid');
            const emptyState = document.getElementById('empty-state');
            const paginationBar = document.getElementById('pagination-bar');

            if (filteredProducts.length === 0) {
                gridContainer.innerHTML = '';
                emptyState.classList.remove('hidden');
                paginationBar.classList.add('hidden');
                return;
            }

            emptyState.classList.add('hidden');
            paginationBar.classList.remove('hidden');

            const totalPages = Math.max(1, Math.ceil(filteredProducts.length / itemsPerPage));
            currentPage = Math.min(currentPage, totalPages);
            document.getElementById('total-pages-num').textContent = totalPages;
            document.getElementById('current-page-num').textContent = currentPage;
            document.getElementById('btn-prev').disabled = currentPage === 1;
            document.getElementById('btn-next').disabled = currentPage === totalPages;

            const itemsToRender = filteredProducts.slice((currentPage - 1) * itemsPerPage, currentPage * itemsPerPage);
            gridContainer.innerHTML = itemsToRender.map(product => `
                <article class="product-card bg-white border border-gray-200 rounded-lg overflow-hidden hover:border-yellow-500/60 hover:shadow-md transition duration-300 flex flex-col h-full group cursor-pointer focus-within:border-yellow-500" data-product-url="${escapeHtml(productDetailUrl(product))}" tabindex="0" role="link" aria-label="Open ${escapeHtml(product.name)}">
                    <div class="w-full h-52 bg-gray-50 p-4 flex items-center justify-center relative overflow-hidden flex-shrink-0">
                        ${product.image ? `<img src="${escapeHtml(product.image)}" alt="${escapeHtml(product.name)}" loading="lazy" class="max-w-full max-h-full object-contain group-hover:scale-105 transition duration-500 rounded">` : '<i class="fas fa-truck-monster text-gray-300 text-5xl"></i>'}
                        <span class="absolute top-3 left-3 bg-white/95 border border-gray-200 text-[10px] font-black text-yellow-600 px-2 py-0.5 rounded tracking-wider uppercase shadow-sm">${escapeHtml(product.category)}</span>
                    </div>
                    <div class="p-5 flex flex-col flex-grow">
                        <h3 class="text-gray-950 font-bold text-sm line-clamp-2 uppercase tracking-tight mb-2 min-h-10 group-hover:text-yellow-600 transition">${escapeHtml(product.name)}</h3>
                        <div class="mt-auto pt-4 border-t border-gray-200 flex flex-col gap-3">
                            <span class="text-gray-500 text-base font-black tracking-tight">Quote on request</span>
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('cart.items.store') }}" class="flex-1">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="slug" value="${escapeHtml(product.slug)}">
                                    <button type="submit" class="w-full border border-gray-300 hover:border-yellow-500 text-gray-950 text-[11px] font-black px-3 py-2.5 rounded uppercase tracking-wider transition whitespace-nowrap">Add</button>
                                </form>
                                <a href="${escapeHtml(productCheckoutUrl(product))}" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-center text-white text-[11px] font-black px-3 py-2.5 rounded uppercase tracking-wider transition whitespace-nowrap">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </article>
            `).join('');

            gridContainer.querySelectorAll('.product-card').forEach(card => {
                card.addEventListener('click', event => {
                    if (event.target.closest('a, button')) return;
                    window.location.href = card.dataset.productUrl;
                });
                card.addEventListener('keydown', event => {
                    if (event.key !== 'Enter' && event.key !== ' ') return;
                    event.preventDefault();
                    window.location.href = card.dataset.productUrl;
                });
            });
        }

        function changePage(direction) {
            currentPage += direction;
            renderGrid();
            document.getElementById('catalog').scrollIntoView({ behavior: 'smooth' });
        }

        document.addEventListener('DOMContentLoaded', initializeCatalog);
    </script>
</body>
</html>
