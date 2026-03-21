<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl leading-tight text-[color:var(--ink)]">{{ __('Registrar producto') }}</h2>
            <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Crea un producto para el catálogo') }}</p>
        </div>
    </x-slot>

    <div class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto space-y-4">
            @if ($categories->isEmpty())
                <div class="rounded-2xl border border-[color:rgba(133,79,11,0.25)] bg-[color:var(--warning-bg)] px-5 py-4 text-sm font-semibold text-[color:var(--warning-text)]">
                    {{ __('Primero crea al menos una categoría para poder registrar productos.') }}
                    <a href="{{ route('admin.categories.create') }}" class="underline font-bold">
                        {{ __('Crear categoría') }}
                    </a>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.products.store') }}"
                class="rounded-2xl bg-[color:var(--white)] border border-[color:var(--cream-dark)] shadow-sm p-6 space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-[color:var(--ink)]" for="name">{{ __('Nombre') }}</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required
                        class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] placeholder:text-[color:var(--ink-faint)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]" />
                    @error('name')
                        <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[color:var(--ink)]" for="category_id">{{ __('Categoría') }}</label>
                    <select id="category_id" name="category_id" required @disabled($categories->isEmpty())
                        class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)] disabled:opacity-60">
                        <option value="">{{ __('Selecciona una categoría') }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected((string) old('category_id') === (string) $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-[color:var(--ink)]" for="price">{{ __('Precio') }}</label>
                        <input id="price" name="price" type="number" step="0.01" min="0" value="{{ old('price') }}" required
                            class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] placeholder:text-[color:var(--ink-faint)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]" />
                        @error('price')
                            <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[color:var(--ink)]" for="material">{{ __('Material (opcional)') }}</label>
                        <input id="material" name="material" type="text" value="{{ old('material') }}"
                            class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] placeholder:text-[color:var(--ink-faint)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]" />
                        @error('material')
                            <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-[color:var(--ink)]" for="color">{{ __('Color (opcional)') }}</label>
                        <input id="color" name="color" type="text" value="{{ old('color') }}"
                            class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] placeholder:text-[color:var(--ink-faint)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]" />
                        @error('color')
                            <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3 pt-8">
                        <input id="stock" name="stock" type="checkbox" value="1" @checked(old('stock', true))
                            class="h-5 w-5 rounded border-[color:var(--cream-dark)] text-[color:var(--gold)] focus:ring-[color:rgba(201,168,76,0.35)]" />
                        <label for="stock" class="text-sm font-semibold text-[color:var(--ink)]">{{ __('Disponible (en stock)') }}</label>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <input id="is_active" name="is_active" type="checkbox" value="1" @checked(old('is_active', true))
                        class="h-5 w-5 rounded border-[color:var(--cream-dark)] text-[color:var(--gold)] focus:ring-[color:rgba(201,168,76,0.35)]" />
                    <label for="is_active" class="text-sm font-semibold text-[color:var(--ink)]">{{ __('Activo (visible en catálogo)') }}</label>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[color:var(--ink)]" for="description">{{ __('Descripción (opcional)') }}</label>
                    <textarea id="description" name="description" rows="5"
                        class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] placeholder:text-[color:var(--ink-faint)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('admin.products.index') }}"
                        class="inline-flex items-center rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] hover:bg-[color:var(--cream)] transition">
                        {{ __('Cancelar') }}
                    </a>
                    <button type="submit" @disabled($categories->isEmpty())
                        class="inline-flex items-center rounded-xl border border-[color:var(--gold-dark)] bg-[color:var(--gold)] px-5 py-2 text-sm font-semibold text-[color:var(--ink)] hover:bg-[color:var(--gold-dark)] hover:text-[color:var(--white)] transition disabled:opacity-60">
                        {{ __('Guardar producto') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

