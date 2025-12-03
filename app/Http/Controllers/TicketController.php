<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $tickets = Ticket::with(['user', 'technician'])
            ->when(!$request->user()->isAdmin(), fn ($query) => $query->where('user_id', $request->user()->id))
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->get();

        return view('tickets.index', [
            'tickets' => $tickets,
            'currentStatus' => $status,
        ]);
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|in:warranty,return,complaint,inquiry',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'order_number' => 'nullable|string|max:100',
            'product_name' => 'nullable|string|max:255',
            'priority' => 'required|in:low,medium,high',
        ]);

        $data['user_id'] = $request->user()->id;
        $data['status'] = 'open';

        Ticket::create($data);

        return redirect()->route('tickets.index')->with('success', 'Ticket creado correctamente.');
    }

    public function edit(Ticket $ticket)
    {
        $this->ensureAdmin();

        $technicians = User::where('role', 'tecnico')->orderBy('name')->get();

        return view('tickets.edit', compact('ticket', 'technicians'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->ensureAdmin();

        $data = $request->validate([
            'type' => 'required|in:warranty,return,complaint,inquiry',
            'subject' => 'required|string|max:255',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:open,in-progress,resolved,closed',
            'description' => 'nullable|string',
            'order_number' => 'nullable|string|max:100',
            'product_name' => 'nullable|string|max:255',
            'comentarios_tecnico' => 'nullable|string',
            'tecnico_id' => 'nullable|exists:users,id',
        ]);

        $ticket->update($data);

        return redirect()->route('tickets.index')->with('success', 'Ticket actualizado correctamente.');
    }

    public function destroy(Ticket $ticket)
    {
        $this->ensureAdmin();

        $ticket->delete();

        return back()->with('success', 'Ticket eliminado correctamente.');
    }

    private function ensureAdmin(): void
    {
        if (!auth()->user()?->isAdmin()) {
            abort(403, 'No tienes permisos para realizar esta acción.');
        }
    }
}
