<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $clientes = Cliente::orderBy('created_at', 'desc')->paginate(10);
        $clientes = Cliente::all();
        return view('admin.cliente.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.cliente.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => ['required', 'string', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'apellido' => ['required', 'string', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'ci_nit' => ['required', 'string', 'max:20', 'unique:clientes'],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'nombre_usuario' => ['required', 'string', 'max:50', 'unique:clientes'],
            'correo' => ['required', 'string', 'email', 'max:100', 'unique:clientes'],
            'clave' => ['required', 'string', Password::min(8)->mixedCase()->numbers()->symbols()],
            'celular' => ['required', 'string', 'max:15', 'regex:/^[0-9]+$/'],
            'genero' => ['required', Rule::in(['Masculino', 'Femenino', 'Otro'])],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no puede exceder los 100 caracteres.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',
            'ci_nit.required' => 'El CI/NIT es obligatorio.',
            'ci_nit.max' => 'El CI/NIT no puede exceder los 20 caracteres.',
            'ci_nit.unique' => 'Este CI/NIT ya está registrado.',
            'foto.image' => 'El archivo debe ser una imagen válida.',
            'foto.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif.',
            'foto.max' => 'La imagen no debe pesar más de 2MB.',
            'nombre_usuario.required' => 'El nombre de usuario es obligatorio.',
            'nombre_usuario.max' => 'El nombre de usuario no puede exceder los 50 caracteres.',
            'nombre_usuario.unique' => 'Este nombre de usuario ya está en uso.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Debe ingresar un correo electrónico válido.',
            'correo.max' => 'El correo no puede exceder los 100 caracteres.',
            'correo.unique' => 'Este correo electrónico ya está registrado.',
            'clave.required' => 'La contraseña es obligatoria.',
            'celular.required' => 'El número de celular es obligatorio.',
            'celular.max' => 'El celular no puede exceder los 15 caracteres.',
            'celular.regex' => 'El celular solo puede contener números.',
            'genero.required' => 'Debe seleccionar un género.',
            'genero.in' => 'El género seleccionado no es válido.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $fotoPath = $request->hasFile('foto') 
            ? $request->file('foto')->store('perfiles-clientes', 'public') 
            : null;

        Cliente::create([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'ci_nit' => $request->ci_nit,
            'foto' => $fotoPath,
            'nombre_usuario' => $request->nombre_usuario,
            'correo' => $request->correo,
            'clave' => bcrypt($request->clave),
            'celular' => $request->celular,
            'genero' => $request->genero,
        ]);

        return redirect()->route('cliente.index')
                        ->with('success', 'Cliente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('admin.cliente.show', compact('cliente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);
        return view('admin.cliente.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);

        $rules = [
            'nombre' => ['required', 'string', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'apellido' => ['required', 'string', 'max:100', 'regex:/^[\pL\s\-]+$/u'],
            'ci_nit' => ['required', 'string', 'max:20', Rule::unique('clientes')->ignore($cliente->id)],
            'foto' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'nombre_usuario' => ['required', 'string', 'max:50', Rule::unique('clientes')->ignore($cliente->id)],
            'correo' => ['required', 'string', 'email', 'max:100', Rule::unique('clientes')->ignore($cliente->id)],
            'celular' => ['required', 'string', 'max:15', 'regex:/^[0-9]+$/'],
            'genero' => ['required', Rule::in(['Masculino', 'Femenino', 'Otro'])],
        ];

        // Solo validar contraseña si se proporciona
        if ($request->filled('clave')) {
            $rules['clave'] = ['string', Password::min(8)->mixedCase()->numbers()->symbols()];
        }

        $validator = Validator::make($request->all(), $rules, [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre no puede exceder los 100 caracteres.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.max' => 'El apellido no puede exceder los 100 caracteres.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',
            'ci_nit.required' => 'El CI/NIT es obligatorio.',
            'ci_nit.max' => 'El CI/NIT no puede exceder los 20 caracteres.',
            'ci_nit.unique' => 'Este CI/NIT ya está registrado.',
            'foto.image' => 'El archivo debe ser una imagen válida.',
            'foto.mimes' => 'La imagen debe ser de tipo: jpeg, png, jpg o gif.',
            'foto.max' => 'La imagen no debe pesar más de 2MB.',
            'nombre_usuario.required' => 'El nombre de usuario es obligatorio.',
            'nombre_usuario.max' => 'El nombre de usuario no puede exceder los 50 caracteres.',
            'nombre_usuario.unique' => 'Este nombre de usuario ya está en uso.',
            'correo.required' => 'El correo electrónico es obligatorio.',
            'correo.email' => 'Debe ingresar un correo electrónico válido.',
            'correo.max' => 'El correo no puede exceder los 100 caracteres.',
            'correo.unique' => 'Este correo electrónico ya está registrado.',
            'celular.required' => 'El número de celular es obligatorio.',
            'celular.max' => 'El celular no puede exceder los 15 caracteres.',
            'celular.regex' => 'El celular solo puede contener números.',
            'genero.required' => 'Debe seleccionar un género.',
            'genero.in' => 'El género seleccionado no es válido.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        $data = $request->except('clave');
        
        if ($request->filled('clave')) {
            $data['clave'] = bcrypt($request->clave);
        }

        if ($request->hasFile('foto')) {
            if ($cliente->foto) {
                Storage::disk('public')->delete($cliente->foto);
            }
            $data['foto'] = $request->file('foto')->store('perfiles-clientes', 'public');
        }

        $cliente->update($data);

        return redirect()->route('cliente.index')
                        ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $cliente = Cliente::findOrFail($id);
        
        if ($cliente->foto) {
            Storage::disk('public')->delete($cliente->foto);
        }
        
        $cliente->delete();

        return redirect()->route('cliente.index')
                        ->with('success', 'Cliente eliminado exitosamente.');
    }
}