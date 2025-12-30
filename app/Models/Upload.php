<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    protected $fillable = ['filename', 'type', 'path', 'is_protected', 'uploaded_by', 'is_private'];
    protected $casts = [
        'is_private' => 'boolean',
        'is_protected' => 'boolean',
    ];
}
