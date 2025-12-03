@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-slate-900">Pedidos</h2>
        @if(session('success'))
            <div class="text-sm text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-lg px-3 py-2">
                {{ session('success') }}
            </div>
        @endif
    </div>

    @php
        $statusLabels = [
            'pending' => ['label' => 'Pendiente', 'class' => 'bg-amber-50 text-amber-700 ring-amber-200'],
            'processing' => ['label' => 'En proceso', 'class' => 'bg-sky-50 text-sky-700 ring-sky-200'],
            'completed' => ['label' => 'Completado', 'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-200'],
            'cancelled' => ['label' => 'Cancelado', 'class' => 'bg-rose-50 text-rose-700 ring-rose-200'],
        ];
        $paymentLabels = [
            'pending' => ['label' => 'Pendiente', 'class' => 'bg-amber-50 text-amber-700 ring-amber-200'],
            'paid' => ['label' => 'Pagado', 'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-200'],
            'failed' => ['label' => 'Fallido', 'class' => 'bg-rose-50 text-rose-700 ring-rose-200'],
            'refunded' => ['label' => 'Reembolsado', 'class' => 'bg-slate-100 text-slate-700 ring-slate-200'],
        ];
    @endphp

    <div class="overflow-x-auto rounded-xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm text-slate-700">
            <thead class="bg-slate-50 text-left">
                <tr>
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">Usuario</th>
                    <th class="px-4 py-3">Total</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Pago</th>
                    <th class="px-4 py-3 text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($orders as $order)
                    <tr>
                        <td class="px-4 py-3 font-semibold">#{{ $order->id }}</td>
                        <td class="px-4 py-3">{{ $order->user->name ?? 'N/D' }}</td>
                        <td class="px-4 py-3">S/ {{ number_format($order->total, 2) }}</td>
                        <td class="px-4 py-3">
                            @php $s = $statusLabels[$order->status] ?? null; @endphp
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $s['class'] ?? 'bg-slate-50 text-slate-700 ring-slate-200' }}">
                                {{ $s['label'] ?? ucfirst(str_replace('-', ' ', $order->status ?? 'N/D')) }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            @php $p = $paymentLabels[$order->payment_status] ?? null; @endphp
                            <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold ring-1 {{ $p['class'] ?? 'bg-slate-50 text-slate-700 ring-slate-200' }}">
                                {{ $p['label'] ?? ucfirst(str_replace('-', ' ', $order->payment_status ?? 'N/D')) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right space-x-2">
                            <a href="{{ route('admin.orders.edit', $order) }}" class="inline-flex items-center gap-1 rounded-lg bg-indigo-50 px-3 py-1.5 text-xs font-semibold text-indigo-700 ring-1 ring-indigo-100 hover:bg-indigo-100">
                                <i class="fa-solid fa-pen-to-square"></i> Editar
                            </a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar este pedido?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-rose-50 px-3 py-1.5 text-xs font-semibold text-rose-700 ring-1 ring-rose-100 hover:bg-rose-100">
                                    <i class="fa-solid fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-slate-500">No hay pedidos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
