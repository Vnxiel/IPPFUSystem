<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectTimeExtension extends Model
{
    use HasFactory;

    protected $table = 'project_time_extension';

    protected $fillable = [
        'project_id',
        'time_extension_no',
        'time_extension',
        'time_extension_reason',
        'revised_expiry',
        'revised_expiry_reason',
        'total_extension_granted',
        'total_revised_contract_time',
        'new_target_completion_date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
