@extends('layouts.app')

@section('title', 'Centro de Soporte')

@php
    $statuses = [
        'open' => 'Abiertos',
        'in-progress' => 'En proceso',
        'resolved' => 'Resueltos',
        'closed' => 'Cerrados',
    ];
    $priorityColors = [
        'high' => 'bg-rose-100 text-rose-800',
        'medium' => 'bg-amber-100 text-amber-800',
        'low' => 'bg-emerald-100 text-emerald-700',
    ];
    $typeLabels = [
        'warranty' => 'Garantía',
        'return' => 'Devolución',
        'complaint' => 'Reclamo',
        'inquiry' => 'Consulta',
    ];
@endphp

@section('content')
@php
    $user = auth()->user();
    $roleLabel = $user->isAdmin()
        ? 'Administrador'
        : ($user->isTecnico() ? 'Técnico' : 'Usuario');
@endphp

<div class="mx-auto max-w-6xl space-y-8" x-data="{ tab: 'tickets' }">
    <section class="rounded-3xl bg-[#0B1222] px-8 py-10 text-white shadow-2xl shadow-slate-900/40">
        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.45em] text-white/70">Centro de Soporte</p>
                <h1 class="mt-3 text-3xl font-bold leading-tight">Gestiona tus tickets y mantén comunicación con CELU MARKET</h1>
                <p class="mt-2 text-sm text-white/70">
                    {{ $user->name }} — {{ $roleLabel }}
                </p>
                <p class="mt-3 text-sm text-white/80">
                    Crea solicitudes, revisa actualizaciones y encuentra respuestas rápidas en un solo lugar.
                </p>
                <div class="mt-6 flex flex-wrap gap-4">
                    <a href="{{ route('tickets.create') }}" class="inline-flex items-center rounded-2xl bg-white px-5 py-3 text-sm font-semibold text-[#0B1222] transition hover:-translate-y-0.5 hover:bg-slate-100">
                        <i class="fa-solid fa-plus-circle mr-2"></i> Nuevo Ticket
                    </a>
                    <a href="{{ route('support.index') }}" class="inline-flex items-center rounded-2xl border border-white/20 px-5 py-3 text-sm font-semibold text-white transition hover:-translate-y-0.5 hover:bg-white/10">
                        Ver guía de soporte
                    </a>
                </div>
            </div>
            <div class="grid gap-4 text-sm text-white/80">
                <div class="rounded-2xl bg-white/10 p-4">
                    <p class="text-xs uppercase tracking-[0.35em] text-white/60">Contacto directo</p>
                    <p class="mt-2 font-semibold">+51 900 123 456</p>
                    <p>soporte@celumarket.pe</p>
                </div>
                <div class="rounded-2xl bg-white/10 p-4">
                    <p class="text-xs uppercase tracking-[0.35em] text-white/60">Chat 24/7</p>
                    <p class="mt-2 font-semibold">Disponible en la esquina inferior derecha</p>
                </div>
            </div>
        </div>
    </section>

    <section class="grid gap-4 md:grid-cols-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="rounded-2xl bg-indigo-100 p-3 text-indigo-600"><i class="fa-solid fa-phone"></i></span>
                <div>
                    <p class="font-semibold text-secondary">Llámanos</p>
                    <p class="text-sm text-slate-500">+51 900 123 456</p>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="rounded-2xl bg-emerald-100 p-3 text-emerald-600"><i class="fa-solid fa-envelope"></i></span>
                <div>
                    <p class="font-semibold text-secondary">Correo</p>
                    <p class="text-sm text-slate-500">soporte@celumarket.pe</p>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center gap-3">
                <span class="rounded-2xl bg-rose-100 p-3 text-rose-600"><i class="fa-solid fa-comments"></i></span>
                <div>
                    <p class="font-semibold text-secondary">Chat en vivo</p>
                    <p class="text-sm text-slate-500">Disponible las 24 horas.</p>
                </div>
            </div>
        </div>
    </section>

    @if(session('success'))
        <div id="ticket-flash" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm transition-opacity duration-500">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => {
                const el = document.getElementById('ticket-flash');
                if (!el) return;
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            }, 4000);
        </script>
    @endif

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-md">
        <div class="flex flex-wrap gap-3 border-b border-slate-200 pb-4 text-sm font-semibold">
            <button type="button" @click="tab = 'tickets'" :class="tab === 'tickets' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="rounded-full px-4 py-2 transition">Mis Tickets</button>
            <button type="button" @click="tab = 'faq'" :class="tab === 'faq' ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200'" class="rounded-full px-4 py-2 transition">Preguntas Frecuentes</button>
        </div>

        <div x-show="tab === 'tickets'" class="mt-6 space-y-4" x-transition>
            <div class="flex flex-wrap gap-3 text-sm font-semibold">
                <a href="{{ route('tickets.index') }}" class="rounded-full px-4 py-2 {{ request('status') ? 'text-slate-500 bg-slate-100 hover:bg-slate-200' : 'bg-slate-900 text-white' }}">Todos</a>
                @foreach ($statuses as $value => $label)
                    <a href="{{ route('tickets.index', ['status' => $value]) }}" class="rounded-full px-4 py-2 {{ request('status') === $value ? 'bg-slate-900 text-white' : 'text-slate-500 bg-slate-100 hover:bg-slate-200' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            @if($tickets->isEmpty())
                <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                    No se encontraron tickets con este filtro.
                </div>
            @else
                <div class="space-y-4">
                    @foreach ($tickets as $ticket)
                        <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                            <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                                <div>
                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-xs font-mono text-slate-400">#{{ $ticket->id }}</span>
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">{{ $typeLabels[$ticket->type] ?? $ticket->type }}</span>
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $priorityColors[$ticket->priority] ?? 'bg-slate-100 text-slate-700' }}">
                                            Prioridad {{ ucfirst($ticket->priority) }}
                                        </span>
                                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                            {{ ucfirst(str_replace('-', ' ', $ticket->status)) }}
                                        </span>
                                    </div>
                                    <h3 class="mt-3 text-lg font-semibold text-secondary">{{ $ticket->subject }}</h3>
                                    <p class="mt-1 text-sm text-slate-500 line-clamp-2">{{ $ticket->description ?? 'Sin descripción' }}</p>
                                    @if($ticket->comentarios_tecnico)
                                        <div class="mt-3 rounded-xl bg-slate-50 px-3 py-2 text-xs text-slate-700">
                                            <p class="font-semibold text-slate-900 mb-1">Notas técnicas</p>
                                            <p class="leading-relaxed">{{ $ticket->comentarios_tecnico }}</p>
                                        </div>
                                    @endif
                                    <div class="mt-3 flex flex-wrap gap-4 text-xs text-slate-400">
                                        <span>Creado: {{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                                        <span>Actualizado: {{ $ticket->updated_at->format('d/m/Y H:i') }}</span>
                                        @if($ticket->product_name)
                                            <span>Producto: {{ $ticket->product_name }}</span>
                                        @endif
                                        @if($ticket->technician)
                                            <span>Técnico: {{ $ticket->technician->name }}</span>
                                        @endif
                                    </div>
                                </div>
                        @if(auth()->user()->isAdmin())
                            <div class="flex flex-col items-end gap-2 text-sm font-semibold md:text-right">
                                <a href="{{ route('tickets.edit', $ticket) }}" class="text-indigo-600 hover:underline">Editar</a>
                                <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" onsubmit="return confirm('¿Eliminar este ticket?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:underline">Eliminar</button>
                                </form>
                            </div>
                        @endif
                    </div>
                </article>
            @endforeach
                </div>
            @endif
        </div>

        <div x-show="tab === 'faq'" class="mt-6 space-y-4" x-transition>
            @foreach ([
                ['title' => '¿Cómo hago seguimiento a mi garantía?', 'body' => 'Crea un ticket seleccionando el tipo "Garantía" e incluye tu número de pedido. Recibirás actualizaciones por correo y dentro del centro de soporte.'],
                ['title' => '¿En cuánto tiempo responden?', 'body' => 'Nuestro equipo responde en menos de 24 horas hábiles. Los tickets con prioridad alta son atendidos en menos de 4 horas.'],
                ['title' => '¿Dónde veo el estado de mi pedido?', 'body' => 'Puedes revisar tu panel de pedidos o crear un ticket indicando tu número de pedido para recibir asistencia personalizada.'],
            ] as $faq)
                <details class="rounded-2xl border border-slate-200 p-4 transition hover:border-indigo-200 hover:bg-indigo-50/40">
                    <summary class="cursor-pointer text-sm font-semibold text-secondary">{{ $faq['title'] }}</summary>
                    <p class="mt-2 text-sm text-slate-600">{{ $faq['body'] }}</p>
                </details>
            @endforeach
        </div>
    </section>
</div>
@endsection
