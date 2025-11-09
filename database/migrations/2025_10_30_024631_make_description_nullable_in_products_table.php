<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar la migración.
     * Hace que el campo 'description' en la tabla 'products' sea opcional.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });
    }

    /**
     * Revertir la migración.
     * Vuelve a hacer que 'description' sea obligatorio.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
        });
    }
};