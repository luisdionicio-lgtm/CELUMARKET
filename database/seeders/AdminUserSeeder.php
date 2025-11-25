<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@celumarket.com'],
            [
                'name' => 'Administrador General',
                'password' => Hash::make('admin12345678'),
                // Fuerza el flag de administrador para que aparezca el panel
                'is_admin' => true,
                'role' => 'admin',
            ]
        );

        if ($admin->wasRecentlyCreated) {
            $this->command->info('✅ Usuario administrador creado exitosamente: admin@celumarket.com');
        } else {
            $this->command->warn('ℹ️ El usuario administrador ya existía; se aseguró el rol administrador.');
        }
    }
}
