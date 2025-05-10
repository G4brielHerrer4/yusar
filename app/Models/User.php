<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nombre',
        'apellido',
        'ci',
        'genero',
        'celular',
        'correo_electronico',
        'clave',
        'foto',
        'rol_id',
    ];

    protected $hidden = [
        'clave',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'clave' => 'hashed',
    ];

    /**
     * Relación con el rol del usuario
     */
    public function rol()
    {
        return $this->belongsTo(Rol::class);
    }


    /**
     * Sobrescribir el método para obtener la clave
     */
    public function getAuthPassword()
    {
        return $this->clave;
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(AsignacionMaterial::class, 'responsable_id');
    }

   
}