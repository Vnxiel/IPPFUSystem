<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundsBreakdowns extends Model
{
    use HasFactory;

    protected $fillable = [
        'funds_utilization_id',
        'type',
        'name',
        'month',
        'date_from',
        'date_to',
        'amount',
    ];
}
