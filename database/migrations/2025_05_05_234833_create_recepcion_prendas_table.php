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
        Schema::create('recepcion_prendas', function (Blueprint $table) {
            $table->id();
            
            // Relación con la asignación
            $table->unsignedBigInteger('asignacion_id');
            $table->foreign('asignacion_id')
                ->references('id')
                ->on('asignacion_materiales')
                ->onDelete('cascade');
            
            // Prenda como campo simple (sin tabla)
            $table->string('tipo_prenda'); // Ej.: "Blusa", "Chaleco"
            $table->string('prenda_nombre'); // Ej.: "Brillio", "Luminoso"
            $table->string('codigo')->nullable(); // Opcional
            
            // Detalles
            $table->enum('talla', ['XS', 'S', 'M', 'L', 'XL', 'XLL']);
            $table->string('color');
            $table->integer('cantidad');
            $table->decimal('costo_confeccion_unitario', 10, 2);
            $table->decimal('total', 10, 2)->storedAs('cantidad * costo_confeccion_unitario'); // ¡Automático!
            
            // Recepción
            $table->unsignedBigInteger('recibido_por');
            $table->foreign('recibido_por')
                ->references('id')
                ->on('users')
                ->onDelete('restrict');
            
            $table->date('fecha_recepcion');
            $table->enum('estado', ['en_revision', 'aprobado', 'devuelto'])->default('en_revision');
            $table->text('observacion')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recepcion_prendas');
    }
};
