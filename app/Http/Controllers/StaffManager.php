<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contractor;
use App\Models\User;
use App\Models\ActivityLog;

class StaffManager extends Controller
{

    public function index() {
        return view('staff.index');  // Returns the 'trash.blade.php' view
    }

    public function projects()
    {
        $contractors = Contractor::orderBy('name')->get();
    
        // default to system admin
        return view('staff.projects', compact('contractors'));
    }

    public function activityLogs() {
        return view('staff.activityLogs');  // Returns the 'activityLogs.blade.php' view
    }

    public function viewActivityLogs(Request $request){
        $activityLogs = activityLog::all();

        return view('staff.activityLogs', [
            'activityLogs' => $activityLogs,
        ]);
    }

    public function overview() {
        return view('staff.overview');  // Returns the 'trash.blade.php' view
    }

    public function trash() {
        return view('staff.trash');  // Returns the 'trash.blade.php' view
    }

    public function userManagement(){
        return view('staff.userManagement'); 
    }

    public function viewUserManagement(Request $request)
    {
        $users = User::all(); 
        return view('staff.userManagement', [
            'users'=> $users
        ]);
    }


    public function addProjects(Request $request){

    }
    public function viewProjects(Request $request){

    }
    public function searchProjects(Request $request){

    }
    public function generateReports(Request $request){

    }

    public function temporaryDeleteProject(Request $request){

    }

    public function restoreProject(Request $request){

    }

    public function viewProjectStatus(Request $request){

    }
}
