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
        $totalProductos = Product::where('active', true)->count();
        $productosEnStock = Product::where('active', true)->where('stock', '>', 0)->count();
        $productosInactivos = Product::where('active', false)->count();
        $pedidosTotales = Order::count();
        $usuariosRegistrados = User::count();
        $ingresosTotales = Order::sum('total'); // Asegúrate de tener un campo 'total' en tu modelo Order

        $productos = Product::latest()->get();

        return view('admin.dashboard', compact(
            'totalProductos',
            'productosEnStock',
            'productosInactivos',
            'pedidosTotales',
            'usuariosRegistrados',
            'ingresosTotales',
            'productos'
        ));
    }
}
