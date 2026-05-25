<?php

namespace App\Http\Controllers;

use App\Support\ShoppingCart;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function show(Request $request, ShoppingCart $cart): View|RedirectResponse
    {
        $summary = $cart->summary($request->session());

        if ($summary['items'] === []) {
            return to_route('cart')->with('error', 'Add equipment to your cart before checkout.');
        }

        return view('checkout', array_merge($summary, [
            'email' => (string) $request->query('email', ''),
            'paymentPreference' => (string) $request->query('payment', ''),
        ]));
    }

    public function store(Request $request, ShoppingCart $cart): View|RedirectResponse
    {
        $summary = $cart->summary($request->session());

        if ($summary['items'] === []) {
            return to_route('cart')->with('error', 'Your cart is empty.');
        }

        $customer = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:40'],
            'company' => ['nullable', 'string', 'max:120'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $order = array_merge($summary, [
            'number' => 'SKP-'.strtoupper(Str::random(8)),
            'placed_at' => now()->format('F j, Y g:i A'),
            'customer' => $customer,
        ]);

        $request->session()->push('orders', $order);
        $cart->clear($request->session());

        return view('order-confirmation', ['order' => $order]);
    }
}
