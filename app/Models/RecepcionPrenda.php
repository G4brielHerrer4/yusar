<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RecepcionPrenda extends Model
{
    protected $table = 'recepcion_prendas';

    protected $fillable = [
        'asignacion_id',
        'tipo_prenda',
        'prenda_nombre',
        'codigo',
        'talla',
        'color',
        'cantidad',
        'costo_confeccion_unitario',
        'total',
        'recibido_por',
        'fecha_recepcion',
        'estado',
        'observacion'
    ];

    protected $casts = [
        'fecha_recepcion' => 'date',
        'costo_confeccion_unitario' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    // Constantes para estados
    public const ESTADOS = [
        'en_revision' => 'En Revisión',
        'aprobado' => 'Aprobado',
        'devuelto' => 'Devuelto'
    ];

    // Constantes para tallas
    public const TALLAS = [
        'XS', 'S', 'M', 'L', 'XL', 'XLL'
    ];

    // Relación con la asignación
    public function asignacion(): BelongsTo
    {
        return $this->belongsTo(AsignacionMaterial::class, 'asignacion_id');
    }

    // Relación con el usuario que recibió
    public function recibidoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recibido_por');
    }

    // Relación con inventario
    public function inventario(): HasOne
    {
        return $this->hasOne(InventarioPrenda::class, 'recepcion_id');
    }

    // Método para calcular el total automáticamente
    public static function calcularTotal($cantidad, $costoUnitario)
    {
        return $cantidad * $costoUnitario;
    }

    // Método para manejar el cambio de estado
    public function actualizarEstado($nuevoEstado)
    {
        $estadoAnterior = $this->estado;
        
        // Solo procesar si el estado cambió
        if ($estadoAnterior === $nuevoEstado) {
            return false;
        }

        // Cambio a Aprobado
        if ($nuevoEstado === 'aprobado') {
            $this->crearInventario();
            return true;
        }

        // Cambio desde Aprobado a otro estado
        if ($estadoAnterior === 'aprobado') {
            $this->eliminarInventario();
            return true;
        }

        return false;
    }

    // Crear registro en inventario
    protected function crearInventario()
    {
        // Eliminar inventario existente si hubiera
        if ($this->inventario) {
            $this->inventario->delete();
        }

        // Calcular precio sugerido (puedes ajustar esta lógica)
        $margen = $this->calcularMargen();
        $precioSugerido = $this->costo_confeccion_unitario + $margen;

        // Crear nuevo registro en inventario
        return InventarioPrenda::create([
            'recepcion_id' => $this->id,
            'precio_venta' => $precioSugerido,
            'cantidad_total' => $this->cantidad,
            'talla' => $this->talla,
            'color' => $this->color,
            'imagen_principal' => 'default.jpg', // Ajustar según tu lógica
            'destino' => 'almacen' // Por defecto va a almacén
        ]);
    }

    // Eliminar registro de inventario
    protected function eliminarInventario()
    {
        if (!$this->inventario) {
            return false;
        }

        // Eliminar de catálogo o almacén si existe
        if ($this->inventario->catalogo) {
            $this->inventario->catalogo->delete();
        }

        if ($this->inventario->almacen) {
            $this->inventario->almacen->delete();
        }

        // Eliminar el inventario
        return $this->inventario->delete();
    }

    // Calcular margen de ganancia (ajusta según tu lógica)
    protected function calcularMargen()
    {
        $margenes = [150, 200, 220, 250];
        return $margenes[array_rand($margenes)];
    }
}