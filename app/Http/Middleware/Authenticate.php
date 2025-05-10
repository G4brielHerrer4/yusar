<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Si es una petición API, no redirigir
        if ($request->expectsJson()) {
            return null;
        }

        // Determinar a qué login redirigir según el guardia usado
        if ($request->route()->middleware() && is_array($request->route()->middleware())) {
            foreach ($request->route()->middleware() as $middleware) {
                if (str_contains($middleware, 'auth:')) {
                    $guard = explode(':', $middleware)[1] ?? null;
                    if ($guard === 'cliente') {
                        return route('cliente.login');
                    }
                }
            }
        }

        // Redirección por defecto (para guardia web/administrador)
        return route('login');
    }
}