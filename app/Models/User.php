<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_admin',
    ];

    /**
     * Atributos ocultos en la serializacion.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversores de atributos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'boolean',
    ];

    /**
     * Verifica si el usuario es administrador.
     */
    public function isAdmin(): bool
    {
        if (array_key_exists('is_admin', $this->attributes)) {
            return (bool) $this->is_admin;
        }

        return $this->role === 'admin';
    }

    /**
     * Check if the user has the technician role.
     */
    public function isTecnico(): bool
    {
        return ($this->role ?? 'user') === 'tecnico';
    }

    /**
     * Generic helper to match against one or many roles.
     *
     * @param  string|array<int, string>  $roles
     */
    public function hasRole(string|array $roles): bool
    {
        $needle = is_array($roles) ? $roles : [$roles];
        $userRole = $this->role ?? 'user';

        return $this->isAdmin() || in_array($userRole, $needle, true);
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites')->withTimestamps();
    }
}
