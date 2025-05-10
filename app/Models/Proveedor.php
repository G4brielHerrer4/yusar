<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';
    protected $fillable = ['nombre', 'ci', 'contacto', 'imagen', 'activo']; // Añadido 'activo'
    protected $casts = [
        'activo' => 'boolean', // Asegura que 'activo' sea tratado como booleano
    ];

    public function compras(): HasMany
    {
        return $this->hasMany(CompraMaterial::class);
    }

    public function configuracionesCep(): HasMany
    {
        return $this->hasMany(ConfiguracionCep::class);
    }
}