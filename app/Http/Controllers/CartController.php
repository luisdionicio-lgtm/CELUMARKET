<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $items = $this->cartItems();

        $totals = [
            'quantity' => $items->sum('quantity'),
            'price' => $items->sum('subtotal'),
        ];

        return view('cart.index', [
            'items' => $items,
            'totals' => $totals,
        ]);
    }

    public function add(Request $request, Product $product)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));

        if (!$product->in_stock) {
            return back()->with('status', 'Producto sin stock.');
        }

        if (Auth::check()) {
            $this->incrementDatabaseCart($product, $quantity);
        } else {
            $this->incrementSessionCart($product->id, $quantity);
        }

        return back()->with('status', 'Producto agregado al carrito.');
    }

    public function update(Request $request, Product $product)
    {
        $quantity = max(1, (int) $request->input('quantity', 1));

        if (Auth::check()) {
            Cart::updateOrCreate(
                ['user_id' => Auth::id(), 'product_id' => $product->id],
                ['quantity' => $quantity]
            );
        } else {
            $cart = Session::get('cart', []);
            if (array_key_exists($product->id, $cart)) {
                $cart[$product->id] = $quantity;
                Session::put('cart', $cart);
            }
        }

        return back()->with('status', 'Cantidad actualizada.');
    }

    public function remove(Product $product)
    {
        if (Auth::check()) {
            Cart::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->delete();
        } else {
            $cart = Session::get('cart', []);
            unset($cart[$product->id]);
            Session::put('cart', $cart);
        }

        return back()->with('status', 'Producto eliminado del carrito.');
    }

    protected function cartItems(): Collection
    {
        if (Auth::check()) {
            return Cart::with('product')
                ->where('user_id', Auth::id())
                ->get()
                ->filter(fn (Cart $cart) => $cart->product)
                ->map(fn (Cart $cart) => $this->formatCartLine($cart->product, $cart->quantity));
        }

        $sessionCart = Session::get('cart', []);
        $products = Product::whereIn('id', array_keys($sessionCart))->get()->keyBy('id');

        return collect($sessionCart)->map(function ($quantity, $productId) use ($products) {
            if (!$products->has($productId)) {
                return null;
            }

            return $this->formatCartLine($products[$productId], $quantity);
        })->filter();
    }

    protected function formatCartLine(Product $product, int $quantity): object
    {
        $price = $this->resolvePrice($product);

        return (object) [
            'product' => $product,
            'quantity' => $quantity,
            'subtotal' => $quantity * $price,
            'price' => $price,
        ];
    }

    protected function resolvePrice(Product $product): float
    {
        return (float) ($product->precio ?? $product->price ?? 0);
    }

    protected function incrementDatabaseCart(Product $product, int $quantity): void
    {
        $cartItem = Cart::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);

        $cartItem->quantity = ($cartItem->exists ? $cartItem->quantity : 0) + $quantity;
        $cartItem->save();
    }

    protected function incrementSessionCart(int $productId, int $quantity): void
    {
        $cart = Session::get('cart', []);
        $cart[$productId] = ($cart[$productId] ?? 0) + $quantity;
        Session::put('cart', $cart);
    }
}
