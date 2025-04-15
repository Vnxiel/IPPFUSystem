<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\ActivityLog;
use App\Models\Contractor;
use App\Models\ProjectDescription;
use App\Models\FundsUtilization;
use App\Models\ProjectFile;
use App\Models\ProjectStatus;
use App\Http\Controllers\ActivityLogs;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Municipalities;

class ProjectManager extends Controller
{
    public function addProject(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'projectTitle' => 'required|string|max:255',
            'projectLoc' => 'required|string|max:255',
            'projectID' => 'required|string|max:50|unique:projects,projectID',
            'projectContractor' => 'nullable|string|max:255',
            'sourceOfFunds' => 'nullable|string|max:255',
            'otherFund' => 'nullable|string|max:255',
            'modeOfImplementation' => 'nullable|string|max:255',
            'projectDescription' => 'nullable|string',
            'projectStatus' => 'nullable|string',
            'ongoingStatus' => 'nullable|string',
            'projectContractDays' => 'nullable|integer',
            'noaIssuedDate' => 'nullable|date',
            'noaReceivedDate' => 'nullable|date',
            'ntpIssuedDate' => 'nullable|date',
            'ntpReceivedDate' => 'nullable|date',
            'officialStart' => 'nullable|date',
            'targetCompletion' => 'nullable|date',
            'timeExtension' => 'nullable|string|max:50',
            'revisedTargetCompletion' => 'nullable|string|max:50',
            'completionDate' => 'nullable|string|max:50',
            'abc' => 'nullable|string',
            'contractAmount' => 'nullable|string',
            'engineering' => 'nullable|string',
            'mqc' => 'nullable|string',
            'contingency' => 'nullable|string',
            'bid' => 'nullable|string',
            'appropriation' => 'nullable|string',
            'contractCost' => 'nullable|string',
            'revisedContractCost' => 'nullable|string',
            'projectSlippage' => 'nullable|string',
            'othersContractor' => 'nullable|string',
            'ea' => 'nullable|string',
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed!',
                'errors' => $validator->errors()
            ], 422);
        }
    
        $dynamicFields = collect($request->all())->filter(function ($_, $key) {
            return preg_match('/^(suspensionOrderNo|resumeOrderNo)\d*$/', $key);
        });
    
        if ($dynamicFields->isNotEmpty()) {
            Schema::table('projects', function (Blueprint $table) use ($dynamicFields) {
                foreach ($dynamicFields as $field => $_) {
                    if (!Schema::hasColumn('projects', $field)) {
                        $table->string($field)->nullable();
                    }
                }
            });
        }
    
        DB::beginTransaction();
    
        try {
            $standardFields = $request->except($dynamicFields->keys()->toArray());
    
            // Add required fields manually into the project fields
            $standardFields['projectStatus'] = $request->input('projectStatus');
            $standardFields['ongoingStatus'] = $request->input('ongoingStatus');
            $standardFields['othersContractor'] = $request->input('othersContractor');
    
            $project = new Project($standardFields);
    
            foreach ($dynamicFields as $field => $value) {
                $project->{$field} = $value;
            }
    
            $project->save();
    
            if (!$project->exists) {
                throw new \Exception("Failed to insert project data into projects_tbl.");
            }
    
            // Insert contractor if not yet in contractors table
            $contractorName = $request->input('othersContractor');
            if ($contractorName && !Contractor::where('name', $contractorName)->exists()) {
                Contractor::create(['name' => $contractorName]);
            }
    
            $projectDescription = $request->input('projectDescription');
    
            if (!empty($projectDescription)) {
                $lines = preg_split('/\r\n|\r|\n/', $projectDescription);
                foreach ($lines as $line) {
                    $trimmedLine = trim($line);
                    if ($trimmedLine !== '') {
                        ProjectDescription::create([
                            'project_id' => $project->id,
                            'projectID' => $project->projectID,
                            'ProjectDescription' => $trimmedLine,
                        ]);
                    }
                }
            }
    
            FundsUtilization::create([
                'project_id' => $project->id,
                'orig_abc' => $this->cleanMoney($request->input('abc')),
                'orig_contract_amount' => $this->cleanMoney($request->input('contractAmount')),
                'orig_engineering' => $this->cleanMoney($request->input('engineering')),
                'orig_mqc' => $this->cleanMoney($request->input('mqc')),
                'orig_contingency' => $this->cleanMoney($request->input('contingency')),
                'orig_bid' => $this->cleanMoney($request->input('bid')),
                'orig_appropriation' => $this->cleanMoney($request->input('appropriation')),
                'orig_completion_date' => $request->input('completionDate'),
            ]);
    
            if (strtolower($request->input('projectStatus')) === 'ongoing') {
                ProjectStatus::create([
                    'project_id' => $project->id,
                    'projectID' => $request->input('projectID'),
                    'progress' => $request->input('projectStatus'),
                    'percentage' => (explode(' - ', $request->input('ongoingStatus'))[0] ?? '0'),
                    'date' => $request->input('ongoingDate') ?? now(),
                ]);
            }
            
    
            if (session()->has('loggedIn')) {
                $sessionData = session()->get('loggedIn');
                $user_id = $sessionData['user_id'];
                $ofmis_id = $sessionData['ofmis_id'];
                $username = $sessionData['performedBy'];
                $role = $sessionData['role'];
                $projectTitle = $request->input('projectTitle');
                $action = "Added a new project: $projectTitle.";
    
                $request->session()->put('AddedNewProject', [
                    'user_id' => $user_id,
                    'ofmis_id' => $ofmis_id,
                    'performedBy' => $username,
                    'role' => $role,
                    'action' => $action,
                ]);
    
                Log::info("User action logged: " . json_encode($request->session()->get('AddedNewProject')));
                (new ActivityLogs)->userAction($user_id, $ofmis_id, $username, $role, $action);
            } else {
                DB::rollBack();
                Log::error("Session not found");
                return response()->json(['status' => 'error', 'message' => 'Session not found'], 401);
            }
    
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Project added successfully!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding project: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error adding project. ' . $e->getMessage()]);
        }
    }
    
    
    
    /**
     * Helper function to clean currency strings (₱, commas, etc.)
     */
    private function cleanMoney($value)
    {
        return $value ? str_replace([',', '₱', 'Php', 'php'], '', $value) : null;
    }
    

    public function yourViewMethod() {
        $contractors = Contractor::orderBy('name')->get(); // or any query you'd like
        return view('systemAdmin.projects', compact('contractors'));
    }
    

    public function ProjectDetails()
    {
        try {
            // Siguraduhin na ang `is_hidden` ay `0` o `NULL`, kaya gumamit ng `whereNull` at `orWhere`
            $projects = Project::where(function ($query) {
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
            $projects = Project::where('is_hidden', 1)
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
    
        public function restoreProject(Request $request, $id)
    {
        try {
            // Find the project by ID
            $project = Project::find($id);

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

    public function getProject(Request $request, $id) 
    {
        try {
            $projectData = DB::table('projects')->where('id', $id)->first();
    
            if (!$projectData) {
                return response()->json(['status' => 'error', 'message' => 'Project not found.'], 404);
            }
    
            $project = (array) $projectData;
    
            // Fetch project status
            $projectStatus = ProjectStatus::where('project_id', $id)->first();
            $project['projectStatus'] = $projectStatus->progress ?? 'Not Available';
            
            if ($projectStatus && $projectStatus->percentage) {
                $percentage = rtrim($projectStatus->percentage, '%'); // Remove any stray % if present
                $date = $projectStatus->updated_at ? $projectStatus->updated_at->format('F d, Y') : 'Unknown date';
                $project['ongoingStatus'] = $percentage . ' - ' . $date;
            } else {
                $project['ongoingStatus'] = 'Not Available';
            }
            
    
            // Fetch all descriptions related to this project
            $descriptions = ProjectDescription::where('project_id', $id)->pluck('ProjectDescription')->toArray();
            $project['projectDescriptions'] = $descriptions;
    
            // Get matching dynamic order fields
            $columns = DB::getSchemaBuilder()->getColumnListing('projects');
            $matchingColumns = collect($columns)->filter(function ($column) {
                return preg_match('/^(suspensionOrderNo|resumeOrderNo)\d+$/', $column);
            });
    
            $orderDetails = [];
            foreach ($matchingColumns as $col) {
                $orderDetails[$col] = $project[$col] ?? null;
            }
            $project['orderDetails'] = $orderDetails;
    
            return response()->json([
                'status' => 'success',
                'project' => $project
            ]);
    
        } catch (\Exception $e) {
            Log::error('Error fetching project details: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found.',
            ]);
        }
    }
    
    
    public function getProjectSummary()
    {
        try {
            Log::info('Fetching project summary...');

            if (!Schema::hasTable('projects')) {
                Log::error('Error: Table "projects" does not exist.');
                return response()->json(['status' => 'error', 'message' => 'Database table not found.']);
            }

            $totalProjects = Project::count();
            $ongoingProjects = Project::where('projectStatus', 'Ongoing')->count();
            $completedProjects = Project::where('projectStatus', 'Completed')->count();
            $discontinuedProjects = Project::where('projectStatus', 'Cancelled')->count();

            $projects = Project::all();
            $totalBudget = $projects->sum(fn ($p) => (float) preg_replace('/[^0-9.]/', '', $p->abc ?? '0'));
            $totalUsed = $projects->sum(fn ($p) => (float) preg_replace('/[^0-9.]/', '', $p->contractAmount ?? '0'));
            $remainingBalance = max($totalBudget - $totalUsed, 0);

            $recentProjects = Project::orderBy('created_at', 'desc')->limit(5)->get();

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

    public function getAllProjects()
    {
        $projects = Project::all();
    
        // Attach projectStatus from project_statuses to each project
        $projects->transform(function ($project) {
            $status = ProjectStatus::where('project_id', $project->id)->latest('created_at')->first();
            $project->projectStatus = $status ? $status->progress : null;
            return $project;
        });
    
        return response()->json([
            'status' => 'success',
            'projects' => $projects
        ]);
    }
    
    


    public function updateProject(Request $request, $id)
    {
        try {
            Log::info("Updating project ID: $id", $request->all());
    
            $validator = \Validator::make($request->all(), [
                'projectTitle' => 'required|string|max:255',
                'projectLoc' => 'required|string|max:255',
                'projectID' => 'required|string|max:50', // This remains as it's a field, not the primary key
                'projectContractor' => 'nullable|string|max:255',
                'sourceOfFunds' => 'nullable|string|max:255',
                'otherFund' => 'nullable|string|max:255',
                'modeOfImplementation' => 'nullable|string|max:255',
                'projectDescription' => 'nullable|string',
                'projectContractDays' => 'nullable|integer',
                'noaIssuedDate' => 'nullable|date',
                'noaReceivedDate' => 'nullable|date',
                'ntpIssuedDate' => 'nullable|date',
                'ntpReceivedDate' => 'nullable|date',
                'officialStart' => 'nullable|date',
                'targetCompletion' => 'nullable|date',
                'timeExtension' => 'nullable|string|max:50',
                'revisedTargetCompletion' => 'nullable|string|max:50',
                'completionDate' => 'nullable|string|max:50',
                'abc' => 'nullable|string',
                'contractAmount' => 'nullable|string',
                'engineering' => 'nullable|string',
                'mqc' => 'nullable|string',
                'contingency' => 'nullable|string',
                'bid' => 'nullable|string',
                'appropriation' => 'nullable|string',
                'contractCost' => 'nullable|string',
                'revisedContractCost' => 'nullable|string',
                'projectSlippage' => 'nullable|string',
                'otherContractor' => 'nullable|string',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed!',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            $newProjectID = $request->input('projectID');
    
            // Collect dynamic fields (suspensionOrderNo*, resumeOrderNo*)
            $dynamicFields = collect($request->all())->filter(function ($_, $key) {
                return preg_match('/^(suspensionOrderNo|resumeOrderNo)\d*$/', $key);
            });
    
            // Start transaction
            \DB::transaction(function () use ($request, $id, $newProjectID, $dynamicFields) {
                $project = Project::find($id);
    
                if (!$project) {
                    throw new \Exception('Project not found.');
                }
    
                // Add new columns if they don't exists
                if ($dynamicFields->isNotEmpty()) {
                    Schema::table('projects', function (Blueprint $table) use ($dynamicFields) {
                        foreach ($dynamicFields as $field => $_) {
                            if (!Schema::hasColumn('projects', $field)) {
                                $table->string($field)->nullable();
                            }
                        }
                    });
                }
    
                // Assign dynamic values to model
                foreach ($dynamicFields as $field => $value) {
                    $project->$field = $value;
                }
    
                // Update other fields (excluding dynamic + projectID manually handled)
                $project->fill($request->except(['projectID'] + $dynamicFields->keys()->toArray()));
    
               
    
                $project->save();
    
                session()->put('projectID', $project->projectID);
                session()->save();
    
                // Insert or update project descriptions if present
                $projectDescription = $request->input('projectDescription');
                if (!empty($projectDescription)) {
                    $lines = preg_split('/\r\n|\r|\n/', $projectDescription);
                    foreach ($lines as $line) {
                        $trimmedLine = trim($line);
                        if ($trimmedLine !== '') {
                            ProjectDescription::updateOrCreate(
                                ['project_id' => $project->id, 'projectID' => $project->projectID, 'ProjectDescription' => $trimmedLine]
                            );
                        }
                    }
                }
    
                // Insert or update funds utilization
                FundsUtilization::updateOrCreate(
                    ['project_id' => $project->id],
                    [
                        'orig_abc' => $this->cleanMoney($request->input('abc')),
                        'orig_contract_amount' => $this->cleanMoney($request->input('contractAmount')),
                        'orig_engineering' => $this->cleanMoney($request->input('engineering')),
                        'orig_mqc' => $this->cleanMoney($request->input('mqc')),
                        'orig_contingency' => $this->cleanMoney($request->input('contingency')),
                        'orig_bid' => $this->cleanMoney($request->input('bid')),
                        'orig_appropriation' => $this->cleanMoney($request->input('appropriation')),
                        'orig_completion_date' => $request->input('completionDate'),
                    ]
                );
    
              
            });
    
            return response()->json([
                'status' => 'success',
                'message' => 'Project updated successfully!',
                'project' => Project::where('id', $id)->first(),
                'newProjectID' => $newProjectID
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
    

    public function trashProject(Request $request, $id)
    {
        $project = Project::where('project_id', $id)->first();

        if (!$project) {
            return response()->json(["status" => "error", "message" => "Project not found."], 404);
        }

        $project->is_hidden = 1;
        $project->save();

        return response()->json(["status" => "success", "message" => "Project successfully archived."]);
    }

    public function fetchStatus(Request $request, $id)
    {
        // Validate if $id is numeric
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid project ID'], 400);
        }
    
        // 🔹 Step 1: Retrieve the project using the primary key `id`
        $project = DB::table('projects')->where('id', $id)->first();
    
        if (!$project) {
            return response()->json(['error' => 'Project not found'], 404);
        }
    
        $project_id = $project->id;
    
        // 🔹 Step 2: Initialize response with default values
        $formattedStatuses = [
            'project_id' => $project_id,
            'projectStatus' => null,
            'ongoingStatus' => null
        ];
    
        // 🔹 Step 3: Fetch progress updates
        $statuses = DB::table('project_statuses')
            ->where('project_id', $id)
            ->orderByDesc('date')
            ->get();
    
        if ($statuses->isEmpty()) {
            return response()->json(['error' => 'No status updates found for this project'], 404);
        }
    
        // 🔹 Step 4: Set latest status and format ongoing status
        $latestStatus = $statuses->first();
        $formattedStatuses['projectStatus'] = $latestStatus->progress;
    
        $formattedStatuses['ongoingStatus'] = $statuses->map(function ($status) {
            return "{$status->progress} - {$status->date} {$status->percentage}";
        })->toArray();
    
        return response()->json($formattedStatuses);
    }
    
    

    public function addStatus(Request $request, $project_id)
    {
        $request->validate([
            'project_id' => 'required|integer|exists:projects,id',
            'progress' => 'required|string',
            'percentage' => 'required|numeric|min:0|max:100',
            'date' => 'required|date',
        ]);
    
        try {
            DB::table('project_statuses')->insert([
                'project_id' => $request->project_id,
                'projectID' => $request->project_id,
                'progress' => $request->progress,
                'percentage' => $request->percentage,
                'date' => $request->date,
                'created_at' => now(),
                'updated_at' => now()
            ]);
    
            return response()->json([
                'status' => 'success',
                'message' => 'Project status successfully inserted.'
            ]);
        } catch (\Exception $e) {
            \Log::error("Failed to insert project status: " . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Something went wrong while inserting project status.'
            ], 500);
        }
    }
    

public function getDropdownOptions(Request $request) {
    // Fetch contractors and municipalities
    $contractors = Contractor::orderBy('name', 'asc')->get();
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

public function overview()
{
    // You need to fetch the contractors here
    $contractors = Contractor::orderBy('name')->get();

    return view('systemAdmin.overview', compact('contractors'));
}

}
