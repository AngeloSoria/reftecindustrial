<?php

namespace App\Models\Contents;

use Illuminate\Database\Eloquent\Model;

class General extends Model
{
    protected $table = "contents_general";
    protected $fillable = ["section", "title", "content", "image_path", "extra_data", "order"];
}
