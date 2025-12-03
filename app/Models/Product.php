<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'description',
        'price',
        'stock',
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
        'active',
    ];

    protected $casts = [
        'in_stock' => 'boolean',
        'featured' => 'boolean',
        'active' => 'boolean',
    ];

    public function getImageSrcAttribute()
    {
        $image = $this->image_url;

        // 1. Si la imagen es una URL externa válida (Amazon, blogs, Falabella, etc.)
        if (filter_var($image, FILTER_VALIDATE_URL)) {
            return $image;
        }

        // 2. Si ya comienza con "storage/" (caso raro pero soportado)
        if (str_starts_with($image, 'storage/')) {
            return asset($image);
        }

        // 3. Imagen local en storage/app/public
        return asset('storage/' . $image);
    }

    //Relaciones
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites')->withTimestamps();
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
