<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Controllers\ActivityLog;

class User extends Authenticatable
{
    
    use Notifiable;
    protected $table = 'users'; 
    protected $fillable = [
        'ofmis_id', 'fullname', 'position', 'email', 'username', 'password', 'role', 'reason', 'time_frame', 'time_limit', 'temp_role',  'created_at',
    ];
    
    protected $dates = ['created_at']; // if you want to handle date fields correctly

    // Set default role on user creation
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($user) {
            if (User::count() === 0) {
                $user->role = 'System Admin'; // First user is System Admin
            } else {
                $user->role = 'Staff'; // Other users will be Staff by default
            }
        });
    }

   // app/Models/User.php
public function expireTemporaryRole(): bool
{
    if ($this->time_frame === 'Temporary' && $this->time_limit && now()->gt($this->time_limit)) {
        $this->role = $this->temp_role ?? 'Staff';
        $this->temp_role = null;
        $this->time_frame = 'Permanent';
        $this->time_limit = null;
        $this->save();

        (new \App\Controllers\ActivityLogs)->userAction(
            $this->id,
            $this->ofmis_id,
            $this->username,
            $this->role,
            'Temporary role expired and reverted'
        );

        return true;
    }

    return false;
}

}
