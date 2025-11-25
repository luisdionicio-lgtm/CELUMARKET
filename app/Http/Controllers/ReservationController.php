<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index()
    {
        $reservas = Reservation::with('product')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('reservations.index', compact('reservas'));
    }

    public function destroy(Reservation $reservation)
    {
        // Verifica que la reserva pertenezca al usuario autenticado
        if ($reservation->user_id !== auth()->id()) {
            abort(403);
        }

        $reservation->delete();

        return back()->with('status', 'Reserva cancelada correctamente.');
    }
}