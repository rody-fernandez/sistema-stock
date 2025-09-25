<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, string $role)
    {
        if (!Auth::check() || optional(Auth::user()->role)->name !== $role) {
            abort(403, 'Acceso denegado');
        }
        return $next($request);
    }
}
