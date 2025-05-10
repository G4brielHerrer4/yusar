<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacenes';
    protected $fillable = ['nombre', 'ubicacion', 'activo']; // Añadido 'activo'
    protected $casts = [
        'activo' => 'boolean', // Asegura que 'activo' sea tratado como booleano
    ];

    public function inventarios(): HasMany
    {
        return $this->hasMany(InventarioMaterial::class);
    }
}