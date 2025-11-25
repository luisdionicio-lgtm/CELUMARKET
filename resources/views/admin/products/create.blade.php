@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">Agregar nuevo producto</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca</label>
            <input type="text" name="brand" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
                <input type="number" name="price" step="0.01" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Stock</label>
                <input type="number" name="stock" class="w-full border rounded px-3 py-2" required>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rating</label>
            <input type="number" name="rating" step="0.1" min="0" max="5" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="inline-flex items-center">
                <input type="checkbox" name="featured" class="form-checkbox">
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">¿Producto destacado?</span>
            </label>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen</label>
            <input type="file" name="image" accept="image/*" class="w-full border rounded px-3 py-2">
        </div>

        <div class="pt-4">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Guardar producto
            </button>
        </div>
    </form>
</div>
@endsection