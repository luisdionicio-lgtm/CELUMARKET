@extends('layouts.app')

@section('title', 'Editar Ticket')

@php
    $statusOptions = [
        'open' => 'Abierto',
        'in-progress' => 'En proceso',
        'resolved' => 'Resuelto',
        'closed' => 'Cerrado',
    ];
    $readOnly = !auth()->user()->isAdmin();
@endphp

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <a href="{{ route('tickets.index') }}" class="text-sm text-indigo-600 hover:underline">
        ← Volver al centro de soporte
    </a>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg">
        <h2 class="text-2xl font-semibold text-primary">Editar Ticket</h2>
        <p class="text-sm text-slate-500">Actualiza la prioridad, estado o detalles del ticket.</p>

        @if($readOnly)
            <div class="mt-4 rounded-xl border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-700">
                Solo el administrador puede modificar la información de un ticket. Los campos se muestran en modo lectura.
            </div>
        @endif

        <form action="{{ route('tickets.update', $ticket) }}" method="POST" class="mt-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Tipo *</label>
                    <select name="type" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-slate-100 disabled:text-slate-500" required @disabled($readOnly)>
                        @foreach (['warranty' => 'Garantía', 'return' => 'Devolución', 'complaint' => 'Reclamo', 'inquiry' => 'Consulta'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('type', $ticket->type) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Prioridad *</label>
                    <select name="priority" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-slate-100 disabled:text-slate-500" required @disabled($readOnly)>
                        @foreach (['low' => 'Baja', 'medium' => 'Media', 'high' => 'Alta'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('priority', $ticket->priority) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('priority')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Estado *</label>
                    <select name="status" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-slate-100 disabled:text-slate-500" required @disabled($readOnly)>
                        @foreach ($statusOptions as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $ticket->status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Número de pedido</label>
                    <input type="text" name="order_number" value="{{ old('order_number', $ticket->order_number) }}" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-slate-100 disabled:text-slate-500" @disabled($readOnly)>
                    @error('order_number')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Producto</label>
                    <input type="text" name="product_name" value="{{ old('product_name', $ticket->product_name) }}" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-slate-100 disabled:text-slate-500" @disabled($readOnly)>
                    @error('product_name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">Asunto *</label>
                <input type="text" name="subject" value="{{ old('subject', $ticket->subject) }}" class="mt-1 w-full rounded-2xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-slate-100 disabled:text-slate-500" required @disabled($readOnly)>
                @error('subject')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">Descripción</label>
                <textarea name="description" rows="6" class="mt-1 w-full rounded-2xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-slate-100 disabled:text-slate-500" @disabled($readOnly)>{{ old('description', $ticket->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Asignar técnico</label>
                    <select name="tecnico_id" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-slate-100 disabled:text-slate-500" @disabled($readOnly)>
                        <option value="">Sin asignar</option>
                        @foreach($technicians as $technician)
                            <option value="{{ $technician->id }}" @selected(old('tecnico_id', $ticket->tecnico_id) == $technician->id)>
                                {{ $technician->name }} ({{ $technician->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('tecnico_id')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Notas técnicas</label>
                    <textarea name="comentarios_tecnico" rows="3" class="mt-1 w-full rounded-2xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-slate-100 disabled:text-slate-500" @disabled($readOnly)>{{ old('comentarios_tecnico', $ticket->comentarios_tecnico) }}</textarea>
                    @error('comentarios_tecnico')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('tickets.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-100">Cerrar</a>
                @if(!$readOnly)
                    <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                        Guardar cambios
                    </button>
                @endif
            </div>
        </form>
    </div>
</div>
@endsection
