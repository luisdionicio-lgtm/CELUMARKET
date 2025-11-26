@extends('layouts.app')

@section('title', 'Mi Carrito')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div class="flex flex-col gap-2 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Compras</p>
            <h1 class="text-2xl font-semibold text-primary">Carrito de compras</h1>
            <p class="text-sm text-slate-500">Productos guardados para tu próxima compra.</p>
        </div>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-600">
            {{ $totals['quantity'] }} artículo(s) — Total S/ {{ number_format($totals['price'], 2) }}
        </div>
    </div>

    {{-- ✅ Mensaje de confirmación (ej: reserva cancelada y redirigido al carrito) --}}
    @if(session('status'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm">
            {{ session('status') }}
        </div>
    @endif

    @if($items->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500 shadow-sm">
            No tienes productos en tu carrito. 
            <a href="{{ route('shop.index') }}" class="text-indigo-600 hover:underline">Explora la tienda</a>.
        </div>
    @else
        <div class="space-y-4">
            @foreach ($items as $line)
                <article class="flex flex-col gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm md:flex-row md:items-center md:justify-between">
                    <div class="flex items-center gap-4">
                        <img src="{{ $line->product->image_url }}" alt="{{ $line->product->name }}" class="h-20 w-20 rounded-xl object-cover">
                        <div>
                            <p class="text-lg font-semibold text-secondary">{{ $line->product->nombre ?? $line->product->name }}</p>
                            <p class="text-sm text-slate-500">S/ {{ number_format($line->price, 2) }} c/u</p>
                        </div>
                    </div>

                    <div class="flex flex-col gap-3 text-sm text-slate-600 md:items-end">
                        {{-- Actualizar cantidad --}}
                        <form action="{{ route('cart.update', $line->product) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            @method('PATCH')
                            <label class="text-xs font-semibold text-slate-500">Cantidad</label>
                            <input type="number" name="quantity" min="1" value="{{ $line->quantity }}" class="w-20 rounded-lg border border-slate-300 px-2 py-1 text-center focus:border-indigo-500 focus:ring-indigo-500">
                            <button type="submit" class="text-indigo-600 hover:underline">Actualizar</button>
                        </form>

                        <p class="font-semibold text-primary">Subtotal: S/ {{ number_format($line->subtotal, 2) }}</p>

                        <div class="flex flex-wrap gap-3">
                            {{-- Eliminar producto --}}
                            <form action="{{ route('cart.remove', $line->product) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto del carrito?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:underline">Eliminar</button>
                            </form>

                            {{-- Reservar producto desde carrito --}}
                            <form action="{{ route('cart.reserve', $line->product) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-amber-600 hover:underline">Reservar producto</button>
                            </form>

                            {{-- Comparar producto --}}
                            <form action="{{ route('cart.compare', $line->product) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-indigo-600 hover:underline">Comparar producto</button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        {{-- Resumen del carrito --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.35em] text-slate-400">Resumen</p>
                    <h3 class="text-xl font-semibold text-secondary">Total a pagar</h3>
                </div>
                <div class="text-right">
                    <p class="text-sm text-slate-500">{{ $totals['quantity'] }} artículo(s)</p>
                    <p class="text-3xl font-bold text-primary">S/ {{ number_format($totals['price'], 2) }}</p>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap gap-3 md:justify-end">
                <a href="{{ route('shop.index') }}" class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                    Seguir comprando
                </a>

                <a href="{{ route('checkout.show') }}" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">
                    <i class="fa-solid fa-credit-card"></i> Pagar ahora
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
