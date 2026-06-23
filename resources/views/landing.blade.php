<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CELU MARKET - Bienvenido</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body.landing-page {
            align-items: center;
            background-color: #1a233a;
            color: #f0f4f8;
            display: flex;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            justify-content: center;
            margin: 0;
            min-height: 100vh;
            padding: 0;
            text-align: center;
        }

        .landing-page .hero-container {
            padding: 2rem;
            width: min(100%, 980px);
        }

        .landing-page .hero-logo .fa-mobile-screen-button {
            color: #d0d0d0;
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .landing-page .hero-title {
            font-size: clamp(2.75rem, 8vw, 4rem);
            font-weight: 800;
            letter-spacing: 2px;
            line-height: 1;
            margin: 0 0 0.5rem;
        }

        .landing-page .hero-subtitle {
            color: #a0aec0;
            font-size: 1.25rem;
            font-weight: 300;
            margin: 0 0 3rem;
        }

        .landing-page .features-grid {
            display: grid;
            gap: 1.5rem;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            margin: 0 auto 3rem;
            max-width: 900px;
        }

        .landing-page .feature-box {
            align-items: center;
            background-color: #2a3b5f;
            border-radius: 12px;
            display: flex;
            flex-direction: column;
            font-size: 0.9rem;
            font-weight: 600;
            gap: 0.75rem;
            padding: 1.5rem 1rem;
        }

        .landing-page .feature-box .fa-solid {
            font-size: 1.5rem;
        }

        .landing-page .feature-box.box-1 {
            color: #d1d5db;
        }

        .landing-page .feature-box.box-2 {
            background-color: #2563eb;
            color: #ffffff;
        }

        .landing-page .feature-box.box-3 {
            background-color: #10b981;
            color: #ffffff;
        }

        .landing-page .feature-box.box-4 {
            background-color: #f59e0b;
            color: #ffffff;
        }

        .landing-page .cta-button {
            align-items: center;
            background-color: #ffffff;
            border-radius: 999px;
            color: #1a233a;
            display: inline-flex;
            font-size: 1.1rem;
            font-weight: 700;
            gap: 0.65rem;
            justify-content: center;
            margin-bottom: 2.5rem;
            padding: 1rem 2.5rem;
            text-decoration: none;
        }

        .landing-page .secondary-benefits {
            color: #a0aec0;
            display: flex;
            flex-wrap: wrap;
            font-size: 0.85rem;
            gap: 2rem;
            justify-content: center;
            margin-bottom: 4rem;
        }

        .landing-page .benefit {
            align-items: center;
            display: flex;
            gap: 0.5rem;
        }

        @media (max-width: 760px) {
            .landing-page .features-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 460px) {
            .landing-page .features-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="landing-page">
    <main class="hero-container">
        <div class="hero-logo">
            <i class="fa-solid fa-mobile-screen-button"></i>
        </div>

        <h1 class="hero-title">CELU MARKET</h1>
        <h2 class="hero-subtitle">Tu tienda de confianza para celulares</h2>

        <div class="features-grid">
            <div class="feature-box box-1">
                <i class="fa-solid fa-box-archive"></i>
                <span>500+ Productos</span>
            </div>
            <div class="feature-box box-2">
                <i class="fa-solid fa-shield-halved"></i>
                <span>Garantía oficial</span>
            </div>
            <div class="feature-box box-3">
                <i class="fa-solid fa-truck-fast"></i>
                <span>Envío gratis</span>
            </div>
            <div class="feature-box box-4">
                <i class="fa-solid fa-star"></i>
                <span>99.5% satisfacción</span>
            </div>
        </div>

        <a href="/tienda" class="cta-button">
            Comenzar a comprar
            <i class="fa-solid fa-sparkles"></i>
        </a>

        <div class="secondary-benefits">
            <div class="benefit">
                <i class="fa-solid fa-credit-card"></i>
                <span>Pago seguro</span>
            </div>
            <div class="benefit">
                <i class="fa-solid fa-bolt-lightning"></i>
                <span>Entrega rápida</span>
            </div>
            <div class="benefit">
                <i class="fa-solid fa-tags"></i>
                <span>Ofertas exclusivas</span>
            </div>
        </div>
    </main>
</body>
</html>
