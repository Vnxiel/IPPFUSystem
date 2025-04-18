<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\ActLogs;

class SystemAdminManager extends Controller
{
    public function index(){
        return view('systemAdmin.index');
    }

    public function userManagement(){
        return view('systemAdmin.userManagement'); 
    }

    public function registerUser(Request $request){
        $validator = Validator::make($request->all(), [ 
            'ofmis_id' => 'required|unique:users_tbl,ofmis_id',
            'fullname' => 'required|min:3',
            'position' => 'required',
            'username' => 'required|unique:users_tbl,username',
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
        $activityLogs = ActLogs::all();

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

    public function getUserRole(Request $request)
    {
        $user = User::find($request->id); 
    
        if ($user) {
            return response()->json([
                'success' => 1,
                'user' => [
                    'role' => $user->role,
                    'time_frame' => $user->time_frame ?? '',
                    'timeLimit' => $user->timeLimit ?? ''
                ]
            ]);
        }
    
        return response()->json(['success' => 0]); 
    }
    
    public function changeRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users_tbl,id',
            'userRole' => 'required|string',
            'time_frame' => 'string',
            'timeLimit' => 'nullable|date',
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
            $user->timeLimit = $request->time_frame === 'Temporary' ? $request->timeLimit : null;
        } else {
            $user->timeLimit = null;
        }
    
        $user->save();
    
    
        return response()->json(1); // Success
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
