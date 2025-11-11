<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CELU MARKET - Tu tienda de confianza</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 font-sans antialiased">
    @php($productos = $products)
    @php($favoriteProductIds = $favoriteProductIds ?? [])
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
            </nav>

            <div class="hidden w-64 items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-500 lg:flex">
                <i class="fa-solid fa-search"></i>
                <input type="text" placeholder="Buscar celulares..." class="w-full border-0 bg-transparent p-0 text-sm text-slate-700 placeholder:text-slate-400 focus:ring-0" />
            </div>

            <div class="flex items-center gap-4 text-xl text-slate-500">
                <a href="#cart" aria-label="Carrito de compras" class="transition hover:text-[#0d6efd]">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>
                <a href="#" id="open-auth-modal" aria-label="Perfil de usuario" class="transition hover:text-[#0d6efd]">
                    <i class="fa-solid fa-user"></i>
                </a>
            </div>
        </div>
    </header>

    <main class="pb-24">
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

        <section id="products" class="bg-slate-100 py-20">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Catálogo</p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">Nuestros productos destacados</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-base text-slate-600">
                        Descubre los modelos más demandados del mercado, cuidadosamente seleccionados para ti.
                    </p>
                </div>

                <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($productos as $producto)
                        @php
                            $isFavorite = in_array($producto->id, $favoriteProductIds ?? [], true);
                            $precio = $producto->precio ?? $producto->price;
                        @endphp
                        <article class="flex flex-col rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
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
                                    <h3 class="text-lg font-semibold text-slate-900">{{ $producto->name }}</h3>
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

    <x-auth-iframe-modal />

    <script>
        console.log('Página CELU MARKET cargada.');
    </script>
</body>
</html>
