@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8 space-y-6">
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-700 hover:text-primary">
        <i class="fa-solid fa-arrow-left"></i> Volver a pedidos
    </a>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-xs uppercase tracking-[0.3em] text-slate-500">Pedido #{{ $order->id }}</p>
                <h2 class="text-2xl font-bold text-slate-900">Detalle de pedido</h2>
                <p class="text-sm text-slate-500">Cliente: {{ $order->user->name ?? 'N/D' }} ({{ $order->user->email ?? 'N/D' }})</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-slate-500">Total</p>
                <p class="text-2xl font-bold text-[#1a233a]">S/ {{ number_format($order->total, 2) }}</p>
            </div>
        </div>

        <div class="mt-6 space-y-4">
            <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid gap-4 md:grid-cols-2">
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Estado</label>
                        <select name="status" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach(['pending' => 'Pendiente', 'processing' => 'En proceso', 'delivered' => 'Entregado', 'cancelled' => 'Cancelado'] as $value => $label)
                                <option value="{{ $value }}" @selected(old('status', $order->status) === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-semibold text-slate-700">Estado de pago</label>
                        <input type="text" name="payment_status" value="{{ old('payment_status', $order->payment_status) }}" class="mt-1 w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Ej: pagado, pendiente">
                        @error('payment_status')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.orders.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">Cancelar</a>
                    <button type="submit" class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Guardar cambios</button>
                </div>
            </form>

            @if($order->items && $order->items->count())
                <div class="mt-4">
                    <h3 class="text-lg font-semibold text-slate-800 mb-2">Productos</h3>
                    <div class="overflow-x-auto border border-slate-200 rounded-xl">
                        <table class="min-w-full divide-y divide-slate-200 text-sm">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Producto</th>
                                    <th class="px-4 py-2 text-left">Cantidad</th>
                                    <th class="px-4 py-2 text-left">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($order->items as $item)
                                    <tr>
                                        <td class="px-4 py-2">{{ $item->product_name }}</td>
                                        <td class="px-4 py-2">{{ $item->quantity }}</td>
                                        <td class="px-4 py-2">S/ {{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
