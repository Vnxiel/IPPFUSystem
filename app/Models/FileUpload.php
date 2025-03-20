<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\showDetails;

class FileUpload extends Model
{
    use HasFactory;

    protected $table = 'project_files'; // Ensure it matches your database table name

    protected $fillable = [
        'projectID',
        'fileName',
        'field',
        'actionBy',
    ];

    public function project()
    {
        return $this->belongsTo(showDetails::class, 'projectID');
    }
}
