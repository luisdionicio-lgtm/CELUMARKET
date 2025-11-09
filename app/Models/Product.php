<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
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
}