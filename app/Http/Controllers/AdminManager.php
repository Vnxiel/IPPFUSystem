<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contractor;
use App\Models\Location;
use App\Models\User;
use App\Models\ActivityLog;

class AdminManager extends Controller
{

    public function index(){
        $locations = Project::select('projectLoc')
        ->distinct()
        ->whereNotNull('projectLoc')
        ->orderBy('projectLoc')
        ->get();
        $sourceOfFunds = Project::select('sourceOfFunds')
        ->distinct()
        ->whereNotNull('sourceOfFunds')
        ->orderBy('sourceOfFunds')
        ->get();
        $contractors = Contractor::orderBy('name', 'asc')->get();
        return view('admin.index', compact('locations', 'contractors', 'sourceOfFunds'));
    }

    public function projects() {
        
        return view('admin.projects');  // Returns the 'trash.blade.php' view
    }

    public function activityLogs() {
        return view('admin.activityLogs');  // Returns the 'activityLogs.blade.php' view
    }

    public function viewActivityLogs(Request $request){
        $activityLogs = activityLog::all();

        return view('admin.activityLogs', [
            'activityLogs' => $activityLogs,
        ]);
    }

    public function overview() {
        return view('admin.overview');  // Returns the 'trash.blade.php' view
    }

    public function trash() {
        return view('admin.trash');  // Returns the 'trash.blade.php' view
    }

    public function userManagement(){
        return view('admin.userManagement'); 
    }

    public function viewUserManagement(Request $request)
    {
        $users = User::all(); 
        return view('admin.userManagement', [
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
