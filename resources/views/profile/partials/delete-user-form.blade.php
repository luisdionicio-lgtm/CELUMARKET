<section class="space-y-6">

    <header class="mb-4">
        <h2 class="text-xl font-semibold text-slate-800">
            Eliminar cuenta
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            Esta acción es permanente. Descarga cualquier información importante antes de continuar.
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-4 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 focus:ring-2 focus:ring-red-400 focus:ring-offset-2 text-white font-semibold"
    >
        Eliminar cuenta
    </x-danger-button>

    <!-- Modal de confirmación -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-6">
            @csrf
            @method('delete')

            <div>
                <h2 class="text-xl font-semibold text-slate-800">
                    ¿Deseas eliminar tu cuenta?
                </h2>
                <p class="mt-2 text-sm text-slate-500">
                    Una vez eliminada, no podrás recuperar tus datos. Confirma tu contraseña para continuar.
                </p>
            </div>

            {{-- Input contraseña --}}
            <div class="space-y-1">
                <x-input-label for="password" value="Contraseña" class="text-slate-700 sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Ingresa tu contraseña"
                    class="block w-full rounded-lg border border-slate-300 px-3 py-2 
                           focus:border-red-600 focus:ring-2 focus:ring-red-500"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="text-sm text-rose-600" />
            </div>

            {{-- Botones --}}
            <div class="flex justify-end gap-3 pt-4 border-t border-slate-200">

                <button
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="px-4 py-2 rounded-lg text-sm font-medium text-slate-600 hover:text-slate-800 
                           focus:ring-2 focus:ring-slate-300"
                >
                    Cancelar
                </button>

                <x-danger-button
                    class="px-4 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold focus:ring-2 focus:ring-red-400 focus:ring-offset-2"
                >
                    Eliminar cuenta
                </x-danger-button>

            </div>
        </form>
    </x-modal>

</section>
