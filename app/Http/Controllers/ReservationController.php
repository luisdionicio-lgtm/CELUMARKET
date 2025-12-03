<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Product;

class ReservationController extends Controller
{
    /**
     * Mostrar todas las reservas del usuario autenticado
     */
    public function index()
    {
        $reservas = Reservation::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('reservations.index', compact('reservas'));
    }

    /**
     * Crear una nueva reserva para un producto
     */
    public function store($productId)
    {
        $product = Product::where('id', $productId)->where('active', true)->firstOrFail();

        Reservation::create([
            'user_id'    => auth()->id(),
            'product_id' => $product->id,
            'status'     => 'pendiente'
        ]);

        return redirect()->route('reservations.index')
            ->with('status', 'Producto reservado correctamente.');
    }

    /**
     * Cancelar una reserva y redirigir al carrito
     */
    public function destroy(Reservation $reservation)
    {
        // Verifica que la reserva pertenezca al usuario autenticado
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        // Elimina la reserva
        $reservation->delete();

        // Redirige al carrito con mensaje de confirmación
        return redirect()->route('cart.index')
            ->with('status', 'Reserva cancelada y redirigido al carrito.');
    }
}
