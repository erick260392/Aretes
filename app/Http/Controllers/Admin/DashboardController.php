<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $today = Carbon::today();
        $monthStart = now()->startOfMonth();
        $monthEnd = now()->endOfMonth();

        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $ordersTodayCount = Order::whereDate('created_at', $today)->count();
        $revenueThisMonth = (float) Order::whereBetween('created_at', [$monthStart, $monthEnd])->sum('total');

        $activeProductsCount = Product::where('is_active', true)->count();
        $outOfStockCount = Product::where('stock', false)->count();
        $customersCount = User::where('role', 'customer')->count();

        $recentOrders = Order::query()
            ->with('user')
            ->latest()
            ->take(8)
            ->get();

        $outOfStockProducts = Product::query()
            ->where('is_active', true)
            ->where('stock', false)
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', [
            'pendingOrdersCount' => $pendingOrdersCount,
            'ordersTodayCount' => $ordersTodayCount,
            'revenueThisMonth' => $revenueThisMonth,
            'activeProductsCount' => $activeProductsCount,
            'outOfStockCount' => $outOfStockCount,
            'customersCount' => $customersCount,
            'recentOrders' => $recentOrders,
            'outOfStockProducts' => $outOfStockProducts,
        ]);
    }
}
