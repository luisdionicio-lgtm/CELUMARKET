<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-white p-4">
    <div class="max-w-xl mx-auto">
        <div class="mb-3">
            <div class="grid grid-cols-2 gap-2 bg-slate-100 rounded-full p-1">
                <button class="px-3 py-2 text-sm font-semibold rounded-full bg-white shadow">Iniciar Sesión</button>
                <a href="{{ route('auth.embed.register', ['redirect' => request('redirect', url()->previous())]) }}" class="px-3 py-2 text-sm font-semibold rounded-full text-slate-600 text-center">Registrarse</a>
            </div>
        </div>

        <div class="border border-slate-200 rounded-xl p-4 shadow-sm">
            <h2 class="text-lg font-semibold">Iniciar Sesión</h2>
            <p class="text-slate-500 mb-4">Ingresa tus credenciales para acceder a tu cuenta</p>
            <form method="POST" action="{{ route('login') }}" class="space-y-3">
                @csrf
                <input type="hidden" name="redirect" value="{{ request('redirect', '/') }}">
                <input type="hidden" name="iframe" value="1">

                <label class="block text-sm" for="email">Email</label>
                <input id="email" name="email" type="email" required autofocus class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2" placeholder="tu@email.com">

                <label class="block text-sm" for="password">Contraseña</label>
                <input id="password" name="password" type="password" required class="w-full bg-slate-50 border border-slate-200 rounded-lg px-3 py-2">

                <button type="submit" class="w-full bg-[#1a233a] hover:bg-[#233255] text-white font-semibold px-4 py-2 rounded-lg">Iniciar Sesión</button>
            </form>
        </div>
    </div>
</body>
</html>

