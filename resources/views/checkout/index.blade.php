@extends('layouts.app')

@section('title', 'Resumen del carrito')

@section('content')
<div class="mx-auto max-w-6xl space-y-8">

    {{-- Encabezado --}}
    <div class="flex flex-col gap-3 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm md:flex-row md:items-center md:justify-between">
        <div>
            <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Checkout</p>
            <h1 class="text-3xl font-semibold text-[#1a233a]">Resumen del carrito</h1>
            <p class="text-sm text-slate-500">Verifica los productos antes de continuar.</p>
        </div>
        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700">
            Total: S/ {{ number_format($totals['price'], 2) }}
        </div>
    </div>

    {{-- Mensajes --}}
    @if (session('status'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm">
            {{ session('status') }}
        </div>
    @endif

    {{-- Lista de items --}}
    <div class="space-y-4">
        @foreach ($items as $line)
            <article class="flex items-center gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                <img src="{{ $line->product->image_url }}"
                     alt="{{ $line->product->nombre ?? $line->product->name }}"
                     class="h-20 w-20 rounded-xl object-cover">

                <div class="flex-1">
                    <p class="text-base font-semibold text-[#1a233a]">
                        {{ $line->product->nombre ?? $line->product->name }}
                    </p>
                    <p class="text-sm text-slate-500">Cantidad: {{ $line->quantity }}</p>
                </div>

                <div class="text-right">
                    <p class="text-sm text-slate-500">Subtotal</p>
                    <p class="text-xl font-bold text-[#1a233a]">
                        S/ {{ number_format($line->subtotal, 2) }}
                    </p>
                </div>
            </article>
        @endforeach
    </div>

    {{-- Total --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm flex items-center justify-between text-lg font-semibold text-[#1a233a]">
        <span>Total</span>
        <span>S/ {{ number_format($totals['price'], 2) }}</span>
    </div>

    {{-- Navegación --}}
    <div class="flex justify-between gap-3">
        <a href="{{ route('cart.index') }}"
           class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">
            Volver al carrito
        </a>

        <a href="{{ route('checkout.shipping') }}"
           class="rounded-xl bg-[#1a233a] px-4 py-2 text-sm font-semibold text-white hover:bg-[#303a58]">
            Continuar
        </a>
    </div>

</div>
@endsection
