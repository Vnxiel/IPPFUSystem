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
use App\Models\FundsUtilization;
use App\Models\ProjectDescription;
use App\Models\ProjectFile;
use App\Models\PhysicalStatus;
use App\Models\VariationOrder;
use App\Models\ProjectTimeExtension;
use App\Models\FundsBreakdowns;
use Barryvdh\DomPDF\Facade\Pdf;

class ProjectManager extends Controller
{
    public function addProject(Request $request)
    {
        // Validate duplicates
        if (Project::where('fpp', $request->input('fpp'))
            ->where('responsibility_center', $request->input('responsibility_center'))
            ->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'A project with the same FPP and RC already exists.'
            ], 409);
        }
    
        $dynamicFields = collect($request->all())->filter(function ($_, $key) {
            return preg_match('/^(suspensionOrderNo|resumeOrderNo)\d+$/', $key);
        });
    
        // Extract remarks data
        $remarksData = [];
        foreach ($request->all() as $key => $value) {
            if (preg_match('/^(suspensionOrderNo|resumeOrderNo)(\d+)$/', $key, $matches)) {
                $index = $matches[2];
                $remarksData[$index] = [
                    'suspensionOrderRemarks' => trim($request->input("suspensionOrderNo{$index}Remarks")),
                    'resumeOrderRemarks' => trim($request->input("resumeOrderNo{$index}Remarks")),
                ];
            }
        }
    
        DB::beginTransaction();
    
        try {
            // Add missing dynamic columns
            if ($dynamicFields->isNotEmpty()) {
                Schema::table('projects', function (Blueprint $table) use ($dynamicFields) {
                    foreach ($dynamicFields as $field => $_) {
                        if (!Schema::hasColumn('projects', $field)) {
                            $table->string($field)->nullable();
                        }
                    }
                });
            }
    
            // Prepare standard project fields
            $excludedFields = [
                '_token', 'abc', 'orig_contract_amount', 'engineering', 'mqc',
                'contingency', 'bid', 'appropriation', 'description', 'ongoingDate',
            ];
            $projectData = $request->except($excludedFields);
            $projectData['reason_for_suspension'] = json_encode($remarksData);
            $projectData['physical_status'] = $request->input('physical_status');
            $projectData['ongoing_status'] = $request->input('ongoing_status');
          
            // Create project
            $project = new Project($projectData);
    
            foreach ($dynamicFields as $field => $value) {
                $project->{$field} = $value;
            }
    
            $project->save();

            // Save time extensions if present
            $extensionEntries = [];
            foreach ($request->all() as $key => $value) {
                if (preg_match('/^timeExtension(\d+)$/', $key, $matches)) {
                    $index = $matches[1];
            
                    $extensionEntries[$index] = [
                        'project_id' => $project->id,
                        'time_extension_no' => $index,
                        'time_extension_reason' => $request->input("extensionReason$index"),
                        'revised_expiry' => $request->input("revisedExpiry$index"),
                        'revised_expiry_reason' => $request->input("revisedReason$index"),
                        'time_extension' => $value,
                        'new_target_completion_date' => $request->input("revisedTargetDate$index"),
                    ];
                }
            }
            
            // Only insert once per time_extension_no
            foreach ($extensionEntries as $entry) {
                \App\Models\ProjectTimeExtension::create($entry);
            }
            
    
            if (!$project->exists) {
                throw new \Exception("Failed to save project data into the projects table.");
            }
    
            // Insert description lines
            $this->storeProjectDescriptions($project, $request->input('description'));
    
            // Fund utilization
            FundsUtilization::create([
                'project_id' => $project->id,
                'orig_abc' => $this->cleanMoney($request->input('abc')),
                'orig_contract_amount' => $this->cleanMoney($request->input('orig_contract_amount')),
                'orig_engineering' => $this->cleanMoney($request->input('engineering')),
                'orig_mqc' => $this->cleanMoney($request->input('mqc')),
                'orig_contingency' => $this->cleanMoney($request->input('contingency')),
                'orig_bid' => $this->cleanMoney($request->input('bid')),
                'orig_appropriation' => $this->cleanMoney($request->input('appropriation')),
                'orig_completion_date' => $request->input('actual_completion_date'),
            ]);
    
            // Project status (if ongoing)
            if (strtolower($request->input('physical_status')) === 'ongoing') {
                PhysicalStatus::create([
                    'project_id' => $project->id,
                    'progress' => $request->input('physical_status'),
                    'percentage' => (explode(' - ', $request->input('ongoing_status'))[0] ?? '0'),
                    'date' => $request->input('ongoingDate') ?? now(),
                ]);
            }
    
            // Session & activity logging
            $this->logUserAction($request, $project->title, 'Added a new project');
    
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Project added successfully!']);
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error adding project: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Error adding project. ' . $e->getMessage()]);
        }
    }


    protected function storeProjectDescriptions(Project $project, $description)
{
    if (empty($description)) return;

    $lines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $description)));
    foreach ($lines as $line) {
        ProjectDescription::create([
            'project_id' => $project->id,
            'projectID' => $project->projectID,
            'description' => $line,
        ]);
    }
}

