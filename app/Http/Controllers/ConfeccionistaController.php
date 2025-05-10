<?php

namespace App\Http\Controllers;

use App\Models\Confeccionista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConfeccionistaController extends Controller
{
    public function store(Request $request)
    {
        // Convertir el estado a booleano antes de validar
        $request->merge([
            'estado' => $request->has('estado') // Si el checkbox está marcado = true
        ]);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:50',
            'apellido' => 'required|string|max:50',
            'celular' => 'required|string|max:15',
            'celular_referencia' => 'nullable|string|max:15',
            'direccion' => 'nullable|string',
            'estado' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.asignacion_material.index')
                ->withErrors($validator)
                ->withInput();
        }

        Confeccionista::create($request->all());

        return redirect()
            ->route('admin.asignacion_material.index')
            ->with('success', 'Confeccionista creado exitosamente');
    }

    public function update(Request $request, $id)
    {
        $confeccionista = Confeccionista::findOrFail($id);

        // Convertir el estado a booleano
        $request->merge([
            'estado' => $request->has('estado')
        ]);

        $validator = Validator::make($request->all(), [
            'nombre' => 'sometimes|string|max:50',
            'apellido' => 'sometimes|string|max:50',
            'celular' => 'sometimes|string|max:15',
            'celular_referencia' => 'nullable|string|max:15',
            'direccion' => 'nullable|string',
            'estado' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.asignacion_material.index')
                ->withErrors($validator)
                ->withInput();
        }

        $confeccionista->update($request->all());

        return redirect()
            ->route('admin.asignacion_material.index')
            ->with('success', 'Confeccionista actualizado exitosamente');
    }

    public function show($id)
    {
        $confeccionista = Confeccionista::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $confeccionista,
        ]);
    }
}