<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDescription extends Model
{
    use HasFactory;

    // Define the exact table name in the database
    protected $table = 'project_descriptions';

    // Allow mass assignment for these fields
    protected $fillable = ['project_id', 'projectID', 'ProjectDescription'];

    /**
     * Relationship to the project.
     * This assumes 'project_id' is the foreign key and also the primary key on 'projects_tbl'
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
