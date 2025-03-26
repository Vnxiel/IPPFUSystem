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
                    <strong id="projectTitle">Loading...</strong>
                </div>
                <div class="card-body" style="font-size: 14px;">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Project Details -->
                            <div class="row p-1 border-bottom">
                                <div class="col-md-4"><strong>Location:</strong></div>
                                <div class="col-md-8" id="projectLoc">Loading...</div>
                            </div>
                            <div class="row p-1 border-bottom">
                                <div class="col-md-4"><strong>Project Description:</strong></div>
                                <div class="col-md-8" id="projectDescription">Loading...</div>
                            </div>
                            <div class="row p-1 border-bottom">
                                <div class="col-md-4"><strong>Contractor:</strong></div>
                                <div class="col-md-8" id="projectContractor">Loading...</div>
                            </div>
                            <div class="row p-1 border-bottom">
                                <div class="col-md-4"><strong>Project ID:</strong></div>
                                <div class="col-md-8" id="projectID">Loading...</div>
                            </div>
                            <div class="row p-1 border-bottom">
                                <div class="col-md-4"><strong>Status:</strong></div>
                                <div class="col-md-8">
                                    <span class="badge bg-success" id="projectStatus">Loading...</span>
                                    <span id="ongoingStatus" style="margin-left: 10px;">Loading...</span>
                                </div>
                            </div>
                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Notice of Award:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="noticeOfAward">Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Official Start:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="officialStart">Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Target Completion:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="targetCompletion">Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Suspension Order No. 1:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="suspensionOrderNo">Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Resume Order No. 1:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="resumeOrderNo">Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Time Extension:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="timeExtension">Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Revised Target Completion:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="revisedTargetCompletion">Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Completion Date:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="completionDate">Loading...
                                                </div>
                                            </div>
                                        </div>


                        <div class="col-md-6">
                            <!-- Financial Details -->
                            <div class="row p-1 border-bottom">
                                <div class="col-md-4"><strong>ABC:</strong></div>
                                <div class="col-md-8" id="abc">Loading...</div>
                            </div>
                            <div class="row p-1 border-bottom">
                                <div class="col-md-4"><strong>Contract Amount:</strong></div>
                                <div class="col-md-8" id="contractAmount">Loading...</div>
                            </div>
                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Engineering:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="engineering">
                                                    Loading...
                                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>MQC:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="mqc">
                                    Loading...
                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Contingency:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="contingency">
                                    Loading...
                                </div>
                                            </div>
                                            <div class="row p-1 border-bottom">
                                                <div class="col-md-4 d-flex align-items-center">
                                                    <strong>Bid Difference:</strong>
                                                </div>
                                                <div class="col-md-8 d-flex align-items-center" id="bid">
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
            <button class="btn btn-danger btn-sm w-100">
                <i class="fa fa-trash"></i>
            </button>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
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
                            <th>Size</th>
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
                                <label for="location" class="form-label">Project Title</label>
                                <input type="text" class="form-control" id="projectTitle">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control" id="projectLoc" >
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
                                <select id="projectStatus" name="projectStatus" class="form-select" onchange="toggleOngoingStatus()">
                                    <option value="---">---</option>
                                    <option value="Ongoing">Ongoing</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Cancelled">Discontinued</option>
                                </select>

                                <!-- Hidden text input for 'Ongoing' -->
                                <div id="ongoingStatusContainer" class="mt-2 fw-bolder" style="display: none;">
                                    <label for="ongoingStatus" class="form-label">Please specify percentage completion:</label>
                                    
                                <div class="d-flex gap-2"> 
                                    <input type="text" id="ongoingStatus" name="ongoingStatus" class="form-control w-50" placeholder="Enter percentage">
                                    <input type="date" id="ongoingDate" class="form-control w-50">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label for="projectDescription" class="form-label">Project Description</label>
                                <textarea class="form-control" id="projectDescription" rows="3" style="width:100%">Expansion of a 4-lane road to 6 lanes</textarea>
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
                                <label for="contractDays" class="form-label">Contract Days</label>
                                <input type="text" class="form-control" id="contractDays">
                            </div>   
                            <div class="mb-1">
                                <label for="noticeOfAward" class="form-label">Notice of Award</label>
                                <input type="date" class="form-control" id="awardDate">
                            </div>  
                            <div class="mb-1">
                                <label for="noticeToProceed" class="form-label">Notice to Proceed</label>
                                <input type="date" class="form-control" id="noticeToProceed" value="">
                            </div>  
                            <div class="mb-1">
                                <label for="officialStart" class="form-label">Official Start</label>
                                <input type="date" class="form-control" id="officialStart" value="">
                            </div> 
                            <div class="mb-1">
                                <label for="targetCompletion" class="form-label">Target Completion</label>
                                <input type="date" class="form-control" id="targetCompletion" value="">
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="SuspeOrder" class="form-label">Suspension Order No.1</label>
                                <input type="date" class="form-control" id="suspensionOrderNo" value="">
                            </div> 
                            <div class="mb-1">
                                <label for="resumeOrder" class="form-label">Resume Order No.1</label>
                                <input type="date" class="form-control" id="resumeOrderNo" value="">
                            </div> 
                            <div class="mb-1">
                                <label for="timeExtension" class="form-label">Time Extension</label>
                                <input type="text" class="form-control" id="timeExtension" value="">
                            </div> 
                            <div class="mb-1">
                                <label for="revisedTargetCompletion" class="form-label">Revised Target Completion</label>
                                <input type="text" class="form-control" id="revisedTargetCompletion" value="">
                            </div> 
                            <div class="mb-1">
                                <label for="CompletionDate" class="form-label">Completion Date</label>
                                <input type="text" class="form-control" id="completionDate" value="">
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
                                <input type="text" class="form-control" id="abc" >
                            </div>
                            <div class="mb-1">
                                <label for="contractAmount" class="form-label">Contract Amount</label>
                                <input type="text" class="form-control" id="contractAmount" >
                            </div>
                            <div class="mb-1">
                                <label for="engineering" class="form-label">Engineering</label>
                                <input type="text" class="form-control" id="engineering" >
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
                                <input type="text" class="form-control" id="bid" >
                            </div>
                            <div class="mb-1">
                                <label for="appropriation" class="form-label">Appropriation</label>
                                <input type="text" class="form-control" id="appropriation" >
                            </div>
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


