<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add soft deactivation support to products.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'active')) {
                $table->boolean('active')->default(true)->after('featured');
            }
        });

        DB::table('products')
            ->whereNull('active')
            ->update(['active' => true]);
    }

    /**
     * Remove the active flag if it was added by this migration.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'active')) {
                $table->dropColumn('active');
            }
        });
    }
};
