<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConfirmacionPrenda extends Model
{
    protected $fillable = [
        'prenda_id',
        'precio',
        'imagen_principal',
        'imagenes_secundarias',
        'stock'
    ];

    protected $casts = [
        'imagenes_secundarias' => 'array'
    ];

    public function prenda(): BelongsTo
    {
        return $this->belongsTo(Prenda::class);
    }
}