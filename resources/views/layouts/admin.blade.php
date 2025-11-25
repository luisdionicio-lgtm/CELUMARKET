<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración | CELU MARKET</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-900 font-sans antialiased">

    <header class="bg-[#1a233a] text-white shadow-md">
        <div class="max-w-6xl mx-auto px-4 py-4 flex justify-between items-center">

            <h1 class="text-xl font-bold">Panel de Administración</h1>

            <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1.5 text-sm font-semibold text-white transition hover:bg-white/20">
                <i class="fa-solid fa-user-gear"></i>
                Mi perfil
            </a>
        </div>
    </header>

    <main class="py-10">
        @yield('content')
    </main>

</body>
</html>
