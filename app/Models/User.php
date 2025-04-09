<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    
    use Notifiable;
    protected $table = 'users_tbl'; 
    protected $fillable = [
        'ofmis_id', 'fullname', 'position', 'username', 'password', 'role', 'time_frame', 'timeLimit', 'temp_role',  'created_at',
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
}
