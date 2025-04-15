<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;

    protected $table = 'nv_municipalities_tbl'; 
    protected $fillable = [
        'municipalityOf', 'created_at',
    ];
    
    protected $dates = ['created_at']; // if you want to handle date fields correctly
}
