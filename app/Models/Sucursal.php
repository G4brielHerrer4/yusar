<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    use HasFactory;

    protected $table = 'sucursales'; // Especifica el nombre de la tabla

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'direccion',
        'latitud',
        'longitud',
        'estado',
        'departamento_id',
    ];

    // Relación con la tabla departamentos
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }
}