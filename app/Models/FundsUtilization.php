<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundsUtilization extends Model
{
    use HasFactory;

    protected $table = 'funds_utilization';

    protected $fillable = [
        'project_id',
        'orig_abc',
        'orig_contract_amount',
        'orig_engineering',
        'orig_mqc',
        'orig_contingency',
        'orig_bid',
        'orig_appropriation',
        'actual_abc',
        'actual_contract_amount',
        'actual_engineering',
        'actual_mqc',
        'actual_bid',
        'actual_contingency',
        'actual_appropriation',
        'summary',
        'partial_billings',
        'total_expenditure',
        'total_savings',
    ];

    protected $casts = [
        'summary' => 'array',
        'partial_billings' => 'array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function mobilizations()
{
    return $this->hasMany(Mobilization::class);
}

public function partialBillings()
{
    return $this->hasMany(PartialBilling::class);
}

public function engineerings()
{
    return $this->hasMany(Engineering::class);
}

public function mqcs()
{
    return $this->hasMany(Mqc::class);
}

public function contingencies()
{
    return $this->hasMany(Contingency::class);
}

}
