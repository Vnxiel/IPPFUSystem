<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportSignatory extends Model
{
    protected $fillable = ['project_id', 'reviewed_by', 'noted_by', 'reviewed_by_position', 'noted_by_position'];
}
