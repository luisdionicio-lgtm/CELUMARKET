<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShopPageController extends Controller
{
    public function index()
    {
        $products = Product::orderByDesc('id')->paginate(12);
        $favoriteProductIds = Auth::check()
            ? Auth::user()->favorites()->pluck('favorites.product_id')->toArray()
            : [];

        return view('shop', [
            'products' => $products,
            'favoriteProductIds' => $favoriteProductIds,
        ]);
    }
}
