<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     * Crea las tablas necesarias para el manejo de trabajos en cola, lotes de trabajos y trabajos fallidos.
     */
    public function up(): void
    {
        // Tabla para almacenar trabajos en cola
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); // ID único del trabajo
            $table->string('queue')->index(); // Nombre de la cola (indexado para búsquedas rápidas)
            $table->longText('payload'); // Datos del trabajo (contenido serializado)
            $table->unsignedTinyInteger('attempts'); // Número de intentos realizados
            $table->unsignedInteger('reserved_at')->nullable(); // Marca de tiempo cuando fue reservado
            $table->unsignedInteger('available_at'); // Marca de tiempo cuando estará disponible
            $table->unsignedInteger('created_at'); // Marca de tiempo de creación
        });

        // Tabla para almacenar lotes de trabajos (Job Batching)
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary(); // ID del lote como clave primaria
            $table->string('name'); // Nombre del lote
            $table->integer('total_jobs'); // Número total de trabajos en el lote
            $table->integer('pending_jobs'); // Número de trabajos pendientes
            $table->integer('failed_jobs'); // Número de trabajos fallidos
            $table->longText('failed_job_ids'); // IDs de los trabajos fallidos
            $table->mediumText('options')->nullable(); // Opciones adicionales del lote
            $table->integer('cancelled_at')->nullable(); // Marca de tiempo si fue cancelado
            $table->integer('created_at'); // Marca de tiempo de creación
            $table->integer('finished_at')->nullable(); // Marca de tiempo de finalización
        });

        // Tabla para registrar trabajos que han fallado
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id(); // ID único del trabajo fallido
            $table->string('uuid')->unique(); // UUID único del trabajo
            $table->text('connection'); // Conexión utilizada
            $table->text('queue'); // Cola en la que estaba el trabajo
            $table->longText('payload'); // Datos del trabajo
            $table->longText('exception'); // Detalles de la excepción que causó el fallo
            $table->timestamp('failed_at')->useCurrent(); // Fecha y hora del fallo
        });
    }

    /**
     * Revertir las migraciones.
     * Elimina las tablas creadas en el método up().
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('failed_jobs');
    }
};