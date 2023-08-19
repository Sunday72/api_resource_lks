<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'product_name',
        'description'
    ];

    // ACCESSOR
    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn ($image) => asset('/storage/products/'.$image)
        );
    }
}
