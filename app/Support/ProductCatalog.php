<?php

namespace App\Support;

use Illuminate\Support\Collection;

class ProductCatalog
{
    private ?Collection $products = null;

    public function all(): Collection
    {
        if ($this->products !== null) {
            return $this->products;
        }

        $products = json_decode(file_get_contents(public_path('equipment-products.json')), true, flags: JSON_THROW_ON_ERROR);
        $seenSkus = [];
        $seenStoreIds = [];

        return $this->products = collect($products)
            ->reject(function (array $product) use (&$seenSkus, &$seenStoreIds): bool {
                $sku = mb_strtolower(trim((string) ($product['sku'] ?? '')));
                $storeId = (string) ($product['hash'] ?? $product['checkoutUrl'] ?? '');
                $isDuplicate = ($sku !== '' && isset($seenSkus[$sku]))
                    || ($storeId !== '' && isset($seenStoreIds[$storeId]));

                if ($sku !== '') {
                    $seenSkus[$sku] = true;
                }

                if ($storeId !== '') {
                    $seenStoreIds[$storeId] = true;
                }

                return $isDuplicate;
            })
            ->values();
    }

    public function find(string $slug): ?array
    {
        return $this->all()->firstWhere('slug', $slug);
    }
}
