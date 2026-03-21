<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl leading-tight text-[color:var(--ink)]">{{ __('Categorías') }}</h2>
                <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Organiza el catálogo') }}</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="inline-flex items-center rounded-xl border border-[color:var(--gold-dark)] bg-[color:var(--gold)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)]">{{ __('Nueva categoría') }}</a>
        </div>
    </x-slot>

    <div class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto space-y-4">
            @if (session('status'))
                <div class="rounded-2xl border border-[color:rgba(59,109,17,0.25)] bg-[color:var(--success-bg)] px-5 py-4 text-sm font-semibold text-[color:var(--success-text)]">{{ session('status') }}</div>
            @endif

            <form method="GET" class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] p-4 flex flex-wrap items-center gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Buscar categoría/slug" class="w-full md:w-96 rounded-xl border-[color:var(--cream-dark)] text-sm">
                <button class="rounded-xl bg-[color:var(--gold)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)]">{{ __('Filtrar') }}</button>
                <a href="{{ route('admin.categories.index') }}" class="rounded-xl border border-[color:var(--cream-dark)] px-4 py-2 text-sm font-semibold">{{ __('Limpiar') }}</a>
                <a href="{{ route('admin.categories.export', request()->query()) }}" class="rounded-xl border border-[color:var(--gold-dark)] px-4 py-2 text-sm font-semibold">{{ __('Exportar Excel') }}</a>
            </form>

            <div class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-[color:var(--cream-dark)]">
                        <thead class="bg-[color:var(--cream)]">
                            <tr>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Categoría') }}</th>
                                <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Slug') }}</th>
                                <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-[color:var(--ink-muted)]">{{ __('Creada') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[color:var(--cream-dark)]">
                            @forelse ($categories as $category)
                                <tr class="hover:bg-[color:var(--cream)] transition">
                                    <td class="px-5 py-4"><p class="text-sm font-semibold text-[color:var(--ink)]">{{ $category->name }}</p>@if ($category->description)<p class="mt-0.5 text-xs text-[color:var(--ink-muted)]">{{ \Illuminate\Support\Str::limit($category->description, 90) }}</p>@endif</td>
                                    <td class="px-5 py-4 text-sm text-[color:var(--ink-muted)]">{{ $category->slug }}</td>
                                    <td class="px-5 py-4 text-sm text-right text-[color:var(--ink-muted)]">{{ $category->created_at?->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="px-5 py-10 text-center text-sm text-[color:var(--ink-muted)]">{{ __('Aún no hay categorías. Crea la primera para empezar a registrar productos.') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-4 border-t border-[color:var(--cream-dark)] bg-[color:var(--white)]">{{ $categories->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
