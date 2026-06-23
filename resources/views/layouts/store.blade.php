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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="@yield('body_class', 'bg-slate-100 text-slate-800 antialiased')">

    <main>
        @yield('content')
    </main>

</body>
</html>
