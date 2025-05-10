<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); // Nombre
            $table->string('apellido'); // Apellido
            $table->string('ci')->unique(); // CI (Cédula de Identidad)
            $table->enum('genero', ['Masculino', 'Femenino', 'Otro']); // Género
            $table->string('celular'); // Celular
            $table->string('correo_electronico')->unique(); // Correo Electrónico
            $table->string('clave'); // Clave (en lugar de password)
            $table->string('foto')->nullable(); // Foto (puede ser nulo)
            $table->unsignedBigInteger('rol_id')->nullable(); // Rol ID (clave foránea, puede ser nulo)
            $table->rememberToken(); // Token para "recordar sesión"
            $table->timestamps(); // Campos de fecha de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
