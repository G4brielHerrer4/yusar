<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProduccionPrenda extends Model
{
    protected $table = 'produccion_prendas';
    protected $fillable = ['asignacion_id', 'variante_id', 'cantidad_producida'];

    public function asignacion()
    {
        return $this->belongsTo(AsignacionConfeccion::class);
    }

    public function variante()
    {
        return $this->belongsTo(VariantePrenda::class);
    }
}