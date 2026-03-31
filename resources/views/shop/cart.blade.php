<x-layouts::shop :title="__('Carrito')">
    <section class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="shop-kicker">{{ __('Tu seleccion') }}</p>
            <h1 class="mt-3 shop-page-title">{{ __('Carrito') }}</h1>
            <p class="shop-copy mt-4 max-w-xl">{{ __('Un resumen más limpio, con productos mejor presentados y un bloque de pago que sí se siente premium.') }}</p>
        </div>

        <a href="{{ route('checkout.create') }}" class="shop-btn-primary">
            {{ __('Ir a checkout') }}
        </a>
    </section>

    <section class="mt-10 grid gap-8 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="space-y-5">
            @forelse ($items as $item)
                @php
                    $itemImage = $item->product->images->first();
                    $itemImageUrl = $itemImage
                        ? (\Illuminate\Support\Str::startsWith($itemImage->url, ['http://', 'https://', '/']) ? $itemImage->url : asset($itemImage->url))
                        : null;
                @endphp
                <article class="shop-card-product p-4 sm:p-5">
                    <div class="grid gap-5 md:grid-cols-[180px_1fr]">
                        <a href="{{ route('shop.products.show', $item->product) }}" class="block overflow-hidden rounded-[1.6rem] bg-[linear-gradient(135deg,#f8efe3,#e9d5bb)]">
                            <div class="flex h-full min-h-[200px] items-center justify-center p-6">
                                @if ($itemImageUrl)
                                    <img src="{{ $itemImageUrl }}" alt="{{ $item->product->name }}" class="max-h-40 w-auto object-contain">
                                @else
                                    <span class="text-6xl">✦</span>
                                @endif
                            </div>
                        </a>

                        <div class="flex flex-col justify-between gap-4">
                            <div class="flex flex-wrap items-start justify-between gap-4">
                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.24em] text-[color:var(--gold)]">
                                        {{ $item->product->category?->name ?? __('Boutique') }}
                                    </p>
                                    <h2 class="mt-2 font-editorial text-4xl font-light text-[color:var(--espresso)]">
                                        {{ $item->product->name }}
                                    </h2>
                                    <p class="mt-3 text-sm text-[color:var(--ink-muted)]">
                                        {{ __('Precio unitario') }}: <span class="text-[color:var(--gold-dark)]">${{ number_format((float) $item->product->price, 2) }} MXN</span>
                                    </p>
                                </div>

                                <div class="text-right">
                                    <p class="text-[10px] uppercase tracking-[0.24em] text-[color:var(--ink-faint)]">{{ __('Subtotal') }}</p>
                                    <p class="mt-2 text-lg text-[color:var(--espresso)]">${{ number_format((float) $item->product->price * (int) $item->quantity, 2) }} MXN</p>
                                </div>
                            </div>

                            <div class="flex flex-col gap-3 border-t border-[color:rgba(201,168,76,0.12)] pt-4 sm:flex-row sm:items-center sm:justify-between">
                                <form method="POST" action="{{ route('cart.items.update', $item) }}" class="flex flex-wrap items-center gap-3">
                                    @csrf
                                    @method('PATCH')
                                    <input name="quantity" type="number" min="1" max="99" value="{{ $item->quantity }}" class="shop-input max-w-[110px]" />
                                    <button type="submit" class="shop-btn-secondary">
                                        {{ __('Actualizar') }}
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('cart.items.destroy', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[11px] uppercase tracking-[0.22em] text-[color:var(--danger-text)] transition hover:opacity-75">
                                        {{ __('Quitar pieza') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <div class="shop-panel rounded-[2rem] px-8 py-14 text-center">
                    <p class="font-editorial text-5xl font-light text-[color:var(--espresso)]">{{ __('Tu carrito esta vacio') }}</p>
                    <p class="shop-copy mx-auto mt-4 max-w-md">{{ __('Todavía no agregas piezas. Vuelve al catálogo y arma una selección con más intención visual y mejor presentación.') }}</p>
                    <a href="{{ route('shop') }}" class="shop-btn-primary mt-8">
                        {{ __('Volver a la tienda') }}
                    </a>
                </div>
            @endforelse
        </div>

        <aside class="space-y-5">
            <div class="shop-panel-dark rounded-[2rem] p-7 text-[color:var(--cream)] sm:p-8">
                <p class="shop-kicker">{{ __('Resumen') }}</p>
                <h2 class="mt-3 font-editorial text-4xl font-light text-[color:var(--cream)]">{{ __('Tu pedido') }}</h2>

                <div class="mt-8 space-y-4 text-sm text-[color:rgba(250,246,240,0.68)]">
                    <div class="flex items-center justify-between">
                        <span>{{ __('Piezas') }}</span>
                        <span>{{ $items->sum('quantity') }}</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-[color:rgba(232,213,163,0.1)] pb-4">
                        <span>{{ __('Subtotal') }}</span>
                        <span class="text-[color:var(--cream)]">${{ number_format($subtotal, 2) }} MXN</span>
                    </div>
                    <div class="flex items-center justify-between text-base text-[color:var(--gold-light)]">
                        <span>{{ __('Total') }}</span>
                        <span>${{ number_format($subtotal, 2) }} MXN</span>
                    </div>
                </div>

                <a href="{{ route('checkout.create') }}" class="shop-btn-primary mt-8 w-full">
                    {{ __('Continuar a checkout') }}
                </a>
                <a href="{{ route('shop') }}" class="shop-btn-secondary mt-3 w-full">
                    {{ __('Seguir comprando') }}
                </a>
            </div>
        </aside>
    </section>
</x-layouts::shop>
