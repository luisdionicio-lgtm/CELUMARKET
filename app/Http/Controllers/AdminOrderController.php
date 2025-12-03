<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(): View
    {
        $orders = Order::with('user')->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function edit(Order $order): View
    {
        $order->load(['user', 'items']);

        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order): RedirectResponse
    {
        $data = $request->validate([
            'status' => 'required|in:pending,processing,delivered,cancelled',
            'payment_status' => 'nullable|string|max:50',
        ]);

        $order->update($data);

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Pedido actualizado correctamente.');
    }

    public function destroy(Order $order): RedirectResponse
    {
        $order->delete();

        return back()->with('success', 'Pedido eliminado.');
    }
}
