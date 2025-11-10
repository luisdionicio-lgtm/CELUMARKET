@extends('layouts.app')

@section('title', 'Nuevo Ticket')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <a href="{{ route('tickets.index') }}" class="text-sm text-indigo-600 hover:underline">
        ← Volver al centro de soporte
    </a>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-lg">
        <h2 class="text-2xl font-semibold text-primary">Crear Ticket</h2>
        <p class="text-sm text-slate-500">Describe tu solicitud para que el equipo pueda ayudarte.</p>

        <form action="{{ route('tickets.store') }}" method="POST" class="mt-6 space-y-6">
            @csrf

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Tipo de ticket *</label>
                    <select name="type" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @foreach (['warranty' => 'Garantía', 'return' => 'Devolución', 'complaint' => 'Reclamo', 'inquiry' => 'Consulta'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('type', request('type')) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('type')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Prioridad *</label>
                    <select name="priority" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @foreach (['low' => 'Baja', 'medium' => 'Media', 'high' => 'Alta'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('priority', 'medium') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('priority')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">Asunto *</label>
                <input type="text" name="subject" value="{{ old('subject') }}" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej. Solicito garantía del producto" required>
                @error('subject')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Número de pedido</label>
                    <input type="text" name="order_number" value="{{ old('order_number') }}" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="ORD-00001">
                    @error('order_number')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Nombre del producto</label>
                    <input type="text" name="product_name" value="{{ old('product_name') }}" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej. Samsung S24">
                    @error('product_name')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">Descripción *</label>
                <textarea name="description" rows="6" class="mt-1 w-full rounded-2xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Cuéntanos qué ocurrió..." required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('tickets.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">Cancelar</a>
                <button type="submit" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white transition hover:bg-secondary">Crear Ticket</button>
            </div>
        </form>
    </div>
</div>
@endsection
