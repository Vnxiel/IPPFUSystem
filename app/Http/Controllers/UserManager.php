<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class UserManager extends Controller
{
    public function dashboard(){
        return view('main.index');  // Returns the 'dashboard.blade.php' view
    }

    public function projects(){
        return view('main.projects');
    }

    public function overview(){
        return view('main.overview');
    }

    public function userManagement(){
        return view('main.userManagement');
    }
    
    public function trash(){
        return view('main.trash');
    }

    public function activityLogs(){
        return view('main.activityLogs');
    }
    
    public function logout(){
        Session::flush();
        return redirect()->route('login');
    }

    public function index(){
        if (User::count() == 0) {
            return redirect()->route('admin.register');
        }
        return view('index');  
    }

    public function goToRegister(){
        $userExists = User::count() > 0;
        if ($userExists) {
            return redirect()->route('index');
        }
        return view('admin.register');  
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
            // \Log::error('Error : ' . $validator->errors()->all());
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
            // \Log::error('Error: '. $e->getMessage());
            return response()->json(2); // Return 2 for database errors
        }
    }

    public function login(Request $request){
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
                    if(Hash::check($request->password, $user->password)){
                        if($user->role === 'System Admin') {
                            $request->session()->put('loggedInSystemAdmin', [
                                'id' => $user->id,
                                'fullname' => $user->fullname,
                                'position' => $user->position,
                                'username' => $user->username,
                                'role' => $user->role,
                            ]);
                            $user_id = session()->get('loggedInSystemAdmin')['id'];
                            $fullname = session()->get('loggedInSystemAdmin')['fullname'];
                            $role = session()->get('loggedInSystemAdmin')['role'];
                            $activity = "Logged in into the system.";
                            (new ActivityLogs)->createAuditTrail($fullname ,$user_id, $activity , $role);
                            return 1;
                        } else if ($user->role === "Admin") {
                            $request->session()->put('loggedInAdmin', [
                                'id' => $user->id,
                                'fullname' => $user->fullname,
                                'position' => $user->position,
                                'username' => $user->username,
                                'role' => $user->role,
                            ]);
                            $user_id = session()->get('loggedInAdmin')['id'];
                            $fullname = session()->get('loggedInAdmin')['fullname'];
                            $role = session()->get('loggedInAdmin')['role'];
                            $activity = "Logged in into the system.";
                            (new ActivityLogs)->createAuditTrail($fullname ,$user_id, $activity , $role);
                            return 2;
                        } else if ($user->role === "Employee") {
                            $request->session()->put('loggedInEmployee', [
                                'id' => $user->id,
                                'fullname' => $user->fullname,
                                'position' => $user->position,
                                'username' => $user->username,
                                'role' => $user->role,
                            ]);
                            $user_id = session()->get('loggedInEmployee')['id'];
                            $fullname = session()->get('loggedInEmployee')['fullname'];
                            $role = session()->get('loggedInEmployee')['role'];
                            $activity = "Logged in into the system.";
                            (new ActivityLogs)->createAuditTrail($fullname ,$user_id, $activity , $role);
                            return 3;
                        }
                    }
                }
            }
        }
    }
}







    // public function projects(){
    //     return view('main.projects');  // Returns the 'projects.blade.php' view
    // }

    // public function overview(){
    //     return view('main.overview');  // Returns the 'overview.blade.php' view
    // }

    // public function userManagement(){
    //     return view('main.userManagement');  // Returns the 'userManagement.blade.php' view
    // }
    // public function trash(){
    //     return view('main.trash');  // Returns the 'trash.blade.php' view
    // }

    // public function activityLogs(){
    //     return view('main.activityLogs');  // Returns the 'activityLogs.blade.php' view
    // }
    // public function logout(){
    //     return view('main.logout');  // Logging out the user and terminating the session
    // }
