<?php

namespace Tests\Feature;

use App\Support\ProductCatalog;
use Tests\TestCase;

class EquipmentNavigationTest extends TestCase
{
    private const SCISSOR_LIFT = 'typhon-xflex-4068et-electric-rubber-track-scissor-lift-32-ton-with-54hp-hydraulic-pump-motor-drive-and-hydraulic-lifting-cylinder-40-ft-max-lifting-height';

    public function test_catalog_keeps_unique_sku_variants_and_removes_duplicate_store_ids(): void
    {
        $products = app(ProductCatalog::class)->all();

        $this->assertCount($products->count(), $products->unique(fn (array $product) => mb_strtolower($product['sku'])));
        $this->assertCount(
            $products->count(),
            $products->unique(fn (array $product) => $product['hash'] ?? $product['checkoutUrl'] ?? '')
        );
    }

    public function test_shop_dropdown_lists_machine_families_without_repeating_attachment_categories(): void
    {
        $shopCategories = [
            'Forklift' => 'Forklifts',
            'Mini Excavators' => 'Mini Excavators',
            'Skid Steer Loader' => 'Skid Steer Loaders',
            'Scissor Lifts' => 'Scissor Lifts',
            'Mini Road Roller' => 'Road Rollers',
            'Wheel Loaders' => 'Wheel Loaders',
        ];
        $catalogCategories = app(ProductCatalog::class)->all()->countBy('category');
        $response = $this->get(route('equipment'));

        $response->assertOk()
            ->assertSee('Shop');

        foreach ($shopCategories as $label => $category) {
            $this->assertTrue($catalogCategories->has($category), "{$category} must exist in the product catalog.");

            $slug = \Illuminate\Support\Str::slug($category);
            $response->assertSee($label)
                ->assertSee(route('equipment.category', ['category' => $slug]), escape: false);
        }

        $response->assertDontSee(route('equipment.category', ['category' => 'mini-excavator-attachments']), escape: false)
            ->assertDontSee(route('equipment.category', ['category' => 'skid-steer-attachments']), escape: false);
    }

    public function test_clean_equipment_category_urls_load_and_query_urls_redirect_301(): void
    {
        $response = $this->get('/equipment/mini-excavators');
        $response->assertOk()
            ->assertSee('Mini Excavators for Sale')
            ->assertSee('https://americanloader.com/equipment/mini-excavators', escape: false);

        $redirect = $this->get('/equipment?category=Mini%20Excavators');
        $redirect->assertRedirect('/equipment/mini-excavators');
        $redirect->assertStatus(301);
    }

    public function test_attachment_dropdown_lists_machine_type_subcategories(): void
    {
        $this->get(route('welcome'))
            ->assertOk()
            ->assertSee('Attachment Catalog')
            ->assertSee('Browse attachments by machine type')
            ->assertSee('X2 Attachments')
            ->assertSee('XXV Attachments')
            ->assertSee('2 Ton and Below Attachments')
            ->assertSee('Mini Excavator Attachments')
            ->assertSee('Compact Series 501-507 Attachments')
            ->assertSee('Standard Series (X1300-509) Attachments')
            ->assertSee(route('attachments.x2'), escape: false)
            ->assertSee(route('attachments.xxv'), escape: false)
            ->assertSee(route('attachments.skid-steer.series', ['series' => 'compact-series']), escape: false)
            ->assertSee(route('attachments.skid-steer.series', ['series' => 'standard-series']), escape: false);
    }

