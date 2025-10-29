<?php

namespace App\Models\Contents;

use Illuminate\Database\Eloquent\Model;
use App\Models\Contents\Upload;

class GeneralProductLines extends Model
{
    protected $table = "contents_general_product_lines";
    protected $fillable = ['name', 'upload_id', 'visibility'];

}
