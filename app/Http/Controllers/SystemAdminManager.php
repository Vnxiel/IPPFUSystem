<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\ActivityLogs;

class SystemAdminManager extends Controller
{
    public function registerUser(Request $request){
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|min:3',
            'position' => 'required',
            'username' => 'required|unique:users_tbl,username',
            'role'=> 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(0); // Return 0 for validation errors
            // Log::error('Error : ' . $validator->errors()->all());
        }

        try {
            $user = new User();
            $user->fullname = $request->fullname;
            $user->position = $request->position;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            $user->save();

            return response()->json(1); // Return 1 for success
        } catch (\Exception $e) {
            // Log::error('Error: '. $e->getMessage());
            return response()->json(2); // Return 2 for database errors
        }
    }
    public function viewActivityLogs(Request $request){

    }
    public function viewUserManagement(Request $request){

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
    // public function logoutSuperAdmin(){
    //     if(session()->has('loggedInSystemAdmin')){
    //         $clientId = session()->get('loggedInSystemAdmin')['id'];
    //         $fullname = session()->get('loggedInSystemAdmin')['fullname'];
    //         $role = session()->get('loggedInSystemAdmin')['role'];
    //         $activity = "Logged out into the system.";
    //         (new ActivityLogs)->userAction($fullname ,$clientId, $activity , $role);
    //         session()->pull('loggedInSystemAdmin');
    //         return redirect('/');
    //     }
    // }
}
