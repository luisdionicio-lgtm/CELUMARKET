<section class="space-y-6">

    <header class="mb-4">
        <h2 class="text-xl font-semibold text-slate-800">
            Información Personal
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            Actualiza tu nombre y correo electrónico.
        </p>
    </header>

    {{-- Reenviar verificación --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Formulario principal --}}
    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        {{-- Nombre --}}
        <div class="space-y-1">
            <x-input-label for="name" value="Nombre" class="text-slate-700 font-medium" />
            <x-text-input
                id="name"
                name="name"
                type="text"
                class="mt-1 block w-full rounded-lg bg-white text-slate-800 border border-slate-300 px-3 py-2 shadow-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-500"
                :value="old('name', $user->name)"
                required autofocus autocomplete="name"
            />
            <x-input-error class="text-sm text-rose-600" :messages="$errors->get('name')" />
        </div>

        {{-- Correo --}}
        <div class="space-y-1">
            <x-input-label for="email" value="Correo electrónico" class="text-slate-700 font-medium" />
            <x-text-input
                id="email"
                name="email"
                type="email"
                class="mt-1 block w-full rounded-lg bg-white text-slate-800 border border-slate-300 px-3 py-2 shadow-sm focus:border-blue-600 focus:ring-2 focus:ring-blue-500"
                :value="old('email', $user->email)"
                required autocomplete="username"
            />
            <x-input-error class="text-sm text-rose-600" :messages="$errors->get('email')" />

            {{-- Mensaje de verificación --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-slate-600">
                        Tu correo electrónico no está verificado.

                        <button form="send-verification"
                            class="underline text-sm text-blue-600 hover:text-blue-800 ml-1">
                            Reenviar correo de verificación
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-sm font-medium text-emerald-600">
                            Se ha enviado un nuevo enlace a tu correo electrónico.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Botón Guardar --}}
        <div class="flex items-center gap-4">
            <button
                type="submit"
                class="px-5 py-2.5 rounded-lg bg-blue-600 text-white text-sm font-semibold hover:bg-blue-700 transition focus:ring-2 focus:ring-blue-400 focus:ring-offset-2"
            >
                Guardar cambios
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-slate-500"
                >
                    Perfil actualizado.
                </p>
            @endif
        </div>
    </form>
</section>
