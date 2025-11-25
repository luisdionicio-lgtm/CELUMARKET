@extends('layouts.admin')

@section('content')
<section class="max-w-4xl mx-auto py-12 px-4 sm:px-6 lg:px-8">

    <a href="{{ route('admin.dashboard') }}"
       class="inline-flex items-center mb-6 px-4 py-2 text-sm font-semibold bg-slate-700 text-white rounded-lg hover:bg-slate-600 transition">
        <i class="fa-solid fa-arrow-left mr-2"></i> Volver al panel
    </a>

    <h2 class="text-2xl font-bold text-slate-900 mb-6">Perfil de administrador</h2>

    @if (session('success'))
        <div class="mb-6 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Datos básicos --}}
    <form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-5 mb-10 bg-white rounded-xl shadow-sm p-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium text-slate-700">Nombre</label>
            <input type="text" name="name" id="name"
                value="{{ old('name', Auth::user()->name) }}"
                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-[#1a233a] focus:ring-[#1a233a]">
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-slate-700">Correo electrónico</label>
            <input type="email" name="email" id="email"
                value="{{ old('email', Auth::user()->email) }}"
                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-[#1a233a] focus:ring-[#1a233a]">
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#1a233a] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#303a58]">
                <i class="fa-solid fa-floppy-disk"></i> Guardar cambios
            </button>
        </div>
    </form>

    {{-- Cambio de contraseña --}}
    <form method="POST" action="{{ route('admin.profile.password') }}" class="space-y-5 bg-white rounded-xl shadow-sm p-6">
        @csrf
        @method('PUT')

        <h3 class="text-lg font-semibold text-slate-900">Actualizar contraseña</h3>

        <div>
            <label for="current_password" class="block text-sm font-medium text-slate-700">Contraseña actual</label>
            <input type="password" name="current_password" id="current_password"
                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-[#1a233a] focus:ring-[#1a233a]">
            @error('current_password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="new_password" class="block text-sm font-medium text-slate-700">Nueva contraseña</label>
            <input type="password" name="new_password" id="new_password"
                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-[#1a233a] focus:ring-[#1a233a]">
            @error('new_password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="new_password_confirmation" class="block text-sm font-medium text-slate-700">Confirmar nueva contraseña</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                class="mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-[#1a233a] focus:ring-[#1a233a]">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-[#1a233a] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#303a58]">
                <i class="fa-solid fa-key"></i> Actualizar contraseña
            </button>
        </div>
    </form>
</section>
@endsection
