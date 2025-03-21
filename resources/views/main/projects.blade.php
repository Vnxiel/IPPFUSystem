@extends('main.layout')

@section('title', 'Dashboard Page')

@section('content') 
                <hr class="mx-2">
                <div class="container-fluid px-3">
                <div class="col-md-12 m-2">
                        <div class="row align-items-center">
                            <div class="col">
                                <h5 class="m-0">Projects</h5>
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addNewProjectModal">
                                    <span class="fa fa-plus"></span>&nbsp;Add New Project
                                </button>
                            </div>
                            <hr class="mt-2">
                        </div>
                        <div class="row">
                            <div class="table-container table-responsive">
                            <table id="projects" class="table table-striped table-hover table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 15%;">Project Title</th>
                                        <th style="width: 10%;">Location</th>
                                        <th style="width: 10%;">Status</th>
                                        <th style="width: 10%;">Contract Amount</th>
                                        <th style="width: 10%;">Contractor</th>
                                        <th style="width: 10%;">Duration</th>
                                        <th style="width: 10%;">Action</th>
                                    </tr>   
                                </thead>
                                <tbody id="projectTableBody">
                                    <tr>
                                        <td colspan="7" class="text-center">Loading projects...</td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>



             <!-- Add Project Modal -->
             <div class="modal fade" id="addNewProjectModal" tabindex="-1" aria-labelledby="addNewProjectLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="appNewProjectLabel">Add Project</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action="{{ route('projects.addProject') }}" id="addProjectForm" method="POST">
                             @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="projectTitle" class="form-label">Project Title</label>
                                        <input type="text" class="form-control" id="projectTitle" name="projectTitle" required placeholder="Enter project title">
                                   </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="projectLoc" class="form-label">Location</label>
                                        <input type="text" class="form-control" id="projectLoc" name="projectLoc" required placeholder="Enter location">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="projectID" class="form-label">Project ID</label>
                                        <input type="text" class="form-control" id="projectID" name="projectID" required placeholder="Enter project ID">
                                    </div>  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="projectContractor" class="form-label">Contractor</label>
                                        <input type="text" class="form-control" id="projectContractor" name="projectContractor n" placeholder="Enter projectContractor">
                                     </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="sourceOfFunds" class="form-label fw-bolder">Select Fund Source</label>
                                        <select id="sourceOfFunds" name="sourceOfFunds" class="form-select" onchange="toggleOtherFund()">
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
                                            <input type="text" id="otherFund" name="otherFund" class="form-control" placeholder="Enter fund source">
                                       </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="modeOfImplementation" class="form-label">Mode of Implementation</label>
                                        <input type="text" class="form-control" id="modeOfImplementation" name="modeOfImplementation" placeholder="Enter mode of implementation.">
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
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="projectDescription" class="form-label">Project Description</label>
                                        <textarea class="form-control" id="projectDescription" name="projectDescription" rows="3" placeholder="Enter project description"></textarea>
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
                                        <input type="text" class="form-control" id="projectContractDays" name="projectContractDays">
                                    </div>   
                                    <div class="mb-1">
                                        <label for="noticeOfAward" class="form-label">Notice of Award</label>
                                        <input type="date" class="form-control" id="noticeOfAward" name="noticeOfAward">
                                    </div>  
                                    <div class="mb-1">
                                        <label for="noticeToProceed" class="form-label">Notice to Proceed</label>
                                        <input type="date" class="form-control" id="noticeToProceed" name="noticeToProceed">
                                    </div>  
                                    <div class="mb-1">
                                        <label for="officialStart" class="form-label">Official Start</label>
                                        <input type="date" class="form-control" id="officialStart" name="officialStart">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="targetCompletion" class="form-label">Target Completion</label>
                                        <input type="date" class="form-control" id="targetCompletion" name="targetCompletion">
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="suspensionOrderNo" class="form-label">Suspension Order No.1</label>
                                        <input type="date" class="form-control" id="suspensionOrderNo" name="suspensionOrderNo" value="">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="resumeOrderNo" class="form-label">Resume Order No.1</label>
                                        <input type="date" class="form-control" id="resumeOrderNo" name="resumeOrderNo" value="">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="timeExtension" class="form-label">Time Extension</label>
                                        <input type="text" class="form-control" id="timeExtension" name="timeExtension" value="">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="revisedTargetCompletion" class="form-label">Revised Target Completion</label>
                                        <input type="text" class="form-control" id="revisedTargetCompletion" name="revisedTargetCompletion" value="">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="CompletionDate" class="form-label">Completion Date</label>
                                        <input type="text" class="form-control" id="CompletionDate" name="CompletionDate" value="">
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
                                        <input type="text" class="form-control currency-input" id="abc" value="">
                                    </div>
                                    <div class="mb-1">
                                        <label for="contractAmount" class="form-label">Contract Amount</label>
                                        <input type="text" class="form-control currency-input" id="contractAmount" value="">
                                    </div>
                                    <div class="mb-1">
                                        <label for="engineering" class="form-label">Engineering</label>
                                        <input type="text" class="form-control currency-input" id="engineering" value="">
                                    </div>
                                    <div class="mb-1">
                                        <label for="mqc" class="form-label">MQC</label>
                                        <input type="text" class="form-control currency-input" id="mqc" value="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="contingency" class="form-label">Contingency</label>
                                        <input type="text" class="form-control currency-input" id="contingency" value="">
                                    </div>
                                    <div class="mb-1">
                                        <label for="bid" class="form-label">Bid Difference</label>
                                        <input type="text" class="form-control currency-input" id="bid" value="">
                                    </div>
                                    <div class="mb-1">
                                        <label for="appropriate" class="form-label">Appropriation</label>
                                        <input type="text" class="form-control currency-input" id="appropriate" value="">
                                    </div>
                                </div>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Project</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

   

      <!-- DataTable & Fetching Script -->
