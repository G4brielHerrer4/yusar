<?php

namespace App\Http\Controllers;

use App\Models\Sucursal;
use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SucursalController extends Controller
{
    /**
     * Mostrar la lista de sucursales.
     */
    public function index()
    {
        $sucursales = Sucursal::with('departamento')->get();
        return view('admin.sucursal.index', compact('sucursales'));
    }

    /**
     * Mostrar el formulario para crear una nueva sucursal.
     */
    public function create()
    {
        $departamentos = Departamento::all();
        return view('admin.sucursal.create', compact('departamentos'));
    }

    /**
     * Guardar una nueva sucursal en la base de datos.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50|regex:/^[a-zA-Z0-9\s]+$/',
            'direccion' => 'required|string|max:150',
            'latitud' => 'required|string',
            'longitud' => 'required|string',
            'estado' => 'required|boolean',
            'departamento_id' => 'nullable|exists:departamentos,id',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y números.',
            'nombre.max' => 'El nombre no puede superar los 50 caracteres.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no puede superar los 150 caracteres.',
            'estado.required' => 'El estado es obligatorio.',
            'departamento_id.exists' => 'El departamento seleccionado no es válido.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        Sucursal::create($validator->validated());


        return redirect()->route('sucursal.index')
                         ->with('success', 'Sucursal creada correctamente.');
    }

    /**
     * Mostrar los detalles de una sucursal.
     */
    public function show($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        return view('admin.sucursal.show', compact('sucursal'));
    }

    /**
     * Mostrar el formulario para editar una sucursal.
     */
    public function edit($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        $departamentos = Departamento::all();
        return view('admin.sucursal.edit', compact('sucursal', 'departamentos'));
    }

    /**
     * Actualizar una sucursal en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $sucursal = Sucursal::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50|regex:/^[a-zA-Z0-9\s]+$/',
            'direccion' => 'required|string|max:150',
            'latitud' => 'nullable|numeric',
            'longitud' => 'nullable|numeric',
            'estado' => 'required|boolean',
            'departamento_id' => 'nullable|exists:departamentos,id',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y números.',
            'nombre.max' => 'El nombre no puede superar los 50 caracteres.',
            'direccion.required' => 'La dirección es obligatoria.',
            'direccion.max' => 'La dirección no puede superar los 150 caracteres.',
            'estado.required' => 'El estado es obligatorio.',
            'departamento_id.exists' => 'El departamento seleccionado no es válido.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

    
        $sucursal->update($validator->validated());


        return redirect()->route('sucursal.index')
                         ->with('success', 'Sucursal actualizada correctamente.');
    }

    /**
     * Eliminar una sucursal de la base de datos.
     */
    public function destroy($id)
    {
        $sucursal = Sucursal::findOrFail($id);
        $sucursal->delete();

        return redirect()->route('sucursal.index')
                         ->with('success', 'Sucursal eliminada correctamente.');
    }
}
