<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // <-- ¡IMPORTANTE! Importa tu modelo

class ShopPageController extends Controller
{
    /**
     * Muestra la página principal de la tienda.
     */
    public function index()
    {
        // Lista de productos paginada (12 por página), más recientes primero
        $products = Product::orderByDesc('id')->paginate(12);

        return view('shop', [
            'products' => $products,
        ]);
    }
}
