@extends('systemAdmin.layout')

@section('title', 'Overview Page')

@section('content')

    <!-- Project Overview -->
    <hr class="mx-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <a class="{{ Request::is('systemAdmin/projects') ? 'bg-light-green text-dark-white' : 'inactive' }}"
                        aria-current="page" href="{{ url('/systemAdmin/projects') }}"><span
                            class="fa fa-arrow-left"></span></a>

                    <h5 class="m-0">Project Overview</h5>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#addProjectFundUtilization" title="Add Fund Utilization Details">
                        <span class="fa fa-plus"></span>
                    </button>
                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                        data-bs-target="#uploadModal" title="Upload Files">
                        <i class="fa fa-upload"></i>
                    </button>
                    <button type="button" id="editProjectBtn" class="btn btn-warning btn-sm" data-bs-toggle="modal"
                        data-bs-target="#projectModal" title="Edit Project Details">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" id="generateProjectBtn" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#generateProjectModal" title="Generate/Download Report">
                        <i class="fa fa-download"></i>
                    </button>
                    <button type="button" id="trashProjectBtn" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                        data-bs-target="#trashModal" title="Temporary Delete Project">
                        <i class="fa fa-trash"></i>
                    </button>
                </div>
            </div>
            <hr class="mt-2">
        </div>
            <!-- Action Buttons -->
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#ProjectFundUtilization" title="Add Fund Utilization Details">
                    <span class="fa fa-plus"></span>
                </button>
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#uploadModal" title="Upload Files">
                    <i class="fa fa-upload"></i>
                </button>
                <button type="button" id="editProjectBtn" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#projectModal" title="Edit Project Details">
                    <i class="fa fa-edit"></i>
                </button>   
                <button type="button" id="generateProjectBtn" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#generateProjectModal" title="Generate/Download Report">
                    <i class="fa fa-download"></i>
                </button>
                <button type="button" id="trashProjectBtn" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#trashModal" title="Temporary Delete Project">
                    <i class="fa fa-trash"></i>
                </button>
                <button type="button" id="checkStatusBtn" class="btn btn-secondary btn-sm mb-2 w-100" data-bs-toggle="modal" data-bs-target="#checkStatusModal">
                Check Status
            </button>
            </div>
        </div>
        <hr class="mt-2">
    </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card bg-light mb-1">
                    <div class="card-header">
                        <h5><strong id="projectTitleDisplay">Loading...</strong></h5>
                        <div class="row p-1 ">
                            <div class="d-flex align-items-center">
                                <strong class="me-2">Project ID:</strong>
                                <div id="projectIDDisplay">Loading...</div>
                            </div>
                        </div>
                        <div class="card-body" style="font-size: 14px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Project Details -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="fw-bold">Project Details</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row p-1">
                                                <div class="col-md-5  text-end"><strong>Project Description:</strong></div>
                                                <div class="col-md-7" id="projectDescriptionDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1">
                                                <div class="col-md-5 text-end"><strong>Location:</strong></div>
                                                <div class="col-md-7" id="projectLocDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1">
                                                <div class="col-md-5  text-end"><strong>Contractor:</strong></div>
                                                <div class="col-md-7" id="projectContractorDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1"> <!-- Just added-->
                                                <div class="col-md-5  text-end"><strong>Mode of Implementation:</strong>
                                                </div>
                                                <div class="col-md-7" id="modeOfImplementationDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1"> <!-- Just added-->
                                                <div class="col-md-5  text-end"><strong>Source of Fund:</strong></div>
                                                <div class="col-md-7" id="sourceOfFundDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1">
                                                <div class="col-md-5 text-end"><strong>Status:</strong></div>
                                                <div class="col-md-7">
                                                    <span class="badge bg-success"
                                                        id="projectStatusDisplay">Loading...</span>
                                                    <span id="ongoingStatusDisplay"
                                                        style="margin-left: 10px;">Loading...</span>
                                                </div>
                                            </div>
                                            <div class="row p-1"><!--Just Added-->
                                                <div class="col-md-5 text-end"><strong>Slippage:</strong></div>
                                                <div class="col-md-7">
                                                    <span class="badge bg-success"
                                                        id="projectSlippageDisplay">Loading...</span>
                                                    <span id="ongoingStatusDisplay"
                                                        style="margin-left: 10px;">Loading...</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--Contract Details-->
                                    <div class="card mt-1">
                                        <div class="card-header">
                                            <h6 class="fw-bold">Contract Details</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row p-1">
                                                <div class="col-md-5 text-end">
                                                    <strong>Appropriation:</strong>
                                                </div>
                                                <div class="col-md-7 d-flex align-items-center currency-input"
                                                    id="appropriationDisplay">
                                                    Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1"> <!-- Just added-->
                                                <div class="col-md-5 text-end"><strong>Contract Cost:</strong></div>
                                                <div class="col-md-7" id="contractCostDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1"> <!-- Just added-->
                                                <div class="col-md-5 text-end"><strong>Revised Contract Cost:</strong></div>
                                                <div class="col-md-7" id="contractRevContractCostDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1"> <!-- Just added-->
                                                <div class="col-md-5 text-end"><strong>Contract Days:</strong></div>
                                                <div class="col-md-7" id="contractDaysDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1 ">
                                                <div class="col-md-5 text-end">
                                                    <strong>Official Start:</strong>
                                                </div>
                                                <div class="col-md-7" id="officialStartDisplay">Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 ">
                                                <div class="col-md-5 text-end">
                                                    <strong>Target Completion Date:</strong>
                                                </div>
                                                <div class="col-md-7 d-flex align-items-center" id="completionDateDisplay">
                                                    Loading...
                                                </div>
                                            </div>
                                            <div class="row text-center">
                                                <div class="fw-bold">Notice of Award (NOA)</div>
                                            </div>
                                            <div class="row p-1 "><!-- Just added-->
                                                <div class="col-md-5 text-end">
                                                    <strong>Issued Date:</strong>
                                                </div>
                                                <div class="col-md-7 d-flex align-items-center" id="noaIssuedDateDisplay">
                                                    Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 "><!-- Just added-->
                                                <div class="col-md-5 text-end">
                                                    <strong>Received Date:</strong>
                                                </div>
                                                <div class="col-md-7" id="noaReceivedDateDisplay">
                                                    Loading...
                                                </div>
                                            </div>
                                            <div class="row text-center">
                                                <div class="fw-bold">Notice to Proceed (NTP)</div>
                                            </div>
                                            <div class="row p-1 "><!-- Just added-->
                                                <div class="col-md-5 text-end">
                                                    <strong>Issued Date:</strong>
                                                </div>
                                                <div class="col-md-7" id="ntpIssuedDateDisplay">
                                                    Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 "><!-- Just added-->
                                                <div class="col-md-5 text-end">
                                                    <strong>Received Date:</strong>
                                                </div>
                                                <div class="col-md-7" id="ntpReceivedDateDisplay">
                                                    Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1"><!-- Just added-->
                                                <div class="col-md-5 text-end"><strong>Original Expiry Date:</strong></div>
                                                <div class="col-md-7" id="originalExpiryDateDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1"><!-- Just added-->
                                                <div class="col-md-5 text-end"><strong>Revised Expiry Date:</strong></div>
                                                <div class="col-md-7" id="revisedExpiryDateDisplay">Loading...
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Project Details -->
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="fw-bold">Fund Utilization</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row p-1">
                                                <div class="col-md-5  text-end"><strong>Project Description:</strong></div>
                                                <div class="col-md-7" id="projectDescriptionDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1">
                                                <div class="col-md-5 text-end"><strong>Location:</strong></div>
                                                <div class="col-md-7" id="projectLocDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1">
                                                <div class="col-md-5  text-end"><strong>Contractor:</strong></div>
                                                <div class="col-md-7" id="projectContractorDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1"> <!-- Just added-->
                                                <div class="col-md-5  text-end"><strong>Mode of Implementation:</strong>
                                                </div>
                                                <div class="col-md-7" id="modeOfImplementationDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1"> <!-- Just added-->
                                                <div class="col-md-5  text-end"><strong>Source of Fund:</strong></div>
                                                <div class="col-md-7" id="sourceOfFundDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1">
                                                <div class="col-md-5 text-end"><strong>Status:</strong></div>
                                                <div class="col-md-7">
                                                    <span class="badge bg-success"
                                                        id="projectStatusDisplay">Loading...</span>
                                                    <span id="ongoingStatusDisplay"
                                                        style="margin-left: 10px;">Loading...</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 text-center"><strong>ORIGINAL</strong></div>
                                            </div>
                                            <div class="row p-1"> <!--Just Added-->
                                                <div class="col-md-5 text-end">
                                                    <strong>ABC:</strong>
                                                </div>
                                                <div class="col-md-7 d-flex align-items-center currency-input"
                                                    id="abcOriginalDisplay">
                                                    Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1">
                                                <div class="col-md-5 text-end">
                                                    <strong>Contract Amount:</strong>
                                                </div>
                                                <div class="col-md-7 d-flex align-items-center currency-input"
                                                    id="contractAmountOriginalDisplay">
                                                    Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1">
                                                <div class="col-md-5 text-end">
                                                    <strong>Engineering:</strong>
                                                </div>
                                                <div class="col-md-7 d-flex align-items-center currency-input"
                                                    id="engineeringOriginalDisplay">
                                                    Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1">
                                                <div class="col-md-5 text-end">
                                                    <strong>MQC:</strong>
                                                </div>
                                                <div class="col-md-7 d-flex align-items-center currency-input"
                                                    id="mqcOriginalDisplay">
                                                    Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1">
                                                <div class="col-md-5 text-end">
                                                    <strong>Contingency:</strong>
                                                </div>
                                                <div class="col-md-7 d-flex align-items-center currency-input"
                                                    id="contingencyOriginalDisplay">
                                                    Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1">
                                                <div class="col-md-5 text-end"><strong>Bid Difference:</strong></div>
                                                <div class="col-md-7 d-flex align-items-center currency-input"
                                                    id="bidDiffOriginalDisplay">
                                                    Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1">
                                                <div class="col-md-5 text-end"><strong>Total Expenditure:</strong></div>
                                                <div class="col-md-7 d-flex align-items-center currency-input"
                                                    id="totalExpenditureOriginalDisplay">
                                                    Loading...
                                                </div>
                                            </div>
                                        </div>
                                        <!--Implemetation Details-->
                                        <div class="card mt-1">
                                            <div class="card-header">
                                                <h6 class="fw-bold">Implementation Details</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row p-1 border-bottom">
                                                    <div class="col-md-4 d-flex align-items-center">
                                                        <strong>Suspension Order No. 1:</strong>
                                                    </div>
                                                    <div class="col-md-8 d-flex align-items-center"
                                                        id="suspensionOrderNoDisplay">Loading...
                                                    </div>
                                                </div>
                                                <div class="row p-1 border-bottom">
                                                    <div class="col-md-4 d-flex align-items-center">
                                                        <strong>Resume Order No. 1:</strong>
                                                    </div>
                                                    <div class="col-md-8 d-flex align-items-center"
                                                        id="resumeOrderNoDisplay">Loading...</div>
                                                </div>
                                                <div class="row p-1 border-bottom">
                                                    <div class="col-md-4 d-flex align-items-center">
                                                        <strong>Time Extension:</strong>
                                                    </div>
                                                    <div class="col-md-8 d-flex align-items-center"
                                                        id="timeExtensionDisplay">Loading...</div>
                                                </div>
                                                <div class="row p-1 border-bottom">
                                                    <div class="col-md-4 d-flex align-items-center">
                                                        <strong>Revised Target Completion:</strong>
                                                    </div>
                                                    <div class="col-md-8 d-flex align-items-center"
                                                        id="revisedTargetCompletionDisplay">Loading...</div>
                                                </div>
                                                <div class="row p-1 border-bottom">
                                                    <div class="col-md-4 d-flex align-items-center">
                                                        <strong>Completion Date:</strong>
                                                    </div>
                                                    <div class="col-md-8 d-flex align-items-center"
                                                        id="completionDateDisplay">Loading...</div>
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
    </div>
    
        <!-- Project Files Table -->
        <div class="container-fluid px-3">
            <div class="col-md-12 m-1">
                <div class="row">
                    <hr>
                    <h5 class="p-0">Project Files</h5>
                    <hr>
                </div>
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


    @include('systemAdmin.modals.add-fund')
    @include('systemAdmin.modals.edit-project')
    @include('systemAdmin.modals.uploadFiles')
    @include('systemAdmin.modals.generate-report')
    @include('systemAdmin.modals.check-status')

@endsection
