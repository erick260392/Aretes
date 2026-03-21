<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $now = now();
        $today = Carbon::today();
        $monthStart = $now->copy()->startOfMonth();
        $monthEnd = $now->copy()->endOfMonth();
        $sevenDaysAgo = $now->copy()->subDays(6)->startOfDay();

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

        $ordersByDate = Order::query()
            ->selectRaw('DATE(created_at) as order_date, COUNT(*) as orders_count, SUM(total) as revenue_total')
            ->where('created_at', '>=', $sevenDaysAgo)
            ->groupBy('order_date')
            ->orderBy('order_date')
            ->get()
            ->keyBy('order_date');

        $chartLabels = collect(range(6, 0))
            ->map(fn (int $days) => $now->copy()->subDays($days))
            ->values();

        $ordersChartLabels = $chartLabels
            ->map(fn (CarbonInterface $date) => $date->format('d/m'))
            ->all();

        $ordersChartData = $chartLabels
            ->map(function (CarbonInterface $date) use ($ordersByDate) {
                $record = $ordersByDate->get($date->toDateString());

                return (int) ($record->orders_count ?? 0);
            })
            ->all();

        $revenueChartData = $chartLabels
            ->map(function (CarbonInterface $date) use ($ordersByDate) {
                $record = $ordersByDate->get($date->toDateString());

                return (float) ($record->revenue_total ?? 0);
            })
            ->all();

        $ordersByStatus = Order::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        $statusChartLabels = $ordersByStatus
            ->map(fn (Order $order) => Str::headline((string) $order->status))
            ->all();

        $statusChartData = $ordersByStatus
            ->map(fn (Order $order) => (int) $order->total)
            ->all();

        return view('admin.dashboard', [
            'pendingOrdersCount' => $pendingOrdersCount,
            'ordersTodayCount' => $ordersTodayCount,
            'revenueThisMonth' => $revenueThisMonth,
            'activeProductsCount' => $activeProductsCount,
            'outOfStockCount' => $outOfStockCount,
            'customersCount' => $customersCount,
            'recentOrders' => $recentOrders,
            'outOfStockProducts' => $outOfStockProducts,
            'ordersChartLabels' => $ordersChartLabels,
            'ordersChartData' => $ordersChartData,
            'revenueChartData' => $revenueChartData,
            'statusChartLabels' => $statusChartLabels,
            'statusChartData' => $statusChartData,
        ]);
    }
}
