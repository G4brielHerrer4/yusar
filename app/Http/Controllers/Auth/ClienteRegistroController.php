<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class ClienteRegistroController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:cliente');
    }

    public function registrar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'apellido' => ['required', 'string', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'ci_nit' => ['required', 'string', 'max:20', 'unique:clientes'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'nombre_usuario' => ['required', 'string', 'max:50', 'unique:clientes', 'regex:/^[a-zA-Z0-9_]+$/'],
            'correo' => ['required', 'string', 'email', 'max:100', 'unique:clientes'],
            'clave' => [
                'required', 
                'string', 
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
            'celular' => ['required', 'string', 'max:15', 'regex:/^[0-9]+$/'],
            'genero' => ['required', Rule::in(['Masculino', 'Femenino', 'Otro'])],
            'terms' => ['required', 'accepted']
        ], $this->mensajesValidacion());

        // Validación en tiempo real para la fortaleza de la contraseña
        if ($request->ajax() && $request->has('clave')) {
            $passwordErrors = [];
            
            if (strlen($request->clave) < 8) {
                $passwordErrors[] = 'La contraseña debe tener al menos 8 caracteres.';
            }
            
            if (!preg_match('/[A-Z]/', $request->clave)) {
                $passwordErrors[] = 'La contraseña debe contener al menos una mayúscula.';
            }
            
            if (!preg_match('/[a-z]/', $request->clave)) {
                $passwordErrors[] = 'La contraseña debe contener al menos una minúscula.';
            }
            
            if (!preg_match('/[0-9]/', $request->clave)) {
                $passwordErrors[] = 'La contraseña debe contener al menos un número.';
            }
            
            if (!preg_match('/[\W]/', $request->clave)) {
                $passwordErrors[] = 'La contraseña debe contener al menos un símbolo.';
            }
            
            return response()->json([
                'errors' => $passwordErrors,
                'strength' => $this->calculatePasswordStrength($request->clave)
            ]);
        }

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $fotoPath = $this->manejarFoto($request);

        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'ci_nit' => $request->ci_nit,
            'foto' => $fotoPath,
            'nombre_usuario' => $request->nombre_usuario,
            'correo' => $request->correo,
            'clave' => Hash::make($request->clave),
            'celular' => $request->celular,
            'genero' => $request->genero,
        ]);

        Auth::guard('cliente')->login($cliente);

        return redirect()->route('cliente.inicio')
               ->with('exito', '¡Registro exitoso! Bienvenido a nuestra tienda.');
    }

    protected function calculatePasswordStrength($password)
    {
        $strength = 0;
        
        // Longitud
        if (strlen($password) >= 8) $strength += 1;
        if (strlen($password) >= 12) $strength += 1;
        
        // Complejidad
        if (preg_match('/[A-Z]/', $password)) $strength += 1;
        if (preg_match('/[a-z]/', $password)) $strength += 1;
        if (preg_match('/[0-9]/', $password)) $strength += 1;
        if (preg_match('/[\W]/', $password)) $strength += 1;
        
        // Puntuación máxima de 6 (ajustable)
        return min(6, $strength);
    }

    protected function mensajesValidacion()
    {
        return [
            'nombre.required' => 'El campo nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'apellido.required' => 'El campo apellido es obligatorio.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',
            'ci_nit.required' => 'El CI/NIT es obligatorio.',
            'ci_nit.unique' => 'Este CI/NIT ya está registrado.',
            'nombre_usuario.required' => 'El nombre de usuario es obligatorio.',
            'nombre_usuario.unique' => 'Este nombre de usuario ya está en uso.',
            'nombre_usuario.regex' => 'El nombre de usuario solo puede contener letras, números y guiones bajos.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Debe ingresar un correo electrónico válido.',
            'correo.unique' => 'Este correo electrónico ya está registrado.',
            'clave.required' => 'La contraseña es obligatoria.',
            'clave.confirmed' => 'Las contraseñas no coinciden.',
            'celular.required' => 'El número de celular es obligatorio.',
            'celular.regex' => 'El celular solo puede contener números.',
            'genero.required' => 'Debe seleccionar un género.',
            'genero.in' => 'El género seleccionado no es válido.',
            'terms.required' => 'Debe aceptar los términos y condiciones.',
            'terms.accepted' => 'Debe aceptar los términos y condiciones.',
            'foto.image' => 'El archivo debe ser una imagen.',
            'foto.mimes' => 'La imagen debe ser JPEG, PNG, JPG o GIF.',
            'foto.max' => 'La imagen no debe pesar más de 2MB.'
        ];
    }

    protected function manejarFoto(Request $request)
    {
        if (!$request->hasFile('foto')) {
            return null;
        }

        $file = $request->file('foto');
        $extension = $file->getClientOriginalExtension();
        $fileName = Str::slug($request->nombre_usuario) . '-' . time() . '.' . $extension;
        
        return $file->storeAs('perfiles-clientes', $fileName, 'public');
    }
}