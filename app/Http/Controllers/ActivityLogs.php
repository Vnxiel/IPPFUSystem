<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog; 
use Illuminate\Http\Request;

class ActivityLogs extends Controller
{
    public function store(Request $request)
    {
        // Collecting the necessary data to store in activity logs
        $activityLogData = [
            'ofmis_id' => $request->input('ofmis_id'), // Retrieve 'ofmis_id' from the request
            'performedBy' => auth()->user()->username,  // Assuming the logged-in user is the one performing the action
            'role' => auth()->user()->role,             // Get the role of the logged-in user
            'action' => "Changed role to " . auth()->user()->role, // Action description (could be dynamic based on changes)
        ];

        // Store the activity log into the database
        return activityLog::create($activityLogData);
    }


    public function userAction($user_id, $ofmis_id, $performedBy, $role, $action)
    {
        // Store activity log with the data passed into the method
        $logData = [
            'user_id' => $user_id,
            'ofmis_id' => $ofmis_id,
            'performedBy' => $performedBy,
            'role' => $role,
            'action' => $action,
        ];
        $logData['created_at'] = now();
        // Save the log entry in the ActivityLog model
        return ActivityLog::create($logData);
    }
}
