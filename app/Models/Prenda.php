<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Prenda extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'nombre',
        'version',
        'descripcion',
        'talla',
        'color',
        'categoria_id',
        'coleccion_id'
    ];

    protected $casts = [
        'confirmada' => 'boolean',
    ];


    // Relación con categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación con colección
    public function coleccion()
    {
        return $this->belongsTo(Coleccion::class);
    }

    // Relación con materiales usados
    public function materiales()
    {
        return $this->hasMany(PrendaMaterial::class);
    }

    public function materialesUsados()
    {
        return $this->hasMany(PrendaMaterial::class);
    }


    public function confirmacion()
    {
        return $this->hasOne(ConfirmacionPrenda::class);
    }
    
    public function estaConfirmada()
    {
        return $this->confirmada && $this->confirmacion;
    }


  
}