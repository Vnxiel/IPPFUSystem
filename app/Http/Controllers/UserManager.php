<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\ActLogs;
use App\Http\Controllers\ActivityLogs;

class UserManager extends Controller
{
    /* If there is no user currently registered, the first user will redirected to the Registration 
    Page exclusive for first user, else, it will stay in the login page. */
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

    public function registerSystemAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ofmis_id' => 'required', 
            'fullname' => 'required|min:3',
            'position' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(0); 
        } 
    
            // Check if this is the first user
            $isFirstUser = User::count() === 0;

        $user = User::create([
            'ofmis_id' => $request->ofmis_id,
            'fullname' => $request->fullname,
            'position' => $request->position,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $isFirstUser ? 'System Admin' : 'Staff', 
            'time_frame' => 'Permanent',
        ]);

        return response()->json([
            'status' => 1,
            'message' => $isFirstUser ? 'System Admin' : 'Staff',
        ]);
    }

    public function changeRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ofmis_id' => 'required|exists:users,ofmis_id',
            'userRole' => 'required|string',
            'time_frame' => 'required|string',
            'timeLimit' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(0); 
        }

        $user = User::find($request->id);
        $user->role = $request->userRole;
        $user->time_frame = $request->time_frame;
        if ($request->has('timeLimit')) {
            $user->timeLimit = $request->timeLimit;
        }
        $user->save();

        $activityLogData = [
            'performedBy' => auth()->user()->id,
            'role' => $user->role,
            'action' => "Changed role to {$user->role}",
        ];
        (new ActivityLogs())->store(new Request($activityLogData));

        return response()->json(1); 
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
        } else { 
            $username = $request->input('username');
            $user = User::where('username', $username)->first();
            if (!$user) {
            return 404;
            } else {
            if ($user) {
                if (Hash::check($request->password, $user->password)) {
                    if ($user->role === 'System Admin' || $user->role === 'Admin' || $user->role === 'Staff') {
                        $request->session()->put('loggedIn', [
                            'ofmis_id' => $user->ofmis_id,
                            'performedBy' => $user->username,
                            'role' => $user->role,
                            'action' => "Logged in into the system.",
                        ]);
                        
                        if (session()->has('loggedIn')) {
                            $ofmis_id = session()->get('loggedIn')['ofmis_id'];
                            $performedBy = session()->get('loggedIn')['performedBy'];
                            $role = session()->get('loggedIn')['role'];
                            $action = session()->get('loggedIn')['action'];
                            (new ActivityLogs)->userAction($ofmis_id, $performedBy, $role, $action);
                        } else {
                        return response()->json(['error' => 'Session not found'], 401);
                        }

                        return 1;
                    }
                } else {
                return 401;
                }
            } else {
                return 404;
            }
            }
        }
    }

    public function validateUser(Request $request) {}

    public function pointToSystemAccount(Request $request) {}

    public function getUserAction(Request $request) {}

    public function projects() {
        return view('main.projects');  // Returns the 'projects.blade.php' view
    }

    public function overview() {
        return view('main.overview');  // Returns the 'overview.blade.php' view
    }

    public function trash() {
        return view('main.trash');  // Returns the 'trash.blade.php' view
    }

    public function activityLogs() {
        return view('main.activityLogs');  // Returns the 'activityLogs.blade.php' view
    }

    //When logging out it will check if the session variable exists then
    // it will retrieve the user's information, log the the activity before clearing the session data. 
    public function logout(Request $request) {
        $user = auth()->user(); 

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Log the logout action
        (new ActivityLogs)->userAction(
            $user->ofmis_id, 
            $user->username, 
            $user->role, 
            "Logged out from the system."
        );

        // Perform logout
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('/');
    }
}
