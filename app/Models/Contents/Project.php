<?php

namespace App\Models\Contents;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $table = "contents_projects";
    protected $fillable = [
        "images",
        "job_order",
        "title",
        "description",
        "status",
        "is_visible",
        "is_featured"
    ];

    protected $casts = [
        'images' => 'array'
    ];
}
