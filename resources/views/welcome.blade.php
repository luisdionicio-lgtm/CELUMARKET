<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bienvenido a {{ config('app.name', 'CELU MARKET') }}</title>

        <!-- Fuentes -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

        <!-- Estilos y scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-950 text-white font-sans antialiased flex flex-col items-center justify-start px-4 py-10">

        <main class="max-w-4xl w-full text-center space-y-8">
            <!-- Encabezado -->
            <div class="space-y-4">
                <p class="text-sm uppercase tracking-[0.4em] text-white/70">Bienvenido</p>
                <h1 class="text-4xl sm:text-5xl font-bold">CELU MARKET</h1>
                <p class="text-base text-white/80">
                    Somos la tienda peruana especializada en celulares de última generación. Descubre promociones,
                    planes de financiamiento y soporte técnico 24/7.
                </p>
            </div>

            <!-- Buscador -->
            <div class="mt-6">
                <input type="text" id="searchInput" placeholder="Buscar celulares..." class="w-full px-4 py-2 rounded-lg text-slate-900 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <!-- Lista de productos -->
            <div id="productList" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6 text-left">
                <div class="producto bg-white p-4 rounded-lg shadow">
                    <h3 class="nombre text-lg font-bold text-slate-900">Samsung Galaxy S23</h3>
                    <p class="text-sm text-slate-600">Alta gama, cámara triple, 256GB.</p>
                </div>
                <div class="producto bg-white p-4 rounded-lg shadow">
                    <h3 class="nombre text-lg font-bold text-slate-900">iPhone 14 Pro</h3>
                    <p class="text-sm text-slate-600">Pantalla OLED, chip A16, 128GB.</p>
                </div>
                <div class="producto bg-white p-4 rounded-lg shadow">
                    <h3 class="nombre text-lg font-bold text-slate-900">Xiaomi Redmi Note 12</h3>
                    <p class="text-sm text-slate-600">Batería 5000mAh, 6GB RAM.</p>
                </div>
            </div>

            <!-- Beneficios -->
            <div class="grid gap-4 sm:grid-cols-3 text-left text-slate-900 mt-10">
                <div class="rounded-2xl bg-white/95 backdrop-blur p-5 shadow-lg">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Catálogo</p>
                    <p class="mt-2 text-2xl font-bold text-slate-900">+300 modelos</p>
                    <p class="text-sm text-slate-500">Nuevos lanzamientos y líneas clásicas.</p>
                </div>
                <div class="rounded-2xl bg-white/95 backdrop-blur p-5 shadow-lg">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Beneficios</p>
                    <p class="mt-2 text-2xl font-bold text-slate-900">Garantía oficial</p>
                    <p class="text-sm text-slate-500">Soporte directo del fabricante.</p>
                </div>
                <div class="rounded-2xl bg-white/95 backdrop-blur p-5 shadow-lg">
                    <p class="text-sm font-semibold text-slate-500 uppercase tracking-wide">Atención</p>
                    <p class="mt-2 text-2xl font-bold text-slate-900">24/7</p>
                    <p class="text-sm text-slate-500">Nos encargamos de tus pedidos en todo momento.</p>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex flex-col gap-4 sm:flex-row sm:justify-center mt-8">
                <a href="{{ Route::has('home') ? route('home') : url('/') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 shadow-lg shadow-slate-900/30 transition hover:-translate-y-1">
                    <i class="fa-solid fa-store"></i>
                    Ir a la tienda
                </a>
                <a href="#contacto" class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/30 px-5 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                    <i class="fa-solid fa-headset"></i>
                    Hablar con soporte
                </a>
            </div>
        </main>

        <!-- Script de filtrado -->
        <script>
            document.getElementById('searchInput').addEventListener('input', function () {
                const query = this.value.toLowerCase();
                const productos = document.querySelectorAll('#productList .producto');

                productos.forEach(producto => {
                    const nombre = producto.querySelector('.nombre').textContent.toLowerCase();
                    producto.style.display = nombre.includes(query) ? 'block' : 'none';
                });
            });
        </script>
    </body>
</html>