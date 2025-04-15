<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ActivityLog extends Model
{
    use HasFactory;

    // Table name for the activity logs
    protected $table = 'activity_logs';

    // Allow mass assignment for these fields
    protected $fillable = [
        'user_id', // Foreign key to users table
        'ofmis_id',
        'performedBy',
        'role',
        'action',
        'created_at',
        'updated_at',
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAllLogs()
    {
        return $this->all();
    }

  
    public function getLogsByUser($ofmis_id)
    {
        return $this->where('performedBy', $ofmis_id)->get();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('Y-m-d H:i:s'); // Adjust the format as necessary
    }


    public function createLog($data)
    {
        return $this->create($data);
    }
}
