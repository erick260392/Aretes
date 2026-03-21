<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Aretes Mich') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[color:var(--cream)] text-[color:var(--ink)]">
        <header class="sticky top-0 z-20 border-b border-[color:var(--cream-dark)] bg-[color:rgba(255,253,249,0.86)] backdrop-blur">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between gap-3">
                    <a href="{{ route('shop') }}" class="flex items-center gap-3">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl bg-[color:var(--gold)] text-[color:var(--ink)] font-bold">
                            A
                        </span>
                        <span class="text-sm font-semibold tracking-wide">{{ config('app.name', 'Aretes Mich') }}</span>
                    </a>

                    <nav class="flex items-center gap-2">
                        <a href="{{ route('shop') }}"
                            class="rounded-xl px-3 py-2 text-sm font-semibold text-[color:var(--ink-muted)] hover:text-[color:var(--ink)] hover:bg-[color:var(--cream)] transition">
                            {{ __('Tienda') }}
                        </a>

                        @auth
                            <a href="{{ route('cart.index') }}"
                                class="rounded-xl border border-[color:var(--cream-dark)] bg-[color:var(--white)] px-3 py-2 text-sm font-semibold text-[color:var(--ink)] hover:border-[color:var(--gold)] hover:bg-[color:var(--cream)] transition">
                                {{ __('Carrito') }}
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="rounded-xl px-3 py-2 text-sm font-semibold text-[color:var(--ink-muted)] hover:text-[color:var(--ink)] hover:bg-[color:var(--cream)] transition">
                                    {{ __('Salir') }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}"
                                class="rounded-xl border border-[color:var(--gold-dark)] bg-[color:var(--gold)] px-3 py-2 text-sm font-semibold text-[color:var(--ink)] hover:bg-[color:var(--gold-dark)] hover:text-[color:var(--white)] transition">
                                {{ __('Entrar') }}
                            </a>
                        @endauth
                    </nav>
                </div>
            </div>
        </header>

        <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-[color:rgba(59,109,17,0.25)] bg-[color:var(--success-bg)] px-5 py-4 text-sm font-semibold text-[color:var(--success-text)]">
                    {{ session('status') }}
                </div>
            @endif

            {{ $slot }}
        </main>
    </body>
</html>

