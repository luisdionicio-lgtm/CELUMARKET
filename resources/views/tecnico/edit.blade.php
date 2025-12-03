@extends('layouts.app')

@section('title', 'Gestionar Ticket')

@php
    $statusOptions = [
        'open' => 'Abierto',
        'in-progress' => 'En proceso',
        'resolved' => 'Resuelto',
        'closed' => 'Cerrado',
    ];
    $priorityOptions = [
        'high' => 'Alta',
        'medium' => 'Media',
        'low' => 'Baja',
    ];
@endphp

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <a href="{{ route('tecnico.dashboard') }}" class="text-sm text-indigo-600 hover:underline">
        Volver al panel técnico
    </a>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-slate-500">Ticket #{{ $ticket->id }}</p>
                <h2 class="text-2xl font-semibold text-primary">{{ $ticket->subject }}</h2>
                <p class="text-sm text-slate-500">Cliente: {{ $ticket->user?->name ?? 'N/D' }} | Email: {{ $ticket->user?->email ?? 'N/D' }}</p>
            </div>
            <div class="rounded-full bg-slate-900 px-3 py-1.5 text-xs font-semibold text-white">
                Estado: {{ $statusOptions[$ticket->status] ?? ucfirst(str_replace('-', ' ', $ticket->status)) }}
            </div>
        </div>

        <div class="mt-4 grid gap-3 text-sm text-slate-600 md:grid-cols-2">
            <div class="rounded-xl bg-slate-50 px-4 py-3">
                <p class="font-semibold text-slate-800">Detalle del cliente</p>
                <p class="mt-1">Orden: {{ $ticket->order_number ?? 'No indicado' }}</p>
                <p>Producto: {{ $ticket->product_name ?? 'No indicado' }}</p>
            </div>
            <div class="rounded-xl bg-slate-50 px-4 py-3">
                <p class="font-semibold text-slate-800">Asignación</p>
                <p class="mt-1">
                    Técnico asignado:
                    {{ $ticket->technician?->name ?? 'Pendiente de asignación' }}
                </p>
                <p class="text-xs text-slate-500 mt-1">Al guardar, el ticket quedará asignado a ti si aún no lo está.</p>
            </div>
        </div>

        <form action="{{ route('tecnico.tickets.update', $ticket) }}" method="POST" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Estado *</label>
                    <select name="status" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $ticket->status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Prioridad *</label>
                    <select name="priority" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @foreach ($priorityOptions as $value => $label)
                            <option value="{{ $value }}" @selected(old('priority', $ticket->priority) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('priority')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">Comentario técnico</label>
                <textarea name="comentarios_tecnico" rows="5" class="mt-1 w-full rounded-2xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Describe diagnóstico, pruebas o próximos pasos">{{ old('comentarios_tecnico', $ticket->comentarios_tecnico) }}</textarea>
                @error('comentarios_tecnico')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="rounded-xl bg-slate-50 px-4 py-3 text-sm text-slate-600">
                {{ $ticket->description ?: 'Sin descripción del cliente.' }}
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('tecnico.dashboard') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">Cancelar</a>
                <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
