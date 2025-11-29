<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CELU MARKET - Tu tienda de confianza</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased">
    @php
        use App\Models\Cart;
        use App\Models\Product;
        use Illuminate\Support\Facades\Auth;
        use Illuminate\Support\Facades\Session;

        $productos = $products;
        $favoriteProductIds = $favoriteProductIds ?? [];

        $cartItems = collect();

        if (Auth::check()) {
            $cartItems = Cart::with('product')
                ->where('user_id', Auth::id())
                ->get()
                ->filter(fn ($cart) => $cart->product)
                ->map(function ($cart) {
                    $product = $cart->product;

                    return [
                        'id' => $product->id,
                        'name' => $product->name ?? $product->nombre,
                        'brand' => $product->marca ?? $product->brand ?? null,
                        'variant' => $product->variant ?? null,
                        'price' => (float) ($product->precio ?? $product->price ?? 0),
                        'quantity' => $cart->quantity ?? 1,
                        'image' => $product->image_url ?? null,
                    ];
                })
                ->values();
        } else {
            $sessionCart = Session::get('cart', []);
            $productsInCart = Product::whereIn('id', array_keys($sessionCart))->get()->keyBy('id');

            $cartItems = collect($sessionCart)->map(function ($quantity, $productId) use ($productsInCart) {
                if (!$productsInCart->has($productId)) {
                    return null;
                }

                $product = $productsInCart[$productId];

                return [
                    'id' => $product->id,
                    'name' => $product->name ?? $product->nombre,
                    'brand' => $product->marca ?? $product->brand ?? null,
                    'variant' => $product->variant ?? null,
                    'price' => (float) ($product->precio ?? $product->price ?? 0),
                    'quantity' => $quantity ?? 1,
                    'image' => $product->image_url ?? null,
                ];
            })->filter()->values();
        }

        if ($cartItems->isNotEmpty()) {
            Session::put('cart_ready', true);
        } elseif (!Session::get('cart_ready', false)) {
            $cartItems = collect();
        }

        $cartSubtotal = $cartItems->reduce(
            fn ($total, $item) => $total + ($item['price'] ?? 0) * ($item['quantity'] ?? 1),
            0
        );

        $cartCount = $cartItems->count();
        $cartSummaryText = $cartCount
            ? 'Tienes ' . $cartCount . ' ' . ($cartCount === 1 ? 'producto' : 'productos') . ' en tu carrito'
            : 'Tu carrito esta vacio';
    @endphp

    <!-- Encabezado -->
    <header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
            <a href="/" class="flex items-center gap-3 text-slate-900">
                <i class="fa-solid fa-mobile-screen-button text-2xl"></i>
                <div class="leading-tight">
                    <strong class="text-base font-semibold">CELU MARKET</strong>
                    <span class="block text-xs text-slate-500">Tu tienda de celulares</span>
                </div>
            </a>

            <nav class="hidden items-center gap-6 text-sm font-medium text-slate-600 md:flex">
                <a href="#products" class="rounded-xl bg-[#1a233a] px-4 py-2 font-semibold text-white shadow-sm transition hover:bg-[#303a58]">Explorar Productos</a>
                <a href="#reservas" class="transition hover:text-[#0d6efd]"><i class="fa-solid fa-calendar-days mr-2"></i>Reservas</a>
                <a href="#pedidos" class="transition hover:text-[#0d6efd]">Mis Pedidos</a>
                <a href="#soporte" class="transition hover:text-[#0d6efd]">Soporte</a>
                <a href="{{ route('admin.dashboard') }}" class="transition hover:text-[#0d6efd]">
    <i class="fa-solid fa-gauge-high mr-2"></i>Panel principal
