@php
    $baseLink = 'group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition';
    $activeLink = 'bg-[color:rgba(201,168,76,0.18)] text-[color:var(--gold-light)] ring-1 ring-[color:rgba(201,168,76,0.28)]';
    $inactiveLink = 'text-[color:var(--sidebar-muted)] hover:bg-[color:rgba(255,253,249,0.06)] hover:text-[color:var(--white)]';
@endphp

<nav class="fixed inset-y-0 left-0 hidden sm:flex sm:flex-col bg-[color:var(--sidebar-bg)] border-r border-[color:var(--sidebar-border)] transition-all duration-300 z-20"
    :class="sidebarCollapsed ? 'w-20' : 'w-64'">
    <div class="flex items-center h-16 px-3 border-b border-[color:var(--sidebar-border)]" :class="sidebarCollapsed ? 'justify-center' : 'justify-between'">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center" title="Dashboard">
            <x-application-logo class="h-10 w-auto" />
        </a>

        <button type="button"
            @click="toggleSidebar()"
            x-show="!sidebarCollapsed"
            x-cloak
            class="inline-flex items-center justify-center h-8 w-8 rounded-lg text-[color:var(--sidebar-muted)] hover:text-[color:var(--white)] hover:bg-[color:rgba(255,253,249,0.06)] transition"
            title="Colapsar menú">
            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M11.78 4.22a.75.75 0 0 1 0 1.06L7.06 10l4.72 4.72a.75.75 0 1 1-1.06 1.06l-5.25-5.25a.75.75 0 0 1 0-1.06l5.25-5.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <div class="mt-4 px-2 space-y-1 flex-1 overflow-y-auto">
        @if (auth()->user()?->isAdmin())
            <h2 class="mt-4 px-2 text-xs font-semibold text-[color:var(--ink-faint)] uppercase tracking-wider" x-show="!sidebarCollapsed" x-cloak>Principal</h2>

            <a href="{{ route('dashboard') }}"
                title="Dashboard"
                class="{{ $baseLink }} {{ request()->routeIs('dashboard') ? $activeLink : $inactiveLink }}"
                :class="sidebarCollapsed ? 'justify-center' : ''">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10.5 2.25a.75.75 0 0 0-1 0l-7 6.5a.75.75 0 0 0 1.02 1.1L4.5 8.94v7.31c0 .83.67 1.5 1.5 1.5H8.5v-5a1.5 1.5 0 0 1 3 0v5H14a1.5 1.5 0 0 0 1.5-1.5V8.94l.98.9a.75.75 0 1 0 1.02-1.09l-7-6.5Z" />
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak>Dashboard</span>
            </a>

            <a href="{{ route('admin.orders.index') }}"
                title="Pedidos"
                class="{{ $baseLink }} {{ request()->routeIs('admin.orders.*') ? $activeLink : $inactiveLink }}"
                :class="sidebarCollapsed ? 'justify-center' : ''">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M3.5 3.25A2.25 2.25 0 0 0 1.25 5.5v9A2.25 2.25 0 0 0 3.5 16.75h13A2.25 2.25 0 0 0 18.75 14.5v-9A2.25 2.25 0 0 0 16.5 3.25h-13ZM4.75 7a.75.75 0 0 1 .75-.75h9a.75.75 0 0 1 0 1.5h-9A.75.75 0 0 1 4.75 7Zm0 3.5a.75.75 0 0 1 .75-.75h5a.75.75 0 0 1 0 1.5h-5a.75.75 0 0 1-.75-.75Z" />
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak>Pedidos</span>
            </a>

            <a href="{{ route('admin.products.index') }}"
                title="Productos"
                class="{{ $baseLink }} {{ request()->routeIs('admin.products.*') ? $activeLink : $inactiveLink }}"
                :class="sidebarCollapsed ? 'justify-center' : ''">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M3.25 5.5A2.25 2.25 0 0 1 5.5 3.25h9A2.25 2.25 0 0 1 16.75 5.5v9a2.25 2.25 0 0 1-2.25 2.25h-9A2.25 2.25 0 0 1 3.25 14.5v-9Zm3 .25a.75.75 0 0 0 0 1.5h7.5a.75.75 0 0 0 0-1.5h-7.5Zm0 3.5a.75.75 0 0 0 0 1.5h4.5a.75.75 0 0 0 0-1.5h-4.5Z" />
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak>Productos</span>
            </a>

            <a href="{{ route('admin.categories.index') }}"
                title="Categorías"
                class="{{ $baseLink }} {{ request()->routeIs('admin.categories.*') ? $activeLink : $inactiveLink }}"
                :class="sidebarCollapsed ? 'justify-center' : ''">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M2.75 5.75A2.75 2.75 0 0 1 5.5 3h2.629c.73 0 1.43.29 1.946.805l.62.62c.234.235.553.367.885.367H14.5a2.75 2.75 0 0 1 2.75 2.75v6.708A2.75 2.75 0 0 1 14.5 17h-9A2.75 2.75 0 0 1 2.75 14.25V5.75Z" />
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak>Categorías</span>
            </a>

            <a href="{{ route('admin.customers.index') }}"
                title="Clientes"
                class="{{ $baseLink }} {{ request()->routeIs('admin.customers.*') ? $activeLink : $inactiveLink }}"
                :class="sidebarCollapsed ? 'justify-center' : ''">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10 2.5a3.75 3.75 0 1 0 0 7.5 3.75 3.75 0 0 0 0-7.5ZM4.25 15a4.75 4.75 0 0 1 9.5 0v.75c0 .414-.336.75-.75.75H5a.75.75 0 0 1-.75-.75V15Zm10.833-5.445a3 3 0 1 1 2.833 5.287.75.75 0 0 1-.708-1.323 1.5 1.5 0 1 0-1.416-2.645.75.75 0 1 1-.709-1.319Z" />
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak>Clientes</span>
            </a>

            <h2 class="mt-6 px-2 text-xs font-semibold text-[color:var(--ink-faint)] uppercase tracking-wider" x-show="!sidebarCollapsed" x-cloak>Gestión</h2>

            <a href="{{ route('admin.inventory.index') }}"
                title="Inventario"
                class="{{ $baseLink }} {{ request()->routeIs('admin.inventory.*') ? $activeLink : $inactiveLink }}"
                :class="sidebarCollapsed ? 'justify-center' : ''">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M4.5 3.25A2.25 2.25 0 0 0 2.25 5.5v1.379c0 .58.335 1.108.859 1.357l5.89 2.812c.612.292 1.324.292 1.936 0l5.89-2.812a1.5 1.5 0 0 0 .859-1.357V5.5A2.25 2.25 0 0 0 15.5 3.25h-11Zm13.25 6.353-5.245 2.504a3.75 3.75 0 0 1-3.23 0L4.03 9.603a3 3 0 0 1-1.78-2.724V14.5a2.25 2.25 0 0 0 2.25 2.25h11a2.25 2.25 0 0 0 2.25-2.25V6.88a3 3 0 0 1-1.78 2.724Z" />
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak>Inventario</span>
            </a>

            <a href="{{ route('admin.payments.index') }}"
                title="Pagos"
                class="{{ $baseLink }} {{ request()->routeIs('admin.payments.*') ? $activeLink : $inactiveLink }}"
                :class="sidebarCollapsed ? 'justify-center' : ''">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M2.75 5A2.25 2.25 0 0 1 5 2.75h10A2.25 2.25 0 0 1 17.25 5v10A2.25 2.25 0 0 1 15 17.25H5A2.25 2.25 0 0 1 2.75 15V5ZM5.5 7.25a.75.75 0 0 0 0 1.5h7a.75.75 0 0 0 0-1.5h-7Zm0 4a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" />
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak>Pagos</span>
            </a>

            <a href="{{ route('admin.shipping.index') }}"
                title="Envíos"
                class="{{ $baseLink }} {{ request()->routeIs('admin.shipping.*') ? $activeLink : $inactiveLink }}"
                :class="sidebarCollapsed ? 'justify-center' : ''">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M1.75 5.75A1.75 1.75 0 0 1 3.5 4h8A1.75 1.75 0 0 1 13.25 5.75v1.5h1.336c.464 0 .907.184 1.235.512l1.667 1.667c.328.328.512.772.512 1.236v2.585a1.75 1.75 0 0 1-1.75 1.75h-.69a2.75 2.75 0 0 1-5.12 0H7.56a2.75 2.75 0 0 1-5.12 0H3.5a1.75 1.75 0 0 1-1.75-1.75v-7.5ZM5 15.5a1.25 1.25 0 1 0 0-2.5 1.25 1.25 0 0 0 0 2.5Zm8 0a1.25 1.25 0 1 0 .001-2.501A1.25 1.25 0 0 0 13 15.5Z" />
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak>Envíos</span>
            </a>
        @endif

        <h2 class="mt-6 px-2 text-xs font-semibold text-[color:var(--ink-faint)] uppercase tracking-wider" x-show="!sidebarCollapsed" x-cloak>Configuración</h2>

        @if (auth()->user()?->isAdmin())
            <a href="{{ route('admin.store.index') }}"
                title="Tienda"
                class="{{ $baseLink }} {{ request()->routeIs('admin.store.*') ? $activeLink : $inactiveLink }}"
                :class="sidebarCollapsed ? 'justify-center' : ''">
                <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M3.5 3.25A2.25 2.25 0 0 0 1.25 5.5v1.379c0 .58.335 1.108.859 1.357l5.89 2.812c.612.292 1.324.292 1.936 0l5.89-2.812a1.5 1.5 0 0 0 .859-1.357V5.5A2.25 2.25 0 0 0 14.5 3.25h-11ZM3 10.7V14.5A2.25 2.25 0 0 0 5.25 16.75h9.5A2.25 2.25 0 0 0 17 14.5v-3.8l-4.2 2.005a4.5 4.5 0 0 1-3.9 0L3 10.7Z" />
                </svg>
                <span x-show="!sidebarCollapsed" x-cloak>Tienda</span>
            </a>
        @endif

        <a href="{{ route('profile.edit') }}"
            title="Mi Cuenta"
            class="{{ $baseLink }} {{ request()->routeIs('profile.*') ? $activeLink : $inactiveLink }}"
            :class="sidebarCollapsed ? 'justify-center' : ''">
            <svg class="h-5 w-5 shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M10 2.5a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-6 13a6 6 0 1 1 12 0v.75a.75.75 0 0 1-.75.75h-10.5a.75.75 0 0 1-.75-.75v-.75Z" clip-rule="evenodd" />
            </svg>
            <span x-show="!sidebarCollapsed" x-cloak>Mi Cuenta</span>
        </a>
    </div>

    <div class="pt-4 pb-4 border-t border-[color:var(--sidebar-border)] px-2">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="w-full rounded-lg px-3 py-2.5 text-sm font-semibold text-[color:var(--sidebar-muted)] hover:bg-[color:rgba(255,253,249,0.06)] hover:text-[color:var(--white)] transition"
                :class="sidebarCollapsed ? 'inline-flex items-center justify-center' : 'text-left'"
                title="Cerrar sesión">
                <span x-show="!sidebarCollapsed" x-cloak>{{ __('Cerrar sesión') }}</span>
                <svg x-show="sidebarCollapsed" x-cloak class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M3 4.75A1.75 1.75 0 0 1 4.75 3h5.5a.75.75 0 0 1 0 1.5h-5.5a.25.25 0 0 0-.25.25v10.5c0 .138.112.25.25.25h5.5a.75.75 0 0 1 0 1.5h-5.5A1.75 1.75 0 0 1 3 15.25V4.75Zm8.22 1.97a.75.75 0 0 1 1.06 0l2.75 2.75a.75.75 0 0 1 0 1.06l-2.75 2.75a.75.75 0 1 1-1.06-1.06l1.47-1.47H8.75a.75.75 0 0 1 0-1.5h3.94l-1.47-1.47a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                </svg>
            </button>
        </form>
    </div>
</nav>
