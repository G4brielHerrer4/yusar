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
        Schema::create('inventario_materiales', function (Blueprint $table) {
            $table->id();
            
            // Relación con materiales (onDelete restrict)
            $table->unsignedBigInteger('material_id');
            $table->foreign('material_id')
                ->references('id')
                ->on('materiales')
                ->onDelete('restrict');
            
            // Relación con almacenes (onDelete restrict)
            $table->unsignedBigInteger('almacen_id');
            $table->foreign('almacen_id')
                ->references('id')
                ->on('almacenes')
                ->onDelete('restrict');
            
            // Relación opcional con detalle_compras (onDelete set null)
            $table->unsignedBigInteger('detalle_compra_id')->nullable();
            $table->foreign('detalle_compra_id')
                ->references('id')
                ->on('detalle_compras')
                ->onDelete('set null');
            
            $table->decimal('stock_actual', 10, 2)->default(0);
            $table->timestamps();
            
            // Índice único para evitar duplicados
            $table->unique(['material_id', 'almacen_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario_materiales');
    }
};
