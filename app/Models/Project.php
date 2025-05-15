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
        'projectID', 'projectTitle', 'projectLoc', 'projectYear', 'projectFPP', 'projectRC', 'projectContractor', 'sourceOfFunds', 'otherFund',
        'modeOfImplementation', 'projectContractDays', 'originalStartDate', 'targetCompletion',
        'timeExtension', 'revisedTargetDate', 'revisedCompletionDate', 'completionDate', 'projectStatus', 'ongoingStatus',
        'abc', 'contractAmount', 'engineering', 'mqc', 'contingency', 'bid', 'appropriation',
        'directOrIndirectCost', 'revisedContractCost', 'originalExpiryDate', 'revisedExpiryDate',
        'noaIssuedDate', 'noaReceivedDate', 'ntpIssuedDate', 'ntpReceivedDate',
        'projectSlippage', 'totalExpenditure', 'ea', 'ea_position', 'ea_monthlyRate', 'projectYear', 'projectRC', 'projectFPP', 'suspensionRemarks', 'contractCost', 'othersContractor', 'is_hidden'
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
        return $this->hasMany(ProjectStatus::class, 'project_id');
    }

    public function fundsUtilization()
    {
        return $this->hasOne(FundsUtilization::class, 'project_id');
    }
}
