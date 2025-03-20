<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLogs extends Model
{
    use HasFactory;
    protected $table = 'activity_logs';
    protected $fillable = [
        'id',
        'performed_by',
        'role',
        'action',
        'created_at',
        'updated_at',
    ];
}
