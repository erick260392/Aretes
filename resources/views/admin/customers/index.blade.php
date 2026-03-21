<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl leading-tight text-[color:var(--ink)]">{{ __('Clientes') }}</h2>
                <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Usuarios con rol customer') }}</p>
            </div>
            <a href="{{ route('admin.customers.create') }}" class="inline-flex items-center rounded-xl border border-[color:var(--gold-dark)] bg-[color:var(--gold)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)]">{{ __('Nuevo cliente') }}</a>
        </div>
    </x-slot>

    <div class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-4">
            @if (session('status'))
                <div class="rounded-2xl border border-[color:rgba(59,109,17,0.25)] bg-[color:var(--success-bg)] px-5 py-4 text-sm font-semibold text-[color:var(--success-text)]">{{ session('status') }}</div>
            @endif

            <form method="GET" class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-4 grid grid-cols-1 md:grid-cols-5 gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar cliente" class="md:col-span-2 rounded-xl border-[color:var(--cream-dark)] text-sm">
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="rounded-xl border-[color:var(--cream-dark)] text-sm">
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="rounded-xl border-[color:var(--cream-dark)] text-sm">
                <div class="flex items-center gap-2">
                    <button class="rounded-xl bg-[color:var(--gold)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)]">{{ __('Filtrar') }}</button>
                    <a href="{{ route('admin.customers.index') }}" class="rounded-xl border border-[color:var(--cream-dark)] px-4 py-2 text-sm font-semibold">{{ __('Limpiar') }}</a>
                </div>
                <div class="md:col-span-5">
                    <a href="{{ route('admin.customers.export', request()->query()) }}" class="inline-flex rounded-xl border border-[color:var(--gold-dark)] px-4 py-2 text-sm font-semibold">{{ __('Exportar Excel') }}</a>
                </div>
            </form>

            <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[color:var(--cream-dark)]">
                        <thead class="bg-[color:var(--cream)]">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Nombre') }}</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Email') }}</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Registro') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[color:var(--cream-dark)]">
                            @forelse ($customers as $customer)
                                <tr class="hover:bg-[color:var(--cream)] transition">
                                    <td class="px-5 py-4 text-sm font-semibold text-[color:var(--ink)]">{{ $customer->name }}</td>
                                    <td class="px-5 py-4 text-sm text-[color:var(--ink-muted)]">{{ $customer->email }}</td>
                                    <td class="px-5 py-4 text-sm text-right text-[color:var(--ink-muted)]">{{ $customer->created_at?->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-5 py-10 text-center text-sm text-[color:var(--ink-muted)]">{{ __('No hay clientes para mostrar.') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-4 border-t border-[color:var(--cream-dark)] bg-[color:var(--white)]">{{ $customers->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
