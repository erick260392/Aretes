<x-layouts::shop :title="$product->name">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 rounded-2xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] p-6 shadow-sm">
            <div class="flex items-start justify-between gap-3">
                <div class="min-w-0">
                    <h1 class="truncate text-2xl font-semibold text-[color:var(--ink)]">{{ $product->name }}</h1>
                    <p class="mt-1 text-sm text-[color:var(--ink-muted)]">Slug: {{ $product->slug }}</p>
                </div>

                <span class="shrink-0 rounded-xl border border-[color:var(--gold-dark)] bg-[color:var(--gold)] px-3 py-1.5 text-sm font-semibold text-[color:var(--ink)]">
                    ${{ number_format((float) $product->price, 2) }}
                </span>
            </div>

            <div class="mt-5">
                <p class="text-sm text-[color:var(--ink-muted)]">{{ $product->description ?: __('Sin descripción.') }}</p>
            </div>

            <div class="mt-5 flex flex-wrap items-center gap-2">
                @if ($product->material)
                    <span class="rounded-full bg-[color:var(--cream)] px-3 py-1 text-xs font-semibold text-[color:var(--ink-muted)]">
                        {{ __('Material') }}: {{ $product->material }}
                    </span>
                @endif
                @if ($product->color)
                    <span class="rounded-full bg-[color:var(--cream)] px-3 py-1 text-xs font-semibold text-[color:var(--ink-muted)]">
                        {{ __('Color') }}: {{ $product->color }}
                    </span>
                @endif
                <span class="rounded-full px-3 py-1 text-xs font-semibold"
                    style="background: {{ (bool) $product->stock ? 'var(--success-bg)' : 'var(--warning-bg)' }}; color: {{ (bool) $product->stock ? 'var(--success-text)' : 'var(--warning-text)' }};">
                    {{ (bool) $product->stock ? __('Disponible') : __('Agotado') }}
                </span>
            </div>
        </div>

        <div class="rounded-2xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] p-6 shadow-sm">
            <h2 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Generar pedido') }}</h2>
            <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Agrega al carrito y pasa a checkout.') }}</p>

            @auth
                <form method="POST" action="{{ route('cart.items.store') }}" class="mt-5 space-y-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">

                    <div>
                        <label class="block text-sm font-semibold text-[color:var(--ink)]" for="quantity">{{ __('Cantidad') }}</label>
                        <input id="quantity" name="quantity" type="number" min="1" max="99" value="{{ old('quantity', 1) }}"
                            class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]" />
                        @error('quantity')
                            <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="inline-flex w-full items-center justify-center rounded-xl border border-[color:var(--gold-dark)] bg-[color:var(--gold)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)] hover:bg-[color:var(--gold-dark)] hover:text-[color:var(--white)] transition">
                        {{ __('Agregar al carrito') }}
                    </button>

                    <a href="{{ route('cart.index') }}"
                        class="inline-flex w-full items-center justify-center rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] hover:bg-[color:var(--cream)] transition">
                        {{ __('Ver carrito') }}
                    </a>
                </form>
            @else
                <div class="mt-5 rounded-xl border border-[color:rgba(133,79,11,0.25)] bg-[color:var(--warning-bg)] px-4 py-3 text-sm font-semibold text-[color:var(--warning-text)]">
                    {{ __('Inicia sesión para agregar al carrito y generar pedidos.') }}
                </div>
                <a href="{{ route('login') }}"
                    class="mt-4 inline-flex w-full items-center justify-center rounded-xl border border-[color:var(--gold-dark)] bg-[color:var(--gold)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)] hover:bg-[color:var(--gold-dark)] hover:text-[color:var(--white)] transition">
                    {{ __('Entrar') }}
                </a>
            @endauth
        </div>
    </div>
</x-layouts::shop>
