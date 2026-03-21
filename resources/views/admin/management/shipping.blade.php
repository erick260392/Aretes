<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl leading-tight text-[color:var(--ink)]">{{ __('Envíos') }}</h2>
            <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Seguimiento de pedidos y despacho') }}</p>
        </div>
    </x-slot>

    <div class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Pendientes') }}</p><p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($pendingOrdersCount) }}</p></div>
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Listos para envío') }}</p><p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($readyToShipCount) }}</p></div>
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Entregados') }}</p><p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($deliveredCount) }}</p></div>
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Cancelados') }}</p><p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($cancelledCount) }}</p></div>
            </div>

            <form method="GET" class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-4 grid grid-cols-1 md:grid-cols-6 gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar pedido/cliente/dirección" class="md:col-span-2 rounded-xl border-[color:var(--cream-dark)] text-sm">
                <select name="status" class="rounded-xl border-[color:var(--cream-dark)] text-sm"><option value="">{{ __('Estado: Todos') }}</option>@foreach ($statuses as $status)<option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>@endforeach</select>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="rounded-xl border-[color:var(--cream-dark)] text-sm">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="rounded-xl border-[color:var(--cream-dark)] text-sm">
                <div class="md:col-span-2 flex items-center gap-2">
                    <button class="rounded-xl bg-[color:var(--gold)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)]">{{ __('Filtrar') }}</button>
                    <a href="{{ route('admin.shipping.index') }}" class="rounded-xl border border-[color:var(--cream-dark)] px-4 py-2 text-sm font-semibold">{{ __('Limpiar') }}</a>
                    <a href="{{ route('admin.shipping.export', request()->query()) }}" class="rounded-xl border border-[color:var(--gold-dark)] px-4 py-2 text-sm font-semibold">{{ __('Exportar Excel') }}</a>
                </div>
            </form>

            <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[color:var(--cream-dark)]">
                        <thead class="bg-[color:var(--cream)]">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Pedido') }}</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Cliente') }}</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Dirección') }}</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Estado') }}</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Fecha') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[color:var(--cream-dark)]">
                            @forelse ($orders as $order)
                                @php
                                    $status = (string) $order->status;
                                    $badgeBg = 'var(--cream-dark)';
                                    $badgeText = 'var(--ink-muted)';
                                    if ($status === 'pending') { $badgeBg = 'var(--warning-bg)'; $badgeText = 'var(--warning-text)'; }
                                    elseif (in_array($status, ['paid', 'completed', 'delivered'], true)) { $badgeBg = 'var(--success-bg)'; $badgeText = 'var(--success-text)'; }
                                    elseif (in_array($status, ['cancelled', 'canceled', 'failed'], true)) { $badgeBg = 'var(--danger-bg)'; $badgeText = 'var(--danger-text)'; }
                                @endphp

                                <tr class="hover:bg-[color:var(--cream)] transition">
                                    <td class="px-5 py-4 text-sm font-semibold text-[color:var(--ink)]">#{{ $order->id }}</td>
                                    <td class="px-5 py-4 text-sm text-[color:var(--ink-muted)]">{{ $order->user?->name ?? __('Sin cliente') }}</td>
                                    <td class="px-5 py-4 text-sm text-[color:var(--ink-muted)]">{{ $order->address?->street ?? __('Sin dirección') }}, {{ $order->address?->city ?? '' }}</td>
                                    <td class="px-5 py-4"><span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold" style="background: {{ $badgeBg }}; color: {{ $badgeText }};">{{ ucfirst($status) }}</span></td>
                                    <td class="px-5 py-4 text-sm text-right text-[color:var(--ink-muted)]">{{ $order->created_at?->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-5 py-10 text-center text-sm text-[color:var(--ink-muted)]">{{ __('No hay envíos para mostrar.') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-4 border-t border-[color:var(--cream-dark)] bg-[color:var(--white)]">{{ $orders->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
