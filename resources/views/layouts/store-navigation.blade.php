<nav class="bg-white border-b border-slate-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 h-16 flex items-center justify-between">

        <a href="{{ route('landing') }}" class="flex items-center gap-2">
            <img src="/logo.png" class="h-8">
            <span class="font-bold text-primary">CELU MARKET</span>
        </a>

        <div class="hidden md:flex items-center gap-8 text-sm font-semibold">

            <a href="{{ route('shop.index') }}" class="hover:text-primary">
                Productos
            </a>

            <button type="button" class="open-cart flex items-center gap-2 hover:text-primary">
                <i class="fa-solid fa-cart-shopping"></i> Carrito
            </button>

            @auth
            <a href="{{ route('favorites.index') }}" class="hover:text-primary">
                Favoritos
            </a>
            @endauth

            @guest
            <button class="btn-open-auth-modal">Iniciar sesión</button>
            @endguest

            @auth
            <a href="{{ route('profile.edit') }}" class="hover:text-primary">
                Mi Perfil
            </a>
            @endauth
        </div>
    </div>
</nav>
