<?php

namespace Tests\Feature;

use App\Support\ProductCatalog;
use Tests\TestCase;

class EquipmentNavigationTest extends TestCase
{
    public function test_catalog_removes_products_with_duplicate_names_or_store_ids(): void
    {
        $products = app(ProductCatalog::class)->all();

        $this->assertCount($products->count(), $products->unique(fn (array $product) => mb_strtolower($product['name'])));
        $this->assertCount($products->count(), $products->unique('hash'));
    }

    public function test_shop_dropdown_lists_machine_families_without_repeating_attachment_categories(): void
    {
        $shopCategories = [
            'Forklift' => 'Forklifts',
            'Mini Excavators' => 'Mini Excavators',
            'Skid Steer Loader' => 'Skid Steer Loaders',
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
}