<script>
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

    // Fetch `projectID` from session first
    fetch("/get-project-id", {
        method: "GET",
        headers: { "Accept": "application/json" }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
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

        let projectID = data.projectID; // Use projectID from session
        console.log("Retrieved Project ID from session:", projectID);

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

        console.log("Uploading file with project_id:", projectID); //Debugging

        fetch("/uploadFile", {
            method: "POST",
            headers: { 
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log("Server Response:", data); //Debugging
            if (data.status === "success") {
                Swal.fire({
                    title: "Success!",
                    text: "File uploaded successfully.",
                    icon: "success",
                    confirmButtonText: "OK"
                });
                loadFiles(projectID); // Refresh file list   
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
            Swal.fire({
                title: "Upload Error",
                text: error.message || "An unexpected error occurred.",
                icon: "error",
                confirmButtonText: "OK"
            });
        }); 
    })
    .catch(error => {
        console.error("Error fetching project ID from session:", error);
        Swal.fire({
            title: "Error",
            text: "Failed to get project ID. Please try again.",
            icon: "error",
            confirmButtonText: "OK"
        });
    });
});


function loadFiles(projectID) {
    console.log("Fetching files for Project ID:", projectID);

    fetch(`/files/${projectID}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP Error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log("API Response:", data);

            if (!data || typeof data !== "object" || !Array.isArray(data.files)) {
                console.error("Invalid API response:", data);
                alert("Invalid file data received.");
                return;
            }

            let tbody = document.querySelector(" #projectFiles tbody");
            tbody.innerHTML = ""; // Clear old data
            
            if (data.files.length === 0) {
                console.warn("No files found for project:", projectID);
                tbody.innerHTML = `<tr><td colspan="6" class="text-center">No files uploaded yet.</td></tr>`;
                return;
            }

            data.files.forEach(file => {
                let fileSizeKB = (file.file_size / 1024).toFixed(2); // Convert to KB

                let row = `<tr>
                    <td>${file.file_name}</td>
                    <td>${file.file_type ? file.file_type.toUpperCase() : "Unknown"}</td>
                    <td>${fileSizeKB} KB</td>
                    <td>${file.uploaded_by || "Unknown"}</td>
                    <td>${file.created_at ? new Date(file.created_at).toLocaleDateString() : "N/A"}</td>
                    <td>
                        <a href="/storage/${file.file_path}" download class="btn btn-success btn-sm">
                            <i class="fa fa-download"></i>
                        </a>
                        <button onclick="deleteFile('${file.id}')" class="btn btn-danger btn-sm">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>`;

                tbody.innerHTML += row;
            });
        })
        .catch(error => {
            console.error("Fetch Error:", error);
            alert("Error loading project files: " + error.message);
        });
}


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
    fetchProjectID();
});


//  Fetch Project ID from Session
function fetchProjectID() {
    fetch("/get-project-id", {
        method: "GET",
        headers: { "Accept": "application/json" }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! Status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.projectID) {
            console.log("Retrieved Project ID from session:", data.projectID);
            loadProjectDetails(data.projectID);
            loadFiles(data.projectID);
        } else {
            console.error("No project ID found in session. Redirecting...");
            window.location.href = "{{ route('main.index') }}"; // Redirect if no ID
        }
    })
    .catch(error => {
        console.error("Error fetching project ID from session:", error);
    });
}


//  Fetch and Display Project Details
function loadProjectDetails(projectID) {
    fetch(`/projects/getProject/${projectID}`)
        .then(response => response.json())
        .then(data => {
            console.log("Fetched Project Data:", data);

            if (data.status === "success") {
                updateProjectUI(data.project);
             
            } else {
                console.error("Error fetching project details:", data.message);
            }
        })
        .catch(error => console.error("Error fetching project data:", error));
}

//  Update UI with Project Data
function updateProjectUI(project) {
    document.getElementById("projectTitle").textContent = project.projectTitle || "N/A";
    document.getElementById("projectLoc").textContent = project.projectLoc || "N/A";
    document.getElementById("projectID").textContent = project.projectID || "N/A";
    document.getElementById("projectDescription").textContent = project.projectDescription || "N/A";
    document.getElementById("projectContractor").textContent = project.projectContractor || "N/A";
    document.getElementById("projectStatus").textContent = project.projectStatus || "Loading...";
    document.getElementById("noticeOfAward").textContent = project.noticeOfAward || "N/A";
    document.getElementById("modeOfImplementation").textContent = project.modeOfImplementation || "N/A";
    document.getElementById("officialStart").textContent = project.officialStart || "N/A";
    document.getElementById("targetCompletion").textContent = project.targetCompletion || "N/A";
    document.getElementById("suspensionOrderNo").textContent = project.suspensionOrderNo || "N/A";
    document.getElementById("resumeOrderNo").textContent = project.resumeOrderNo || "N/A";
    document.getElementById("timeExtension").textContent = project.timeExtension || "N/A";
    document.getElementById("revisedTargetCompletion").textContent = project.revisedTargetCompletion || "N/A";
    document.getElementById("completionDate").textContent = project.completionDate || "N/A";
    document.getElementById("abc").textContent = project.abc || "N/A";
    document.getElementById("mqc").textContent = project.mqc || "N/A";
    document.getElementById("contractAmount").textContent = project.contractAmount || "N/A";
    document.getElementById("bid").textContent = project.bid || "N/A";
    document.getElementById("engineering").textContent = project.engineering || "N/A";
    document.getElementById("contingency").textContent = project.contingency || "   ";
    document.getElementById("appropriation").textContent = project.appropriation || "N/A";

    // Extract Percentage & Date from `ongoingStatus`
    let ongoingStatusText = project.ongoingStatus || "";
    let percentage = "";
    let date = "";

    if (ongoingStatusText.includes(" - ")) {
        let parts = ongoingStatusText.split(" - ");
        percentage = parts[0].trim() + "%";
        date = formatDate(parts[1].trim());
    }

    document.getElementById("ongoingStatus").textContent = percentage ? `${percentage} as of ${date}` : "N/A";
}

// Fetch & Populate Modal Form
// Open Edit Modal **Only When "Edit" Button is Clicked**
document.getElementById("editProjectBtn").addEventListener("click", function () {
    fetch("/get-project-id", {
        method: "GET",
        headers: { "Accept": "application/json" }
    })
    .then(response => response.json())
    .then(data => {
        if (data.projectID) {
            fetch(`/projects/getProject/${data.projectID}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        updateProjectForm(data.project);  // ✅ Now populate form inside modal
                    } else {
                        console.error("Error fetching project details:", data.message);
                    }
                })
                .catch(error => console.error("Error fetching project data:", error));
        } else {
            console.error("No project ID found in session.");
        }
    })
    .catch(error => console.error("Error fetching project ID:", error));
});

