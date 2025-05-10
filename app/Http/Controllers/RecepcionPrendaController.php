<?php

namespace App\Http\Controllers;

use App\Models\RecepcionPrenda;
use App\Models\InventarioPrenda;
use App\Models\AsignacionMaterial;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RecepcionPrendaController extends Controller
{
    public function create($asignacionId)
    {
        $asignacion = AsignacionMaterial::findOrFail($asignacionId);
        $responsables = User::all();
        return view('admin.asignacion_material.modals.recepcion.create', compact('asignacion', 'responsables'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'asignacion_id' => 'required|exists:asignacion_materiales,id',
            'tipo_prenda' => 'required|string|max:50',
            'prenda_nombre' => 'required|string|max:100',
            'codigo' => 'nullable|string|max:50',
            'talla' => 'required|in:XS,S,M,L,XL,XLL',
            'color' => 'required|string|max:50',
            'cantidad' => 'required|integer|min:1',
            'costo_confeccion_unitario' => 'required|numeric|min:0',
            'recibido_por' => 'required|exists:users,id',
            'fecha_recepcion' => 'required|date',
            'estado' => 'required|in:en_revision,aprobado,devuelto',
            'observacion' => 'nullable|string'
        ], [
            'tipo_prenda.required' => 'El tipo de prenda es obligatorio',
            'prenda_nombre.required' => 'El nombre/modelo de la prenda es obligatorio',
            'talla.required' => 'La talla es obligatoria',
            'color.required' => 'El color es obligatorio',
            'cantidad.required' => 'La cantidad es obligatoria',
            'costo_confeccion_unitario.required' => 'El costo unitario es obligatorio',
            'recibido_por.required' => 'Debe especificar quién recibió',
            'fecha_recepcion.required' => 'La fecha de recepción es obligatoria',
            'estado.required' => 'El estado es obligatorio'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', '¡Error en el formulario! Por favor corrige los errores.');
        }

        try {
            DB::beginTransaction();

            $recepcion = RecepcionPrenda::create([
                'asignacion_id' => $request->asignacion_id,
                'tipo_prenda' => $request->tipo_prenda,
                'prenda_nombre' => $request->prenda_nombre,
                'codigo' => $request->codigo,
                'talla' => $request->talla,
                'color' => $request->color,
                'cantidad' => $request->cantidad,
                'costo_confeccion_unitario' => $request->costo_confeccion_unitario,
                'recibido_por' => $request->recibido_por,
                'fecha_recepcion' => $request->fecha_recepcion,
                'estado' => $request->estado,
                'observacion' => $request->observacion
            ]);

            // Si el estado es aprobado al crear, registrar en inventario
            if ($request->estado === 'aprobado') {
                $this->crearRegistroInventario($recepcion);
            }

            DB::commit();

            return redirect()->route('admin.asignacion_material.index')
                ->with('success', 'Prenda registrada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error al registrar la prenda: '.$e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $recepcion = RecepcionPrenda::with(['asignacion', 'recibidoPor'])->findOrFail($id);
        $responsables = User::all();
        
        return view('admin.asignacion_material.modals.recepcion.edit', [
            'recepcion' => $recepcion,
            'responsables' => $responsables,
            'estados' => RecepcionPrenda::ESTADOS,
            'tallas' => RecepcionPrenda::TALLAS
        ]);
    }

    public function update(Request $request, $id)
    {
        $recepcion = RecepcionPrenda::with('inventario')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'prenda_nombre' => 'required|string|max:100',
            'codigo' => 'nullable|string|max:50',
            'talla' => 'required|in:'.implode(',', RecepcionPrenda::TALLAS),
            'color' => 'required|string|max:50',
            'cantidad' => 'required|integer|min:1',
            'costo_confeccion_unitario' => 'required|numeric|min:0',
            'recibido_por' => 'required|exists:users,id',
            'fecha_recepcion' => 'required|date',
            'estado' => 'required|in:'.implode(',', array_keys(RecepcionPrenda::ESTADOS)),
            'observacion' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', '¡Error en el formulario!');
        }

        try {
            DB::beginTransaction();

            // Guardar el estado actual antes de actualizar
            $estadoAnterior = $recepcion->estado;
            $nuevoEstado = $request->estado;

            // Actualizar los datos básicos
            $recepcion->update([
                'prenda_nombre' => $request->prenda_nombre,
                'codigo' => $request->codigo,
                'talla' => $request->talla,
                'color' => $request->color,
                'cantidad' => $request->cantidad,
                'costo_confeccion_unitario' => $request->costo_confeccion_unitario,
                'recibido_por' => $request->recibido_por,
                'fecha_recepcion' => $request->fecha_recepcion,
                'estado' => $nuevoEstado,
                'observacion' => $request->observacion
            ]);

            // Manejar el cambio de estado
            if ($estadoAnterior !== $nuevoEstado) {
                // Caso 1: Cambio a Aprobado (desde cualquier estado)
                if ($nuevoEstado === 'aprobado') {
                    $this->crearRegistroInventario($recepcion);
                }
                // Caso 2: Cambio desde Aprobado a otro estado (En revisión o Devuelto)
                elseif ($estadoAnterior === 'aprobado') {
                    $this->eliminarRegistroInventario($recepcion);
                }
            }

            DB::commit();

            $mensaje = 'Prenda actualizada correctamente';
            if ($estadoAnterior !== $nuevoEstado) {
                $mensaje .= '. Estado cambiado de '.RecepcionPrenda::ESTADOS[$estadoAnterior].' a '.RecepcionPrenda::ESTADOS[$nuevoEstado];
            }

            return redirect()->route('admin.asignacion_material.index')
                ->with('success', $mensaje);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error al actualizar recepción: ".$e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Error al actualizar: '.$e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $recepcion = RecepcionPrenda::with('inventario')->findOrFail($id);
            
            // Si tiene inventario, eliminarlo primero
            if ($recepcion->inventario) {
                $this->eliminarRegistroInventario($recepcion);
            }
            
            $recepcion->delete();
            
            DB::commit();
            
            return redirect()->route('admin.asignacion_material.index')
                ->with('success', 'Prenda eliminada correctamente');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.asignacion_material.index')
                ->with('error', 'Error al eliminar la prenda: '.$e->getMessage());
        }
    }

    /**
     * Crea un nuevo registro en el inventario para una recepción aprobada
     */
    protected function crearRegistroInventario(RecepcionPrenda $recepcion)
    {
        // Eliminar inventario existente si había
        if ($recepcion->inventario) {
            $recepcion->inventario->delete();
        }

        // Calcular precio de venta (costo + margen)
        $margen = rand(180, 250); // Margen aleatorio entre 180 y 250 Bs.
        $precioVenta = $recepcion->costo_confeccion_unitario + $margen;

        // Crear nuevo registro en inventario
        InventarioPrenda::create([
            'recepcion_id' => $recepcion->id,
            'precio_venta' => $precioVenta,
            'cantidad_total' => $recepcion->cantidad,
            'talla' => $recepcion->talla,
            'color' => $recepcion->color,
            'imagen_principal' => 'default.jpg'
        ]);
    }

    /**
     * Elimina el registro de inventario y sus relaciones
     */
    protected function eliminarRegistroInventario(RecepcionPrenda $recepcion)
    {
        if ($recepcion->inventario) {
            // Eliminar relaciones primero
            if ($recepcion->inventario->catalogo) {
                $recepcion->inventario->catalogo->delete();
            }
            if ($recepcion->inventario->almacen) {
                $recepcion->inventario->almacen->delete();
            }
            
            // Eliminar el inventario
            $recepcion->inventario->delete();
        }
    }
}