<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    // Mostrar modal de creación
    public function create()
    {
        return view('admin.gestion_material.modals.materiales.create');
    }

    // Guardar nuevo material
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'color' => 'nullable|string',
            'unidad_medida' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('imagen');
        
        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('materiales', 'public');
        }

        Material::create($data);

        return redirect()->route('admin.gestion_material.index')
            ->with('success', 'Material creado correctamente.');
    }

    // Mostrar modal de edición
    public function edit($id)
    {
        $material = Material::findOrFail($id);
        return view('admin.gestion_material.modals.materiales.edit', compact('material'));
    }

    // Actualizar material
    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'color' => 'nullable|string',
            'unidad_medida' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->except('imagen');
        
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($material->imagen) {
                Storage::disk('public')->delete($material->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('materiales', 'public');
        }

        $material->update($data);

        return redirect()->route('admin.gestion_material.index')
            ->with('success', 'Material actualizado correctamente.');
    }

    // Eliminar material
    public function destroy($id)
    {
        $material = Material::findOrFail($id);
        
        if ($material->imagen) {
            Storage::disk('public')->delete($material->imagen);
        }

        $material->delete();

        return redirect()->route('admin.gestion_material.index')
            ->with('success', 'Material eliminado correctamente.');
    }
}