<x-layouts::shop :title="$product->name">
    @php
        $productImage = $product->images->first();
        $productImageUrl = $productImage
            ? (\Illuminate\Support\Str::startsWith($productImage->url, ['http://', 'https://', '/']) ? $productImage->url : asset($productImage->url))
            : null;
    @endphp

    <section class="grid gap-8 lg:grid-cols-[1.08fr_0.92fr]">
        <div class="space-y-6">
            <div class="shop-card-product p-4 sm:p-6">
                <div class="relative overflow-hidden rounded-[1.7rem] bg-[linear-gradient(135deg,#f8efe2,#e4cda8)]">
                    <div class="absolute inset-0 bg-[url('/images/logo_aretes_mich_1.svg')] bg-center bg-no-repeat opacity-[0.06]"></div>
                    <div class="absolute left-5 top-5 z-10 inline-flex items-center rounded-full bg-[color:var(--espresso)] px-4 py-2 text-[10px] font-medium uppercase tracking-[0.24em] text-[color:var(--cream)]">
                        {{ $product->category?->name ?? __('Coleccion principal') }}
                    </div>

                    <div class="flex min-h-[540px] items-center justify-center px-8 py-14">
                        @if ($productImageUrl)
                            <img src="{{ $productImageUrl }}" alt="{{ $product->name }}" class="max-h-[420px] w-auto object-contain drop-shadow-[0_20px_40px_rgba(44,24,16,0.18)]">
                        @else
                            <div class="flex h-56 w-56 items-center justify-center rounded-full border border-[color:rgba(44,24,16,0.08)] bg-[color:rgba(255,255,255,0.42)] shadow-[0_20px_50px_rgba(44,24,16,0.12)]">
                                <span class="text-8xl">{{ (bool) $product->stock ? '✦' : '○' }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if ($relatedProducts->isNotEmpty())
                <div class="shop-panel rounded-[2rem] p-6 sm:p-8">
                    <div class="flex items-end justify-between gap-4">
                        <div>
                            <p class="shop-kicker">{{ __('Tambien te puede gustar') }}</p>
                            <h2 class="mt-3 shop-section-title">{{ __('Piezas relacionadas') }}</h2>
                        </div>
                    </div>

                    <div class="mt-8 grid gap-5 md:grid-cols-3">
                        @foreach ($relatedProducts as $relatedProduct)
                            @php
                                $relatedImage = $relatedProduct->images->first();
                                $relatedImageUrl = $relatedImage
                                    ? (\Illuminate\Support\Str::startsWith($relatedImage->url, ['http://', 'https://', '/']) ? $relatedImage->url : asset($relatedImage->url))
                                    : null;
                            @endphp
                            <article class="rounded-[1.6rem] border border-[color:rgba(201,168,76,0.12)] bg-white p-3 shadow-[0_16px_40px_rgba(44,24,16,0.06)]">
                                <a href="{{ route('shop.products.show', $relatedProduct) }}" class="block overflow-hidden rounded-[1.25rem] bg-[linear-gradient(135deg,#f9f2e8,#ead7bc)]">
                                    <div class="flex h-48 items-center justify-center px-5 py-5">
                                        @if ($relatedImageUrl)
                                            <img src="{{ $relatedImageUrl }}" alt="{{ $relatedProduct->name }}" class="max-h-36 w-auto object-contain">
                                        @else
                                            <span class="text-5xl">{{ $loop->iteration === 1 ? '✨' : ($loop->iteration === 2 ? '🌸' : '⭐') }}</span>
                                        @endif
                                    </div>
                                </a>
                                <div class="px-2 pb-2 pt-4">
                                    <p class="text-[10px] uppercase tracking-[0.24em] text-[color:var(--gold)]">
                                        {{ $relatedProduct->category?->name ?? __('Boutique') }}
                                    </p>
                                    <h3 class="mt-2 font-editorial text-2xl font-light text-[color:var(--espresso)]">
                                        {{ $relatedProduct->name }}
                                    </h3>
                                    <p class="mt-2 text-sm text-[color:var(--gold-dark)]">
                                        ${{ number_format((float) $relatedProduct->price, 2) }} MXN
                                    </p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div class="space-y-6">
            <div class="shop-panel rounded-[2rem] p-7 sm:p-8">
                <p class="shop-kicker">{{ __('Detalle de pieza') }}</p>
                <div class="mt-4 flex flex-wrap items-start justify-between gap-4">
                    <div class="min-w-0">
                        <h1 class="shop-page-title !text-[3.6rem]">{{ $product->name }}</h1>
                        <p class="mt-3 text-[11px] uppercase tracking-[0.28em] text-[color:var(--ink-faint)]">
                            {{ $product->slug }}
                        </p>
                    </div>
                    <span class="inline-flex items-center rounded-full border border-[color:rgba(201,168,76,0.22)] bg-[color:rgba(255,253,249,0.86)] px-5 py-3 text-sm uppercase tracking-[0.18em] text-[color:var(--gold-dark)]">
                        ${{ number_format((float) $product->price, 2) }} MXN
                    </span>
                </div>

                <p class="shop-copy mt-6">
                    {{ $product->description ?: __('Una pieza con acento delicado y presencia elegante, pensada para acompañar looks cotidianos o momentos especiales.') }}
                </p>

                <div class="mt-7 flex flex-wrap gap-2">
                    @if ($product->material)
                        <span class="inline-flex items-center rounded-full border border-[color:rgba(201,168,76,0.14)] bg-[color:rgba(255,253,249,0.8)] px-4 py-2 text-[10px] uppercase tracking-[0.22em] text-[color:var(--ink-muted)]">
                            {{ __('Material') }} · {{ $product->material }}
                        </span>
                    @endif
                    @if ($product->color)
                        <span class="inline-flex items-center rounded-full border border-[color:rgba(201,168,76,0.14)] bg-[color:rgba(255,253,249,0.8)] px-4 py-2 text-[10px] uppercase tracking-[0.22em] text-[color:var(--ink-muted)]">
                            {{ __('Color') }} · {{ $product->color }}
                        </span>
                    @endif
                    <span class="inline-flex items-center rounded-full px-4 py-2 text-[10px] uppercase tracking-[0.22em] {{ (bool) $product->stock ? 'bg-[color:var(--success-bg)] text-[color:var(--success-text)]' : 'bg-[color:var(--warning-bg)] text-[color:var(--warning-text)]' }}">
                        {{ (bool) $product->stock ? __('Disponible') : __('Agotado') }}
                    </span>
                </div>
            </div>

            <div class="shop-panel-dark rounded-[2rem] p-7 text-[color:var(--cream)] sm:p-8">
                <p class="shop-kicker">{{ __('Compra ahora') }}</p>
                <h2 class="mt-3 font-editorial text-4xl font-light leading-none text-[color:var(--cream)]">
                    {{ __('Lleva esta pieza a tu carrito') }}
                </h2>
                <p class="mt-4 text-sm leading-8 text-[color:rgba(250,246,240,0.6)]">
                    {{ __('Mantuvimos la interfaz ligera, pero ahora con mejor contraste, jerarquía y un bloque de compra que sí se siente protagonista.') }}
                </p>

                @auth
                    <form method="POST" action="{{ route('cart.items.store') }}" class="mt-8 space-y-5">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div>
                            <label class="mb-3 block text-[11px] font-medium uppercase tracking-[0.24em] text-[color:rgba(250,246,240,0.62)]" for="quantity">
                                {{ __('Cantidad') }}
                            </label>
                            <input id="quantity" name="quantity" type="number" min="1" max="99" value="{{ old('quantity', 1) }}" class="shop-input bg-[color:rgba(255,253,249,0.94)]" />
                            @error('quantity')
                                <p class="mt-3 text-sm text-[color:#f0b8b8]">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="shop-btn-primary w-full" @disabled(!(bool) $product->stock)>
                            {{ (bool) $product->stock ? __('Agregar al carrito') : __('Producto agotado') }}
                        </button>

                        <a href="{{ route('cart.index') }}" class="shop-btn-secondary w-full">
                            {{ __('Ver carrito') }}
                        </a>
                    </form>
                @else
                    <div class="mt-7 rounded-[1.4rem] border border-[color:rgba(232,213,163,0.14)] bg-[color:rgba(255,255,255,0.06)] px-5 py-4 text-sm text-[color:rgba(250,246,240,0.7)]">
                        {{ __('Inicia sesión para agregar al carrito y continuar con tu compra.') }}
                    </div>
                    <a href="{{ route('login') }}" class="shop-btn-primary mt-6 w-full">
                        {{ __('Entrar') }}
                    </a>
                @endauth
            </div>
        </div>
    </section>
</x-layouts::shop>
