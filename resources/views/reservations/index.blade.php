@extends('layouts.app')

@section('title', 'Mis Reservas')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <h1 class="text-2xl font-semibold text-primary">Mis productos reservados</h1>

    @if($reservas->isEmpty())
        <div class="rounded-xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500 shadow-sm">
            No tienes productos reservados. <a href="{{ route('shop.index') }}" class="text-indigo-600 hover:underline">Explora la tienda</a>.
        </div>
    @else
        <div class="space-y-4">
            @foreach ($reservas as $reserva)
                <article class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <img src="{{ $reserva->product->image_url }}" alt="{{ $reserva->product->name }}" class="h-20 w-20 rounded-xl object-cover">
                    <div>
                        <p class="text-lg font-semibold text-secondary">{{ $reserva->product->nombre ?? $reserva->product->name }}</p>
                        <p class="text-sm text-slate-500">Reservado el {{ $reserva->created_at->format('d/m/Y') }}</p>

                        <!-- ✅ Botón para cancelar reserva -->
                        <form action="{{ route('reservations.destroy', $reserva) }}" method="POST" onsubmit="return confirm('¿Cancelar esta reserva?');" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-600 hover:underline text-sm">Cancelar reserva</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection