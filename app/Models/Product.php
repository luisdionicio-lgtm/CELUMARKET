<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio',
        'stock',
        'name',
        'brand',
        'description',
        'price',
        'image_url',
        'rating',
        'storage',
        'ram',
        'processor',
        'camera',
        'screen',
        'battery',
        'in_stock',
        'featured',
    ];

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
