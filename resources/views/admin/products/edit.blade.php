@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Editar producto</h2>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca</label>
            <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
                <input type="number" name="price" step="0.01" value="{{ old('price', $product->price) }}" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full border rounded px-3 py-2" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rating</label>
            <input type="number" name="rating" step="0.1" min="0" max="5" value="{{ old('rating', $product->rating) }}" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="inline-flex items-center">
                <input type="checkbox" name="featured" {{ $product->featured ? 'checked' : '' }} class="form-checkbox">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">¿Producto destacado?</span>
            </label>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen actual</label>
            @if($product->image_url)
                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover rounded mb-2">
            @else
                <p class="text-gray-500 italic">Sin imagen</p>
            @endif
            <input type="file" name="image" accept="image/*" class="w-full border rounded px-3 py-2">
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Actualizar producto
            </button>
        </div>
    </form>
</div>
@endsection