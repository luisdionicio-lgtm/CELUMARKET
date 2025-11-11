@extends('layouts.app')

@section('title', 'Mis Favoritos')

@section('content')
<div class="mx-auto max-w-5xl space-y-6">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <p class="text-xs uppercase tracking-[0.35em] text-slate-400">Colección</p>
        <h1 class="text-2xl font-semibold text-primary">Productos favoritos</h1>
        <p class="text-sm text-slate-500">Tus celulares destacados en un solo lugar.</p>
    </div>

    @if(session('favorite-status'))
        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm">
            {{ session('favorite-status') }}
        </div>
    @endif

    @if($products->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center text-slate-500 shadow-sm">
            Aún no tienes favoritos. <a href="{{ route('shop.index') }}" class="text-indigo-600 hover:underline">Explora la tienda</a>.
        </div>
    @else
        <div class="grid gap-4 md:grid-cols-2">
            @foreach ($products as $product)
                <article class="flex gap-4 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-24 w-24 rounded-xl object-cover">
                    <div class="flex flex-1 flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-secondary">{{ $product->nombre ?? $product->name }}</h3>
                            <p class="text-sm text-slate-500">{{ $product->brand }}</p>
                            <p class="mt-2 text-primary font-bold">S/ {{ number_format($product->precio ?? $product->price, 2) }}</p>
                        </div>
                        <form action="{{ route('favorites.toggle', $product) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-rose-600 hover:underline text-sm">Quitar de favoritos</button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>
    @endif
</div>
@endsection
