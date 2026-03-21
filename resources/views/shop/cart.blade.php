<x-layouts::shop :title="__('Carrito')">
    <div class="flex items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold">{{ __('Carrito') }}</h1>
            <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Revisa artículos antes de checkout.') }}</p>
        </div>

        <a href="{{ route('checkout.create') }}"
            class="inline-flex items-center rounded-xl border border-[color:var(--gold-dark)] bg-[color:var(--gold)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)] hover:bg-[color:var(--gold-dark)] hover:text-[color:var(--white)] transition">
            {{ __('Ir a checkout') }}
        </a>
    </div>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 rounded-2xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-[color:var(--cream-dark)]">
                    <thead class="bg-[color:var(--cream)]">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Producto') }}</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Precio') }}</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Cantidad') }}</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Subtotal') }}</th>
                            <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[color:var(--cream-dark)]">
                        @forelse ($items as $item)
                            <tr class="hover:bg-[color:var(--cream)] transition">
                                <td class="px-5 py-4">
                                    <p class="text-sm font-semibold text-[color:var(--ink)]">{{ $item->product->name }}</p>
                                    <p class="mt-0.5 text-xs text-[color:var(--ink-muted)]">ID: {{ $item->product->id }}</p>
                                </td>
                                <td class="px-5 py-4 text-sm font-semibold text-right text-[color:var(--ink)]">
                                    ${{ number_format((float) $item->product->price, 2) }}
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <form method="POST" action="{{ route('cart.items.update', $item) }}" class="inline-flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input name="quantity" type="number" min="1" max="99" value="{{ $item->quantity }}"
                                            class="w-20 rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-3 py-1.5 text-sm text-[color:var(--ink)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]" />
                                        <button type="submit"
                                            class="rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-3 py-1.5 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] hover:bg-[color:var(--cream)] transition">
                                            {{ __('Actualizar') }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-5 py-4 text-sm font-semibold text-right text-[color:var(--ink)]">
                                    ${{ number_format((float) $item->product->price * (int) $item->quantity, 2) }}
                                </td>
                                <td class="px-5 py-4 text-right">
                                    <form method="POST" action="{{ route('cart.items.destroy', $item) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm font-semibold" style="color: var(--danger-text);">
                                            {{ __('Quitar') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-sm text-[color:var(--ink-muted)]">
                                    {{ __('Tu carrito está vacío.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-2xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] p-6 shadow-sm">
            <h2 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Resumen') }}</h2>

            <div class="mt-4 flex items-center justify-between">
                <span class="text-sm font-semibold text-[color:var(--ink-muted)]">{{ __('Subtotal') }}</span>
                <span class="text-sm font-semibold text-[color:var(--ink)]">${{ number_format($subtotal, 2) }}</span>
            </div>

            <div class="mt-5">
                <a href="{{ route('checkout.create') }}"
                    class="inline-flex w-full items-center justify-center rounded-xl border border-[color:var(--gold-dark)] bg-[color:var(--gold)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)] hover:bg-[color:var(--gold-dark)] hover:text-[color:var(--white)] transition">
                    {{ __('Continuar a checkout') }}
                </a>
            </div>
        </div>
    </div>
</x-layouts::shop>
