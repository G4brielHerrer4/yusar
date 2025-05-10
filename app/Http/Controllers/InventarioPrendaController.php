<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Coleccion;
use App\Models\InventarioPrenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class InventarioPrendaController extends Controller
{
    public function index()
    {
        $prendas = InventarioPrenda::with(['categoria', 'coleccion', 'recepcion'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $categorias = Categoria::all();
        $colecciones = Coleccion::all();

        return view('admin.inventario_prenda.index', [
            'prendas' => $prendas,
            'categorias' => $categorias,
            'colecciones' => $colecciones,
            'titulo' => 'Gestión de Inventario de Prendas'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'precio_oficial' => 'required|numeric|min:0',
            'categoria_id' => 'nullable|exists:categorias,id',
            'coleccion_id' => 'nullable|exists:colecciones,id',
            'imagen_principal' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'imagenes_secundarias.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
        ]);

        $prenda = InventarioPrenda::findOrFail($id);

        // Inicializar array de imágenes secundarias
        $imagenesSecundarias = [];

        // 1. Procesar imágenes existentes (si hay)
        if ($request->imagenes_secundarias_existentes) {
            $imagenesSecundarias = array_merge($imagenesSecundarias, $request->imagenes_secundarias_existentes);
        }

        // 2. Eliminar imágenes marcadas para eliminación
        if ($request->imagenes_secundarias_eliminar) {
            foreach ((array)$request->imagenes_secundarias_eliminar as $imagenEliminar) {
                Storage::delete($imagenEliminar);
                $imagenesSecundarias = array_diff($imagenesSecundarias, [$imagenEliminar]);
            }
        }

        // 3. Agregar nuevas imágenes
        if ($request->hasFile('imagenes_secundarias')) {
            foreach ($request->file('imagenes_secundarias') as $file) {
                $path = $file->store('public/prendas');
                $imagenesSecundarias[] = str_replace('public/', '', $path);
            }
        }

        // Actualizar todos los datos
        $prenda->update([
            'precio_venta' => $request->precio_oficial,
            'categoria_id' => $request->categoria_id,
            'coleccion_id' => $request->coleccion_id,
            'imagenes_secundarias' => $imagenesSecundarias, // Laravel hará el cast a JSON automático
            'imagen_principal' => $request->hasFile('imagen_principal')
                ? str_replace('public/', '', $request->file('imagen_principal')->store('public/prendas'))
                : ($request->eliminar_imagen_principal ? null : $prenda->imagen_principal)
        ]);

        return redirect()->route('admin.inventario_prenda.index')
            ->with('success', 'Prenda actualizada correctamente');
    }

    public function asignarDestino(Request $request, $id)
    {
        $prenda = InventarioPrenda::with(['almacen', 'catalogo'])->findOrFail($id);
        
        $request->validate([
            'cantidad_almacen' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use ($prenda) {
                    if ($value > $prenda->cantidad_total) {
                        $fail('La cantidad para almacén no puede ser mayor al total disponible ('.$prenda->cantidad_total.')');
                    }
                }
            ],
            'cantidad_catalogo' => [
                'required',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) use ($prenda) {
                    if ($value > $prenda->cantidad_total) {
                        $fail('La cantidad para catálogo no puede ser mayor al total disponible ('.$prenda->cantidad_total.')');
                    }
                }
            ],
            'ubicacion' => 'nullable|string|max:100',
            'publicado' => 'nullable|boolean'
        ]);

        $totalAsignado = $request->cantidad_almacen + $request->cantidad_catalogo;
        
        // Validación adicional para la suma total
        if ($totalAsignado > $prenda->cantidad_total) {
            return back()->withErrors([
                'cantidad' => 'La suma total ('.$totalAsignado.') no puede exceder el inventario disponible ('.$prenda->cantidad_total.')'
            ])->withInput();
        }

        // Validar que se asigne al menos una unidad
        if ($totalAsignado <= 0) {
            return back()->withErrors([
                'cantidad' => 'Debes asignar al menos una unidad a almacén o catálogo'
            ])->withInput();
        }

        DB::transaction(function () use ($prenda, $request) {
            // Gestionar almacén
            if ($request->cantidad_almacen > 0) {
                $prenda->almacen()->updateOrCreate(
                    ['inventario_id' => $prenda->id],
                    [
                        'cantidad' => $request->cantidad_almacen,
                        'ubicacion' => $request->ubicacion
                    ]
                );
            } else {
                $prenda->almacen()->delete();
            }

            // Gestionar catálogo
            if ($request->cantidad_catalogo > 0) {
                $prenda->catalogo()->updateOrCreate(
                    ['inventario_id' => $prenda->id],
                    [
                        'cantidad' => $request->cantidad_catalogo,
                        'publicado' => $request->has('publicado')
                    ]
                );
            } else {
                $prenda->catalogo()->delete();
            }
        });

        return redirect()->route('admin.inventario_prenda.index')
            ->with('success', 'Destino de la prenda actualizado correctamente');
    }
}