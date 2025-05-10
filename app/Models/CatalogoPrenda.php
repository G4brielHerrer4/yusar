<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatalogoPrenda extends Model
{
    protected $table = 'catalogo_prendas';

    protected $fillable = [
        'inventario_id',
        'cantidad',
        'publicado'
    ];

    protected $casts = [
        'publicado' => 'boolean'
    ];

    public function inventario(): BelongsTo
    {
        return $this->belongsTo(InventarioPrenda::class, 'inventario_id');
    }

    // Método para activar/desactivar según cantidad
    public function actualizarEstado(): void
    {
        $this->publicado = $this->cantidad > 0;
        $this->save();
    }
}