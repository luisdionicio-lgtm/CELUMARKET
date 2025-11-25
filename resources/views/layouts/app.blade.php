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
        {{ config('app.name', 'CELU MARKET') }}
    </title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans bg-slate-100 text-slate-800 antialiased">

    @include('layouts.navigation')

    @isset($header)
        <header class="bg-white border-b border-slate-200 shadow-sm">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main>
        @hasSection('content')
            @yield('content')
        @elseif(isset($slot))
            {{ $slot }}
        @endif
    </main>

    @include('components.auth-modal')

    <x-cart-drawer />

    @if(session('status'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Notificación',
                text: @json(session('status')),
                confirmButtonColor: '#0d6efd'
            });
        </script>
    @endif

    @include('components.footer')

</body>
</html>
