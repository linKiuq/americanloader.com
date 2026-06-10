<?php

namespace Tests\Feature;

use Tests\TestCase;

class AttachmentCatalogTest extends TestCase
{
    private const MINI_BUNDLE = '10-in-1-mini-excavator-attachment-bundle-essential-tools-combo-kit-for-worksites';

    public function test_attachment_shop_displays_real_products_and_category_counts(): void
    {
        $this->get(route('attachments.index'))
            ->assertOk()
            ->assertSee('Equipment Attachments')
            ->assertSee('71')
            ->assertSee('Mini Excavator')
            ->assertSee('44')
            ->assertSee('Skid Steer')
            ->assertSee('27')
            ->assertSee('10-in-1 Mini Excavator Attachment Bundle')
            ->assertSee('Add to Cart')
            ->assertSee('Buy Now');
    }

    public function test_attachment_category_supports_search_and_sort_controls(): void
    {
        $this->get(route('attachments.mini-excavator'))
            ->assertOk()
            ->assertSee('Mini Excavator Attachments')
            ->assertSee('10-in-1 Mini Excavator Attachment Bundle');

        $this->get(route('attachments.skid-steer', ['search' => 'snow blower', 'sort' => 'price-low']))
            ->assertOk()
            ->assertSee('Skid Steer Attachments')
            ->assertSee('TYPHON Skid Steer Loader Snow Blower Attachment USA')
            ->assertSee('Showing 1-1 of');
    }

    public function test_attachment_subcategory_pages_show_the_correct_filtered_products(): void
    {
        $this->get(route('attachments.x2'))
            ->assertOk()
            ->assertSee('X2 Attachments')
            ->assertSee('Browse high-performance machinery and professional attachment solutions in the X2 Attachments collection.')
            ->assertSee('TERROR X2')
            ->assertDontSee('Terror XXV');

        $this->get(route('attachments.xxv'))
            ->assertOk()
            ->assertSee('XXV Attachments')
            ->assertSee('Terror XXV')
            ->assertDontSee('TERROR X2 PRO');

        $this->get(route('attachments.mini-excavators-2-tons-and-below'))
            ->assertOk()
            ->assertSee('2 Ton and Below Attachments')
            ->assertSee('5-in-1 0.8-2 Ton Excavator Attachments');

        $this->get(route('attachments.skid-steer.series', ['series' => 'standard-series']))
            ->assertOk()
            ->assertSee('Standard Series (X1300-509) Attachments')
            ->assertSee('STOMP X1300')
            ->assertSee('STOMP 509');

        $this->get(route('attachments.skid-steer.series', ['series' => 'compact-series']))
            ->assertOk()
            ->assertSee('Compact Series 501-507 Attachments')
            ->assertDontSee('STOMP X1300')
            ->assertDontSee('STOMP 509');
    }

    public function test_real_attachment_products_can_be_added_to_the_cart(): void
    {
        $catalogPage = route('attachments.index');

        $this->from($catalogPage)
            ->post(route('cart.items.store'), ['slug' => self::MINI_BUNDLE])
            ->assertRedirect($catalogPage)
            ->assertSessionHas('success', 'Equipment added to your cart.');

        $this->get(route('cart'))
            ->assertOk()
            ->assertSee('10-in-1 Mini Excavator Attachment Bundle')
            ->assertSee('Pricing is hidden in the shopping cart');
    }
}
