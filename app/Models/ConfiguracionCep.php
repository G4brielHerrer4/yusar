<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfiguracionCep extends Model
{
    protected $fillable = [
        'demanda_anual',
        'costo_orden',
        'costo_mantenimiento',
        'tiempo_entrega',
        'cantidad_economica',
        'punto_reorden',
        'frecuencia_dias'
    ];

    protected $table = 'configuracion_cep';

    // Relación con InventarioMaterial
    public function inventarioMaterial()
    {
        return $this->belongsTo(InventarioMaterial::class);
    }

    // Calcular CEP automáticamente al guardar
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->calcularCep();
        });
    }

    public function calcularCep()
    {
        $this->cantidad_economica = sqrt(
            (2 * $this->demanda_anual * $this->costo_orden) / $this->costo_mantenimiento
        );
        
        $this->punto_reorden = ($this->demanda_anual / 365) * $this->tiempo_entrega;
        
        $this->frecuencia_dias = 365 / ($this->demanda_anual / $this->cantidad_economica);
    }
}