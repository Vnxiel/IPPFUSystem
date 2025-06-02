<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Correct table name based on your migration
    protected $table = 'projects';

    // Fillable fields for mass assignment
    protected $fillable = [
        'projectID', 'title', 'location', 'year', 'fpp', 'responsibility_center', 'firm_name', 'source_of_funds',
        'mode_of_implementation', 'contract_days', 'official_starting_date', 'target_completion_date', 'actual_length',
        'timeExtension', 'revised_target_date', 'revisedCompletionDate', 'actual_completion_date', 'physical_status', 'ongoing_status',
        'abc', 'orig_contract_amount', 'engineering', 'mqc', 'contingency', 'bid', 'appropriation',
        'original_expiry_date', 'revised_expiry_date', 'noa_issued_date', 'noa_received_date', 'ntp_issued_date', 'ntp_received_date',
        'project_slippage', 'engineer_name', 'engineer_position', 'reason_for_suspension', 'contractor_name', 'contractor_address', 'is_hidden'
    ];

    // Relationships
    public function files()
    {
        return $this->hasMany(ProjectFile::class, 'project_id');
    }

    public function description()
    {
        return $this->hasMany(ProjectDescription::class, 'project_id');
    }

    public function status()
    {
        return $this->hasMany(physical_status::class, 'project_id');
    }

    public function fundsUtilization()
    {
        return $this->hasOne(FundsUtilization::class, 'project_id');
    }
}
