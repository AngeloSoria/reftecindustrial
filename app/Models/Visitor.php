<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MonishRoy\VisitorTracking\Models\VisitorTable;
use Laravel\Sanctum\HasApiTokens;
class Visitor extends VisitorTable
{
    use HasFactory, HasApiTokens;
}
