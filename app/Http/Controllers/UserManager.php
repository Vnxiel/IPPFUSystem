<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserManager extends Controller
{    public function index(){
        return view('main.index');  // Returns the 'dashboard.blade.php' view
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

    // public register(Request $request){

    // }
}
