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
        Schema::create('catalogo_prendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventario_id');
            $table->foreign('inventario_id')
                  ->references('id')
                  ->on('inventario_prendas')
                  ->onDelete('cascade');
        
            $table->integer('cantidad'); // Ej: 3 unidades en catálogo
            $table->boolean('publicado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('catalogo_prendas');
    }
};
