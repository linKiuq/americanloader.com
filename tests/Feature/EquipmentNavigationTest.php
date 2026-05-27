<?php

namespace Tests\Feature;

use App\Support\ProductCatalog;
use Tests\TestCase;

class EquipmentNavigationTest extends TestCase
{
    private const SCISSOR_LIFT = 'typhon-xflex-4068et-electric-rubber-track-scissor-lift-3-2-ton-with-5-4hp-hydraulic-pump-motor-drive-and-hydraulic-lifting-cylinder-40-ft-max-lifting-height';

    public function test_catalog_removes_products_with_duplicate_names_or_store_ids(): void
    {
        $products = app(ProductCatalog::class)->all();

        $this->assertCount($products->count(), $products->unique(fn (array $product) => mb_strtolower($product['name'])));
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

            $response->assertSee($label)
                ->assertSee(route('equipment', ['category' => $category]).'#catalog', escape: false);
        }

        $response->assertDontSee(route('equipment', ['category' => 'Mini Excavator Attachments']).'#catalog', escape: false)
            ->assertDontSee(route('equipment', ['category' => 'Skid Steer Attachments']).'#catalog', escape: false);
    }

    public function test_scissor_lift_products_are_available_and_buy_now_opens_the_matching_store_product(): void
    {
        $scissorLifts = app(ProductCatalog::class)->all()->where('category', 'Scissor Lifts');
        $expectedUrls = [
            self::SCISSOR_LIFT => '/store#!/TYPHON-xFlex-4068ET-Electric-Rubber-Track-Scissor-Lift-3-2-Ton-with-5-4HP-Hydraulic-Pump-Motor-Drive-and-Hydraulic-Lifting-Cylinder-40-ft-Max-Lifting-Height/p/837444761',
            'typhon-xflex-4065w-walk-behind-scissor-lift-2-7-ton-with-assisted-walking-manual-outriggers-of-40-ft-lifting-height-110v-electric' => '/store#!/TYPHON-xFlex-4065W-Walk-Behind-Scissor-Lift-2-7-Ton-with-Assisted-Walking-Manual-outriggers-of-40-ft-lifting-Height-&-110V-Electric/p/837469759',
            'typhon-xflex-4046ew-electric-wheel-scissor-lift-2-6-ton-operating-weight-and-40ft-platform-height-with-705lbs-load-capacity' => '/store#!/TYPHON-xFlex-4046EW-Electric-Wheel-Scissor-Lift-2-6-Ton-operating-weight-and-40ft-platform-height-with-705lbs-Load-Capacity/p/837444764',
            'typhon-xflex-2037w-walk-behind-scissor-lift-comes-with-20ft-working-height-and-manual-outriggers-1102-lbs-load-capacity-110v-electric' => '/store#!/TYPHON-xFlex-2037W-Walk-Behind-Scissor-Lift-comes-with-20ft-Working-Height-and-Manual-outriggers-1102-lbs-load-capacity-110V-Electric/p/837469757',
            'typhon-xflex-2031em-1-2-ton-electric-mini-scissor-lift-with-20ft-max-platform-height-and-19-7-platform-extend' => '/store#!/TYPHON-xFLEX-2031EM-1-2-Ton-Electric-Mini-Scissor-Lift-with-20ft-Max-Platform-Height-and-19-7-Platform-Extend/p/837464013',
        ];

        $this->assertCount(5, $scissorLifts);
        $this->assertCount(5, $scissorLifts->unique('checkoutUrl'));
        $this->assertSame($expectedUrls, $scissorLifts->pluck('checkoutUrl', 'slug')->all());
        $this->assertTrue($scissorLifts->every(
            fn (array $product): bool => str_starts_with($product['checkoutUrl'], '/store#!/')
                && $product['hash'] === $product['checkoutUrl']
                && str_starts_with($product['image'], 'https://d2j6dbq0eux0bg.cloudfront.net/images/80100025/products/')
        ));

        $this->get(route('product.show', self::SCISSOR_LIFT))
            ->assertOk()
            ->assertSee('TYPHON xFlex 4068ET Electric Rubber Track Scissor Lift')
            ->assertSee('Scissor Lifts')
            ->assertSee('href="'.$expectedUrls[self::SCISSOR_LIFT].'"', escape: false);
    }

    public function test_navbar_search_submits_to_the_shop_catalog_and_preserves_the_search_term(): void
    {
        $this->get(route('welcome'))
            ->assertOk()
            ->assertSee('src="'.asset('logo.png').'"', escape: false)
            ->assertSee(asset('favicon-32x32.png').'?v=3', escape: false)
            ->assertDontSee('data:image/svg+xml')
            ->assertSee('role="search"', escape: false)
            ->assertSee('action="'.route('equipment').'#catalog"', escape: false)
            ->assertSee('name="search"', escape: false)
            ->assertSee('--nav-bg: #0b101a', escape: false)
            ->assertSee('--nav-yellow: #facc15', escape: false)
            ->assertDontSee('Get Quote');

        $this->get(route('equipment', ['search' => 'scissor lift']))
            ->assertOk()
            ->assertSee('value="scissor lift"', escape: false);
    }

    public function test_home_hero_renders_the_interactive_wheel_loader_configurator(): void
    {
        $this->get(route('welcome'))
            ->assertOk()
            ->assertSee('industrial-hero-section')
            ->assertSee('Power Your')
            ->assertSee('Next Project')
            ->assertSee('Engine Power and Torque')
            ->assertSee('https://minexcavators.com/wp-content/uploads/2026/05/image.webp', escape: false)
            ->assertSee(route('equipment', ['category' => 'Wheel Loaders']).'#catalog', escape: false)
            ->assertSee('background-color: #facc15', escape: false)
            ->assertDontSee('#e67e22', escape: false)
            ->assertDontSee('orange-', escape: false)
            ->assertDontSee('🔥', escape: false)
            ->assertSee('swapFeatureContext', escape: false);
    }

    public function test_home_includes_wheel_loader_solutions_section_with_real_links(): void
    {
        $this->get(route('welcome'))
            ->assertOk()
            ->assertSee('id="wheel-loader-solutions"', escape: false)
            ->assertSee('Built for Serious Work')
            ->assertSee('https://electricforklift.org/wp-content/uploads/2026/05/ChatGPT-Image-May-27-2026-02_03_58-PM.png', escape: false)
            ->assertSee(route('equipment', ['category' => 'Wheel Loaders']).'#catalog', escape: false)
            ->assertSee(route('contact'), escape: false);
    }

    public function test_home_replaces_hero_statistics_with_service_assurances(): void
    {
        $this->get(route('welcome'))
            ->assertOk()
            ->assertSee('Shipping Sitewide')
            ->assertSee('Free US shipping')
            ->assertSee('Return Policy')
            ->assertSee('30 Days return &amp; Exchange', escape: false)
            ->assertSee('1 Year Warranty')
            ->assertSee('On all equipment purchases')
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
            ->assertSee('id="attachments" class="py-16 lg:py-20 bg-slate-950', escape: false)
            ->assertSee('max-width: 940px', escape: false)
            ->assertSee('height: 510px', escape: false)
            ->assertSee('text-yellow-400 font-black text-xs uppercase tracking-widest')
            ->assertSee('bg-yellow-400 w-8', escape: false);
    }

    public function test_home_why_choose_section_does_not_render_image_panel(): void
    {
        $this->get(route('welcome'))
            ->assertOk()
            ->assertSee('id="why-choose"', escape: false)
            ->assertSee('Why choose the TYPHON SKOOP for compact loader work?')
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
}
