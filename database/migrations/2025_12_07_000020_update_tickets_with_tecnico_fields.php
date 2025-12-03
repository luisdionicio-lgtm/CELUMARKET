<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add technician support fields to tickets.
     */
    public function up(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (!Schema::hasColumn('tickets', 'tecnico_id')) {
                $table->foreignId('tecnico_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('users')
                    ->nullOnDelete();
            }

            if (!Schema::hasColumn('tickets', 'comentarios_tecnico')) {
                $table->text('comentarios_tecnico')->nullable()->after('description');
            }

            if (!Schema::hasColumn('tickets', 'priority')) {
                $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('description');
            }

            if (!Schema::hasColumn('tickets', 'status')) {
                $table->enum('status', ['open', 'in-progress', 'resolved', 'closed'])->default('open')->after('priority');
            }
        });
    }

    /**
     * Rollback technician fields.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if (Schema::hasColumn('tickets', 'tecnico_id')) {
                $table->dropConstrainedForeignId('tecnico_id');
            }

            if (Schema::hasColumn('tickets', 'comentarios_tecnico')) {
                $table->dropColumn('comentarios_tecnico');
            }
        });
    }
};
