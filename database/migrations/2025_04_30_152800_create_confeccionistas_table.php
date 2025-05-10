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
        Schema::create('confeccionistas', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('celular', 15); 
            $table->string('celular_referencia', 15)->nullable(); 
            $table->text('direccion')->nullable(); 
            $table->boolean('estado')->default(true); 
            $table->timestamps(); // created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confeccionistas');
    }
};
