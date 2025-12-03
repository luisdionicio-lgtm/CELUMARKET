<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ShopPageController extends Controller
{
    public function index()
    {
        // Obtener productos paginados, ordenados por ID descendente
        $productos = Product::where('active', true)
            ->orderByDesc('id')
            ->paginate(12);

        // Obtener los IDs de productos favoritos del usuario autenticado
        $favoriteProductIds = Auth::check()
            ? Auth::user()->favorites()->where('active', true)->pluck('favorites.product_id')->toArray()
            : [];

        // Retornar la vista con los datos necesarios
        return view('shop', [
            'products' => $productos,
            'favoriteProductIds' => $favoriteProductIds,
        ]);
    }
}
