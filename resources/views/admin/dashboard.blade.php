<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl leading-tight text-[color:var(--ink)]">
                    {{ __('Dashboard') }}
                </h2>
                <p class="mt-1 text-sm text-[color:var(--ink-muted)]">
                    {{ __('Resumen general de la tienda') }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('admin.orders.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] hover:bg-[color:var(--cream)] transition">
                    {{ __('Ver pedidos') }}
                </a>
                <a href="{{ route('admin.products.index') }}"
                    class="inline-flex items-center gap-2 rounded-xl border border-[color:var(--gold-dark)] bg-[color:var(--gold)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)] hover:bg-[color:var(--gold-dark)] hover:text-[color:var(--white)] transition">
                    {{ __('Ver productos') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Pedidos pendientes') }}</p>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[color:var(--warning-bg)] text-[color:var(--warning-text)]">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16Zm.75-11a.75.75 0 0 0-1.5 0v3.25c0 .414.336.75.75.75h2a.75.75 0 0 0 0-1.5h-1.25V7Z" clip-rule="evenodd" /></svg>
                        </span>
                    </div>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($pendingOrdersCount) }}</p>
                    <p class="mt-2 text-sm text-[color:var(--ink-muted)]">{{ __('Requieren atención') }}</p>
                </div>

                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Pedidos de hoy') }}</p>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[color:var(--cream)] text-[color:var(--ink-muted)]">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M5.75 2.5a.75.75 0 0 1 .75.75V4h7V3.25a.75.75 0 0 1 1.5 0V4h.75A2.25 2.25 0 0 1 18 6.25v8.5A2.25 2.25 0 0 1 15.75 17h-11A2.25 2.25 0 0 1 2.5 14.75v-8.5A2.25 2.25 0 0 1 4.75 4h.75v-.75a.75.75 0 0 1 .75-.75Z" /></svg>
                        </span>
                    </div>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($ordersTodayCount) }}</p>
                    <p class="mt-2 text-sm text-[color:var(--ink-muted)]">{{ __('Últimas 24h') }}</p>
                </div>

                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Ventas del mes') }}</p>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[color:rgba(201,168,76,0.15)] text-[color:var(--gold-dark)]">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10.75 4.75a.75.75 0 0 0-1.5 0v.443a3.25 3.25 0 0 0 .75 6.413h.5a1.75 1.75 0 1 1 0 3.5h-.5a1.75 1.75 0 0 1-1.75-1.75.75.75 0 0 0-1.5 0 3.25 3.25 0 0 0 2.5 3.156v.488a.75.75 0 0 0 1.5 0v-.443a3.25 3.25 0 0 0-.75-6.413h-.5a1.75 1.75 0 1 1 0-3.5h.5c.967 0 1.75.784 1.75 1.75a.75.75 0 0 0 1.5 0 3.25 3.25 0 0 0-2.5-3.156V4.75Z" /></svg>
                        </span>
                    </div>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">${{ number_format($revenueThisMonth, 2) }}</p>
                    <p class="mt-2 text-sm text-[color:var(--ink-muted)]">{{ __('Acumulado mensual') }}</p>
                </div>

                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Productos activos') }}</p>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[color:var(--success-bg)] text-[color:var(--success-text)]">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M3.25 5.5A2.25 2.25 0 0 1 5.5 3.25h9A2.25 2.25 0 0 1 16.75 5.5v9a2.25 2.25 0 0 1-2.25 2.25h-9A2.25 2.25 0 0 1 3.25 14.5v-9Zm4.97 5.03a.75.75 0 1 0-1.06 1.06l1.5 1.5a.75.75 0 0 0 1.06 0l3.5-3.5a.75.75 0 0 0-1.06-1.06L9.19 11.5l-.97-.97Z" /></svg>
                        </span>
                    </div>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($activeProductsCount) }}</p>
                    <p class="mt-2 text-sm text-[color:var(--ink-muted)]">{{ __('En catálogo') }}</p>
                </div>

                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Sin stock') }}</p>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[color:var(--danger-bg)] text-[color:var(--danger-text)]">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M9.401 2.403a1.75 1.75 0 0 1 3.198 0l5.212 11.737A1.75 1.75 0 0 1 16.213 16.5H3.787a1.75 1.75 0 0 1-1.598-2.36L7.4 2.403ZM10 7.25a.75.75 0 0 0-.75.75v3a.75.75 0 0 0 1.5 0V8a.75.75 0 0 0-.75-.75Zm0 7a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z" clip-rule="evenodd" /></svg>
                        </span>
                    </div>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($outOfStockCount) }}</p>
                    <p class="mt-2 text-sm text-[color:var(--ink-muted)]">{{ __('Productos agotados') }}</p>
                </div>

                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Clientes') }}</p>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-[color:var(--cream)] text-[color:var(--ink-muted)]">
                            <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M10 2.5a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5ZM4.25 15a4.75 4.75 0 0 1 9.5 0v.75c0 .414-.336.75-.75.75H5a.75.75 0 0 1-.75-.75V15Z" /></svg>
                        </span>
                    </div>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($customersCount) }}</p>
                    <p class="mt-2 text-sm text-[color:var(--ink-muted)]">{{ __('Registrados') }}</p>
                </div>
            </div>

            <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5">
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h3 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Referencias rápidas') }}</h3>
                        <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Accesos directos para operación diaria') }}</p>
                    </div>
                </div>
                <div class="mt-4 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-3">
                    <a href="{{ route('admin.inventory.index') }}" class="rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--cream)] px-4 py-3 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] transition">{{ __('Revisar inventario') }}</a>
                    <a href="{{ route('admin.payments.index') }}" class="rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--cream)] px-4 py-3 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] transition">{{ __('Ver pagos') }}</a>
                    <a href="{{ route('admin.shipping.index') }}" class="rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--cream)] px-4 py-3 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] transition">{{ __('Gestionar envíos') }}</a>
                    <a href="{{ route('admin.store.index') }}" class="rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--cream)] px-4 py-3 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] transition">{{ __('Configuración tienda') }}</a>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <form method="GET" class="xl:col-span-3 rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-4 grid grid-cols-1 md:grid-cols-5 gap-3">
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)] mb-1">{{ __('Rango') }}</label>
                        <select name="chart_days" class="w-full rounded-xl border-[color:var(--cream-dark)] text-sm">
                            <option value="7" @selected((int) ($chartDays ?? 7) === 7)>{{ __('Últimos 7 días') }}</option>
                            <option value="30" @selected((int) ($chartDays ?? 7) === 30)>{{ __('Últimos 30 días') }}</option>
                            <option value="90" @selected((int) ($chartDays ?? 7) === 90)>{{ __('Últimos 90 días') }}</option>
                            <option value="180" @selected((int) ($chartDays ?? 7) === 180)>{{ __('Últimos 180 días') }}</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)] mb-1">{{ __('Estado pedido') }}</label>
                        <select name="chart_status" class="w-full rounded-xl border-[color:var(--cream-dark)] text-sm">
                            <option value="all" @selected(($chartStatus ?? 'all') === 'all')>{{ __('Todos') }}</option>
                            @foreach (($availableStatuses ?? collect()) as $status)
                                <option value="{{ $status }}" @selected(($chartStatus ?? 'all') === $status)>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-3 flex items-end gap-2">
                        <button class="rounded-xl bg-[color:var(--gold)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)]">{{ __('Aplicar filtros') }}</button>
                        <a href="{{ route('dashboard') }}" class="rounded-xl border border-[color:var(--cream-dark)] px-4 py-2 text-sm font-semibold">{{ __('Limpiar') }}</a>
                        <a href="{{ route('admin.dashboard.export', request()->query()) }}" class="rounded-xl border border-[color:var(--gold-dark)] px-4 py-2 text-sm font-semibold">{{ __('Exportar Excel') }}</a>
                    </div>
                </form>

                <div class="xl:col-span-3 grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5 lg:col-span-2">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Ventas últimos :days días', ['days' => $chartDays ?? 7]) }}</h3>
                                <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Monto diario facturado') }}</p>
                            </div>
                        </div>
                        <div class="mt-4 h-72">
                            <canvas id="revenueLast7DaysChart"></canvas>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5">
                        <h3 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Pedidos por estado') }}</h3>
                        <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Distribución actual') }}</p>
                        <div class="mt-4 h-72">
                            <canvas id="ordersStatusChart"></canvas>
                        </div>
                    </div>

                    <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5 lg:col-span-3">
                        <h3 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Pedidos últimos :days días', ['days' => $chartDays ?? 7]) }}</h3>
                        <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Cantidad diaria de pedidos') }}</p>
                        <div class="mt-4 h-64">
                            <canvas id="ordersLast7DaysChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="xl:col-span-2 rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm">
                    <div class="flex items-center justify-between px-5 py-4 border-b border-[color:var(--cream-dark)]">
                        <div>
                            <h3 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Pedidos recientes') }}</h3>
                            <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Últimos movimientos') }}</p>
                        </div>
                        <a href="{{ route('admin.orders.index') }}" class="text-sm font-semibold text-[color:var(--gold-dark)] hover:text-[color:var(--gold)] transition">
                            {{ __('Ver todos') }}
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-[color:var(--cream-dark)]">
                            <thead class="bg-[color:var(--cream)]">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Pedido') }}</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Cliente') }}</th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Estado') }}</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Total') }}</th>
                                    <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Fecha') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-[color:var(--cream-dark)]">
                                @forelse ($recentOrders as $order)
                                    @php
                                        $status = (string) $order->status;
                                        $badgeBg = 'var(--cream-dark)';
                                        $badgeText = 'var(--ink-muted)';

                                        if ($status === 'pending') {
                                            $badgeBg = 'var(--warning-bg)';
                                            $badgeText = 'var(--warning-text)';
                                        } elseif (in_array($status, ['paid', 'completed', 'delivered'], true)) {
                                            $badgeBg = 'var(--success-bg)';
                                            $badgeText = 'var(--success-text)';
                                        } elseif (in_array($status, ['cancelled', 'canceled', 'failed'], true)) {
                                            $badgeBg = 'var(--danger-bg)';
                                            $badgeText = 'var(--danger-text)';
                                        }
                                    @endphp
                                    <tr class="hover:bg-[color:var(--cream)] transition">
                                        <td class="px-5 py-4 text-sm font-semibold text-[color:var(--ink)]">#{{ $order->id }}</td>
                                        <td class="px-5 py-4 text-sm text-[color:var(--ink-muted)]">
                                            {{ $order->user?->name ?? __('(Sin usuario)') }}
                                        </td>
                                        <td class="px-5 py-4">
                                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold"
                                                style="background: {{ $badgeBg }}; color: {{ $badgeText }};">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-4 text-sm font-semibold text-right text-[color:var(--ink)]">${{ number_format((float) $order->total, 2) }}</td>
                                        <td class="px-5 py-4 text-sm text-right text-[color:var(--ink-muted)]">{{ $order->created_at?->format('d/m/Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-5 py-8 text-center text-sm text-[color:var(--ink-muted)]">
                                            {{ __('Aún no hay pedidos para mostrar.') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm">
                    <div class="px-5 py-4 border-b border-[color:var(--cream-dark)]">
                        <h3 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Alertas de inventario') }}</h3>
                        <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Productos activos sin stock') }}</p>
                    </div>

                    <div class="p-5 space-y-3">
                        @forelse ($outOfStockProducts as $product)
                            <div class="flex items-center justify-between gap-3 rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--cream)] px-4 py-3">
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-[color:var(--ink)]">{{ $product->name }}</p>
                                    <p class="mt-0.5 text-xs text-[color:var(--ink-muted)]">
                                        {{ __('SKU/ID') }}: {{ $product->id }}
                                    </p>
                                </div>
                                <span class="shrink-0 inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold"
                                    style="background: var(--danger-bg); color: var(--danger-text);">
                                    {{ __('Agotado') }}
                                </span>
                            </div>
                        @empty
                            <div class="rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--cream)] px-4 py-4 text-sm text-[color:var(--ink-muted)]">
                                {{ __('Sin alertas por ahora.') }}
                            </div>
                        @endforelse

                        <a href="{{ route('admin.products.index') }}"
                            class="inline-flex w-full items-center justify-center rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] hover:bg-[color:var(--cream)] transition">
                            {{ __('Gestionar productos') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
    <script>
        (() => {
            if (!window.Chart) {
                return;
            }

            const labels = @js($ordersChartLabels);
            const ordersData = @js($ordersChartData);
            const revenueData = @js($revenueChartData);
            const statusLabels = @js($statusChartLabels);
            const statusData = @js($statusChartData);

            const axisColor = '#6f675f';
            const gridColor = 'rgba(129, 116, 104, 0.18)';
            const ink = '#332b24';

            new Chart(document.getElementById('revenueLast7DaysChart'), {
                type: 'line',
                data: {
                    labels,
                    datasets: [{
                        label: 'Ventas ($)',
                        data: revenueData,
                        borderColor: '#b9831b',
                        backgroundColor: 'rgba(185, 131, 27, 0.18)',
                        fill: true,
                        tension: 0.35,
                        pointRadius: 3,
                        pointHoverRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: { color: ink }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: axisColor },
                            grid: { color: gridColor }
                        },
                        y: {
                            ticks: { color: axisColor },
                            grid: { color: gridColor }
                        }
                    }
                }
            });

            new Chart(document.getElementById('ordersLast7DaysChart'), {
                type: 'bar',
                data: {
                    labels,
                    datasets: [{
                        label: 'Pedidos',
                        data: ordersData,
                        backgroundColor: 'rgba(84, 68, 54, 0.75)',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: { color: ink }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: axisColor },
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: axisColor,
                                precision: 0
                            },
                            grid: { color: gridColor }
                        }
                    }
                }
            });

            new Chart(document.getElementById('ordersStatusChart'), {
                type: 'doughnut',
                data: {
                    labels: statusLabels,
                    datasets: [{
                        data: statusData,
                        backgroundColor: [
                            '#b9831b',
                            '#3f8e5a',
                            '#ca5234',
                            '#7b6f64',
                            '#c5a57a',
                            '#8d5f3b'
                        ],
                        borderWidth: 1,
                        borderColor: '#ffffff'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: ink,
                                usePointStyle: true,
                                padding: 16
                            }
                        }
                    }
                }
            });
        })();
    </script>
</x-app-layout>
