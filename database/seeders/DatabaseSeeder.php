<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Product;

class DatabaseSeeder extends Seeder
{
    /**
     * Poblar la base de datos de la aplicación.
     */
    public function run(): void
    {
        // Verifica si el usuario ya existe antes de crearlo
        if (!User::where('email', 'test@example.com')->exists()) {
            User::create([
                'name' => 'Test User',
                'email' => 'test@example.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'), // puedes cambiar la contraseña si lo deseas
                'remember_token' => Str::random(10),
            ]);
        }

        // Ejecuta el seeder de productos
        $this->call(ProductSeeder::class);
    }
}