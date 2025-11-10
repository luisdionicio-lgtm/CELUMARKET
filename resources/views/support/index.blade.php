@extends('layouts.app')

@section('title', 'Centro de Soporte')

@section('content')
<div class="mx-auto max-w-6xl space-y-10">
    <section class="overflow-hidden rounded-3xl bg-[#0B1222] text-white shadow-2xl shadow-slate-900/40">
        <div class="grid gap-8 px-8 py-12 md:grid-cols-2 md:items-center">
            <div>
                <p class="text-xs uppercase tracking-[0.45em] text-white/70">Soporte oficial</p>
                <h1 class="mt-4 text-4xl font-bold leading-tight">Bienvenido al Centro de Soporte de CELU MARKET</h1>
                <p class="mt-4 text-base text-white/80">
                    Reporta problemas, solicita garantías o consulta tus pedidos fácilmente. Nuestro equipo está disponible para ayudarte 24/7.
                </p>
                <div class="mt-8 flex flex-wrap gap-4">
                    <a href="{{ route('tickets.index') }}" class="inline-flex items-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-[#0B1222] transition hover:-translate-y-0.5 hover:bg-slate-100">
                        Ir al Centro de Soporte
                    </a>
                    <a href="{{ route('tickets.create') }}" class="inline-flex items-center rounded-2xl border border-white/30 px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-white/10">
                        Crear ticket
                    </a>
                </div>
            </div>
            <div class="relative">
                <div class="rounded-2xl bg-white/10 p-6 backdrop-blur">
                    <h3 class="text-lg font-semibold">¿Cómo podemos ayudarte?</h3>
                    <ul class="mt-4 space-y-3 text-sm text-white/80">
                        <li class="flex items-start gap-3">
                            <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white/20 text-xs font-semibold">1</span>
                            Reporta fallas o solicita garantías desde un solo lugar.
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white/20 text-xs font-semibold">2</span>
                            Da seguimiento en tiempo real al estado de tus tickets.
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="mt-1 inline-flex h-6 w-6 items-center justify-center rounded-full bg-white/20 text-xs font-semibold">3</span>
                            Obtén contacto directo con especialistas CELU MARKET.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-6 md:grid-cols-2">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-md">
            <h3 class="text-xl font-semibold text-primary">Opciones rápidas</h3>
            <p class="mt-2 text-sm text-slate-500">Selecciona el tipo de atención que necesitas.</p>
            <div class="mt-5 grid gap-4 sm:grid-cols-2">
                <a href="{{ route('tickets.create', ['type' => 'warranty']) }}" class="rounded-2xl border border-slate-200 px-4 py-3 transition hover:-translate-y-0.5 hover:border-indigo-200 hover:bg-indigo-50">
                    <h4 class="font-semibold text-secondary">Garantías</h4>
                    <p class="text-sm text-slate-500">Reporta problemas de fábrica.</p>
                </a>
                <a href="{{ route('tickets.create', ['type' => 'return']) }}" class="rounded-2xl border border-slate-200 px-4 py-3 transition hover:-translate-y-0.5 hover:border-indigo-200 hover:bg-indigo-50">
                    <h4 class="font-semibold text-secondary">Devoluciones</h4>
                    <p class="text-sm text-slate-500">Inicia cambios o reembolsos.</p>
                </a>
                <a href="{{ route('tickets.create', ['type' => 'complaint']) }}" class="rounded-2xl border border-slate-200 px-4 py-3 transition hover:-translate-y-0.5 hover:border-indigo-200 hover:bg-indigo-50">
                    <h4 class="font-semibold text-secondary">Reclamos</h4>
                    <p class="text-sm text-slate-500">Notifica incidencias con tu pedido.</p>
                </a>
                <a href="{{ route('tickets.create', ['type' => 'inquiry']) }}" class="rounded-2xl border border-slate-200 px-4 py-3 transition hover:-translate-y-0.5 hover:border-indigo-200 hover:bg-indigo-50">
                    <h4 class="font-semibold text-secondary">Consultas</h4>
                    <p class="text-sm text-slate-500">Resuelve dudas generales.</p>
                </a>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-md">
            <h3 class="text-xl font-semibold text-primary">Canales de contacto</h3>
            <p class="mt-2 text-sm text-slate-500">Si necesitas ayuda inmediata, utiliza estos canales.</p>
            <div class="mt-5 space-y-4 text-sm text-slate-600">
                <div class="flex items-center gap-3 rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3">
                    <i class="fa-solid fa-phone text-primary"></i>
                    <div>
                        <p class="font-semibold text-secondary">Atención telefónica</p>
                        <p>+51 900 123 456</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3">
                    <i class="fa-solid fa-envelope text-primary"></i>
                    <div>
                        <p class="font-semibold text-secondary">Correo de soporte</p>
                        <p>soporte@celumarket.pe</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 rounded-2xl border border-slate-100 bg-slate-50 px-4 py-3">
                    <i class="fa-solid fa-comments text-primary"></i>
                    <div>
                        <p class="font-semibold text-secondary">Chat en vivo</p>
                        <p>Disponible 24/7 en la parte inferior derecha del sitio.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
