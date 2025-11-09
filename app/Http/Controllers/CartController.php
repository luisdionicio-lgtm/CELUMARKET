<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Agrega un producto al carrito del usuario autenticado.
     *
     * @param Request $request - La solicitud HTTP entrante.
     * @param Product $product - El producto que se desea agregar.
     * @return \Illuminate\Http\RedirectResponse - Redirige a la tienda después de agregar.
     */
    public function add(Request $request, Product $product)
    {
        // Obtiene el ID del usuario autenticado
        $userId = Auth::id();

        // Evita agregar productos sin stock
        if (!$product->in_stock) {
            return redirect()->route('shop.index')->with('status', 'Producto sin stock');
        }

        // Busca si el producto ya está en el carrito del usuario
        $cartItem = Cart::where('user_id', $userId)
                        ->where('product_id', $product->id)
                        ->first();

        // Si el producto ya está en el carrito, incrementa la cantidad
        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // Si no está en el carrito, lo agrega con cantidad 1
            Cart::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => 1,
            ]);
        }

        // Redirige al catálogo de la tienda
        return redirect()->route('shop.index');
    }
}
