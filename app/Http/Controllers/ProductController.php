<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Product::create($this->mapProductPayload($data));

        return redirect()->route('products.index')->with('success', 'Producto agregado correctamente.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($this->mapProductPayload($data, $product));

        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return back()->with('success', 'Producto eliminado.');
    }

    private function mapProductPayload(array $data, ?Product $product = null): array
    {
        return [
            'nombre' => $data['nombre'],
            'precio' => $data['precio'],
            'stock' => $data['stock'],
            'name' => $data['nombre'],
            'price' => $data['precio'],
            'brand' => $product->brand ?? 'Genérico',
            'description' => $product->description ?? 'Descripción pendiente.',
            'image_url' => $product->image_url ?? 'https://placehold.co/600x600?text=Producto',
            'rating' => $product->rating ?? 5,
            'storage' => $product->storage ?? 'N/D',
            'ram' => $product->ram ?? 'N/D',
            'processor' => $product->processor ?? 'N/D',
            'camera' => $product->camera ?? 'N/D',
            'screen' => $product->screen ?? 'N/D',
            'battery' => $product->battery ?? 'N/D',
            'in_stock' => $data['stock'] > 0,
            'featured' => $product->featured ?? false,
        ];
    }
}
