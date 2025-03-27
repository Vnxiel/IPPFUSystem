<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    protected $table = 'projectfiles_tbl'; // Ensure it matches your database table name

    protected $fillable = [
        'projectID',
        'fileName',
        'fileID',
        'file',
        'actionBy',
    ];

    public function project()
    {
        return $this->belongsTo(showDetails::class, 'projectID');
    }
}
