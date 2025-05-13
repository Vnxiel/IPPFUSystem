@extends('systemAdmin.layout')

@section('title', 'Overview Page')

@section('content')
<!-- Project Overview -->
<div class="container-fluid py-4" style="background-color: transparent;">
    <!-- Header Section -->
    <div class="card mb-1 border-0 shadow-lg text-center">
    <div class="card-body p-2">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
            <!-- Back Button and Title -->
            <div class="d-flex align-items-center gap-2">
                <a class="btn btn-outline-secondary btn-sm {{ Request::is('systemAdmin/projects') ? 'active' : '' }}"
                    href="{{ url('/systemAdmin/projects') }}">
                    <span class="fa fa-arrow-left"></span>
                </a>
                <h5 class="m-0">Project Overview</h5>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex flex-wrap align-items-center gap-2">
                <button type="button" id="editProjectBtn" class="btn btn-warning btn-sm d-flex align-items-center gap-1" 
                    data-bs-toggle="modal" data-bs-target="#projectModal" title="Edit Project Details">
                    <i class="fa fa-edit"></i>
                    <span class="d-none d-md-inline">Edit</span>
                </button>
                <button class="btn btn-primary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                    data-bs-target="#addProjectFundUtilization" title="Add Fund Utilization Details">
                    <span class="fa fa-plus"></span>
                    <span class="d-none d-md-inline">Fund Utilization</span>
                </button>
                <button type="button" id="fundSummaryBtn" class="btn btn-secondary btn-sm d-flex align-items-center gap-1" 
                    data-bs-toggle="modal" data-bs-target="#fundSummaryModal" title="Fund Summary">
                    <i class="fa-solid fa-check-to-slot"></i>
                    <span class="d-none d-md-inline">Fund Summary</span>
                </button>
                <button type="button" id="generateProjectBtn" class="btn btn-info btn-sm d-flex align-items-center gap-1" 
                    data-bs-toggle="modal" data-bs-target="#generateProjectModal" title="Generate/Download Report">
                    <i class="fa fa-download"></i>
                    <span class="d-none d-md-inline">Report</span>
                </button>
                <button type="button" id="trashProjectBtn" class="btn btn-danger btn-sm d-flex align-items-center gap-1" 
                    data-bs-toggle="modal" data-bs-target="#trashModal" title="Archive Project">
                    <i class="fa fa-trash"></i>
                    <span class="d-none d-md-inline">Archive</span>
                </button>
                <button type="button" class="btn btn-success btn-sm d-flex align-items-center gap-1"
                    data-bs-toggle="modal" data-bs-target="#uploadModal" title="Upload Files">
                    <i class="fa fa-upload"></i>
                    <span class="d-none d-md-inline">Upload</span>
                </button>
            </div>
        </div>
    </div>
