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
            ->assertSee('89')
            ->assertSee('Mini Excavator')
            ->assertSee('47')
            ->assertSee('Skid Steer')
            ->assertSee('40')
            ->assertSee('Mini Excavator Attachment');
    }

    public function test_attachment_category_supports_search_and_sort_controls(): void
    {
        $this->get(route('attachments.mini-excavator'))
            ->assertOk()
            ->assertSee('Mini Excavator Attachments');

        $this->get(route('attachments.skid-steer', ['search' => 'snow', 'sort' => 'price-low']))
            ->assertOk()
            ->assertSee('Skid Steer Attachments');
    }

    public function test_attachment_subcategory_pages_show_the_correct_filtered_products(): void
    {
        $this->get(route('attachments.x2'))
            ->assertOk()
            ->assertSee('X2 Attachments')
            ->assertSee('Browse high-performance machinery and professional attachment solutions in the X2 Attachments collection.');

        $this->get(route('attachments.xxv'))
            ->assertOk()
            ->assertSee('XXV Attachments');

        $this->get(route('attachments.mini-excavators-2-tons-and-below'))
            ->assertOk()
            ->assertSee('2 Ton and Below Attachments');

        $this->get(route('attachments.skid-steer.series', ['series' => 'standard-series']))
            ->assertOk()
            ->assertSee('Standard Series (X1300-509) Attachments')
            ->assertSee('STOMP');

        $this->get(route('attachments.skid-steer.series', ['series' => 'compact-series']))
            ->assertOk()
            ->assertSee('Compact Series 501-507 Attachments');
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
