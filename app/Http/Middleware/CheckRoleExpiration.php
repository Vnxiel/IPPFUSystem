<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRoleExpiration
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->time_frame === 'Temporary' && $user->time_limit && now()->gt($user->time_limit)) {
                session()->flash('logout_soon', true);

                 // ✅ Revert the role
                 $user->role = $user->temp_role ?? 'Staff';
                 $user->temp_role = null;
                 $user->time_limit = null;
                 $user->time_frame = 'Permanent';
                 $user->save();
 
                 // ✅ Log the role expiration if needed (optional)
             (new \App\Http\Controllers\ActivityLogs)->userAction(
                     $user->id,
                      $user->ofmis_id,
                  $user->username,
                      $user->role,
                  'Temporary role expired and reverted'
                  );
            }
    
              
        }

        return $next($request);
    }
}
