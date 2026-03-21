<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl leading-tight text-[color:var(--ink)]">{{ __('Tienda') }}</h2>
            <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Resumen y referencias rápidas de operación') }}</p>
        </div>
    </x-slot>

    <div class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-4">
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Categorías') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($categoriesCount) }}</p>
                </div>
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Productos') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($productsCount) }}</p>
                </div>
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Clientes') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($customersCount) }}</p>
                </div>
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Pedidos') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">{{ number_format($ordersCount) }}</p>
                </div>
                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-5 shadow-sm">
                    <p class="text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Ingresos') }}</p>
                    <p class="mt-2 text-3xl font-semibold text-[color:var(--ink)]">${{ number_format($revenueTotal, 2) }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
                <div class="xl:col-span-2 rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5">
                    <h3 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Referencias rápidas') }}</h3>
                    <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Accesos útiles para gestionar la tienda') }}</p>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                        <a href="{{ route('dashboard') }}" class="rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--cream)] px-4 py-3 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] transition">{{ __('Dashboard Admin') }}</a>
                        <a href="{{ route('shop') }}" class="rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--cream)] px-4 py-3 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] transition">{{ __('Ver Tienda Pública') }}</a>
                        <a href="{{ route('admin.products.index') }}" class="rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--cream)] px-4 py-3 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] transition">{{ __('Gestionar Productos') }}</a>
                        <a href="{{ route('admin.orders.index') }}" class="rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--cream)] px-4 py-3 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] transition">{{ __('Gestionar Pedidos') }}</a>
                    </div>
                </div>

                <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-5">
                    <h3 class="text-base font-semibold text-[color:var(--ink)]">{{ __('Clientes recientes') }}</h3>
                    <div class="mt-4 space-y-2">
                        @forelse ($recentCustomers as $customer)
                            <div class="rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--cream)] px-4 py-3">
                                <p class="text-sm font-semibold text-[color:var(--ink)]">{{ $customer->name }}</p>
                                <p class="text-xs text-[color:var(--ink-muted)]">{{ $customer->email }}</p>
                            </div>
                        @empty
                            <p class="text-sm text-[color:var(--ink-muted)]">{{ __('No hay clientes recientes.') }}</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
