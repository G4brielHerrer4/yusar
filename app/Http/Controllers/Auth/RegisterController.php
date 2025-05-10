<?php

namespace App\Http\Controllers\Auth;

use App\Models\Rol;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    protected function redirectTo()
    {
        // Como el rol ahora puede ser nulo, verificamos primero si el usuario tiene un rol
        if (auth()->user()->rol) {
            if (auth()->user()->rol->nombre == 'administrador') {
                return '/admin/dashboard';
            } elseif (auth()->user()->rol->nombre == 'vendedor') {
                return '/vendedor/dashboard';
            } elseif (auth()->user()->rol->nombre == 'responsable') {
                return '/responsable/dashboard';
            }
        }
        
        // Si no tiene rol, redirigir a la página principal
        return '/';
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nombre' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'ci' => ['required', 'string', 'max:20', 'unique:users'],
            'genero' => ['required', 'string', 'in:Masculino,Femenino,Otro'],
            'celular' => ['required', 'string', 'max:15'],
            'correo_electronico' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'clave' => ['required', 'string', 'min:8', 'confirmed'],
            // Hacemos que rol_id sea nullable y opcional
            'rol_id' => ['nullable', 'sometimes', 'exists:roles,id'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Aseguramos que foto tenga un valor predeterminado
        $foto = isset($data['foto']) ? $data['foto'] : 'default.jpg';
        
        // Creamos el usuario con rol_id como NULL si no está definido
        return User::create([
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'ci' => $data['ci'],
            'genero' => $data['genero'],
            'celular' => $data['celular'],
            'correo_electronico' => $data['correo_electronico'],
            'clave' => Hash::make($data['clave']),
            'foto' => $foto,
            'rol_id' => $data['rol_id'] ?? null, // Si rol_id no existe, será null
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $roles = Rol::all();
        return view('auth.register', compact('roles'));
    }
}