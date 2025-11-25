<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalProductos = Product::count();
        $productosEnStock = Product::where('stock', '>', 0)->count();
        $pedidosTotales = Order::count();
        $usuariosRegistrados = User::count();
        $ingresosTotales = Order::sum('total'); // Asegúrate de tener un campo 'total' en tu modelo Order

        $productos = Product::latest()->get();

        return view('admin.dashboard', compact(
            'totalProductos',
            'productosEnStock',
            'pedidosTotales',
            'usuariosRegistrados',
            'ingresosTotales',
            'productos'
        ));
    }
}