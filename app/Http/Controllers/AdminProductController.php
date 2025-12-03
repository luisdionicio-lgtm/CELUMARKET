<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        return redirect()->route('admin.dashboard');
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
            'active'   => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('products', 'public');
        }

        $validated['featured'] = $request->has('featured');
        $validated['active'] = $request->boolean('active', true);
        $validated['in_stock'] = $validated['stock'] > 0;

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
            'active'   => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('products', 'public');
        }

        $validated['featured'] = $request->has('featured');
        $validated['active'] = $request->boolean('active', $product->active);
        $validated['in_stock'] = $validated['stock'] > 0;

        $product->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Product $product)
    {
        if (!$product->active) {
            return redirect()->route('admin.dashboard')->with('success', 'El producto ya estaba desactivado.');
        }

        $product->update([
            'active' => false,
            'in_stock' => false,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Producto desactivado correctamente.');
    }
}
