@extends('admin.layout')

@section('title', 'Overview Page')

@section('content')
    <!-- Project Overview -->
     <div class="container-fluid py-4" style="background-color: transparent;">
        <div class="card mb-1 border-0 shadow-lg "style="margin-top:75px;" >
            <div class="card-body p-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <a id="back-to-projects" class="btn btn-outline-secondary btn-sm"
                            href="{{ url('/admin/projects') }}">
                            <span class="fa fa-arrow-left"></span>
                        </a>
                        <h5 class="m-0">Project Overview</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-1">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                         <span class="font-title-overview mb-0 text-uppercase">{{ $project['title'] ?? '' }}</span>
                        <div class="d-flex gap-2">
                            <button type="button" id="editProjectBtn"
                                class="btn btn-warning btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                                data-bs-target="#projectModal" title="Edit Project Details">
                                <i class="fa fa-edit"></i>
                                <span class="d-none d-md-inline">Edit</span>
                            </button>
                             <!-- Report Button -->
                             <button type="button"
                                    id="generateProjectBtn"
                                    class="btn btn-info btn-sm d-flex align-items-center gap-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#generateProjectModal"
                                    title="Generate/Download Report">
                                <i class="fa fa-download"></i>
                                <span class=" d-md-inline">Report</span>
                            </button>

                            <button type="button" id="trashProjectBtn"
                                class="btn btn-danger btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                                data-bs-target="#trashModal" title="Archive Project">
                                <i class="fa fa-trash"></i>
                                <span class="d-none d-md-inline">Archive</span>
                            </button>
                           
                        </div>
                    </div>
                    <div class="card-body font-content">
                        <div class="row gy-2 mb-2">
                            <div class="col-md-8 font-base">
                                <!-- Column 1 -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4 ">
                                                <p class="d-block">Project ID: </p>
                                            </div>
                                            <div class="col-md-8">
                                                <span
                                                    style="font-weight: normal;color: black;">{{ $project['projectID'] ?? '' }}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 ">
                                                <p class="d-block">Location:</p>
                                            </div>
                                            <div class="col-md-8">
                                                <span
                                                    style="font-weight: normal;color: black;">{{ $project['location'] ?? '' }}</span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 ">
                                                <p class="d-block">Project Year: </p>
                                            </div>
                                            <div class="col-md-8">
                                                <span
                                                    style="font-weight: normal; color: black;">{{ $project['year'] ?? '' }}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4 ">
                                                <p class="d-block">Project FPP: </p>
                                            </div>
                                            <div class="col-8">
                                                <span
                                                    style="font-weight: normal; color: black;">{{ $project['fpp'] ?? '' }}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4 ">
                                                <p class="d-block">Project Engineer: </p>
                                            </div>
                                            <div class="col-8">
                                                <p style="font-weight: normal; color: black;">{{ $project['engineer_name'] ?? '' }}
                                                    <br> <i>{{ $project['engineer_position'] ?? '' }}</i>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Column 2 -->
                                    <div class="col-md-6 font-base">
                                        <div class="row">
                                            <div class="col-md-5 ">
                                                <p class="d-block">Contract Days:</p>
                                            </div>
                                            <div class="col-md-7">
                                                <span
                                                    style="font-weight: normal; color: black;">{{ $project['contract_days'] ?? '' }}
                                                    (Calendar days)</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-5 ">
                                                <p class="d-block">Source of Fund: </p>
                                            </div>
                                            <div class="col-md-7">
                                                <span style="font-weight: normal; color: black;">
                                                    {{ ($project['source_of_funds'] ?? '') === 'Others' ? ($project['otherFund'] ?? '') : ($project['source_of_funds'] ?? '') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 ">
                                                <p class="d-block">RC:</p>
                                            </div>
                                            <div class="col-md-7">
                                                <span
                                                    style="font-weight: normal; color: black;">{{ $project['responsibility_center'] ?? '' }}</span>
                                            </div>
                                        </div>
                                        @php
                                            $ongoing_status = $projectStatusData['ongoing_status'] ?? [];

                                            $totalPercentage = is_array($ongoing_status) ? array_sum(array_column($ongoing_status, 'percentage')) : 0;

                                            $latestDate = null;
                                            if (is_array($ongoing_status) && count($ongoing_status) > 0) {
                                                $dates = array_column($ongoing_status, 'date');
                                                $latestDate = max($dates); // gets the latest (most recent) date
                                            }
                                        @endphp

                                        <!-- Project Status Display -->
                                        <div class="row">
                                            <div class="col-md-5 ">
                                                <p class="d-block">Status:</p>
                                            </div>
                                            <div class="col-md-7">
                                                <span class="badge bg-success me-2 text-white" style="font-weight: normal;">
                                                    {{ $project['physical_status'] ?? '' }}
                                                </span><br>
                                                <small style="font-weight: normal;">
                                                    {{ $totalPercentage }}% Completed
                                                    @if ($latestDate)
                                                        as of {{ \Carbon\Carbon::parse($latestDate)->format('F j, Y') }}
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 ">
                                                <p class="d-block">Slippage:</p>
                                            </div>
                                            <div class="col-md-7">
                                                <span
                                                    class="badge bg-danger text-white">{{ $project['project_slippage'] ?? '' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 3 - One column with two stacked rows -->
                            <div class="col-md-4">

                                <!-- Row 1: Project Progress Table -->
                                <div class="mb-3">
                                    <div class="bg-light p-2 d-flex justify-content-between align-items-center">
                                        <span><i class="bi bi-bar-chart-line me-2"></i><strong>Progress</strong></span>

                                        @if ($totalPercentage < 100)
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="addStatusBtn">
                                                <i class="bi bi-plus-circle me-1"></i>Add
                                            </button>
                                        @endif
                                    </div>

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
                                                @if (!empty($ongoing_status) && is_array($ongoing_status))
                                                    @foreach ($ongoing_status as $status)
                                                        <tr>
                                                            <td>{{ $status['progress'] }}</td>
                                                            <td>{{ $status['percentage'] }}%</td>
                                                            <td>{{ $status['date'] }}</td>
                                                        </tr>
                                                    @endforeach
                                                @elseif ($projectStatusData['physical_status'] === 'Completed')
                                                    <tr>
                                                        <td colspan="3" class="text-center text-muted">This project is completed.
                                                        </td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td colspan="3" class="text-center text-muted">No progress data available.
                                                        </td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Row 2: Financial Progress Table -->
                                <div>
                                    <div class="bg-light p-2 d-flex justify-content-between align-items-center">
                                        <span><i class="bi bi-bar-chart-line me-2"></i><strong>Financial Progress</strong></span>
                                    </div>

                                    <div class="table-responsive" style="max-height: 180px; overflow-y: auto;">
                                        <table class="table table-sm table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Billing Particulars</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- Partial Billings --}}
                                                
                                                @if (!empty($project['partial_billings']))
                                                    @php
                                                        $partialBillings = $project['partial_billings'] ?? [];
                                                    @endphp
                                                    @foreach ($partialBillings as $index => $billing)
                                                        @php
                                                            $amount = $billing['amount'] ?? '';
                                                            if (!$amount) continue;
                                                            $remarks = $billing['remarks'] ?? null;
                                                            $label = ($index + 1) . match($index + 1) {
                                                                1 => 'st', 2 => 'nd', 3 => 'rd', default => 'th',
                                                            } . ' Partial Billing';
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $label }}</td>
                                                            <td>{{ number_format((float) $amount, 2) }}</td>


                                                            <td>
                                                                <span class="{{ $remarks === 'Release' ? 'text-success' : 'text-muted' }}">
                                                                    {{ $remarks === 'Release' ? 'Released' : 'Not Released' }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif


                                                {{-- Final Billing --}}
                                                @php
                                                
                                                    $summary = $project['summary'] ?? [];
                                                    $finalAmount = $summary['final']['amount'] ?? '';
                                                    $finalRemarks = $summary['final']['remarks'] ?? null;
                                                @endphp
                                                <tr>
                                                    <td>Final Billing</td>
                                                    <td>{{ number_format((float) $finalAmount, 2) }}</td>
                                                    <td>
                                                         <span class="{{ strtolower($finalRemarks) === 'release' ? 'text-success' : 'text-muted' }}">
                                                            {{ strtolower($finalRemarks) === 'release' ? 'Released' : 'Not Released' }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>

                            
                            <div class="row align-items-stretch">
                                <!-- Left Column: Project Description and Contractor Details stacked in half-width -->
                                <div class="col-md-6">
                                    <!-- Project Description -->
                                    <fieldset class="border p-3 mb-4 rounded shadow-sm w-100 d-flex flex-column">
                                        <legend class="float-none w-auto px-2 legend-text">Project Description</legend>
                                        <div class="mb-3">
                                            <ul class="list-unstyled ps-3">
                                                @foreach ($project['description'] ?? [] as $desc)
                                                    <li class="mb-1">• {{ $desc }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </fieldset>

                                    <!-- Contractor Details -->
                                    <fieldset class="border p-3 mb-4 rounded shadow-sm w-100 d-flex flex-column">
                                        <legend class="float-none w-auto px-2 legend-text">Contractor Details</legend>

                                        <div class="mb-3">
                                            <div class="row mb-2">
                                                <div class="col-md-5">
                                                    <p class="font-base mb-0">Name of Firm:</p>
                                                </div>
                                                <div class="col-md-7">
                                                    <span style="font-weight: normal; color: black;">
                                                        {{ $project['firm_name'] ?? ' ' }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-5">
                                                    <p class="font-base mb-0">Contractor's Name:</p>
                                                </div>
                                                <div class="col-md-7">
                                                    <span style="font-weight: normal; color: black;">
                                                        {{ $project['contractor_name'] ?? ' ' }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-5">
                                                    <p class="font-base mb-0" style="white-space: nowrap; ">Address of Contractor/Firm:</p>
                                                </div>
                                                <div class="col-md-7">
                                                    <span style="font-weight: normal; color: black;">
                                                        {{ $project['contractor_address'] ?? 'N/A' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>

                                </div>

                                <!-- Right Column: Implementation Details -->
                                <div class="col-md-6 d-flex">
                                    <fieldset class="border p-3 mb-4 rounded shadow-sm w-100 d-flex flex-column">
                                        <legend class="float-none w-auto px-2 legend-text">Implementation Details</legend>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p class="font-base">Implementation Mode:</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p style="font-weight: normal; color: black;">
                                                    {{ $project['mode_of_implementation'] ?? '' }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="row mb-0" style="margin-bottom: 1px !important;">
                                            <div class="col-md-12">
                                                <div class="row" style="margin-bottom: 1px !important;">
                                                    <div class="col-md-6"></div>
                                                    <div class="col-md-3">
                                                        <span style="font-weight: bold; font-size: 0.875rem;">Issued Date</span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span style="font-weight: bold; font-size: 0.875rem;">Received Date</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-0" style="margin-bottom: 1px !important;">
                                            <div class="col-md-12">
                                                <div class="row" style="margin-bottom: 1px !important; align-items: center;">
                                                    <div class="col-md-6">
                                                        <p class="font-base" style="margin-bottom: 0; font-size: 0.875rem;">Notice of Award:</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span style="font-size: 0.875rem;">{{ $project['noa_issued_date'] ?? '' }}</span>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <span style="font-size: 0.875rem;">{{ $project['noa_received_date'] ?? '' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    <!-- Group: Notice to Proceed -->
                                    <div class="row mb-2"> <!-- Slightly more spacing here -->
                                        <div class="col-md-12">
                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <p class="font-base mb-0" style="font-size: 0.875rem;">Notice to Proceed:</p>
                                                </div>
                                                <div class="col-md-3">
                                                    <span style="font-size: 0.875rem;">{{ $project['ntp_issued_date'] ?? '' }}</span>
                                                </div>
                                                <div class="col-md-3">
                                                    <span style="font-size: 0.875rem;">{{ $project['ntp_received_date'] ?? '' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Spacer -->
                                    <div class="mb-2"></div> <!-- This adds clear spacing -->

                                    <!-- Group: Start and Completion Dates -->
                                    <div class="row mb-1 align-items-center">
                                        <div class="col-md-6">
                                            <p class="font-base mb-0">Starting Date:</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-0" style="font-weight: normal; color: black; font-size: 0.875rem;">
                                                {{ $project['official_starting_date'] ?? ' ' }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <p class="font-base mb-0">Target Completion Date:</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-0" style="font-weight: normal; color: black; font-size: 0.875rem;">
                                                {{ $project['target_completion_date'] ?? '' }}
                                            </p>
                                        </div>
                                    </div>
                                        @php
                                            $hasSuspension = false;

                                            // Decode remarks safely
                                            $remarksData = json_decode($project['reason_for_suspension'], true) ?? [];

                                            // Extract suspension-related indices
                                            $indices = [];
                                            foreach ($project as $key => $val) {
                                                if (preg_match('/(?:suspensionOrderNo|resumeOrderNo)(\d+)/', $key, $matches)) {
                                                    $indices[] = (int) $matches[1];
                                                }
                                            }

                                            $uniqueIndices = array_unique($indices);
                                            sort($uniqueIndices);

                                            // Check if there's at least one valid suspension entry
                                            foreach ($uniqueIndices as $index) {
                                                $suspKey = "suspensionOrderNo{$index}";
                                                $resumeKey = "resumeOrderNo{$index}";
                                                $remarks = $remarksData[$index]['suspensionOrderRemarks'] ?? null;

                                                if (!empty($project[$suspKey]) || !empty($project[$resumeKey]) || !empty($remarks)) {
                                                    $hasSuspension = true;
                                                    break;
                                                }
                                            }
                                        @endphp

                                        @if ($hasSuspension)
                                            {{-- Suspension Details --}}
                                            @foreach ($uniqueIndices as $index)
                                                @php
                                                    $suspKey = "suspensionOrderNo{$index}";
                                                    $resumeKey = "resumeOrderNo{$index}";
                                                    $suspensionValue = $project[$suspKey] ?? null;
                                                    $resumeValue = $project[$resumeKey] ?? null;
                                                    $remarks = $remarksData[$index]['suspensionOrderRemarks'] ?? null;
                                                    $shouldShow = !empty($suspensionValue) || !empty($resumeValue) || !empty($remarks);
                                                @endphp

                                                @if ($shouldShow)
                                                    <div class="row mb-0 align-items-center">
                                                        <hr>
                                                        <div class="col-md-6">
                                                            <p class="font-base mb-0" style="font-size: 0.875rem;">Suspension Order No. {{ $index }}:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="text-dark mb-0" style="font-size: 0.875rem;">{{ $suspensionValue }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-0">
                                                        <div class="col-md-6">
                                                            <p class="font-base mb-0" style="font-size: 0.875rem;">Reason for Suspension:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="text-dark mb-0" style="font-size: 0.875rem;">{{ trim($remarks ?? '') }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3 align-items-center">
                                                        <div class="col-md-6">
                                                            <p class="font-base mb-0" style="font-size: 0.875rem;">Resumption Order No. {{ $index }}:</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p class="text-dark mb-0" style="font-size: 0.875rem;">{{ $resumeValue }}</p>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @endif

                                        @foreach ($timeExtensions as $index => $extension)
                                        @php
                                            $hasData = !empty($extension->time_extension) ||
                                                    !empty($extension->time_extension_reason) ||
                                                    !empty($extension->revised_expiry) ||
                                                    !empty($extension->revised_expiry_reason);
                                        @endphp

                                        @if ($hasData)
                                            <hr>
                                            <div class="row mb-2" style="align-items: center;">
                                                <div class="col-12">
                                                    <p class="fw-bold" style="font-size: 0.9rem;">Time Extension {{ $index + 1 }}</p>
                                                </div>

                                                @if (!empty($extension->time_extension))
                                                    <div class="col-md-6">
                                                        <p class="font-base mb-1" style="font-size: 0.875rem;">Number of Days of Extension:</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="text-dark mb-1" style="font-size: 0.875rem;">{{ $extension->time_extension }}</p>
                                                    </div>
                                                @endif

                                                @if (!empty($extension->time_extension_reason))
                                                    <div class="col-md-6">
                                                        <p class="font-base mb-1" style="font-size: 0.875rem;">Reason for Extension:</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="text-dark mb-1" style="font-size: 0.875rem;">{{ $extension->time_extension_reason }}</p>
                                                    </div>
                                                @endif

                                                @if (!empty($extension->revised_expiry))
                                                    <div class="col-md-6">
                                                        <p class="font-base mb-1" style="font-size: 0.875rem;">Revised Expiry Date:</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="text-dark mb-1" style="font-size: 0.875rem;">
                                                            {{ \Carbon\Carbon::parse($extension->revised_expiry)->format('d-M-Y') }}
                                                        </p>
                                                    </div>
                                                @endif

                                                <!-- @if (!empty($extension->revised_expiry_reason))
                                                    <div class="col-md-6">
                                                        <p class="font-base mb-1" style="font-size: 0.875rem;">Reason for Revised Expiry:</p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p class="text-dark mb-1" style="font-size: 0.875rem;">{{ $extension->revised_expiry_reason }}</p>
                                                    </div>
                                                @endif -->
                                            </div>
                                        @endif
                                    @endforeach


                                            {{-- Revised Dates --}}
                                            <hr>
                                            <div class="row mb-3" style="margin-bottom: 2px !important; align-items: center;">
                                                <div class="col-md-6">
                                                    <p class="font-base" style="margin-bottom: 0; font-size: 0.875rem;">New Target Completion Date:</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p style="margin-bottom: 0; font-weight: normal; color: black; font-size: 0.875rem;">
                                                        {{ $project['revised_target_date'] ?? '' }}
                                                    </p>
                                                </div>
                                            </div>
                                          
                         
                                        <div class="row mb-0">
                                            <div class="col-md-6 ">
                                                <p class="font-base">Actual Date of Completion:</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p style="font-weight: normal; color: black;">
                                                    {{ $project['actual_completion_date'] ?? '' }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="row mb-0">
                                            <div class="col-md-6 ">
                                                <p class="font-base">Actual Length:</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p style="font-weight: normal; color: black;">
                                                {{ $project['actual_length'] ?? '' }}
                                                </p>
                                            </div>
                                        </div>

                                    </fieldset>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col-md-12">
                <!-- Combined Card with Two Columns -->
                <div class="card shadow-sm">
                    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                        <a href="{{ route('project.fund-utilization', ['project_id' => $project['id']]) }}"
                            class="btn btn-primary btn-sm d-flex align-items-center gap-2 ms-auto"
                            title="Add Fund Utilization Details">
                            <i class="fa fa-plus"></i>
                            <span class=" d-md-inline">Add/Edit Fund Utilization</span>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="row g-3 align-items-stretch">
                                <!-- Left Column: Cost Breakdown -->
                                <div class="col-md-6 d-flex">
                                    <div class="d-flex h-100 w-100">
                                        <fieldset class="border rounded shadow-sm p-3 w-100 h-100">
                                            <legend class="float-none w-auto px-2 legend-text">Funds Source</legend>
                                            <div class="table-responsive">
                                                <table class="table table-bordered text-center align-middle fund-summary-table"
                                                    id="costBreakdownTable">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th rowspan="2">Category</th>
                                                            <th rowspan="2">Proposed</th>
                                                            <th
                                                                colspan="{{ max(count($project['variation_orders'] ?? []), 1) }}">
                                                                Variation Orders</th>
                                                            <th rowspan="2">Actual Utilization</th>
                                                        </tr>
                                                        <tr>
                                                            @php
                                                                $vos = $project['variation_orders'] ?? [];
                                                                $hasVO1 = collect($vos)->contains('vo_number', 1);
                                                            @endphp

                                                            <th>V.O. 1</th>
                                                            @foreach($vos as $vo)
                                                                @if ($vo['vo_number'] != 1)
                                                                    <th>V.O. {{ $vo['vo_number'] }}</th>
                                                                @endif
                                                            @endforeach
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $rows = [
                                                                ['label' => 'Appropriation', 'key' => 'appropriation'],
                                                                ['label' => 'ABC', 'key' => 'abc'],
                                                                ['label' => 'Contract Amount', 'key' => 'contract_amount'],
                                                                ['label' => 'Savings', 'key' => 'bid'],
                                                                ['label' => 'Wages', 'key' => null, 'is_header' => true],
                                                                ['label' => 'Engineering', 'key' => 'engineering', 'child_of' => 'Wages', 'text_end' => true],
                                                                ['label' => 'MQC', 'key' => 'mqc', 'child_of' => 'Wages', 'text_end' => true],
                                                                ['label' => 'Contingency', 'key' => 'contingency'],
                                                            ];

                                                            $funds = $project['funds'] ?? [];
                                                            $vos = $project['variation_orders'] ?? [];
                                                            $vo1 = collect($vos)->firstWhere('vo_number', 1);
                                                            $voKeys = collect($vos)->pluck('vo_number')->filter(fn($num) => $num != 1)->values()->all();

                                                            $proposedTotalKeys = ['contract_amount', 'bid', 'engineering', 'mqc', 'contingency'];
                                                            $proposedTotal = 0;
                                                        @endphp

                                                        @foreach ($rows as $row)
                                                            @if (!empty($row['is_header']))
                                                                <tr class="table-secondary fw-bold">
                                                                    <td colspan="{{ 3 + max(count($vos), 1) }}" style="white-space: nowrap;">{{ $row['label'] }}</td>
                                                                </tr>
                                                            @else
                                                                @php
                                                                    $key = $row['key'];
                                                                    $orig = $funds['orig_' . $key] ?? 0;
                                                                    $vo1Val = $vo1['vo_' . $key] ?? 0;
                                                                    $actual = $funds['actual_' . $key] ?? 0;

                                                                    if (in_array($key, $proposedTotalKeys)) {
                                                                        $proposedTotal += $orig;
                                                                    }
                                                                @endphp
                                                                <tr>
                                                                    <td class="{{ isset($row['child_of']) ? 'ps-4' : '' }} {{ !empty($row['text_end']) ? 'text-end' : '' }}">
                                                                        {{ $row['label'] }}
                                                                    </td>
                                                                    <td class="text-end">{{ number_format($orig, 2) }}</td>
                                                                    <td class="text-end">{{ number_format($vo1Val, 2) }}</td>
                                                                    @foreach ($voKeys as $voNum)
                                                                        @php
                                                                            $voVal = collect($vos)->firstWhere('vo_number', $voNum)['vo_' . $key] ?? 0;
                                                                        @endphp
                                                                        <td class="text-end">{{ number_format($voVal, 2) }}</td>
                                                                    @endforeach
                                                                    <td class="text-end">{{ number_format($actual, 2) }}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach

                                                        <!-- Total Row for Proposed Column Only -->
                                                       <!-- Total Row for Proposed Column Only -->
                                                       <tr class="table-warning fw-bold">
                                                            <td>Total</td>
                                                            <td class="text-end">{{ number_format($proposedTotal, 2) }}</td>
                                                            <td colspan="{{ 1 + count($voKeys) }}">
                                                            <td class="text-end">
                                                                {{ number_format(
                                                                    ($funds['actual_contract_amount'] ?? 0) +
                                                                    ($funds['actual_engineering'] ?? 0) +
                                                                    ($funds['actual_mqc'] ?? 0) +
                                                                    ($funds['actual_contingency'] ?? 0), 2) 
                                                                }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>

                                <!-- Right Column: Fund Utilization Summary -->
                                <div class="col-md-6 d-flex font-base">
                                    <div class="d-flex h-100 w-100">
                                        <fieldset class="border rounded shadow-sm p-3 w-100 h-100">
                                            <legend class="float-none w-auto px-2 legend-text">Fund Utilization Summary
                                            </legend>
                                            <div class="table-responsive">
                                            @php
                                                    if (!function_exists('ordinal')) {
                                                        function ordinal($number) {
                                                            $ends = ['th','st','nd','rd','th','th','th','th','th','th'];
                                                            return ($number % 100 >= 11 && $number % 100 <= 13)
                                                                ? $number.'th'
                                                                : $number.$ends[$number % 10];
                                                        }
                                                    }

                                                    $summary = $project['summary'] ?? [];
                                                    $partialBillings = $project['partial_billings'] ?? [];
                                                    $labels = [
                                                        'mobilization' => '15% Mobilization',
                                                        'final' => 'Final Billing',
                                                        'engineering' => 'Engineering',
                                                        'mqc' => 'MQC',
                                                    ];

                                                    $funds = $project['funds'] ?? [];
                                                    $orig_contract_amount = (float) ($funds['actual_contract_amount'] ?? 0);
                                                    $orig_appropriation = (float) ($funds['orig_appropriation'] ?? 0);
                                                    $mobilizationAmt = (float) ($summary['mobilization']['amount'] ?? 0);
                                                    $finalAmt = (float) ($summary['final']['amount'] ?? 0);
                                                    $engAmt = (float) str_replace(',', '', ($summary['engineering']['amount'] ?? 0));
                                                    $mqcAmt = (float) str_replace(',', '', ($summary['mqc']['amount'] ?? 0));
                                                    $partialTotal = collect($partialBillings)->sum('amount');
                                                    $expenditures = $mobilizationAmt + $partialTotal + $finalAmt + $engAmt + $mqcAmt;
                                                 

                                                    $contractBalance = $orig_contract_amount - ($mobilizationAmt + $partialTotal + $finalAmt);
                                                    $origEng = (float) str_replace(',', '', ($funds['orig_engineering'] ?? 0));
                                                    $origMqc = (float) str_replace(',', '', ($funds['orig_mqc'] ?? 0));
                                                    $engineeringBreakdownSum = collect($engineeringEntries)->sum('amount');
                                                    $mqcBreakdownSum = collect($mqcEntries)->sum('amount');
                                                    $engineeringBalance = $origEng - $engineeringBreakdownSum;
                                                    $mqcBalance = $origMqc - $mqcBreakdownSum;
                                                    $origAppropriation = (float) ($funds['orig_appropriation'] ?? 0);
                                                    $totalBalance = $origAppropriation - $expenditures;
                                                @endphp

                                                <table class="table table-bordered text-center align-middle fund-summary-table">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Particulars</th>
                                                            <th>Amount</th>
                                                            <th>Retention %</th>
                                                            <th>Retention Amount</th>
                                                            <th>Total</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="font-weight: normal;">
                                                        <tr>
                                                            <td><strong>Total Appropriation</strong></td>
                                                            <td class="text-end" colspan="1">{{ number_format($orig_appropriation, 2) }}</td>
                                                            <td></td> <td></td>
                                                            <td></td> <td></td>                 
                                                        </tr>

                                                        <tr>
                                                            <td><strong>Contract Amount</strong></td>
                                                            <td class="text-end" colspan="1">{{ number_format($orig_contract_amount, 2) }}</td>
                                                            <td></td> <td></td>
                                                            <td></td> <td></td>    
                                                        </tr>
                                                      <!-- Mobilization -->
                                                            @php
                                                            $mobiAmount = isset($summary['mobilization']['amount']) ? floatval($summary['mobilization']['amount']) : 0;
                                                            $mobiRetention = $mobiAmount > 0 ? $mobiAmount * 0.10 : 0;
                                                            $mobiTotal = $mobiAmount - $mobiRetention;
                                                            @endphp
                                                            <tr>
                                                            <td>{{ $labels['mobilization'] }}</td>
                                                            <td class="text-end">{{ number_format($mobiAmount, 2) }}</td>
                                                            <td class="text-end"></td>
                                                            <td class="text-end"></td>
                                                            <td class="text-end"></td>
                                                            <td></td>
                                                            </tr>

                                                            <!-- Partial Billings -->
                                                            @foreach ($partialBillings as $index => $billing)
                                                            @php
                                                                $amount = isset($billing['amount']) ? floatval($billing['amount']) : 0;
                                                                $hasValue = $amount > 0 || !empty($billing['remarks']) || !empty($billing['date']);
                                                                $retention = $amount > 0 ? $amount * 0.10 : 0;
                                                                $total = $amount - $retention;
                                                            @endphp
                                                            @if ($index === 0 || $hasValue)
                                                                <tr>
                                                                <td>{{ ordinal($index + 1) }} Partial Billing</td>
                                                                <td class="text-end">{{ $amount > 0 ? number_format($amount, 2) : '' }}</td>
                                                                <td class="text-end">{{ $amount > 0 ? '10%' : '' }}</td>
                                                                <td class="text-end">{{ $amount > 0 ? number_format($retention, 2) : '' }}</td>
                                                                <td class="text-end">{{ $amount > 0 ? number_format($total, 2) : '' }}</td>
                                                                <td></td>
                                                                </tr>
                                                            @endif
                                                            @endforeach

                                                            <!-- Final Billing -->
                                                            @php
                                                            $finalAmount = isset($summary['final']['amount']) ? floatval($summary['final']['amount']) : 0;
                                                            $finalRetention = $finalAmount > 0 ? $finalAmount * 0.10 : 0;
                                                            $finalTotal = $finalAmount - $finalRetention;
                                                            @endphp
                                                            <tr>
                                                            <td>{{ $labels['final'] }}</td>
                                                            <td class="text-end">{{ number_format($finalAmt, 2) }}</td>
                                                            <td class="text-end">10%</td>
                                                            <td class="text-end">{{ $finalAmount > 0 ? number_format($finalRetention, 2) : '' }}</td>
                                                            <td class="text-end">{{ $finalAmount > 0 ? number_format($finalTotal, 2) : '' }}</td>
                                                            <td></td>
                                                            </tr>

                                                        <tr>
                                                            <td>Balance</td>
                                                            <td class="text-end text-success fw-semibold">{{ number_format($contractBalance, 2) }}</td>
                                                            <td></td> <td></td>    
                                                            <td></td> <td></td> 
                                                        </tr>

                                                        {{-- Engineering --}}
                                                        <tr>
                                                            <td>{{ $labels['engineering'] }}</td>
                                                            <td class="text-end">{{ number_format($engAmt, 2) }}</td>
                                                            <td></td> <td></td>  <td class="text-end">{{ number_format($engAmt, 2) }}</td>    
                                                            <td class="text-end">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#engineeringBreakdown" aria-expanded="false" aria-controls="engineeringBreakdown" class="text-decoration-none ms-2">
                                                                        <i class="bi bi-list"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                           
                                                        </tr>
                                                        <tr class="collapse" id="engineeringBreakdown">
                                                            <td colspan="6">
                                                                <table class="table table-sm table-bordered text-center mb-0 w-100">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th>Date</th>
                                                                            <th>Name (Month)</th>
                                                                            <th>Amount</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse($engineeringEntries as $eng)
                                                                            <tr>
                                                                                <td style="width: 28%;">
                                                                                    @if($eng->date_from && $eng->date_to)
                                                                                        {{ \Carbon\Carbon::parse($eng->date_from)->format('Y-m-d') }} to {{ \Carbon\Carbon::parse($eng->date_to)->format('Y-m-d') }}
                                                                                    @endif
                                                                                </td>
                                                                                <td style="width: 40%;">{{ $eng->name }} - {{ $eng->month }}</td>
                                                                                <td class="text-end" data-amount="{{ $eng->amount }}">{{ number_format($eng->amount, 2) }}</td>
                                                                            </tr>
                                                                        @empty
                                                                            <tr>
                                                                                <td colspan="3" class="text-muted">No entries found.</td>
                                                                            </tr>
                                                                        @endforelse
                                                                    </tbody>

                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Balance (Engineering)</td>
                                                            <td class="text-end text-success fw-semibold">{{ number_format($engineeringBalance, 2) }}</td>
                                                            <td></td> <td></td>    
                                                            <td></td> <td></td> 
                                                        </tr>

                                                        {{-- MQC --}}
                                                        <tr>
                                                            <td>{{ $labels['mqc'] }}</td>
                                                            <td class="text-end">{{ number_format($mqcAmt, 2) }}</td>
                                                            <td></td> <td></td> <td class="text-end">{{ number_format($mqcAmt, 2) }}</td>    
                                                            <td class="text-start">
                                                                <div class="d-flex justify-content-between align-items-center">
                                                                    <a href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#mqcBreakdown" aria-expanded="false" aria-controls="mqcBreakdown" class="text-decoration-none ms-2">
                                                                        <i class="bi bi-list"></i>
                                                                    </a>
                                                                </div>
                                                            </td>
                                                           
                                                        </tr>
                                                        <tr class="collapse" id="mqcBreakdown">
                                                            <td colspan="6">
                                                                <table class="table table-sm table-bordered text-center mb-0 w-100">
                                                                    <thead class="table-light">
                                                                        <tr>
                                                                            <th>Date Period</th>
                                                                            <th>Name (Month)</th>
                                                                            <th>Amount</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @forelse($mqcEntries as $mqc)
                                                                            <tr>
                                                                                <td style="width: 28%;">
                                                                                    @if($mqc->date_from && $mqc->date_to)
                                                                                        {{ \Carbon\Carbon::parse($mqc->date_from)->format('Y-m-d') }} to {{ \Carbon\Carbon::parse($mqc->date_to)->format('Y-m-d') }}
                                                                                    @else
                                                                                        
                                                                                    @endif
                                                                                </td>
                                                                                <td style="width: 40%;">{{ $mqc->name }} - {{ $mqc->month }}</td>
                                                                                <td class="text-end" data-amount="{{ $mqc->amount }}">₱{{ number_format($mqc->amount, 2) }}</td>
                                                                            </tr>
                                                                        @empty
                                                                            <tr>
                                                                                <td colspan="3" class="text-muted">No entries found.</td>
                                                                            </tr>
                                                                        @endforelse
                                                                    </tbody>

                                                                </table>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Balance (MQC)</td>
                                                            <td class="text-end text-success fw-semibold">{{ number_format($mqcBalance, 2) }}</td>
                                                            <td></td>    <td></td>   
                                                            <td></td> <td></td> 
                                                        </tr>

                                                        <tr class="table-info fw-bold">
                                                            <td>Total Expenditures</td>
                                                            <td class="text-end" colspan="1">{{ number_format($expenditures, 2) }}</td>
                                                            <td></td> <td></td>    
                                                            @php
                                                           
                                                            $grandTotal = $mobiTotal + $partialTotal + $finalTotal + $engAmt + $mqcAmt;

                                                            @endphp
                                                            <td>{{ number_format($grandTotal, 2) }} </td> <td></td> 
                                                        </tr>

                                                        <tr class="table-success fw-bold">
                                                            <td>Total Savings</td>
                                                            <td class="text-end" colspan="1">{{ number_format($totalBalance, 2) }}</td>
                                                            <td></td> <td></td>    
                                                            <td></td> <td></td> 
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

        <!-- file Manment -->
        <div class="row font-content my-2">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle me-3"
                                style="background: rgba(158, 158, 158, 0.1); padding: 12px; border-radius: 50%;">
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
        </div>
    </div>


    <script>
        function calculateBalances() {
    // --- CONTRACT GROUP SUMMARY ---
    const contractAmount = parseFloat(document.getElementById('contractAmount').textContent || 0);
    const mobi = parseFloat(document.getElementById('mobiAmount').textContent || 0);
    const partial = parseFloat(document.getElementById('partialAmount').textContent || 0);
    const finalBilling = parseFloat(document.getElementById('finalAmount').textContent || 0);

    const contractBalance = contractAmount - (mobi + partial + finalBilling);
    document.getElementById('contractBalance').textContent = contractBalance.toFixed(2);

    // --- ENGINEERING ---
    const engineeringTotal = parseFloat(document.getElementById('engineeringAmount').textContent || 0);
    let engineeringBreakdownSum = 0;
    document.querySelectorAll('#engineeringTable tbody tr .breakdownAmount').forEach(cell => {
        engineeringBreakdownSum += parseFloat(cell.textContent || 0);
    });
    const engineeringBalance = engineeringTotal - engineeringBreakdownSum;
    document.getElementById('engineeringBalance').textContent = engineeringBalance.toFixed(2);

    // --- MQC ---
    const mqcTotal = parseFloat(document.getElementById('mqcAmount').textContent || 0);
    let mqcBreakdownSum = 0;
    document.querySelectorAll('#mqcTable tbody tr .breakdownAmount').forEach(cell => {
        mqcBreakdownSum += parseFloat(cell.textContent || 0);
    });
    const mqcBalance = mqcTotal - mqcBreakdownSum;
    document.getElementById('mqcBalance').textContent = mqcBalance.toFixed(2);


        const variationOrders = {!! json_encode($project['variation_orders'] ?? []) !!};

        // Insert V.O. headers
        const voHeadersPlaceholder = document.getElementById("voHeadersPlaceholder");
        if (variationOrders.length > 0) {
            voHeadersPlaceholder.colSpan = variationOrders.length;
            variationOrders.forEach((vo, index) => {
                const th = document.createElement("th");
                th.textContent = `V.O. ${vo.vo_number}`;
                voHeadersPlaceholder.parentElement.insertBefore(th, voHeadersPlaceholder);
            });
            voHeadersPlaceholder.remove();
        }

        // Populate each V.O. column per row
        const fields = ['appropriation', 'contract_amount', 'abc', 'bid', 'engineering', 'mqc', 'contingency'];

        fields.forEach(field => {
            const row = document.querySelector(`.vo_cells_row[data-field="${field}"]`);
            variationOrders.forEach(vo => {
                const td = document.createElement("td");

                // Matching VO fields to data-field
                let voKey = 'vo_' + field;
                let value = vo[voKey] ?? 0;

                td.textContent = parseFloat(value).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
                row.appendChild(td);
            });
        });
     }
    </script>


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

        
    </script>

    @include('admin.modals.Projects.add-status')
    @include('admin.modals.Projects.edit-project')
    @include('admin.modals.Projects.uploadFiles')
    @include('admin.modals.Projects.generate-report')
    

@endsection