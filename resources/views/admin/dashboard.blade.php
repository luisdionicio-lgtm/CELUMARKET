@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <h2 class="text-2xl font-bold text-slate-900 mb-6">Panel de Administración</h2>

    <!-- Métricas -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-10">
        <div class="rounded-xl bg-white p-4 shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Total Productos</p>
            <h3 class="text-2xl font-bold text-[#1a233a]">{{ $totalProductos }}</h3>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">En Stock</p>
            <h3 class="text-2xl font-bold text-[#1a233a]">{{ $productosEnStock }}</h3>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Pedidos Totales</p>
            <h3 class="text-2xl font-bold text-[#1a233a]">{{ $pedidosTotales }}</h3>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Usuarios Registrados</p>
            <h3 class="text-2xl font-bold text-[#1a233a]">{{ $usuariosRegistrados }}</h3>
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Ingresos Totales</p>
            <h3 class="text-2xl font-bold text-[#1a233a]">S/ {{ number_format($ingresosTotales, 2) }}</h3>
        </div>
    </div>

    <!-- Gestión de Productos -->
    <div class="mb-6 flex justify-between items-center">
        <h3 class="text-xl font-semibold text-slate-900">Gestión de Productos</h3>
        <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-[#1a233a] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#303a58]">
            <i class="fa-solid fa-plus"></i> Agregar Producto
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-slate-200">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50 text-left text-sm text-slate-500">
                <tr>
                    <th class="px-4 py-3">Imagen</th>
                    <th class="px-4 py-3">Producto</th>
                    <th class="px-4 py-3">Marca</th>
                    <th class="px-4 py-3">Precio</th>
                    <th class="px-4 py-3">Stock</th>
                    <th class="px-4 py-3">Rating</th>
                    <th class="px-4 py-3">Destacado</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                @foreach ($productos as $producto)
                <tr>
                    <td class="px-4 py-3">
                        @if($producto->image_url)
                            <img src="{{ $producto->image_src }}"
                                 alt="{{ $producto->name }}"
                                 class="w-16 h-16 object-cover rounded">
                        @else
                            <span class="text-gray-400 italic">Sin imagen</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 font-medium">{{ $producto->name }}</td>
                    <td class="px-4 py-3">{{ $producto->brand }}</td>
                    <td class="px-4 py-3">S/ {{ number_format($producto->price, 2) }}</td>
                    <td class="px-4 py-3">{{ $producto->stock ? 'En Stock' : 'Sin Stock' }}</td>
                    <td class="px-4 py-3">⭐ {{ number_format($producto->rating, 1) }}</td>
                    <td class="px-4 py-3">{{ $producto->featured ? 'Sí' : 'No' }}</td>
                    <td class="px-4 py-3 flex gap-2">
                        <a href="{{ route('admin.products.edit', $producto) }}" class="text-blue-600 hover:underline"><i class="fa-solid fa-pen-to-square"></i></a>
                        <form action="{{ route('admin.products.destroy', $producto) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
