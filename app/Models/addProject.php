<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class addProject extends Model
{
    use HasFactory;

    protected $table = 'projects_tbl'; // Ensure this matches your SQL Server table name
    protected $primaryKey = 'projectID'; // Define primary key if it's different from 'id'
    public $incrementing = false; // Disable auto-increment if projectID is manually set

    protected $fillable = [
        'projectTitle', 'projectLoc', 'projectID', 'projectContractor', 'sourceOfFunds', 'otherFund',
        'modeOfImplementation', 'projectStatus', 'ongoingStatus', 'projectDescription',
        'projectContractDays', 'awardDate', 'noticeToProceed', 'officialStart', 'targetCompletion',
        'suspensionOrderNo1',  'suspensionOrderNo2',  'suspensionOrderNo3', 'resumeOrderNo1', 'resumeOrderNo2', 'resumeOrderNo3','timeExtension', 'revisedTargetCompletion', 'completionDate',
        'abc', 'contractAmount', 'engineering', 'mqc', 'contingency', 'bid', 'appropriation', 'directOrIndirectCost',
        'revisedContractCost', 'originalExpiryDate','revisedExpiryDate', 'noaIssuedDate', 'noaReceivedDate', 'ntpIssuedDate',
        'ntpReceivedDate', 'projectSlippage', 'totalExpenditure', 'ea', 'contractCost'
    ];

 
}
