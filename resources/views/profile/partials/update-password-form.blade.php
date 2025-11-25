<section class="space-y-6">

    <header class="mb-4">
        <h2 class="text-xl font-semibold text-slate-800">
            Actualizar contraseña
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            Usa una contraseña segura y difícil de adivinar.
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        {{-- Contraseña actual --}}
        <div class="space-y-1">
            <x-input-label for="update_password_current_password" value="Contraseña actual" class="text-slate-700 font-medium" />
            <x-text-input
                id="update_password_current_password"
                name="current_password"
                type="password"
                autocomplete="current-password"
                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2 
                       focus:border-blue-600 focus:ring-2 focus:ring-blue-500"
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="text-sm text-rose-600" />
        </div>

        {{-- Nueva contraseña --}}
        <div class="space-y-1">
            <x-input-label for="update_password_password" value="Nueva contraseña" class="text-slate-700 font-medium" />
            <x-text-input
                id="update_password_password"
                name="password"
                type="password"
                autocomplete="new-password"
                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2
                       focus:border-blue-600 focus:ring-2 focus:ring-blue-500"
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="text-sm text-rose-600" />
        </div>

        {{-- Confirmar contraseña --}}
        <div class="space-y-1">
            <x-input-label for="update_password_password_confirmation" value="Confirmar contraseña" class="text-slate-700 font-medium" />
            <x-text-input
                id="update_password_password_confirmation"
                name="password_confirmation"
                type="password"
                autocomplete="new-password"
                class="mt-1 block w-full rounded-lg border border-slate-300 px-3 py-2
                       focus:border-blue-600 focus:ring-2 focus:ring-blue-500"
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="text-sm text-rose-600" />
        </div>

        {{-- Botón Guardar --}}
        <div class="flex items-center gap-4">
            <button
                type="submit"
                class="px-5 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-semibold
                       hover:bg-blue-700 transition focus:ring-2 focus:ring-blue-400 focus:ring-offset-2"
            >
                Guardar contraseña
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-500"
                >
                    Contraseña actualizada.
                </p>
            @endif
        </div>

    </form>
</section>
