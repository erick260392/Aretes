<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminEmail = 'admin@aretes.test';

        $admin = User::query()->firstOrCreate(
            ['email' => $adminEmail],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        );

        if (User::query()->where('role', 'customer')->count() < 15) {
            User::factory()
                ->customer()
                ->count(20)
                ->create();
        }

        $targetCategories = 7;
        $categoryCount = Category::query()->count();

        if ($categoryCount < $targetCategories) {
            Category::factory()->count($targetCategories - $categoryCount)->create();
        }

        $targetProducts = 45;
        $productCount = Product::query()->count();

        if ($productCount < $targetProducts) {
            Product::factory()->count($targetProducts - $productCount)->create();
        }

        $customers = User::query()->where('role', 'customer')->get();
        $products = Product::query()->where('is_active', true)->get();

        if ($customers->isEmpty() || $products->isEmpty()) {
            return;
        }

        foreach ($customers as $customer) {
            if ($customer->addresses()->count() === 0) {
                $customer->addresses()->create([
                    'street' => fake()->streetAddress(),
                    'city' => fake()->city(),
                    'state' => fake()->state(),
                    'postal_code' => fake()->postcode(),
                    'country' => 'México',
                    'is_default' => true,
                ]);

                if (fake()->boolean(35)) {
                    $customer->addresses()->create([
                        'street' => fake()->streetAddress(),
                        'city' => fake()->city(),
                        'state' => fake()->state(),
                        'postal_code' => fake()->postcode(),
                        'country' => 'México',
                        'is_default' => false,
                    ]);
                }
            }
        }

        foreach ($customers->take(12) as $customer) {
            $cart = Cart::firstOrCreate(['user_id' => $customer->id]);

            if ($cart->items()->count() === 0) {
                $pickCount = min($products->count(), fake()->numberBetween(1, 4));
                $pick = $products->random($pickCount);
                $pick = $pick instanceof \Illuminate\Support\Collection ? $pick : collect([$pick]);

                foreach ($pick as $product) {
                    $cart->items()->create([
                        'product_id' => $product->id,
                        'quantity' => fake()->numberBetween(1, 3),
                    ]);
                }
            }
        }

        if (Order::query()->count() < 10) {
            DB::transaction(function () use ($customers, $products, $admin): void {
                $ordersToCreate = 28;

                for ($i = 0; $i < $ordersToCreate; $i++) {
                    $customer = $customers->random();
                    $address = Address::query()
                        ->where('user_id', $customer->id)
                        ->inRandomOrder()
                        ->first();

                    if (!$address) {
                        $address = Address::create([
                            'user_id' => $customer->id,
                            'street' => fake()->streetAddress(),
                            'city' => fake()->city(),
                            'state' => fake()->state(),
                            'postal_code' => fake()->postcode(),
                            'country' => 'México',
                            'is_default' => false,
                        ]);
                    }

                    $status = fake()->randomElement(['pending', 'pending', 'paid', 'completed', 'cancelled']);
                    $itemsCount = fake()->numberBetween(1, 4);

                    $pickCount = min($products->count(), $itemsCount);
                    $pickedProducts = $products->random($pickCount);
                    $pickedProducts = $pickedProducts instanceof \Illuminate\Support\Collection ? $pickedProducts : collect([$pickedProducts]);

                    $order = Order::create([
                        'user_id' => $customer->id,
                        'address_id' => $address->id,
                        'status' => $status,
                        'total' => 0,
                        'notes' => fake()->optional(0.2)->sentence(8),
                    ]);

                    $total = 0;

                    foreach ($pickedProducts as $product) {
                        $quantity = fake()->numberBetween(1, 3);
                        $unitPrice = (float) $product->price;

                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $product->id,
                            'quantity' => $quantity,
                            'unit_price' => $unitPrice,
                        ]);

                        $total += $unitPrice * $quantity;
                    }

                    $order->update(['total' => $total]);

                    Payment::create([
                        'order_id' => $order->id,
                        'payment_method' => fake()->randomElement(['cash', 'transfer', 'card']),
                        'amount' => $total,
                        'status' => in_array($status, ['paid', 'completed'], true) ? 'paid' : 'pending',
                        'transaction_id' => null,
                        'paid_at' => in_array($status, ['paid', 'completed'], true) ? now()->subDays(fake()->numberBetween(0, 10)) : null,
                    ]);
                }

                $admin->touch();
            });
        }
    }
}
