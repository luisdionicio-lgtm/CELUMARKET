<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migración.
     * Agrega nuevos campos detallados a la tabla 'products'.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->float('rating')->nullable();              // Calificación del producto
            $table->string('storage')->nullable();             // Almacenamiento interno
            $table->string('ram')->nullable();                 // Memoria RAM
            $table->string('processor')->nullable();           // Procesador
            $table->string('camera')->nullable();              // Configuración de cámara
            $table->string('screen')->nullable();              // Tamaño y tipo de pantalla
            $table->string('battery')->nullable();             // Capacidad de batería
            $table->boolean('in_stock')->default(true);        // Disponibilidad en inventario
            $table->boolean('featured')->default(false);       // Producto destacado
        });
    }

    /**
     * Revertir la migración.
     * Elimina los campos agregados si se revierte.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'rating',
                'storage',
                'ram',
                'processor',
                'camera',
                'screen',
                'battery',
                'in_stock',
                'featured',
            ]);
        });
    }
};