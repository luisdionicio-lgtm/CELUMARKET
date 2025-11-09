<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     * Crea las tablas necesarias para usuarios, recuperación de contraseña y sesiones.
     */
    public function up(): void
    {
        // Tabla de usuarios
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('name'); // Nombre del usuario
            $table->string('email')->unique(); // Correo electrónico único
            $table->timestamp('email_verified_at')->nullable(); // Fecha de verificación de correo
            $table->string('password'); // Contraseña encriptada
            $table->rememberToken(); // Token para recordar sesión
            $table->timestamps(); // created_at y updated_at
        });

        // Tabla para almacenar tokens de recuperación de contraseña
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Correo como clave primaria
            $table->string('token'); // Token de recuperación
            $table->timestamp('created_at')->nullable(); // Fecha de creación del token
        });

        // Tabla para almacenar sesiones de usuario
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // ID de la sesión como clave primaria
            $table->foreignId('user_id')->nullable()->index(); // ID del usuario (puede ser nulo)
            $table->string('ip_address', 45)->nullable(); // Dirección IP del usuario
            $table->text('user_agent')->nullable(); // Información del navegador/dispositivo
            $table->longText('payload'); // Datos de la sesión
            $table->integer('last_activity')->index(); // Marca de tiempo de última actividad
        });
    }

    /**
     * Revertir las migraciones.
     * Elimina las tablas creadas en el método up().
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};