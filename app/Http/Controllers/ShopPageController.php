<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopPageController extends Controller
{
    public function index()
    {
        // Obtener productos paginados, ordenados por ID descendente
        $productos = Product::orderByDesc('id')->paginate(12);

        // Obtener los IDs de productos favoritos del usuario autenticado
        $favoriteProductIds = Auth::check()
            ? Auth::user()->favorites()->pluck('favorites.product_id')->toArray()
            : [];

        // Retornar la vista con los datos necesarios
        return view('shop', [
            'products' => $productos,
            'favoriteProductIds' => $favoriteProductIds,
        ]);
    }
}