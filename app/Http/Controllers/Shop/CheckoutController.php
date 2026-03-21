<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(Request $request): View
    {
        $user = $request->user();
        abort_if(!$user, 401);

        $cart = Cart::firstOrCreate(['user_id' => $user->id]);
        $items = $cart->items()->with('product')->get();

        $subtotal = $items->sum(fn (CartItem $item) => (float) $item->product->price * (int) $item->quantity);

        $defaultAddress = Address::query()
            ->where('user_id', $user->id)
            ->orderByDesc('is_default')
            ->latest()
            ->first();

        return view('shop.checkout', [
            'items' => $items,
            'subtotal' => $subtotal,
            'defaultAddress' => $defaultAddress,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_if(!$user, 401);

        $validated = $request->validate([
            'street' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:50'],
            'country' => ['required', 'string', 'max:255'],
            'payment_method' => ['required', 'in:cash,transfer,card'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $order = DB::transaction(function () use ($user, $validated): Order {
            $cart = Cart::firstOrCreate(['user_id' => $user->id]);
            $items = $cart->items()->with('product')->lockForUpdate()->get();

            abort_if($items->isEmpty(), 422, __('Tu carrito está vacío.'));

            $address = Address::create([
                'user_id' => $user->id,
                'street' => $validated['street'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'postal_code' => $validated['postal_code'],
                'country' => $validated['country'],
                'is_default' => false,
            ]);

            $total = $items->sum(fn (CartItem $item) => (float) $item->product->price * (int) $item->quantity);

            $order = Order::create([
                'user_id' => $user->id,
                'address_id' => $address->id,
                'status' => 'pending',
                'total' => $total,
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => (int) $item->quantity,
                    'unit_price' => (float) $item->product->price,
                ]);
            }

            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $validated['payment_method'],
                'amount' => $total,
                'status' => 'pending',
                'transaction_id' => null,
                'paid_at' => null,
            ]);

            $cart->items()->delete();

            return $order;
        });

        return redirect()->route('orders.success', $order);
    }

    public function success(Request $request, Order $order): View
    {
        $user = $request->user();
        abort_if(!$user, 401);
        abort_unless($order->user_id === $user->id || $user->isAdmin(), 403);

        $order->load(['items.product', 'address', 'payment']);

        return view('shop.order-success', [
            'order' => $order,
        ]);
    }
}
