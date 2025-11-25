@extends('layouts.app')

@section('title', 'Datos de envío')

@section('content')
<div class="mx-auto max-w-3xl space-y-8">

    {{-- Encabezado --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Checkout</p>
        <h1 class="text-3xl font-semibold text-[#1a233a]">Datos de envío</h1>
        <p class="text-sm text-slate-500">Completa tu información para poder enviar tu pedido.</p>
    </div>

    <form action="{{ route('checkout.shipping.store') }}" method="POST"
          class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        @csrf

        {{-- Nombre --}}
        <div>
            <label class="text-sm font-semibold text-slate-700">Nombre completo</label>
            <input type="text"
                   name="nombre"
                   value="{{ old('nombre', $shipping['nombre'] ?? auth()->user()->name) }}"
                   required
                   class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-indigo-500">
            @error('nombre') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Dirección --}}
        <div>
            <label class="text-sm font-semibold text-slate-700">Dirección</label>
            <input type="text"
                   name="direccion"
                   value="{{ old('direccion', $shipping['direccion'] ?? '') }}"
                   required
                   class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:ring-indigo-500">
            @error('direccion') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Ciudad + País --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-semibold text-slate-700">Ciudad</label>
                <input type="text"
                       name="ciudad"
                       value="{{ old('ciudad', $shipping['ciudad'] ?? '') }}"
                       required
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @error('ciudad') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-sm font-semibold text-slate-700">País</label>
                <input type="text"
                       name="pais"
                       value="{{ old('pais', $shipping['pais'] ?? 'Perú') }}"
                       required
                       class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
                @error('pais') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Teléfono --}}
        <div>
            <label class="text-sm font-semibold text-slate-700">Teléfono</label>
            <input type="text"
                   name="telefono"
                   value="{{ old('telefono', $shipping['telefono'] ?? '') }}"
                   required
                   class="mt-1 w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">
            @error('telefono') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Navegación --}}
        <div class="flex justify-between gap-3 pt-2">
            <a href="{{ route('checkout.show') }}"
               class="rounded-xl border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-600 hover:bg-slate-50">
                Volver
            </a>
            <button type="submit"
                    class="rounded-xl bg-[#1a233a] px-4 py-2 text-sm font-semibold text-white hover:bg-[#303a58]">
                Continuar
            </button>
        </div>

    </form>

</div>
@endsection
