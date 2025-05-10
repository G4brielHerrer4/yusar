<?php

namespace App\Http\Controllers;

use App\Models\Prenda;
use App\Models\AlmacenPrenda;
use App\Models\CatalogoPrenda;
use App\Models\Categoria;
use App\Models\Coleccion;
use App\Models\ConfirmacionPrenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;


class PrendaController extends Controller
{
    // Método store() ajustado a tu tabla exacta
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'codigo' => 'required|string|max:50|unique:prendas',
            'nombre' => 'required|string|max:100',
            'version' => 'required|string|max:50',
            'talla' => 'required|string|max:20',
            'color' => 'required|string|max:50',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'coleccion_id' => 'nullable|exists:colecciones,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Error en el formulario');
        }

        // Crear prenda con confirmación inicial en false
        $prenda = Prenda::create(array_merge($request->all(), ['confirmada' => false]));

        return redirect()->route('asignaciones-confeccion.index')
            ->with('success', 'Prenda creada exitosamente');
    }

    // Método para confirmar una prenda
    

    public function showConfirmarForm($id)
    {
        $prenda = Prenda::findOrFail($id);
        
        if ($prenda->confirmada) {
            return redirect()->back()
                ->with('warning', 'Esta prenda ya ha sido confirmada');
        }

        return view('admin.gestion_produccion.modals.prendas.confirmar', compact('prenda'));
    }

    public function confirmar(Request $request, $id)
    {
        $prenda = Prenda::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'precio' => 'required|numeric|min:0',
            'imagen_principal' => 'required|image|max:2048', // 2MB máximo
            'imagenes_secundarias.*' => 'nullable|image|max:2048',
            'stock' => 'required|integer|min:0'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Error en el formulario de confirmación');
        }

        DB::transaction(function () use ($request, $prenda) {
            // Subir imágenes
            $imagenPrincipal = $request->file('imagen_principal')->store('public/prendas');
            
            $imagenesSecundarias = [];
            if ($request->hasFile('imagenes_secundarias')) {
                foreach ($request->file('imagenes_secundarias') as $imagen) {
                    $imagenesSecundarias[] = $imagen->store('public/prendas/secundarias');
                }
            }

            // Crear confirmación
            ConfirmacionPrenda::create([
                'prenda_id' => $prenda->id,
                'precio' => $request->precio,
                'imagen_principal' => str_replace('public/', 'storage/', $imagenPrincipal),
                'imagenes_secundarias' => $imagenesSecundarias ? 
                    array_map(fn($path) => str_replace('public/', 'storage/', $path), $imagenesSecundarias) : null,
                'stock' => $request->stock
            ]);

            // Marcar prenda como confirmada
            $prenda->update(['confirmada' => true]);
        });

        return redirect()->route('asignaciones-confeccion.index')
            ->with('success', 'Prenda confirmada exitosamente');
    }

    // Método update() ajustado
    public function update(Request $request, $id)
    {
        $prenda = Prenda::findOrFail($id);

        // Validar que no se pueda editar una prenda confirmada
        if ($prenda->confirmada) {
            return redirect()->back()
                ->with('error', 'No se puede editar una prenda ya confirmada');
        }

        $validator = Validator::make($request->all(), [
            'codigo' => [
                'required',
                'string',
                'max:50',
                Rule::unique('prendas')->ignore($prenda->id)
            ],
            'nombre' => 'required|string|max:100',
            'version' => 'required|string|max:50',
            'talla' => 'required|string|max:20',
            'color' => 'required|string|max:50',
            'descripcion' => 'nullable|string',
            'categoria_id' => 'required|exists:categorias,id',
            'coleccion_id' => 'nullable|exists:colecciones,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Error en el formulario');
        }

        $prenda->update($request->all());

        return redirect()->route('asignaciones-confeccion.index')
            ->with('success', 'Prenda actualizada exitosamente');
    }

    // Método destroy() con verificación de confirmación
    public function destroy($id)
    {
        $prenda = Prenda::findOrFail($id);
        
        // Verificar que la prenda no esté confirmada
        if ($prenda->confirmada) {
            return redirect()->route('asignaciones-confeccion.index')
                ->with('error', 'No se puede eliminar una prenda confirmada');
        }

        $prenda->delete();

        return redirect()->route('asignaciones-confeccion.index')
            ->with('success', 'Prenda eliminada exitosamente');
    }
}