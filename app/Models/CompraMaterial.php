<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    BelongsTo,
    HasMany
};

class CompraMaterial extends Model
{

    protected $table = 'compras_materiales';
    protected $fillable = [
        'user_id', 
        'proveedor_id', 
        'estado', 
        'fecha_entrega_estimada'
    ];
    protected $casts = [
        'fecha_entrega_estimada' => 'datetime',
    ];

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function detalles(): HasMany
    {
        return $this->hasMany(DetalleCompra::class, 'compra_id');
    }
}