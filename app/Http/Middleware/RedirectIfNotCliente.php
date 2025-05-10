<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;
// use Symfony\Component\HttpFoundation\Response;

// class RedirectIfNotCliente
// {
//     /**
//      * Handle an incoming request.
//      *
//      * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
//      */
//     public function handle($request, Closure $next)
//     {
//         if (!Auth::guard('cliente')->check()) {
//             return redirect()->route('cliente.login');
//         }

//         return $next($request);
//     }
// }
