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
use Illuminate\Support\Facades\Crypt;
use App\Models\ActivityLog;
use App\Http\Controllers\ActivityLogs;
use App\Models\Contractor;
use App\Models\FundsUtilization;
use App\Models\ProjectDescription;
use App\Models\ProjectFile;
use App\Models\ProjectStatus;
use App\Models\VariationOrder;
use Barryvdh\DomPDF\Facade\Pdf;

class ProjectManager extends Controller
{
    public function addProject(Request $request)
{
    $validator = \Validator::make($request->all(), [
        'projectTitle' => 'required|string',
        'projectLoc' => 'required|string',
        'projectID' => 'required|string',
        'projectYear' => 'required|integer|max:2100|min:1900',
        'projectFPP' => 'required|string',
        'projectRC' => 'required|string',
        'projectContractor' => 'required|string',
        'sourceOfFunds' => 'required|string',
        'otherFund' => 'nullable|string',
        'modeOfImplementation' => 'required|string',
        'projectDescription' => 'string',
        'projectStatus' => 'required|string',
        'ongoingStatus' => 'nullable|string',
        'projectContractDays' => 'required|integer',
        'noaIssuedDate' => 'nullable|date',
        'noaReceivedDate' => 'nullable|date',
        'ntpIssuedDate' => 'nullable|date',
        'ntpReceivedDate' => 'nullable|date',
        'officialStart' => 'required|date',
        'targetCompletion' => 'required|date',
        'timeExtension' => 'nullable|integer',
        'revisedCompletionDate' => 'nullable|date',
        'completionDate' => 'required|date',
        'projectSlippage' => 'nullable|string',
        'othersContractor' => 'nullable|string',
        'ea' => 'required|string',
        'ea_position' => 'required|string',
        'ea_monthlyRate' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed!',
            'errors' => $validator->errors()
        ], 422);
    }

    // Collect all dynamic field names (suspensionOrderNo1, suspensionOrderNo2, etc.)
    $dynamicFields = collect($request->all())->filter(function ($_, $key) {
        return preg_match('/^(suspensionOrderNo|resumeOrderNo)\d*$/', $key);
    });

    $existing = Project::where('projectFPP', $request->input('projectFPP'))
    ->where('projectRC', $request->input('projectRC'))
    ->exists();

if ($existing) {
    return response()->json([
        'status' => 'error',
        'message' => 'A project with the same FPP and RC already exists.'
    ], 409);
}


    // Begin DB transaction
    DB::beginTransaction();

