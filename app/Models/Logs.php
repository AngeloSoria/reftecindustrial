<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logs extends Model
{
    protected $fillable = ['action', 'activity', 'user', 'details'];
    protected $table = "logs";
}
