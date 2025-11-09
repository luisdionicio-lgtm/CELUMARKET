<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CELU MARKET - Tu tienda de confianza</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css','resources/js/app.js'])
    
    <style>
        /* --- ESTILOS GLOBALES --- */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            scroll-behavior: smooth; /* Para el scroll suave */
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8f9fa; /* Fondo blanco-gris */
            color: #212529; /* Texto oscuro */
            line-height: 1.6;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* --- 1. NAVBAR --- */
        .navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .nav-logo .fa-mobile-screen-button { font-size: 1.75rem; }
        
        .nav-logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        
        .nav-logo-text strong {
            font-size: 1.1rem;
            font-weight: 700;
        }
        
        .nav-logo-text span {
            font-size: 0.8rem;
            color: #6c757d;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .nav-links a {
            font-size: 0.95rem;
            font-weight: 500;
            color: #495057;
            transition: color 0.2s;
        }
        
        .nav-links a:hover { color: #0d6efd; }
        
        .nav-links a.active {
            color: #0d6efd;
            font-weight: 700;
        }
        
        .nav-links .btn-explore {
            background-color: #1a233a;
            color: #ffffff;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        .nav-links .btn-explore:hover { background-color: #344266; }

        .search-bar {
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            border-radius: 8px;
            padding: 0.6rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            width: 250px;
        }
        
        .search-bar .fa-search { color: #6c757d; }
        
        .search-bar input {
            border: none;
            background: none;
            outline: none;
            width: 100%;
            font-size: 0.9rem;
        }

        .nav-icons {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            font-size: 1.2rem;
            color: #495057;
        }
        
        .nav-icons .fa-solid { cursor: pointer; transition: color 0.2s; }
        .nav-icons .fa-solid:hover { color: #0d6efd; }


        /* --- 2. HERO SECTION --- */
        .hero-section {
            background-color: #1a233a;
            color: #ffffff;
            padding: 6rem 0;
            text-align: center;
        }

        .hero-content {
            max-width: 700px;
            margin: 0 auto;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            font-weight: 300;
            color: #ced4da;
            margin-bottom: 2.5rem;
        }

        .hero-features {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3rem;
        }

        .hero-feature {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 0.75rem 1.25rem;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-cta {
            background-color: #ffffff;
            color: #1a233a;
            font-size: 1rem;
            font-weight: 700;
            padding: 0.9rem 2.5rem;
            border-radius: 8px;
            transition: background-color 0.2s, transform 0.2s;
        }
        
        .btn-cta:hover {
            background-color: #f0f0f0;
            transform: translateY(-2px);
        }

        /* --- 3. WHY-CHOOSE-US SECTION --- */
        .why-us-section {
            padding: 6rem 0;
            background-color: #ffffff;
            text-align: center;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #6c757d;
            max-width: 600px;
            margin: 0 auto 4rem auto;
        }

        .why-us-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            margin-bottom: 4rem;
        }

        .why-us-card {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        
        .why-us-card i {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            /* Colores de Íconos */
        }
        .why-us-card .fa-mobile-screen-button { color: #0d6efd; }
        .why-us-card .fa-bolt-lightning { color: #198754; }
        .why-us-card .fa-shield-halved { color: #0d6efd; }
        .why-us-card .fa-credit-card { color: #fd7e14; }

        .why-us-card h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .why-us-card p {
            font-size: 0.95rem;
            color: #6c757d;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }
        
        .stat-item i {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #495057;
        }
        
        .stat-item h3 {
            font-size: 1.75rem;
            font-weight: 700;
        }
        
        .stat-item p {
            font-size: 0.9rem;
            color: #6c757d;
        }
        
        /* --- 4. PRODUCTS SECTION --- */
        .products-section {
            padding: 6rem 0;
            background-color: #f8f9fa; /* Fondo gris claro */
        }

        .products-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .product-card {
            background-color: #ffffff;
            border: 1px solid #e9ecef;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .product-image-box {
            background-color: #f8f9fa;
            position: relative;
            padding: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 280px; /* Altura fija para la caja de imagen */
        }
        
        .product-image-box .badge {
            position: absolute;
            top: 1rem;
            left: 1rem;
            background-color: #fd7e14;
            color: #ffffff;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 0.3rem 0.6rem;
            border-radius: 6px;
        }
        
        .product-image-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain; /* Asegura que la imagen quepa sin deformarse */
        }

        .product-content {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1; /* Hace que esta parte crezca */
        }
        
        .product-content h3 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .product-rating {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 0.75rem;
        }
        .product-rating .fa-star { color: #f59e0b; }
        
        .product-features {
            font-size: 0.9rem;
            color: #495057;
            list-style: none;
            margin-bottom: 1.5rem;
            flex-grow: 1; /* Empuja el precio hacia abajo */
        }
        
        .product-features li {
            margin-bottom: 0.25rem;
        }
        
        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a233a;
            margin-bottom: 1rem;
        }

        .btn-add-cart {
            background-color: #1a233a;
            color: #ffffff;
            text-align: center;
            padding: 0.75rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.2s;
        }
        
        .btn-add-cart:hover {
            background-color: #344266;
        }

    </style>
</head>
<body>

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
                <a href="#reservas">
                    <i class="fa-solid fa-calendar-days"></i> Reservas
                </a>
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
                <a href="#" id="open-auth-modal" aria-label="Perfil de usuario">
                    <i class="fa-solid fa-user"></i>
                </a>
            </div>

        </div>
    </header>

    <main>

        <section class="hero-section">
            <div class="container hero-content">
                <h1 class="hero-title">CELU MARKET</h1>
                <h2 class="hero-subtitle">Los mejores celulares al mejor precio del mercado</h2>
                <div class="hero-features">
                    <div class="hero-feature">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Garantía Oficial</span>
                    </div>
                    <div class="hero-feature">
                        <i class="fa-solid fa-truck-fast"></i>
                        <span>Envío Gratis</span>
                    </div>
                    <div class="hero-feature">
                        <i class="fa-solid fa-credit-card"></i>
                        <span>Pago Seguro</span>
                    </div>
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
                <p class="section-subtitle">
                    Somos tu tienda de confianza para celulares de última generación con más
                    de 3 años de experiencia
                </p>

                <div class="why-us-grid">
                    <div class="why-us-card">
                        <i class="fa-solid fa-mobile-screen-button"></i>
                        <h3>Últimos Modelos</h3>
                        <p>Siempre tenemos los celulares más nuevos del mercado</p>
                    </div>
                    <div class="why-us-card">
                        <i class="fa-solid fa-bolt-lightning"></i>
                        <h3>Entrega Rápida</h3>
                        <p>Recibe tu celular en 24-48 horas en Lima¡</p>
                    </div>
                    <div class="why-us-card">
                        <i class="fa-solid fa-shield-halved"></i>
                        <h3>Garantía Oficial</h3>
                        <p>Todos nuestros productos tienen garantía del fabricante</p>
                    </div>
                    <div class="why-us-card">
                        <i class="fa-solid fa-credit-card"></i>
                        <h3>FinanciaciÃ³n</h3>
                        <p>Paga en cuotas sin intereses con tu tarjeta de crédito</p>
                    </div>
                </div>

                <div class="stats-grid">
                    <div class="stat-item">
                        <i class="fa-solid fa-users"></i>
                        <h3>9000 +</h3>
                        <p>Clientes Satisfechos</p>
                    </div>
                    <div class="stat-item">
                        <i class="fa-solid fa-box-open"></i>
                        <h3>300 +</h3>
                        <p>Productos Disponibles</p>
                    </div>
                    <div class="stat-item">
                        <i class="fa-solid fa-star"></i>
                        <h3>99.5%</h3>
                        <p>Satisfacción</p>
                    </div>
                    <div class="stat-item">
                        <i class="fa-solid fa-headset"></i>
                        <h3>24/7</h3>
                        <p>Soporte Técnico</p>
                    </div>
                </div>
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
                <a href="#add-to-cart-{{ $product->id }}" class="btn-add-cart">
                    <i class="fa-solid fa-cart-plus"></i>
                    Agregar
                </a>
            </div>
        </div>
    @endforeach
</div>
    </main>


    <x-auth-iframe-modal />

    <script>
        // No necesitamos JavaScript complicado.
        // La funcionalidad de "Comenzar a Comprar" y "Explorar Productos"
        // se maneja con enlaces de ancla (href="#products")
        // y la propiedad CSS `scroll-behavior: smooth;`
        
        console.log("PÃ¡gina CELU MARKET cargada.");
        
        // AquÃ­ podrÃ­amos aÃ±adir la lÃ³gica para el botÃ³n "Agregar"
        // en el futuro, cuando conectemos la base de datos.
    </script>

</body>
</html>
