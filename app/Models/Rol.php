<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{

    protected $table = 'roles'; // Especifica el nombre de la tabla
    protected $fillable = ['nombre'];

    // Relación con el modelo User
    public function users()
    {
        return $this->hasMany(User::class, 'rol_id');
    }
}