    try {
        // ✅ Create dynamic columns before starting the transaction
        if ($dynamicFields->isNotEmpty()) {
            Schema::table('projects', function (Blueprint $table) use ($dynamicFields) {
                foreach ($dynamicFields as $field => $_) {
                    // Add only if column doesn't exist
                    if (!Schema::hasColumn('projects', $field)) {
                        $table->string($field)->nullable();
                    }
                }
            });
        }

            // Collect suspension and resumption remarks data
            $suspensionData = [];
            foreach ($request->all() as $key => $value) {
                if (preg_match('/^suspensionOrderNo(\d+)$/', $key, $matches)) {
                    $index = $matches[1];
                    $suspensionOrderNo = (int)$value;

                    $resumeOrderKey = "resumeOrderNo{$index}";
                    $resumeOrderNo = (int)($request->input($resumeOrderKey) ?? null);

                    $suspensionRemarks = $request->input("suspensionOrderNo{$index}Remarks");
                    $resumeRemarks = $request->input("resumeOrderNo{$index}Remarks");

                    if ($suspensionOrderNo || $resumeOrderNo || $suspensionRemarks || $resumeRemarks) {
                        $suspensionData[$index] = [
                            'suspensionOrderNo' => $suspensionOrderNo,
                            'resumeOrderNo' => $resumeOrderNo,
                            'suspensionOrderRemarks' => $suspensionRemarks,
                            'resumeOrderRemarks' => $resumeRemarks,
                        ];
                    }
                }
            }



        // Prepare project data
        $standardFields = $request->except([
            '_token',
            'abc',
            'contractAmount',
            'engineering',
            'mqc',
            'contingency',
            'bid',
            'appropriation',
            'projectDescription',
            'ongoingDate',
        ]);

        // Add suspension remarks as a JSON field
        $standardFields['remarksData'] = json_encode($suspensionData);
        $standardFields['projectStatus'] = $request->input('projectStatus');
        $standardFields['ongoingStatus'] = $request->input('ongoingStatus');
        $standardFields['othersContractor'] = $request->input('othersContractor');

        // Create project record
        $project = new Project($standardFields);

        // Assign dynamic field values to the project
        foreach ($dynamicFields as $field => $value) {
            $project->{$field} = $value;
        }

        $project->save();

        if (!$project->exists) {
            throw new \Exception("Failed to save project data into the projects table.");
        }

        //  Insert contractor if new
        $contractorName = $request->input('othersContractor');
        if ($contractorName && !Contractor::where('name', $contractorName)->exists()) {
            Contractor::create(['name' => $contractorName]);
        }

        // Insert project description line-by-line if provided
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

        // Insert fund utilization record
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

        // Insert project status if ongoing
        if (strtolower($request->input('projectStatus')) === 'ongoing') {
            ProjectStatus::create([
                'project_id' => $project->id,
                'progress' => $request->input('projectStatus'),
                'percentage' => (explode(' - ', $request->input('ongoingStatus'))[0] ?? '0'),
                'date' => $request->input('ongoingDate') ?? now(),
            ]);
        }

        // User session logging
        if (session()->has('loggedIn')) {
            $sessionData = session()->get('loggedIn');
            $action = "Added a new project: " . $request->input('projectTitle');

            // Log the activity
            $request->session()->put('AddedNewProject', [
                'user_id' => $sessionData['user_id'],
                'ofmis_id' => $sessionData['ofmis_id'],
                'performedBy' => $sessionData['performedBy'],
                'role' => $sessionData['role'],
                'action' => $action,
            ]);

            Log::info("User action logged: " . json_encode($request->session()->get('AddedNewProject')));

            // Activity log entry
            (new ActivityLogs)->userAction(
                $sessionData['user_id'],
                $sessionData['ofmis_id'],
                $sessionData['performedBy'],
                $sessionData['role'],
                $action
            );
        } else {
            DB::rollBack();
            Log::error("Session not found");
            return response()->json(['status' => 'error', 'message' => 'Session not found'], 401);
        }

        // Commit the transaction
        DB::commit();
        return response()->json(['status' => 'success', 'message' => 'Project added successfull!']);
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

    public function viewProjects()
{
    $projects = Project::select('id', 'projectTitle', 'projectLoc', 'projectStatus', 'projectContractor', 'othersContractor', 'projectContractDays')
        ->with('fundsUtilization')
        ->where(function ($query) {
            $query->whereNull('is_hidden')->orWhere('is_hidden', 0);
        })
        ->orderBy('created_at', 'desc')
        ->get();
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

    return view('systemAdmin.projects', compact('mappedProjects', 'contractors', 'locations', 'sourceOfFunds', 'projectEA', 'projectYear'));
}

    
    public function fetchTrashedProjects()
    {
        try {
            // Kunin lang ang mga projects na may `is_hidden = 1`
            $projects = Project::where('is_hidden', 1)
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($project) {
                    return [
                        'title' => $project->projectTitle ?? 'N/A',
                        'location' => $project->projectLoc ?? 'N/A',
                        'status' => $project->projectStatus ?? 'N/A',
                      'amount' => number_format((float) preg_replace('/[^\d.]/', '', $project->contractAmount), 2),

                        'contractor' => (strtolower($project->projectContractor) === 'others')
                            ? ($project->othersContractor ?? 'N/A')
                            : ($project->projectContractor ?? 'N/A'),
                        'duration' => $project->projectContractDays ? $project->projectContractDays . ' days' : 'N/A',
                        'action' => '<button class="btn btn-primary btn-sm restore-btn" data-id="' . $project->id . '">Restore</button>',
                    ];
                });
    
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

              // Log activity
        $sessionData = session('loggedIn', []);
        $action = "Restored project: " . $project->projectTitle;
        (new ActivityLogs)->userAction(
            $sessionData['user_id'] ?? null,
            $sessionData['ofmis_id'] ?? null,
            $sessionData['performedBy'] ?? null,
            $sessionData['role'] ?? null,
            $action
        );

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
        
            $sourceOfFunds = Project::select('sourceOfFunds')->distinct()->whereNotNull('sourceOfFunds')->orderBy('sourceOfFunds')->get();
            $projectYear = Project::select('projectYear')->distinct()->whereNotNull('projectYear')->orderBy('projectYear')->get();
            $projectEA = Project::select('ea')->distinct()->whereNotNull('ea')->orderBy('ea')->get();
    
            $projectData = Project::find($id);
    
            if (!$projectData) {
                return redirect()->back()->withErrors(['Project not found.']);
            }
            
    
            $project = $projectData->toArray();
            // Decode suspensionRemarks JSON
                $project['remarksData'] = [];
                if (!empty($projectData->suspensionRemarks)) {
                    $decodedRemarks = json_decode($projectData->suspensionRemarks, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $project['remarksData'] = $decodedRemarks;
                    } else {
                        Log::warning('Invalid JSON in suspensionRemarks', ['project_id' => $id]);
                    }
                }

            $project['projectStatus'] = $projectData->projectStatus ?? 'Not Available';
    
            $statuses = ProjectStatus::where('project_id', $id)
                ->orderByDesc('date')
                ->orderByDesc('percentage')
                ->get();
    
            $projectStatusData = [
                'project_id' => $projectData->id,
                'projectStatus' => $statuses->isEmpty() ? ($projectData->projectStatus ?? 'No status available') : $statuses->first()->progress,
                'updatedAt' => $statuses->isEmpty() ? optional($projectData->updated_at)->format('Y-m-d') : $statuses->first()->date,
                'latestPercentage' => $statuses->isEmpty() ? $projectData->percentage : $statuses->first()->percentage,
                'ongoingStatus' => $statuses->map(function ($status) {
                    return [
                        'progress' => $status->progress,
                        'percentage' => $status->percentage,
                        'date' => $status->date,
                    ];
                })->toArray()
            ];
    
            if (strtolower($project['projectStatus']) === 'ongoing') {
                $projectStatus = $statuses->first();
                if ($projectStatus) {
                    $percentage = rtrim($projectStatus->percentage, '%');
                    $formattedDate = $projectStatus->date ? \Carbon\Carbon::parse($projectStatus->date)->format('F d, Y') : 'Unknown date';
                    $project['ongoingStatus'] = $percentage . '% - ' . $formattedDate;
                } else {
                    $project['ongoingStatus'] = 'Not Available';
                }
            } else {
                $project['ongoingStatus'] = null;
            }
    
            $project['projectDescriptions'] = ProjectDescription::where('project_id', $id)
                ->pluck('ProjectDescription')->toArray();
    
            $columns = DB::getSchemaBuilder()->getColumnListing('projects');
            $matchingColumns = collect($columns)->filter(function ($column) {
                return preg_match('/^(suspensionOrderNo|resumeOrderNo)\d+$/', $column);
            });
    
            $orderDetails = [];
            foreach ($matchingColumns as $col) {
                $orderDetails[$col] = $project[$col] ?? null;
            }
            $project['orderDetails'] = $orderDetails;
    
            $fundUtilization = FundsUtilization::where('project_id', $id)
            ->orderBy('updated_at', 'desc')
            ->first();
            if ($fundUtilization) {
                $project['funds'] = $fundUtilization->only([
                    'orig_abc', 'orig_contract_amount', 'orig_engineering', 'orig_mqc', 'orig_contingency', 'orig_bid', 'orig_appropriation',
                    'actual_abc', 'actual_contract_amount', 'actual_engineering', 'actual_mqc', 'actual_contingency', 'actual_bid', 'actual_appropriation',
                ]);
    
                $project['summary'] = [];

                if (isset($fundUtilization->summary)) {
                    if (is_string($fundUtilization->summary)) {
                        $decodedSummary = json_decode($fundUtilization->summary, true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            $project['summary'] = $decodedSummary;
                        } else {
                            // Handle JSON decoding error
                            error_log('Summary JSON decode error: ' . json_last_error_msg());
                        }
                    } elseif (is_array($fundUtilization->summary)) {
                        $project['summary'] = $fundUtilization->summary;
                    }
                }
                
                $project['partial_billings'] = [];
                
                if (isset($fundUtilization->partial_billings)) {
                    if (is_string($fundUtilization->partial_billings)) {
                        $decodedBillings = json_decode($fundUtilization->partial_billings, true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            $project['partial_billings'] = $decodedBillings;
                        } else {
                            // Handle JSON decoding error
                            error_log('Partial billings JSON decode error: ' . json_last_error_msg());
                        }
                    } elseif (is_array($fundUtilization->partial_billings)) {
                        $project['partial_billings'] = $fundUtilization->partial_billings;
                    }
                }
                
            }
        
    
            $project['variation_orders'] = VariationOrder::where('funds_utilization_id', $fundUtilization->id ?? null)
                ->orderBy('vo_number')
                ->get()
                ->map(function ($vo) {
                    return $vo->only([
                        'vo_number', 'vo_abc', 'vo_contract_amount', 'vo_engineering', 'vo_mqc', 'vo_contingency', 'vo_bid', 'vo_appropriation'
                    ]);
                })
                ->toArray();

                Log::info('Variation Orders:', ['project_id' => $id, 'variation_orders' => $project['variation_orders']]);
    
                
            $role = auth()->user()->role;
            switch ($role) {
                case 'System Admin':
                    $view = 'systemAdmin.overview';
                    break;
                case 'Admin':
                    $view = 'admin.overview';
                    break;
                case 'Staff':
                    $view = 'staff.overview';
                    break;
                default:
                    return redirect()->back()->withErrors(['Unauthorized role.']);
            }
    
            return view($view, compact('contractors', 'project', 'locations', 'sourceOfFunds', 'projectYear', 'projectEA', 'projectStatusData'));
    
        } catch (\Exception $e) {
            Log::error('Error fetching project details: ' . $e->getMessage());
            return redirect()->back()->withErrors(['An error occurred while retrieving the project.']);
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

        // Only consider projects that are not hidden
        $visibleProjects = Project::where('is_hidden', '!=', 1);

        $totalProjects = $visibleProjects->count();
        $ongoingProjects = $visibleProjects->clone()->where('projectStatus', 'Ongoing')->count();
        $completedProjects = $visibleProjects->clone()->where('projectStatus', 'Completed')->count();
        $discontinuedProjects = $visibleProjects->clone()->where('projectStatus', 'Cancelled')->count();
        $toBeStartedProjects = $visibleProjects->clone()->where('projectStatus', 'Not Started')->count();
        $suspendedProjects = $visibleProjects->clone()->where('projectStatus', 'Suspended')->count();

        $projects = $visibleProjects->get();
        
        $totalBudget = 0;
        $totalUsed = 0;
        
        foreach ($projects as $project) {
            // Try to find a FundsUtilization entry for this project
            $funds = FundsUtilization::where('project_id', $project->id)->first();
        
            // Use FundsUtilization values if available, otherwise fallback to Project values
            $abc = $funds ? $funds->orig_abc : $project->abc;
            $contractAmount = $funds ? $funds->orig_contract_amount : $project->contractAmount;
        
            $totalBudget += (float) preg_replace('/[^0-9.]/', '', $abc ?? '0');
            $totalUsed += (float) preg_replace('/[^0-9.]/', '', $contractAmount ?? '0');
        }
        
        $remainingBalance = max($totalBudget - $totalUsed, 0);
        
        $recentProjects = $visibleProjects->orderBy('created_at', 'desc')->limit(5)->get();

        Log::info('Project summary fetched successfully.');

        return response()->json([
            'status' => 'success',
            'data' => [
                'totalProjects' => $totalProjects,
                'ongoingProjects' => $ongoingProjects,
                'completedProjects' => $completedProjects,
                'discontinuedProjects' => $discontinuedProjects,
                'toBeStartedProjects' => $toBeStartedProjects,
                'suspendedProjects' => $suspendedProjects,
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


public function updateProject(Request $request, $id)
{
    try {
        Log::info("Updating project ID: $id", $request->all());

        $validator = \Validator::make($request->all(), [
            'projectTitle' => 'required|string|max:255',
            'projectLoc' => 'required|string|max:255',
            'projectID' => 'required|string|max:255',
            'projectContractor' => 'required|string',
            'sourceOfFunds' => 'required|string',
            'otherFund' => 'nullable|string|max:255',
            'modeOfImplementation' => 'required|string',
            'projectDescription' => 'nullable|string',
            'projectContractDays' => 'required|integer',
            'noaIssuedDate' => 'nullable|date',
            'noaReceivedDate' => 'nullable|date',
            'ntpIssuedDate' => 'nullable|date',
            'ntpReceivedDate' => 'nullable|date',
            'officialStart' => 'required|date',
            'targetCompletion' => 'required|date',
            'timeExtension' => 'nullable|integer',
            'revisedCompletionDate' => 'nullable|date',
            'completionDate' => 'required|date',
            'projectSlippage' => 'nullable|string',
            'othersContractor' => 'nullable|string',
            'ea' => 'nullable|string',
            'ea_position' => 'nullable|string',
            'ea_monthlyRate' => 'nullable|string',
            'projectYear' => 'nullable|integer',
            'projectFPP' => 'nullable|string',
            'projectRC' => 'nullable|string',
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
            return preg_match('/^(suspensionOrderNo|resumeOrderNo)\d*$/', $key);
        });

        $remarksData = [];
        foreach ($request->all() as $key => $value) {
            if (preg_match('/^(suspensionOrderNo|resumeOrderNo)(\d+)$/', $key, $matches)) {
                $index = $matches[2];
                $remarksData[$index] = [
                    'suspensionOrderRemarks' => $request->input("suspensionOrderNo{$index}Remarks"),
                    'resumeOrderRemarks' => $request->input("resumeOrderNo{$index}Remarks"),
                ];
            }
        }

        $oldValues = [];

        \DB::transaction(function () use ($request, $id, $newProjectID, $dynamicFields, $remarksData, &$oldValues) {
            $project = Project::find($id);

            if (!$project) {
                throw new \Exception('Project not found.');
            }

            $oldValues = $project->only([
                'projectTitle', 'projectLoc', 'projectID', 'projectContractor',
                'sourceOfFunds', 'otherFund', 'modeOfImplementation',
                'projectStatus', 'ongoingStatus', 'projectContractDays',
                'noaIssuedDate', 'noaReceivedDate', 'ntpIssuedDate', 'ntpReceivedDate',
                'officialStart', 'targetCompletion', 'timeExtension',
                'revisedCompletionDate', 'completionDate', 'projectSlippage',
                'othersContractor', 'ea', 'ea_position', 'ea_monthlyRate', 'projectYear', 'projectFPP', 'projectRC',
                'suspensionRemarks'
            ]);

            $project->fill($request->only(array_keys($oldValues)));

            foreach ($dynamicFields as $field => $value) {
                if (Schema::hasColumn('projects', $field)) {
                    $project->$field = $value;
                }
            }

            $project->suspensionRemarks = json_encode($remarksData);
            $project->save();

            $projectDescription = $request->input('projectDescription');
            if (!empty($projectDescription)) {
                $lines = preg_split('/\r\n|\r|\n/', $projectDescription);
                foreach ($lines as $line) {
                    $trimmedLine = trim($line);
                    if ($trimmedLine !== '') {
                        $existing = ProjectDescription::where('project_id', $project->id)
                            ->where('ProjectDescription', $trimmedLine)
                            ->first();

                        if (!$existing) {
                            ProjectDescription::create([
                                'project_id' => $project->id,
                                'projectID' => $project->projectID,
                                'ProjectDescription' => $trimmedLine
                            ]);
                        }
                    }
                }
            }

            $funds = FundsUtilization::firstOrNew(['project_id' => $project->id]);
            $funds->orig_abc = $this->cleanMoney($request->input('abc'));
            $funds->orig_contract_amount = $this->cleanMoney($request->input('contractAmount'));
            $funds->orig_engineering = $this->cleanMoney($request->input('engineering'));
            $funds->orig_mqc = $this->cleanMoney($request->input('mqc'));
            $funds->orig_contingency = $this->cleanMoney($request->input('contingency'));
            $funds->orig_bid = $this->cleanMoney($request->input('bid'));
            $funds->orig_appropriation = $this->cleanMoney($request->input('appropriation'));
            $funds->save();
        });

        // Log activity
        $project = Project::find($id);
        $newValues = $project->only(array_keys($oldValues));
        $changes = [];

        foreach ($oldValues as $key => $oldValue) {
            $newValue = $newValues[$key];
            if ($oldValue != $newValue) {
                $changes[] = "$key: '$oldValue' -> '$newValue'";
            }
        }

        $projectTitle = $request->input('projectTitle');
        $changeLog = implode("; ", $changes) ?: 'No changes detected.';
        $sessionData = session('loggedIn', []);
        $action = "Updated project: $projectTitle. Changes: $changeLog";

        (new ActivityLogs)->userAction(
            $sessionData['user_id'] ?? null,
            $sessionData['ofmis_id'] ?? null,
            $sessionData['performedBy'] ?? null,
            $sessionData['role'] ?? null,
            $action
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Project updated successfully!',
            'project' => $project,
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
        $project = Project::where('id', $id)->first();

        if (!$project) {
            return response()->json(["status" => "error", "message" => "Project not found."], 404);
        }

        $project->is_hidden = 1;
        $project->save();

         // Log activity
            $sessionData = session('loggedIn', []);
            $action = "Archived project: " . $project->projectTitle;
            (new ActivityLogs)->userAction(
                $sessionData['user_id'] ?? null,
                $sessionData['ofmis_id'] ?? null,
                $sessionData['performedBy'] ?? null,
                $sessionData['role'] ?? null,
                $action
            );

        return response()->json(["status" => "success", "message" => "Project successfully archived."]);
    }

    
     
    

public function addStatus(Request $request)
{
    $request->validate([
        'project_id' => 'required|integer|exists:projects,id',
        'progress' => 'required|string',
        'percentage' => 'required|numeric|min:0|max:100',
        'date' => 'required|date',
    ]);

    try {
        $project = Project::where('id', $request->project_id)->first();

        if (!$project) {
            return response()->json(['status' => 'error', 'message' => 'Project not found.'], 404);
        }

        if (in_array($project->projectStatus, ['Completed', 'Discontinued'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot add status to a completed or discontinued project.'
            ], 403);
        }

        $latestStatus = ProjectStatus::where('project_id', $request->project_id)
            ->orderByDesc('date')
            ->orderByDesc('percentage')
            ->first();

        if ($latestStatus) {
            if (
                strtotime($request->date) < strtotime($latestStatus->date) ||
                $request->percentage < $latestStatus->percentage
            ) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'The new status must have a later date and higher or equal percentage.'
                ], 422);
            }
        }

        DB::beginTransaction();

        ProjectStatus::insert([
            'project_id' => $request->project_id,
            'progress' => $request->progress,
            'percentage' => $request->percentage,
            'date' => $request->date,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $ongoingStatus = $request->percentage . ' - ' . $request->date;

        Project::where('id', $request->project_id)
            ->update([
                'projectStatus' => $request->progress,
                'ongoingStatus' =>$request->percentage,
                'updated_at' => now()
            ]);

        DB::commit();

        return response()->json([
            'status' => 'success',
            'message' => 'Project status successfully inserted and project updated.'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error("Error in addStatus: " . $e->getMessage());
        return response()->json([
            'status' => 'error',
            'message' => 'Failed to insert status or update project.',
            'error' => $e->getMessage()
        ], 500);
    }
}


// public function getDropdownOptions(Request $request) {
//     // Fetch contractors and municipalities
//     $contractors = Contractor::orderBy('name', 'asc')->get();
//     $municipalities = Municipalities::orderBy('municipalityOf', 'asc')->get();

//     // Check if the request is for the overview page
//     if ($request->has('overview') && $request->overview == true) {
//         return response()->json([
//             'contractors' => $contractors,
//             'municipalities' => $municipalities
//         ]);
//     }

//     // Check if the request is for the dashboard (index page)
//     if ($request->has('dashboard') && $request->dashboard == true) {
//         return response()->json([
//             'contractors' => $contractors,
//             'municipalities' => $municipalities
//         ]);
//     }

//     // Pass both to the view for the system admin projects page
//     return view('systemAdmin.projects', [
//         'contractors' => $contractors,
//         'municipalities' => $municipalities
//     ]);
// }






}
