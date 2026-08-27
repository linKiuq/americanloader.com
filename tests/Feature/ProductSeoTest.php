<?php

namespace Tests\Feature;

use App\Support\ProductCatalog;
use Tests\TestCase;

class ProductSeoTest extends TestCase
{
    public function test_product_detail_page_renders_rich_snippet_schema_and_breadcrumbs(): void
    {
        $product = app(ProductCatalog::class)->all()->first();
        $this->assertNotNull($product, 'At least one product must exist in catalog.');

        $response = $this->get(route('product.show', $product['slug']));

        $response->assertOk()
            ->assertSee('for Sale in USA | American Loader', escape: false)
            ->assertSee('aria-label="Breadcrumb"', escape: false)
            ->assertSee('@type":"Product"', escape: false)
            ->assertSee('@type":"Offer"', escape: false)
            ->assertSee('@type":"AggregateRating"', escape: false)
            ->assertSee('hasMerchantReturnPolicy', escape: false)
            ->assertSee('shippingDetails', escape: false)
            ->assertSee('product:availability', escape: false);
    }
}
