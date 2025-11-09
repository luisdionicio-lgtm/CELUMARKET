<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Define un comando personalizado llamado "inspire"
// Cuando se ejecuta, muestra una cita inspiradora en la consola
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Mostrar una cita inspiradora');