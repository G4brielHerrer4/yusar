<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsignacionMaterial extends Model
{
    protected $table = 'asignacion_materiales';
    
    protected $fillable = [
        'responsable_id',
        'confeccionista_id', // Nuevo campo para la relación
        'materiales_asignados',
        'prendas_esperadas',
        'fecha_entrega_estimada',
        'estado',
        'observaciones'
    ];

    protected $casts = [
        'materiales_asignados' => 'array',
        'fecha_entrega_estimada' => 'datetime:Y-m-d',
        'prendas_esperadas' => 'integer'
    ];

    protected $attributes = [
        'estado' => 'pendiente',
    ];

    public const ESTADOS = [
        'pendiente' => 'Pendiente',
        'completado' => 'Completado',
        'cancelado' => 'Cancelado'
    ];

    // Relación con el responsable (usuario)
    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id')->withDefault([
            'name' => 'Usuario Eliminado',
        ]);
    }

    // Nueva relación con el confeccionista
    public function confeccionista()
    {
        return $this->belongsTo(Confeccionista::class);
    }

    // Accesor para el nombre completo del confeccionista
    public function getNombreConfeccionistaAttribute(): string
    {
        return $this->confeccionista->nombre . ' ' . $this->confeccionista->apellido;
    }

    // Accesor para el color del estado (para vistas)
    public function getEstadoColorAttribute(): string
    {
        return match($this->estado) {
            'pendiente' => 'warning',
            'completado' => 'success',
            'cancelado' => 'danger',
            default => 'secondary'
        };
    }

    // Métodos existentes (sin cambios)
    public function getMaterialAsignado($materialId): ?array
    {
        foreach ($this->materiales_asignados as $material) {
            if ($material['material_id'] == $materialId) {
                return $material;
            }
        }
        return null;
    }

    public function getTotalMateriales(): float
    {
        return collect($this->materiales_asignados)->sum('cantidad');
    }

    public function estaPendiente(): bool
    {
        return $this->estado === 'pendiente';
    }
}