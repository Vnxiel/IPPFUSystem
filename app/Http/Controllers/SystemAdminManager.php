<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordChanged;
use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Contractor;
use App\Models\Project;

class SystemAdminManager extends Controller
{
    public function index(){
    
        $contractors = Contractor::orderBy('name', 'asc')->get();
        $staticLocations = [ 
            'Alfonso Castañeda', 'Aritao', 'Bagabag', 'Bambang', 'Bayombong', 'Diadi',
            'Dupax del Norte', 'Dupax del Sur', 'Kasibu', 'Kayapa', 'Quezon', 'Solano',
            'Villaverde', 'Ambaguio', 'Santa Fe'
        ];
        
        $dbLocationsRaw = Project::select('projectLoc')
            ->whereNotNull('projectLoc')
            ->pluck('projectLoc')
            ->toArray();
        
        // Extract only the municipality (first part before the comma)
        $dbLocations = array_map(function ($loc) {
            return trim(explode(',', $loc)[0]);
        }, $dbLocationsRaw);
        
        // Extract only the municipality (first part before the comma)
        $dbLocations = array_map(function ($loc) {
            return trim(explode(',', $loc)[0]);
        }, $dbLocationsRaw);

        // Merge, de-duplicate, and sort
        $locations = collect(array_merge($staticLocations, $dbLocations))
            ->unique()
            ->sort()
            ->values();


        $sourceOfFunds = Project::select('sourceOfFunds')
        ->distinct()
        ->whereNotNull('sourceOfFunds')
        ->orderBy('sourceOfFunds')
        ->get();

        $projectYear = Project::select('projectYear')
        ->distinct()
        ->whereNotNull('projectYear')
        ->orderBy('projectYear')
        ->get();
        $projectEA = Project::select('ea')
        ->distinct()
        ->whereNotNull('ea')
        ->orderBy('ea')
        ->get();

         return view('systemAdmin.index', compact('contractors', 'locations', 'sourceOfFunds', 'projectEA', 'projectYear'));
}

    public function userManagement(){
        return view('systemAdmin.userManagement'); 
    }

    public function registerUser(Request $request){
        $validator = Validator::make($request->all(), [ 
            'ofmis_id' => 'required|unique:users,ofmis_id',
            'fullname' => 'required|min:3',
            'email' => 'required',
            'position' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 0,
                'errors' => $validator->errors()->all()
            ]); 
        }

        try {
            $user = new User(); 
            $user->ofmis_id = $request->ofmis_id; // Assign ofmis_id
            $user->role = $request->role; 
            $user->fullname = $request->fullname; 
            $user->position = $request->position;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->time_frame = 'Permanent';
            $user->save();

            return response()->json([
                'status' => 1,
                'message' => $user->role, 
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 2,
                'message' => 'Server error occurred'
            ]); 
        }
    }

    public function viewActivityLogs(Request $request){
        
        $activityLogs = ActivityLog::orderBy('id', 'desc')->get();
        return view('systemAdmin.activityLogs', [
            'activityLogs' => $activityLogs,
        ]);
        
    }

    public function viewUserManagement(Request $request)
    {
        $users = User::all(); 
        return view('systemAdmin.userManagement', [
            'users'=> $users
        ]);
    }

    
    
    public function changeRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'userRole' => 'required|string',
            'time_frame' => 'string',
            'time_limit' => 'nullable|date',
        ]);
    
        if ($validator->fails()) {
            return response()->json(0); 
        }
    
        $user = User::find($request->id);
    
        if (!$user) {
            return response()->json(2); 
        }
    
        $user->role = $request->userRole;
    
        // Handle time frame
        if ($request->userRole == 'System Admin' || 'Staff' || 'Admin' && $request->time_frame) {
            $user->time_frame = $request->time_frame;
            $user->time_limit = $request->time_frame === 'Temporary' ? $request->time_limit : null;
        } else {
            $user->time_limit = null;
        }
    
        $user->save();
    
    
        return response()->json(1); // Success
    }   

    
    public function requestPasswordChange(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'reason' => 'required|string',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found.']);
        }

        $user->request_pass = 1;
        $user->reason = $request->reason;
        $user->save();


        // You could also log or store the reason somewhere if needed.
        return response()->json(['success' => true]);
    }

    public function getPasswordRequests()
    {
        $requests = User::where('request_pass', 1)
            ->select('username', 'email', 'reason')
            ->get();

        return response()->json($requests);
    }

    public function changeUserPassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'new_password' => 'required|min:6|same:confirm_password'
        ]);

        $user = User::find($request->user_id);
        $user->password = Hash::make($request->new_password);
        $user->request_pass = 0;
        $user->reason = null;
        $user->save();

        \Log::info('Starting password change for user: ' . $request->user_id);

            try {
                Mail::to($user->email)->send(new PasswordChanged($user, $request->new_password));
                \Log::info('Email sent to: ' . $user->email);
            } catch (\Exception $e) {
                \Log::error('Email failed: ' . $e->getMessage());
            }

        return response()->json(['success' => true]);
    }

    public function addProjects(Request $request){

    }
    public function viewProjects(Request $request){

    }
    public function searchProjects(Request $request){

    }

    public function generateReports(Request $request){

    }

    public function restoreProject(Request $request){

    }

    public function temporaryDeleteProject(Request $request){

    }

    public function ViewProjectStatus(Request $request){

    }
}
