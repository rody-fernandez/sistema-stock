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

        $user = auth()->user();

        if (!$user->relationLoaded('role')) {
            $user->load('role');
        }

        if (!$user->isAdmin()) {
            abort(403, 'Acceso denegado: permiso insuficiente.');
        }

        return $next($request);
    }
}
