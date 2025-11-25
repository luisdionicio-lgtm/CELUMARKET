<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @hasSection('title')
            @yield('title') -
        @endif
        CELU MARKET
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-800 antialiased">

    {{-- ESTE ES EL NAVEGADOR DE LA TIENDA (no el del panel) --}}
    @include('layouts.store-navigation')

    <main>
        @yield('content')
    </main>

    {{-- Drawer del carrito --}}
    <x-cart-drawer />

</body>
</html>
