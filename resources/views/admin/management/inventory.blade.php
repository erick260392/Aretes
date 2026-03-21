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
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Total productos') }}</p><p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($totalProducts) }}</p></div>
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Productos activos') }}</p><p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($activeProducts) }}</p></div>
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Sin stock') }}</p><p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($outOfStockProducts) }}</p></div>
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm"><p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Categorías') }}</p><p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($categoriesCount) }}</p></div>
            </div>

            <form method="GET" class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-4 grid grid-cols-1 md:grid-cols-6 gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar producto" class="md:col-span-2 rounded-xl border-[color:var(--cream-dark)] text-sm">
                <select name="category_id" class="rounded-xl border-[color:var(--cream-dark)] text-sm">
                    <option value="">{{ __('Todas las categorías') }}</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) request('category_id') === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                <select name="is_active" class="rounded-xl border-[color:var(--cream-dark)] text-sm">
                    <option value="">{{ __('Activo: Todos') }}</option>
                    <option value="1" @selected(request('is_active') === '1')>{{ __('Activos') }}</option>
                    <option value="0" @selected(request('is_active') === '0')>{{ __('Inactivos') }}</option>
                </select>
                <select name="stock" class="rounded-xl border-[color:var(--cream-dark)] text-sm">
                    <option value="">{{ __('Stock: Todos') }}</option>
                    <option value="1" @selected(request('stock') === '1')>{{ __('Disponible') }}</option>
                    <option value="0" @selected(request('stock') === '0')>{{ __('Agotado') }}</option>
                </select>
                <div class="grid grid-cols-2 gap-2">
                    <input type="number" step="0.01" name="min_price" value="{{ request('min_price') }}" placeholder="Min $" class="rounded-xl border-[color:var(--cream-dark)] text-sm">
                    <input type="number" step="0.01" name="max_price" value="{{ request('max_price') }}" placeholder="Max $" class="rounded-xl border-[color:var(--cream-dark)] text-sm">
                </div>
                <div class="md:col-span-6 flex items-center gap-2">
                    <button class="rounded-xl bg-[color:var(--gold)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)]">{{ __('Filtrar') }}</button>
                    <a href="{{ route('admin.inventory.index') }}" class="rounded-xl border border-[color:var(--cream-dark)] px-4 py-2 text-sm font-semibold">{{ __('Limpiar') }}</a>
                    <a href="{{ route('admin.inventory.export', request()->query()) }}" class="rounded-xl border border-[color:var(--gold-dark)] px-4 py-2 text-sm font-semibold">{{ __('Exportar Excel') }}</a>
                </div>
            </form>

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
                                    <td class="px-5 py-4">@if ((bool) $product->is_active)<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold" style="background: var(--success-bg); color: var(--success-text);">{{ __('Sí') }}</span>@else<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold" style="background: var(--danger-bg); color: var(--danger-text);">{{ __('No') }}</span>@endif</td>
                                    <td class="px-5 py-4">@if ((bool) $product->stock)<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold" style="background: var(--success-bg); color: var(--success-text);">{{ __('Disponible') }}</span>@else<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold" style="background: var(--warning-bg); color: var(--warning-text);">{{ __('Agotado') }}</span>@endif</td>
                                    <td class="px-5 py-4 text-sm font-semibold text-right text-[color:var(--ink)]">${{ number_format((float) $product->price, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="px-5 py-10 text-center text-sm text-[color:var(--ink-muted)]">{{ __('No hay productos para mostrar.') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-4 border-t border-[color:var(--cream-dark)] bg-[color:var(--white)]">{{ $products->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
