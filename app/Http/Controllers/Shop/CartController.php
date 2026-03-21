<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(Request $request): View
    {
        $cart = $this->cartFor($request);
        $items = $cart->items()->with('product')->get();

        $subtotal = $items->sum(fn (CartItem $item) => (float) $item->product->price * (int) $item->quantity);

        return view('shop.cart', [
            'cart' => $cart,
            'items' => $items,
            'subtotal' => $subtotal,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $product = Product::query()->where('is_active', true)->findOrFail($validated['product_id']);
        $quantity = (int) ($validated['quantity'] ?? 1);

        $cart = $this->cartFor($request);

        DB::transaction(function () use ($cart, $product, $quantity): void {
            $item = $cart->items()->where('product_id', $product->id)->first();

            if ($item) {
                $item->update([
                    'quantity' => (int) $item->quantity + $quantity,
                ]);

                return;
            }

            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
        });

        return redirect()
            ->route('cart.index')
            ->with('status', __('Producto agregado al carrito.'));
    }

    public function update(Request $request, CartItem $item): RedirectResponse
    {
        $cart = $this->cartFor($request);

        abort_unless($item->cart_id === $cart->id, 404);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $item->update([
            'quantity' => (int) $validated['quantity'],
        ]);

        return back()->with('status', __('Carrito actualizado.'));
    }

    public function destroy(Request $request, CartItem $item): RedirectResponse
    {
        $cart = $this->cartFor($request);
        abort_unless($item->cart_id === $cart->id, 404);

        $item->delete();

        return back()->with('status', __('Producto eliminado del carrito.'));
    }

    private function cartFor(Request $request): Cart
    {
        $user = $request->user();
        abort_if(!$user, 401);

        return Cart::firstOrCreate([
            'user_id' => $user->id,
        ]);
    }
}
