<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            abort(403, 'Acceso denegado: usuario no autenticado.');
        }

        // Verifica si el usuario tiene role_id = 1
        if (auth()->user()->role_id !== 1) {
            abort(403, 'Acceso denegado: permiso insuficiente.');
        }

        return $next($request);
    }
}
