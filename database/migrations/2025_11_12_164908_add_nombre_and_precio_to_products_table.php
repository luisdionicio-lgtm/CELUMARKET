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
        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'nombre')) {
                $table->string('nombre')->nullable()->after('name');
            }

            if (! Schema::hasColumn('products', 'precio')) {
                $table->decimal('precio', 10, 2)->nullable()->after('price');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'nombre')) {
                $table->dropColumn('nombre');
            }

            if (Schema::hasColumn('products', 'precio')) {
                $table->dropColumn('precio');
            }
        });
    }
};