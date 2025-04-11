<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectDescription extends Model
{
    use HasFactory;

    // Define the exact table name in the database
    protected $table = 'project_description_tbl';

    // Allow mass assignment for these fields
    protected $fillable = ['projectID', 'ProjectDescription'];

    /**
     * Relationship to the project.
     * This assumes 'projectID' is the foreign key and also the primary key on 'projects_tbl'
     */
   
}
