<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Coleccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class ColeccionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|unique:colecciones',
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'descripcion' => 'nullable|string|max:255',
            'estado' => 'required|boolean',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ], [
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal_target', '#modalColeccionCreate');
        }

        $imagenPath = $request->file('imagen')->store('colecciones', 'public');

        Coleccion::create([
            'nombre' => $request->nombre,
            'imagen' => $imagenPath,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin
        ]);

        return redirect()->back()->with('success', 'Colección creada exitosamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $coleccion = Coleccion::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nombre' => 'required|string|max:100|unique:colecciones,nombre,'.$coleccion->id,
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'descripcion' => 'nullable|string|max:255',
            'estado' => 'required|boolean',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ], [
            'fecha_fin.after_or_equal' => 'La fecha de fin debe ser igual o posterior a la fecha de inicio'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('modal_target', '#modalColeccionEdit'.$id);
        }

        $data = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin
        ];

        if ($request->hasFile('imagen')) {
            if ($coleccion->imagen && Storage::disk('public')->exists($coleccion->imagen)) {
                Storage::disk('public')->delete($coleccion->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('colecciones', 'public');
        }

        $coleccion->update($data);

        return redirect()->back()->with('success', 'Colección actualizada exitosamente');
    }

    /**
     * Verifica si una colección está activa según las fechas
     */
    public static function verificarEstadoColeccion($coleccion)
    {
        $hoy = Carbon::now();
        return $coleccion->estado && 
               $hoy->between($coleccion->fecha_inicio, $coleccion->fecha_fin);
    }
}