protected function logUserAction(Request $request, $title, $actionPrefix)
{
    if (!session()->has('loggedIn')) {
        throw new \Exception('Session not found');
    }

    $sessionData = session()->get('loggedIn');
    $action = "{$actionPrefix}: {$title}";

    $request->session()->put('AddedNewProject', [
        'user_id' => $sessionData['user_id'],
        'ofmis_id' => $sessionData['ofmis_id'],
        'performed_by' => $sessionData['performed_by'],
        'role' => $sessionData['role'],
        'action' => $action,
    ]);

    Log::info("User action logged: " . json_encode($request->session()->get('AddedNewProject')));

    (new ActivityLogs)->userAction(
        $sessionData['user_id'],
        $sessionData['ofmis_id'],
        $sessionData['performed_by'],
        $sessionData['role'],
        $action
    );
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

        $projectEA = Project::select('engineer_name')
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

    return view('systemAdmin.projects', compact('mappedProjects', 'contractors', 'locations', 'source_of_funds', 'projectEA'));
}

public function fetchTrashedProjects()
{
    try {
        $projects = Project::where('is_hidden', 1)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($project) {
                $amount = optional($project->fundsUtilization)->orig_contract_amount;
                $formattedAmount = is_numeric($amount) ? number_format((float) $amount, 2) : '0.00';

                return [
                    'title' => $project->title ?? 'N/A',
                    'location' => $project->location ?? 'N/A',
                    'status' => $project->physical_status ?? 'N/A',
                    'amount' => $formattedAmount,
                    'contractor' => (strtolower($project->firm_name) === 'others')
                        ? ($project->othersContractor ?? 'N/A')
                        : ($project->firm_name ?? 'N/A'),
                    'duration' => $project->contract_days ? $project->contract_days . ' days' : 'N/A',
                    'action' => '<button class="btn btn-primary btn-sm restore-btn" data-id="' . $project->id . '">Restore</button>',
                ];
            });

        $role = auth()->user()->role;
        switch ($role) {
            case 'System Admin':
                $view = 'systemAdmin.trash';
                break;
            case 'Admin':
                $view = 'admin.trash';
                break;
            case 'Staff':
                $view = 'staff.trash';
                break;
            default:
                return redirect()->back()->withErrors(['Unauthorized role.']);
        }

        return view($view, compact('projects'));

    } catch (\Exception $e) {
        \Log::error('Error fetching trashed projects: ' . $e->getMessage());
        return back()->with('error', 'Failed to load trashed projects. Please try again.');
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
        $action = "Restored project: " . $project->title;
        (new ActivityLogs)->userAction(
            $sessionData['user_id'] ?? null,
            $sessionData['ofmis_id'] ?? null,
            $sessionData['performed_by'] ?? null,
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
            $contractors = Project::orderBy('firm_name')->get();
            $staticLocations = [ 
                'Alfonso Castañeda', 'Aritao', 'Bagabag', 'Bambang', 'Bayombong', 'Diadi',
                'Dupax del Norte', 'Dupax del Sur', 'Kasibu', 'Kayapa', 'Quezon', 'Solano',
                'Villaverde', 'Ambaguio', 'Santa Fe'
            ];
            
            $dbLocationsRaw = Project::select('location')
                ->whereNotNull('location')
                ->pluck('location')
                ->toArray();
            
                $dbLocations = array_map('trim', $dbLocationsRaw);

            // Merge, de-duplicate, and sort
            $locations = collect(array_merge($staticLocations, $dbLocations))
                ->unique()
                ->sort()
                ->values();
        
            $source_of_funds = Project::select('source_of_funds')->distinct()->whereNotNull('source_of_funds')->orderBy('source_of_funds')->get();
            $year = Project::select('year')->distinct()->whereNotNull('year')->orderBy('year')->get();
            $projectEA = Project::select('engineer_name')->distinct()->whereNotNull('engineer_name')->orderBy('engineer_name')->get();
    
            $projectData = Project::find($id);
    
            if (!$projectData) {
                return redirect()->back()->withErrors(['Project not found.']);
            }
            
    
            $project = $projectData->toArray();
            // Decode reason_for_suspension JSON
                $project['remarksData'] = [];
                if (!empty($projectData->reason_for_suspension)) {
                    $decodedRemarks = json_decode($projectData->reason_for_suspension, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $project['remarksData'] = $decodedRemarks;
                    } else {
                        Log::warning('Invalid JSON in reason_for_suspension', ['project_id' => $id]);
                    }
                }

            $project['physical_status'] = $projectData->physical_status ?? 'Not Available';
    
            $statuses = PhysicalStatus::where('project_id', $id)
                ->orderByDesc('date')
                ->orderByDesc('percentage')
                ->get();
    
            $projectStatusData = [
                'project_id' => $projectData->id,
                'physical_status' => $statuses->isEmpty() ? ($projectData->physical_status ?? 'No status available') : $statuses->first()->progress,
                'updatedAt' => $statuses->isEmpty() ? optional($projectData->updated_at)->format('Y-m-d') : $statuses->first()->date,
                'latestPercentage' => $statuses->isEmpty() ? $projectData->percentage : $statuses->first()->percentage,
                'latestDate' => $statuses->isEmpty() ? $projectData->date : $statuses->first()->date,
                'ongoing_status' => $statuses->map(function ($status) {
                    return [
                        'progress' => $status->progress,
                        'percentage' => $status->percentage,
                        'date' => $status->date,
                    ];
                })->toArray()
            ];
    
            if (strtolower($project['physical_status']) === 'ongoing') {
                $physical_status = $statuses->first();
                if ($physical_status) {
                    $percentage = rtrim($physical_status->percentage, '%');
                    $formattedDate = $physical_status->date ? \Carbon\Carbon::parse($physical_status->date)->format('F d, Y') : 'Unknown date';
                    $project['ongoing_status'] = $percentage . '% - ' . $formattedDate;
                } else {
                    $project['ongoing_status'] = 'Not Available';
                }
            } else {
                $project['ongoing_status'] = null;
            }
    
            $project['description'] = ProjectDescription::where('project_id', $id)
                ->pluck('description')->toArray();
    
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
                            Log::info('Summary data fetched successfully.', [
                                'project_id' => $id,
                                'summary' => $decodedSummary
                            ]);
                        } else {
                            error_log('Summary JSON decode error: ' . json_last_error_msg());
                            Log::warning('Summary JSON decode error.', [
                                'project_id' => $id,
                                'error' => json_last_error_msg()
                            ]);
                        }
                    } elseif (is_array($fundUtilization->summary)) {
                        $project['summary'] = $fundUtilization->summary;
                        Log::info('Summary array fetched successfully.', [
                            'project_id' => $id,
                            'summary' => $fundUtilization->summary
                        ]);
                    }
                }
                
                $project['partial_billings'] = [];
                
                if (isset($fundUtilization->partial_billings)) {
                    if (is_string($fundUtilization->partial_billings)) {
                        $decodedBillings = json_decode($fundUtilization->partial_billings, true);
                        if (json_last_error() === JSON_ERROR_NONE) {
                            $project['partial_billings'] = $decodedBillings;
                            Log::info('Partial billings fetched successfully.', [
                                'project_id' => $id,
                                'partial_billings' => $decodedBillings
                            ]);
                        } else {
                            error_log('Partial billings JSON decode error: ' . json_last_error_msg());
                            Log::warning('Partial billings JSON decode error.', [
                                'project_id' => $id,
                                'error' => json_last_error_msg()
                            ]);
                        }
                    } elseif (is_array($fundUtilization->partial_billings)) {
                        $project['partial_billings'] = $fundUtilization->partial_billings;
                        Log::info('Partial billings array fetched successfully.', [
                            'project_id' => $id,
                            'partial_billings' => $fundUtilization->partial_billings
                        ]);
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
                    // Fetch engineering and mqc from database
                    $engineeringEntries = FundsBreakdowns::where('funds_utilization_id', $fundUtilization->id)
                    ->where('type', 'engineering')
                    ->orderBy('created_at', 'desc')
                    ->get();
                    

                    \Log::info('Debug engineering entries', [
                        'fund_utilization_id' => $fundUtilization->project_id ?? null,
                        'engineering_count' => $engineeringEntries->count(),
                        'entries' => $engineeringEntries->toArray()
                    ]);
                    
                

            $mqcEntries = FundsBreakdowns::where('funds_utilization_id', $fundUtilization->id)
                ->where('type', 'mqc')
                ->orderBy('created_at', 'desc')
                ->get();


            $timeExtensions = ProjectTimeExtension::where('project_id', $id)
                ->get();
    
            
                
                
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
    
            return view($view, compact('contractors', 'project', 'locations', 'source_of_funds', 'year', 'timeExtensions', 'projectEA', 'projectStatusData', 'engineeringEntries', 'mqcEntries'));
    
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
            $ongoingProjects = $visibleProjects->clone()->where('physical_status', 'Ongoing')->count();
            $completedProjects = $visibleProjects->clone()->where('physical_status', 'Completed')->count();
            $discontinuedProjects = $visibleProjects->clone()->where('physical_status', 'Cancelled')->count();
            $toBeStartedProjects = $visibleProjects->clone()->where('physical_status', 'Not Started')->count();
            $suspendedProjects = $visibleProjects->clone()->where('physical_status', 'Suspended')->count();

            $projects = $visibleProjects->get();
            
            $totalBudget = 0;
            $totalUsed = 0;
            
            foreach ($projects as $project) {
                // Try to find a FundsUtilization entry for this project
                $funds = FundsUtilization::where('project_id', $project->id)->first();
            
                // Use FundsUtilization values if available, otherwise fallback to Project values
                $abc = $funds ? $funds->orig_abc : $project->abc;
                $orig_contract_amount = $funds ? $funds->orig_contract_amount : $project->orig_contract_amount;
            
                $totalBudget += (float) preg_replace('/[^0-9.]/', '', $abc ?? '0');
                $totalUsed += (float) preg_replace('/[^0-9.]/', '', $orig_contract_amount ?? '0');
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
    
            $newProjectID = $request->input('projectID');
    
            $dynamicFields = collect($request->all())->filter(function ($_, $key) {
                return preg_match('/^(suspensionOrderNo|resumeOrderNo)\d*$/', $key);
            });
    
            $remarksData = [];
            foreach ($request->all() as $key => $value) {
                if (preg_match('/^(suspensionOrderNo|resumeOrderNo)(\d+)$/', $key, $matches)) {
                    $index = $matches[2];
                    $remarksData[$index] = [
                        'suspensionOrderRemarks' => trim($request->input("suspensionOrderNo{$index}Remarks")),
                        'resumeOrderRemarks' => trim($request->input("resumeOrderNo{$index}Remarks")),
                    ];
                }
            }
    
            $oldValues = [];
            $oldFundValues = [];
    
            \DB::transaction(function () use (
                $request, $id, $newProjectID, $dynamicFields, $remarksData, 
                &$oldValues, &$oldFundValues
            ) {
                $project = Project::find($id);
                if (!$project) {
                    throw new \Exception('Project not found.');
                }
    
                $oldValues = $project->only([
                    'title', 'location', 'projectID', 'firm_name',
                    'source_of_funds', 'mode_of_implementation', 'actual_length',
                    'physical_status', 'ongoing_status', 'contract_days',
                    'noa_issued_date', 'noa_received_date', 'ntp_issued_date', 'ntp_received_date',
                    'official_starting_date', 'target_completion_date', 'timeExtension', 'revised_target_date', 
                    'revisedCompletionDate', 'actual_completion_date', 'project_slippage',
                    'engineer_name', 'engineer_position', 'year', 'fpp', 'responsibility_center',
                    'reason_for_suspension'
                ]);
    
                $project->fill($request->only(array_keys($oldValues)));
                $project->revised_target_date = $request->input('revised_target_date');
                $project->revisedCompletionDate = $request->input('revisedCompletionDate');
                Log::debug('revised_target_date:', [$request->input('revised_target_date')]);
                Log::debug('revisedCompletionDate:', [$request->input('revisedCompletionDate')]);
                
    
                foreach ($dynamicFields as $field => $value) {
                    if (\Schema::hasColumn('projects', $field)) {
                        $project->$field = $value;
                    }
                }
    
                $project->reason_for_suspension = json_encode($remarksData);
                $project->save();

               
                $extensionEntries = [];
                // ---Time Extension ---
                    // No deletion here — only update existing or create new

                    // ---Time Extension Update / Create---
                            if ($request->has('time_extensions')) {
                                foreach ($request->input('time_extensions') as $index => $ext) {
                                    if (empty($ext['days']) && empty($ext['reason']) && empty($ext['revised']) && empty($ext['revised_reason'])) {
                                        continue; // Skip empty rows
                                    }

                                    ProjectTimeExtension::updateOrCreate(
                                        [
                                            'project_id' => $project->id,
                                            'time_extension_no' => $index + 1, // assumes 0-based index from JS
                                        ],
                                        [
                                            'time_extension' => $ext['days'],
                                            'time_extension_reason' => $ext['reason'],
                                            'revised_expiry' => $ext['revised'],
                                            'revised_expiry_reason' => $ext['revised_reason'],
                                            'new_target_completion_date' => $request->input('revised_target_date'),
                                        ]
                                    );
                                }
                            }

    
                $description = $request->input('description');
                if (!empty($description)) {
                    $newLines = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $description)));
                    $newCombined = implode(' ', $newLines);
                    $existingDescriptions = ProjectDescription::where('project_id', $project->id)
                        ->pluck('description')
                        ->toArray();
                    $existingCombined = implode(' ', array_map('trim', $existingDescriptions));
    
                    similar_text($existingCombined, $newCombined, $percentSimilarity);
                    if ($percentSimilarity < 95) {
                        ProjectDescription::where('project_id', $project->id)->delete();
                        foreach ($newLines as $line) {
                            ProjectDescription::create([
                                'project_id' => $project->id,
                                'projectID' => $project->projectID,
                                'description' => $line
                            ]);
                        }
                    }
                }
    
                $fundsOld = FundsUtilization::where('project_id', $id)->first();
                $oldFundValues = [
                    'abc' => $fundsOld->orig_abc ?? null,
                    'orig_contract_amount' => $fundsOld->orig_contract_amount ?? null,
                    'engineering' => $fundsOld->orig_engineering ?? null,
                    'mqc' => $fundsOld->orig_mqc ?? null,
                    'contingency' => $fundsOld->orig_contingency ?? null,
                    'bid' => $fundsOld->orig_bid ?? null,
                    'appropriation' => $fundsOld->orig_appropriation ?? null,
                ];
    
                $funds = FundsUtilization::firstOrNew(['project_id' => $project->id]);
                $funds->orig_abc = $this->cleanMoney($request->input('abc'));
                $funds->orig_contract_amount = $this->cleanMoney($request->input('orig_contract_amount'));
                $funds->orig_engineering = $this->cleanMoney($request->input('engineering'));
                $funds->orig_mqc = $this->cleanMoney($request->input('mqc'));
                $funds->orig_contingency = $this->cleanMoney($request->input('contingency'));
                $funds->orig_bid = $this->cleanMoney($request->input('bid'));
                $funds->orig_appropriation = $this->cleanMoney($request->input('appropriation'));
                $funds->save();
            });
    
            // After transaction
            $project = Project::find($id);
            $newValues = $project->only(array_keys($oldValues));
            $changes = [];
    
            foreach ($oldValues as $key => $oldValue) {
                $newValue = $newValues[$key];
                if ($oldValue != $newValue) {
                    $changes[] = "$key: '$oldValue' -> '$newValue'";
                }
            }
    
            $sessionData = session('loggedIn', []);
            $title = $request->input('title');
    
            foreach ($oldValues as $key => $oldValue) {
                $newValue = $newValues[$key];
                if ($oldValue != $newValue) {
                    $action = "Updated $key in project: $title — from '$oldValue' to '$newValue'";
                    (new ActivityLogs)->userAction(
                        $sessionData['user_id'] ?? null,
                        $sessionData['ofmis_id'] ?? null,
                        $sessionData['performed_by'] ?? null,
                        $sessionData['role'] ?? null,
                        $action
                    );
                }
            }
    
            // Log fund changes
            $newFundValues = [
                'abc' => $request->input('abc'),
                'orig_contract_amount' => $request->input('orig_contract_amount'),
                'engineering' => $request->input('engineering'),
                'mqc' => $request->input('mqc'),
                'contingency' => $request->input('contingency'),
                'bid' => $request->input('bid'),
                'appropriation' => $request->input('appropriation'),
            ];
    
            foreach ($oldFundValues as $key => $oldValue) {
                $newValue = $this->cleanMoney($newFundValues[$key] ?? null);
                if ($oldValue != $newValue) {
                    $action = "Updated $key in project: $title — from '$oldValue' to '$newValue'";
                    (new ActivityLogs)->userAction(
                        $sessionData['user_id'] ?? null,
                        $sessionData['ofmis_id'] ?? null,
                        $sessionData['performed_by'] ?? null,
                        $sessionData['role'] ?? null,
                        $action
                    );
                }
            }
    
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
            $action = "Archived project: " . $project->title;
            (new ActivityLogs)->userAction(
                $sessionData['user_id'] ?? null,
                $sessionData['ofmis_id'] ?? null,
                $sessionData['performed_by'] ?? null,
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

        if (in_array($project->physical_status, ['Completed', 'Discontinued'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot add status to a completed or discontinued project.'
            ], 403);
        }

        $latestStatus = PhysicalStatus::where('project_id', $request->project_id)
            ->orderByDesc('date')
            ->orderByDesc('percentage')
            ->first(); 

        DB::beginTransaction();

        PhysicalStatus::insert([
            'project_id' => $request->project_id,
            'progress' => $request->progress,
            'percentage' => $request->percentage,
            'date' => $request->date,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $ongoing_status = $request->percentage . ' - ' . $request->date;

        Project::where('id', $request->project_id)
            ->update([
                'physical_status' => $request->progress,
                'ongoing_status' =>$request->percentage,
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

}
