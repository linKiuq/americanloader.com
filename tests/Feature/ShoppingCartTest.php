<?php

namespace Tests\Feature;

use Tests\TestCase;

class ShoppingCartTest extends TestCase
{
    private const FORKLIFT = '2024-typhon-2-ton-rated-capacity-electric-forklift-lifter-lift-truck-usa';

    private const VIGOR = 'new-2025-typhon-vigor-1-5-blue-electric-forklift-1-5-ton-lifter-lift-truck-jitney-hi-lo';

    public function test_multiple_equipment_products_can_be_added_to_one_cart(): void
    {
        $productPage = route('product.show', self::FORKLIFT);

        $this->from($productPage)
            ->post(route('cart.items.store'), ['slug' => self::FORKLIFT])
            ->assertRedirect($productPage);
        $this->from(route('equipment'))
            ->post(route('cart.items.store'), ['slug' => self::VIGOR])
            ->assertRedirect(route('equipment'));

        $this->get(route('cart'))
            ->assertOk()
            ->assertSee('2024 TYPHON 2 Ton Rated Capacity Electric Forklift')
            ->assertSee('New 2025 TYPHON VIGOR 1.5 Blue Electric Forklift')
            ->assertSee('$25,597.00')
            ->assertSee('Shopping cart')
            ->assertSee('Your email address')
            ->assertSee('Checkout')
            ->assertSee('Pay with')
            ->assertSee('PayPal');
    }

    public function test_adding_a_product_stays_on_the_product_page_with_a_confirmation(): void
    {
        $productPage = route('product.show', self::FORKLIFT);

        $this->from($productPage)
            ->post(route('cart.items.store'), ['slug' => self::FORKLIFT])
            ->assertRedirect($productPage)
            ->assertSessionHas('success', 'Equipment added to your cart.')
            ->assertSessionHas('cart.items.'.self::FORKLIFT, 1);

        $this->get($productPage)
            ->assertOk()
            ->assertSee('Equipment added to your cart.')
            ->assertSee('>1</span>', false);
    }

    public function test_adding_the_same_product_twice_keeps_one_cart_line_with_quantity_two(): void
    {
        $this->post(route('cart.items.store'), ['slug' => self::FORKLIFT])->assertRedirect();
        $this->post(route('cart.items.store'), ['slug' => self::FORKLIFT])->assertRedirect();

        $this->assertSame([self::FORKLIFT => 2], session('cart.items'));

        $this->get(route('cart'))
            ->assertOk()
            ->assertSee('value="2"', false);
    }

    public function test_cart_quantities_can_be_changed_and_items_removed_or_cleared(): void
    {
        $this->withSession(['cart.items' => [
            self::FORKLIFT => 1,
            self::VIGOR => 1,
        ]]);

        $this->patch(route('cart.items.update'), ['slug' => self::FORKLIFT, 'quantity' => 3])
            ->assertRedirect();

        $this->get(route('cart'))
            ->assertOk()
            ->assertSee('$56,793.00');

        $this->delete(route('cart.items.destroy'), ['slug' => self::VIGOR])->assertRedirect();
        $this->get(route('cart'))->assertDontSee('New 2025 TYPHON VIGOR 1.5 Blue Electric Forklift');

        $this->delete(route('cart.clear'))->assertRedirect();
        $this->get(route('cart'))->assertSee('Your cart is empty');
    }

    public function test_checkout_submits_every_cart_item_as_one_session_order_and_empties_cart(): void
    {
        $response = $this->withSession(['cart.items' => [
            self::FORKLIFT => 2,
            self::VIGOR => 1,
        ]])->post(route('checkout.store'), [
            'name' => 'Pat Builder',
            'email' => 'pat@example.com',
            'phone' => '+1 213-214-2203',
            'company' => 'Site Works',
            'address' => '2642 River Ave #A',
            'city' => 'Rosemead',
            'state' => 'CA',
            'zip' => '91770',
            'notes' => 'Call before delivery.',
        ]);

        $response
            ->assertOk()
            ->assertSee('Order Received')
            ->assertSee('2024 TYPHON 2 Ton Rated Capacity Electric Forklift')
            ->assertSee('New 2025 TYPHON VIGOR 1.5 Blue Electric Forklift')
            ->assertSee('$41,195.00')
            ->assertSessionMissing('cart.items')
            ->assertSessionHas('orders.0.items', fn (array $items): bool => count($items) === 2);
    }

    public function test_checkout_step_prefills_email_from_the_cart_page(): void
    {
        $this->withSession(['cart.items' => [self::FORKLIFT => 1]])
            ->get(route('checkout.show', ['email' => 'buyer@example.com', 'payment' => 'paypal']))
            ->assertOk()
            ->assertSee('value="buyer@example.com"', false)
            ->assertSee('PayPal selected.')
            ->assertSee('Delivery options')
            ->assertSee('Place order');
    }

    public function test_unknown_catalog_products_cannot_be_added_to_cart(): void
    {
        $this->post(route('cart.items.store'), ['slug' => 'not-a-product'])->assertNotFound();
    }

    public function test_buy_now_links_a_product_to_its_ecwid_store_view(): void
    {
        $this->get(route('product.show', self::FORKLIFT))
            ->assertOk()
            ->assertSee('Buy Now')
            ->assertSee('/store#!/2024-TYPHON-2-Ton-Rated-Capacity-Electric-Forklift-Lifter-Lift-Truck-USA-p598669332');
    }

    public function test_cart_and_checkout_use_store_prefixed_routes(): void
    {
        $this->assertSame(url('/store/cart'), route('cart'));
        $this->assertSame(url('/store/cart/add'), route('cart.items.store'));
        $this->assertSame(url('/store/cart/remove'), route('cart.items.destroy'));
        $this->assertSame(url('/store/cart/update'), route('cart.items.update'));
        $this->assertSame(url('/store/checkout'), route('checkout.show'));
    }
}
