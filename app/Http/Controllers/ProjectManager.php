<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ActivityLogs;
use App\Models\ActLogs;
use App\Models\addProject;
use App\Models\showDetails;
use App\Models\ProjectStatus;
use Barryvdh\DomPDF\Facade\Pdf;

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
            'appropriattion' => 'nullable|string',
            'directOrIndirectCost' => 'nullable|string',
            'revisedContractCost' => 'nullable|string',
            'originalExpiryDate' => 'nullable|string',
            'revisedExpiryDate' => 'nullable|string',
            'noaIssuedDate' => 'nullable|string',
            'noaReceivedDate' => 'nullable|string',
            'ntpIssuedDate' => 'nullable|string',
            'ntpReceivedDate' => 'nullable|string',
            'projectSlippage' => 'nullable|string',
            'totalExpenditure' => 'nullable|string',
            'ea' => 'nullable|string',
            'contractCost' => 'nullable|string',
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

            $dynamicFields = collect($request->all())->filter(function ($_, $key) {
                return preg_match('/^(suspensionOrderNo|resumeOrderNo)\d+$/', $key);
            });
            
            if ($dynamicFields->isNotEmpty()) {
                Schema::table('projects_tbl', function (Blueprint $table) use ($dynamicFields) {
                    foreach ($dynamicFields as $field => $_) {
                        if (!Schema::hasColumn('projects_tbl', $field)) {
                            $table->date($field)->nullable();
                        }
                    }
                });
            }
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
            $remainingBalance = max($totalBudget - $totalUsed, 0);

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
                    'remainingBalance' => number_format($remainingBalance, 2),
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

        $validator = \Validator::make($request->all(), [
            'projectTitle' => 'required|string|max:255',
            'projectLoc' => 'required|string|max:255',
            'projectID' => 'required|string|max:50',
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

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed!',
                'errors' => $validator->errors()
            ], 422);
        }

        $newProjectID = $request->input('projectID');

        $dynamicFields = collect($request->all())->filter(function ($_, $key) {
            return preg_match('/^(suspensionOrderNo|resumeOrderNo)\d+$/', $key);
        });
        
        if ($dynamicFields->isNotEmpty()) {
            Schema::table('projects_tbl', function (Blueprint $table) use ($dynamicFields) {
                foreach ($dynamicFields as $field => $_) {
                    if (!Schema::hasColumn('projects_tbl', $field)) {
                        $table->date($field)->nullable();
                    }
                }
            });
        }
        
        \DB::transaction(function () use ($request, $projectID, $newProjectID) {
            $project = showDetails::where('projectID', $projectID)->first();
        
            if (!$project) {
                throw new \Exception('Project not found.');
            }
        
            if ($request->input('projectStatus') === 'Ongoing') {
                $ongoingStatus = $request->input('ongoingStatus');
                $ongoingDate = $request->input('ongoingDate');
                $project->ongoingStatus = !empty($ongoingStatus) && !empty($ongoingDate)
                    ? "{$ongoingStatus} - {$ongoingDate}"
                    : null;
            } else {
                $project->ongoingStatus = null;
            }
        
            // Step 1: Update parent table first so new ID exists
            if ($newProjectID !== $projectID) {
                $project->projectID = $newProjectID;
            }
        
            $project->fill($request->except('projectID'));
            $project->save();
        
            // Step 2: Update child tables after parent
            if ($newProjectID !== $projectID) {
                \DB::table('projectFiles_tbl')->where('projectID', $projectID)->update(['projectID' => $newProjectID]);
                \DB::table('project_status')->where('projectID', $projectID)->update(['projectID' => $newProjectID]);
            }
        
            // ✅ Update session
            session()->put('projectID', $project->projectID);
            session()->save();
            
        });
        

        return response()->json([
            'status' => 'success',
            'message' => 'Project updated successfully!',
            'project' => showDetails::where('projectID', $newProjectID)->first(),
            'newProjectID' => $newProjectID
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

public function fetchStatus($projectID)
{
    // 🔹 Step 1: Initialize response with default values
    $formattedStatuses = [
        'projectID' => $projectID,
        'projectStatus' => null, // Default: no status available
        'ongoingStatus' => null // Default: no progress updates
    ];

    // 🔹 Step 2: Fetch progress updates from `project_status`
    $statuses = DB::table('project_status')
        ->where('projectID', $projectID)
        ->orderByDesc('date') // Get latest status first
        ->get();

    // If there are no statuses for this project, return an error
    if ($statuses->isEmpty()) {
        return response()->json(['error' => 'No status updates found for this project'], 404);
    }

    // 🔹 Step 3: Set the latest status as the project status (from the most recent entry)
    $latestStatus = $statuses->first();
    $formattedStatuses['projectStatus'] = $latestStatus->progress; // Assuming the latest progress is the project status

    // 🔹 Step 4: Format the `ongoingStatus` by correctly separating the percentage and date
    $formattedStatuses['ongoingStatus'] = $statuses->map(function ($status) {
        // Extract the progress, percentage, and date properly
        $progress = $status->progress;
        $percentage = $status->percentage;
        $date = $status->date;

        return "{$progress} - {$date} {$percentage}";
    })->toArray();

    return response()->json($formattedStatuses);
}


public function insertProjectStatus(Request $request)
{
    $request->validate([
        'projectID' => 'required|string',
        'progress' => 'required|string',
        'percentage' => 'required|string',
        'date' => 'required|date',
    ]);

    try {
        DB::table('project_status')->insert([
            'projectID' => $request->projectID,
            'progress' => $request->progress,
            'percentage' => $request->percentage,
            'date' => $request->date,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json(['status' => 'success', 'message' => 'Project status inserted successfully.']);
    } catch (\Exception $e) {
        \Log::error("Failed to insert project status: " . $e->getMessage());
        return response()->json(['status' => 'error', 'message' => 'Failed to insert project status.']);
    }
}


}
