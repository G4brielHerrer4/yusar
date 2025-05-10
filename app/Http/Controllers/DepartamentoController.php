<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartamentoController extends Controller
{
    /**
     * Mostrar la lista de departamentos.
     */
    public function index()
    {
        $departamentos = Departamento::all();
        return view('admin.departamento.index', compact('departamentos'));
    }

    /**
     * Mostrar el formulario para crear un nuevo departamento.
     */
    public function create()
    {
        return view('admin.departamento.create');
    }

    /**
     * Guardar un nuevo departamento en la base de datos.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => ['required', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', 'max:50'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'nombre.max' => 'El nombre no puede tener más de 50 caracteres.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        Departamento::create($validator->validated());

        return redirect()->route('departamento.index')
                        ->with('success', 'Departamento creado correctamente.');
    }

    /**
     * Mostrar los detalles de un departamento.
     */
    public function show($id)
    {
        $departamento = Departamento::findOrFail($id);
        return view('admin.departamento.show', compact('departamento'));
    }

    /**
     * Mostrar el formulario para editar un departamento.
     */
    public function edit($id)
    {
        $departamento = Departamento::findOrFail($id);
        return view('admin.departamento.edit', compact('departamento'));
    }

    /**
     * Actualizar un departamento en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $departamento = Departamento::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => ['required', 'regex:/^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/', 'max:50'],
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'nombre.max' => 'El nombre no puede tener más de 50 caracteres.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
        }

        
        $departamento->update($validator->validated());

        return redirect()->route('departamento.index')
                        ->with('success', 'Departamento actualizado correctamente.');
    }

    /**
     * Eliminar un departamento de la base de datos.
     */
    public function destroy($id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->delete();

        return redirect()->route('departamento.index')
                         ->with('success', 'Departamento eliminado correctamente.');
    }
}