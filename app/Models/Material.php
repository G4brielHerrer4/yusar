<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materiales';
    protected $fillable = ['nombre', 'color', 'unidad_medida', 'imagen']; // 'color' ya estaba en tu migración

    public function inventarios(): HasMany
    {
        return $this->hasMany(InventarioMaterial::class);
    }

    public function configuracionesCep(): HasMany
    {
        return $this->hasMany(ConfiguracionCep::class);
    }

    public function detallesCompra(): HasMany
    {
        return $this->hasMany(DetalleCompra::class);
    }
}