//  Populate Modal Form with Fetched Data
function updateProjectForm(project) {
    if (!project) {
        console.error("Error: Project data is undefined or null.");
        return;
    }

    console.log("Populating form with project data:", project);  

    let fields = [
        "projectTitle", "projectLoc", "projectID", "projectContractor",
        "sourceOfFunds", "modeOfImplementation", "projectStatus", "projectDescription",
        "contractDays", "awardDate", "noticeToProceed", "officialStart",
        "targetCompletion", "suspensionOrderNo", "resumeOrderNo", "timeExtension",
        "revisedTargetCompletion", "completionDate", "abc", "contractAmount",
        "engineering", "mqc", "contingency", "bid", "appropriation"
    ];

    fields.forEach(field => {
        let input = document.getElementById(field);
        if (input) {
            // ✅ Ensure no `null` or `undefined` values break the form
            input.value = project[field] !== null && project[field] !== undefined ? project[field] : "";
        } else {
            console.warn(`Warning: Element #${field} not found.`);
        }
    });

    // ✅ Handle dropdowns separately
    let sourceOfFunds = document.getElementById("sourceOfFunds");
    if (sourceOfFunds) {
        sourceOfFunds.value = project["sourceOfFunds"] || ""; 
    }

    let projectStatus = document.getElementById("projectStatus");
    if (projectStatus) {
        projectStatus.value = project["projectStatus"] || "";
    }

    // ✅ Show the modal only after all data is populated
    let projectModal = new bootstrap.Modal(document.getElementById("projectModal"));
    projectModal.show();
}



