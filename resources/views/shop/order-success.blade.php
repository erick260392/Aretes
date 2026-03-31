<x-layouts::shop :title="__('Pedido generado')">
    <section class="shop-panel rounded-[2rem] p-8 sm:p-10">
        <p class="shop-kicker">{{ __('Pedido confirmado') }}</p>
        <h1 class="mt-3 shop-page-title !text-[3.4rem]">{{ __('Tu pedido fue generado') }}</h1>
        <p class="shop-copy mt-5 max-w-2xl">
            {{ __('El checkout ahora también se siente cuidado: jerarquía más clara, mejor espaciado y resumen visualmente coherente con la tienda.') }}
            <span class="font-medium text-[color:var(--gold-dark)]">#{{ $order->id }}</span>
        </p>
    </section>

    <section class="mt-8 grid gap-8 lg:grid-cols-[1.08fr_0.92fr]">
        <div class="space-y-5">
            @foreach ($order->items as $item)
                @php
                    $successImage = $item->product?->images?->first();
                    $successImageUrl = $successImage
                        ? (\Illuminate\Support\Str::startsWith($successImage->url, ['http://', 'https://', '/']) ? $successImage->url : asset($successImage->url))
                        : null;
                @endphp
                <article class="shop-card-product p-4 sm:p-5">
                    <div class="grid gap-5 md:grid-cols-[160px_1fr]">
                        <div class="overflow-hidden rounded-[1.5rem] bg-[linear-gradient(135deg,#f8efe3,#e7d2b3)]">
                            <div class="flex min-h-[180px] items-center justify-center p-5">
                                @if ($successImageUrl)
                                    <img src="{{ $successImageUrl }}" alt="{{ $item->product?->name }}" class="max-h-32 w-auto object-contain">
                                @else
                                    <span class="text-5xl">✦</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-[10px] uppercase tracking-[0.24em] text-[color:var(--gold)]">
                                    {{ $item->product?->category?->name ?? __('Boutique') }}
                                </p>
                                <h2 class="mt-2 font-editorial text-4xl font-light text-[color:var(--espresso)]">
                                    {{ $item->product?->name ?? __('Producto') }}
                                </h2>
                                <p class="mt-3 text-sm text-[color:var(--ink-muted)]">
                                    {{ __('Cantidad') }}: {{ $item->quantity }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-[11px] uppercase tracking-[0.22em] text-[color:var(--ink-faint)]">{{ __('Subtotal') }}</p>
                                <p class="mt-2 text-lg text-[color:var(--gold-dark)]">
                                    ${{ number_format((float) $item->unit_price * (int) $item->quantity, 2) }} MXN
                                </p>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <aside class="space-y-5">
            <div class="shop-panel-dark rounded-[2rem] p-7 text-[color:var(--cream)] sm:p-8">
                <p class="shop-kicker">{{ __('Resumen final') }}</p>
                <h2 class="mt-3 font-editorial text-4xl font-light text-[color:var(--cream)]">{{ __('Datos del pedido') }}</h2>

                <div class="mt-8 space-y-4 text-sm text-[color:rgba(250,246,240,0.68)]">
                    <div class="flex items-center justify-between">
                        <span>{{ __('Total') }}</span>
                        <span class="text-[color:var(--gold-light)]">${{ number_format((float) $order->total, 2) }} MXN</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>{{ __('Estado') }}</span>
                        <span>{{ $order->status }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>{{ __('Pago') }}</span>
                        <span>{{ $order->payment?->payment_method }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>{{ __('Estatus pago') }}</span>
                        <span>{{ $order->payment?->status }}</span>
                    </div>
                </div>
            </div>

            <div class="shop-panel rounded-[2rem] p-7 sm:p-8">
                <p class="shop-kicker">{{ __('Entrega') }}</p>
                <h2 class="mt-3 shop-section-title">{{ __('Direccion registrada') }}</h2>
                <p class="shop-copy mt-5">
                    {{ $order->address?->street }}<br>
                    {{ $order->address?->city }}, {{ $order->address?->state }} {{ $order->address?->postal_code }}<br>
                    {{ $order->address?->country }}
                </p>
                <a href="{{ route('shop') }}" class="shop-btn-primary mt-8 w-full">
                    {{ __('Seguir comprando') }}
                </a>
            </div>
        </aside>
    </section>
</x-layouts::shop>
