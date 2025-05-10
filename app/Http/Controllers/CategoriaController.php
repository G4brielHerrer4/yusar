<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoriaController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|unique:categorias',
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'descripcion' => 'nullable|string|max:255',
            'estado' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal_target', '#modalCategoriaCreate');
        }

        $imagenPath = $request->file('imagen')->store('categorias', 'public');

        Categoria::create([
            'nombre' => $request->nombre,
            'imagen' => $imagenPath,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado
        ]);

        return redirect()->back()->with('success', 'Categoría creada exitosamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $categoria = Categoria::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|unique:categorias,nombre,'.$categoria->id,
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'descripcion' => 'nullable|string|max:255',
            'estado' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal_target', '#modalCategoriaEdit'.$id);
        }

        $data = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado
        ];

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($categoria->imagen && Storage::disk('public')->exists($categoria->imagen)) {
                Storage::disk('public')->delete($categoria->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('categorias', 'public');
        }

        $categoria->update($data);

        return redirect()->back()->with('success', 'Categoría actualizada exitosamente');
    }
}