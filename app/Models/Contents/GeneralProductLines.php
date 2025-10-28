<?php

namespace App\Models\Contents;

use Illuminate\Database\Eloquent\Model;

class GeneralProductLines extends Model
{
    protected $table = "contents_general_product_lines";
    protected $fillable = ['name', 'image_path', 'visibility'];
}
