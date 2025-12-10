<?php

namespace App\Models\Contents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = "contents_products";
    protected $fillable = [
        "images",
        "title",
        "description",
        "is_visible",
    ];
    protected $casts = [
        'images' => 'array'
    ];
}
