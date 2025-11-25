@extends('layouts.app')

@section('title', 'Mis Comparaciones')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <h1 class="text-2xl font-semibold text-primary">Mis productos comparados</h1>

    @if($comparaciones->isEmpty())
        <div class="rounded-xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500 shadow-sm">
            No has comparado ningún producto. <a href="{{ route('shop.index') }}" class="text-indigo-600 hover:underline">Explora la tienda</a>.
        </div>
    @else
        <div class="space-y-4">
            @foreach ($comparaciones as $comparacion)
                <article class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <img src="{{ $comparacion->product->image_url }}" alt="{{ $comparacion->product->name }}" class="h-20 w-20 rounded-xl object-cover">
                    <div>
                        <p class="text-lg font-semibold text-secondary">{{ $comparacion->product->nombre ?? $comparacion->product->name }}</p>
                        <p class="text-sm text-slate-500">Comparado el {{ $comparacion->created_at->format('d/m/Y') }}</p>
                        <p class="text-sm {{ $comparacion->recommended ? 'text-green-600' : 'text-rose-600' }}">
                            {{ $comparacion->recommended ? '✅ Recomendado' : '⚠️ No recomendado' }}
                        </p>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection