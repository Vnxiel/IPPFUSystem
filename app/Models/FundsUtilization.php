<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundsUtilization extends Model
{
    use HasFactory;

    protected $table = 'funds_utilization_tbl';

    protected $fillable = [
        'projectID',
        'orig_abc',
        'orig_contract_amount',
        'orig_engineering',
        'orig_mqc',
        'orig_bid',
        'orig_appropriation',
        'orig_completion_date',
        'actual_abc',
        'actual_contract_amount',
        'actual_engineering',
        'actual_mqc',
        'actual_bid',
        'actual_contingency',
        'actual_appropriation',
        'actual_completion_date',
    ];


}
