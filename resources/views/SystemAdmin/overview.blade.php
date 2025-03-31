@extends('main.layout')

@section('title', 'Dashboard Page')

@section('content') 
                
               <!-- Project Overview -->
<hr class="mx-2">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 d-flex align-items-center gap-2">
            <a href="{{ route('main.projects') }}" class="btn btn-danger btn-sm">
                <span class="fa fa-arrow-left"></span>
            </a>
            <h5 class="m-0">Project Overview</h5>
        </div>
        <hr class="mt-2">
    </div>

    <div class="row">
        <div class="col-md-11">
            <div class="card bg-light mb-1">
                <div class="card-header">
                    <strong id="projectTitleDisplay">Loading...</strong>
                </div>
                <div class="card-body" style="font-size: 14px;">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Project Details -->
                            <div class="row p-1 border-bottom">
                                <div class="col-md-4"><strong>Location:</strong></div>
                                <div class="col-md-8" id="projectLocDisplay">Loading...</div>
                            </div>
                            <div class="row p-1 border-bottom">
                                <div class="col-md-4"><strong>Project Description:</strong></div>
                                <div class="col-md-8" id="projectDescriptionDisplay">Loading...</div>
                            </div>
                            <div class="row p-1 border-bottom">
                                <div class="col-md-4"><strong>Contractor:</strong></div>
                                <div class="col-md-8" id="projectContractorDisplay">Loading...</div>
                            </div>
                            <div class="row p-1 border-bottom">
                                <div class="col-md-4"><strong>Project ID:</strong></div>
                                <div class="col-md-8" id="projectIDDisplay">Loading...</div>
                            </div>
                            <div class="row p-1 border-bottom">
                                <div class="col-md-4"><strong>Status:</strong></div>
                                <div class="col-md-8">
                                    <span class="badge bg-success" id="projectStatusDisplay">Loading...</span>
                                    <span id="ongoingStatusDisplay" style="margin-left: 10px;">Loading...</span>
                                </div>
                            </div>
                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Notice of Award:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="noticeOfAwardDisplay">Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Official Start:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="officialStartDisplay">Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Target Completion:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="targetCompletionDisplay">Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Suspension Order No. 1:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="suspensionOrderNoDisplay">Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Resume Order No. 1:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="resumeOrderNoDisplay">Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Time Extension:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="timeExtensionDisplay">Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Revised Target Completion:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="revisedTargetCompletionDisplay">Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Completion Date:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="completionDateDisplay">Loading...
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6">
                                            <!-- Financial Details -->
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4"><strong>ABC:</strong></div>
                                                <div class="col-md-8 currency-input" id="abcDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4"><strong>Contract Amount:</strong></div>
                                                <div class="col-md-8 currency-input" id="contractAmountDisplay">Loading...</div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Engineering:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center currency-input" id="engineeringDisplay">
                                                    Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>MQC:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center currency-input" id="mqcDisplay">
                                    Loading...
                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Contingency:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center currency-input" id="contingencyDisplay">
                                    Loading...
                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Bid Difference:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center currency-input" id="bidDisplay">
                                    Loading...
                                </div>
                                </div>
                                <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Appropriation:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center currency-input" id="appropriationDisplay">
                                    Loading...
                                </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="col-md-1 d-flex flex-column align-items-center">
            <button type="button" class="btn btn-success btn-sm mb-2 w-100" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="fa fa-upload"></i>
            </button>
            <button type="button" class="btn btn-info btn-sm mb-2 w-100">
                <i class="fa fa-file"></i>
            </button>
            <button type="button" id="editProjectBtn" class="btn btn-warning btn-sm mb-2 w-100" data-bs-toggle="modal" data-bs-target="#projectModal">
                <i class="fa fa-edit"></i>
            </button>
            <button class="btn btn-primary btn-sm mb-2 w-100">
                <i class="fa fa-download"></i>
            </button>
            <button type="button" id="trashProjectBtn" class="btn btn-danger btn-sm w-100" data-bs-toggle="modal" data-bs-target="#trashModal">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel"> 
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" enctype="multipart/form-data">
                   
                    <div class="mb-3">
                        <label for="file" class="form-label">Choose File</label>
                        <input type="file" id="file" class="form-control" accept="image/*, .pdf, .docx, .xlsx, .zip">
                        <small class="text-muted">Accepted: Images, PDF, DOCX, XLSX, ZIP</small>
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreviewContainer" class="text-center" style="display: none;">
                        <img id="imagePreview" src="" class="img-thumbnail" style="max-width: 100px;">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Upload</button>
                </form>
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




