<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class OperationsController extends Controller
{
    public function inventory(): View
    {
        $products = Product::query()
            ->with('category')
            ->latest()
            ->paginate(15);

        return view('admin.management.inventory', [
            'products' => $products,
            'totalProducts' => Product::count(),
            'activeProducts' => Product::where('is_active', true)->count(),
            'outOfStockProducts' => Product::where('stock', false)->count(),
            'categoriesCount' => Category::count(),
        ]);
    }

    public function payments(): View
    {
        $payments = Payment::query()
            ->with(['order.user'])
            ->latest()
            ->paginate(15);

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
        ]);
    }

    public function shipping(): View
    {
        $orders = Order::query()
            ->with(['user', 'address'])
            ->latest()
            ->paginate(15);

        return view('admin.management.shipping', [
            'orders' => $orders,
            'pendingOrdersCount' => Order::where('status', 'pending')->count(),
            'readyToShipCount' => Order::whereIn('status', ['paid', 'completed'])->count(),
            'deliveredCount' => Order::where('status', 'delivered')->count(),
            'cancelledCount' => Order::whereIn('status', ['cancelled', 'canceled'])->count(),
        ]);
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
