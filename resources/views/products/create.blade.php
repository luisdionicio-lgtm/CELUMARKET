@extends('layouts.app')

@section('title', 'Agregar Producto')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <a href="{{ route('products.index') }}" class="text-sm text-indigo-600 hover:underline">
        ← Volver a productos
    </a>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-2xl font-semibold text-primary">Nuevo Producto</h2>
        <p class="text-sm text-slate-500">Registra un producto disponible para la venta.</p>

        <form action="{{ route('products.store') }}" method="POST" class="mt-6 space-y-5">
            @csrf

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Nombre *</label>
                    <input type="text" name="nombre" value="{{ old('nombre') }}" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej. iPhone 15" required>
                    @error('nombre')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Precio *</label>
                    <input type="number" step="0.01" name="precio" value="{{ old('precio') }}" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="S/ 0.00" required>
                    @error('precio')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Stock *</label>
                    <input type="number" name="stock" value="{{ old('stock', 0) }}" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" min="0" required>
                    @error('stock')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('products.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">Cancelar</a>
                <button type="submit" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white transition hover:bg-secondary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
