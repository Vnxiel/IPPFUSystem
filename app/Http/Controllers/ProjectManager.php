<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\addProject;
use App\Models\showDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\ActLogs;
use App\Models\Contractor;
use App\Http\Controllers\ActivityLogs;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Municipalities;

class ProjectManager extends Controller
{
    public function addProject(Request $request)
    {
        // Validate the form data
        $validator = \Validator::make($request->all(), [
            'projectTitle' => 'required|string|max:255',
            'projectLoc' => 'required|string|max:255',
            'projectID' => 'required|string|max:50|unique:projects_tbl,projectID',
            'projectContractor' => 'nullable|string|max:255',
            'sourceOfFunds' => 'nullable|string|max:255',
            'otherFund' => 'nullable|string|max:255',
            'modeOfImplementation' => 'nullable|string|max:255',
            'projectStatus' => 'required|string|max:50',
            'ongoingStatus' => 'nullable|string|max:50',
            'ongoingDate' => 'nullable|date',
            'projectDescription' => 'nullable|string',
            'projectContractDays' => 'nullable|integer',
            'awardDate' => 'nullable|date',
            'noticeOfAward' => 'nullable|date',
            'noticeToProceed' => 'nullable|date',
            'officialStart' => 'nullable|date',
            'targetCompletion' => 'nullable|date',
            'suspensionOrderNo' => 'nullable|date',
            'resumeOrderNo' => 'nullable|date',
            'timeExtension' => 'nullable|string|max:50',
            'revisedTargetCompletion' => 'nullable|string|max:50',
            'CompletionDate' => 'nullable|string|max:50',
            'abc' => 'nullable|string',
            'contractAmount' => 'nullable|string',
            'engineering' => 'nullable|string',
            'mqc' => 'nullable|string',
            'contingency' => 'nullable|string',
            'bid' => 'nullable|string',
            'appropriate' => 'nullable|string',
        ]);
    
        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed!',
                'errors' => $validator->errors()
            ], 422);
        }

         //  Get username from session
         if (session()->has('loggedIn')) {
            $sessionData = session()->get('loggedIn');
            $username = $sessionData['performedBy'];  // Assuming this is the username
        } else {
            Log::error("Session not found");
            return response()->json(['status' => 'error', 'message' => 'Session not found'], 401);
        }

         // Fetch session data properly
            $ofmis_id = $sessionData['ofmis_id'] ?? null;
            $role = $sessionData['role'] ?? 'Unknown';
            $username = $sessionData['username'] ?? 'Unknown';
            $projectTitle = $request->input('projectTitle');

    
        try {
            // Insert into the database
            $project = addProject::create($request->all());
            
            if ($project) {
                // Logging user action
                $action = "Added new project: $projectTitle.";
    
                // Store in session
                $request->session()->put('AddedNewProject', [
                    'ofmis_id' => $ofmis_id,
                    'performedBy' => $username,
                    'role' => $role,
                    'action' => $action,
                ]);
    
                Log::info("User action logged: " . json_encode($request->session()->get('AddedNewProject')));
    
                // Store in activity logs
                (new ActivityLogs)->userAction($ofmis_id, $username, $role, $action);
    
                return response()->json(['status' => 'success', 'message' => 'Project added successfully!']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Failed to add project.']);
            }
        } catch (\Exception $e) {
            Log::error('Error adding project: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error adding project. ' . $e->getMessage()]);
        }
    }

    public function showDetails()
    {
        try {
            // Siguraduhin na ang `is_hidden` ay `0` o `NULL`, kaya gumamit ng `whereNull` at `orWhere`
            $projects = showDetails::where(function ($query) {
                    $query->whereNull('is_hidden')  // Kapag walang value ang is_hidden
                          ->orWhere('is_hidden', 0); // O kaya kapag `0` ang value
                })
                ->orderBy('created_at', 'desc')
                ->get();
    
            return response()->json([
                'status' => 'success',
                'projects' => $projects
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching projects: ' . $e->getMessage());
    
            return response()->json([
                'status' => 'error',
                'message' => 'Error fetching projects. Please try again.'
            ], 500);
        }
    }

    public function fetchTrashedProjects()
    {
        try {
            // Kunin lang ang mga projects na may `is_hidden = 1`
            $projects = showDetails::where('is_hidden', 1)
                ->orderBy('created_at', 'desc')
                ->get();
    
            return response()->json(['status' => 'success', 'projects' => $projects]);
        } catch (\Exception $e) {
            \Log::error('Error fetching trashed projects: ' . $e->getMessage());
    
            return response()->json([
                'status' => 'error',
                'message' => 'Error fetching trashed projects. Please try again.'
            ], 500);
        }
    }
    
    public function restoreProject($projectID)
    {
        try {
            // Find the project by ID
            $project = showDetails::where('projectID', $projectID)->first();

            if (!$project) {
                return response()->json(["status" => "error", "message" => "Project not found."], 404);
            }

            // Set is_hidden to 0 to restore the project
            $project->is_hidden = 0;
            $project->save();

            return response()->json(["status" => "success", "message" => "Project successfully restored."]);
        } catch (\Exception $e) {
            \Log::error('Error restoring project: ' . $e->getMessage());
            
            return response()->json([
                "status" => "error",
                "message" => "Error restoring project. Please try again."
            ], 500);
        }
    }

    // Fetch the list of contractors for the filter dropdown
    public function getContractors()
    {
        $contractors = Contractor::all();  // Fetch all contractors from the database
        
        return response()->json($contractors);
    }

    // Get the projects data
    public function getProjectsData(Request $request)
    {
        try {
            // Start the query for fetching projects
            $query = showDetails::query();

            // Apply filters if they exist
            if ($request->has('status') && $request->status != '') {
                $query->where('status', $request->status);
            }

            if ($request->has('contractor') && $request->contractor != '') {
                $query->where('contractor', $request->contractor);
            }

            // Return the data as a DataTables response
            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    return '<a href="/projects/'.$row->id.'" class="btn btn-sm btn-primary">View</a>';
                })
                ->make(true);  // Ensure DataTables JSON format
        } catch (\Exception $e) {
            // Handle error gracefully
            return response()->json(['status' => 'error', 'message' => 'Internal Server Error.'], 500);
        }
    }
   

    public function getProject($projectID)
    {
        try {
            $project = showDetails::where('projectID', $projectID)->first();
    
            if (!$project) {
                return response()->json(['status' => 'error', 'message' => 'Project not found.'], 404);
            }
    
            return response()->json(['status' => 'success', 'project' => $project]);
        } catch (\Exception $e) {
            Log::error('Error fetching project details: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Project not found.']);
        }
    }
    

    public function getProjectSummary()
    {
        try {
            Log::info('Fetching project summary...');

            if (!Schema::hasTable('projects_tbl')) {
                Log::error('Error: Table "projects" does not exist.');
                return response()->json(['status' => 'error', 'message' => 'Database table not found.']);
            }

            $totalProjects = showDetails::count();
            $ongoingProjects = showDetails::where('projectStatus', 'Ongoing')->count();
            $completedProjects = showDetails::where('projectStatus', 'Completed')->count();
            $discontinuedProjects = showDetails::where('projectStatus', 'Cancelled')->count();

            $projects = showDetails::all();
            $totalBudget = $projects->sum(fn ($p) => (float) preg_replace('/[^0-9.]/', '', $p->abc ?? '0'));
            $totalUsed = $projects->sum(fn ($p) => (float) preg_replace('/[^0-9.]/', '', $p->contractAmount ?? '0'));
            $resystemAdminingBalance = max($totalBudget - $totalUsed, 0);

            $recentProjects = showDetails::orderBy('created_at', 'desc')->limit(5)->get();

            Log::info('Project summary fetched successfully.');

            return response()->json([
                'status' => 'success',
                'data' => [
                    'totalProjects' => $totalProjects,
                    'ongoingProjects' => $ongoingProjects,
                    'completedProjects' => $completedProjects,
                    'discontinuedProjects' => $discontinuedProjects,
                    'totalBudget' => number_format($totalBudget, 2),
                    'totalUsed' => number_format($totalUsed, 2),
                    'resystemAdminingBalance' => number_format($resystemAdminingBalance, 2),
                    'recentProjects' => $recentProjects
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching project summary: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Error fetching project summary.',
                'error_details' => $e->getMessage()
            ]);
        }
    }

    public function updateProject(Request $request, $projectID)
{
    try {
        Log::info("Updating project ID: $projectID", $request->all());

        // Validate input fields
        $validator = \Validator::make($request->all(), [
            'projectTitle' => 'required|string|max:255',
            'projectLoc' => 'required|string|max:255',
            'projectID' => 'required|string|max:50|',
            'projectContractor' => 'nullable|string|max:255',
            'sourceOfFunds' => 'nullable|string|max:255',
            'otherFund' => 'nullable|string|max:255',
            'modeOfImplementation' => 'nullable|string|max:255',
            'projectStatus' => 'required|string|max:50',
            'ongoingStatus' => 'nullable|string|max:50',
            'ongoingDate' => 'nullable|date',
            'projectDescription' => 'nullable|string',
            'projectContractDays' => 'nullable|integer',
            'noticeOfAward' => 'nullable|date',
            'noticeToProceed' => 'nullable|date',
            'officialStart' => 'nullable|date',
            'targetCompletion' => 'nullable|date',
            'suspensionOrderNo' => 'nullable|date',
            'resumeOrderNo' => 'nullable|date',
            'timeExtension' => 'nullable|string|max:50',
            'revisedTargetCompletion' => 'nullable|string|max:50',
            'completionDate' => 'nullable|string|max:50',
            'abc' => 'nullable|string',
            'contractAmount' => 'nullable|string',
            'engineering' => 'nullable|string',
            'mqc' => 'nullable|string',
            'contingency' => 'nullable|string',
            'bid' => 'nullable|string',
            'appropriate' => 'nullable|string',
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed!',
                'errors' => $validator->errors()
            ], 422);
        }

        // Find the project by projectID
        $project = showDetails::where('projectID', $projectID)->first();

        if (!$project) {
            return response()->json(['status' => 'error', 'message' => 'Project not found.'], 404);
        }

        // Process ongoing status
        if ($request->input('projectStatus') === 'Ongoing') {
            $ongoingStatus = $request->input('ongoingStatus');
            $ongoingDate = $request->input('ongoingDate');
            $project->ongoingStatus = !empty($ongoingStatus) && !empty($ongoingDate)
                ? "{$ongoingStatus} - {$ongoingDate}"
                : null;
        } else {
            $project->ongoingStatus = null;
        }

        // Update project details
        $project->update($request->except(['projectID']));

        return response()->json([
            'status' => 'success',
            'message' => 'Project updated successfully!',
            'project' => $project
        ]);

    } catch (\Exception $e) {
        Log::error("Error updating project ID $projectID: " . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update project.',
            'error_details' => $e->getMessage()
        ]);
    }
}

public function trashProject(Request $request, $projectID)
{
    $project = showDetails::where('projectID', $projectID)->first();

    if (!$project) {
        return response()->json(["status" => "error", "message" => "Project not found."], 404);
    }

    $project->is_hidden = 1;
    $project->save();

    return response()->json(["status" => "success", "message" => "Project successfully archived."]);
}

public function getDropdownOptions(Request $request) {
    // Fetch contractors and municipalities
    $contractors = Contractor::orderBy('fullname', 'asc')->get();
    $municipalities = Municipalities::orderBy('municipalityOf', 'asc')->get();

    // Check if the request is for the overview page
    if ($request->has('overview') && $request->overview == true) {
        return response()->json([
            'contractors' => $contractors,
            'municipalities' => $municipalities
        ]);
    }

    // Pass both to the view for the system admin projects page
    return view('systemAdmin.projects', [
        'contractors' => $contractors,
        'municipalities' => $municipalities
    ]);
}

public function viewProjects() {
    return view('systemAdmin.projects');  // Returns the 'projects.blade.php' view
}

public function overview() {
    return view('systemAdmin.overview');  // Returns the 'overview.blade.php' view
}
}
