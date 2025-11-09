<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     * Crea la tabla 'carts' para almacenar los productos agregados al carrito por los usuarios.
     */
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id(); // ID único del registro en el carrito

            // Relación con la tabla 'users', elimina el carrito si se elimina el usuario
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Relación con la tabla 'products', elimina el carrito si se elimina el producto
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->integer('quantity')->default(1); // Cantidad del producto en el carrito

            $table->timestamps(); // Campos created_at y updated_at
        });
    }

    /**
     * Revertir las migraciones.
     * Elimina la tabla 'carts' si existe.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};