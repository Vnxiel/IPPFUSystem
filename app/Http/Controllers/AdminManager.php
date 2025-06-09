<?php

// Define the namespace for this controller
namespace App\Http\Controllers;

// Import necessary classes for use within this controller
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\User;
use App\Models\Project;
use App\Models\ActivityLog;

// Define the AdminManager controller
class AdminManager extends Controller
{

    // Method for loading the admin dashboard page
    public function index(){
        
        // Fetch all contractors ordered by name (ascending)
        $contractors = Project::orderBy('firm_name', 'asc')->get();

        // Static list of municipalities in Nueva Vizcaya
        $staticLocations = [
            'Alfonso Castañeda', 'Aritao', 'Bagabag', 'Bambang', 'Bayombong', 'Diadi',
            'Dupax del Norte', 'Dupax del Sur', 'Kasibu', 'Kayapa', 'Quezon', 'Solano',
            'Villaverde', 'Ambaguio', 'Santa Fe'
        ];

        // Get unique project locations from the database (raw)
        $dbLocationsRaw = Project::select('location')
            ->whereNotNull('location')
            ->pluck('location')
            ->toArray();    

        // Extract only the first part (municipality) from each location string
        $dbLocations = array_map(function ($loc) {
            return trim(explode(',', $loc)[0]);
        }, $dbLocationsRaw);

        // Combine static and DB-based locations, remove duplicates, sort alphabetically
        $locations = collect(array_merge($staticLocations, $dbLocations))
            ->unique()
            ->sort()
            ->values();

        // Get distinct list of all source of funds
        $source_of_funds = Project::select('source_of_funds')
            ->distinct()
            ->whereNotNull('source_of_funds')
            ->orderBy('source_of_funds')
            ->get();

        // Get distinct list of project years
        $year = Project::select('year')
            ->distinct()
            ->whereNotNull('year')
            ->orderBy('year')
            ->get();

        // Get distinct list of implementing/executing agencies
        $engineer_name = Project::select('engineer_name')
            ->distinct()
            ->whereNotNull('engineer_name')
            ->orderBy('engineer_name')
            ->get();

        // Return the admin.index view with required data
        return view('admin.index', compact('contractors', 'locations', 'source_of_funds', 'engineer_name', 'year'));
    }

    // Method to return the admin.projects view with mapped project details
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
            'id' => $project->id,
            'title' => $project->title ?? 'N/A',
            'location' => $project->location ?? 'N/A',
            'status' => $project->physical_status ?? 'N/A',
            'amount' => $formattedAmount,
            'year' => $project->year ?? 'N/A',
            'contractor' => (strtolower($project->firm_name) === 'others')
                ? ($project->othersContractor ?? 'N/A')
                : ($project->firm_name ?? 'N/A'),
            'duration' => $project->contract_days ? $project->contract_days . ' days' : 'N/A',
         
        ];
    });
        // Return the view with prepared data
        return view('admin.projects', compact('mappedProjects', 'contractors', 'locations', 'source_of_funds', 'engineer_name'));
    }

    // Loads the activity logs page (view only)
    public function activityLogs() {
        return view('admin.activityLogs');  // Returns the 'activityLogs.blade.php' view
    }

    // Fetches and displays activity logs from database
    public function viewActivityLogs(Request $request){
        $activityLogs = activityLog::all(); // Fetch all activity logs
        return view('admin.activityLogs', [
            'activityLogs' => $activityLogs,
        ]);
    }

    // Loads the admin overview page
    public function overview() {
        return view('admin.overview');  // Returns the 'overview.blade.php' view
    }

    // Loads the admin trash page
    public function trash() {
        return view('admin.trash');  // Returns the 'trash.blade.php' view
    }

    // Loads the user management page and passes the user data
    public function viewUserManagement(Request $request)
    {
        $users = User::all();  // Get all users
        return view('admin.userManagement', [
            'users'=> $users
        ]);
    }

}
