<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    
    // Mostrar modal de creación
    public function create()
    {
        return view('admin.gestion_material.modals.almacenes.create');
    }

    // Guardar nuevo almacén
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string',
            'activo' => 'boolean'
        ]);

        Almacen::create([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'activo' => $request->has('activo')
        ]);

        return redirect()->route('admin.gestion_material.index')
            ->with('success', 'Almacén creado correctamente.');
    }

    // Mostrar modal de edición
    public function edit($id)
    {
        $almacen = Almacen::findOrFail($id);
        return view('admin.gestion_material.modals.almacenes.edit', compact('almacen'));
    }

    // Actualizar almacén
    public function update(Request $request, $id)
    {
        $almacen = Almacen::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'ubicacion' => 'required|string',
            'activo' => 'boolean'
        ]);

        $almacen->update([
            'nombre' => $request->nombre,
            'ubicacion' => $request->ubicacion,
            'activo' => $request->has('activo')
        ]);

        return redirect()->route('admin.gestion_material.index')
            ->with('success', 'Almacén actualizado correctamente.');
    }

    // Eliminar almacén
    public function destroy($id)
    {
        $almacen = Almacen::findOrFail($id);
        $almacen->delete();

        return redirect()->route('admin.gestion_material.index')
            ->with('success', 'Almacén eliminado correctamente.');
    }
}