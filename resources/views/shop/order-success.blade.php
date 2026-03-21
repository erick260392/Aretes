<x-layouts::shop :title="__('Pedido generado')">
    <div class="rounded-2xl border border-[color:rgba(59,109,17,0.25)] bg-[color:var(--success-bg)] p-6">
        <h1 class="text-xl font-semibold text-[color:var(--success-text)]">{{ __('Pedido generado') }}</h1>
        <p class="mt-2 text-sm text-[color:var(--success-text)]">
            {{ __('Tu pedido se creó correctamente.') }} <span class="font-bold">#{{ $order->id }}</span>
        </p>
    </div>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 rounded-2xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-[color:var(--cream-dark)]">
                <h2 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Artículos') }}</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[color:var(--cream-dark)]">
                    <thead class="bg-[color:var(--cream)]">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Producto') }}</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Precio') }}</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Cantidad') }}</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Subtotal') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[color:var(--cream-dark)]">
                        @foreach ($order->items as $item)
                            <tr class="hover:bg-[color:var(--cream)] transition">
                                <td class="px-5 py-4 text-sm font-semibold text-[color:var(--ink)]">{{ $item->product?->name ?? __('Producto') }}</td>
                                <td class="px-5 py-4 text-sm font-semibold text-right text-[color:var(--ink)]">${{ number_format((float) $item->unit_price, 2) }}</td>
                                <td class="px-5 py-4 text-sm font-semibold text-right text-[color:var(--ink)]">{{ $item->quantity }}</td>
                                <td class="px-5 py-4 text-sm font-semibold text-right text-[color:var(--ink)]">
                                    ${{ number_format((float) $item->unit_price * (int) $item->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="space-y-4">
            <div class="rounded-2xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Total') }}</h2>
                <p class="mt-2 text-2xl font-semibold text-[color:var(--ink)]">${{ number_format((float) $order->total, 2) }}</p>
                <p class="mt-2 text-sm text-[color:var(--ink-muted)]">{{ __('Estado') }}: <span class="font-semibold">{{ $order->status }}</span></p>
            </div>

            <div class="rounded-2xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Pago') }}</h2>
                <p class="mt-2 text-sm text-[color:var(--ink-muted)]">
                    {{ __('Método') }}: <span class="font-semibold text-[color:var(--ink)]">{{ $order->payment?->payment_method }}</span>
                </p>
                <p class="mt-1 text-sm text-[color:var(--ink-muted)]">
                    {{ __('Estatus') }}: <span class="font-semibold text-[color:var(--ink)]">{{ $order->payment?->status }}</span>
                </p>
            </div>

            <div class="rounded-2xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Dirección') }}</h2>
                <p class="mt-2 text-sm text-[color:var(--ink-muted)]">
                    {{ $order->address?->street }}<br>
                    {{ $order->address?->city }}, {{ $order->address?->state }} {{ $order->address?->postal_code }}<br>
                    {{ $order->address?->country }}
                </p>
            </div>

            <a href="{{ route('shop') }}"
                class="inline-flex w-full items-center justify-center rounded-xl border border-[color:var(--gold-dark)] bg-[color:var(--gold)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)] hover:bg-[color:var(--gold-dark)] hover:text-[color:var(--white)] transition">
                {{ __('Seguir comprando') }}
            </a>
        </div>
    </div>
</x-layouts::shop>
