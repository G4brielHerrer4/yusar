<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Confeccionista extends Model
{
    use HasFactory;


    protected $table = 'confeccionistas';
    protected $fillable = [
        'nombre',
        'apellido',
        'celular',
        'celular_referencia',
        'direccion',
        'estado',
    ];

    // Opcional: Cast 'estado' a booleano (si prefieres)
    protected $casts = [
        'estado' => 'boolean',
    ];
}