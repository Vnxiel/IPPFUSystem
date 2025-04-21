<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contractor;
use App\Models\Location;
use App\Models\User;
use App\Models\ActivityLog;

class AdminManager extends Controller
{

    public function index() {
        return view('admin.index');  // Returns the 'trash.blade.php' view
    }

    public function getLocConProject()
    {
        $contractors = Contractor::orderBy('name')->get();
        $locations   = Location::orderBy('location')->get();
    
        // default to system admin
        return view('admin.projects', compact('contractors', 'locations'));
    }
    
    

    public function getLocConOverview()
    {
        // 1. Load your data
        $contractors = Contractor::orderBy('name')->get();
        $locations   = Location::orderBy('location')->get();
    
        // 3. Otherwise, show the system‑admin overview
        return view('admin.overview', compact('contractors', 'locations'));
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
