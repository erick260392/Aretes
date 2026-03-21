<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    private const TARGET_PRODUCTS = 100;
    private const TARGET_CUSTOMERS = 1000;
    private const TARGET_ORDERS = 10000;
    private const TARGET_PAYMENTS = 100000;

    public function run(): void
    {
        DB::disableQueryLog();

        User::query()->updateOrCreate(
            ['email' => 'admin@aretes.test'],
            [
                'name' => 'Admin Aretes Mich',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        );

        $this->clearDemoData();

        $categoryIds = $this->seedCategories();
        $this->seedProducts($categoryIds);

        $customerIds = $this->seedCustomers();
        $this->seedAddresses($customerIds);

        $this->seedOrdersAndPayments($customerIds);
    }

    private function clearDemoData(): void
    {
        DB::table('payments')->delete();
        DB::table('order_items')->delete();
        DB::table('orders')->delete();
        DB::table('cart_items')->delete();
        DB::table('carts')->delete();
        DB::table('addresses')->delete();
        DB::table('users')->where('role', 'customer')->delete();
        DB::table('products')->delete();
        DB::table('categories')->delete();
    }

    private function seedCategories(): array
    {
        $categories = [
            ['name' => 'Aretes', 'slug' => 'aretes', 'description' => 'Aretes para diario, eventos y regalo.'],
            ['name' => 'Collares', 'slug' => 'collares', 'description' => 'Collares en tendencia para distintos estilos.'],
            ['name' => 'Pulseras', 'slug' => 'pulseras', 'description' => 'Pulseras elegantes y casuales.'],
            ['name' => 'Anillos', 'slug' => 'anillos', 'description' => 'Anillos ajustables y de talla fija.'],
            ['name' => 'Sets', 'slug' => 'sets', 'description' => 'Conjuntos completos para regalo.'],
            ['name' => 'Temporada', 'slug' => 'temporada', 'description' => 'Lanzamientos por temporada.'],
            ['name' => 'Bodas', 'slug' => 'bodas', 'description' => 'Piezas para novia, damas y eventos formales.'],
            ['name' => 'Minimalista', 'slug' => 'minimalista', 'description' => 'Diseños limpios y versátiles.'],
        ];

        $now = now();
        $rows = [];

        foreach ($categories as $category) {
            $rows[] = [
                'name' => $category['name'],
                'slug' => $category['slug'],
                'description' => $category['description'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('categories')->insert($rows);

        return DB::table('categories')
            ->orderBy('id')
            ->pluck('id')
            ->all();
    }

    private function seedProducts(array $categoryIds): void
    {
        $productTypes = [
            'Arete', 'Collar', 'Pulsera', 'Anillo', 'Set',
            'Choker', 'Broquel', 'Argolla', 'Dije', 'Cadena',
        ];
        $styles = [
            'Perla Clásica', 'Luna Fina', 'Corazón Brillante', 'Flor Michoacán', 'Eslabón Deluxe',
            'Nudo Elegante', 'Marina Turquesa', 'Oro Rosa', 'Plata Premium', 'Ámbar Sunset',
            'Minimal Slim', 'Boho Chic', 'Vintage Luz', 'Nocturna Shine', 'Aurora',
        ];
        $materials = ['Plata .925', 'Acero inoxidable', 'Chapa de oro', 'Acero y cristal', 'Perla natural'];
        $colors = ['Dorado', 'Plateado', 'Rose Gold', 'Perla', 'Ámbar', 'Turquesa', 'Negro'];

        $rows = [];
        $now = now();

        for ($i = 1; $i <= self::TARGET_PRODUCTS; $i++) {
            $type = $productTypes[($i - 1) % count($productTypes)];
            $style = $styles[($i - 1) % count($styles)];
            $name = "{$type} {$style} #".str_pad((string) $i, 3, '0', STR_PAD_LEFT);
            $slug = Str::slug($name);
            $price = 149 + (($i * 17) % 650);

            $rows[] = [
                'category_id' => $categoryIds[($i - 1) % count($categoryIds)],
                'name' => $name,
                'slug' => $slug,
                'description' => "Pieza {$type} {$style} con acabado premium para uso diario o regalo.",
                'price' => $price,
                'stock' => $i % 9 !== 0,
                'material' => $materials[($i - 1) % count($materials)],
                'color' => $colors[($i - 1) % count($colors)],
                'is_active' => $i % 13 !== 0,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('products')->insert($rows);
    }

    private function seedCustomers(): array
    {
        $firstNames = ['María', 'Ana', 'Sofía', 'Valeria', 'Daniela', 'Carla', 'Fernanda', 'Paola', 'Gabriela', 'Montserrat', 'Andrea', 'Ximena', 'Camila', 'Renata', 'Lucía', 'Ariana', 'Regina', 'Natalia', 'Elena', 'Jimena'];
        $lastNames = ['López', 'Martínez', 'Hernández', 'Ramírez', 'Jiménez', 'Castro', 'Ruiz', 'Navarro', 'Torres', 'Vega', 'Flores', 'Salazar', 'Mendoza', 'Rojas', 'Aguilar', 'Chávez', 'Delgado', 'Morales', 'Ibarra', 'Ortega'];

        $password = Hash::make('password');
        $now = now();
        $rows = [];

        for ($i = 1; $i <= self::TARGET_CUSTOMERS; $i++) {
            $name = $firstNames[($i - 1) % count($firstNames)].' '.$lastNames[($i - 1) % count($lastNames)].' '.$lastNames[$i % count($lastNames)];

            $rows[] = [
                'name' => $name,
                'email' => 'cliente'.str_pad((string) $i, 4, '0', STR_PAD_LEFT).'@demoaretes.mx',
                'email_verified_at' => $now,
                'role' => 'customer',
                'password' => $password,
                'remember_token' => Str::random(10),
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('users')->insert($chunk);
        }

        return User::query()
            ->where('role', 'customer')
            ->orderBy('id')
            ->pluck('id')
            ->all();
    }

    private function seedAddresses(array $customerIds): void
    {
        $cities = [
            ['city' => 'Morelia', 'state' => 'Michoacán', 'postal' => '58000'],
            ['city' => 'Uruapan', 'state' => 'Michoacán', 'postal' => '60000'],
            ['city' => 'Zamora', 'state' => 'Michoacán', 'postal' => '59600'],
            ['city' => 'Guadalajara', 'state' => 'Jalisco', 'postal' => '44100'],
            ['city' => 'León', 'state' => 'Guanajuato', 'postal' => '37000'],
            ['city' => 'Querétaro', 'state' => 'Querétaro', 'postal' => '76000'],
            ['city' => 'Puebla', 'state' => 'Puebla', 'postal' => '72000'],
            ['city' => 'Ciudad de México', 'state' => 'CDMX', 'postal' => '03000'],
            ['city' => 'Monterrey', 'state' => 'Nuevo León', 'postal' => '64000'],
            ['city' => 'Toluca', 'state' => 'Estado de México', 'postal' => '50000'],
        ];

        $now = now();
        $rows = [];

        foreach ($customerIds as $idx => $userId) {
            $city = $cities[$idx % count($cities)];

            $rows[] = [
                'user_id' => $userId,
                'street' => 'Calle '.($idx + 1).' #'.(100 + ($idx % 700)),
                'city' => $city['city'],
                'state' => $city['state'],
                'postal_code' => $city['postal'],
                'country' => 'México',
                'is_default' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('addresses')->insert($chunk);
        }
    }

    private function seedOrdersAndPayments(array $customerIds): void
    {
        $addresses = Address::query()
            ->whereIn('user_id', $customerIds)
            ->pluck('id', 'user_id');

        $products = Product::query()
            ->orderBy('id')
            ->get(['id', 'price'])
            ->values();

        $productCount = $products->count();
        $orderStatuses = ['pending', 'paid', 'completed', 'delivered', 'cancelled'];
        $paymentMethods = ['card', 'transfer', 'cash'];
        $now = Carbon::now();
        $startOrderId = ((int) Order::max('id')) + 1;

        $ordersBatch = [];
        $orderItemsBatch = [];
        $paymentsBatch = [];

        for ($i = 0; $i < self::TARGET_ORDERS; $i++) {
            $orderId = $startOrderId + $i;
            $userId = $customerIds[$i % count($customerIds)];
            $addressId = $addresses[$userId] ?? null;

            if (!$addressId || $productCount < 2) {
                continue;
            }

            $productA = $products[($i * 7) % $productCount];
            $productB = $products[($i * 13 + 5) % $productCount];

            $quantityA = 1 + ($i % 2);
            $quantityB = 1 + (($i + 1) % 3);

            $lineA = $quantityA * (float) $productA->price;
            $lineB = $quantityB * (float) $productB->price;
            $orderTotal = round($lineA + $lineB, 2);

            $status = $orderStatuses[$i % count($orderStatuses)];
            $createdAt = $now->copy()->subDays($i % 180)->subMinutes($i % 1440);

            $ordersBatch[] = [
                'id' => $orderId,
                'user_id' => $userId,
                'address_id' => $addressId,
                'status' => $status,
                'total' => $orderTotal,
                'notes' => 'DEMO-ORD-'.str_pad((string) ($i + 1), 5, '0', STR_PAD_LEFT),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];

            $orderItemsBatch[] = [
                'order_id' => $orderId,
                'product_id' => $productA->id,
                'quantity' => $quantityA,
                'unit_price' => $productA->price,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
            $orderItemsBatch[] = [
                'order_id' => $orderId,
                'product_id' => $productB->id,
                'quantity' => $quantityB,
                'unit_price' => $productB->price,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];

            $this->appendPaymentsForOrder(
                $paymentsBatch,
                $orderId,
                $orderTotal,
                $status,
                $paymentMethods,
                $createdAt,
            );

            if (count($ordersBatch) >= 500) {
                DB::table('orders')->insert($ordersBatch);
                $ordersBatch = [];
                DB::table('order_items')->insert($orderItemsBatch);
                $orderItemsBatch = [];

                if (count($paymentsBatch) >= 5000) {
                    DB::table('payments')->insert($paymentsBatch);
                    $paymentsBatch = [];
                }
            }
        }

        if (!empty($ordersBatch)) {
            DB::table('orders')->insert($ordersBatch);
            DB::table('order_items')->insert($orderItemsBatch);
        }

        if (!empty($paymentsBatch)) {
            DB::table('payments')->insert($paymentsBatch);
        }

        $currentPayments = DB::table('payments')->count();

        if ($currentPayments < self::TARGET_PAYMENTS) {
            $this->seedRemainingPayments(self::TARGET_PAYMENTS - $currentPayments, $paymentMethods, $now);
        }
    }

    private function appendPaymentsForOrder(
        array &$paymentsBatch,
        int $orderId,
        float $orderTotal,
        string $orderStatus,
        array $paymentMethods,
        Carbon $baseDate
    ): void {
        $installments = intdiv(self::TARGET_PAYMENTS, self::TARGET_ORDERS);
        $partial = round($orderTotal / $installments, 2);
        $accumulated = 0.0;

        for ($installment = 1; $installment <= $installments; $installment++) {
            $status = 'pending';
            if ($installment === $installments) {
                $status = in_array($orderStatus, ['paid', 'completed', 'delivered'], true)
                    ? 'paid'
                    : ($orderStatus === 'cancelled' ? 'failed' : 'pending');
            } elseif ($installment % 3 === 0) {
                $status = 'failed';
            }

            $amount = $installment === $installments
                ? round($orderTotal - $accumulated, 2)
                : $partial;

            $accumulated += $amount;
            $paidAt = $status === 'paid' ? $baseDate->copy()->addMinutes($installment * 7) : null;
            $createdAt = $baseDate->copy()->addMinutes($installment * 5);

            $paymentsBatch[] = [
                'order_id' => $orderId,
                'payment_method' => $paymentMethods[($orderId + $installment) % count($paymentMethods)],
                'amount' => max($amount, 0),
                'status' => $status,
                'transaction_id' => 'TXN-DEMO-'.str_pad((string) $orderId, 6, '0', STR_PAD_LEFT).'-'.str_pad((string) $installment, 2, '0', STR_PAD_LEFT),
                'paid_at' => $paidAt,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }
    }

    private function seedRemainingPayments(int $remaining, array $paymentMethods, Carbon $now): void
    {
        $orderIds = DB::table('orders')->orderBy('id')->pluck('id')->all();
        if (empty($orderIds)) {
            return;
        }

        $rows = [];

        for ($i = 0; $i < $remaining; $i++) {
            $orderId = $orderIds[$i % count($orderIds)];
            $createdAt = $now->copy()->subMinutes($i % 5000);

            $rows[] = [
                'order_id' => $orderId,
                'payment_method' => $paymentMethods[$i % count($paymentMethods)],
                'amount' => 10.00,
                'status' => $i % 2 === 0 ? 'failed' : 'pending',
                'transaction_id' => 'TXN-EXTRA-'.str_pad((string) ($i + 1), 8, '0', STR_PAD_LEFT),
                'paid_at' => null,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];

            if (count($rows) >= 5000) {
                DB::table('payments')->insert($rows);
                $rows = [];
            }
        }

        if (!empty($rows)) {
            DB::table('payments')->insert($rows);
        }
    }
}
