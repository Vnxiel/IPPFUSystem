@extends('systemAdmin.layout')

@section('title', 'Overview Page')

@section('content')
<!-- Project Overview -->
<hr class="mx-2">
<div class="container-fluid mt-5" >
    <div class="row">
        <div class="col-md-12 d-flex align-items-center justify-content-between mb-3" style="margin-top:25px;">
            <div class="d-flex align-items-center gap-2">
                <a id="back-to-projects" class="btn btn-outline-secondary btn-sm"
                        href="{{ url('/systemAdmin/projects') }}">
                    <span class="fa fa-arrow-left"></span>
                </a>

                <h5 class="m-0">Project Overview</h5>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
            <div class="card-header bg-light border-bottom  d-flex justify-content-between align-items-center">
                <h4 class="mb-0">{{ $project['projectTitle'] ?? 'N/A' }}</h4>

                <div class="d-flex gap-2">
                    <button type="button" id="editProjectBtn" class="btn btn-warning btn-sm d-flex align-items-center gap-1"
                        data-bs-toggle="modal" data-bs-target="#projectModal" title="Edit Project Details">
                        <i class="fa fa-edit"></i>
                        <span class=" d-md-inline">Edit</span>
                    </button>

                    <button type="button" id="trashProjectBtn" class="btn btn-danger btn-sm d-flex align-items-center gap-1"
                        data-bs-toggle="modal" data-bs-target="#trashModal" title="Archive Project">
                        <i class="fa fa-trash"></i>
                        <span class=" d-md-inline">Archive</span>
                    </button>
                </div>
            </div>


            <div class="card-body">
                <div class="row gy-4">
                    <!-- Column 1 -->
                    <div class="col-md-4">
                        <div class="col-md-12" >
                            <div class="row">
                                <div class="col-md-4" >
                                    <strong class="d-block text-end">Project ID:</strong>
                                </div>
                                <div class="col-md-8" >
                                    <span style="font-weight: normal;">{{ $project['projectID'] ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" >
                            <div class="row">
                                <div class="col-md-4" >
                                    <strong class="d-block text-end">Location:</strong>
                                </div>
                                <div class="col-md-8" >
                                    <span style="font-weight: normal;">{{ $project['projectLoc'] ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" >
                            <div class="row">
                                <div class="col-md-4" >
                                    <strong class="d-block text-end">Contractor:</strong>
                                </div>
                                <div class="col-md-8" >
                                    <span style="font-weight: normal;">{{ $project['projectContractor'] ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" >
                            <div class="row">
                                <div class="col-md-4" >
                                    <strong class="d-block text-end">Project Year:</strong>
                                </div>
                                <div class="col-md-8" >
                                    <span style="font-weight: normal;">{{ $project['projectYear'] ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" >
                            <div class="row">
                                <div class="col-md-4" >
                                    <strong class="d-block text-end">Project FPP:</strong>
                                </div>
                                <div class="col-md-8" >
                                    
                                    <span style="font-weight: normal;">{{ $project['projectFPP'] ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" >
                            <div class="row">
                                <div class="col-md-4" >
                                    <strong class="d-block text-end">Project Engineer:</strong>
                                </div>
                                <div class="col-md-8" >
                                    <span style="font-weight: normal;">{{ $project['ea'] ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="col-md-4">
                        <div class="mb-2">
                            <strong class="d-block">Contract Days:  <span style="font-weight: normal;">{{ $project['projectContractDays'] ?? 'N/A' }} (Calendar days)</span> </strong>
                        </div>
                        <div class="mb-2">
                            <strong class="d-block">Source of Fund:  <span style="font-weight: normal;">
                                {{ ($project['sourceOfFunds'] ?? '') === 'Others' ? ($project['otherFund'] ?? 'N/A') : ($project['sourceOfFunds'] ?? 'N/A') }}
                            </span></strong>
                           
                        </div>
                        <div class="mb-2">
                            <strong class="d-block">Responsibility Center:  <span style="font-weight: normal;">{{ $project['projectRC'] ?? 'N/A' }}</span></strong>  
                        </div>

                        @php
                            $ongoingStatus = $projectStatusData['ongoingStatus'] ?? [];
                            $totalPercentage = is_array($ongoingStatus) ? array_sum(array_column($ongoingStatus, 'percentage')) : 0;
                            $latestDate = is_array($ongoingStatus) && count($ongoingStatus) > 0
                                ? end($ongoingStatus)['date']
                                : null;
                        @endphp

                    <!-- Project Status Display -->
                    <div class="mb-2 d-flex align-items-center">
                        <strong class="me-2">
                            Status:
                            <span class="badge bg-success me-2" style="font-weight: normal;">
                                {{ $project['projectStatus'] ?? 'N/A' }}
                            </span>
                            <small style="font-weight: normal;">
                                {{ $totalPercentage }}% Completed
                                @if ($latestDate)
                                    as of {{ \Carbon\Carbon::parse($latestDate)->format('F j, Y') }}
                                @endif
                            </small>
                        </strong>
                    </div>
                    <div>
                            <strong>Slippage:
                            <span class="badge bg-danger ms-2">{{ $project['projectSlippage'] ?? 'N/A' }}</span></strong>
                        </div>
                 </div>
                    <!-- Column 3 - Progress Table -->
                    <div class="col-md-4">
                    <div class="bg-light p-2 d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-bar-chart-line me-2"></i><strong>Progress</strong></span>

                            @if ($totalPercentage < 100)

                                <button type="button" class="btn btn-sm btn-outline-primary" id="addStatusBtn">
                                    <i class="bi bi-plus-circle me-1"></i>Add
                                </button>
                            @endif
                        </div>

                        <!-- Scrollable Table Wrapper -->
                        <div class="table-responsive" style="max-height: 180px; overflow-y: auto;">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Progress</th>
                                        <th>Percentage</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($ongoingStatus) && is_array($ongoingStatus))
                                        @foreach ($ongoingStatus as $status)
                                            <tr>
                                                <td>{{ $status['progress'] }}</td>
                                                <td>{{ $status['percentage'] }}%</td>
                                                <td>{{ $status['date'] }}</td>
                                            </tr>
                                        @endforeach
                                    @elseif ($projectStatusData['projectStatus'] === 'Completed')
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">This project is completed.</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No progress data available.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-12">
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="fw-bold m-0">Project Description & Implementation Details</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3">
                                        <!-- Left Column: Project Description -->
                                        <div class="col-md-6">
                                            <fieldset class="border p-3 rounded shadow-sm h-100">
                                                <legend class="float-none w-auto px-2 fw-bold text-primary">Project Description</legend>
                                                <ul class="list-unstyled ps-3 mb-3">
                                                    @foreach ($project['projectDescriptions'] ?? [] as $desc)
                                                        <li class="mb-1">• {{ $desc }}</li>
                                                    @endforeach
                                                </ul>
                                            </fieldset>
                                        </div>

                                        <div class="col-md-6 font-base">
                                        <fieldset class="border p-3 rounded shadow-sm h-100">
                                            <legend class="float-none w-auto px-2 fw-bold text-primary">Implementation Details</legend>

                                            {{-- Row: Implementation Mode --}}
                                            <div class="row mb-3">
                                                <div class="col-md-12" >
                                                    <div class="row">
                                                        <div class="col-md-4" >
                                                            <strong class="d-block text-end">Implementation Mode:</strong>
                                                        </div>
                                                        <div class="col-md-8" >
                                                            <span style="font-weight: normal;">{{ $project['modeOfImplementation'] ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12" >
                                                    <div class="row">
                                                        <div class="col-md-4" >
                                                         </div>
                                                        <div class="col-md-4" >
                                                            <span style="font-weight: bold;">Issued Date</span>
                                                        </div>
                                                        <div class="col-md-4" >
                                                            <span style="font-weight: bold;">Received Date</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Row: NOA--}}
                                            <div class="row mb-3">
                                                <div class="col-md-12" >
                                                    <div class="row">
                                                        <div class="col-md-4" >
                                                            <strong class="d-block text-end">Notice of Award:</strong>
                                                        </div>
                                                        <div class="col-md-4" >
                                                            <span style="font-weight: normal;">{{ $project['noaIssuedDate'] ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="col-md-4" >
                                                            <span style="font-weight: normal;">{{ $project['noaReceivedDate'] ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- Row: NTP--}}
                                            <div class="row mb-3">
                                                <div class="col-md-12" >
                                                    <div class="row">
                                                        <div class="col-md-4" >
                                                            <strong class="d-block text-end">Notice to Proceed:</strong>
                                                        </div>
                                                        <div class="col-md-4" >
                                                            <span style="font-weight: normal;">{{ $project['ntpIssuedDate'] ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="col-md-4" >
                                                            <span style="font-weight: normal;">{{ $project['ntpReceivedDate'] ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>        

                                            {{-- Row: Original Start Date & Target Completion Date --}}
                                            <div class="row mb-3">
                                                <div class="col-md-12" >
                                                    <div class="row">
                                                        <div class="col-md-4" >
                                                            <strong class="d-block text-end">Original Starting Date:</strong>
                                                        </div>
                                                        <div class="col-md-8" >
                                                            <span style="font-weight: normal;">{{ $project['originalStartDate'] ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>   
                                            <div class="row mb-3">
                                                <div class="col-md-12" >
                                                    <div class="row">
                                                        <div class="col-md-4" >
                                                            <strong class="d-block text-end">Target Completion Date:</strong>
                                                        </div>
                                                        <div class="col-md-8" >
                                                            <span style="font-weight: normal;">{{ $project['targetCompletion'] ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>     
                                            <div class="row mb-3">
                                                <div class="col-md-12" >
                                                    <div class="row">
                                                        <div class="col-md-4" >
                                                            <strong class="d-block text-end" style="white-space: nowrap;">Actual Date of Completion:</strong>
                                                        </div>
                                                        <div class="col-md-8" >
                                                            <span style="font-weight: normal;">{{ $project['completionDate'] ?? 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>      
                                            @php
                                                $hasSuspension = false;

                                                // Decode suspension remarks JSON
                                                $remarksData = json_decode($project['suspensionRemarks'], true) ?? [];

                                                // Collect available suspension indices
                                                $indices = [];
                                                foreach ($project as $key => $val) {
                                                    if (preg_match('/(?:suspensionOrderNo|resumeOrderNo)(\d+)/', $key, $matches)) {
                                                        $indices[] = (int)$matches[1];
                                                    }
                                                }
                                                $uniqueIndices = array_unique($indices);
                                                sort($uniqueIndices);
                                            @endphp

                                            @foreach ($uniqueIndices as $index)
                                                @php
                                                    $suspKey = "suspensionOrderNo{$index}";
                                                    $resumeKey = "resumeOrderNo{$index}";

                                                    $suspensionValue = $project[$suspKey] ?? null;
                                                    $resumeValue = $project[$resumeKey] ?? null;
                                                    $remarks = $remarksData[$index]['suspensionOrderRemarks'] ?? null;

                                                    $shouldShow = isset($suspensionValue) || isset($resumeValue) || isset($remarks);

                                                    if ($shouldShow) $hasSuspension = true;
                                                @endphp

                                                @if ($shouldShow)
                                                    {{-- Row: Suspension and Resume Order --}}
                                                    <div class="row mb-3">  
                                                        <div class="col-md-4 text-end fw-bold">Suspension Order No. {{ $index }}:</div>
                                                        <div class="col-md-2">{{ $suspensionValue ?? 'N/A' }}</div>
                                                        <div class="col-md-4 text-end fw-bold">Resume Order No. {{ $index }}:</div>
                                                        <div class="col-md-2">{{ $resumeValue ?? 'N/A' }}</div>
                                                    </div>

                                                    {{-- Row: Suspension Remarks --}}
                                                    <div class="row mb-3">
                                                        <div class="col-md-4 text-end fw-bold">Suspension Remarks:</div>
                                                        <div class="col-md-8">{{ $remarks ?? 'N/A' }}</div>
                                                    </div>
                                                @endif
                                            @endforeach


                                            {{-- Time Extension, Revised Target & Completion Dates --}}
                                            @if ($hasSuspension)
                                                <div class="row mb-3">
                                                    <div class="col-md-4 text-end fw-bold">Time Extension:</div>
                                                    <div class="col-md-8">{{ $project['timeExtension'] ?? 'N/A' }}</div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-4 text-end fw-bold">Revised Target Completion:</div>
                                                    <div class="col-md-2">{{ $project['revisedTargetDate'] ?? 'N/A' }}</div>
                                                    <div class="col-md-4 text-end fw-bold">Revised Completion Date:</div>
                                                    <div class="col-md-2">{{ $project['revisedCompletionDate'] ?? 'N/A' }}</div>
                                                </div>
                                            @endif
                                        </fieldset>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                        <div class="col-md-12">
                            <!-- Combined Card with Two Columns -->
                            <div class="card shadow-sm">
                                <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">   
                                <a href="{{ route('project.fund-utilization', ['project_id' => $project['id']]) }}"
                                    class="btn btn-primary btn-sm d-flex align-items-center gap-2 ms-auto"
                                    title="Add Fund Utilization Details">
                                        <i class="fa fa-plus"></i>
                                        <span class=" d-md-inline">Add Fund Utilization</span>
                                    </a>



                                </div>
                            
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Cost Breakdown -->
                                            <fieldset class="border p-3 mb-4 rounded shadow-sm">
                                            <legend class="float-none w-auto px-2 fw-bold text-primary">Cost Breakdown</legend>
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-striped text-center align-middle" id="costBreakdownTable">
                                                <thead class="table-light">
                                                    <tr>
                                                    <th>Category</th>
                                                    <th>Proposed</th>
                                                    <!-- V.O. headers will be dynamically inserted here -->
                                                    <th id="voHeadersPlaceholder"></th>
                                                    <th>Actual</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>Appropriation</td>
                                                    <td id="orig_appropriation_view">{{ number_format($projects->orig_appropriation ?? 0, 2) }}</td>
                                                    <!-- Dynamic VO cells for Appropriation -->
                                                    <!-- Each <td> will be appended inside this cell -->
                                                    <td class="vo_cells_row" data-field="appropriation"></td>
                                                    <td id="actual_appropriation_view"></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Contract Amount</td>
                                                    <td id="orig_contract_amount_view"></td>
                                                    <td class="vo_cells_row" data-field="contract_amount"></td>
                                                    <td id="actual_contract_amount_view"></td>
                                                    </tr>
                                                    <tr>
                                                    <td>ABC</td>
                                                    <td id="orig_abc_view"></td>
                                                    <td class="vo_cells_row" data-field="abc"></td>
                                                    <td id="actual_abc_view"></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Bid Difference</td>
                                                    <td id="orig_bid_view"></td>
                                                    <td class="vo_cells_row" data-field="bid"></td>
                                                    <td id="actual_bid_view"></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Engineering</td>
                                                    <td id="orig_engineering_view"></td>
                                                    <td class="vo_cells_row" data-field="engineering"></td>
                                                    <td id="actual_engineering_view"></td>
                                                    </tr>
                                                    <tr>
                                                    <td>MQC</td>
                                                    <td id="orig_mqc_view"></td>
                                                    <td class="vo_cells_row" data-field="mqc"></td>
                                                    <td id="actual_mqc_view"></td>
                                                    </tr>
                                                    <tr>
                                                    <td>Contingency</td>
                                                    <td id="orig_contingency_view"></td>
                                                    <td class="vo_cells_row" data-field="contingency"></td>
                                                    <td id="actual_contingency_view"></td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </div>
                                            </fieldset>


                                        </div>
                                        
                                <!-- Right Column: Implementation Details -->
                                <div class="col-md-6 font-base">
                                    <fieldset class="border p-3 mb-4 rounded shadow-sm">
                                    <legend class="float-none w-auto px-2 fw-bold text-primary">Fund Utilization Summary</legend>
                                   

                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped text-center align-middle">
                                        <thead class="table-light">
                                            <tr>
                                            <th>Category</th>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                            <td>Mobilization</td>
                                            <td id="dateMobi_view"></td>
                                            <td id="amountMobi_view"></td>
                                            <td id="remMobi_view"></td>
                                            </tr>
                                            <tr>
                                            <tbody id="partialBillingsRows"></tbody>
                                            </tr>
                                    
                                            <tr>
                                            <td>Final Billing</td>
                                            <td id="dateFinal_view"></td>
                                            <td id="amountFinal_view"></td>
                                            <td id="remFinal_view"></td>
                                            </tr>
                                            <tr>
                                            <td>Engineering</td>
                                            <td id="dateEng_view"></td>
                                            <td id="amountEng_view"></td>
                                            <td id="remEng_view"></td>
                                            </tr>
                                            <tr>
                                            <td>MQC</td>
                                            <td id="dateMqc_view"></td>
                                            <td id="amountMqc_view"></td>
                                            <td id="remMqc_view"></td>
                                            </tr>
                                            <tr class="fw-bold">
                                            <td>Total Expenditures</td>
                                            <td>-</td>
                                            <td id="amountTotal_view"></td>
                                            <td id="remTotal_view"></td>
                                            </tr>
                                            <tr class="fw-bold">
                                            <td>Total Savings</td>
                                            <td>-</td>
                                            <td id="amountSavings_view"></td>
                                            <td id="remSavings_view"></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                    </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>       
            </div>
        </div>
    </div>
</div>
           



    <!-- file Manment -->
    <div class="row font-content mt-2">
    <div class="col-md-12">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="icon-circle me-3" style="background: rgba(158, 158, 158, 0.1); padding: 12px; border-radius: 50%;">
                        <i class="fas fa-archive" style="font-size: 16px; color: #757575;"></i>
                    </div>
                    <div>
                        <h4 class="mb-0">Project Files</h4>
                    </div>
                </div>
                <button type="button" class="btn btn-success btn-sm d-flex align-items-center gap-1"
                    data-bs-toggle="modal" data-bs-target="#uploadModal" title="Upload Files">
                    <i class="fa fa-upload"></i>
                    <span class=" d-md-inline">Upload</span>
                </button>
            </div>
            <div class="card-body p-2">
                <div class="table-responsive">
                    <div class="row projectInfo">
                        <div class="table-container table-responsive">
                            <table id="projectFiles" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>File Name</th>
                                        <th>Type</th>
                                        <th>Uploaded By</th>
                                        <th>Upload Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>        

<script>
    // Store the project ID in sessionStorage before going back
    document.getElementById('back-to-projects').addEventListener('click', function () {
        const projectId = '{{ $project->id ?? null }}';
        if (projectId) {
            localStorage.setItem('highlighted_project_id', projectId);
            // Optional: Reset scroll on reload to prevent jumping to page 1
            localStorage.setItem('highlighted_project_page', 'preserve');
        }
    });

   // Function to toggle the visibility of the 'otherFundContainer' when 'Others' is selected in 'Source of Fund'
function toggleOtherFund() {
    const sourceOfFunds = document.getElementById("sourceOfFunds").value;
    const otherFundContainer = document.getElementById("otherFundContainer");
    
    if (sourceOfFunds === "Others") {
        otherFundContainer.style.display = "block"; // Show the input field for specifying the fund
    } else {
        otherFundContainer.style.display = "none"; // Hide the input field if not selected
    }
}

// Function to toggle the visibility of the 'othersContractorDiv' when 'Others' is selected in 'Contractor'
function toggleOtherContractor() {
    const projectContractor = document.getElementById("projectContractor").value;
    const othersContractorDiv = document.getElementById("othersContractorDiv");
    
    if (projectContractor === "Others") {
        othersContractorDiv.style.display = "block"; // Show the input field for specifying the contractor
    } else {
        othersContractorDiv.style.display = "none"; // Hide the input field if not selected
    }
}

// Ensure the correct visibility when the page loads, in case the 'Others' option was already selected in any dropdown
document.addEventListener("DOMContentLoaded", function() {
    toggleOtherFund(); // Check if 'Others' was selected for Source of Fund
    toggleOtherContractor(); // Check if 'Others' was selected for Contractor
});

    </script>

<script>
    
     document.addEventListener("DOMContentLoaded", function () {
        const currencyInputs = document.querySelectorAll(".currency-input");

        currencyInputs.forEach(input => {
            // On focus: strip formatting for easier editing
            input.addEventListener("focus", function () {
                const raw = parseCurrency(input.value);
                input.value = raw ? raw : ''; // Keep blank if zero
            });

            // On blur: format unless it's empty
            input.addEventListener("blur", function () {
                if (input.id !== 'bid') {
                    const raw = parseCurrency(input.value);
                    input.value = raw ? formatCurrency(raw) : '';
                }
                updateBidDifference();
            });

            // Format pre-filled values
            if (input.value.trim() !== "") {
                input.dispatchEvent(new Event("blur"));
            }
        });

        function parseCurrency(value) {
            return parseFloat(value.replace(/[^0-9.]/g, "")) || 0;
        }

        function formatCurrency(value) {
            return value.toLocaleString("en-PH", {
                style: "currency",
                currency: "PHP",
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function updateBidDifference() {
            const abcInput = document.getElementById('abc');
            const contractInput = document.getElementById('contractAmount');
            const bidInput = document.getElementById('bid');

            const abc = parseCurrency(abcInput.value);
            const contractAmount = parseCurrency(contractInput.value);

            // Only calculate if both fields are filled
            if (abcInput.value.trim() !== '' && contractInput.value.trim() !== '') {
                const bidDifference = abc - contractAmount;
                bidInput.value = bidDifference !== 0 ? formatCurrency(bidDifference) : formatCurrency(0);
            } else {
                bidInput.value = '';
            }
        }

        // Trigger calculation while typing
        document.getElementById('abc').addEventListener('input', updateBidDifference);
        document.getElementById('contractAmount').addEventListener('input', updateBidDifference);
    });

    </script>



<script>
let orderCount = 1;

// Function to add order fields dynamically
function addOrderFields() {
    orderCount++;
    const container = document.getElementById('orderContainer');

    const newSet = document.createElement('div');
    newSet.classList.add('row', 'order-set');
    newSet.id = `orderSet${orderCount}`;
    newSet.innerHTML = `
        <div class="col-md-6">
            <div class="mb-1">
                <label for="suspensionOrderNo${orderCount}" class="form-label">Suspension Order No. ${orderCount}</label>
                <input type="date" class="form-control" id="suspensionOrderNo${orderCount}" name="suspensionOrderNo${orderCount}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-1">
                <label for="resumeOrderNo${orderCount}" class="form-label">Resumption Order No. ${orderCount}</label>
                <input type="date" class="form-control" id="resumeOrderNo${orderCount}" name="resumeOrderNo${orderCount}">
            </div>
        </div>
    `;

    container.appendChild(newSet);

    // Attach event listeners to the new input fields
    const suspensionOrderNo = document.getElementById(`suspensionOrderNo${orderCount}`);
    const resumeOrderNo = document.getElementById(`resumeOrderNo${orderCount}`);

    suspensionOrderNo.addEventListener('change', function() {
        validateOrderDates(orderCount);
    });
    
    resumeOrderNo.addEventListener('change', function() {
        validateOrderDates(orderCount);
    });
}

// Function to remove last order fields dynamically
function removeLastOrderFields() {
    if (orderCount > 1) {
        const lastSet = document.getElementById(`orderSet${orderCount}`);
        lastSet.remove();
        orderCount--;
    } else {
        Swal.fire({
            icon: "warning",
            title: "Oops...",
            text: "You must keep at least one order pair. If none leave it blank.",
        });
    }
}

// Function to validate that resumeOrderNo is not earlier than or equal to suspensionOrderNo
function validateOrderDates(orderId) {
    const suspensionOrderNo = document.getElementById(`suspensionOrderNo${orderId}`);
    const resumeOrderNo = document.getElementById(`resumeOrderNo${orderId}`);
    
    const suspensionDate = new Date(suspensionOrderNo.value);
    const resumeDate = new Date(resumeOrderNo.value);

    if (resumeDate <= suspensionDate && resumeOrderNo.value !== '') {
        Swal.fire({
            icon: "error",
            title: "Invalid Date",
            text: "The resumption order date must be later than the suspension order date.",
        });
        resumeOrderNo.value = ''; // Clear the resume order field
    }
}

// Initial validation for the first order pair when the page loads
document.addEventListener("DOMContentLoaded", function() {
    const firstSuspensionOrderNo = document.getElementById('suspensionOrderNo1');
    const firstResumeOrderNo = document.getElementById('resumeOrderNo1');
    
    firstSuspensionOrderNo.addEventListener('change', function() {
        validateOrderDates(1);
    });
    
    firstResumeOrderNo.addEventListener('change', function() {
        validateOrderDates(1);
    });
});
</script>

<script>

    //load the contractors name this is example only
const contractors = ['Kristine Joy Briones', 'Janessa Guillermo', 'CJenalyn Jumawan', 'Arjay Ordinario'];

function showSuggestions(query) {
    const suggestionsBox = document.getElementById('suggestionsBox');
    suggestionsBox.innerHTML = ''; // Clear previous suggestions

    if (query.length > 0) {
        const filteredContractors = contractors.filter(contractor => contractor.toLowerCase().includes(query.toLowerCase()));
        
        if (filteredContractors.length > 0) {
            suggestionsBox.style.display = 'block';
            filteredContractors.forEach(contractor => {
                const item = document.createElement('a');
                item.href = '#';
                item.className = 'list-group-item list-group-item-action';
                item.textContent = contractor;
                suggestionsBox.appendChild(item);
            });
        } else {
            suggestionsBox.style.display = 'none';
        }
    } else {
        suggestionsBox.style.display = 'none';
    }
}


// Predefined list of municipalities in Nueva Vizcaya
const municipalities = [
    'Alfonso Castañeda', 'Aritao', 'Bagabag', 'Bambang', 'Bayombong', 'Diadi',
    'Dupax del Norte', 'Dupax del Sur', 'Kasibu', 'Kayapa', 'Quezon', 'Solano', 
    'Villaverde', 'Ambaguio', 'Santa Fe', 'Lamut'
];

function showMunicipalitySuggestions(query) {
    const suggestionsBox = document.getElementById('suggestionsBox');
    suggestionsBox.innerHTML = ''; // Clear previous suggestions

    if (query.length > 0) {
        // Filter the municipalities based on the user input
        const filteredMunicipalities = municipalities.filter(municipality => municipality.toLowerCase().includes(query.toLowerCase()));

        if (filteredMunicipalities.length > 0) {
            suggestionsBox.style.display = 'block';
            filteredMunicipalities.forEach(municipality => {
                const item = document.createElement('a');
                item.href = '#';
                item.className = 'list-group-item list-group-item-action';
                item.textContent = municipality;
                item.onclick = function() {
                    document.getElementById('projectLoc').value = municipality + ', Nueva Vizcaya'; // Auto-format the location
                    suggestionsBox.style.display = 'none'; // Hide suggestions after selection
                };
                suggestionsBox.appendChild(item);
            });
        } else {
            suggestionsBox.style.display = 'none';
        }
    } else {
        suggestionsBox.style.display = 'none';
    }
}


</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    function validateDates(issuedId, receivedId, label) {
      const issued = document.getElementById(issuedId);
      const received = document.getElementById(receivedId);

      function checkDate() {
  const issuedDate = new Date(issued.value);
  const receivedDate = new Date(received.value);

  if (issued.value && received.value && receivedDate < issuedDate) {
    Swal.fire({
      icon: 'error',
      title: `${label} Error`,
      text: 'Received date must be the same or after the issued date.',
      confirmButtonColor: '#3085d6',
    });
    received.value = ""; // Clear invalid input
  }
}

      }

      issued.addEventListener("change", checkDate);
      received.addEventListener("change", checkDate);
    }

    validateDates("noaIssuedDate", "noaReceivedDate", "Notice of Award");
    validateDates("ntpIssuedDate", "ntpReceivedDate", "Notice to Proceed");
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const contractDaysInput = document.getElementById("projectContractDays");
    const startDateInput = document.getElementById("originalStartDate");
    const completionDateInput = document.getElementById("targetCompletion");

    function calculateCompletionDate() {
      const startDateValue = startDateInput.value;
      const contractDays = parseInt(contractDaysInput.value);

      if (startDateValue && contractDays > 0) {
        const startDate = new Date(startDateValue);
        const completionDate = new Date(startDate);
        completionDate.setDate(startDate.getDate() + contractDays - 1); // minus 1 here
        const formatted = completionDate.toISOString().split('T')[0];
        completionDateInput.value = formatted;
      }
    }

    contractDaysInput.addEventListener("input", calculateCompletionDate);
    startDateInput.addEventListener("change", calculateCompletionDate);
  });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    const targetCompletionInput = document.getElementById("targetCompletion");
    const timeExtensionInput = document.getElementById("timeExtension");
    const revisedTargetInput = document.getElementById("revisedTargetCompletion");
    const completionDateInput = document.getElementById("completionDate");

    function updateDates() {
      const targetDateValue = targetCompletionInput.value;
      const timeExtension = parseInt(timeExtensionInput.value);

      if (targetDateValue && !isNaN(timeExtension) && timeExtension > 0) {
        const targetDate = new Date(targetDateValue);
        const revisedDate = new Date(targetDate);
        revisedDate.setDate(targetDate.getDate() + timeExtension);

        const formatted = revisedDate.toISOString().split('T')[0];

        revisedTargetInput.value = formatted;
        completionDateInput.value = formatted;

        revisedTargetInput.readOnly = true;
        completionDateInput.readOnly = true;
      } else {
        revisedTargetInput.readOnly = false;
        completionDateInput.readOnly = false;
      }
    }

    targetCompletionInput.addEventListener("change", updateDates);
    timeExtensionInput.addEventListener("input", updateDates);
  });
</script>

    
    @include('systemAdmin.modals.Projects.add-fund')
    @include('systemAdmin.modals.Projects.add-status')
    @include('systemAdmin.modals.Projects.edit-project')
    @include('systemAdmin.modals.Projects.uploadFiles')

@endsection
