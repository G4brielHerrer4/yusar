<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlmacenPrenda extends Model
{
    protected $table = 'almacen_prendas';

    protected $fillable = [
        'inventario_id',
        'cantidad',
        'ubicacion'
    ];

    public function inventario(): BelongsTo
    {
        return $this->belongsTo(InventarioPrenda::class, 'inventario_id');
    }
}