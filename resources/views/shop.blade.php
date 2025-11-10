<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda | CELU MARKET</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-900 antialiased">
    @php($productos = $products)

    <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/95 backdrop-blur">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ url('/') }}" class="flex items-center gap-3 text-slate-900">
                <i class="fa-solid fa-mobile-screen-button text-2xl"></i>
                <div class="leading-tight">
                    <strong class="text-base font-semibold">CELU MARKET</strong>
                    <span class="block text-xs text-slate-500">Tienda especializada</span>
                </div>
            </a>

            <nav class="hidden items-center gap-5 text-sm font-medium text-slate-600 lg:flex">
                <a href="#productos" class="transition hover:text-[#0d6efd]">Productos</a>
                <a href="#beneficios" class="transition hover:text-[#0d6efd]">Beneficios</a>
                <a href="#destacados" class="transition hover:text-[#0d6efd]">Destacados</a>
            </nav>

            <div class="hidden w-64 items-center gap-2 rounded-2xl border border-slate-200 bg-slate-50 px-4 py-2 text-sm text-slate-500 md:flex">
                <i class="fa-solid fa-search"></i>
                <input type="text" placeholder="Buscar celulares..." class="w-full border-0 bg-transparent p-0 text-sm text-slate-700 placeholder:text-slate-400 focus:ring-0" />
            </div>

            <div class="flex items-center gap-4 text-xl text-slate-500">
                <a href="#carrito" aria-label="Carrito" class="transition hover:text-[#0d6efd]">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>

                @auth
                    <details class="relative">
                        <summary class="flex cursor-pointer list-none items-center gap-2 rounded-full border border-slate-200 px-3 py-1.5 text-sm font-semibold text-slate-600 transition hover:border-slate-300">
                            <i class="fa-solid fa-user text-base"></i>
                            {{ \Illuminate\Support\Str::limit(Auth::user()->name, 10) }}
                        </summary>
                        <div class="absolute right-0 mt-2 w-48 rounded-xl border border-slate-200 bg-white p-3 text-sm shadow-xl">
                            <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 text-slate-600 transition hover:bg-slate-50">
                                Mi perfil
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                @csrf
                                <button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-rose-600 transition hover:bg-rose-50">
                                    Cerrar sesión
                                </button>
                            </form>
                        </div>
                    </details>
                @else
                    <button type="button" class="btn-open-auth-modal text-slate-500 transition hover:text-[#0d6efd]" aria-label="Abrir modal de autenticación">
                        <i class="fa-solid fa-user"></i>
                    </button>
                @endauth
            </div>
        </div>
    </header>

    <main class="pb-24">
        <section class="bg-[#10172A] py-20 text-white" id="destacados">
            <div class="mx-auto flex max-w-6xl flex-col gap-10 px-4 sm:px-6 lg:px-8 lg:flex-row lg:items-center lg:justify-between">
                <div class="space-y-6 lg:w-1/2">
                    <p class="text-sm uppercase tracking-[0.35em] text-white/70">Tienda oficial</p>
                    <h1 class="text-4xl font-bold sm:text-5xl">Los modelos más recientes con entrega inmediata</h1>
                    <p class="text-base text-white/80">
                        Compra celulares desbloqueados, con garantía oficial y planes de financiamiento sin intereses.
                        Cobertura en todo el Perú y soporte técnico especializado.
                    </p>
                    <div class="flex flex-col gap-3 text-sm text-white/80 sm:flex-row">
                        <div class="flex items-center gap-2 rounded-full border border-white/20 px-4 py-2">
                            <i class="fa-solid fa-shield-halved"></i> Garantía oficial
                        </div>
                        <div class="flex items-center gap-2 rounded-full border border-white/20 px-4 py-2">
                            <i class="fa-solid fa-truck-fast"></i> Envío gratis
                        </div>
                        <div class="flex items-center gap-2 rounded-full border border-white/20 px-4 py-2">
                            <i class="fa-solid fa-credit-card"></i> Pago seguro
                        </div>
                    </div>
                    <a href="#productos" class="inline-flex items-center gap-3 rounded-xl bg-white px-6 py-3 text-sm font-semibold text-[#10172A] shadow-lg shadow-black/30 transition hover:-translate-y-1">
                        <i class="fa-solid fa-box-open"></i> Ver catálogo
                    </a>
                </div>
                <div class="grid flex-1 gap-4 sm:grid-cols-2">
                    <div class="rounded-2xl border border-white/15 bg-white/5 p-5 text-left backdrop-blur">
                        <p class="text-sm uppercase tracking-[0.35em] text-white/70">Clientes</p>
                        <p class="mt-3 text-3xl font-bold">+9 000</p>
                        <p class="text-sm text-white/80">Compradores satisfechos en todo el país.</p>
                    </div>
                    <div class="rounded-2xl border border-white/15 bg-white/5 p-5 text-left backdrop-blur">
                        <p class="text-sm uppercase tracking-[0.35em] text-white/70">Catálogo</p>
                        <p class="mt-3 text-3xl font-bold">+300</p>
                        <p class="text-sm text-white/80">Modelos disponibles y listos para entrega.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="beneficios" class="bg-white py-16">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-400">Beneficios</p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">¿Por qué elegir CELU MARKET?</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-base text-slate-600">
                        Ofrecemos entrega rápida, asesoría personalizada y atención 24/7 para que disfrutes tu compra desde el primer minuto.
                    </p>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <article class="rounded-2xl border border-slate-200 p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <i class="fa-solid fa-mobile-screen-button text-3xl text-[#0d6efd]"></i>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900">Últimos modelos</h3>
                        <p class="text-sm text-slate-600">Actualizamos el catálogo cada semana con lanzamientos globales.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200 p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <i class="fa-solid fa-bolt-lightning text-3xl text-emerald-500"></i>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900">Entrega rápida</h3>
                        <p class="text-sm text-slate-600">Envíos exprés en Lima y courier asegurado a provincias.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200 p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <i class="fa-solid fa-credit-card text-3xl text-amber-500"></i>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900">Financiación</h3>
                        <p class="text-sm text-slate-600">Paga en cuotas sin intereses con tarjetas seleccionadas.</p>
                    </article>
                    <article class="rounded-2xl border border-slate-200 p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                        <i class="fa-solid fa-headset text-3xl text-slate-500"></i>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900">Soporte 24/7</h3>
                        <p class="text-sm text-slate-600">Asistencia por chat, correo y teléfono todos los días.</p>
                    </article>
                </div>
            </div>
        </section>

        <section id="productos" class="bg-slate-100 py-16">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-500">Catálogo</p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">Explora nuestros productos</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-base text-slate-600">
                        Seleccionamos los equipos mejor valorados para que encuentres el celular ideal.
                    </p>
                </div>

                <div class="mt-10 grid gap-6 sm:grid-cols-2 xl:grid-cols-3">
                    @foreach ($productos as $producto)
                        <article class="flex flex-col rounded-2xl border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-xl">
                            <div class="relative flex items-center justify-center bg-slate-50 p-6">
                                @if ($producto->featured)
                                    <span class="absolute left-4 top-4 rounded-full bg-amber-500 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-white">Destacado</span>
                                @endif
                                <img src="{{ $producto->image_url }}" alt="{{ $producto->name }}" class="h-64 w-full object-contain" />
                            </div>
                            <div class="flex flex-1 flex-col p-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-slate-900">{{ $producto->name }}</h3>
                                    <div class="mt-2 flex items-center gap-2 text-sm text-slate-500">
                                        <i class="fa-solid fa-star text-amber-400"></i>
                                        ({{ number_format($producto->rating, 1) }})
                                    </div>
                                </div>
                                <div class="mt-4 flex-1 text-sm text-slate-600">
                                    @if (!empty($producto->description))
                                        {!! nl2br(e($producto->description)) !!}
                                    @else
                                        <em class="text-slate-400">Sin descripción disponible</em>
                                    @endif
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <span class="text-2xl font-bold text-[#1a233a]">${{ number_format($producto->price, 0) }}</span>
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">Stock seguro</span>
                                </div>
                                <div class="mt-4">
                                    @auth
                                        <form action="{{ route('cart.add', $producto) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#1a233a] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#303a58]">
                                                <i class="fa-solid fa-cart-plus"></i>
                                                Agregar al carrito
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" class="btn-open-auth-modal flex w-full items-center justify-center gap-2 rounded-xl bg-[#1a233a] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#303a58]">
                                            <i class="fa-solid fa-cart-plus"></i>
                                            Inicia sesión para comprar
                                        </button>
                                    @endauth
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-10">
                    {{ $productos->links() }}
                </div>
            </div>
        </section>
    </main>

    <x-auth-iframe-modal />
</body>
</html>
