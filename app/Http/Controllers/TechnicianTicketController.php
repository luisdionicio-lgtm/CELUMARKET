<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TechnicianTicketController extends Controller
{
    /**
     * List tickets for technicians with optional status filter.
     */
    public function index(Request $request): View
    {
        $status = $request->query('status');
        $user = $request->user();

        $tickets = Ticket::with(['user', 'technician'])
            ->when(!$user->isAdmin(), function ($query) use ($user) {
                $query->where(function ($sub) use ($user) {
                    $sub->whereNull('tecnico_id')
                        ->orWhere('tecnico_id', $user->id);
                });
            })
            ->when($status, fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('tecnico.dashboard', [
            'tickets' => $tickets,
            'status' => $status,
        ]);
    }

    /**
     * Show the technician edit form.
     */
    public function edit(Request $request, Ticket $ticket): View
    {
        $this->authorizeTicket($request->user(), $ticket);

        return view('tecnico.edit', [
            'ticket' => $ticket->load(['user', 'technician']),
        ]);
    }

    /**
     * Update ticket fields available to technicians.
     */
    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        $this->authorizeTicket($request->user(), $ticket);

        $data = $request->validate([
            'status' => 'required|in:open,in-progress,resolved,closed',
            'priority' => 'required|in:low,medium,high',
            'comentarios_tecnico' => 'nullable|string',
        ]);

        if (!$ticket->tecnico_id) {
            $ticket->tecnico_id = $request->user()->id;
        }

        $ticket->fill($data);
        $ticket->save();

        return redirect()
            ->route('tecnico.dashboard')
            ->with('success', 'Ticket actualizado correctamente.');
    }

    private function authorizeTicket($user, Ticket $ticket): void
    {
        if ($user->isAdmin()) {
            return;
        }

        if ($ticket->tecnico_id && $ticket->tecnico_id !== $user->id) {
            abort(403, 'No puedes gestionar un ticket asignado a otro técnico.');
        }
    }
}
