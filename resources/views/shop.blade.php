<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda - CELU MARKET</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="shop-page">

    <header class="navbar">
        <div class="container navbar-content">
            
            <a href="/" class="nav-logo">
                <i class="fa-solid fa-mobile-screen-button"></i>
                <div class="nav-logo-text">
                    <strong>CELU MARKET</strong>
                    <span>Tu tienda de celulares</span>
                </div>
            </a>

            <div class="nav-links">
                <a href="#products" class="btn-explore">Explorar Productos</a>
                <a href="#reservas"><i class="fa-solid fa-calendar-days"></i> Reservas</a>
                <a href="#pedidos">Mis Pedidos</a>
                <a href="#soporte">Soporte</a>
            </div>

            <div class="search-bar">
                <i class="fa-solid fa-search"></i>
                <input type="text" placeholder="Buscar celulares...">
            </div>

            <div class="nav-icons">
                <a href="#cart" aria-label="Carrito de compras">
                    <i class="fa-solid fa-cart-shopping"></i>
                </a>

                @auth
                    <div class="user-dropdown">
                        <i class="fa-solid fa-user"></i>
                        <div class="user-dropdown-content">
                            <a href="{{ route('profile.edit') }}">Mi Perfil</a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Cerrar Sesión</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="#" class="btn-open-auth-modal" aria-label="Iniciar Sesión">
                        <i class="fa-solid fa-user"></i>
                    </a>
                @endauth

            </div>
        </div>
    </header>

    <main>

        <section class="hero-section">
            <div class="container hero-content">
                <h1 class="hero-title">CELU MARKET</h1>
                <h2 class="hero-subtitle">Los mejores celulares al mejor precio del mercado</h2>
                <div class="hero-features">
                    <div class="hero-feature"><i class="fa-solid fa-shield-halved"></i><span>Garantí­a Oficial</span></div>
                    <div class="hero-feature"><i class="fa-solid fa-truck-fast"></i><span>Enví­o Gratis</span></div>
                    <div class="hero-feature"><i class="fa-solid fa-credit-card"></i><span>Pago Seguro</span></div>
                </div>
                <a href="#products" class="btn-cta">
                    <i class="fa-solid fa-boxes-stacked"></i>
                    Explorar Productos
                </a>
            </div>
        </section>

        <section class="why-us-section">
            <div class="container">
                <h2 class="section-title">¿Por qué elegir CELU MARKET?</h2>
                <p class="section-subtitle">Somos tu tienda de confianza para celulares de última generación con más de 3 años de experiencia</p>
                <div class="why-us-grid">
                    <div class="why-us-card"><i class="fa-solid fa-mobile-screen-button"></i><h3>últimos Modelos</h3><p>Siempre tenemos los celulares mÃ¡s nuevos del mercado</p></div>
                    <div class="why-us-card"><i class="fa-solid fa-bolt-lightning"></i><h3>Entrega Rápida</h3><p>Recibe tu celular en 24-48 horas en Lima</p></div>
                    <div class="why-us-card"><i class="fa-solid fa-shield-halved"></i><h3>Garantía Oficial</h3><p>Todos nuestros productos tienen garantía del fabricante</p></div>
                    <div class="why-us-card"><i class="fa-solid fa-credit-card"></i><h3>Financiación</h3><p>Paga en cuotas sin intereses con tu tarjeta de crédito</p></div>
                </div>
                <div class="stats-grid">
                    <div class="stat-item"><i class="fa-solid fa-users"></i><h3>9000 +</h3><p>Clientes Satisfechos</p></div>
                    <div class="stat-item"><i class="fa-solid fa-box-open"></i><h3>300 +</h3><p>Productos Disponibles</p></div>
                    <div class="stat-item"><i class="fa-solid fa-star"></i><h3>99.5%</h3><p>Satisfacción</p></div>
                    <div class="stat-item"><i class="fa-solid fa-headset"></i><h3>24/7</h3><p>Soporte Técnico</p></div>
                </div>
            </div>
        </section>

        <section class="products-section" id="products">
            <div class="container">
                <div class="products-header">
                    <h2 class="section-title">Productos Destacados</h2>
                    <p class="section-subtitle">Descubre los celulares más populares y mejor valorados por nuestros clientes</p>
                </div>

<div class="products-grid">
    @foreach ($products as $product)
        <div class="product-card">
            <div class="product-image-box">
                @if ($product->featured)
                    <span class="badge">Destacado</span>
                @endif
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}">
            </div>
            <div class="product-content">
                <h3>{{ $product->name }}</h3>
                <div class="product-rating">
                    <i class="fa-solid fa-star"></i> ({{ number_format($product->rating, 1) }})
                </div>
                <ul class="product-features">
                    @if (!empty($product->description))
                        <li>{!! nl2br(e($product->description)) !!}</li>
                    @else
                        <li><em>Sin descripción disponible</em></li>
                    @endif
                </ul>
                <p class="product-price">${{ number_format($product->price, 0) }}</p>

                @auth
                    <form action="{{ route('cart.add', $product) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-add-cart" style="width: 100%; border: none; cursor: pointer;">
                            <i class="fa-solid fa-cart-plus"></i>
                            Agregar
                        </button>
                    </form>
                @else
                    <button type="button" class="btn-add-cart btn-open-auth-modal" style="width: 100%; border: none; cursor: pointer;">
                        <i class="fa-solid fa-cart-plus"></i>
                        Agregar
                    </button>
                @endauth
            </div>
        </div>
    @endforeach
</div>

<div class="pagination" style="margin-top: 2rem;">
    {{ $products->links() }}
</div>

                </div>
            </div>
        </section>
    </main>
    <x-auth-iframe-modal />
</body>
</html>


