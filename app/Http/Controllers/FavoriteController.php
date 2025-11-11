<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function index(Request $request)
    {
        $products = $request->user()
            ->favorites()
            ->with('favoritedBy')
            ->get();

        return view('favorites.index', compact('products'));
    }

    public function toggle(Request $request, Product $product)
    {
        $favorites = $request->user()->favorites();

        if ($favorites->where('product_id', $product->id)->exists()) {
            $favorites->detach($product->id);
            $message = 'Producto eliminado de tus favoritos.';
        } else {
            $favorites->attach($product->id);
            $message = 'Producto agregado a tus favoritos.';
        }

        return back()->with('favorite-status', $message);
    }
}
