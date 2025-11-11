<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product; // Importa el modelo Product

class HomeController extends Controller
{
    /**
     * Muestra la página de inicio con todos los productos.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtiene todos los productos de la base de datos
        $products = Product::all();
        $favoriteProductIds = Auth::check()
            ? Auth::user()->favorites()->pluck('favorites.product_id')->toArray()
            : [];

        // Retorna la vista 'home' con los productos
        return view('home', [
            'products' => $products,
            'favoriteProductIds' => $favoriteProductIds,
        ]);
    }
}
