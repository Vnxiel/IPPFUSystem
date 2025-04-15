<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundsUtilization extends Model
{
    use HasFactory;

    // Define the exact table name in the database
    protected $table = 'funds_utilization';

    // Allow mass assignment for these fields
    protected $fillable = [
        'project_id',
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

    /**
     * Relationship to the Project model.
     * Each FundsUtilization record is related to a single Project.
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
