<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectStatus extends Model
{
    use HasFactory;

    // Ensure this matches your database table name
    protected $table = 'project_statuses';

    // Fillable fields for mass assignment
    protected $fillable = ['project_id', 'projectID', 'percentage', 'progress', 'date'];

    // Relationship: ProjectStatus belongs to Project
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
