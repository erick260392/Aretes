<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $chartDays = (int) $request->integer('chart_days', 7);
        $chartDays = in_array($chartDays, [7, 30, 90, 180], true) ? $chartDays : 7;
        $chartStatus = trim((string) $request->string('chart_status', 'all'));

        $now = now();
        $today = Carbon::today();
        $monthStart = $now->copy()->startOfMonth();
        $monthEnd = $now->copy()->endOfMonth();
        $chartStart = $now->copy()->subDays($chartDays - 1)->startOfDay();

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

        $ordersByDateQuery = Order::query()
            ->selectRaw('DATE(created_at) as order_date, COUNT(*) as orders_count, SUM(total) as revenue_total')
            ->where('created_at', '>=', $chartStart);

        if ($chartStatus !== 'all' && $chartStatus !== '') {
            $ordersByDateQuery->where('status', $chartStatus);
        }

        $ordersByDate = $ordersByDateQuery
            ->groupBy('order_date')
            ->orderBy('order_date')
            ->get()
            ->keyBy('order_date');

        $chartLabels = collect(range($chartDays - 1, 0))
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
            ->where('created_at', '>=', $chartStart)
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
            'chartDays' => $chartDays,
            'chartStatus' => $chartStatus,
            'availableStatuses' => Order::query()->select('status')->distinct()->pluck('status'),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $chartDays = (int) $request->integer('chart_days', 7);
        $chartDays = in_array($chartDays, [7, 30, 90, 180], true) ? $chartDays : 7;
        $chartStatus = trim((string) $request->string('chart_status', 'all'));
        $now = now();
        $chartStart = $now->copy()->subDays($chartDays - 1)->startOfDay();

        $ordersQuery = Order::query()->where('created_at', '>=', $chartStart);
        if ($chartStatus !== 'all' && $chartStatus !== '') {
            $ordersQuery->where('status', $chartStatus);
        }

        return response()->streamDownload(function () use ($ordersQuery): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Pedido', 'Estado', 'Total', 'Fecha']);

            $ordersQuery->orderByDesc('id')->chunk(1000, function ($orders) use ($handle): void {
                foreach ($orders as $order) {
                    fputcsv($handle, [
                        $order->id,
                        $order->status,
                        number_format((float) $order->total, 2, '.', ''),
                        $order->created_at?->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, 'reporte_dashboard.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
