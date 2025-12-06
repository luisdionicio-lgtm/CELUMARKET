<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartService
{
    
    /** Fusionar el carrito de la sesión con el carrito del usuario autenticado. **/
    public function mergeSessionToUser(User $user): void
    {
        $sessionCart = Session::get('cart', []);

        if (empty($sessionCart)) {
            return;
        }

        $existing = Cart::where('user_id', $user->id)->get()->keyBy('product_id');

        foreach ($sessionCart as $productId => $quantity) {
            if ($quantity < 1) {
                continue;
            }

            /** @var Cart $cartItem */
            $cartItem = $existing->get($productId) ?? new Cart([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);

            $cartItem->quantity = ($cartItem->exists ? $cartItem->quantity : 0) + (int) $quantity;
            $cartItem->save();
        }

        Session::forget(['cart', 'cart_ready']);
    }


    /**
    * Recuperar artículos del carrito para la sesión o el usuario autenticado.
    */
    public function getItems(?User $user): Collection
    {
        if ($user) {
            return Cart::with('product')
                ->where('user_id', $user->id)
                ->get()
                ->filter(fn (Cart $cart) => $cart->product && $cart->product->active)
                ->map(fn (Cart $cart) => $this->formatLine($cart->product, $cart->quantity));
        }

        $sessionCart = Session::get('cart', []);

        if (empty($sessionCart)) {
            return collect();
        }

        $products = Product::where('active', true)
            ->whereIn('id', array_keys($sessionCart))
            ->get()
            ->keyBy('id');

        return collect($sessionCart)->map(function ($quantity, $productId) use ($products) {
            if (!$products->has($productId)) {
                return null;
            }

            return $this->formatLine($products[$productId], (int) $quantity);
        })->filter();
    }

    public function totals(Collection $items): array
    {
        return [
            'quantity' => $items->sum('quantity'),
            'price' => $items->sum('subtotal'),
        ];
    }

    public function addProduct(Product $product, int $quantity, ?User $user = null): void
    {
        if ($user) {
            $cartItem = Cart::firstOrNew([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);

            $cartItem->quantity = ($cartItem->exists ? $cartItem->quantity : 0) + $quantity;
            $cartItem->save();
            return;
        }

        $cart = Session::get('cart', []);
        $cart[$product->id] = ($cart[$product->id] ?? 0) + $quantity;
        Session::put('cart', $cart);
        Session::put('cart_ready', true);
        Session::save();
    }

    public function updateQuantity(Product $product, int $quantity, ?User $user = null): void
    {
        if ($user) {
            Cart::updateOrCreate(
                ['user_id' => $user->id, 'product_id' => $product->id],
                ['quantity' => $quantity]
            );
            return;
        }

        $cart = Session::get('cart', []);
        if (array_key_exists($product->id, $cart)) {
            $cart[$product->id] = $quantity;
            Session::put('cart', $cart);
            Session::put('cart_ready', true);
            Session::save();
        }
    }

    public function removeProduct(Product $product, ?User $user = null): void
    {
        if ($user) {
            Cart::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->delete();
        } else {
            $cart = Session::get('cart', []);
            unset($cart[$product->id]);
            Session::put('cart', $cart);
            Session::save();
        }

        $this->cleanupSessionFlags($user);
    }

    public function clear(?User $user = null): void
    {
        if ($user) {
            Cart::where('user_id', $user->id)->delete();
        }

        Session::forget(['cart', 'cart_ready']);
    }

    protected function formatLine(Product $product, int $quantity): object
    {
        $safeQuantity = max(1, $quantity);
        $price = $this->resolvePrice($product);

        return (object) [
            'product' => $product,
            'quantity' => $safeQuantity,
            'subtotal' => $safeQuantity * $price,
            'price' => $price,
        ];
    }

    protected function resolvePrice(Product $product): float
    {
        return (float) ($product->precio ?? $product->price ?? 0);
    }

    /**
    * Limpiar las banderas de sesión cuando el carrito esté vacío.
    */
    protected function cleanupSessionFlags(?User $user = null): void
    {
        if ($user) {
            if (!Cart::where('user_id', $user->id)->exists()) {
                Session::forget('cart_ready');
            }
            return;
        }

        $cart = Session::get('cart', []);
        if (empty($cart)) {
            Session::forget('cart_ready');
        }
    }
}
