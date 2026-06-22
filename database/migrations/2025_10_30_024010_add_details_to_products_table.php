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
            if (!Schema::hasColumn('products', 'rating')) {
                $table->float('rating')->nullable();              // Calificación del producto
            }
            if (!Schema::hasColumn('products', 'storage')) {
                $table->string('storage')->nullable();             // Almacenamiento interno
            }
            if (!Schema::hasColumn('products', 'ram')) {
                $table->string('ram')->nullable();                 // Memoria RAM
            }
            if (!Schema::hasColumn('products', 'processor')) {
                $table->string('processor')->nullable();           // Procesador
            }
            if (!Schema::hasColumn('products', 'camera')) {
                $table->string('camera')->nullable();              // Configuración de cámara
            }
            if (!Schema::hasColumn('products', 'screen')) {
                $table->string('screen')->nullable();              // Tamaño y tipo de pantalla
            }
            if (!Schema::hasColumn('products', 'battery')) {
                $table->string('battery')->nullable();             // Capacidad de batería
            }
            if (!Schema::hasColumn('products', 'in_stock')) {
                $table->boolean('in_stock')->default(true);        // Disponibilidad en inventario
            }
            if (!Schema::hasColumn('products', 'featured')) {
                $table->boolean('featured')->default(false);       // Producto destacado
            }
        });
    }

    /**
     * Revertir la migración.
     * Elimina los campos agregados si se revierte.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'rating')) {
                $table->dropColumn('rating');
            }
            if (Schema::hasColumn('products', 'storage')) {
                $table->dropColumn('storage');
            }
            if (Schema::hasColumn('products', 'ram')) {
                $table->dropColumn('ram');
            }
            if (Schema::hasColumn('products', 'processor')) {
                $table->dropColumn('processor');
            }
            if (Schema::hasColumn('products', 'camera')) {
                $table->dropColumn('camera');
            }
            if (Schema::hasColumn('products', 'screen')) {
                $table->dropColumn('screen');
            }
            if (Schema::hasColumn('products', 'battery')) {
                $table->dropColumn('battery');
            }
            if (Schema::hasColumn('products', 'in_stock')) {
                $table->dropColumn('in_stock');
            }
            if (Schema::hasColumn('products', 'featured')) {
                $table->dropColumn('featured');
            }
        });
    }
};