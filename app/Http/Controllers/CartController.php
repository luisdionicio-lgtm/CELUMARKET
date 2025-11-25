<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartQuantityRequest;
use App\Models\Comparison;
use App\Models\Product;
use App\Models\Reservation;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(private readonly CartService $cartService) {}

    public function index(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $this->cartService->mergeSessionToUser($user);
        }

        $items = $this->cartService->getItems($user);
        $totals = $this->cartService->totals($items);

        return view('cart.index', [
            'items' => $items,
            'totals' => $totals,
        ]);
    }

    public function add(CartQuantityRequest $request, Product $product)
    {
        $quantity = $request->quantity();

        if (!$product->in_stock) {
            return back()->with('status', 'Producto sin stock.');
        }

        $user = $request->user();

        if ($user) {
            $this->cartService->mergeSessionToUser($user);
        }

        $this->cartService->addProduct($product, $quantity, $user);

        return back()->with('status', 'Producto agregado al carrito.');
    }

    public function update(CartQuantityRequest $request, Product $product)
    {
        $quantity = $request->quantity();
        $user = $request->user();

        if ($user) {
            $this->cartService->mergeSessionToUser($user);
        }

        $this->cartService->updateQuantity($product, $quantity, $user);

        return back()->with('status', 'Cantidad actualizada.');
    }

    public function remove(Request $request, Product $product)
    {
        $user = $request->user();

        if ($user) {
            $this->cartService->mergeSessionToUser($user);
        }

        $this->cartService->removeProduct($product, $user);

        return back()->with('status', 'Producto eliminado del carrito.');
    }

    public function reserve(Product $product)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        Reservation::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'status' => 'pendiente',
        ]);

        return back()->with('status', 'Producto reservado correctamente.');
    }

    public function compare(Product $product)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $recommended = $product->marca === 'Samsung' || $product->ram >= 6;

        Comparison::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'recommended' => $recommended,
        ]);

        $mensaje = $recommended
            ? 'Este es el celular adecuado para ti.'
            : 'Este celular puede no ser el m\u00e1s recomendado.';

        return back()->with('status', $mensaje);
    }
}
