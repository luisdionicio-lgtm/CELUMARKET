<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     * Crea la tabla 'products' para almacenar información de los productos.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Identificador único del producto (clave primaria)
            $table->string('name'); // Nombre del producto
            $table->string('brand'); // Marca del producto
            $table->text('description'); // Descripción detallada del producto
            $table->decimal('price', 10, 2); // Precio con hasta 10 dígitos y 2 decimales
            $table->string('image_url'); // URL de la imagen del producto
            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Revertir las migraciones.
     * Elimina la tabla 'products' si existe.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};