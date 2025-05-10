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
        Schema::create('colecciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique(); 
            $table->string('imagen'); 
            $table->text('descripcion')->nullable();
            $table->boolean('estado'); 
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colecciones');
    }
};
