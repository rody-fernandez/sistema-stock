<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        // Verifica si el usuario está autenticado
        if (!auth()->check()) {
            abort(403, 'Acceso denegado: usuario no autenticado.');
        }

        // Verifica si el usuario tiene el rol adecuado
        if (auth()->user()->role->name !== $role) {
            abort(403, 'Acceso denegado: permiso insuficiente.');
        }

        return $next($request);
    }
}
