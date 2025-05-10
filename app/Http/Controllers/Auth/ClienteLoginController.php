<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class ClienteLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:cliente')->except(['cerrarSesion', 'index']);
    }

    // Método para mostrar el dashboard del cliente
    public function index()
    {
        return view('cliente.inicio');// Asegúrate de que esta vista exista
    }



    public function autenticar(Request $request)
    {
        $request->validate([
            'correo' => 'required|email',
            'clave' => 'required|string'
        ]);

        // Preparamos credenciales para Laravel
        $credenciales = [
            'correo' => $request->correo,
            'password' => $request->clave // Laravel espera 'password' pero usamos 'clave'
        ];

        if (Auth::guard('cliente')->attempt($credenciales, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('cliente.inicio'));
        }

        return back()->withErrors([
            'correo' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }


    public function cerrarSesion(Request $request)
    {
        Auth::guard('cliente')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }


    
}