<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->where('is_active', true)
            ->with(['category', 'images' => fn ($query) => $query->orderByDesc('is_main')->orderBy('order')])
            ->latest()
            ->paginate(12);

        $categories = Category::query()
            ->withCount([
                'products' => fn ($query) => $query->where('is_active', true),
            ])
            ->orderBy('name')
            ->take(4)
            ->get();

        return view('shop.index', [
            'products' => $products,
            'categories' => $categories,
            'shopStats' => [
                'products' => Product::query()->where('is_active', true)->count(),
                'categories' => Category::query()->count(),
                'available' => Product::query()->where('is_active', true)->where('stock', true)->count(),
            ],
        ]);
    }
}
