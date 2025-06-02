<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectFile extends Model
{
    use HasFactory;

    protected $table = 'project_files'; // Matches the table created in migration

    protected $fillable = [
        'project_id',    // foreign key referencing projects
        'file_name',
        'file_id',
        'action_by',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
