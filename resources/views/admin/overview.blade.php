@extends('admin.layout')

@section('title', 'Overview Page')

@section('content')
<!-- Project Overview -->
<hr class="mx-2">
<div class="container-fluid mt-5" >
    <div class="row">
        <div class="col-md-12 d-flex align-items-center justify-content-between mb-3" style="margin-top:25px;">
            <div class="d-flex align-items-center gap-2">
                <a id="back-to-projects" class="btn btn-outline-secondary btn-sm"
                        href="{{ url('/admin/projects') }}">
                    <span class="fa fa-arrow-left"></span>
                </a>

                <h5 class="m-0">Project Overview</h5>
            </div>
        </div>
    </div>

    <div class="row mb-1">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                    <span class="font-title-overview mb-0">{{ $project['projectTitle'] ?? 'N/A' }}</span>
                    <div class="d-flex gap-2">
                        <button type="button" id="editProjectBtn"
                            class="btn btn-warning btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                            data-bs-target="#projectModal" title="Edit Project Details">
                            <i class="fa fa-edit"></i>
                            <span class="d-none d-md-inline">Edit</span>
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
                                                style="font-weight: normal;color: black;">{{ $project['projectID'] ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 ">
                                            <p class="d-block">Location:</p>
                                        </div>
                                        <div class="col-md-8">
                                            <span
                                                style="font-weight: normal;color: black;">{{ $project['projectLoc'] ?? 'N/A' }}</span>
                                        </div>
                                    </div>
 
                                    <div class="row">
                                        <div class="col-md-4 ">
                                            <p class="d-block">Project Year: </p>
                                        </div>
                                        <div class="col-md-8">
                                            <span
                                                style="font-weight: normal; color: black;">{{ $project['projectYear'] ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 ">
                                            <p class="d-block">Project FPP: </p>
                                        </div>
                                        <div class="col-8">
                                            <span
                                                style="font-weight: normal; color: black;">{{ $project['projectFPP'] ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 ">
                                            <p class="d-block">Project Engineer: </p>
                                        </div>
                                        <div class="col-8">
                                            <p style="font-weight: normal; color: black;">{{ $project['ea'] ?? 'N/A' }}
                                                <br> <i>{{ $project['ea_position'] ?? 'N/A' }}</i>
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
                                                style="font-weight: normal; color: black;">{{ $project['projectContractDays'] ?? 'N/A' }}
                                                (Calendar days)</span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-5 ">
                                            <p class="d-block">Source of Fund: </p>
                                        </div>
                                        <div class="col-md-7">
                                            <span style="font-weight: normal; color: black;">
                                                {{ ($project['sourceOfFunds'] ?? '') === 'Others' ? ($project['otherFund'] ?? 'N/A') : ($project['sourceOfFunds'] ?? 'N/A') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5 ">
                                            <p class="d-block">Responsibility Center:</p>
                                        </div>
                                        <div class="col-md-7">
                                            <span
                                                style="font-weight: normal; color: black;">{{ $project['projectRC'] ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    @php
                                    $ongoingStatus = $projectStatusData['ongoingStatus'] ?? [];
                                    $totalPercentage = is_array($ongoingStatus) ? array_sum(array_column($ongoingStatus, 'percentage')) : 0;
                                    $latestDate = is_array($ongoingStatus) && count($ongoingStatus) > 0
                                        ? end($ongoingStatus)['date']
                                        : null;
                                    @endphp

                    
                                    <!-- Project Status Display -->
                                    <div class="row">
                                        <div class="col-md-5 ">
                                            <p class="d-block">Status:</p>
                                        </div> 
                                        <div class="col-md-7">
                                            <span class="badge bg-success me-2 text-white" style="font-weight: normal;">
                                                {{ $project['projectStatus'] ?? 'N/A' }}
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
                                                class="badge bg-danger text-white">{{ $project['projectSlippage'] ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
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

                    <div class="row">
                        <!-- Left Column: Project Description -->
                        <div class="col-md-6">
                            <fieldset class="border p-3 mb-4 rounded shadow-sm h-100">
                                <legend class="legend-text">Project Description</legend>
                                <div class="mb-3">
                                    <ul class="list-unstyled ps-3">
                                        @foreach ($project['projectDescriptions'] ?? [] as $desc)
                                            <li class="mb-1">• {{ $desc }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </fieldset>
                        </div>

 <!-- Right Column: Implementation Details -->
                            <div class="col-md-6 font-base">
                                <fieldset class="border p-3 mb-4 rounded shadow-sm h-100">
                                    <legend class="legend-text">Implementation Details</legend>
                                        <div class="row">
                                            <div class="col-md-5 ">
                                                <p class="d-block">Implementation Mode:</p>
                                            </div>
                                            <div class="col-md-7">
                                                <p style="font-weight: normal; color: black;">
                                                    {{ $project['modeOfImplementation'] ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-12" >
                                                <div class="row">
                                                    <div class="col-md-5" >
                                                        </div>
                                                    <div class="col-md-3"    >
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
                                                    <div class="col-md-5 " >
                                                            <p class="font-base">Notice of Award:</p>
                                                    </div>
                                                    <div class="col-md-3" >
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
                                                    <div class="col-md-5 " >
                                                            <p class="font-base">Notice to Proceed:</p>
                                                    </div>
                                                    <div class="col-md-3" >
                                                        <span style="font-weight: normal;">{{ $project['ntpIssuedDate'] ?? 'N/A' }}</span>
                                                    </div>
                                                    <div class="col-md-4" >
                                                        <span style="font-weight: normal;">{{ $project['ntpReceivedDate'] ?? 'N/A' }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-md-5 ">
                                                <p class="font-base">Original Starting Date:</p>
                                            </div>
                                            <div class="col-md-7">
                                                <p style="font-weight: normal; color: black;">
                                                    {{ $project['originalStartDate'] ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 ">
                                                <p class="font-base">Target Completion Date:</p>
                                            </div>
                                            <div class="col-md-7">
                                                <p style="font-weight: normal; color: black;">
                                                    {{ $project['targetCompletion'] ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5 ">
                                                <p class="font-base">Actual Date of Completion:</p>
                                            </div>
                                            <div class="col-md-7">
                                                <p style="font-weight: normal; color: black;">
                                                    {{ $project['completionDate'] ?? 'N/A' }}</p>
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
                                                    $indices[] = (int) $matches[1];
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

                                                if ($shouldShow)
                                                    $hasSuspension = true;
                                            @endphp

                                            @if ($shouldShow)
                                                {{-- Row: Suspension and Resume Order --}}
                                                <div class="row">
                                                    <div class="col-md-5 ">
                                                        <p class="font-base">Suspension Order No.
                                                            {{ $index }}:
                                                        </p>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <p style="font-weight: normal; color: black;">
                                                            {{ $suspensionValue ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5 ">
                                                        <p class="font-base">Resume Order No.
                                                            {{ $index }}:
                                                        </p>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <p style="font-weight: normal; color: black;">{{ $resumeValue ?? 'N/A' }}
                                                        </p>
                                                    </div>
                                                </div>
                                                {{-- Row: Suspension Remarks --}}
                                                <div class="row">
                                                    <div class="row">
                                                        <div class="col-md-5 ">
                                                            <p class="font-base">Suspension Remarks:</p>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <p style="font-weight: normal; color: black;">{{ $remarks ?? 'N/A' }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach                                 
                            


                                        {{-- Time Extension, Revised Target & Completion Dates --}}
                                        @if ($hasSuspension)
                                            <div class="row">
                                                <div class="col-md-5 ">
                                                    <p class="font-base">Time Extension:</p>
                                                </div>
                                                <div class="col-md-7">
                                                    <p style="font-weight: normal; color: black;">{{ $project['timeExtension'] ?? 'N/A' }}
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 ">
                                                    <p class="font-base">Revised Target Completion:</p>
                                                </div>
                                                <div class="col-md-7">
                                                    <p style="font-weight: normal; color: black;">
                                                        {{ $project['revisedTargetDate'] ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-5 ">
                                                    <p class="font-base">Revised Completion Date:</p>
                                                </div>
                                                <div class="col-md-7">
                                                    <p style="font-weight: normal; color: black;">
                                                        {{ $project['revisedCompletionDate'] ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        @endif
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
                                        <span class=" d-md-inline">Add Fund Utilization</span>
                                    </a>
                                </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Cost Breakdown -->
                                <fieldset class="border p-3 mb-4 rounded shadow-sm">
                                    <legend class="float-none w-auto px-2 fw-bold text-primary">Funds Source</legend>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped text-center align-middle" id="costBreakdownTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th rowspan="2">Category</th>
                                                    <th rowspan="2">Proposed</th>
                                                    <th colspan="{{ max(count($project['variation_orders'] ?? []), 1) }}">Variation Orders</th>
                                                    <th rowspan="2">Actual</th>
                                                </tr>
                                                <tr>
                                                    @php
                                                        $vos = $project['variation_orders'] ?? [];
                                                        $hasVO1 = collect($vos)->contains('vo_number', 1);
                                                    @endphp

                                                    {{-- Always show VO.1 --}}
                                                    <th>V.O. 1</th>

                                                    {{-- Show others if present and not VO.1 --}}
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
                                                        ['label' => 'Bid Difference', 'key' => 'bid'],
                                                        ['label' => 'Engineering', 'key' => 'engineering'],
                                                        ['label' => 'MQC', 'key' => 'mqc'],
                                                        ['label' => 'Contingency', 'key' => 'contingency'],
                                                    ];
                                                    $funds = $project['funds'] ?? [];
                                                    $vo1 = collect($vos)->firstWhere('vo_number', 1);
                                                @endphp

                                                @foreach ($rows as $row)
                                                    @php $key = $row['key']; @endphp
                                                    <tr>
                                                        <td>{{ $row['label'] }}</td>
                                                        <td>{{ number_format($funds['orig_' . $key] ?? 0, 2) }}</td>

                                                        {{-- Always show VO.1 --}}
                                                        <td>{{ number_format($vo1 ? ($vo1['vo_' . $key] ?? 0) : 0, 2) }}</td>

                                                        {{-- Show others if present and not VO.1 --}}
                                                        @foreach ($vos as $vo)
                                                            @if ($vo['vo_number'] != 1)
                                                                <td>{{ number_format($vo['vo_' . $key] ?? 0, 2) }}</td>
                                                            @endif
                                                        @endforeach

                                                        <td>{{ number_format($funds['actual_' . $key] ?? 0, 2) }}</td>
                                                    </tr>
                                                @endforeach
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
                                        <th>Show Breakdown</th>
                                        </tr>
                                    </thead>
                                    <tbody style="font-weight: normal;">
                                        @php
                                        if (!function_exists('ordinal')) {
                                            function ordinal($number) {
                                                $ends = ['th','st','nd','rd','th','th','th','th','th','th'];

                                                if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
                                                    return $number . 'th';
                                                }

                                                return $number . $ends[$number % 10];
                                            }
                                        }


                                        $summary = $project['summary'] ?? [];
                                        $partialBillings = $project['partial_billings'] ?? [];

                                        $summaryLabels = [
                                            'mobilization' => '15% Mobilization',
                                            'final' => 'Final Billing',
                                            'engineering' => 'Engineering',
                                            'mqc' => 'MQC',
                                        ];
                                        @endphp

                                        {{-- Mobilization --}}
                                        @php $mob = $summary['mobilization'] ?? null; @endphp
                                        <tr>
                                        <td>{{ $summaryLabels['mobilization'] }}</td>
                                        <td>{{ $mob['date'] ?? '-' }}</td>
                                        <td>{{ number_format($mob['amount'] ?? 0, 2) }}</td>
                                        <td>{{ $mob['remarks'] ?? '-' }}</td>
                                        <td>-</td>
                                        </tr>

                                        {{-- Partial Billings --}}
                                        @foreach ($partialBillings as $index => $billing)
                                        @if (!empty($billing['date']) || !empty($billing['amount']) || !empty($billing['remarks']))
                                            <tr>
                                            <td>{{ ordinal($index + 1) }} Partial Billing</td>
                                            <td>{{ $billing['date'] ?? '-' }}</td>
                                            <td>{{ number_format($billing['amount'] ?? 0, 2) }}</td>
                                            <td>{{ $billing['remarks'] ?? '-' }}</td>
                                            <td>-</td>
                                            </tr>
                                        @endif
                                        @endforeach

                                        {{-- Final Billing --}}
                                        @php $final = $summary['final'] ?? null; @endphp
                                        <tr>
                                        <td>{{ $summaryLabels['final'] }}</td>
                                        <td>{{ $final['date'] ?? '-' }}</td>
                                        <td>{{ number_format($final['amount'] ?? 0, 2) }}</td>
                                        <td>{{ $final['remarks'] ?? '-' }}</td>
                                        <td>-</td>
                                        </tr>

                                        {{-- Engineering --}}
                                        @php $eng = $summary['engineering'] ?? null; @endphp
                                        <tr>
                                        <td>{{ $summaryLabels['engineering'] }}</td>
                                        <td>{{ $eng['date'] ?? '-' }}</td>
                                        <td>{{ number_format((float) ($eng['amount'] ?? 0), 2) }}</td>
                                        <td>{{ $eng['remarks'] ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#engineeringBreakdown">
                                            View
                                            </button>
                                        </td>
                                        </tr>
                                        <tr class="collapse" id="engineeringBreakdown">
                                        <td colspan="5">
                                            <table class="table table-sm table-bordered text-center mb-0 w-100">
                                            <thead>
                                                <tr>
                                                <th>Name (Month - Payment Period)</th>
                                                <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($engineeringEntries as $eng)
                                                <tr>
                                                <td>{{ $eng->name }} ({{ $eng->month }} - {{ $eng->payment_periods }})</td>
                                                <td>{{ number_format($eng->amount, 2) }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                <td colspan="2" class="text-muted">No entries found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            </table>
                                        </td>
                                        </tr>

                                        {{-- MQC --}}
                                        @php $mqc = $summary['mqc'] ?? null; @endphp
                                        <tr>
                                        <td>{{ $summaryLabels['mqc'] }}</td>
                                        <td>{{ $mqc['date'] ?? '-' }}</td>
                                        <td>{{ number_format((float) ($mqc['amount'] ?? 0), 2) }}</td>

                                        <td>{{ $mqc['remarks'] ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse" data-bs-target="#mqcBreakdown">
                                            View
                                            </button>
                                        </td>
                                        </tr>
                                        <tr class="collapse" id="mqcBreakdown">
                                        <td colspan="5">
                                            <table class="table table-sm table-bordered text-center mb-0 w-100">
                                            <thead>
                                                <tr>
                                                <th>Name (Month - Payment Period)</th>
                                                <th>Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($mqcEntries as $mqc)
                                                <tr>
                                                <td>{{ $mqc->name }} ({{ $mqc->month }} - {{ $mqc->payment_periods }})</td>
                                                <td>{{ number_format($mqc->amount, 2) }}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                <td colspan="2" class="text-muted">No entries found.</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                            </table>
                                        </td>
                                        </tr>

                                        {{-- Totals --}}
                                            <tr class="fw-normal">
                                            <td>Total Expenditures</td>
                                            <td>-</td>
                                            <td>
                                                {{ number_format(
                                                    (float)($summary['totalExpenditures']['amount'] ?? 0),
                                                    2
                                                ) }}
                                            </td>
                                            <td>{{ $summary['remarks_total_expenditures'] ?? '-' }}</td>
                                            <td>-</td>
                                            </tr>
                                            <tr class="fw-normal">
                                            <td>Total Savings</td>
                                            <td>-</td>
                                            <td>
                                                {{ number_format(
                                                    (float)($summary['totalSavings']['amount'] ?? 0),
                                                    2
                                                ) }}
                                            </td>
                                            <td>{{ $summary['remarks_total_savings'] ?? '-' }}</td>
                                            <td>-</td>
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
 
            <!-- file Manment -->
            <div class="row font-content my-2">
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
            </div>
        </div>


    <script>
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

    @include('admin.modals.Projects.add-status')
    @include('admin.modals.Projects.edit-project')
    @include('admin.modals.Projects.uploadFiles')

@endsection
