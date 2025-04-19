<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectLocation extends Model
{
    use HasFactory;

    protected $table = 'project_locations'; 
    protected $fillable = [
        'location', 'created_at',
    ];
    
    protected $dates = ['created_at']; // if you want to handle date fields correctly
}
