<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckUserRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Verifica si el usuario está autenticado
        if (!Auth::check()) {
            return redirect('/login');
        }

        // Obtiene el usuario autenticado
        $user = Auth::user();
        
        // Añadir logs para depuración
        Log::info('CheckUserRole middleware ejecutándose');
        Log::info('Usuario ID: ' . $user->id);
        Log::info('Rol del usuario: ' . $user->rol->nombre);
        Log::info('Rol requerido: ' . $role);

        // Verifica si el usuario tiene el rol requerido
        if ($user->rol->nombre !== $role) {
            Log::info('Rol no coincide, redirigiendo a unauthorized');
            // Redirige a la vista de error si no tiene el rol correcto
            return redirect()->route('unauthorized');
        }

        Log::info('Rol coincide, permitiendo acceso');
        // Si el rol es correcto, permite el acceso
        return $next($request);
    }
}