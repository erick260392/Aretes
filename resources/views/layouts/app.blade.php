<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Aretes Mich') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>[x-cloak]{display:none !important;}</style>
    </head>
    <body x-data="appShell()" x-init="init()" class="font-sans antialiased bg-[color:var(--cream)] text-[color:var(--ink)]">
        <div class="min-h-screen flex">
            @include('layouts.sidebar')

            <div class="flex-1 ml-0 transition-all duration-300" :class="sidebarCollapsed ? 'sm:ml-20' : 'sm:ml-64'">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-[color:var(--white)] border-b border-[color:var(--cream-dark)]">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            <div class="flex items-start gap-3">
                                <button type="button"
                                    @click="toggleSidebar()"
                                    class="hidden sm:inline-flex items-center justify-center h-10 w-10 rounded-lg border border-[color:var(--cream-dark)] bg-[color:var(--white)] text-[color:var(--ink-muted)] hover:text-[color:var(--ink)] hover:border-[color:var(--gold)] transition"
                                    title="Colapsar/expandir menú">
                                    <svg class="h-5 w-5 transition-transform duration-300" :class="sidebarCollapsed ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M11.78 4.22a.75.75 0 0 1 0 1.06L7.06 10l4.72 4.72a.75.75 0 1 1-1.06 1.06l-5.25-5.25a.75.75 0 0 1 0-1.06l5.25-5.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div class="min-w-0 flex-1">
                                    {{ $header }}
                                </div>
                            </div>
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>

        <script>
            function appShell() {
                return {
                    sidebarCollapsed: false,
                    init() {
                        this.sidebarCollapsed = localStorage.getItem('admin-sidebar-collapsed') === '1';
                    },
                    toggleSidebar() {
                        this.sidebarCollapsed = !this.sidebarCollapsed;
                        localStorage.setItem('admin-sidebar-collapsed', this.sidebarCollapsed ? '1' : '0');
                    },
                };
            }
        </script>
    </body>
</html>