    public function test_scissor_lift_products_are_available_and_buy_now_opens_the_matching_store_product(): void
    {
        $scissorLifts = app(ProductCatalog::class)->all()->where('category', 'Scissor Lifts');
        $expectedUrls = [
            'typhon-xflex-4065w-walk-behind-scissor-lift-27-ton-with-assisted-walking-manual-outriggers-of-40-ft-lifting-height-110v-electric' => '/store/TYPHON-xFlex-4065W-Walk-Behind-Scissor-Lift-2-7-Ton-with-Assisted-Walking-Manual-outriggers-of-40-ft-lifting-Height-&-110V-Electric-p837469759',
            'typhon-xflex-2037w-walk-behind-scissor-lift-comes-with-20ft-working-height-and-manual-outriggers-1102-lbs-load-capacity-110v-electric' => '/store/TYPHON-xFlex-2037W-Walk-Behind-Scissor-Lift-comes-with-20ft-Working-Height-and-Manual-outriggers-1102-lbs-load-capacity-110V-Electric-p837469757',
            'typhon-xflex-2031em-12-ton-electric-mini-scissor-lift-with-20ft-max-platform-height-and-197-platform-extend' => '/store/TYPHON-xFLEX-2031EM-1-2-Ton-Electric-Mini-Scissor-Lift-with-20ft-Max-Platform-Height-and-19-7-Platform-Extend-p837464013',
            'typhon-xflex-4046ew-electric-wheel-scissor-lift-26-ton-operating-weight-and-40ft-platform-height-with-705lbs-load-capacity' => '/store/TYPHON-xFlex-4046EW-Electric-Wheel-Scissor-Lift-2-6-Ton-operating-weight-and-40ft-platform-height-with-705lbs-Load-Capacity-p837444764',
            self::SCISSOR_LIFT => '/store/TYPHON-xFlex-4068ET-Electric-Rubber-Track-Scissor-Lift-3-2-Ton-with-5-4HP-Hydraulic-Pump-Motor-Drive-and-Hydraulic-Lifting-Cylinder-40-ft-Max-Lifting-Height-p837444761',
        ];

        $this->assertCount(5, $scissorLifts);
        $this->assertCount(5, $scissorLifts->unique('checkoutUrl'));
        $this->assertSame($expectedUrls, $scissorLifts->pluck('checkoutUrl', 'slug')->all());
        $this->assertTrue($scissorLifts->every(
            fn (array $product): bool => str_starts_with($product['checkoutUrl'], '/store/')
                && $product['hash'] === $product['checkoutUrl']
                && str_starts_with($product['image'], 'https://')
        ));

        $this->get(route('product.show', self::SCISSOR_LIFT))
            ->assertOk()
            ->assertSee('TYPHON xFlex-4068ET')
            ->assertSee('Scissor Lifts')
            ->assertSee('href="'.$expectedUrls[self::SCISSOR_LIFT].'"', escape: false);
    }

    public function test_navbar_search_submits_to_the_shop_catalog_and_preserves_the_search_term(): void
    {
        $this->get(route('welcome'))
            ->assertOk()
            ->assertSee('src="'.asset('american-loader-logo.webp').'"', escape: false)
            ->assertSee(asset('favicon-32x32.png').'?v=7', escape: false)
            ->assertDontSee('data:image/svg+xml')
            ->assertSee('role="search"', escape: false)
            ->assertSee('action="'.route('equipment').'"', escape: false)
            ->assertSee('name="search"', escape: false)
            ->assertSee('class="site-navbar__search-toggle"', escape: false)
            ->assertSee('aria-controls="navbar-search-panel"', escape: false)
            ->assertSee('id="navbar-search-panel"', escape: false)
            ->assertSee('--nav-bg: #ffffff', escape: false)
            ->assertSee('--nav-accent: #c91f2c', escape: false)
            ->assertDontSee('Get Quote');

        $this->get(route('equipment', ['search' => 'scissor lift']))
            ->assertOk()
            ->assertSee('value="scissor lift"', escape: false);
    }

    public function test_home_hero_renders_the_branded_poster_and_loader_video(): void
    {
        $this->get(route('welcome'))
            ->assertOk()
            ->assertSee('brand-hero')
            ->assertSee('Equipment Ready for Real Work')
            ->assertSee('Wheel Loaders in Action')
            ->assertSee(asset('american-loader-hero-poster.jpg'), escape: false)
            ->assertSee(asset('wheel-loader-gravel.mp4'), escape: false)
            ->assertSee('autoplay muted loop playsinline', escape: false)
            ->assertSee('preload="auto"', escape: false)
            ->assertSee(route('equipment.category', ['category' => 'wheel-loaders']), escape: false)
            ->assertSee('background: #c91f2c', escape: false)
            ->assertDontSee('#e67e22', escape: false);
    }

