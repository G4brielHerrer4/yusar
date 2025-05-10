<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrendaMaterial extends Model
{
    use HasFactory;

    protected $table = 'prenda_materiales';

    protected $fillable = [
        'prenda_id',
        'asignacion_confeccion_id',
        'cantidad_usada'
    ];

    // Relación con prenda
    public function prenda()
    {
        return $this->belongsTo(Prenda::class);
    }

    // Relación con asignación de confección
    public function asignacion()
    {
        return $this->belongsTo(AsignacionConfeccion::class, 'asignacion_confeccion_id');
    }
}