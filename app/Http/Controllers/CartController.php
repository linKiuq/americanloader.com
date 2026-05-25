<?php

namespace App\Http\Controllers;

use App\Support\ProductCatalog;
use App\Support\ShoppingCart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request, ShoppingCart $cart, ProductCatalog $catalog): View
    {
        $summary = $cart->summary($request->session());
        $cartSlugs = array_column($summary['items'], 'slug');
        $recommendations = $catalog->all()
            ->reject(fn (array $product): bool => in_array($product['slug'], $cartSlugs, true))
            ->whereIn('category', ['Mini Excavator Attachments', 'Skid Steer Attachments'])
            ->take(3);

        return view('cart', array_merge($summary, compact('recommendations')));
    }

    public function store(Request $request, ShoppingCart $cart): RedirectResponse
    {
        $validated = $request->validate([
            'slug' => ['required', 'string'],
        ]);

        abort_unless($cart->add($request->session(), $validated['slug']), 404);

        return back()->with('success', 'Equipment added to your cart.');
    }

    public function update(Request $request, ShoppingCart $cart): RedirectResponse
    {
        $validated = $request->validate([
            'slug' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        abort_unless($cart->update($request->session(), $validated['slug'], $validated['quantity']), 404);

        return back();
    }

    public function destroy(Request $request, ShoppingCart $cart): RedirectResponse
    {
        $validated = $request->validate([
            'slug' => ['required', 'string'],
        ]);

        $cart->remove($request->session(), $validated['slug']);

        return back()->with('success', 'Item removed from your cart.');
    }

    public function clear(Request $request, ShoppingCart $cart): RedirectResponse
    {
        $cart->clear($request->session());

        return back()->with('success', 'Your cart has been cleared.');
    }
}
