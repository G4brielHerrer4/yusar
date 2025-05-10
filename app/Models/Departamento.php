<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $table = 'departamentos'; // Especifica el nombre de la tabla

    // Campos que se pueden asignar masivamente
    protected $fillable = ['nombre'];

    // Relación con la tabla sucursales
    public function sucursales()
    {
        return $this->hasMany(Sucursal::class);
    }
}