<script>    
document.addEventListener("DOMContentLoaded", function () {
    fetch("{{ route('projects.showDetails') }}")
        .then(response => response.json())
        .then(data => {
            console.log("Projects Data:", data); // Debugging
            if (data.status === "success") {
                loadProjects(data.projects);
            } else {
                console.error("Error fetching projects:", data.message);
            }
        })
        .catch(error => console.error("Error fetching projects:", error));

    loadProjects(); // Load projects when the page loads

    // Handle Add Project Form Submission
    document.getElementById("addProjectForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent normal form submission

        let formData = new FormData(this);

        fetch("{{ route('projects.addProject') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Accept": "application/json"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                Swal.fire({
                    title: "Success!",
                    text: data.message,
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(() => {
                    $("#addNewProjectModal").modal("hide"); // Hide modal
                    document.getElementById("addProjectForm").reset(); // Reset form
                    loadProjects(); // Reload projects without refreshing page
                });
            } else {
                let errorMsg = data.message;
                
                if (data.errors) {
                    errorMsg += "<ul>";
                    for (const [field, errors] of Object.entries(data.errors)) {
                        errorMsg += `<li>${errors.join(", ")}</li>`;
                    }
                    errorMsg += "</ul>";
                }

                Swal.fire({
                    title: "Error!",
                    html: errorMsg,
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        })
        .catch(error => {
            Swal.fire({
                title: "Error!",
                text: "An unexpected error occurred. Please try again.",
                icon: "error",
                confirmButtonText: "OK"
            });
            console.error("Error:", error);
        });
    });


// Fetch and Load Projects into DataTable
document.addEventListener("DOMContentLoaded", function () {
    loadProjects(); //  Load projects on page load
});

//  Fetch and Load Projects into DataTable
function loadProjects() {
    fetch("{{ route('projects.showDetails') }}", {
        method: "GET",
        headers: { "Accept": "application/json" }
    })
    .then(response => response.json())
    .then(data => {
        console.log("Fetched Projects Data:", data); //  Debugging

        if (data.status === "success") {
            let projects = data.projects.map(project => [
                project.projectTitle || "N/A",
                project.projectLoc || "N/A",
                project.projectStatus || "N/A",
                project.contractAmount ? `₱${parseFloat(project.contractAmount).toLocaleString()}` : "N/A",
                project.projectContractor || "N/A",
                project.projectContractDays ? `${project.projectContractDays} days` : "N/A",
                `<a href="{{ route('main.overview') }}?id=${project.id}" class="btn btn-primary btn-sm">Overview</a>`
            ]);

            //  Fix: Destroy DataTable before reloading
            if ($.fn.DataTable.isDataTable("#projects")) {
                $('#projects').DataTable().clear().destroy();
                $("#projects tbody").empty(); //  Clear table content
            }

            //  Fix: Ensure Correct Column Mapping
            $('#projects').DataTable({
                data: projects, //  Sending only necessary data
                columns: [
                    { title: "Project Title" },
                    { title: "Location" },
                    { title: "Status" },
                    { title: "Contract Amount" },
                    { title: "Contractor" },
                    { title: "Duration" },
                    { title: "Action" }
                ],
                responsive: true,
                scrollX: true,
                paging: true,
                searching: true,
                autoWidth: false
            });

            console.log("✅ DataTable Reloaded Successfully!");
        } else {
            console.error("Error Fetching Projects:", data.message);
        }
    })
    .catch(error => {
        console.error("Fetch Error:", error);
    });
}


function initializeDataTable() {
        if ($.fn.DataTable.isDataTable("#projects")) {
            $('#projects').DataTable().destroy(); // Destroy previous instance
        }

        dataTable = $('#projects').DataTable({
            responsive: true,
            scrollX: true,
            paging: true,
            searching: true
        });

        setTimeout(() => {
            dataTable.columns.adjust().draw();
        }, 500);
    }


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
        var projectStatus = document.getElementById("projectStatus").value;
        var ongoingStatusContainer = document.getElementById("ongoingStatusContainer");

        if (projectStatus === "Ongoing") {
            ongoingStatusContainer.style.display = "block";
        } else {
            ongoingStatusContainer.style.display = "none";
        }
    }

    // Add Event Listener for Project Status Dropdown
    document.getElementById("projectStatus").addEventListener("change", function () {
        toggleOngoingStatus();
    });

    // Initialize DataTable
    $(document).ready(function() {
    $("#projects").DataTable({
        responsive: true,
        scrollX: true,
        paging: true,
        searching: true
    });

    loadProjects(); // ✅ Load projects after DataTable is initialized
});


        // Handle "Other Fund" Dropdown Change
        $('#sourceOfFunds').on('change', function() {
            if ($(this).val() === 'Others') {
                $('#otherFundContainer').slideDown(); // Show input with animation
            } else {
                $('#otherFundContainer').slideUp(); // Hide input with animation
            }
        });
    });

</script>

@endsection