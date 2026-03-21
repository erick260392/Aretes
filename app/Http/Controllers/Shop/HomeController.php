<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $products = Product::query()
            ->where('is_active', true)
            ->latest()
            ->paginate(12);

        return view('shop.index', [
            'products' => $products,
        ]);
    }
}
