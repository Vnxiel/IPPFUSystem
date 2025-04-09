@extends('admin.layout')

@section('title', 'Dashboard Page')

@section('content') 
                
               <!-- Project Overview -->
<hr class="mx-2">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 d-flex align-items-center gap-2">
            <a href="{{ route('admin.projects') }}" class="btn btn-danger btn-sm">
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
                <hr class="mx-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 d-flex align-items-center gap-2">
                            <a href="{{ route('admin.projects') }}" type="button" class="btn btn-danger btn-sm"><span class="fa fa-arrow-left"></span></a>
                            <h5 class="m-0">Project Overview</h5>
                        </div>
                        <hr class="mt-2">
                    </div>
                    <div class="row">
                        <div class="col-md-11">
                            <div class="card bg-light mb-1">
                                <div class="card-header">
                                    <strong id="projectTitle">Construction of Barangay Multi-Purpose Hall</strong>
                                </div>
                                <div class="card-body" style="font-size: 14px;">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <!-- Project Details -->
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong id="projectLoc">Location:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    Barangay San Isidro, Quezon City
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong id="projectDescription">Project Description:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    Expansion of a 4-lane road to 6 lanes
                                                </div>                                                 
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong id="projectContractor">Contractor:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    JKL Builders & Co.
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong id="projectID">Project ID:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    003102025-01
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong id="modeOfImplementation">Mode of Implementation:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    Public Bidding
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong id="projectStatus">Status:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center">
                                                    <span class="badge bg-success" id="ongoingStatus">On-going</span>&nbsp;50% as of January 31, 2025
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
                <form id="updateProjectForm">
                    @csrf
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
                                <input type="text" class="form-control" id="modeOfImplementation" value="JKL Builders & Co.">
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
                                <label for="appropriate" class="form-label">Appropriation</label>
                                <input type="text" class="form-control" id="appropriate" value="PHP 2,500,000.00">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
        $(document).ready(function() {
            $('#editStatus').on('change', function() {
                if ($(this).val() === 'Ongoing') {
                    $('#ongoingStatusContainer').stop(true, true).slideDown();
                } else {
                    $('#ongoingStatusContainer').stop(true, true).slideUp();
                }
            });
        });
        $(document).ready(function() {
                $('#fundSource').on('change', function() {
                    if ($(this).val() === 'Others') {
                        $('#otherFundContainer').slideDown(); // Show input with animation
                    } else {
                        $('#otherFundContainer').slideUp(); // Hide input with animation
                    }
                });
            });   
            
            
            //...

            // Show Image Preview Before Upload
                function setupUploadModal() {
                    document.getElementById("file").addEventListener("change", function (event) {
                        let file = event.target.files[0];
                        let previewContainer = document.getElementById("imagePreviewContainer");
                        let previewImage = document.getElementById("imagePreview");

                        if (file && file.type.startsWith("image/")) {
                            let reader = new FileReader();
                            reader.onload = function (e) {
                                previewImage.src = e.target.result;
                                previewContainer.style.display = "block";
                            };
                            reader.readAsDataURL(file);
                        } else {
                            previewContainer.style.display = "none";
                        }
                    });
                }

                document.getElementById("uploadForm").addEventListener("submit", function (e) {
                    e.preventDefault();

                    // Fetch `projectID` first
                    fetch("/get-project-id", {
                        method: "GET",
                        headers: { "Accept": "application/json" }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.projectID) {
                            Swal.fire({
                                title: "Error",
                                text: "No project ID found in session. Please select a project first.",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                            return;
                        }

                        let projectID = data.projectID;
                        console.log("Retrieved Project ID:", projectID); // Debugging

                        let fileInput = document.getElementById("file");
                        if (!fileInput.files.length) {
                            Swal.fire({
                                title: "Warning",
                                text: "Please select a file to upload.",
                                icon: "warning",
                                confirmButtonText: "OK"
                            });
                            return;
                        }

                        let formData = new FormData();
                        formData.append("projectID", projectID);
                        formData.append("file", fileInput.files[0]);

                        console.log("Uploading file with formData:", formData); // Debugging

                        fetch("/uploadFile", {
                                method: "POST",
                                headers: { 
                                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                                },
                                body: formData
                            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Upload Response:", data);
                    if (data.status === "success") {
                        Swal.fire({
                            title: "Success!",
                            text: "File uploaded successfully.",
                            icon: "success",
                            confirmButtonText: "OK"
                        });
                    } else {
                        Swal.fire({
                            title: "Upload Failed",
                            text: data.message || "Something went wrong!",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    }
                })
                .catch(error => {
                    console.error("Upload Error:", error);
                    Swal.fire({
                        title: "Error",
                        text: "Failed to upload file. Please check Laravel logs.",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                });

                    })
                    .catch(error => {
                        console.error("Error fetching project ID:", error);
                        Swal.fire({
                            title: "Error",
                            text: "Failed to get project ID. Please try again.",
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    });
                });


              

                // Delete File
                function deleteFile(fileID) {
                    fetch(`/delete/${fileID}`, { 
                        method: "DELETE",
                        headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") }
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                        loadFiles(document.getElementById("projectID").value); // Reload files
                    })
                    .catch(error => console.error("Error deleting file:", error));
                }

                // Handle Status & Fund Source Change Animations
                $(document).ready(function () {
                    $('#projectStatus').on('change', function () {
                        $(this).val() === 'Ongoing' ? $('#ongoingStatusContainer').slideDown() : $('#ongoingStatusContainer').slideUp();
                    });

                    $('#sourceOfFunds').on('change', function () {
                        $(this).val() === 'Others' ? $('#otherFundContainer').slideDown() : $('#otherFundContainer').slideUp();
                    });
                });

                document.addEventListener("DOMContentLoaded", function () {
                    fetchProjectDetails(); // Fetch project details when page loads
                });

                //  Fetch Project ID & Details
                function fetchProjectDetails() {
                    fetch("/get-project-id", {
                        method: "GET",
                        headers: { "Accept": "application/json" }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        if (!data.projectID) {
                            console.error("No project ID found in session. Redirecting...");
                            window.location.href = "{{ route('admin.index') }}"; // Redirect if no ID
                            return;
                        }
                        
                        console.log("Project ID:", data.projectID);
                        fetch(`/projects/getProject/${data.projectID}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.status === "success") {
                                    console.log(" Fetched Project Data:", data.project);
                                    updateProjectUI(data.project); // Populate UI
                                    updateProjectForm(data.project); // Populate form in modal
                                } else {
                                    console.error(" Error fetching project details:", data.message);
                                }
                            })
                            .catch(error => console.error(" Error fetching project data:", error));
                    })
                    .catch(error => console.error(" Error fetching project ID:", error));
                }

                //  Update UI with Project Data
                function updateProjectUI(project) {
                    let fields = {
                        "projectTitle": project.projectTitle,
                        "projectLoc": project.projectLoc,
                        "projectID": project.projectID,
                        "projectDescription": project.projectDescription,
                        "projectContractor": project.projectContractor,
                        "projectStatus": project.projectStatus,
                        "noticeOfAward": project.noticeOfAward,
                        "modeOfImplementation": project.modeOfImplementation,
                        "officialStart": project.officialStart,
                        "targetCompletion": project.targetCompletion,
                        "suspensionOrderNo": project.suspensionOrderNo,
                        "resumeOrderNo": project.resumeOrderNo,
                        "timeExtension": project.timeExtension,
                        "revisedTargetCompletion": project.revisedTargetCompletion,
                        "completionDate": project.completionDate,
                        "abc": project.abc,
                        "mqc": project.mqc,
                        "contractAmount": project.contractAmount,
                        "bid": project.bid,
                        "engineering": project.engineering,
                        "contingency": project.contingency,
                        "appropriation": project.appropriation
                    };

                    for (let id in fields) {
                        let element = document.getElementById(id);
                        if (element) {
                            element.textContent = fields[id] !== null && fields[id] !== undefined ? fields[id] : "N/A";
                        }
                    }

                    //  Extract & display ongoing project status (if applicable)
                    let ongoingStatusText = project.ongoingStatus || "";
                    let percentage = "", date = "";

                    if (ongoingStatusText.includes(" - ")) {
                        let parts = ongoingStatusText.split(" - ");
                        percentage = parts[0].trim() + "%";
                        date = formatDate(parts[1].trim());
                    }

                    let ongoingStatusElem = document.getElementById("ongoingStatus");
                    if (ongoingStatusElem) {
                        ongoingStatusElem.textContent = percentage ? `${percentage} as of ${date}` : "N/A";
                    }
                }

                //  Open Edit Modal & Populate Form
                document.getElementById("editProjectBtn").addEventListener("click", function () {
                    let projectModal = new bootstrap.Modal(document.getElementById("projectModal"));
                    projectModal.show();
                });



                //  Populate Modal Form with Project Data
                function updateProjectForm(project) {
                    if (!project) {
                        console.error("Error: Project data is undefined or null.");
                        return;
                    }

                    console.log("Populating form with project data:", project);

                    let fields = [
                        "projectTitle", "projectLoc", "projectID", "projectContractor",
                        "sourceOfFunds", "modeOfImplementation", "projectStatus", "projectDescription",
                        "projectContractDays", "noticeOfAward", "noticeToProceed", "officialStart",
                        "targetCompletion", "suspensionOrderNo", "resumeOrderNo", "timeExtension",
                        "revisedTargetCompletion", "completionDate", "abc", "contractAmount",
                        "engineering", "mqc", "contingency", "bid", "appropriation"
                    ];

                    fields.forEach(field => {
                        let input = document.getElementById(field);
                        if (input) {
                            let value = project[field] !== null && project[field] !== undefined ? project[field] : "";
                            
                            if (input.type === "date" && value.includes(" ")) {
                                value = value.split(" ")[0]; // Extract only YYYY-MM-DD
                            }

                            input.value = value;
                        } else {
                            console.warn(`Warning: Element #${field} not found.`);
                        }
                    });

                    // Handle dropdowns separately
                    setDropdownValue("sourceOfFunds", project["sourceOfFunds"]);
                    setDropdownValue("projectStatus", project["projectStatus"]);

                    // Handle "Ongoing" status separately
                    let ongoingContainer = document.getElementById("ongoingStatusContainer");
                    let ongoingInput = document.getElementById("ongoingStatus");
                    let ongoingDateInput = document.getElementById("ongoingDate");

                    if (project.projectStatus === "Ongoing" && project.ongoingStatus) {
                        ongoingContainer.style.display = "block";
                        let [percentage, date] = project.ongoingStatus.split(" - ");
                        ongoingInput.value = percentage.trim();
                        ongoingDateInput.value = date.trim();
                    } else {
                        ongoingContainer.style.display = "none";
                    }
                }

                //  Helper function to safely set dropdown values
                function setDropdownValue(elementID, value) {
                    let selectElement = document.getElementById(elementID);
                    if (!selectElement || !selectElement.options) {
                        console.warn(` Dropdown #${elementID} is not available.`);
                        return;
                    }

                    let options = Array.from(selectElement.options).map(option => option.value);
                    selectElement.value = options.includes(value) ? value : "";

                    // Handle the "Ongoing" status showing hidden fields
                    if (elementID === "projectStatus") {
                        let ongoingContainer = document.getElementById("ongoingStatusContainer");
                        ongoingContainer.style.display = value === "Ongoing" ? "block" : "none";
                    }
                }

                //  Handle Project Updates
                document.getElementById("updateProjectForm").addEventListener("submit", function (event) {
                    event.preventDefault();

                    fetch("/get-project-id", { method: "GET", headers: { "Accept": "application/json" } })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.projectID) {
                            console.error("No project ID found in session.");
                            return;
                        }

                        let updatedData = {};
                        let fieldIDs = [
                            "projectContractor", "sourceOfFunds", "modeOfImplementation", "projectStatus",
                            "projectDescription", "projectContractDays", "noticeOfAward", "noticeToProceed",
                            "officialStart", "targetCompletion", "suspensionOrderNo", "resumeOrderNo",
                            "timeExtension", "revisedTargetCompletion", "completionDate", "abc",
                            "contractAmount", "engineering", "mqc", "contingency", "bid", "appropriation"
                        ];

                        fieldIDs.forEach(id => {
                            let input = document.getElementById(id);
                            updatedData[id] = input ? input.value : null;
                        });

                        // Handle "Ongoing" status fields
                        if (updatedData.projectStatus === "Ongoing") {
                            let ongoingStatus = document.getElementById("ongoingStatus").value;
                            let ongoingDate = document.getElementById("ongoingDate").value;
                            updatedData.ongoingStatus = `${ongoingStatus} - ${ongoingDate}`;
                        } else {
                            updatedData.ongoingStatus = null;
                        }

                        return fetch(`/projects/update/${data.projectID}`, {
                            method: "PUT",  // FIX: Use PUT instead of POST
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                            },
                            body: JSON.stringify(updatedData)
                        });
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP Error! Status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === "success") {
                            Swal.fire({ title: "Updated Successfully!", text: data.message, icon: "success", confirmButtonText: "OK" })
                                .then(() => location.reload());
                        } else {
                            Swal.fire({ title: "Error!", text: data.message, icon: "error", confirmButtonText: "OK" });
                        }
                    })
                    .catch(error => {
                        console.error("Error updating project:", error);
                        Swal.fire({ title: "Error!", text: "Failed to update project. Please try again.", icon: "error", confirmButtonText: "OK" });
                    });
                });



                // Helper: Format Date to "Month Day, Year"
                function formatDate(inputDate) {
                    if (!inputDate || inputDate === "N/A") return "N/A";

                    let dateObj = new Date(inputDate);
                    if (isNaN(dateObj.getTime())) {
                        console.error("Invalid Date Format:", inputDate);
                        return inputDate;
                    }

                    return dateObj.toLocaleDateString("en-US", { year: "numeric", month: "long", day: "numeric" });
                }

                // Handle Status Change Animation
                $(document).ready(function () {
                    $('#editStatus').on('change', function () {
                        $(this).val() === 'Ongoing' ? $('#ongoingStatusContainer').slideDown() : $('#ongoingStatusContainer').slideUp();
                    });

                    $('#sourceOfFunds').on('change', function () {
                        $(this).val() === 'Others' ? $('#otherFundContainer').slideDown() : $('#otherFundContainer').slideUp();
                    });
                });

                document.addEventListener("DOMContentLoaded", function () {
                    let projectModal = document.getElementById("projectModal");

                    projectModal.addEventListener("hidden.bs.modal", function () {
                        location.reload(); // Reload the page after the modal is closed
                    });
                });
</script>
@endsection