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
        'timeExtension', 'revisedTargetCompletion', 'completionDate',
        'abc', 'contractAmount', 'engineering', 'mqc', 'contingency', 'bid', 'appropriation', 'directOrIndirectCost',
        'revisedContractCost', 'originalExpiryDate','revisedExpiryDate', 'noaIssuedDate', 'noaReceivedDate', 'ntpIssuedDate',
        'ntpReceivedDate', 'projectSlippage', 'totalExpenditure', 'ea', 'contractCost',
    ];

    // Define a mutator to allow dynamic fields for suspension and resumption orders
    public function setSuspensionOrderNoAttribute($value)
    {
        // Handle dynamic fields, e.g. suspensionOrderNo1, suspensionOrderNo2, etc.
        $this->attributes['suspensionOrderNo'] = json_encode($value); // Store as JSON if needed
    }

    public function setResumeOrderNoAttribute($value)
    {
        // Handle dynamic fields, e.g. resumeOrderNo1, resumeOrderNo2, etc.
        $this->attributes['resumeOrderNo'] = json_encode($value); // Store as JSON if needed
    }

    // If you store as JSON, you can access it as an array when needed:
    public function getSuspensionOrderNoAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getResumeOrderNoAttribute($value)
    {
        return json_decode($value, true);
    }
}
