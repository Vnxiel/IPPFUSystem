<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Location;
use App\Models\User;
use App\Models\Project;
use App\Models\ActivityLog;

class StaffManager extends Controller
{

    public function index(){
    
        $contractors = Project::orderBy('firm_name', 'asc')->get();
        $staticLocations = [
            'Alfonso Castañeda', 'Aritao', 'Bagabag', 'Bambang', 'Bayombong', 'Diadi',
            'Dupax del Norte', 'Dupax del Sur', 'Kasibu', 'Kayapa', 'Quezon', 'Solano',
            'Villaverde', 'Ambaguio', 'Santa Fe'
        ];
    
        $dbLocations = Project::select('location')
            ->whereNotNull('location')
            ->pluck('location')
            ->toArray();
    
        // Merge and remove duplicates
        $locations = collect(array_merge($staticLocations, $dbLocations))
            ->unique()
            ->sort()
            ->values();

        $source_of_funds = Project::select('source_of_funds')
        ->distinct()
        ->whereNotNull('source_of_funds')
        ->orderBy('source_of_funds')
        ->get();

        $year = Project::select('year')
        ->distinct()
        ->whereNotNull('year')
        ->orderBy('year')
        ->get();
        $projectEA = Project::select('engineer_name')
        ->distinct()
        ->whereNotNull('engineer_name')
        ->orderBy('engineer_name')
        ->get();

         return view('staff.index', compact('contractors', 'locations', 'source_of_funds', 'projectEA', 'year'));
}


public function projects()
{
       // Fetch all visible projects with select fields and related funds utilization
       $projects = Project::select('id', 'title', 'location', 'physical_status', 'firm_name', 'year', 'contract_days')
       ->with('fundsUtilization')
       ->where(function ($query) {
           $query->whereNull('is_hidden')->orWhere('is_hidden', 0);
       })
       ->orderBy('created_at', 'desc')
       ->get();

 
       $contractors = Project::orderBy('firm_name', 'asc')->get();
       
       $staticLocations = [ 
           'Alfonso Castañeda', 'Aritao', 'Bagabag', 'Bambang', 'Bayombong', 'Diadi',
           'Dupax del Norte', 'Dupax del Sur', 'Kasibu', 'Kayapa', 'Quezon', 'Solano',
           'Villaverde', 'Ambaguio', 'Santa Fe'
       ];
       
       $dbLocationsRaw = Project::select('location')
           ->whereNotNull('location')
           ->pluck('location')
           ->toArray();
       
       // Extract only the municipality (first part before the comma)
       $dbLocations = array_map(function ($loc) {
           return trim(explode(',', $loc)[0]);
       }, $dbLocationsRaw);
       
       // Merge and remove duplicates
       $locations = collect(array_merge($staticLocations, $dbLocations))
           ->unique()
           ->sort()
           ->values();
       
       $source_of_funds = Project::select('source_of_funds')
       ->distinct()
       ->whereNotNull('source_of_funds')
       ->orderBy('source_of_funds')
       ->get();

       $engineer_name = Project::select('engineer_name')
       ->distinct()
       ->whereNotNull('engineer_name')
       ->orderBy('engineer_name')
       ->get();


   $mappedProjects = $projects->map(function ($project) {
       $amount = optional($project->fundsUtilization)->orig_contract_amount;
       $formattedAmount = is_numeric($amount) ? number_format((float) $amount, 2) : '0.00';

       return [
           'title' => $project->title ?? 'N/A',
           'location' => $project->location ?? 'N/A',
           'status' => $project->physical_status ?? 'N/A',
           'amount' => $formattedAmount,
           'year' => $project->year ?? 'N/A',
           'contractor' => (strtolower($project->firm_name) === 'others')
               ? ($project->othersContractor ?? 'N/A')
               : ($project->firm_name ?? 'N/A'),
           'duration' => $project->contract_days ? $project->contract_days . ' days' : 'N/A',
           'id' => $project->id,
       ];
   });
    
    return view('staff.projects', compact('mappedProjects', 'contractors', 'locations', 'source_of_funds', 'engineer_name'));
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
}
