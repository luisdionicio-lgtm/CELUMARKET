<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-white p-4">
    <div class="mx-auto max-w-xl">
        <div class="mb-3">
            <div class="grid grid-cols-2 gap-2 rounded-full bg-slate-100 p-1">
                <button class="rounded-full bg-white px-3 py-2 text-sm font-semibold shadow">Iniciar sesión</button>
                <a href="{{ route('auth.embed.register', ['redirect' => request('redirect', url()->previous())]) }}" class="rounded-full px-3 py-2 text-center text-sm font-semibold text-slate-600">Registrarse</a>
            </div>
        </div>

        <div class="rounded-xl border border-slate-200 p-4 shadow-sm">
            <h2 class="text-lg font-semibold">Iniciar sesión</h2>
            <p class="mb-4 text-slate-500">Ingresa tus credenciales para acceder a tu cuenta</p>
            <form method="POST" action="{{ route('login') }}" class="space-y-3">
                @csrf
                <input type="hidden" name="redirect" value="{{ request('redirect', '/') }}">
                <input type="hidden" name="iframe" value="1">

                <label class="block text-sm" for="email">Correo electrónico</label>
                <input id="email" name="email" type="email" required autofocus class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2" placeholder="tu@email.com">

                <label class="block text-sm" for="password">Contraseña</label>
                <input id="password" name="password" type="password" required class="w-full rounded-lg border border-slate-200 bg-slate-50 px-3 py-2">

                <button type="submit" class="w-full rounded-lg bg-[#1a233a] px-4 py-2 font-semibold text-white transition hover:bg-[#233255]">Iniciar sesión</button>
            </form>
        </div>
    </div>
</body>
</html>
