<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ActLogs extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';
    protected $fillable = [
        'ofmis_id',
        'performedBy',
        'role',
        'action',
        'created_at',
        'updated_at',
        'username', // Added username field

    ];

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
        return Carbon::parse($value)->format('Y-m-d H:i:s');  // Change this to any format you need
    }

    public function createLog($data)
    {
        return $this->create($data);
    }
}
