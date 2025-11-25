@extends('layouts.app')

@section('title', 'Confirmación del pedido')

@section('content')
<div class="mx-auto max-w-4xl space-y-8">

    {{-- ENCABEZADO --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Checkout</p>
        <h1 class="text-3xl font-semibold text-[#1a233a]">Confirmación</h1>
        <p class="text-sm text-slate-500">Revisa toda la información antes de completar tu compra.</p>
    </div>

    {{-- DATOS DE ENVÍO + PAGO --}}
    <div class="grid gap-6 md:grid-cols-2">

        {{-- ENVÍO --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-1">
            <h2 class="text-lg font-semibold text-[#1a233a]">Datos de envío</h2>

            <p class="text-sm text-slate-700">{{ $shipping['nombre'] }}</p>
            <p class="text-sm text-slate-700">{{ $shipping['direccion'] }}</p>
            <p class="text-sm text-slate-700">{{ $shipping['ciudad'] }}, {{ $shipping['pais'] }}</p>
            <p class="text-sm text-slate-700">Tel: {{ $shipping['telefono'] }}</p>
        </div>

        {{-- MÉTODO DE PAGO --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-1">
            <h2 class="text-lg font-semibold text-[#1a233a]">Método de pago</h2>

            <p class="text-sm text-slate-700">
                @if ($payment['metodo'] === 'card')
                    Tarjeta de crédito / débito (simulado)
                @else
                    PagoEfectivo / Yape / Plin (simulado)
                @endif
            </p>

            @if (!empty($payment['notas']))
                <p class="text-sm text-slate-700 mt-2">
                    <strong>Notas:</strong> {{ $payment['notas'] }}
                </p>
            @endif
        </div>

    </div>

    {{-- RESUMEN DE PRODUCTOS --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">

        @foreach ($items as $line)
            <div class="flex items-center justify-between text-sm text-slate-700">
                <div>
                    <p class="font-semibold">{{ $line->product->nombre ?? $line->product->name }}</p>
                    <p class="text-slate-500">Cantidad: {{ $line->quantity }}</p>
                </div>

                <span class="font-semibold">
                    S/ {{ number_format($line->subtotal, 2) }}
                </span>
            </div>
        @endforeach

        <div class="flex items-center justify-between pt-4 border-t border-slate-200 font-semibold text-slate-900">
            <span>Total</span>
            <span>S/ {{ number_format($totals['price'], 2) }}</span>
        </div>
    </div>

    {{-- NAVEGACIÓN --}}
    <div class="flex justify-between gap-3">
        <a href="{{ route('checkout.payment') }}"
           class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">
            Volver
        </a>

        <form action="{{ route('checkout.complete') }}" method="POST">
            @csrf
            <button type="submit"
                    class="rounded-xl bg-[#1a233a] px-4 py-2 text-sm font-semibold text-white hover:bg-[#303a58]">
                Confirmar y finalizar pedido
            </button>
        </form>
    </div>

</div>
@endsection
