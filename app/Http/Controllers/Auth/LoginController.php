<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers {
        authenticated as protected parent_authenticated;
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'correo_electronico';
    }

    protected function authenticated(Request $request, $user)
    {
        Log::info('Método authenticated llamado');
        Log::info('Usuario ID: ' . $user->id);
        Log::info('Correo electrónico: ' . $user->correo_electronico);
        
        try {
            $user->load('rol');
            
            if (!$user->rol) {
                Log::error('Usuario no tiene rol asignado');
                Auth::logout();
                return redirect('/login')->with('error', 'Tu cuenta no tiene un rol asignado.');
            }
            
            Log::info('Rol ID: ' . $user->rol_id);
            Log::info('Rol nombre: ' . $user->rol->nombre);
            
            switch ($user->rol->nombre) {
                case 'Administrador':
                    Log::info('Redirigiendo a /admin/dashboard');
                    return redirect()->to('/admin/dashboard');
                case 'Vendedor':
                    Log::info('Redirigiendo a /vendedor/dashboard');
                    return redirect()->to('/vendedor/dashboard');
                case 'Responsable':
                    Log::info('Redirigiendo a /responsable/dashboard');
                    return redirect()->to('/responsable/dashboard');
                default:
                    Log::info('Rol desconocido (' . $user->rol->nombre . '), redirigiendo a /');
                    return redirect('/unauthorized')->with('error', 'No tienes permisos para acceder.');
            }
        } catch (\Exception $e) {
            Log::error('Error en authenticated: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            Auth::logout();
            return redirect('/login')->with('error', 'Ha ocurrido un error al procesar tu inicio de sesión.');
        }
    }
}