</div>


    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h4 class="mb-0">{{ $project['projectTitle'] ?? 'N/A' }}</h4>
                </div>
            <div class="card-body">
                <div class="row gy-4">
                    <!-- Column 1 -->
                    <div class="col-md-4">
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;" >Project ID: <span style="font-weight: normal; font-size: 18px; color: black;">{{ $project['projectID'] ?? 'N/A' }}</span></strong>
                        </div>
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;">Location:  <span style="font-weight: normal; font-size: 18px; color: black;">{{ $project['projectLoc'] ?? 'N/A' }}</span></strong>
                           
                        </div>
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;">Contractor:  <span style="font-weight: normal; color: black;">
                                {{ ($project['projectContractor'] ?? '') === 'Others' ? ($project['othersContractor'] ?? 'N/A') : ($project['projectContractor'] ?? 'N/A') }}
                            </span></strong>
                        </div>
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;">Project Year:  <span style="font-weight: normal; font-size: 18px; color: black;">{{ $project['projectYear'] ?? 'N/A' }}</span></strong>  
                        </div>
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;">Project FPP:  <span style="font-weight: normal; font-size: 18px; color: black;">{{ $project['projectFPP'] ?? 'N/A' }}</span></strong>  
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="col-md-4">
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;">Implementation Mode:  <span style="font-weight: normal; color: black;">{{ $project['modeOfImplementation'] ?? 'N/A' }}</span></strong>
                        </div>
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;">Source of Fund:  <span style="font-weight: normal; color: black;">
                                {{ ($project['sourceOfFunds'] ?? '') === 'Others' ? ($project['otherFund'] ?? 'N/A') : ($project['sourceOfFunds'] ?? 'N/A') }}
                            </span></strong>
                           
                        </div>
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;">Responsibility Center:  <span style="font-weight: normal; font-size: 18px; color: black;">{{ $project['projectRC'] ?? 'N/A' }}</span></strong>  
                        </div>
                        <div class="mb-2 d-flex align-items-center">
                            <strong class="text-muted me-2" style="font-size: 18px;">Status:  <span class="badge bg-success me-2" style="font-weight: normal;">{{ $project['projectStatus'] ?? 'N/A' }}</span>
                            <small >{{ $project['ongoingStatus'] ?? '' }}</small></strong>                           
                        </div>
                        <div class="mb-2">
                            <strong class="text-muted me-2" style="font-size: 18px;">Slippage:</strong>
                            <span class="badge bg-danger ms-2">{{ $project['projectSlippage'] ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <!-- Column 3 - Progress Table -->
                    <div class="col-md-4">
                        <div class="bg-light p-2 d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-bar-chart-line me-2"></i><strong>Progress</strong></span>
                            <button type="button" class="btn btn-sm btn-outline-primary" id="addStatusBtn">
                                <i class="bi bi-plus-circle me-1"></i>Add
                            </button>
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
                                    @if (!empty($projectStatusData['ongoingStatus']) && is_array($projectStatusData['ongoingStatus']))
                                        @foreach ($projectStatusData['ongoingStatus'] as $status)
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
                        <!-- Combined Card with Two Columns -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-light py-2">
                                <h6 class="fw-bold m-0">Project Description & Implementation Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Left Column: Project Description -->
                                    <div class="col-md-6 border-end pe-4">
                                        <h6 class="fw-bold">Project Description</h6>
                                        <div class="mb-3">
                                            <ul class="list-unstyled ps-3">
                                                @foreach ($project['projectDescriptions'] ?? [] as $desc)
                                                    <li class="mb-1">• {{ $desc }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Right Column: Implementation Details -->
                                    <div class="col-md-6 ps-4">
                                        <h6 class="fw-bold">Implementation Details</h6>
                                        @foreach ($project['orderDetails'] as $field => $value)
                                            @php
                                                preg_match('/(suspensionOrderNo|resumeOrderNo)(\d+)/', $field, $matches);
                                                $type = $matches[1] ?? null;
                                                $index = isset($matches[2]) ? (int)$matches[2] : null;

                                                $suspKey = 'suspensionOrderNo' . $index;
                                                $resumeKey = 'resumeOrderNo' . $index;

                                                $suspensionValue = $project['orderDetails'][$suspKey] ?? null;
                                                $resumeValue = $project['orderDetails'][$resumeKey] ?? null;

                                                $shouldShow = $index === 1 || !empty($suspensionValue) || !empty($resumeValue);
                                            @endphp

                                              @if (!$type || $shouldShow)
                                                <div class="d-flex gap-2 mb-2">
                                                    <span class="text-muted" style="width: 200px;">{{ ucwords(str_replace(['suspensionOrderNo', 'resumeOrderNo'], ['Suspension Order No. ', 'Resume Order No. '], $field)) }}:</span>
                                                    <span class="fw-medium">{{ $value ?? 'N/A' }}</span>
                                                </div>
                                                
                                            @endif
                                        @endforeach

                                        @foreach ([
                                            'Time Extension' => 'timeExtension',
                                            'Revised Target Completion' => 'revisedTargetCompletion',
                                            'Completion Date' => 'completionDate'
                                        ] as $label => $key)
                                            <div class="d-flex gap-2 mb-2">
                                                <span class="text-muted" style="width: 180px;">{{ $label }}:</span>
                                                <span class="fw-medium">{{ $project[$key] ?? 'N/A' }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="card mb-2 border-0 shadow-sm">
            <div class="card-body p-2">
                <div class="d-flex align-items-center">
                    <div class="icon-circle me-3" style="background: rgba(158, 158, 158, 0.1); padding: 12px; border-radius: 50%;">
                        <i class="fas fa-archive" style="font-size: 16px; color: #757575;"></i>
                    </div>
                    <div>
                        <h4 class="mb-0">Project Files</h4>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table Section - Main Content -->
        <div class="col-md-12">
            <div class="card border-0 shadow-sm h-100">
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
</div>


        

<script>
  
</script>

    
    @include('systemAdmin.modals.Projects.add-fund')
    @include('systemAdmin.modals.Projects.add-status')
    @include('systemAdmin.modals.Projects.fund-summary')
    @include('systemAdmin.modals.Projects.edit-project')
    @include('systemAdmin.modals.Projects.uploadFiles')
    @include('systemAdmin.modals.Projects.generate-report')

@endsection
