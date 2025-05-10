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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100); // Nombre
            $table->string('apellido', 100); // Apellido
            $table->string('ci_nit', 20)->unique(); // CI/NIT (único)
            $table->string('foto')->nullable(); // Foto (puede ser nulo)
            $table->string('nombre_usuario')->unique(); // Nombre de Usuario (único)
            $table->string('correo')->unique(); // Correo (único)
            $table->string('clave'); // Clave (password)
            $table->string('celular', 15); // Celular
            $table->enum('genero', ['Masculino', 'Femenino', 'Otro']); // Género
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
