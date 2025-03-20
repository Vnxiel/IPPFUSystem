<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class showDetails extends Model
{
    use HasFactory;

    protected $table = 'projects_tbl'; // Ensure this matches your SQL Server table name
    protected $primaryKey = 'projectID'; // Define primary key if it's different from 'id'
    public $incrementing = false; // Disable auto-increment if projectID is manually set

    protected $fillable = [
        'projectTitle', 'projectLoc', 'projectID', 'projectContractor', 'sourceOfFunds', 'otherFund',
        'modeOfImplementation', 'projectStatus', 'ongoingStatus', 'projectDescription',
        'projectContractDays', 'awardDate', 'noticeToProceed', 'officialStart', 'targetCompletion',
        'suspensionOrderNo', 'resumeOrderNo', 'timeExtension', 'revisedTargetCompletion', 'completionDate',
        'abc', 'contractAmount', 'engineering', 'mqc', 'contingency', 'bid', 'appropriation'
    ];

  
}

