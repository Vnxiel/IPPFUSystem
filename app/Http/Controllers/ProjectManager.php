<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\showDetails;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class ProjectManager extends Controller
{
    public function addProject(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
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
            'completionDate' => 'nullable|string|max:50',
            'abc' => 'nullable|numeric',
            'contractAmount' => 'nullable|numeric',
            'engineering' => 'nullable|numeric',
            'mqc' => 'nullable|numeric',
            'contingency' => 'nullable|numeric',
            'bid' => 'nullable|numeric',
            'appropriate' => 'nullable|numeric',
        ]);
    
        // If validation fails, return 2 (Validation Error)
        if ($validator->fails()) {
            return response()->json([
                'status' => 2,
                'message' => 'Validation failed!',
                'errors' => $validator->errors()
            ], 422);
        }

        // Check if a project with the same projectID already exists
        if (Project::where('projectID', $request->input('projectID'))->exists()) {
            return response()->json(4); // 4: Duplicate entry
        }

        // Attempt to insert into the database
        $project = Project::create($request->all());

        // Check if the project was successfully created
        if ($project) {
            return response()->json([
                'status' => 1, // Changed to numeric 1 for success
                'message' => 'Project added successfully!',
                'project' => $project
            ]);
        }

        // Return an error response if the creation failed
        return response()->json([
            'status' => 0, // Changed to numeric 0 for failure
            'message' => 'Failed to add project.'
        ]);
    }
    

    public function showDetails(Request $request)
    {
        // Fetch projects ordered by creation date
        $projects = showDetails::orderBy('created_at', 'desc')->get();

        // Return data in a format compatible with DataTables
        return response()->json([
            'data' => $projects // DataTables expects a 'data' key
        ]);
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

        // Validate input fields
        $validator = \Validator::make($request->all(), [
            'projectTitle' => 'required|string|max:255',
            'projectLoc' => 'required|string|max:255',
            'projectID' => 'required|string|max:50|unique:projects_tbl,projectID,' . $projectID . ',projectID',
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
            'abc' => 'nullable|numeric',
            'contractAmount' => 'nullable|numeric',
            'engineering' => 'nullable|numeric',
            'mqc' => 'nullable|numeric',
            'contingency' => 'nullable|numeric',
            'bid' => 'nullable|numeric',
            'appropriate' => 'nullable|numeric',
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
        Log::error("Error updating project ID $id: " . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to update project.',
            'error_details' => $e->getMessage()
        ]);
    }
}



}
