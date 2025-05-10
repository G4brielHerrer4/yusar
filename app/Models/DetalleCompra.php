<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetalleCompra extends Model
{

    protected $table = 'detalle_compras';
    protected $fillable = [
        'compra_id',
        'material_id',
        'cantidad',
        'precio_unitario',
        'precio_total'
    ];

    public function compra(): BelongsTo
    {
        return $this->belongsTo(CompraMaterial::class);
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function inventarios() {
        return $this->hasMany(InventarioMaterial::class, 'detalle_compra_id');
    }
    protected static function booted()
    {
        static::saving(function ($model) {
            $model->precio_total = $model->cantidad * $model->precio_unitario;
        });
    }
}