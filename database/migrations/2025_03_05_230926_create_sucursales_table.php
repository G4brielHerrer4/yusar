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
        Schema::create('sucursales', function (Blueprint $table) {
            $table->id(); // Clave primaria autoincremental
            $table->string('nombre'); // Nombre de la sucursal
            $table->string('direccion'); // Dirección de la sucursal
            $table->decimal('latitud', 10, 7)->nullable(); // Latitud con 10 dígitos y 7 decimales
            $table->decimal('longitud', 10, 7)->nullable(); // Longitud con 10 dígitos y 7 decimales
            $table->boolean('estado')->default(true); // Estado (activo por defecto)
            $table->unsignedBigInteger('departamento_id')->nullable(); // Clave foránea (nullable)

            // Definir la relación con la tabla departamentos
            $table->foreign('departamento_id')
                  ->references('id')
                  ->on('departamentos')
                  ->onDelete('set null'); // Si se elimina el departamento, departamento_id será NULL

            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sucursales');
    }
};
