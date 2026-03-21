<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl leading-tight text-[color:var(--ink)]">{{ __('Pedidos') }}</h2>
            <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Listado de pedidos') }}</p>
        </div>
    </x-slot>

    <div class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm overflow-hidden">
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
                        @forelse ($orders as $order)
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
                                <td class="px-5 py-4 text-sm text-[color:var(--ink-muted)]">{{ $order->user?->name ?? __('(Sin usuario)') }}</td>
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
                                <td colspan="5" class="px-5 py-10 text-center text-sm text-[color:var(--ink-muted)]">
                                    {{ __('No hay pedidos todavía.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="px-5 py-4 border-t border-[color:var(--cream-dark)] bg-[color:var(--white)]">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

