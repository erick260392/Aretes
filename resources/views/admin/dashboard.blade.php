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
                    <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Pedidos pendientes') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($pendingOrdersCount) }}</p>
                    <p class="mt-2 text-sm text-[color:var(--ink-muted)]">{{ __('Requieren atención') }}</p>
                </div>

                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Pedidos de hoy') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($ordersTodayCount) }}</p>
                    <p class="mt-2 text-sm text-[color:var(--ink-muted)]">{{ __('Últimas 24h') }}</p>
                </div>

                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Ventas del mes') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">${{ number_format($revenueThisMonth, 2) }}</p>
                    <p class="mt-2 text-sm text-[color:var(--ink-muted)]">{{ __('Acumulado mensual') }}</p>
                </div>

                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Productos activos') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($activeProductsCount) }}</p>
                    <p class="mt-2 text-sm text-[color:var(--ink-muted)]">{{ __('En catálogo') }}</p>
                </div>

                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Sin stock') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($outOfStockCount) }}</p>
                    <p class="mt-2 text-sm text-[color:var(--ink-muted)]">{{ __('Productos agotados') }}</p>
                </div>

                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Clientes') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($customersCount) }}</p>
                    <p class="mt-2 text-sm text-[color:var(--ink-muted)]">{{ __('Registrados') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
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
</x-app-layout>

