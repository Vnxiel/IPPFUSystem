<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{
    use HasFactory;
    protected $table = 'project_status'; // Ensure it matches your database table name

    protected $fillable = ['projectID', 'percentage', 'progress', 'date'];

    // Accessor to format ongoingStatus as "10 - 2025-04-14"
    public function getOngoingStatusAttribute()
    {
        return "{$this->percentage} - {$this->date}";
    }
}