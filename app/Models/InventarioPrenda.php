<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InventarioPrenda extends Model
{
    protected $table = 'inventario_prendas';

    protected $fillable = [
        'recepcion_id',
        'categoria_id',
        'coleccion_id',
        'talla',
        'color',
        'cantidad_total',
        'imagen_principal',
        'imagenes_secundarias',
        'precio_venta',
        // 'destino'
    ];

    protected $casts = [
        'imagenes_secundarias' => 'array',
        'precio_venta' => 'decimal:2'
    ];

    // Relaciones
    public function recepcion(): BelongsTo
    {
        return $this->belongsTo(RecepcionPrenda::class, 'recepcion_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function coleccion(): BelongsTo
    {
        return $this->belongsTo(Coleccion::class, 'coleccion_id');
    }

    public function almacen(): HasOne
    {
        return $this->hasOne(AlmacenPrenda::class, 'inventario_id');
    }

    public function catalogo(): HasOne
    {
        return $this->hasOne(CatalogoPrenda::class, 'inventario_id');
    }
}