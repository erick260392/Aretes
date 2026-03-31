<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Aretes Mich') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Jost:wght@300;400;500;600&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-[color:var(--cream)] text-[color:var(--ink)]">
        @php
            $shopCartCount = auth()->check()
                ? \App\Models\CartItem::query()
                    ->whereHas('cart', fn ($query) => $query->where('user_id', auth()->id()))
                    ->sum('quantity')
                : 0;
        @endphp

        <header class="sticky top-0 z-20 border-b border-[color:rgba(201,168,76,0.22)] bg-[color:rgba(250,246,240,0.84)] backdrop-blur-xl">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex min-h-[84px] items-center justify-between gap-4">
                    <a href="{{ route('shop') }}" class="flex items-center gap-3">
                        <span class="font-editorial text-3xl font-light tracking-[0.18em] text-[color:var(--espresso)]">
                            Aretes <span class="italic text-[color:var(--gold)]">Mich</span>
                        </span>
                    </a>

                    <nav class="hidden items-center gap-8 md:flex">
                        <a href="{{ route('shop') }}"
                            class="text-[11px] font-medium uppercase tracking-[0.28em] text-[color:var(--ink-muted)] transition hover:text-[color:var(--gold)] {{ request()->routeIs('shop') ? 'text-[color:var(--gold-dark)]' : '' }}">
                            {{ __('Inicio') }}
                        </a>
                        <a href="{{ route('shop') }}#categorias"
                            class="text-[11px] font-medium uppercase tracking-[0.28em] text-[color:var(--ink-muted)] transition hover:text-[color:var(--gold)]">
                            {{ __('Categorias') }}
                        </a>
                        <a href="{{ route('shop') }}#productos"
                            class="text-[11px] font-medium uppercase tracking-[0.28em] text-[color:var(--ink-muted)] transition hover:text-[color:var(--gold)]">
                            {{ __('Novedades') }}
                        </a>
                        <a href="{{ route('shop') }}#historia"
                            class="text-[11px] font-medium uppercase tracking-[0.28em] text-[color:var(--ink-muted)] transition hover:text-[color:var(--gold)]">
                            {{ __('Sobre Mich') }}
                        </a>
                        <a href="{{ route('shop') }}#contacto"
                            class="text-[11px] font-medium uppercase tracking-[0.28em] text-[color:var(--ink-muted)] transition hover:text-[color:var(--gold)]">
                            {{ __('Contacto') }}
                        </a>
                    </nav>

                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ route('cart.index') }}"
                                class="group relative inline-flex h-11 w-11 items-center justify-center rounded-full border border-[color:rgba(201,168,76,0.28)] bg-[color:rgba(255,253,249,0.9)] text-[color:var(--espresso)] transition hover:border-[color:var(--gold)] hover:bg-[color:var(--white)]"
                                aria-label="{{ __('Carrito') }}">
                                <span class="text-lg">👜</span>
                                @if ($shopCartCount > 0)
                                    <span class="absolute -right-1 -top-1 inline-flex h-5 min-w-[20px] items-center justify-center rounded-full bg-[color:var(--gold)] px-1 text-[10px] font-semibold text-[color:var(--white)]">
                                        {{ $shopCartCount }}
                                    </span>
                                @endif
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="inline-flex items-center rounded-full border border-transparent px-4 py-2 text-[11px] font-medium uppercase tracking-[0.24em] text-[color:var(--ink-muted)] transition hover:border-[color:rgba(201,168,76,0.25)] hover:text-[color:var(--gold)]">
                                    {{ __('Salir') }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center rounded-full border border-[color:var(--espresso)] bg-[color:var(--espresso)] px-5 py-2.5 text-[11px] font-medium uppercase tracking-[0.24em] text-[color:var(--cream)] transition hover:border-[color:var(--gold)] hover:bg-[color:var(--gold)]">
                                    {{ __('Entrar') }}
                                </a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <main>
            @if (session('status'))
                <div class="mx-auto mt-6 max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="rounded-2xl border border-[color:rgba(59,109,17,0.25)] bg-[color:var(--success-bg)] px-5 py-4 text-sm font-semibold text-[color:var(--success-text)]">
                        {{ session('status') }}
                    </div>
                </div>
            @endif

            <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

        <footer class="mt-0 bg-[color:var(--espresso)] text-[color:var(--cream)]">
            <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-[1.6fr_1fr_1fr_1fr] lg:px-8">
                <div>
                    <p class="font-editorial text-4xl font-light tracking-[0.12em] text-[color:var(--cream)]">
                        Aretes <span class="italic text-[color:var(--gold)]">Mich</span>
                    </p>
                    <p class="mt-4 max-w-sm text-sm leading-7 text-[color:rgba(250,246,240,0.58)]">
                        {{ __('Joyeria artesanal con una estetica calida, femenina y contemporanea. Piezas ligeras hechas para contar historias reales.') }}
                    </p>
                </div>

                <div>
                    <p class="text-[11px] font-medium uppercase tracking-[0.3em] text-[color:var(--gold)]">{{ __('Mapa') }}</p>
                    <div class="mt-5 flex flex-col gap-3 text-sm text-[color:rgba(250,246,240,0.58)]">
                        <a href="{{ route('shop') }}" class="transition hover:text-[color:var(--gold)]">{{ __('Inicio') }}</a>
                        <a href="{{ route('shop') }}#categorias" class="transition hover:text-[color:var(--gold)]">{{ __('Categorias') }}</a>
                        <a href="{{ route('shop') }}#productos" class="transition hover:text-[color:var(--gold)]">{{ __('Productos') }}</a>
                    </div>
                </div>

                <div>
                    <p class="text-[11px] font-medium uppercase tracking-[0.3em] text-[color:var(--gold)]">{{ __('Marca') }}</p>
                    <div class="mt-5 flex flex-col gap-3 text-sm text-[color:rgba(250,246,240,0.58)]">
                        <a href="{{ route('shop') }}#historia" class="transition hover:text-[color:var(--gold)]">{{ __('Historia de Mich') }}</a>
                        <a href="{{ route('shop') }}#contacto" class="transition hover:text-[color:var(--gold)]">{{ __('Contacto') }}</a>
                        <a href="{{ route('cart.index') }}" class="transition hover:text-[color:var(--gold)]">{{ __('Carrito') }}</a>
                    </div>
                </div>

                <div>
                    <p class="text-[11px] font-medium uppercase tracking-[0.3em] text-[color:var(--gold)]">{{ __('Contacto') }}</p>
                    <div class="mt-5 flex flex-col gap-3 text-sm text-[color:rgba(250,246,240,0.58)]">
                        <span>hola@aretesmich.mx</span>
                        <span>Instagram / @aretesmich</span>
                        <span>WhatsApp / +52 222 000 0000</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-[color:rgba(232,213,163,0.12)] bg-[color:rgba(0,0,0,0.18)]">
                <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-4 text-[11px] uppercase tracking-[0.18em] text-[color:rgba(250,246,240,0.34)] sm:px-6 lg:flex-row lg:items-center lg:justify-between lg:px-8">
                    <p>{{ __('Aretes Mich Atelier') }}</p>
                    <p>{{ __('Diseno artesanal con acentos dorados') }}</p>
                </div>
            </div>
        </footer>
    </body>
</html>
