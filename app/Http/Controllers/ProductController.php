<?php

namespace App\Http\Controllers;

use App\Support\ProductCatalog;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(ProductCatalog $catalog, string $slug): View
    {
        $product = $catalog->find($slug);
        abort_unless($product, 404);

        $relatedProducts = $catalog->all()
            ->where('category', $product['category'])
            ->where('slug', '!=', $slug)
            ->take(3);

        return view('product', compact('product', 'relatedProducts'));
    }
}