//  Handle Project Updates
document.getElementById("updateProjectForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent normal form submission

    fetch("/get-project-id", { method: "GET", headers: { "Accept": "application/json" } })
    .then(response => response.json())
    .then(data => {
        if (!data.projectID) {
            console.error("No project ID found in session.");
            return;
        }

        let updatedData = {
            
            projectContractor: document.getElementById("projectContractor").value,
            sourceOfFunds: document.getElementById("sourceOfFunds").value,
            modeOfImplementation: document.getElementById("modeOfImplementation").value,
            projectStatus: document.getElementById("projectStatus").value,
            projectDescription: document.getElementById("projectDescription").value,
            contractDays: document.getElementById("contractDays").value,
            awardDate: document.getElementById("awardDate").value,
            noticeToProceed: document.getElementById("noticeToProceed").value,
            officialStart: document.getElementById("officialStart").value,
            targetCompletion: document.getElementById("targetCompletion").value,
            suspensionOrderNo: document.getElementById("suspensionOrderNo").value,
            resumeOrderNo: document.getElementById("resumeOrderNo").value,
            timeExtension: document.getElementById("timeExtension").value,
            revisedTargetCompletion: document.getElementById("revisedTargetCompletion").value,
            completionDate: document.getElementById("completionDate").value,
            abc: document.getElementById("abc").value,
            contractAmount: document.getElementById("contractAmount").value,
            engineering: document.getElementById("engineering").value,
            mqc: document.getElementById("mqc").value,
            contingency: document.getElementById("contingency").value,
            bid: document.getElementById("bid").value,
            appropriation: document.getElementById("appropriation").value
        };

        return fetch(`/projects/update/${data.projectID}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
            },
            body: JSON.stringify(updatedData)
        });
    })
    .then(response => response.json())
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

</script>


@endsection