</a>
            </nav>

            <!-- Buscador funcional -->
            <div class="hidden w-64 items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-500 lg:flex">
                <i class="fa-solid fa-search"></i>
                <input type="text" id="searchInput" placeholder="Buscar celulares..." class="w-full border-0 bg-transparent p-0 text-sm text-slate-700 placeholder:text-slate-400 focus:ring-0" />
            </div>

            <div class="flex items-center gap-4 text-xl text-slate-500">
                <button
                    type="button"
                    class="relative transition hover:text-[#0d6efd]"
                    aria-label="Carrito de compras"
                    data-open-cart
                >
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span
                        class="absolute -right-3 -top-2 inline-flex min-w-[1.6rem] items-center justify-center rounded-full bg-[#0d6efd] px-1 text-xs font-semibold text-white"
                        data-cart-count
                    >
                        {{ $cartItems->count() }}
                    </span>
                </button>
                <a href="#" id="open-auth-modal" aria-label="Perfil de usuario" class="transition hover:text-[#0d6efd]">
                    <i class="fa-solid fa-user"></i>
                </a>
            </div>
        </div>
    </header>

    <main class="pb-24">
        <!-- Sección de bienvenida -->
        <section class="bg-[#1a233a] py-20 text-white">
            <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
                <p class="text-sm uppercase tracking-[0.35em] text-white/80">Bienvenido</p>
                <h1 class="mt-4 text-4xl font-extrabold tracking-wide sm:text-5xl">CELU MARKET</h1>
                <h2 class="mt-3 text-lg font-light text-white/80 sm:text-xl">Los mejores celulares al mejor precio del mercado</h2>

                <div class="mt-10 flex flex-col gap-4 text-sm font-semibold text-white/80 sm:flex-row sm:justify-center">
                    <div class="flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Garantía Oficial</span>
                    </div>
                    <div class="flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2">
                        <i class="fa-solid fa-truck-fast"></i>
                        <span>Envío Gratis</span>
                    </div>
                    <div class="flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2">
                        <i class="fa-solid fa-credit-card"></i>
                        <span>Pago Seguro</span>
                    </div>
                </div>

                <a href="#products" class="mt-10 inline-flex items-center justify-center gap-3 rounded-xl bg-white px-6 py-3 font-semibold text-[#1a233a] shadow-lg shadow-slate-900/20 transition hover:-translate-y-1 hover:bg-slate-100">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    Explorar Productos
                </a>
            </div>
        </section>

        <!-- Sección beneficios -->
        <section class="bg-white py-20" id="por-que">
            <div class="mx-auto max-w-6xl px-4 text-center sm:px-6 lg:px-8">
                <p class="text-sm uppercase tracking-[0.3em] text-slate-400">¿Por qué nosotros?</p>
                <h2 class="mt-3 text-3xl font-bold text-slate-900">¿Por qué elegir CELU MARKET?</h2>
                <p class="mx-auto mt-4 max-w-2xl text-base text-slate-600">
                    Somos tu tienda de confianza para celulares de última generación con más de 3 años de experiencia.
                </p>

                <div class="mt-12 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <article class="rounded-2xl border border-slate-200 p-6 text-left shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <i class="fa-solid fa-mobile-screen-button text-3xl text-[#0d6efd]"></i>
                        <h3 class="mt-6 text-lg font-semibold text-slate-900">Últimos Modelos</h3>
                        <p class="mt-2 text-sm text-slate-600">Siempre tenemos los celulares más nuevos del mercado.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200 p-6 text-left shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <i class="fa-solid fa-bolt-lightning text-3xl text-emerald-500"></i>
                        <h3 class="mt-6 text-lg font-semibold text-slate-900">Entrega Rápida</h3>
                        <p class="mt-2 text-sm text-slate-600">Recibe tu celular en 24-48 horas en Lima.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200 p-6 text-left shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <i class="fa-solid fa-shield-halved text-3xl text-[#0d6efd]"></i>
                        <h3 class="mt-6 text-lg font-semibold text-slate-900">Garantía Oficial</h3>
                        <p class="mt-2 text-sm text-slate-600">Todos nuestros productos cuentan con garantía del fabricante.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200 p-6 text-left shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <i class="fa-solid fa-credit-card text-3xl text-amber-500"></i>
                        <h3 class="mt-6 text-lg font-semibold text-slate-900">Financiación</h3>
                        <p class="mt-2 text-sm text-slate-600">Paga en cuotas sin intereses con tu tarjeta de crédito.</p>
                    </article>
                </div>
            </div>
        </section>
        <!-- Métricas destacadas -->
        <div class="mt-12 grid gap-6 text-left sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 text-center">
                <i class="fa-solid fa-users text-3xl text-slate-500"></i>
                <h3 class="mt-4 text-2xl font-bold">9000+</h3>
                <p class="text-sm text-slate-600">Clientes Satisfechos</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 text-center">
                <i class="fa-solid fa-box-open text-3xl text-slate-500"></i>
                <h3 class="mt-4 text-2xl font-bold">300+</h3>
                <p class="text-sm text-slate-600">Productos Disponibles</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 text-center">
                <i class="fa-solid fa-star text-3xl text-slate-500"></i>
                <h3 class="mt-4 text-2xl font-bold">99.5%</h3>
                <p class="text-sm text-slate-600">Índice de satisfacción</p>
            </div>
            <div class="rounded-2xl border border-slate-200 bg-slate-50 p-6 text-center">
                <i class="fa-solid fa-headset text-3xl text-slate-500"></i>
                <h3 class="mt-4 text-2xl font-bold">24/7</h3>
                <p class="text-sm text-slate-600">Soporte Técnico</p>
            </div>
        </div>
    </div>
