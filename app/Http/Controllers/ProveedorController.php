<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProveedorController extends Controller
{
    // Mostrar modal de creación
    public function create()
    {
        return view('admin.gestion_material.modals.proveedores.create');
    }

    // Guardar nuevo proveedor
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ci' => 'nullable|string',
            'contacto' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'activo' => 'boolean'
        ]);

        $data = $request->except('imagen');
        $data['activo'] = $request->has('activo');
        
        
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('proveedores', 'public');
        }

        Proveedor::create($data);

        return redirect()->route('admin.gestion_material.index')
            ->with('success', 'Proveedor creado correctamente.');
    }

    // Mostrar modal de edición
    public function edit($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        return view('admin.gestion_material.modals.proveedores.edit', compact('proveedor'));
    }

    // Actualizar proveedor
    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'ci' => 'nullable|string',
            'contacto' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'activo' => 'boolean'
        ]);

        $data = $request->except('imagen');
        $data['activo'] = $request->has('activo');
        
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($proveedor->imagen) {
                Storage::disk('public')->delete($proveedor->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('proveedores', 'public');
        }

        $proveedor->update($data);

        return redirect()->route('admin.gestion_material.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    // Eliminar proveedor
    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        
        if ($proveedor->imagen) {
            Storage::disk('public')->delete($proveedor->imagen);
        }

        $proveedor->delete();

        return redirect()->route('admin.gestion_material.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }
}