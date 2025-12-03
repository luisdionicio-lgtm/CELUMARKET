@extends('layouts.app')

@section('title', 'Panel Técnico')

@php
    $statusLabels = [
        'open' => 'Abierto',
        'in-progress' => 'En proceso',
        'resolved' => 'Resuelto',
        'closed' => 'Cerrado',
    ];
    $priorityLabels = [
        'high' => ['label' => 'Alta', 'classes' => 'bg-rose-100 text-rose-700'],
        'medium' => ['label' => 'Media', 'classes' => 'bg-amber-100 text-amber-700'],
        'low' => ['label' => 'Baja', 'classes' => 'bg-emerald-100 text-emerald-700'],
    ];
@endphp

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <header class="rounded-3xl bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 px-8 py-10 text-white shadow-xl">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-white/60">Panel Técnico</p>
                <h1 class="mt-2 text-3xl font-bold leading-tight">Soporte y tickets asignados</h1>
                <p class="mt-2 text-sm text-white/70">Revisa, toma y actualiza los tickets que requieren intervención técnica.</p>
            </div>
            <div class="grid grid-cols-2 gap-3 text-sm text-white/80 md:grid-cols-4">
                <div class="rounded-2xl bg-white/10 p-4">
                    <p class="text-[11px] uppercase tracking-[0.25em] text-white/60">En la vista</p>
                    <p class="text-2xl font-semibold">{{ $tickets->count() }}</p>
                </div>
                <div class="rounded-2xl bg-white/10 p-4">
                    <p class="text-[11px] uppercase tracking-[0.25em] text-white/60">Asignados a ti</p>
                    <p class="text-2xl font-semibold">
                        {{ collect($tickets->items())->filter(fn ($t) => $t->tecnico_id === auth()->id())->count() }}
                    </p>
                </div>
                <div class="rounded-2xl bg-white/10 p-4">
                    <p class="text-[11px] uppercase tracking-[0.25em] text-white/60">Sin asignar</p>
                    <p class="text-2xl font-semibold">
                        {{ collect($tickets->items())->filter(fn ($t) => is_null($t->tecnico_id))->count() }}
                    </p>
                </div>
                <div class="rounded-2xl bg-white/10 p-4">
                    <p class="text-[11px] uppercase tracking-[0.25em] text-white/60">Filtro</p>
                    <p class="text-2xl font-semibold">
                        {{ $status ? ($statusLabels[$status] ?? $status) : 'Todos' }}
                    </p>
                </div>
            </div>
        </div>
    </header>

    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-wrap items-center gap-3 border-b border-slate-200 pb-4">
            <a href="{{ route('tecnico.dashboard') }}"
               class="rounded-full px-4 py-2 text-sm font-semibold {{ $status ? 'bg-slate-100 text-slate-600 hover:bg-slate-200' : 'bg-slate-900 text-white' }}">
                Todos
            </a>
            @foreach($statusLabels as $value => $label)
                <a href="{{ route('tecnico.dashboard', ['status' => $value]) }}"
                   class="rounded-full px-4 py-2 text-sm font-semibold {{ $status === $value ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        @if($tickets->isEmpty())
            <div class="mt-6 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-8 text-center text-slate-500">
                No hay tickets para mostrar con el filtro seleccionado.
            </div>
        @else
            <div class="mt-6 grid gap-4">
                @foreach($tickets as $ticket)
                    <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-lg">
                        <div class="flex flex-col gap-3 md:flex-row md:justify-between">
                            <div class="space-y-2">
                                <div class="flex flex-wrap items-center gap-2 text-xs font-semibold">
                                    <span class="rounded-full bg-slate-100 px-3 py-1 text-slate-600">#{{ $ticket->id }}</span>
                                    <span class="rounded-full bg-slate-900 px-3 py-1 text-white">{{ $statusLabels[$ticket->status] ?? ucfirst(str_replace('-', ' ', $ticket->status)) }}</span>
                                    <span class="rounded-full px-3 py-1 {{ $priorityLabels[$ticket->priority]['classes'] ?? 'bg-slate-100 text-slate-700' }}">
                                        Prioridad {{ $priorityLabels[$ticket->priority]['label'] ?? $ticket->priority }}
                                    </span>
                                    @if($ticket->tecnico_id)
                                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-emerald-700">
                                            Técnico: {{ $ticket->technician?->name ?? 'N/A' }}
                                        </span>
                                    @else
                                        <span class="rounded-full bg-amber-100 px-3 py-1 text-amber-700">Sin asignar</span>
                                    @endif
                                </div>
                                <h3 class="text-lg font-semibold text-slate-900">{{ $ticket->subject }}</h3>
                                <p class="text-sm text-slate-600 line-clamp-2">{{ $ticket->description ?? 'Sin descripción' }}</p>
                                <div class="text-xs text-slate-500 flex flex-wrap gap-3">
                                    <span>Cliente: {{ $ticket->user?->name ?? 'N/A' }}</span>
                                    @if($ticket->order_number)
                                        <span>Orden: {{ $ticket->order_number }}</span>
                                    @endif
                                    @if($ticket->product_name)
                                        <span>Producto: {{ $ticket->product_name }}</span>
                                    @endif
                                    <span>Actualizado: {{ $ticket->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                                @if($ticket->comentarios_tecnico)
                                    <div class="rounded-xl bg-slate-50 px-4 py-3 text-sm text-slate-700">
                                        <p class="font-semibold text-slate-900 mb-1">Comentario técnico</p>
                                        <p class="leading-relaxed">{{ $ticket->comentarios_tecnico }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="flex flex-col items-start gap-2 md:items-end text-sm font-semibold">
                                <a href="{{ route('tecnico.tickets.edit', $ticket) }}" class="inline-flex items-center gap-2 rounded-full bg-slate-900 px-4 py-2 text-white hover:bg-slate-800">
                                    <i class="fa-solid fa-pen-to-square"></i> Actualizar
                                </a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('tickets.edit', $ticket) }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-700">
                                        Ver en panel general
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $tickets->links() }}
            </div>
        @endif
    </section>
</div>
@endsection
