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
        Schema::create('configuracion_cep', function (Blueprint $table) {
            $table->id();
            
            // Relación con inventario_materiales (1:1)
            $table->unsignedBigInteger('inventario_material_id')->unique();
            $table->foreign('inventario_material_id')
                ->references('id')
                ->on('inventario_materiales')
                ->onDelete('cascade');
            
            // Parámetros CEP
            $table->decimal('demanda_anual', 10, 2)->comment('Unidades consumidas por año');
            $table->decimal('costo_orden', 10, 2)->comment('Costo de realizar un pedido ($)');
            $table->decimal('costo_mantenimiento', 10, 2)->comment('Costo de almacenar por unidad/año ($)');
            $table->decimal('tiempo_entrega', 10, 2)->comment('Días de espera para recibir el pedido');
            
            // Campos calculados
            $table->decimal('cantidad_economica', 10, 2)->comment('CEP = √((2*Demanda*Costo_Orden)/Costo_Mantenimiento)');
            $table->decimal('punto_reorden', 10, 2)->comment('Demanda durante el tiempo de entrega');
            $table->integer('frecuencia_dias')->comment('Cada cuántos días se debe pedir (365/(Demanda/CEP))');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracion_cep');
    }
};
