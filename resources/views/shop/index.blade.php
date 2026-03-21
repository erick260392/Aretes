<x-layouts::shop :title="__('Tienda')">
    <div class="flex items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold">{{ __('Tienda') }}</h1>
            <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Explora productos y genera pedidos con checkout.') }}</p>
        </div>
    </div>

    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @forelse ($products as $product)
            <a href="{{ route('shop.products.show', $product) }}"
                class="group rounded-2xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] p-5 shadow-sm hover:border-[color:var(--gold)] hover:bg-[color:var(--cream)] transition">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-base font-semibold text-[color:var(--ink)] group-hover:text-[color:var(--ink)]">
                            {{ $product->name }}
                        </p>
                        <p class="mt-1 text-sm text-[color:var(--ink-muted)]">ID: {{ $product->id }}</p>
                    </div>
                    <span class="shrink-0 rounded-xl border border-[color:var(--gold-dark)] bg-[color:var(--gold)] px-3 py-1.5 text-sm font-semibold text-[color:var(--ink)]">
                        ${{ number_format((float) $product->price, 2) }}
                    </span>
                </div>

                @if ($product->description)
                    <p class="mt-4 text-sm text-[color:var(--ink-muted)]">
                        {{ \Illuminate\Support\Str::limit($product->description, 110) }}
                    </p>
                @endif

                <div class="mt-4 flex items-center justify-between">
                    <span class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-faint)]">
                        {{ (bool) $product->stock ? __('Disponible') : __('Agotado') }}
                    </span>
                    <span class="text-sm font-semibold text-[color:var(--gold-dark)] group-hover:text-[color:var(--gold)] transition">
                        {{ __('Ver') }} →
                    </span>
                </div>
            </a>
        @empty
            <div class="col-span-full rounded-2xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] p-8 text-center text-sm text-[color:var(--ink-muted)]">
                {{ __('No hay productos todavía.') }}
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $products->links() }}
    </div>
</x-layouts::shop>
