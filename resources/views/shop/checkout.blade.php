<x-layouts::shop :title="__('Checkout')">
    <div class="flex items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold">{{ __('Checkout') }}</h1>
            <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Completa la dirección y genera el pedido.') }}</p>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <form method="POST" action="{{ route('checkout.store') }}" class="lg:col-span-2 space-y-6">
            @csrf

            <div class="rounded-2xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Dirección de envío') }}</h2>

                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-[color:var(--ink)]" for="street">{{ __('Calle y número') }}</label>
                        <input id="street" name="street" type="text" required
                            value="{{ old('street', $defaultAddress?->street) }}"
                            class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]" />
                        @error('street')
                            <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[color:var(--ink)]" for="city">{{ __('Ciudad') }}</label>
                        <input id="city" name="city" type="text" required value="{{ old('city', $defaultAddress?->city) }}"
                            class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]" />
                        @error('city')
                            <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[color:var(--ink)]" for="state">{{ __('Estado') }}</label>
                        <input id="state" name="state" type="text" required value="{{ old('state', $defaultAddress?->state) }}"
                            class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]" />
                        @error('state')
                            <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[color:var(--ink)]" for="postal_code">{{ __('Código postal') }}</label>
                        <input id="postal_code" name="postal_code" type="text" required value="{{ old('postal_code', $defaultAddress?->postal_code) }}"
                            class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]" />
                        @error('postal_code')
                            <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[color:var(--ink)]" for="country">{{ __('País') }}</label>
                        <input id="country" name="country" type="text" required value="{{ old('country', $defaultAddress?->country ?? 'México') }}"
                            class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]" />
                        @error('country')
                            <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="rounded-2xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] p-6 shadow-sm">
                <h2 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Pago') }}</h2>

                <div class="mt-4 grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @php($method = old('payment_method', 'cash'))
                    <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-3 text-sm font-semibold text-[color:var(--ink)]">
                        <input type="radio" name="payment_method" value="cash" @checked($method === 'cash')>
                        {{ __('Efectivo') }}
                    </label>
                    <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-3 text-sm font-semibold text-[color:var(--ink)]">
                        <input type="radio" name="payment_method" value="transfer" @checked($method === 'transfer')>
                        {{ __('Transferencia') }}
                    </label>
                    <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-3 text-sm font-semibold text-[color:var(--ink)]">
                        <input type="radio" name="payment_method" value="card" @checked($method === 'card')>
                        {{ __('Tarjeta') }}
                    </label>
                </div>

                @error('payment_method')
                    <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                @enderror

                <div class="mt-4">
                    <label class="block text-sm font-semibold text-[color:var(--ink)]" for="notes">{{ __('Notas (opcional)') }}</label>
                    <input id="notes" name="notes" type="text" value="{{ old('notes') }}"
                        class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]" />
                    @error('notes')
                        <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('cart.index') }}"
                    class="inline-flex items-center rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] hover:bg-[color:var(--cream)] transition">
                    {{ __('Volver al carrito') }}
                </a>
                <button type="submit"
                    class="inline-flex items-center rounded-xl border border-[color:var(--gold-dark)] bg-[color:var(--gold)] px-5 py-2 text-sm font-semibold text-[color:var(--ink)] hover:bg-[color:var(--gold-dark)] hover:text-[color:var(--white)] transition">
                    {{ __('Generar pedido') }}
                </button>
            </div>
        </form>

        <div class="rounded-2xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] p-6 shadow-sm">
            <h2 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Resumen') }}</h2>

            <div class="mt-4 space-y-3">
                @foreach ($items as $item)
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="truncate text-sm font-semibold text-[color:var(--ink)]">{{ $item->product->name }}</p>
                            <p class="mt-0.5 text-xs text-[color:var(--ink-muted)]">
                                {{ __('Cantidad') }}: {{ $item->quantity }}
                            </p>
                        </div>
                        <p class="shrink-0 text-sm font-semibold text-[color:var(--ink)]">
                            ${{ number_format((float) $item->product->price * (int) $item->quantity, 2) }}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 border-t border-[color:var(--cream-dark)] pt-4 flex items-center justify-between">
                <span class="text-sm font-semibold text-[color:var(--ink-muted)]">{{ __('Total') }}</span>
                <span class="text-sm font-semibold text-[color:var(--ink)]">${{ number_format($subtotal, 2) }}</span>
            </div>
        </div>
    </div>
</x-layouts::shop>
