@extends('systemAdmin.layout')

@section('title', 'Overview Page')

@section('content') 
                
<!-- Project Overview -->
<hr class="mx-2">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('systemAdmin.projects') }}" class="btn btn-danger btn-sm">
                    <span class="fa fa-arrow-left"></span>
                </a>
                <h5 class="m-0">Project Overview</h5>
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
                                        <div class="col-md-5  text-end"><strong>Mode of Implementation:</strong></div>
                                        <div class="col-md-7" id="modeOfImplementationDisplay">Loading...</div>
                                    </div>
                                    <div class="row p-1"> <!-- Just added-->
                                        <div class="col-md-5  text-end"><strong>Source of Fund:</strong></div>
                                        <div class="col-md-7" id="sourceOfFundsDisplay" name="sourceOfFundDisplay">Loading...</div>
                                    </div>
                                    <div class="row p-1">
                                        <div class="col-md-5 text-end"><strong>Status:</strong></div>
                                        <div class="col-md-7">
                                            <span class="badge bg-success" id="projectStatusDisplay">Loading...</span>
                                            <span id="ongoingStatusDisplay" style="margin-left: 10px;">Loading...</span>
                                        </div>
                                    </div>
                                    <div class="row p-1"><!--Just Added-->
                                        <div class="col-md-5 text-end"><strong>Slippage:</strong></div>
                                        <div class="col-md-7">
                                            <span class="badge bg-success" id="projectSlippageDisplay">Loading...</span>
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
                                        <div class="col-md-7 d-flex align-items-center currency-input" id="appropriationDisplay">
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
                                    <div class="row">
                                        <div class="col-md-12 text-center"><strong>ORIGINAL</strong></div>
                                    </div>
                                    <div class="row p-1"> <!--Just Added-->
                                        <div class="col-md-5 text-end">
                                            <strong>ABC:</strong>
                                        </div>
                                        <div class="col-md-7 d-flex align-items-center currency-input" id="abcOriginalDisplay">
                                            Loading...
                                        </div>
                                    </div>
                                    <div class="row p-1">
                                        <div class="col-md-5 text-end">
                                            <strong>Contract Amount:</strong>
                                        </div>
                                        <div class="col-md-7 d-flex align-items-center currency-input" id="contractAmountOriginalDisplay">
                                            Loading...
                                        </div>
                                    </div>
                                    <div class="row p-1">
                                        <div class="col-md-5 text-end">
                                            <strong>Engineering:</strong>
                                        </div>
                                        <div class="col-md-7 d-flex align-items-center currency-input" id="engineeringOriginalDisplay">
                                            Loading...
                                        </div>
                                    </div>
                                    <div class="row p-1">
                                        <div class="col-md-5 text-end">
                                            <strong>MQC:</strong>
                                        </div>
                                        <div class="col-md-7 d-flex align-items-center currency-input" id="mqcOriginalDisplay">
                                            Loading...
                                        </div>
                                    </div>
                                    <div class="row p-1">
                                        <div class="col-md-5 text-end">
                                            <strong>Contingency:</strong>
                                        </div>
                                        <div class="col-md-7 d-flex align-items-center currency-input" id="contingencyOriginalDisplay">
                                            Loading...
                                        </div>
                                    </div>
                                    <div class="row p-1">
                                        <div class="col-md-5 text-end"><strong>Bid Difference:</strong></div>
                                        <div class="col-md-7 d-flex align-items-center currency-input" id="bidDiffOriginalDisplay">
                                            Loading...
                                        </div>
                                    </div>
                                    <div class="row p-1">
                                        <div class="col-md-5 text-end"><strong>Total Expenditure:</strong></div>
                                        <div class="col-md-7 d-flex align-items-center currency-input" id="totalExpenditureOriginalDisplay">
                                            Loading...
                                        </div>
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
                                            <div class="col-md-8 d-flex align-items-center" id="suspensionOrderNoDisplay">Loading...
                                            </div>
                                        </div>
                                        <div class="row p-1 border-bottom">
                                            <div class="col-md-4 d-flex align-items-center">
                                                <strong>Resume Order No. 1:</strong>
                                            </div>
                                            <div class="col-md-8 d-flex align-items-center" id="resumeOrderNoDisplay">Loading...</div>
                                        </div>
                                        <div class="row p-1 border-bottom">
                                            <div class="col-md-4 d-flex align-items-center">
                                                <strong>Time Extension:</strong>
                                            </div>
                                            <div class="col-md-8 d-flex align-items-center" id="timeExtensionDisplay">Loading...</div>
                                        </div>
                                        <div class="row p-1 border-bottom">
                                            <div class="col-md-4 d-flex align-items-center">
                                                <strong>Revised Target Completion:</strong>
                                            </div>
                                            <div class="col-md-8 d-flex align-items-center" id="revisedTargetCompletionDisplay">Loading...</div>
                                        </div>
                                        <div class="row p-1 border-bottom">
                                            <div class="col-md-4 d-flex align-items-center">
                                                <strong>Completion Date:</strong>
                                            </div>
                                            <div class="col-md-8 d-flex align-items-center" id="completionDateDisplay">Loading...</div>
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
            <form id="updateProjectForm" name="updateProjectForm">
                    @csrf
                    <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-1">
                                            <label for="projectTitle" class="form-label">Project Title</label>
                                            <textarea class="form-control" id="projectTitle" name="projectTitle" rows="2" placeholder="Enter project title." required></textarea>
                                    </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-1">
                                                <label for="projectLoc" class="form-label">Location</label>
                                                <input type="text" class="form-control" id="projectLoc" name="projectLoc" required placeholder="Enter municipality, Nueva Vizcaya" onkeyup="showMunicipalitySuggestions(this.value)">
                                            <div id="suggestionsBox" class="list-group" style="display:none;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-1">
                                            <label for="projectDescription" class="form-label">Project Description</label>
                                            <textarea class="form-control" id="projectDescription" name="projectDescription" rows="3" placeholder="Enter project description."></textarea>
                                    </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label for="projectID" class="form-label">Project ID</label>
                                            <input type="text" class="form-control" id="projectID" name="projectID" required placeholder="Enter project ID">
                                        </div> 
                                          <div class="mb-1">
                                                <label for="projectContractor" class="form-label">Contractor</label>
                                                <select id="projectContractor" name="projectContractor" class="form-select">
                                                    <option value="">--Select Contractor--</option>
                                                    @foreach($contractors as $contractor)
                                                        <option value="{{ $contractor->name }}">{{ $contractor->name }}</option>
                                                    @endforeach
                                                    <option value="Others">Others: (Specify)</option>
                                                </select>
                                            </div>

                                            <!-- Hidden textbox for specifying 'Others' -->
                                            <div class="mb-1" id="othersContractorDiv" style="display: none;">
                                                <label for="othersContractor" class="form-label">Specify New Contractor</label>
                                                <input type="text" class="form-control" id="othersContractor" name="othersContractor"
                                                    placeholder="Enter new contractor">
                                            </div>

                                        <div class="mb-1">
                                            <label for="modeOfImplementation" class="form-label">Mode of Implementation</label>
                                            <input type="text" class="form-control" id="modeOfImplementation" name="modeOfImplementation" placeholder="Enter mode of implementation." value="By contract">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label for="sourceOfFunds" class="form-label">Source of Fund</label>
                                            <select id="sourceOfFunds" name="sourceOfFunds" class="form-select" onchange="toggleOtherFund()">
                                                <option value="">-- --</option>
                                                <option value="Wages">Wages</option>
                                                <option value="% Mobilization">15% Mobilization</option>
                                                <option value="Trust Fund">Trust Fund</option>
                                                <option value="Final Billing">Final Billing</option>
                                                <option value="Others">Others</option>
                                            </select>

                                            <!-- Hidden text input for 'Others' -->
                                            <div id="otherFundContainer" class="mt-2" style="display: none;">
                                                <label for="otherFund" class="form-label">Please specify:</label>
                                                <input type="text" id="otherFund" name="otherFund" class="form-control" placeholder="Enter fund source">
                                        </div>
                                        </div>
                                    
                                       
                                        <div class="mb-1">
                                            <label for="projectSlippage" class="form-label">Slippage</label>
                                            <input type="text" class="form-control" id="projectSlippage" name="projectSlippage" placeholder="Enter slippage">
                                        </div>
                                    </div>
                                </div>

                                <hr class="w-50 mx-auto" style="border-color: red;">
                                
                                <div class="row text-center">
                                <div class="row">
                                    <h6 class=" m-1 fw-bold">Contract Details</h6>
                                </div>
                            </div>

                            <hr class="w-50 mx-auto" style="border-color: red;">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="mb-1">
                                            <label for="appropriation" class="form-label">Appropriation</label>
                                            <input type="text" class="form-control currency-input" id="appropriation" name="appropriation">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-1">
                                            <label for="contractCost" class="form-label">Contract Cost</label>
                                            <input type="text" class="form-control currency-input" id="contractCost" name="contractCost">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-1">
                                            <label for="revisedConstractCost" class="form-label">Revised Contract Cost</label>
                                            <input type="number" class="form-control currency-input" id="revisedConstractCost" name="revisedConstractCost" min="0">
                                        </div>
                                    </div>                                    
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="mb-1">
                                            <label for="projectContractDays" class="form-label">Contract Days</label>
                                            <input type="number" class="form-control" id="projectContractDays" name="projectContractDays" min="0">
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="mb-1">
                                            <label for="officialStart" class="form-label">Official Start</label>
                                            <input type="date" class="form-control" id="officialStart" name="officialStart">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-1">
                                            <label for="targetCompletion" class="form-label">Target Completion</label>
                                            <input type="date" class="form-control" id="targetCompletion" name="targetCompletion">
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6"> 
                                    <div class="row">
                                        <div class="row text-center">
                                            <h6 class=" m-1 fw-bold">Notice of Award</h6>
                                        </div> 
                                        <div class="mb-1">
                                            <label for="noaIssuedDate" class="form-label">Issued Date</label>
                                            <input type="date" class="form-control" id="noaIssuedDate" name="noaIssuedDate">
                                        </div> 
                                        <div class="mb-1">
                                            <label for="noaReceivedDate" class="form-label">Received Date</label>
                                            <input type="date" class="form-control" id="noaReceivedDate" name="noaReceivedDate">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">                                          
                                        <div class="row text-center">
                                            <h6 class=" m-1 fw-bold">Notice to Proceed</h6>
                                        </div> 
                                        <div class="mb-1">
                                            <label for="ntpIssuedDate" class="form-label">Issued Date</label>
                                            <input type="date" class="form-control" id="ntpIssuedDate" name="ntpIssuedDate">
                                        </div> 
                                        <div class="mb-1">
                                            <label for="ntpReceivedDate" class="form-label">Received Date</label>
                                            <input type="date" class="form-control" id="ntpReceivedDate" name="ntpReceivedDate">
                                        </div> 
                                    </div>                                                                 
                                </div>  
                            </div> 
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="originalExpiryDate" class="form-label">Original Expiry Date</label>
                                    <input type="date" class="form-control" id="originalExpiryDate" name="originalExpiryDate">
                                </div>
                                <div class="col-md-6">
                                    <label for="revisedExpiryDate" class="form-label">Revised Expiry Date</label>
                                    <input type="date" class="form-control" id="revisedExpiryDate" name="revisedExpiryDate">
                                </div> 
                            </div> 
                                
                                
                            <div class="row">   
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="abc" class="form-label">ABC</label>
                                        <input type="text" class="form-control currency-input" id="abc" name="abc">
                                    </div>
                                    <div class="mb-1">
                                        <label for="contractAmount" class="form-label">Contract Amount</label>
                                        <input type="text" class="form-control currency-input" id="contractAmount" name="contractAmount">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="engineering" class="form-label">Engineering</label>
                                        <input type="text" class="form-control currency-input" id="engineering" name="engineering">
                                    </div>                                        
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="mqc" class="form-label">MQC</label>
                                        <input type="text" class="form-control currency-input" id="mqc" name="mqc">
                                    </div>
                                    <div class="mb-1">
                                        <label for="bid" class="form-label">Contingency</label>
                                        <input type="text" class="form-control currency-input" id="contingency" name="contingency">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="bid" class="form-label">Bid Difference</label>
                                        <input type="text" class="form-control currency-input" id="bid" name="bid">
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="totalExpenditure" class="form-label">Total Expenditure</label>
                                    <input type="text" class="form-control currency-input" id="totalExpenditure" name="totalExpenditure">
                                </div>
                            </div>

                            <hr class="w-50 mx-auto" style="border-color: red;">

                            <div class="row text-center">
                                <div class="row">
                                    <h6 class=" m-1 fw-bold">Implementation Details</h6>
                                </div>
                            </div>

                            <hr class="w-50 mx-auto" style="border-color: red;">

                            <div class="container">
                                <div class="row align-items-center">
                                    <!-- Buttons above the order fields -->
                                    <div class="col-12 text-end mb-0">
                                        <button type="button" class="btn btn-outline-primary btn-sm mr-1" onclick="addOrderFields()" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Suspension and Resumption Order">
                                            <span class="fa-solid fa-square-plus"></span>                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeLastOrderFields()" data-bs-toggle="tooltip" data-bs-placement="top" title=" Suspension and Resumption Order">
                                            <span class="fa-solid fa-circle-minus"></span>
                                        </button>
                                    </div>

                                    <!-- Order pair container -->
                                    <div id="orderContainer" class="col-12">
                                        <div class="row mb-3 order-set" id="orderSet1">
                                            <div class="col-md-6 mb-1">
                                                <label for="suspensionOrderNo1" class="form-label">Suspension Order No. 1</label>
                                                <input type="date" class="form-control" id="suspensionOrderNo1" name="suspensionOrderNo1">
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <label for="resumeOrderNo1" class="form-label">Resumption Order No. 1</label>
                                                <input type="date" class="form-control" id="resumeOrderNo1" name="resumeOrderNo1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="timeExtension" class="form-label">Time Extension</label>
                                        <input type="text" class="form-control" id="timeExtension" name="timeExtension" value="">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="revisedTargetCompletion" class="form-label">Revised Target Completion</label>
                                        <input type="text" class="form-control" id="revisedTargetCompletion" name="revisedTargetCompletion" value="">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-1">
                                            <label for="completionDate" class="form-label">Completion Date</label>
                                            <input type="text" class="form-control" id="completionDate" name="completionDate" value="">
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
            </div>

            <!-- Bootstrap Modal -->
            <div class="modal fade" id="generateProjectModal" tabindex="-1" aria-labelledby="generateProjectLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="generateProjectLabel">Generate Project Report</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to generate the project report?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" id="confirmGenerateBtn" class="btn btn-primary">Generate</button>
                        </div>
                    </div>
                </div>
            </div>


             <!-- Fund Utilization -->
             <div class="modal fade" id="ProjectFundUtilization" tabindex="-1" aria-labelledby="ProjectFundUtilizationLabel" aria-hidden="true">
                <div class="modal-dialog  modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="appNewProjectLabel">Fund Utilization </h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="addFundUtilization" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-1">
                                            <label for="projectTitleFU" class="form-label">Project Title</label>
                                            <textarea class="form-control" id="projectTitleFU" name="projectTitleFU" rows="2" placeholder="Enter project title." required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">   
                                    <div class="row text-center">
                                        <div class="row">
                                            <h6 class=" m-1 fw-bold">Original</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label for="orig_abc" class="form-label">ABC</label>
                                            <input type="text" class="form-control currency-input" id="orig_abc" name="orig_abc">
                                        </div>
                                        <div class="mb-1">
                                            <label for="orig_contract_amount" class="form-label">Contract Amount</label>
                                            <input type="text" class="form-control currency-input" id="orig_contract_amount" name="orig_contract_amount">
                                        </div> 
                                        <div class="mb-1">
                                            <label for="orig_engineering" class="form-label">Engineering</label>
                                            <input type="text" class="form-control currency-input" id="orig_engineering" name="orig_engineering">
                                        </div>
                                        <div class="mb-1">
                                            <label for="orig_mqc" class="form-label">MQC</label>
                                            <input type="text" class="form-control currency-input" id="orig_mqc" name="orig_mqc">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label for="orig_contingency" class="form-label">Contingency</label>
                                            <input type="text" class="form-control currency-input" id="orig_contingency" name="orig_contingency">
                                        </div>
                                        <div class="mb-1">
                                            <label for="orig_bid" class="form-label">Bid Difference</label>
                                            <input type="text" class="form-control currency-input" id="orig_bid" name="orig_bid">
                                        </div>
                                        <div class="mb-1">
                                            <label for="orig_completion_date" class="form-label">Completion Date</label>
                                            <input type="date" class="form-control" id="orig_completion_date" name="orig_completion_date">
                                        </div> 
                                        <div class="mb-1">
                                            <label for="appropriation" class="form-label">Appropriation</label>
                                            <input type="text" class="form-control currency-input" id="orig_appropriation" name="orig_appropriation">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="container">
                                        <div class="row align-items-center">
                                            <!-- Buttons above the order fields -->
                                            <div class="col-md-10">
                                                <hr>
                                            </div>   
                                            <div class="col-2 text-center mb-0">
                                                <button type="button" class="btn btn-outline-primary btn-sm mr-1" onclick="addVOFields()" data-bs-toggle="tooltip" data-bs-placement="top" title="Add V.O.">
                                                    <span class="fa-solid fa-square-plus"></span>                                        </button>
                                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeLastVOFields()" data-bs-toggle="tooltip" data-bs-placement="top" title="Remove Last V.O.">
                                                    <span class="fa-solid fa-circle-minus"></span>
                                                </button>
                                            </div>
                                            <!-- Order pair container -->
                                            <div id="voContainer" class="col-12">
                                                <div class="row text-center">
                                                    <div class="row">
                                                        <h6 class=" m-1 fw-bold">V.O.1</h6>
                                                    </div>
                                                </div>
                                                <div class="row mb-3 order-set" id="voSet1">
                                                    <div class="col-md-6">
                                                        <div class="mb-1">
                                                            <label for="vo_abc" class="form-label">ABC</label>
                                                            <input type="text" class="form-control currency-input" id="vo_abc" name="vo_abc">
                                                        </div>
                                                        <div class="mb-1">
                                                            <label for="vo_contract_amount" class="form-label">Contract Amount</label>
                                                            <input type="text" class="form-control currency-input" id="vo_contract_amount" name="vo_contract_amount">
                                                        </div> 
                                                        <div class="mb-1">
                                                            <label for="vo_engineering" class="form-label">Engineering</label>
                                                            <input type="text" class="form-control currency-input" id="vo_engineering" name="vo_engineering">
                                                        </div>
                                                        <div class="mb-1">
                                                            <label for="vo_mqc" class="form-label">MQC</label>
                                                            <input type="text" class="form-control currency-input" id="vo_mqc" name="vo_mqc">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-1">
                                                            <label for="vo_contingency" class="form-label">Contingency</label>
                                                            <input type="text" class="form-control currency-input" id="vo_contingency" name="vo_contingency">
                                                        </div>
                                                        <div class="mb-1">
                                                            <label for="vo_bid" class="form-label">Bid Difference</label>
                                                            <input type="text" class="form-control currency-input" id="vo_bid" name="vo_bid">
                                                        </div>
                                                        <div class="mb-1">
                                                            <label for="vo_completion_date" class="form-label">Completion Date</label>
                                                            <input type="date" class="form-control" id="vo_completion_date" name="vo_completion_date">
                                                        </div> 
                                                        <div class="mb-1">
                                                            <label for="vo_appropriation" class="form-label">Appropriation</label>
                                                            <input type="text" class="form-control currency-input" id="vo_appropriation" name="vo_appropriation">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                           

                                <div class="row">   
                                    <div class="row text-center">
                                        <div class="row">
                                            <h6 class=" m-1 fw-bold">Actual</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="mb-1">
                                            <label for="actual_abc" class="form-label">ABC</label>
                                            <input type="text" class="form-control currency-input" id="actual_abc" name="actual_abc">
                                        </div>
                                    <div class="mb-1">
                                            <label for="actual_contract_amount" class="form-label">Contract Amount</label>
                                            <input type="text" class="form-control currency-input" id="actual_contract_amount" name="actual_contract_amount">
                                        </div> 
                                    <div class="mb-1">
                                            <label for="actual_engineering" class="form-label">Engineering</label>
                                            <input type="text" class="form-control currency-input" id="actual_engineering" name="actual_engineering">
                                        </div>
                                        <div class="mb-1">
                                            <label for="actual_mqc" class="form-label">MQC</label>
                                            <input type="text" class="form-control currency-input" id="actual_mqc" name="actual_mqc">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label for="actual_contingency" class="form-label">Contingency</label>
                                            <input type="text" class="form-control currency-input" id="actual_contingency" name="actual_contingency">
                                        </div>
                                        <div class="mb-1">
                                            <label for="actual_bid" class="form-label">Bid Difference</label>
                                            <input type="text" class="form-control currency-input" id="actual_bid" name="actual_bid">
                                        </div>
                                        <div class="mb-1">
                                            <label for="actual_completion_date" class="form-label">Completion Date</label>
                                            <input type="text" class="form-control" id="actual_completion_date" name="actual_completion_date" value="">
                                        </div> 
                                      
                                        <div class="mb-1">
                                            <label for="actual_appropriation" class="form-label">Appropriation</label>
                                            <input type="text" class="form-control currency-input" id="actual_appropriation" name="actual_appropriation">
                                        </div>
                                    </div>
                                </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="button" id="submitFundsUtilization" class="btn btn-primary">Add Fund Utilization</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modern Modal for Checking Project Status -->
