<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl leading-tight text-[color:var(--ink)]">{{ __('Crear cliente') }}</h2>
            <p class="mt-1 text-sm text-[color:var(--ink-muted)]">{{ __('Genera una cuenta con rol customer') }}</p>
        </div>
    </x-slot>

    <div class="px-4 py-8 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <form method="POST" action="{{ route('admin.customers.store') }}"
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
                    <label class="block text-sm font-semibold text-[color:var(--ink)]" for="email">{{ __('Email') }}</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}" required
                        class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] placeholder:text-[color:var(--ink-faint)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]" />
                    @error('email')
                        <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-[color:var(--ink)]" for="password">{{ __('Contraseña') }}</label>
                        <input id="password" name="password" type="password" required
                            class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] placeholder:text-[color:var(--ink-faint)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]" />
                        @error('password')
                            <p class="mt-2 text-sm" style="color: var(--danger-text);">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[color:var(--ink)]" for="password_confirmation">{{ __('Confirmar contraseña') }}</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                            class="mt-2 block w-full rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm text-[color:var(--ink)] placeholder:text-[color:var(--ink-faint)] focus:outline-none focus:ring-2 focus:ring-[color:rgba(201,168,76,0.35)]" />
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-2">
                    <a href="{{ route('admin.customers.index') }}"
                        class="inline-flex items-center rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-4 py-2 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] hover:bg-[color:var(--cream)] transition">
                        {{ __('Cancelar') }}
                    </a>
                    <button type="submit"
                        class="inline-flex items-center rounded-xl border border-[color:var(--gold-dark)] bg-[color:var(--gold)] px-5 py-2 text-sm font-semibold text-[color:var(--ink)] hover:bg-[color:var(--gold-dark)] hover:text-[color:var(--white)] transition">
                        {{ __('Guardar cliente') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

