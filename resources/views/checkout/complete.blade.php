@extends('layouts.app')

@section('title', 'Pedido completado')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4 space-y-8">

    {{-- ICONO DE ÉXITO --}}
    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-emerald-100 text-emerald-600 text-4xl shadow">
        ✓
    </div>

    {{-- TÍTULO --}}
    <h1 class="text-3xl font-bold text-center text-slate-900">
        ¡Tu pedido ha sido completado!
    </h1>

    <p class="text-center text-sm text-slate-600 max-w-md mx-auto">
        Hemos registrado tu orden correctamente.  
        Recibirás un correo con la confirmación y los detalles del envío.
    </p>

    {{-- RESUMEN DEL PEDIDO --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-4">

        <h2 class="text-lg font-semibold text-slate-900 mb-3">Resumen del pedido</h2>

        @foreach($items as $line)
            <div class="flex items-center justify-between text-sm text-slate-700">
                <span>
                    {{ $line->product->nombre ?? $line->product->name }}
                    (x{{ $line->quantity }})
                </span>

                <span class="font-semibold">
                    S/ {{ number_format($line->subtotal, 2) }}
                </span>
            </div>
        @endforeach

        <div class="flex items-center justify-between pt-4 border-t border-slate-200 font-semibold text-slate-900">
            <span>Total pagado</span>
            <span>S/ {{ number_format($totals['price'], 2) }}</span>
        </div>
    </div>

    {{-- INFORMACIÓN DE ENVÍO --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-1">
        <h2 class="text-lg font-semibold text-slate-900">Envío</h2>

        <p class="text-sm text-slate-700">{{ $shipping['nombre'] }}</p>
        <p class="text-sm text-slate-700">{{ $shipping['direccion'] }}</p>
        <p class="text-sm text-slate-700">{{ $shipping['ciudad'] }}, {{ $shipping['pais'] }}</p>
        <p class="text-sm text-slate-700">Tel: {{ $shipping['telefono'] }}</p>
    </div>

    {{-- MÉTODO DE PAGO --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm space-y-1">
        <h2 class="text-lg font-semibold text-slate-900">Método de pago</h2>

        <p class="text-sm text-slate-700">
            @if($payment['metodo'] === 'cash')
                PagoEfectivo / Yape / Plin (simulado)
            @else
                Tarjeta de crédito / débito (simulado)
            @endif
        </p>

        @if(!empty($payment['notas']))
            <p class="text-sm text-slate-700 mt-2">
                <strong>Notas:</strong> {{ $payment['notas'] }}
            </p>
        @endif
    </div>

    {{-- BOTÓN VOLVER --}}
    <div class="text-center">
        <a href="{{ route('shop.index') }}"
           class="inline-flex items-center justify-center rounded-xl bg-[#1a233a] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#303a58]">
            Volver a la tienda
        </a>
    </div>

</div>
@endsection
