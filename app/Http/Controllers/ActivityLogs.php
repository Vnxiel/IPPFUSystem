<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ActLogs; 
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
        return ActLogs::create($activityLogData);
    }

    public function index()
    {
        // Get all activity logs and return them as JSON
        $logs = ActLogs::all();
        return response()->json($logs);
    }

    public function userAction($ofmis_id, $performedBy, $role, $action)
    {
        // Store activity log with the data passed into the method
        $logData = [
            'ofmis_id' => $ofmis_id,
            'performedBy' => $performedBy,
            'role' => $role,
            'action' => $action,
        ];

        // Save the log entry in the ActivityLog model
        return ActLogs::create($logData);
    }
}
