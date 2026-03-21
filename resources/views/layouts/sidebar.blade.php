<nav class="fixed inset-y-0 left-0 w-64 bg-[color:var(--sidebar-bg)] border-r border-[color:var(--sidebar-border)] hidden sm:flex sm:flex-col">
    <div class="flex items-center h-16 px-4 border-b border-[color:var(--sidebar-border)]">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="h-12 w-auto" />
        </a>
    </div>

    <div class="mt-6 px-2 space-y-1 flex-1 overflow-y-auto">

        @if (auth()->user()?->isAdmin())
            <h2 class="mt-6 px-2 text-xs font-semibold text-[color:var(--ink-faint)] uppercase tracking-wider mb-4"><p>Principal</p></h2>
            <x-nav-link vertical :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-nav-link>

            <x-nav-link vertical :href="route('admin.orders.index')" :active="request()->routeIs('admin.orders.*')">
                {{ __('Pedidos') }}
            </x-nav-link>

            <x-nav-link vertical :href="route('admin.products.index')" :active="request()->routeIs('admin.products.*')">
                {{ __('Productos') }}
            </x-nav-link>

            <x-nav-link vertical :href="route('admin.categories.index')" :active="request()->routeIs('admin.categories.*')">
                {{ __('Categorías') }}
            </x-nav-link>

            <x-nav-link vertical :href="route('admin.customers.index')" :active="request()->routeIs('admin.customers.*')">
                {{ __('Clientes') }}
            </x-nav-link>
            <!-- add more sidebar links here -->


            <h2 class="mt-6 px-2 text-xs font-semibold text-[color:var(--ink-faint)] uppercase tracking-wider mb-4"  >
                <p>Gestion</p>
            </h2>

            <x-nav-link vertical href="#" aria-disabled="true" class="opacity-60 cursor-not-allowed">
                {{ __('Inventario') }}
            </x-nav-link>

            <x-nav-link vertical href="#" aria-disabled="true" class="opacity-60 cursor-not-allowed">
                {{ __('Pagos') }}
            </x-nav-link>

            <x-nav-link vertical href="#" aria-disabled="true" class="opacity-60 cursor-not-allowed">
                {{ __('Envios') }}
            </x-nav-link>
        @endif

        <h2 class="mt-6 px-2 text-xs font-semibold text-[color:var(--ink-faint)] uppercase tracking-wider mb-6">
            <p>Configuración</p>
        </h2>

        <x-nav-link vertical href="#" aria-disabled="true" class="opacity-60 cursor-not-allowed">
            {{ __('Tienda') }}
        </x-nav-link>


        <x-nav-link vertical :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
            {{ __('Mi Cuenta') }}
        </x-nav-link>

        


    </div>


        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-4 border-t border-[color:var(--sidebar-border)] px-2">

            <form method="POST" action="{{ route('logout') }}" class="mt-3">
                @csrf

                <button type="submit" class="block w-full rounded-lg px-4 py-2 text-sm font-semibold text-[color:var(--sidebar-muted)] hover:bg-[color:rgba(255,253,249,0.06)] hover:text-[color:var(--white)] text-left transition">
                    {{ __('Cerrar sesión') }}
                </button>
            </form>
        </div>
    

</nav>
