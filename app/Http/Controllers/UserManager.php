<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\ActivityLogs;


class UserManager extends Controller
{
    public function index(){
        $userExists = User::count() > 0;
        if (!$userExists) {
            return redirect()->route('systemAdmin.register');
        }
    
        return view('index');  
    }
    public function goToRegister(){
        $userExists = User::count() > 0;
        if ($userExists) {
            return redirect()->route('index');
        }
        return view('systemAdmin.register');  
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|min:3',
            'position' => 'required',
            'username' => 'required|unique:users_tbl,username',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(0); // Return 0 for validation errors
        }

        try {
            $user = new User();
            $user->fullname = $request->fullname;
            $user->position = $request->position;
            $user->username = $request->username;
            $user->password = Hash::make($request->password);
            $user->role = 'System Admin';
            $user->save();

            return response()->json(1); // Return 1 for success
        } catch (\Exception $e) {

            return response()->json(2); // Return 2 for database errors
        }
    }

    public function userLogin(Request $request){
        $validator = Validator::make($request->all(), 
        [
            'username' => 'required|string|max:20',
            'password' => 'required|min:6|max:20',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->getMessageBag()
            ]);
        }else{ 
            $username = $request->input('username');
            $user = User::where('username', $username)->first();
            if(!$user){
                return 404;
            }else{
                if($user) {
                    $user->password = Hash::make($request->password);
                    if(Hash::check($request->password, $user->password)){
                        if($user->role === 'System Admin') {
                            // $request->session()->put('loggedInSystemAdmin', [
                            //     'id' => $user->id,
                            //     'performedBy' => $user->performedBy,
                            //     'role'=> $user->role,
                            //     'action' => $user->action,
                            // ]);
                            // $id = session()->get('loggedInSystemAdmin')['id'];
                            // $performedBy = session()->get('loggedInSystemAdmin')['fullname'];
                            // $role = session()->get('loggedInSystemAdmin')['role'];
                            // $action = "Logged in into the system.";
                            // (new ActivityLogs)->userAction($id, $performedBy, $role , $action);
                            return 1;
                        // } else if ($user->role === "Admin") {
                        //     $request->session()->put('loggedInAdmin', [
                        //         'id' => $user->id,
                        //         'fullname' => $user->fullname,
                        //         'position' => $user->position,
                        //         'role'=> $user->role,
                        //     ]);
                        //     $id = session()->get('loggedInAdmin')['id'];
                        //     $performedBy = session()->get('loggedInAdmin')['fullname'];
                        //     $role = session()->get('loggedInAdmin')['role'];
                        //     $action = "Logged in into the system.";
                        //     (new ActivityLogs)->createActivityLogs($id, $performedBy, $role , $action);
                        //     return 2;
                        // } else if ($user->role === "Staff") {
                        //     $request->session()->put('loggedInStaff', [
                        //         'id' => $user->id,
                        //         'fullname' => $user->fullname,
                        //         'position' => $user->position,
                        //         'role'=> $user->role,
                        //     ]);
                        //     $id = session()->get('loggedInStaff')['id'];
                        //     $performedBy = session()->get('loggedInStaff')['fullname'];
                        //     $role = session()->get('loggedInStaff')['role'];
                        //     $action = "Logged in into the system.";
                        //     (new ActivityLogs)->createActivityLogs($id, $performedBy, $role , $action);
                        //     return 3;
                        }
                    }else{
                        return 401;
                    }
                }else{
                    return 404;
                }
            }
        }
    }


    public function validateUser(Request $request){

    }

    public function pointToSystemAccount(Request $request){

    }

    public function getUserAction(Request $request){

    }


    public function projects(){
        return view('main.projects');  // Returns the 'projects.blade.php' view
    }

    public function overview(){
        return view('main.overview');  // Returns the 'overview.blade.php' view
    }

    public function userManagement(){
        return view('main.userManagement');  // Returns the 'userManagement.blade.php' view
    }
    public function trash(){
        return view('main.trash');  // Returns the 'trash.blade.php' view
    }

    public function activityLogs(){
        return view('main.activityLogs');  // Returns the 'activityLogs.blade.php' view
    }
    public function logout(){
        return view('main.logout');  // Logging out the user and terminating the session
    }
}





<<<<<<< Updated upstream


    // public function projects(){
    //     return view('main.projects');  // Returns the 'projects.blade.php' view
    // }
=======
>>>>>>> Stashed changes

