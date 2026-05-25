<?php

namespace App\Support;

use Illuminate\Contracts\Session\Session;

class ShoppingCart
{
    private const SESSION_KEY = 'cart.items';

    public function __construct(private ProductCatalog $catalog)
    {
    }

    public function add(Session $session, string $slug): bool
    {
        if (! $this->catalog->find($slug)) {
            return false;
        }

        $cart = $session->get(self::SESSION_KEY, []);
        $cart[$slug] = min(($cart[$slug] ?? 0) + 1, 99);
        $session->put(self::SESSION_KEY, $cart);

        return true;
    }

    public function update(Session $session, string $slug, int $quantity): bool
    {
        $cart = $session->get(self::SESSION_KEY, []);

        if (! isset($cart[$slug]) || ! $this->catalog->find($slug)) {
            return false;
        }

        $cart[$slug] = max(1, min($quantity, 99));
        $session->put(self::SESSION_KEY, $cart);

        return true;
    }

    public function remove(Session $session, string $slug): void
    {
        $cart = $session->get(self::SESSION_KEY, []);
        unset($cart[$slug]);
        $session->put(self::SESSION_KEY, $cart);
    }

    public function clear(Session $session): void
    {
        $session->forget(self::SESSION_KEY);
    }

    public function summary(Session $session): array
    {
        $cart = $session->get(self::SESSION_KEY, []);
        $items = [];

        foreach ($cart as $slug => $quantity) {
            $product = $this->catalog->find((string) $slug);

            if (! $product) {
                continue;
            }

            $quantity = max(1, min((int) $quantity, 99));
            $price = (float) ($product['price'] ?? 0);
            $items[] = [
                'slug' => $product['slug'],
                'name' => $product['name'],
                'category' => $product['category'] ?? 'Equipment',
                'image' => $product['image'] ?? null,
                'price' => $price,
                'quantity' => $quantity,
                'line_total' => $price * $quantity,
            ];
        }

        return [
            'items' => $items,
            'count' => array_sum(array_column($items, 'quantity')),
            'subtotal' => array_sum(array_column($items, 'line_total')),
        ];
    }
}
