<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl leading-tight text-[color:var(--ink)]">{{ __('Inventario') }}</h2>
            <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Estado actual del catálogo') }}</p>
        </div>
    </x-slot>

    <div class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Total productos') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($totalProducts) }}</p>
                </div>
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Productos activos') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($activeProducts) }}</p>
                </div>
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Sin stock') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($outOfStockProducts) }}</p>
                </div>
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Categorías') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($categoriesCount) }}</p>
                </div>
            </div>

            <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[color:var(--cream-dark)]">
                        <thead class="bg-[color:var(--cream)]">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Producto') }}</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Categoría') }}</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Activo') }}</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Stock') }}</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Precio') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[color:var(--cream-dark)]">
                            @forelse ($products as $product)
                                <tr class="hover:bg-[color:var(--cream)] transition">
                                    <td class="px-5 py-4 text-sm font-semibold text-[color:var(--ink)]">{{ $product->name }}</td>
                                    <td class="px-5 py-4 text-sm text-[color:var(--ink-muted)]">{{ $product->category?->name ?? __('Sin categoría') }}</td>
                                    <td class="px-5 py-4">
                                        @if ((bool) $product->is_active)
                                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold" style="background: var(--success-bg); color: var(--success-text);">{{ __('Sí') }}</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold" style="background: var(--danger-bg); color: var(--danger-text);">{{ __('No') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        @if ((bool) $product->stock)
                                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold" style="background: var(--success-bg); color: var(--success-text);">{{ __('Disponible') }}</span>
                                        @else
                                            <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold" style="background: var(--warning-bg); color: var(--warning-text);">{{ __('Agotado') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-sm font-semibold text-right text-[color:var(--ink)]">${{ number_format((float) $product->price, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-5 py-10 text-center text-sm text-[color:var(--ink-muted)]">{{ __('No hay productos para mostrar.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-5 py-4 border-t border-[color:var(--cream-dark)] bg-[color:var(--white)]">
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
