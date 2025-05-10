<?php

namespace App\Http\Controllers;

use App\Models\Prenda;
use App\Models\User;
use App\Models\AsignacionConfeccion;
use App\Models\PrendaMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PrendaMaterialController extends Controller
{
    // Mostrar formulario de creación (para modal)
    public function create()
    {
        // Obtener todos los confeccionistas (rol_id = 3) CON sus materiales asignados
        $confeccionistas = User::with([
                'asignacionesConfeccion' => function($query) {
                    $query->where('cantidad', '>', 0)
                        ->with(['inventario.material']);
                }
            ])
            ->where('rol_id', 3)
            ->get()
            ->filter(function($user) {
                return $user->asignacionesConfeccion->isNotEmpty(); // Solo los con materiales
            });

        $prendas = Prenda::all();

        return view('admin.gestion_produccion.modals.prenda_material.create', [
            'confeccionistas' => $confeccionistas,
            'prendas' => $prendas
        ]);
    }

    // Nuevo método para obtener materiales por confeccionista (vía AJAX)
    public function getMaterialesByConfeccionista($userId)
    {
        // Verifica que el usuario sea confeccionista (rol_id = 3)
        $user = User::where('id', $userId)->where('rol_id', 3)->first();
        
        if (!$user) {
            return response()->json([]);
        }

        // Obtiene materiales con stock > 0 y carga relaciones necesarias
        $materiales = AsignacionConfeccion::with([
                'inventario.material', // Asegúrate que estas relaciones existan en el modelo
                'user'
            ])
            ->where('user_id', $userId)
            ->where('cantidad', '>', 0)
            ->get()
            ->map(function ($asignacion) {
                // Filtra asignaciones sin material
                if (!$asignacion->inventario || !$asignacion->inventario->material) {
                    return null;
                }

                return [
                    'id' => $asignacion->id,
                    'text' => sprintf(
                        "%s (Stock: %s %s) - Lote: %s",
                        $asignacion->inventario->material->nombre,
                        $asignacion->cantidad,
                        $asignacion->inventario->material->unidad_medida ?? 'unidades',
                        $asignacion->inventario->lote ?? 'N/A'
                    ),
                    'stock' => $asignacion->cantidad
                ];
            })
            ->filter() // Elimina elementos null
            ->values(); // Reindexa el array

        return response()->json($materiales);
    }

    // Almacenar nueva relación prenda-material
    public function store(Request $request)
    {
        $request->validate([
            'prenda_id' => 'required|exists:prendas,id',
            'asignacion_confeccion_id' => 'required|exists:asignacion_confeccion,id',
            'cantidad_usada' => 'required|numeric|min:0.01'
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Verificar stock disponible
                $asignacion = AsignacionConfeccion::findOrFail($request->asignacion_confeccion_id);

                if ($asignacion->cantidad < $request->cantidad_usada) {
                    throw ValidationException::withMessages([
                        'cantidad_usada' => 'No hay suficiente stock en esta asignación. Disponible: ' . $asignacion->cantidad
                    ]);
                }

                // Crear registro
                PrendaMaterial::create([
                    'prenda_id' => $request->prenda_id,
                    'asignacion_confeccion_id' => $request->asignacion_confeccion_id,
                    'cantidad_usada' => $request->cantidad_usada
                ]);

                // Descontar del stock
                $asignacion->decrement('cantidad', $request->cantidad_usada);
            });

            return response()->json([
                'success' => true,
                'message' => 'Material asignado a la prenda correctamente.'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }

    // Mostrar formulario de edición (para modal)
    public function edit($id)
    {
        $prendaMaterial = PrendaMaterial::with(['prenda', 'asignacion.confeccionista', 'asignacion.material'])
                          ->findOrFail($id);

        $asignaciones = AsignacionConfeccion::with(['material', 'confeccionista'])
                        ->where('cantidad', '>', 0)
                        ->orWhere('id', $prendaMaterial->asignacion_confeccion_id) // Incluir la asignación actual aunque tenga stock 0
                        ->get();

        return view('admin.gestion_produccion.modals.prenda_material.edit', compact('prendaMaterial', 'asignaciones'));
    }

    // Actualizar relación existente
    public function update(Request $request, $id)
    {
        $request->validate([
            'asignacion_confeccion_id' => 'required|exists:asignacion_confeccion,id',
            'cantidad_usada' => 'required|numeric|min:0.01'
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                $prendaMaterial = PrendaMaterial::findOrFail($id);
                $asignacionOriginal = $prendaMaterial->asignacion;
                $nuevaAsignacion = AsignacionConfeccion::findOrFail($request->asignacion_confeccion_id);

                // Caso 1: Misma asignación, cambiar cantidad
                if ($asignacionOriginal->id == $nuevaAsignacion->id) {
                    $diferencia = $request->cantidad_usada - $prendaMaterial->cantidad_usada;

                    if ($nuevaAsignacion->cantidad < $diferencia) {
                        throw ValidationException::withMessages([
                            'cantidad_usada' => 'No hay suficiente stock. Disponible: ' . $nuevaAsignacion->cantidad
                        ]);
                    }

                    $nuevaAsignacion->decrement('cantidad', $diferencia);
                } 
                // Caso 2: Diferente asignación
                else {
                    // Verificar stock en nueva asignación
                    if ($nuevaAsignacion->cantidad < $request->cantidad_usada) {
                        throw ValidationException::withMessages([
                            'cantidad_usada' => 'No hay suficiente stock en la nueva asignación. Disponible: ' . $nuevaAsignacion->cantidad
                        ]);
                    }

                    // Devolver stock a la asignación original
                    $asignacionOriginal->increment('cantidad', $prendaMaterial->cantidad_usada);

                    // Descontar de la nueva asignación
                    $nuevaAsignacion->decrement('cantidad', $request->cantidad_usada);
                }

                // Actualizar registro
                $prendaMaterial->update([
                    'asignacion_confeccion_id' => $request->asignacion_confeccion_id,
                    'cantidad_usada' => $request->cantidad_usada
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Material actualizado correctamente.'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error inesperado: ' . $e->getMessage()
            ], 500);
        }
    }

    // Eliminar asignación (y devolver stock)
    public function destroy($id)
    {
        try {
            DB::transaction(function () use ($id) {
                $prendaMaterial = PrendaMaterial::findOrFail($id);
                $asignacion = $prendaMaterial->asignacion;

                // Devolver stock
                $asignacion->increment('cantidad', $prendaMaterial->cantidad_usada);

                // Eliminar registro
                $prendaMaterial->delete();
            });

            return response()->json([
                'success' => true,
                'message' => 'Material retirado de la prenda y stock reembolsado.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar: ' . $e->getMessage()
            ], 500);
        }
    }
}