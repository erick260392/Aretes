<x-layouts::shop :title="__('Checkout')">
    <section class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="shop-kicker">{{ __('Finaliza tu pedido') }}</p>
            <h1 class="mt-3 shop-page-title">{{ __('Checkout') }}</h1>
            <p class="shop-copy mt-4 max-w-xl">{{ __('Un cierre visualmente consistente: formularios más elegantes, resumen claro y mejor contraste para transmitir confianza.') }}</p>
        </div>
    </section>

    <section class="mt-10 grid gap-8 lg:grid-cols-[1.05fr_0.95fr]">
        <form method="POST" action="{{ route('checkout.store') }}" class="space-y-6">
            @csrf

            <div class="shop-panel rounded-[2rem] p-7 sm:p-8">
                <p class="shop-kicker">{{ __('Direccion de envio') }}</p>
                <h2 class="mt-3 shop-section-title">{{ __('¿A dónde enviamos tu pedido?') }}</h2>

                <div class="mt-8 grid gap-5 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label class="mb-3 block text-[11px] font-medium uppercase tracking-[0.24em] text-[color:var(--ink-muted)]" for="street">{{ __('Calle y numero') }}</label>
                        <input id="street" name="street" type="text" required value="{{ old('street', $defaultAddress?->street) }}" class="shop-input">
                        @error('street')
                            <p class="mt-3 text-sm text-[color:var(--danger-text)]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-3 block text-[11px] font-medium uppercase tracking-[0.24em] text-[color:var(--ink-muted)]" for="city">{{ __('Ciudad') }}</label>
                        <input id="city" name="city" type="text" required value="{{ old('city', $defaultAddress?->city) }}" class="shop-input">
                        @error('city')
                            <p class="mt-3 text-sm text-[color:var(--danger-text)]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-3 block text-[11px] font-medium uppercase tracking-[0.24em] text-[color:var(--ink-muted)]" for="state">{{ __('Estado') }}</label>
                        <input id="state" name="state" type="text" required value="{{ old('state', $defaultAddress?->state) }}" class="shop-input">
                        @error('state')
                            <p class="mt-3 text-sm text-[color:var(--danger-text)]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-3 block text-[11px] font-medium uppercase tracking-[0.24em] text-[color:var(--ink-muted)]" for="postal_code">{{ __('Codigo postal') }}</label>
                        <input id="postal_code" name="postal_code" type="text" required value="{{ old('postal_code', $defaultAddress?->postal_code) }}" class="shop-input">
                        @error('postal_code')
                            <p class="mt-3 text-sm text-[color:var(--danger-text)]">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-3 block text-[11px] font-medium uppercase tracking-[0.24em] text-[color:var(--ink-muted)]" for="country">{{ __('Pais') }}</label>
                        <input id="country" name="country" type="text" required value="{{ old('country', $defaultAddress?->country ?? 'México') }}" class="shop-input">
                        @error('country')
                            <p class="mt-3 text-sm text-[color:var(--danger-text)]">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="shop-panel rounded-[2rem] p-7 sm:p-8">
                <p class="shop-kicker">{{ __('Pago') }}</p>
                <h2 class="mt-3 shop-section-title">{{ __('Selecciona tu metodo') }}</h2>

                <div class="mt-8 grid gap-4 sm:grid-cols-3">
                    @php
                        $method = old('payment_method', 'cash');
                    @endphp
                    <label class="shop-choice">
                        <input type="radio" name="payment_method" value="cash" @checked($method === 'cash')>
                        <span>
                            <span class="block text-[11px] uppercase tracking-[0.24em] text-[color:var(--gold)]">{{ __('Opcion') }}</span>
                            <span class="mt-1 block text-sm text-[color:var(--espresso)]">{{ __('Efectivo') }}</span>
                        </span>
                    </label>
                    <label class="shop-choice">
                        <input type="radio" name="payment_method" value="transfer" @checked($method === 'transfer')>
                        <span>
                            <span class="block text-[11px] uppercase tracking-[0.24em] text-[color:var(--gold)]">{{ __('Opcion') }}</span>
                            <span class="mt-1 block text-sm text-[color:var(--espresso)]">{{ __('Transferencia') }}</span>
                        </span>
                    </label>
                    <label class="shop-choice">
                        <input type="radio" name="payment_method" value="card" @checked($method === 'card')>
                        <span>
                            <span class="block text-[11px] uppercase tracking-[0.24em] text-[color:var(--gold)]">{{ __('Opcion') }}</span>
                            <span class="mt-1 block text-sm text-[color:var(--espresso)]">{{ __('Tarjeta') }}</span>
                        </span>
                    </label>
                </div>
                @error('payment_method')
                    <p class="mt-3 text-sm text-[color:var(--danger-text)]">{{ $message }}</p>
                @enderror

                <div class="mt-6">
                    <label class="mb-3 block text-[11px] font-medium uppercase tracking-[0.24em] text-[color:var(--ink-muted)]" for="notes">{{ __('Notas adicionales') }}</label>
                    <input id="notes" name="notes" type="text" value="{{ old('notes') }}" class="shop-input" placeholder="{{ __('Indicaciones de entrega, referencia, etc.') }}">
                    @error('notes')
                        <p class="mt-3 text-sm text-[color:var(--danger-text)]">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap justify-end gap-3">
                <a href="{{ route('cart.index') }}" class="shop-btn-secondary">
                    {{ __('Volver al carrito') }}
                </a>
                <button type="submit" class="shop-btn-primary">
                    {{ __('Generar pedido') }}
                </button>
            </div>
        </form>

        <aside class="space-y-6">
            <div class="shop-panel-dark rounded-[2rem] p-7 text-[color:var(--cream)] sm:p-8">
                <p class="shop-kicker">{{ __('Resumen') }}</p>
                <h2 class="mt-3 font-editorial text-4xl font-light text-[color:var(--cream)]">{{ __('Tu seleccion final') }}</h2>

                <div class="mt-8 space-y-4">
                    @foreach ($items as $item)
                        @php
                            $checkoutImage = $item->product->images->first();
                            $checkoutImageUrl = $checkoutImage
                                ? (\Illuminate\Support\Str::startsWith($checkoutImage->url, ['http://', 'https://', '/']) ? $checkoutImage->url : asset($checkoutImage->url))
                                : null;
                        @endphp
                        <div class="flex items-center gap-4 rounded-[1.4rem] border border-[color:rgba(232,213,163,0.08)] bg-[color:rgba(255,255,255,0.04)] p-4">
                            <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-[1.2rem] bg-[linear-gradient(135deg,#f8efe2,#e6d0af)]">
                                @if ($checkoutImageUrl)
                                    <img src="{{ $checkoutImageUrl }}" alt="{{ $item->product->name }}" class="max-h-14 w-auto object-contain">
                                @else
                                    <span class="text-3xl">✦</span>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="truncate font-editorial text-2xl font-light text-[color:var(--cream)]">{{ $item->product->name }}</p>
                                <p class="mt-1 text-[11px] uppercase tracking-[0.22em] text-[color:rgba(250,246,240,0.45)]">
                                    {{ __('Cantidad') }} · {{ $item->quantity }}
                                </p>
                            </div>
                            <p class="text-sm text-[color:var(--gold-light)]">
                                ${{ number_format((float) $item->product->price * (int) $item->quantity, 2) }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8 space-y-4 border-t border-[color:rgba(232,213,163,0.1)] pt-5 text-sm text-[color:rgba(250,246,240,0.68)]">
                    <div class="flex items-center justify-between">
                        <span>{{ __('Subtotal') }}</span>
                        <span>${{ number_format($subtotal, 2) }} MXN</span>
                    </div>
                    <div class="flex items-center justify-between text-base text-[color:var(--gold-light)]">
                        <span>{{ __('Total') }}</span>
                        <span>${{ number_format($subtotal, 2) }} MXN</span>
                    </div>
                </div>
            </div>
        </aside>
    </section>
</x-layouts::shop>
