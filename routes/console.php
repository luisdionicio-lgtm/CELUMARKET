<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\Payment;

// Define un comando personalizado llamado "inspire"
// Cuando se ejecuta, muestra una cita inspiradora en la consola
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Mostrar una cita inspiradora');

Artisan::command('payments:expire-qr', function () {
    $expired = Payment::where('status', 'pending')
        ->whereNotNull('expires_at')
        ->where('expires_at', '<', now())
        ->update(['status' => 'expired']);

    $this->info("Pagos expirados: {$expired}");
})->purpose('Expira pagos QR pendientes cuando pasa el tiempo de vigencia');