</section>

<!-- Catálogo de productos -->
<section id="products" class="bg-slate-100 py-20">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Catálogo</p>
            <h2 class="mt-3 text-3xl font-bold text-slate-900">Nuestros productos destacados</h2>
            <p class="mx-auto mt-4 max-w-2xl text-base text-slate-600">
                Descubre los modelos más demandados del mercado, cuidadosamente seleccionados para ti.
            </p>
        </div>

        <!-- Campo de búsqueda -->
        <div class="mt-10 flex justify-center">
            <input type="text" id="searchInput" placeholder="Buscar celulares..." class="w-full max-w-md px-4 py-2 rounded-lg border border-slate-300 text-slate-900 focus:outline-none focus:ring-2 focus:ring-[#1a233a]" />
        </div>

        <!-- Lista de productos con filtro -->
        <div id="productList" class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($productos as $producto)
                @php
                    $isFavorite = in_array($producto->id, $favoriteProductIds ?? [], true);
                    $precio = $producto->precio ?? $producto->price;
                @endphp
                <article class="producto flex flex-col rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="relative flex items-center justify-center bg-slate-50 p-6">
                        @if ($producto->featured)
                            <span class="absolute left-4 top-4 rounded-full bg-amber-500 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white">Destacado</span>
                        @endif
                        <div class="absolute right-4 top-4">
                            @auth
                                <form action="{{ route('favorites.toggle', $producto) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-xl {{ $isFavorite ? 'text-rose-500' : 'text-slate-400 hover:text-rose-500' }}">
                                        <i class="{{ $isFavorite ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
                                    </button>
                                </form>
                            @else
                                <button type="button" class="btn-open-auth-modal text-xl text-slate-400 hover:text-rose-500">
                                    <i class="fa-regular fa-heart"></i>
                                </button>
                            @endauth
                        </div>
                        <img src="{{ $producto->image_url }}" alt="{{ $producto->name }}" class="h-60 w-full object-contain" />
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <div>
                            <h3 class="nombre text-lg font-semibold text-slate-900">{{ $producto->name }}</h3>
                            <div class="mt-2 flex items-center gap-2 text-sm text-slate-500">
                                <i class="fa-solid fa-star text-amber-400"></i>
                                ({{ number_format($producto->rating, 1) }})
                            </div>
                        </div>
                        <ul class="mt-4 flex-1 list-disc space-y-2 pl-5 text-sm text-slate-600">
                            @if (!empty($producto->description))
                                <li>{!! nl2br(e($producto->description)) !!}</li>
                            @else
                                <li class="italic text-slate-400">Sin descripción disponible</li>
                            @endif
                        </ul>
                        <p class="mt-4 text-2xl font-bold text-[#1a233a]">S/ {{ number_format($precio, 2) }}</p>
                        <form action="{{ route('cart.add', $producto) }}" method="POST" class="mt-4">
                            @csrf
                            <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-xl bg-[#1a233a] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#303a58]">
                                <i class="fa-solid fa-cart-plus"></i>
                                Agregar al carrito
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
</main>

<!-- Backdrop del carrito -->
<div
    id="cart-backdrop"
    class="fixed inset-0 z-40 hidden bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300"
></div>

<!-- Drawer del carrito -->
<aside
    id="cart-drawer"
    class="fixed right-0 top-0 z-50 flex h-full w-full max-w-[450px] translate-x-full flex-col border-l border-gray-200 bg-white p-6 shadow-2xl transition-transform duration-300 ease-out"
    aria-hidden="true"
>
    <!-- Boton cerrar -->
    <button
        type="button"
        id="close-cart"
        class="absolute right-4 top-4 text-gray-400 transition hover:text-gray-600"
        aria-label="Cerrar carrito"
    >
        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 6 6 18M6 6l12 12" />
        </svg>
    </button>

    <!-- Header del carrito -->
    <div class="flex items-center gap-3">
        <div class="rounded-full bg-gray-100 p-3 text-gray-700">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h15l-1.5 9h-12z" />
                <circle cx="9" cy="19" r="1.5" />
                <circle cx="17" cy="19" r="1.5" />
            </svg>
        </div>
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Carrito de Compras</h2>
            <p class="text-sm text-gray-500" data-cart-summary>{{ $cartSummaryText }}</p>
        </div>
    </div>

    <!-- Tabs -->
    <div class="mt-6 flex rounded-xl bg-gray-100 p-1 text-sm font-semibold text-gray-600">
        <button
            type="button"
            class="flex-1 rounded-lg bg-white py-2 text-center text-gray-900 shadow-sm transition"
            data-cart-tab="cart"
        >
            Carrito (<span data-cart-count>{{ $cartCount }}</span>)
        </button>
        <button
            type="button"
            class="flex-1 rounded-lg py-2 text-center transition hover:text-gray-900"
        >
            Comparar
        </button>
    </div>

    <!-- Lista de items -->
    <div
        class="mt-6 {{ $cartItems->isEmpty() ? 'hidden' : '' }} flex-1 overflow-y-auto space-y-4"
        id="cart-item-list"
    ></div>

    <!-- Estado vacio -->
    <div
        class="mt-6 flex h-full flex-col items-center justify-center text-center text-gray-500 {{ $cartItems->isEmpty() ? '' : 'hidden' }}"
        id="cart-empty-state"
    >
        <div class="rounded-full bg-gray-100 p-6 text-4xl text-gray-300">
            <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h15l-1.5 9h-12z" />
                <circle cx="9" cy="19" r="1.5" />
                <circle cx="17" cy="19" r="1.5" />
            </svg>
        </div>
        <p class="mt-3 text-lg font-semibold text-gray-900">Tu carrito está vacío</p>
        <p class="text-sm text-gray-500">Agrega productos para comenzar.</p>
    </div>

    <!-- Footer del carrito -->
    <div class="border-t border-gray-200 pt-4">
        <div class="flex items-center justify-between text-gray-900">
            <span class="text-sm font-semibold">Subtotal</span>
            <span class="text-2xl font-bold" data-cart-subtotal>S/ {{ number_format($cartSubtotal, 2) }}</span>
        </div>
        <button
            type="button"
            class="mt-4 w-full rounded-xl bg-gray-900 py-3 text-center font-semibold text-white transition hover:bg-black"
        >
            Continuar con la compra
        </button>
    </div>
</aside>

@include('components.auth-modal')

@stack('scripts')

<script>
    window.__cartItems = @json($cartItems);
</script>

<!-- Lógica del carrito off-canvas -->
<script>
    (function () {
        const drawer      = document.getElementById('cart-drawer');
        const backdrop    = document.getElementById('cart-backdrop');
        const openButtons = document.querySelectorAll('#open-cart, [data-open-cart]');
        const closeButton = document.getElementById('close-cart');
        const list        = document.getElementById('cart-item-list');
        const emptyState  = document.getElementById('cart-empty-state');
        const subtotalEl  = document.querySelector('[data-cart-subtotal]');
        const summaryEl   = document.querySelector('[data-cart-summary]');
        const countEls    = document.querySelectorAll('[data-cart-count]');
        let hideBackdropTimeout;

        const state = {
            items: Array.isArray(window.__cartItems) ? window.__cartItems : [],
        };
        window.__cartItems = state.items;

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
        const cartUrl = (productId) => `/cart/${productId}`;

        const persistQuantity = async (productId, quantity) => {
            const response = await fetch(cartUrl(productId), {
                method: 'PATCH',
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ quantity }),
            });

            if (response.status >= 400) throw new Error('No se pudo actualizar el carrito');
        };

        const persistRemoval = async (productId) => {
            const response = await fetch(cartUrl(productId), {
                method: 'DELETE',
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    ...(csrfToken ? { 'X-CSRF-TOKEN': csrfToken } : {}),
                },
            });

            if (response.status >= 400) throw new Error('No se pudo eliminar el producto');
        };

        const handleError = (message) => {
            console.error(message);
            alert(message);
        };

        if (!drawer || !backdrop || !list || !emptyState) return;

        function formatCurrency(value) {
            return new Intl.NumberFormat('es-PE', {
                style: 'currency',
                currency: 'PEN',
                minimumFractionDigits: 2,
            }).format(value || 0);
        }

        function updateItems(items) {
            if (!Array.isArray(items)) return;
            state.items = items.map(item => ({
                ...item,
                quantity: item?.quantity ?? 1,
            }));
            window.__cartItems = state.items;
            renderItems();
        }

        async function adjustQuantity(itemId, delta) {
            const index = state.items.findIndex(item => item.id === itemId);
            if (index === -1) return;
            const current = state.items[index].quantity ?? 1;
            const next = Math.max(0, current + delta);
            if (next < 1) {
                await removeItem(itemId);
                return;
            }
            try {
                await persistQuantity(itemId, next);
                state.items[index] = { ...state.items[index], quantity: next };
                renderItems();
            } catch (error) {
                handleError('No se pudo actualizar la cantidad. Intenta nuevamente.');
            }
        }

        async function removeItem(itemId) {
            const previous = [...state.items];
            try {
                await persistRemoval(itemId);
                state.items = state.items.filter(item => item.id !== itemId);
                window.__cartItems = state.items;
                renderItems();
            } catch (error) {
                state.items = previous;
                window.__cartItems = state.items;
                handleError('No se pudo eliminar el producto del carrito.');
            }
        }

        function renderItems() {
            list.innerHTML = '';

            if (!state.items.length) {
                list.classList.add('hidden');
                emptyState.classList.remove('hidden');
            } else {
                list.classList.remove('hidden');
                emptyState.classList.add('hidden');

                state.items.forEach(item => {
                    const article = document.createElement('article');
                    article.className = 'flex gap-4 rounded-2xl border border-gray-100 p-4';

                    const image = document.createElement('img');
                    image.className = 'h-20 w-20 rounded-xl object-cover';
                    image.alt = item.name ?? 'Producto';
                    image.src = item.image ?? 'https://via.placeholder.com/80';

                    const body = document.createElement('div');
                    body.className = 'flex flex-1 flex-col gap-2';

                    const info = document.createElement('div');
                    const title = document.createElement('h3');
                    title.className = 'text-sm font-semibold text-gray-900';
                    title.textContent = item.name ?? 'Producto';

                    const details = document.createElement('p');
                    details.className = 'text-xs text-gray-500';
                    details.textContent = item.brand ?? item.variant ?? '';

                    info.appendChild(title);
                    if (details.textContent) {
                        info.appendChild(details);
                    }

                    const quantityControls = document.createElement('div');
                    quantityControls.className = 'flex items-center gap-2 text-sm text-gray-600';

                    const minusButton = document.createElement('button');
                    minusButton.type = 'button';
                    minusButton.className = 'rounded-full border border-gray-200 px-2';
                    minusButton.textContent = '-';
                    minusButton.addEventListener('click', () => {
                        adjustQuantity(item.id, -1);
                    });

                    const quantity = document.createElement('span');
                    quantity.textContent = item.quantity ?? 1;

                    const plusButton = document.createElement('button');
                    plusButton.type = 'button';
                    plusButton.className = 'rounded-full border border-gray-200 px-2';
                    plusButton.textContent = '+';
                    plusButton.addEventListener('click', () => {
                        adjustQuantity(item.id, 1);
                    });

                    quantityControls.append(minusButton, quantity, plusButton);

                    const priceRow = document.createElement('div');
                    priceRow.className = 'flex items-center justify-between text-sm text-gray-600';

                    const price = document.createElement('span');
                    price.textContent = formatCurrency((item.price ?? 0) * (item.quantity ?? 1));

                    const removeButton = document.createElement('button');
                    removeButton.type = 'button';
                    removeButton.className = 'text-rose-500 hover:text-rose-600';
                    removeButton.innerHTML = `
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 6h18M9 6V4h6v2m2 0v12a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2V6h10z" />
                        </svg>
                    `;
                    removeButton.addEventListener('click', () => {
                        removeItem(item.id);
                    });

                    priceRow.append(price, removeButton);

                    body.append(info, quantityControls, priceRow);
                    article.append(image, body);
                    list.appendChild(article);
                });
            }

            const subtotal = state.items.reduce(
                (total, item) => total + (item.price ?? 0) * (item.quantity ?? 1),
                0
            );
            if (subtotalEl) {
                subtotalEl.textContent = formatCurrency(subtotal);
            }

            const summaryText = state.items.length
                ? `Tienes ${state.items.length} ${state.items.length === 1 ? 'producto' : 'productos'} en tu carrito`
                : 'Tu carrito esta vacio';

            if (summaryEl) {
                summaryEl.textContent = summaryText;
            }

            countEls.forEach(el => {
                el.textContent = state.items.length;
            });
        }

        function showBackdrop() {
            backdrop.classList.remove('hidden');
            requestAnimationFrame(() => {
                backdrop.classList.remove('opacity-0');
            });
        }

        function hideBackdrop() {
            backdrop.classList.add('opacity-0');
            hideBackdropTimeout = window.setTimeout(() => {
                backdrop.classList.add('hidden');
            }, 300);
        }

        function openDrawer(event) {
            if (event) {
                event.preventDefault();
            }
            if (hideBackdropTimeout) {
                clearTimeout(hideBackdropTimeout);
            }
            drawer.classList.remove('translate-x-full');
            drawer.setAttribute('aria-hidden', 'false');
            showBackdrop();
        }

        function closeDrawer() {
            drawer.classList.add('translate-x-full');
            drawer.setAttribute('aria-hidden', 'true');
            hideBackdrop();
        }

        openButtons.forEach(button => {
            button.addEventListener('click', openDrawer);
        });

        if (closeButton) {
            closeButton.addEventListener('click', closeDrawer);
        }

        backdrop.addEventListener('click', closeDrawer);

        document.addEventListener('keydown', event => {
            if (event.key === 'Escape') {
                closeDrawer();
            }
        });

        // Eventos globales
        window.addEventListener('cart:open', openDrawer);
        window.addEventListener('cart:close', closeDrawer);

        ['cart:update', 'cart:set', 'cart:drawer:update', 'cart-drawer:update'].forEach(eventName => {
            window.addEventListener(eventName, event => {
                updateItems(event.detail);
            });
        });

        window.addEventListener('cart:increment', event => {
            if (event.detail?.id !== undefined) {
                adjustQuantity(event.detail.id, 1);
            }
        });

        window.addEventListener('cart:decrement', event => {
            if (event.detail?.id !== undefined) {
                adjustQuantity(event.detail.id, -1);
            }
        });

        window.addEventListener('cart:remove', event => {
            if (event.detail?.id !== undefined) {
                removeItem(event.detail.id);
            }
        });

        // Disparadores dinamicos
        document.addEventListener('click', function (e) {
            if (e.target.closest('[data-open-cart]')) {
                window.dispatchEvent(new CustomEvent('cart:open'));
            }
        });

        // Render inicial
        renderItems();
    })();
</script>

<!-- Abrir carrito con #carrito o ?cart=1 -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function checkForCartHash() {
            if (window.location.hash === '#carrito' || window.location.search.includes('cart=1')) {
                window.dispatchEvent(new CustomEvent('cart:open'));
            }
        }

        checkForCartHash();
        window.addEventListener('hashchange', checkForCartHash);
    });
</script>

<!-- Script de filtrado en tiempo real -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const searchInput = document.getElementById('searchInput');
        const productList = document.getElementById('productList');

        if (searchInput && productList) {
            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase();
                const productos = productList.querySelectorAll('.producto');

                productos.forEach(producto => {
                    const nombreEl = producto.querySelector('.nombre');
                    const nombre = nombreEl ? nombreEl.textContent.toLowerCase() : '';
                    producto.style.display = nombre.includes(query) ? 'block' : 'none';
                });
            });
        }
    });
</script>

<script>
    console.log('Página CELU MARKET cargada.');
</script>
</body>
</html>
