<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/" class="flex items-center gap-3 text-slate-900">
                        <i class="fa-solid fa-mobile-screen-button text-2xl text-slate-500"></i>
                        <div class="leading-tight">
                            <strong class="text-base font-semibold text-slate-700">CELU MARKET</strong>
                            <span class="block text-xs text-slate-500">Tienda especializada</span>
                        </div>
                    </a>
                </div>

                <!-- Desktop links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex text-sm font-medium text-gray-700 dark:text-gray-300">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        <i class="fa-solid fa-house mr-2"></i> Panel principal
                    </x-nav-link>

                    @unless(request()->routeIs('profile.*'))
                        <button type="button" class="open-cart flex items-center gap-2 text-gray-700 hover:text-primary">
                            <i class="fa-solid fa-cart-shopping text-lg"></i>
                            Carrito
                        </button>
                    @endunless

                    <x-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.*')">
                        <i class="fa-solid fa-headset mr-2"></i> Soporte
                    </x-nav-link>

                    @auth
                        <x-nav-link :href="route('reservations.index')" :active="request()->routeIs('reservations.*')">
                            <i class="fa-solid fa-calendar-check mr-2"></i> Mis reservas
                        </x-nav-link>

                        <x-nav-link :href="route('comparisons.index')" :active="request()->routeIs('comparisons.*')">
                            <i class="fa-solid fa-chart-bar mr-2"></i> Mis comparaciones
                        </x-nav-link>

                        <x-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.*')">
                            <i class="fa-solid fa-heart mr-2"></i> Favoritos
                        </x-nav-link>
                    @endauth

                    {{-- Perfil / Admin / Técnico --}}
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <div x-data="{ open: false }" class="relative">
                                <button
                                    @click="open = !open"
                                    @keydown.escape.window="open = false"
                                    class="inline-flex h-full items-center gap-2 rounded-full bg-white/5 px-3 py-2 text-slate-100 font-semibold transition hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/40"
                                >
                                    <i class="fa-solid fa-user-shield"></i>
                                    Panel administrador
                                    <i class="fa-solid fa-chevron-down text-xs transition" :class="open ? 'rotate-180' : ''"></i>
                                </button>

                                <div
                                    x-cloak
                                    x-show="open"
                                    x-transition.origin.top.left
                                    @click.outside="open = false"
                                    class="absolute left-0 z-20 mt-2 w-56 rounded-2xl border border-slate-200 bg-white/98 py-2 shadow-2xl ring-1 ring-slate-100"
                                >
                                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-50">
                                        <i class="fa-solid fa-id-card text-slate-500"></i> Mi perfil
                                    </a>
                                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                        <i class="fa-solid fa-box text-slate-500"></i> Gestionar productos
                                    </a>
                                    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                        <i class="fa-solid fa-receipt text-slate-500"></i> Gestionar pedidos
                                    </a>
                                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">
                                        <i class="fa-solid fa-users text-slate-500"></i> Gestionar usuarios
                                    </a>
                                </div>
                            </div>
                        @elseif(auth()->user()->isTecnico())
                            <x-nav-link :href="route('tecnico.dashboard')" :active="request()->routeIs('tecnico.*')">
                                <i class="fa-solid fa-screwdriver-wrench mr-2"></i> Panel técnico
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                                <i class="fa-solid fa-id-card mr-2"></i> Mi perfil
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Mobile toggle -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500
                    hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900
                    focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                              stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Panel principal
            </x-responsive-nav-link>

            @unless(request()->routeIs('profile.*'))
                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                    Carrito
                </x-responsive-nav-link>
            @endunless

            <x-responsive-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.*')">
                Soporte
            </x-responsive-nav-link>

            @auth
                <x-responsive-nav-link :href="route('reservations.index')" :active="request()->routeIs('reservations.*')">
                    Mis reservas
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('comparisons.index')" :active="request()->routeIs('comparisons.*')">
                    Mis comparaciones
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.*')">
                    Favoritos
                </x-responsive-nav-link>
            @endauth

            {{-- Perfil en versión móvil --}}
            @auth
                @php
                    $profileRoute = auth()->user()->isAdmin()
                        ? route('admin.dashboard')
                        : (auth()->user()->isTecnico() ? route('tecnico.dashboard') : route('profile.edit'));
                    $profileActive = auth()->user()->isAdmin()
                        ? request()->routeIs('admin.*')
                        : (auth()->user()->isTecnico() ? request()->routeIs('tecnico.*') : request()->routeIs('profile.*'));
                    $profileLabel = auth()->user()->isAdmin()
                        ? 'Panel administrador'
                        : (auth()->user()->isTecnico() ? 'Panel técnico' : 'Perfil');
                @endphp

                <x-responsive-nav-link :href="$profileRoute" :active="$profileActive">
                    {{ $profileLabel }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Usuario móvil -->
        @auth
            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="font-medium text-sm text-gray-500">
                        {{ Auth::user()->email }}
                    </div>
                </div>

                <div class="mt-3 space-y-1">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Cerrar sesión
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth

        @guest
            <div class="pt-4 pb-4 border-t border-gray-200 dark:border-gray-600 px-4">
                <button type="button" class="btn-open-auth-modal w-full px-4 py-2 rounded-md bg-gray-100 dark:bg-gray-900/40 text-sm font-semibold">
                    Iniciar sesión
                </button>
            </div>
        @endguest
    </div>
</nav>
