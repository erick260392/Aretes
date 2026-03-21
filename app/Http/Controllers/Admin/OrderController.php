<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::query()
            ->with('user');

        if ($search = trim((string) $request->string('q'))) {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('id', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
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

        if ($request->filled('min_total')) {
            $query->where('total', '>=', (float) $request->input('min_total'));
        }

        if ($request->filled('max_total')) {
            $query->where('total', '<=', (float) $request->input('max_total'));
        }

        $orders = $query
            ->latest()
            ->paginate(50)
            ->withQueryString();

        return view('admin.orders.index', [
            'orders' => $orders,
            'statuses' => Order::query()->select('status')->distinct()->pluck('status'),
        ]);
    }

    public function export(Request $request): StreamedResponse
    {
        $query = Order::query()->with('user');

        if ($search = trim((string) $request->string('q'))) {
            $query->where(function ($builder) use ($search) {
                $builder
                    ->where('id', 'like', "%{$search}%")
                    ->orWhere('notes', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
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

        if ($request->filled('min_total')) {
            $query->where('total', '>=', (float) $request->input('min_total'));
        }

        if ($request->filled('max_total')) {
            $query->where('total', '<=', (float) $request->input('max_total'));
        }

        return response()->streamDownload(function () use ($query): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Pedido', 'Cliente', 'Email', 'Estado', 'Total', 'Fecha']);

            $query->orderByDesc('id')->chunk(1000, function ($orders) use ($handle): void {
                foreach ($orders as $order) {
                    fputcsv($handle, [
                        $order->id,
                        $order->user?->name,
                        $order->user?->email,
                        $order->status,
                        number_format((float) $order->total, 2, '.', ''),
                        $order->created_at?->format('Y-m-d H:i:s'),
                    ]);
                }
            });

            fclose($handle);
        }, 'reporte_pedidos.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }
}