    public function test_home_includes_wheel_loader_solutions_section_with_real_links(): void
    {
        $this->get(route('welcome'))
            ->assertOk()
            ->assertSee('id="wheel-loader-solutions"', escape: false)
            ->assertSee('Wheel Loaders')
            ->assertSee('Worksite Attachments')
            ->assertSee('Financing Available')
            ->assertSee(asset('wheel-loader-solutions-red.png'), escape: false)
            ->assertSee(asset('wheel-loader-applications.png'), escape: false)
            ->assertSee(route('equipment.category', ['category' => 'wheel-loaders']), escape: false)
            ->assertSee(route('attachments.index'), escape: false)
            ->assertSee(route('contact'), escape: false);
    }

    public function test_home_hero_contains_only_the_poster_and_video_cards(): void
    {
        $this->get(route('welcome'))
            ->assertOk()
            ->assertSee('Fast Free Shipping')
            ->assertSee('Shop All')
            ->assertDontSee('id="service-assurances"', escape: false)
            ->assertDontSee('Products Active')
            ->assertDontSee('Customers Served')
            ->assertDontSee('Rating Index')
            ->assertDontSee('In Business Ops');
    }

    public function test_home_attachments_showcase_uses_compact_industrial_styling(): void
    {
        $this->get(route('welcome'))
            ->assertOk()
            ->assertSee('id="attachments"', escape: false);
    }

    public function test_home_why_choose_section_does_not_render_image_panel(): void
    {
        $this->get(route('welcome'))
            ->assertOk()
            ->assertSee('id="why-choose"', escape: false)
            ->assertSee('Compact by design.')
            ->assertDontSee('ChatGPT-Image-May-27-2026-02_31_46-PM.png', escape: false)
            ->assertDontSee('Kubota diesel engine');
    }

    public function test_topics_navigation_index_is_available(): void
    {
        $this->get(route('topics.index'))
            ->assertOk()
            ->assertSee('Topics')
            ->assertSee(route('topics.show', 'buy-guides'), escape: false)
            ->assertSee(route('topics.show', 'safety'), escape: false);
    }

    public function test_public_pages_include_search_optimized_metadata(): void
    {
        $this->get(route('welcome'))
            ->assertOk()
            ->assertSee('<title>American Loader | Wheel Loaders, Skid Steers &amp; Mini Excavators</title>', escape: false)
            ->assertSee('<link rel="canonical" href="https://americanloader.com/">', escape: false)
            ->assertSee('<meta property="og:site_name" content="American Loader">', escape: false)
            ->assertSee('application/ld+json', escape: false)
            ->assertSee('SearchAction', escape: false);

        $this->get(route('equipment'))
            ->assertOk()
            ->assertSee('<title>Heavy Equipment for Sale | Wheel Loaders, Skid Steers &amp; Excavators</title>', escape: false)
            ->assertSee('<link rel="canonical" href="https://americanloader.com/equipment">', escape: false)
            ->assertSee('CollectionPage', escape: false);
    }

    public function test_product_pages_include_product_schema_and_canonical_url(): void
    {
        $this->get(route('product.show', self::SCISSOR_LIFT))
            ->assertOk()
            ->assertSee('<meta property="og:type" content="product">', escape: false)
            ->assertSee('<link rel="canonical" href="https://americanloader.com/product/'.self::SCISSOR_LIFT.'">', escape: false)
            ->assertSee('"@type":"Product"', escape: false)
            ->assertSee('"category":"Scissor Lifts"', escape: false);
    }

    public function test_sitemap_and_robots_expose_crawl_paths(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
            ->assertSee('Disallow: /admin', escape: false)
            ->assertSee('Sitemap: https://americanloader.com/sitemap.xml', escape: false);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml; charset=UTF-8')
            ->assertSee('<loc>https://americanloader.com/equipment</loc>', escape: false)
            ->assertSee('<loc>https://americanloader.com/attachments/skid-steer/compact-series</loc>', escape: false)
            ->assertSee('<loc>https://americanloader.com/product/'.self::SCISSOR_LIFT.'</loc>', escape: false);
    }
}
