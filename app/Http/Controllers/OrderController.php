<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->latest()->get();

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();

        return view('orders.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,delivered,cancelled',
        ]);

        Order::create($data);

        return redirect()->route('orders.index')->with('success', 'Pedido creado correctamente.');
    }

    public function edit(Order $order)
    {
        $users = User::orderBy('name')->get();

        return view('orders.edit', compact('order', 'users'));
    }

    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:pending,processing,delivered,cancelled',
        ]);

        $order->update($data);

        return redirect()->route('orders.index')->with('success', 'Pedido actualizado.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return back()->with('success', 'Pedido eliminado.');
    }
}
