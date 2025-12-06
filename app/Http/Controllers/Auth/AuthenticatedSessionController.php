<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Mostrar la vista de inicio de sesión.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Manejar una solicitud de autenticación entrante.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $redirect = $request->input('redirect');
        if (is_string($redirect) && str_starts_with($redirect, '/')) {
            return redirect()->to(route('auth.bridge', ['to' => $redirect], false));
        }

        $user = $request->user();
        $targetRoute = match (true) {
            $user?->isAdmin() => 'admin.dashboard',
            $user?->isTecnico() => 'tecnico.dashboard',
            default => 'dashboard',
        };

        return redirect()->intended(route($targetRoute, absolute: false));
    }

    /**
     * Destruir una sesión autenticada.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
