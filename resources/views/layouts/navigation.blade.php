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

                    {{-- Perfil / Admin --}}
                    @auth
                        @if(auth()->check() && auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                <i class="fa-solid fa-user-shield mr-2"></i> Panel administrador
                            </x-nav-link>
                        @endif

                        <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                            <i class="fa-solid fa-id-card mr-2"></i> Mi perfil
                        </x-nav-link>
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
                @if(auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        Panel administrador
                    </x-responsive-nav-link>
                @endif
                <x-responsive-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.*')">
                    Perfil
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
