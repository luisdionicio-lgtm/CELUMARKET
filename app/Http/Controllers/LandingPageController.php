<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Muestra la página de portada (la azul oscura).
     */
    public function index()
    {
        // Esto cargará el archivo: resources/views/landing.blade.php
        return view('landing');
    }
}