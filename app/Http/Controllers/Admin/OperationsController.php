<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class OperationsController extends Controller
{
    public function inventory(Request $request): View
    {
        $query = Product::query()->with('category');

        if ($search = trim((string) $request->string('q'))) {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('material', 'like', "%{$search}%")
                    ->orWhere('color', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', (int) $request->input('category_id'));
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', (bool) $request->input('is_active'));
        }

        if ($request->filled('stock')) {
            $query->where('stock', (bool) $request->input('stock'));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        $products = $query->latest()->paginate(50)->withQueryString();

        return view('admin.management.inventory', [
            'products' => $products,
            'totalProducts' => Product::count(),
            'activeProducts' => Product::where('is_active', true)->count(),
            'outOfStockProducts' => Product::where('stock', false)->count(),
            'categoriesCount' => Category::count(),
            'categories' => Category::query()->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function exportInventory(Request $request): StreamedResponse
    {
        $query = Product::query()->with('category');

        if ($search = trim((string) $request->string('q'))) {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('material', 'like', "%{$search}%")
                    ->orWhere('color', 'like', "%{$search}%")
                    ->orWhere('id', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', (int) $request->input('category_id'));
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', (bool) $request->input('is_active'));
        }

        if ($request->filled('stock')) {
            $query->where('stock', (bool) $request->input('stock'));
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        return response()->streamDownload(function () use ($query): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Producto', 'Categoria', 'Activo', 'Stock', 'Material', 'Color', 'Precio']);

            $query->orderByDesc('id')->chunk(1000, function ($products) use ($handle): void {
                foreach ($products as $product) {
                    fputcsv($handle, [
                        $product->id,
                        $product->name,
                        $product->category?->name,
                        $product->is_active ? 'Si' : 'No',
                        $product->stock ? 'Disponible' : 'Agotado',
                        $product->material,
                        $product->color,
                        number_format((float) $product->price, 2, '.', ''),
                    ]);
                }
            });

            fclose($handle);
        }, 'reporte_inventario.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function payments(Request $request): View
    {
        $query = Payment::query()->with(['order.user']);

        if ($search = trim((string) $request->string('q'))) {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('id', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%")
                    ->orWhere('order_id', 'like', "%{$search}%")
                    ->orWhereHas('order.user', function ($userQuery) use ($search) {
                        $userQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($method = $request->string('payment_method')->toString()) {
            $query->where('payment_method', $method);
        }

        if ($dateFrom = $request->string('date_from')->toString()) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->string('date_to')->toString()) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', (float) $request->input('min_amount'));
        }

        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', (float) $request->input('max_amount'));
        }

        $payments = $query->latest()->paginate(50)->withQueryString();

        $methodBreakdown = Payment::query()
            ->selectRaw('payment_method, COUNT(*) as total, SUM(amount) as amount_total')
            ->groupBy('payment_method')
            ->orderByDesc('total')
            ->get();

        return view('admin.management.payments', [
            'payments' => $payments,
            'pendingPaymentsCount' => Payment::where('status', 'pending')->count(),
            'paidPaymentsCount' => Payment::where('status', 'paid')->count(),
            'totalPaidAmount' => (float) Payment::where('status', 'paid')->sum('amount'),
            'methodBreakdown' => $methodBreakdown,
            'statuses' => Payment::query()->select('status')->distinct()->pluck('status'),
            'methods' => Payment::query()->select('payment_method')->distinct()->pluck('payment_method'),
        ]);
    }

    public function exportPayments(Request $request): StreamedResponse
    {
        $query = Payment::query()->with(['order.user']);

        if ($search = trim((string) $request->string('q'))) {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('id', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%")
                    ->orWhere('order_id', 'like', "%{$search}%")
                    ->orWhereHas('order.user', function ($userQuery) use ($search) {
                        $userQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($method = $request->string('payment_method')->toString()) {
            $query->where('payment_method', $method);
        }

        if ($dateFrom = $request->string('date_from')->toString()) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->string('date_to')->toString()) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', (float) $request->input('min_amount'));
        }

        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', (float) $request->input('max_amount'));
        }

        return response()->streamDownload(function () use ($query): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Pago', 'Pedido', 'Cliente', 'Metodo', 'Estado', 'Monto', 'Transaccion', 'Fecha']);

            $query->orderByDesc('id')->chunk(1000, function ($payments) use ($handle): void {
                foreach ($payments as $payment) {
                    fputcsv($handle, [
                        $payment->id,
                        $payment->order_id,
                        $payment->order?->user?->name,
                        $payment->payment_method,
                        $payment->status,
                        number_format((float) $payment->amount, 2, '.', ''),
                        $payment->transaction_id,
                        $payment->created_at?->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, 'reporte_pagos.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function shipping(Request $request): View
    {
        $query = Order::query()->with(['user', 'address']);

        if ($search = trim((string) $request->string('q'))) {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('address', function ($addressQuery) use ($search) {
                        $addressQuery
                            ->where('street', 'like', "%{$search}%")
                            ->orWhere('city', 'like', "%{$search}%")
                            ->orWhere('state', 'like', "%{$search}%");
                    });
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($dateFrom = $request->string('date_from')->toString()) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->string('date_to')->toString()) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $orders = $query->latest()->paginate(50)->withQueryString();

        return view('admin.management.shipping', [
            'orders' => $orders,
            'pendingOrdersCount' => Order::where('status', 'pending')->count(),
            'readyToShipCount' => Order::whereIn('status', ['paid', 'completed'])->count(),
            'deliveredCount' => Order::where('status', 'delivered')->count(),
            'cancelledCount' => Order::whereIn('status', ['cancelled', 'canceled'])->count(),
            'statuses' => Order::query()->select('status')->distinct()->pluck('status'),
        ]);
    }

    public function exportShipping(Request $request): StreamedResponse
    {
        $query = Order::query()->with(['user', 'address']);

        if ($search = trim((string) $request->string('q'))) {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('id', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('address', function ($addressQuery) use ($search) {
                        $addressQuery
                            ->where('street', 'like', "%{$search}%")
                            ->orWhere('city', 'like', "%{$search}%")
                            ->orWhere('state', 'like', "%{$search}%");
                    });
            });
        }

        if ($status = $request->string('status')->toString()) {
            $query->where('status', $status);
        }

        if ($dateFrom = $request->string('date_from')->toString()) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo = $request->string('date_to')->toString()) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        return response()->streamDownload(function () use ($query): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Pedido', 'Cliente', 'Ciudad', 'Estado', 'Direccion', 'Estatus', 'Total', 'Fecha']);

            $query->orderByDesc('id')->chunk(1000, function ($orders) use ($handle): void {
                foreach ($orders as $order) {
                    fputcsv($handle, [
                        $order->id,
                        $order->user?->name,
                        $order->address?->city,
                        $order->address?->state,
                        $order->address?->street,
                        $order->status,
                        number_format((float) $order->total, 2, '.', ''),
                        $order->created_at?->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, 'reporte_envios.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function store(): View
    {
        $recentCustomers = User::query()
            ->where('role', 'customer')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.management.store', [
            'categoriesCount' => Category::count(),
            'productsCount' => Product::count(),
            'customersCount' => User::where('role', 'customer')->count(),
            'ordersCount' => Order::count(),
            'revenueTotal' => (float) Order::sum('total'),
            'recentCustomers' => $recentCustomers,
        ]);
    }
}
