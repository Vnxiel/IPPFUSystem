<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contractor extends Model
{
    use HasFactory;

    protected $table = 'contractors_tbl'; 
    protected $fillable = [
        'fullname', 'created_at',
    ];
    
    protected $dates = ['created_at']; // if you want to handle date fields correctly
}