<div class="modal fade" id="checkStatusModal" tabindex="-1" aria-labelledby="checkStatusModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title d-flex align-items-center" id="checkStatusModalLabel">
          <i class="bi bi-clipboard-check me-2"></i> Project Status
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <div id="statusCards" class="row g-3">
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal for adding project status -->
<!-- Add Status Modal -->
<div class="modal fade" id="addStatusModal" tabindex="-1" aria-labelledby="addStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStatusModalLabel">Add Project Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addStatusForm">
                <div class="modal-body">
                    <!-- Project Title and Project ID -->
                    <div class="text-center mb-4">
                        <h4 id="projectTitleDisplay" class="text-primary">Project Title</h4>
                        <p id="projectIDDisplay" class="text-muted">Project ID: <span id="projectID"></span></p>
                    </div>

                    <!-- Progress Dropdown -->
                    <div class="mb-3">
                        <label for="progress" class="form-label">Progress</label>
                        <select class="form-select" id="progress" aria-label="Select project progress">
                            <option value="Ongoing">Ongoing</option>
                            <option value="Cancelled">Cancelled</option>
                            <option value="Completed">Completed</option>
                        </select>
                    </div>

                    <!-- Percentage Input -->
                    <div class="mb-3">
                        <label for="percentage" class="form-label">Percentage</label>
                        <input type="number" class="form-control" id="percentage" placeholder="Enter percentage">
                    </div>

                    <!-- Date Input with Checkbox for Auto Date -->
                    <div class="mb-3">
                        <label for="date" class="form-label">Date</label>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="autoDate" checked>
                            <label class="form-check-label" for="autoDate">Set to Current Date</label>
                        </div>
                        <input type="date" class="form-control" id="date" disabled>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit Status</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
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


        // Handle "Other Fund" Selection Toggle
        function toggleOtherFund() {
            var sourceOfFunds = document.getElementById("sourceOfFunds").value;
            var otherFundContainer = document.getElementById("otherFundContainer");

            if (sourceOfFunds === "Others") {
                otherFundContainer.style.display = "block";
            } else {
                otherFundContainer.style.display = "none";
            }
        }

        // Handle "Ongoing Status" Selection Toggle
        function toggleOngoingStatus() {
            let statusSelect = document.getElementById("projectStatus");
            let ongoingContainer = document.getElementById("ongoingStatusContainer");
            let ongoingDate = document.getElementById("ongoingDate");

            if (statusSelect.value === "Ongoing") {
                ongoingContainer.style.display = "block";

                // Set the ongoingDate to today's date
                let today = new Date().toISOString().split('T')[0];
                ongoingDate.value = today;
            } else {
                ongoingContainer.style.display = "none";
                ongoingDate.value = ""; // Clear the date when status is not "Ongoing"
            }
        }


        // Add Event Listener for Project Status Dropdown
        document.getElementById("projectStatus").addEventListener("change", function () {
            toggleOngoingStatus();
        });


        // Handle "Other Fund" Dropdown Change
        $('#sourceOfFunds').on('change', function () {
            if ($(this).val() === 'Others') {
                $('#otherFundContainer').slideDown(); // Show input with animation
            } else {
                $('#otherFundContainer').slideUp(); // Hide input with animation
            }
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

document.addEventListener("DOMContentLoaded", function () {
            const contractorSelect = document.getElementById("projectContractor");
            const othersContractorDiv = document.getElementById("othersContractorDiv");
            const othersContractorInput = document.getElementById("othersContractor");

            contractorSelect.addEventListener("change", function () {
                if (this.value === "Others") {
                    // Show the "Specify New Contractor" text box
                    othersContractorDiv.style.display = "block";
                } else {
                    // Hide the "Specify New Contractor" text box if anything else is selected
                    othersContractorDiv.style.display = "none";
                    othersContractorInput.value = ""; // Clear input if not "Others"
                }
            });
        });
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    function validateDates(issuedId, receivedId, label) {
      const issued = document.getElementById(issuedId);
      const received = document.getElementById(receivedId);

      function checkDate() {
        const issuedDate = new Date(issued.value);
        const receivedDate = new Date(received.value);

        if (issued.value && received.value && receivedDate <= issuedDate) {
          Swal.fire({
            icon: 'error',
            title: `${label} Error`,
            text: 'Received date must be after the issued date.',
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
    const startDateInput = document.getElementById("officialStart");
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

