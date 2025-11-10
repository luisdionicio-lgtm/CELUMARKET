@extends('layouts.app')

@section('title', 'Pedidos')

@php
    $statusStyles = [
        'pending' => 'bg-amber-100 text-amber-800',
        'processing' => 'bg-blue-100 text-blue-800',
        'delivered' => 'bg-emerald-100 text-emerald-700',
        'cancelled' => 'bg-rose-100 text-rose-700',
    ];
@endphp

@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-md">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Operaciones</p>
                <h1 class="text-2xl font-semibold text-primary">Gestión de Pedidos</h1>
                <p class="text-sm text-slate-500">Administra el estado de los pedidos registrados.</p>
            </div>
            <a href="{{ route('orders.create') }}" class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                <i class="fa-solid fa-plus mr-2"></i>
                Nuevo Pedido
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-xs font-semibold uppercase tracking-wider text-slate-500">
                <tr>
                    <th class="px-4 py-3">Cliente</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Fecha</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($orders as $order)
                    <tr class="transition hover:bg-slate-50">
                        <td class="px-4 py-3 font-medium text-slate-900">{{ $order->user->name ?? 'Usuario eliminado' }}</td>
                        <td class="px-4 py-3 font-semibold text-secondary">S/ {{ number_format($order->total, 2) }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $statusStyles[$order->status] ?? 'bg-slate-100 text-slate-600' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-slate-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex gap-2 text-sm font-semibold">
                                <a href="{{ route('orders.edit', $order) }}" class="text-indigo-600 hover:underline">Editar</a>
                                <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('¿Eliminar este pedido?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:underline">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center text-slate-500">Aún no se registran pedidos.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
