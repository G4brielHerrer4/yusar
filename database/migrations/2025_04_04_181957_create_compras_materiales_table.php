<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('compras_materiales', function (Blueprint $table) {
            $table->id();
            
            // Relación con users - FORMA CORRECTA
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            
            // Relación con proveedores
            $table->foreignId('proveedor_id')
                ->constrained('proveedores')
                ->onDelete('restrict');
            
            $table->enum('estado', ['pendiente', 'recibido', 'cancelado'])
                ->default('pendiente');
            $table->date('fecha_entrega_estimada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('compras_materiales');
    }
};
