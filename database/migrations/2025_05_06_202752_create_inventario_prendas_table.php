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
        Schema::create('inventario_prendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recepcion_id')->unique(); // Relación 1:1
            $table->foreign('recepcion_id')
                  ->references('id')
                  ->on('recepcion_prendas')
                  ->onDelete('cascade');
        
            // Relaciones con categoría/colección (1:1)
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->foreign('categoria_id')
                  ->references('id')
                  ->on('categorias')
                  ->onDelete('restrict');
        
            $table->unsignedBigInteger('coleccion_id')->nullable();
            $table->foreign('coleccion_id')
                  ->references('id')
                  ->on('colecciones')
                  ->onDelete('set null');
        
            // Atributos heredados de recepción (para evitar joins)
            $table->string('talla'); // Ej: "M"
            $table->string('color'); // Ej: "Rojo"
            $table->integer('cantidad_total'); // Ej: 10 unidades recibidas
        
            // Imágenes y precios
            $table->string('imagen_principal');
            $table->json('imagenes_secundarias')->nullable();
            $table->decimal('precio_venta', 10, 2);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario_prendas');
    }
};
