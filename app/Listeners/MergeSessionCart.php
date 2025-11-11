<?php

namespace App\Listeners;

use App\Models\Cart;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Session;

class MergeSessionCart
{
    public function handle(Login $event): void
    {
        $sessionCart = Session::get('cart', []);

        if (empty($sessionCart)) {
            return;
        }

        foreach ($sessionCart as $productId => $quantity) {
            if ($quantity < 1) {
                continue;
            }

            $cartItem = Cart::firstOrNew([
                'user_id' => $event->user->id,
                'product_id' => $productId,
            ]);

            $cartItem->quantity = ($cartItem->exists ? $cartItem->quantity : 0) + $quantity;
            $cartItem->save();
        }

        Session::forget('cart');
    }
}
