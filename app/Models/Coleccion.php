<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coleccion extends Model
{
    protected $table = 'colecciones';

    protected $fillable = [
        'nombre',
        'imagen',
        'descripcion',
        'estado',
        'fecha_inicio',
        'fecha_fin'
    ];

    protected $casts = [
        'estado' => 'boolean',
        'fecha_inicio' => 'datetime:Y-m-d',
        'fecha_fin' => 'datetime:Y-m-d'
    ];

    public function prendas(): HasMany
    {
        return $this->hasMany(InventarioPrenda::class, 'coleccion_id');
    }
}