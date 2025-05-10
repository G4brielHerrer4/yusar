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
        Schema::create('asignacion_materiales', function (Blueprint $table) {
            $table->id();
            
            // Relación con el responsable (users)
            $table->unsignedBigInteger('responsable_id');
            $table->foreign('responsable_id')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            
            $table->unsignedBigInteger('confeccionista_id');
            $table->foreign('confeccionista_id')
                ->references('id')
                ->on('confeccionistas')
                ->onDelete('restrict');
            
            // Materiales asignados (JSON): [{material_id: 1, cantidad: 5}, ...]
            $table->json('materiales_asignados');
            
            $table->integer('prendas_esperadas'); // Cantidad estimada
            $table->date('fecha_entrega_estimada');
            $table->enum('estado', ['pendiente', 'completado', 'cancelado'])->default('pendiente');
            $table->text('observaciones')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignacion_materiales');
    }
};
