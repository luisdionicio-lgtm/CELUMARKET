@extends('layouts.app')

@section('title', 'Nuevo Pedido')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <a href="{{ route('orders.index') }}" class="text-sm text-indigo-600 hover:underline">
        ← Volver a pedidos
    </a>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-2xl font-semibold text-primary">Registrar Pedido</h2>
        <p class="text-sm text-slate-500">Asigna un pedido a un cliente y define su estado.</p>

        <form action="{{ route('orders.store') }}" method="POST" class="mt-6 space-y-5">
            @csrf

            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="text-sm font-semibold text-slate-700">Cliente *</label>
                    <select name="user_id" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Selecciona un usuario</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" @selected(old('user_id') == $user->id)>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Total *</label>
                    <input type="number" step="0.01" name="total" value="{{ old('total') }}" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="S/ 0.00" required>
                    @error('total')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-sm font-semibold text-slate-700">Estado *</label>
                    <select name="status" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        @foreach (['pending' => 'Pendiente', 'processing' => 'En proceso', 'delivered' => 'Entregado', 'cancelled' => 'Cancelado'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', 'pending') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('orders.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">Cancelar</a>
                <button type="submit" class="rounded-xl bg-primary px-4 py-2 text-sm font-semibold text-white transition hover:bg-secondary">Guardar</button>
            </div>
        </form>
    </div>
</div>
@endsection
