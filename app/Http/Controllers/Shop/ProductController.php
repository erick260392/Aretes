<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function show(Product $product): View
    {
        abort_unless((bool) $product->is_active, 404);

        $product->load([
            'category',
            'images' => fn ($query) => $query->orderByDesc('is_main')->orderBy('order'),
        ]);

        $relatedProducts = Product::query()
            ->where('is_active', true)
            ->whereKeyNot($product->getKey())
            ->when($product->category_id, fn ($query) => $query->where('category_id', $product->category_id))
            ->with(['category', 'images' => fn ($query) => $query->orderByDesc('is_main')->orderBy('order')])
            ->latest()
            ->take(3)
            ->get();

        return view('shop.product', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }
}
