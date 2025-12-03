<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request ensuring the authenticated user has one of the allowed roles.
     *
     * @param  array<int, string>  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $userRole = $user->role ?? 'user';

        // Admins always pass; otherwise check explicit allowed roles.
        if ($user->isAdmin() || in_array($userRole, $roles, true)) {
            return $next($request);
        }

        abort(403, 'Acceso no autorizado para este rol.');
    }
}
