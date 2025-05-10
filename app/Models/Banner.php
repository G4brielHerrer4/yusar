<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'enlace',
        'activo',
    ];

    // Si prefieres usar $guarded en lugar de $fillable:
    // protected $guarded = [];
}