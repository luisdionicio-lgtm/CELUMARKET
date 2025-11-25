<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-semibold text-slate-800">
            Mi Perfil
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50">
        <div class="max-w-4xl mx-auto space-y-10">

            {{-- Información del perfil --}}
            <div class="bg-white shadow-sm rounded-2xl p-8 border border-slate-200">
                @include('profile.partials.update-profile-information-form')
            </div>

            {{-- Cambiar contraseña --}}
            <div class="bg-white shadow-sm rounded-2xl p-8 border border-slate-200">
                <h3 class="text-xl font-semibold text-slate-800 mb-1">Cambiar Contraseña</h3>
                <p class="text-sm text-slate-500 mb-6">
                    Usa una contraseña fuerte para proteger tu cuenta.
                </p>

                @include('profile.partials.update-password-form')
            </div>

            {{-- Eliminar cuenta --}}
            <div class="bg-white shadow-sm rounded-2xl p-8 border border-slate-200">
                <h3 class="text-xl font-semibold text-rose-600 mb-1">Eliminar Cuenta</h3>
                <p class="text-sm text-slate-500 mb-6">
                    Esta acción es irreversible. Ingresa tu contraseña para confirmar.
                </p>

                @include('profile.partials.delete-user-form')
            </div>

        </div>
    </div>
</x-app-layout>
