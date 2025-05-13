<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Contractor;
use App\Models\Location;
use App\Models\User;
use App\Models\Project;
use App\Models\ActivityLog;

class AdminManager extends Controller
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

         return view('admin.index', compact('contractors', 'locations', 'sourceOfFunds', 'projectEA', 'projectYear'));
}


public function projects()
{
    $projects = Project::select('id', 'projectTitle', 'projectLoc', 'projectStatus', 'projectContractor', 'othersContractor', 'projectContractDays')
    ->with('fundsUtilization')
    ->where(function ($query) {
        $query->whereNull('is_hidden')->orWhere('is_hidden', 0);
    })
    ->orderBy('created_at', 'desc')
    ->get();
    $contractors = Contractor::orderBy('name')->get();
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


    $mappedProjects = $projects->map(function ($project) {
        $amount = optional($project->fundsUtilization)->orig_contract_amount;
        $formattedAmount = is_numeric($amount) ? number_format((float) $amount, 2) : '0.00';

        return [
            'title' => $project->projectTitle ?? 'N/A',
            'location' => $project->projectLoc ?? 'N/A',
            'status' => $project->projectStatus ?? 'N/A',
            'amount' => $formattedAmount,
            'contractor' => (strtolower($project->projectContractor) === 'others')
                ? ($project->othersContractor ?? 'N/A')
                : ($project->projectContractor ?? 'N/A'),
            'duration' => $project->projectContractDays ? $project->projectContractDays . ' days' : 'N/A',
            'id' => $project->id,
        ];
    });

    return view('admin.projects', compact('mappedProjects', 'contractors', 'locations', 'sourceOfFunds', 'projectEA', 'projectYear'));
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
