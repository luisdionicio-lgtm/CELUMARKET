<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $productos = Product::latest()->get();
        return view('admin.dashboard', compact('productos'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'brand'    => 'required|string|max:50',
            'price'    => 'required|numeric|min:0',
            'stock'    => 'required|integer|min:0',
            'rating'   => 'nullable|numeric|min:0|max:5',
            'featured' => 'nullable|boolean',
            'image'    => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('products', 'public');
        }

        $validated['featured'] = $request->has('featured');

        Product::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'brand'    => 'required|string|max:50',
            'price'    => 'required|numeric|min:0',
            'stock'    => 'required|integer|min:0',
            'rating'   => 'nullable|numeric|min:0|max:5',
            'featured' => 'nullable|boolean',
            'image'    => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['featured'] = $request->has('featured');

        $product->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Producto eliminado correctamente.');
    }
}