<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MQC extends Model
{
    use HasFactory;
    protected $fillable = [
        'funds_utilization_id',
        'name',
        'month',
        'payment_periods',
        'amount',
        'date',
        'remarks',
    ];
    
}