<div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="projectModalLabel">Edit Project Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="updateProjectForm">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label for="projectTitle" class="form-label">Project Title</label>
                                <input type="text" class="form-control" id="projectTitle">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="projectLoc" class="form-label">Location</label>
                                <input type="text" class="form-control" id="projectLoc">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="projectID" class="form-label">Project ID</label>
                                <input type="text" class="form-control" id="projectID">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="projectContractor" class="form-label">Contractor</label>
                                <input type="text" class="form-control" id="projectContractor">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="sourceOfFunds" class="form-label fw-bolder">Select Fund Source</label>
                                <select id="sourceOfFunds" class="form-select" alt="source">
                                    <option value="">-- --</option>
                                    <option value="Wages">Wages</option>
                                    <option value="% Mobilization">% Mobilization</option>
                                    <option value="1st Partial Billing">1st Partial Billing</option>
                                    <option value="Trust Fund">Trust Fund</option>
                                    <option value="Final Billing">Final Billing</option>
                                    <option value="Others" id="otherFundContainer">Others</option>
                                </select>

                                <!-- Hidden text input for 'Others' -->
                                <div id="otherFundContainer" class="mt-2 fw-bolder" style="display: none;">
                                    <label for="otherFund" class="form-label">Please specify:</label>
                                    <input type="text" id="otherFund" class="form-control" placeholder="Enter fund source">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="contractor" class="form-label">Mode of Implementation</label>
                                <input type="text" class="form-control" id="modeOfImplementation">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="projectStatus" class="form-label fw-bolder">Status</label>
                                <select id="projectStatus" name="projectStatus" class="form-select">
                                    <option value="---">---</option>
                                    <option value="Ongoing">Ongoing</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Discontinued</option>
                                </select>

                                <!-- Hidden text input for 'Ongoing' status -->
                                <div id="ongoingStatusContainer" class="mt-2 fw-bolder" style="display: none;">
                                    <label for="ongoingStatus" class="form-label">Please specify percentage completion:</label>
                                    <div class="d-flex gap-2"> 
                                        <input type="text" id="ongoingStatus" name="ongoingStatus" class="form-control w-50" placeholder="Enter percentage">
                                        <input type="date" id="ongoingDate" class="form-control w-50">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label for="projectDescription" class="form-label">Project Description</label>
                                <textarea class="form-control" id="projectDescription" rows="3" style="width:100%"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row text-center">
                        <div class="row">
                            <h6 class=" m-1 fw-bold">Contract Details</h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="projectContractDays" class="form-label">Contract Days</label>
                                <input type="text" class="form-control" id="projectContractDays">
                            </div>   
                            <div class="mb-1">
                                <label for="noticeOfAward" class="form-label">Notice of Award</label>
                                <input type="date" class="form-control" id="noticeOfAward">
                            </div>  
                            <div class="mb-1">
                                <label for="noticeToProceed" class="form-label">Notice to Proceed</label>
                                <input type="date" class="form-control" id="noticeToProceed">
                            </div>  
                            <div class="mb-1">
                                <label for="officialStart" class="form-label">Official Start</label>
                                <input type="date" class="form-control" id="officialStart">
                            </div> 
                            <div class="mb-1">
                                <label for="targetCompletion" class="form-label">Target Completion</label>
                                <input type="date" class="form-control" id="targetCompletion">
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="SuspeOrder" class="form-label">Suspension Order No.1</label>
                                <input type="date" class="form-control" id="suspensionOrderNo">
                            </div> 
                            <div class="mb-1">
                                <label for="resumeOrder" class="form-label">Resume Order No.1</label>
                                <input type="date" class="form-control" id="resumeOrderNo">
                            </div> 
                            <div class="mb-1">
                                <label for="timeExtension" class="form-label">Time Extension</label>
                                <input type="text" class="form-control" id="timeExtension">
                            </div> 
                            <div class="mb-1">
                                <label for="revisedTargetCompletion" class="form-label">Revised Target Completion</label>
                                <input type="text" class="form-control" id="revisedTargetCompletion">
                            </div> 
                            <div class="mb-1">
                                <label for="CompletionDate" class="form-label">Completion Date</label>
                                <input type="text" class="form-control" id="completionDate">
                            </div> 
                        </div>
                    </div>
                    <div class="row text-center">
                         <h6 class="m-1 fw-bold">Financial Details</h6>
                    </div>
                        <!-- Financial Details -->
                    <div class="row">
                        <div class="col-md-6 border-bottom">
                            <div class="mb-1">
                                <label for="abc" class="form-label">ABC</label>
                                <input type="text" class="form-control" id="abc">
                            </div>
                            <div class="mb-1">
                                <label for="contractAmount" class="form-label">Contract Amount</label>
                                <input type="text" class="form-control" id="contractAmount">
                            </div>
                            <div class="mb-1">
                                <label for="engineering" class="form-label">Engineering</label>
                                <input type="text" class="form-control" id="engineering">
                            </div>
                            <div class="mb-1">
                                <label for="mqc" class="form-label">MQC</label>
                                <input type="text" class="form-control" id="mqc">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="contingency" class="form-label">Contingency</label>
                                <input type="text" class="form-control" id="contingency">
                            </div>
                            <div class="mb-1">
                                <label for="bid" class="form-label">Bid Difference</label>
                                <input type="text" class="form-control" id="bid">
                            </div>
                            <div class="mb-1">
                                <label for="appropriation" class="form-label">Appropriation</label>
                                <input type="text" class="form-control" id="appropriation">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection