<?php

namespace App\Http\Controllers;

use App\Models\AsignacionMaterial;
use App\Models\RecepcionPrenda;
use App\Models\User;
use App\Models\Confeccionista;
use App\Models\InventarioMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;


class AsignacionMaterialController extends Controller
{
    public function index()
    {
        $asignaciones = AsignacionMaterial::with(['responsable', 'confeccionista'])->latest()->get();
        $recepciones = RecepcionPrenda::with(['asignacion', 'recibidoPor'])->latest()->get();
        $responsables = User::all();
        $materiales = InventarioMaterial::with('material')->get();
        // $confeccionistas = Confeccionista::where('estado', true)->latest()->get();
        $confeccionistas = Confeccionista::all();
        
        
        return view('admin.asignacion_material.index', compact(
            'asignaciones',
            'recepciones',
            'responsables',
            'materiales',
            'confeccionistas',
            
        ));
    }

    public function create()
    {
        $responsables = User::all();
        $materiales = InventarioMaterial::with('material')->get();
        $confeccionistas = Confeccionista::where('estado', true)->latest()->get();
        return view('admin.asignacion_material.modals.asignacion.create', compact(
            'responsables',
            'materiales',
            'confeccionistas'
        ));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'responsable_id' => 'required|exists:users,id',
            'confeccionista_id' => 'required|exists:confeccionistas,id',
            'materiales' => 'required|array|min:1',
            'materiales.*.material_id' => 'required|exists:inventario_materiales,id',
            'materiales.*.cantidad' => 'required|numeric|min:0.1',
            'prendas_esperadas' => 'required|integer|min:1',
            'fecha_entrega_estimada' => 'required|date', // Eliminada validación after:today
            'observaciones' => 'nullable|string'
        ], [
            'confeccionista_id.required' => 'Debe seleccionar un confeccionista.',
            'materiales.required' => 'Debe asignar al menos un material.',
            'materiales.*.material_id.exists' => 'El material seleccionado no existe.',
            'materiales.*.cantidad.min' => 'La cantidad debe ser mayor a 0.',
            'fecha_entrega_estimada.date' => 'La fecha de entrega no es válida.',
        ]);

        // Validación personalizada de stock
        $validator->after(function ($validator) use ($request) {
            $materialesConStockInsuficiente = [];
            
            foreach ($request->materiales as $key => $item) {
                $inventario = InventarioMaterial::with('material')->find($item['material_id']);
                
                if (!$inventario) {
                    $validator->errors()->add(
                        "materiales.$key.material_id",
                        "El material seleccionado no existe en el inventario."
                    );
                    continue;
                }

                if ($inventario->stock_actual <= 0) {
                    $validator->errors()->add(
                        "materiales.$key.material_id",
                        "El material {$inventario->material->nombre} no tiene stock disponible."
                    );
                    continue;
                }

                if ($inventario->stock_actual < $item['cantidad']) {
                    $validator->errors()->add(
                        "materiales.$key.cantidad",
                        "Stock insuficiente de {$inventario->material->nombre}. Disponible: {$inventario->stock_actual}"
                    );
                    
                    $materialesConStockInsuficiente[] = [
                        'material' => $inventario->material->nombre,
                        'stock' => $inventario->stock_actual,
                        'solicitado' => $item['cantidad']
                    ];
                }
            }

            if (!empty($materialesConStockInsuficiente)) {
                $request->session()->flash('stock_errors', $materialesConStockInsuficiente);
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', '¡Error en los datos! Corrige los campos resaltados.');
        }

        try {
            DB::beginTransaction();

            $materialesAsignados = [];
            foreach ($request->materiales as $item) {
                $inventario = InventarioMaterial::with('material')->find($item['material_id']);
                
                if ($inventario->stock_actual < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente de {$inventario->material->nombre} al procesar la asignación");
                }

                $materialesAsignados[] = [
                    'material_id' => $item['material_id'],
                    'cantidad' => $item['cantidad'],
                    'nombre' => $inventario->material->nombre,
                    'stock_actual' => $inventario->stock_actual
                ];
            }

            $asignacion = AsignacionMaterial::create([
                'responsable_id' => $request->responsable_id,
                'confeccionista_id' => $request->confeccionista_id,
                'materiales_asignados' => $materialesAsignados,
                'prendas_esperadas' => $request->prendas_esperadas,
                'fecha_entrega_estimada' => $request->fecha_entrega_estimada,
                'estado' => 'pendiente',
                'observaciones' => $request->observaciones
            ]);

            DB::commit();

            return redirect()->route('admin.asignacion_material.index')
                ->with('success', '¡Asignación creada correctamente!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->back()
                ->with('error', 'Error al crear la asignación: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $asignacion = AsignacionMaterial::with('confeccionista')->findOrFail($id);
        $responsables = User::all();
        $materiales = InventarioMaterial::with('material')->get();
        $confeccionistas = Confeccionista::where('estado', true)->latest()->get();
        
        return view('admin.asignacion_material.modals.asignacion.edit', compact(
            'asignacion',
            'responsables',
            'materiales',
            'confeccionistas'
        ));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'responsable_id' => 'required|exists:users,id',
            'confeccionista_id' => 'required|exists:confeccionistas,id',
            'prendas_esperadas' => 'required|integer|min:1',
            'fecha_entrega_estimada' => 'required|date',
            'estado' => 'required|in:pendiente,completado,cancelado',
            'observaciones' => 'nullable|string'
        ], [
            'fecha_entrega_estimada.after' => 'La fecha debe ser futura.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', '¡Error en los datos!');
        }

        try {
            DB::beginTransaction();

            $asignacion = AsignacionMaterial::findOrFail($id);
            $estadoAnterior = $asignacion->estado;
            $nuevoEstado = $request->estado;

            // Manejo de inventario
            if ($estadoAnterior === 'completado' && $nuevoEstado !== 'completado') {
                foreach ($asignacion->materiales_asignados as $material) {
                    InventarioMaterial::where('id', $material['material_id'])
                        ->increment('stock_actual', $material['cantidad']);
                }
            } elseif ($nuevoEstado === 'completado' && $estadoAnterior !== 'completado') {
                foreach ($asignacion->materiales_asignados as $material) {
                    $inventario = InventarioMaterial::find($material['material_id']);
                    if ($inventario->stock_actual < $material['cantidad']) {
                        throw new \Exception("No hay suficiente stock de {$material['nombre']}");
                    }
                    $inventario->decrement('stock_actual', $material['cantidad']);
                }
            }

            $asignacion->update([
                'responsable_id' => $request->responsable_id,
                'confeccionista_id' => $request->confeccionista_id,
                'prendas_esperadas' => $request->prendas_esperadas,
                'fecha_entrega_estimada' => $request->fecha_entrega_estimada,
                'estado' => $nuevoEstado,
                'observaciones' => $request->observaciones
            ]);

            DB::commit();

            return redirect()->route('admin.asignacion_material.index')
                ->with('success', 'Asignación actualizada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al actualizar: '.$e->getMessage());
        }
    }
}