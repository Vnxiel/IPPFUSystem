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
                                            <th style="width: 25%;">Project Title</th>
                                            <th style="width: 15%;">Location</th>
                                            <th style="width: 15%;">Status</th>
                                            <th style="width: 10%;">Contract Amount</th>
                                            <th style="width: 15%;">Contractor</th>
                                            <th style="width: 12%;">Duration</th>
                                            <th style="width: 8%;">Action</th>
                                        </tr>   
                                    </thead>
                                    <tbody>
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
             <!-- Add Project Modal -->
             <div class="modal fade" id="addNewProjectModal" tabindex="-1" aria-labelledby="addNewProjectLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="appNewProjectLabel">Add Project</h1>
                        <h1 class="modal-title fs-5" id="appNewProjectLabel">Add Project</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addProjectForm">
                            @csrf
                    <form action="{{ route('projects.addProject') }}" id="addProjectForm" method="POST">
                             @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="location" class="form-label">Project Title</label>
                                        <input type="text" class="form-control" name="projectTitle" id="projectTitle" placeholder="Enter project title." required>
                                    </div>
                                        <label for="projectTitle" class="form-label">Project Title</label>
                                        <input type="text" class="form-control" id="projectTitle" name="projectTitle" required placeholder="Enter project title">
                                   </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="location" class="form-label">Location</label>
                                        <input type="text" class="form-control" name="location" id="location" placeholder="Enter Location." required>
                                        <label for="projectLoc" class="form-label">Location</label>
                                        <input type="text" class="form-control" id="projectLoc" name="projectLoc" required placeholder="Enter location">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="projectID" class="form-label">Project ID</label>
                                        <input type="text" class="form-control" name="projectID" id="projectID" placeholder="Enter project ID." required>
                                    </div>
                                        <input type="text" class="form-control" id="projectID" name="projectID" required placeholder="Enter project ID">
                                    </div>  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="contractor" class="form-label">Contractor</label>
                                        <input type="text" class="form-control" name="contractor" id="contractor" placeholder="Enter contractor." required>
                                    </div>
                                        <label for="projectContractor" class="form-label">Contractor</label>
                                        <input type="text" class="form-control" id="projectContractor" name="projectContractor" placeholder="Enter projectContractor">
                                     </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="fundSource" class="form-label fw-bolder">Select Fund Source</label>
                                        <select id="fundSource" class="form-select" alt="source" required>
                                            <option placeholder="">-- --</option>
                                            <option placeholder="Wages">Wages</option>
                                            <option placeholder="% Mobilization">% Mobilization</option>
                                            <option placeholder="1st Partial Billing">1st Partial Billing</option>
                                            <option placeholder="Trust Fund">Trust Fund</option>
                                            <option placeholder="Final Billing">Final Billing</option>
                                            <option placeholder="Others" id="otherFundContainer">Others</option>
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
                                            <input type="text" name="otherFund" name="otherFund" id="otherFund" class="form-control" placeholder="Enter fund source">
                                        </div>
                                            <input type="text" id="otherFund" name="otherFund" class="form-control" placeholder="Enter fund source">
                                       </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="contractor" class="form-label">Mode of Implementation</label>
                                        <input type="text" class="form-control" name="contractor" id="contractor" placeholder="Enter mode of implementation.">
                                    </div>
                                        <label for="modeOfImplementation" class="form-label">Mode of Implementation</label>
                                        <input type="text" class="form-control" id="modeOfImplementation" name="modeOfImplementation" placeholder="Enter mode of implementation.">
                            </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="editStatus" class="form-label fw-bolder">Status</label>
                                        <select id="editStatus" class="form-select" required>
                                            <option placeholder="---">---</option>
                                            <option id="ongoingStatusContainer" placeholder="Ongoing">Ongoing</option>
                                            <option placeholder="Completed">Completed</option>
                                            <option placeholder="Cancelled">Discontinued</option>
                                        <label for="projectStatus" class="form-label fw-bolder">Status</label>
                                        <select id="projectStatus" name="projectStatus" class="form-select" onchange="toggleOngoingStatus()">
                                            <option value="---">---</option>
                                            <option value="Ongoing">Ongoing</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Cancelled">Discontinued</option>
                                        </select>

                                        <!-- Hidden text input for 'Ongoing' -->
                                        <div id="ongoingStatusContainer" class="mt-2 fw-bolder" style="display: none;">
                                            <label for="ongoingStatus" class="form-label">Please specify:</label>
                                            <input type="text" name="ongoingStatus" id="ongoingStatus" class="form-control" placeholder="Enter status percentage.">
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
                                        <textarea class="form-control" name="projectDescription" id="projectDescription" rows="3" style="width:100%" placeholder="Enter project description."></textarea>
                                    </div>
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
                                        <label for="contractDays" class="form-label">Contract Days</label>
                                        <input type="text" class="form-control" name="contractDays"id="contractDays" placeholder="Calendar Days">
                                        <label for="projectContractDays" class="form-label">Contract Days</label>
                                        <input type="text" class="form-control" id="projectContractDays" name="projectContractDays">
                                    </div>   
                                    <div class="mb-1">
                                        <label for="noticeOfAward" class="form-label">Notice of Award</label>
                                        <input type="date" class="form-control" name="noticeOfAward" id="noticeOfAward" placeholder="">
                                        <input type="date" class="form-control" id="noticeOfAward" name="noticeOfAward">
                                    </div>  
                                    <div class="mb-1">
                                        <label for="noticeToProceed" class="form-label">Notice to Proceed</label>
                                        <input type="date" class="form-control" name="noticeToProceed" id="noticeToProceed" placeholder="">
                                        <input type="date" class="form-control" id="noticeToProceed" name="noticeToProceed">
                                    </div>  
                                    <div class="mb-1">
                                        <label for="officialStart" class="form-label">Official Start</label>
                                        <input type="date" class="form-control" name="officialStart" id="officialStart" placeholder="">
                                        <input type="date" class="form-control" id="officialStart" name="officialStart">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="targetCompletion" class="form-label">Target Completion</label>
                                        <input type="date" class="form-control" name="targetCompletion" id="targetCompletion" placeholder="">
                                        <input type="date" class="form-control" id="targetCompletion" name="targetCompletion">
                                    </div> 
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="SuspeOrder" class="form-label">Suspension Order No.1</label>
                                        <input type="date" class="form-control" name="SuspeOrder" id="SuspeOrder" placeholder="">
                                        <label for="suspensionOrderNo" class="form-label">Suspension Order No.1</label>
                                        <input type="date" class="form-control" id="suspensionOrderNo" name="suspensionOrderNo" value="">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="resumeOrder" class="form-label">Resume Order No.1</label>
                                        <input type="date" class="form-control" name="resumeOrder" id="resumeOrder" placeholder="">
                                        <label for="resumeOrderNo" class="form-label">Resume Order No.1</label>
                                        <input type="date" class="form-control" id="resumeOrderNo" name="resumeOrderNo" value="">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="timeExtension" class="form-label">Time Extension</label>
                                        <input type="text" class="form-control" name="timeExtension" id="timeExtension" placeholder="">
                                        <input type="text" class="form-control" id="timeExtension" name="timeExtension" value="">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="revisedTargetCompletion" class="form-label">Revised Target Completion</label>
                                        <input type="text" class="form-control" name="revisedTargetCompletion" id="revisedTargetCompletion" placeholder="">
                                        <input type="text" class="form-control" id="revisedTargetCompletion" name="revisedTargetCompletion" value="">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="CompletionDate" class="form-label">Completion Date</label>
                                        <input type="text" class="form-control" name="CompletionDate" id="CompletionDate" placeholder="">
                                        <label for="completionDate" class="form-label">Completion Date</label>
                                        <input type="text" class="form-control" id="completionDate" name="completionDate" value="">
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
                                        <input type="text" class="form-control" name="abc" id="abc" placeholder="">
                                        <input type="text" class="form-control currency-input" id="abc" name="abc">
                                    </div>
                                    <div class="mb-1">
                                        <label for="contractAmount" class="form-label">Contract Amount</label>
                                        <input type="text" class="form-control" name="contractAmount" id="contractAmount" placeholder="">
                                        <input type="text" class="form-control currency-input" id="contractAmount" id="contractAmount">
                                    </div>
                                    <div class="mb-1">
                                        <label for="engineering" class="form-label">Engineering</label>
                                        <input type="text" class="form-control" name="engineering" id="engineering" placeholder="">
                                        <input type="text" class="form-control currency-input" id="engineering" name="engineering">
                                    </div>
                                    <div class="mb-1">
                                        <label for="mqc" class="form-label">MQC</label>
                                        <input type="text" class="form-control" name="mqc" id="mqc" placeholder="">
                                        <input type="text" class="form-control currency-input" id="mqc" name="mqc">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="contingency" class="form-label">Contingency</label>
                                        <input type="text" class="form-control" name="contingency" id="contingency" placeholder="">
                                        <input type="text" class="form-control currency-input" id="contingency" name="contingency">
                                    </div>
                                    <div class="mb-1">
                                        <label for="bid" class="form-label">Bid Difference</label>
                                        <input type="text" class="form-control" name="bid" id="bid" placeholder="">
                                        <input type="text" class="form-control currency-input" id="bid" name="bid">
                                    </div>
                                    <div class="mb-1">
                                        <label for="appropriate" class="form-label">Appropriation</label>
                                        <input type="text" class="form-control" name="appropriate" id="appropriate" placeholder="">
                                    </div>
                                </div>
                            </div>
                                        <label for="appropriation" class="form-label">Appropriation</label>
                                        <input type="text" class="form-control currency-input" id="appropriation" name="appropriation">
                                    </div>
                                </div>
                            </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Projects</button>
                            <button type="submit" class="btn btn-primary">Add Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

   

      <!-- DataTable & Fetching Script -->
        <script>    
            document.addEventListener("DOMContentLoaded", function () {
                // Select all input fields with the "currency-input" class
                let currencyInputs = document.querySelectorAll(".currency-input");

                currencyInputs.forEach(input => {
                    input.addEventListener("input", function () {
                        formatCurrencyInput(this);
                    });

                    input.addEventListener("blur", function () {
                        formatCurrencyOnBlur(this);
                    });

                    //  Format existing values on page load
                    if (input.value.trim() !== "") {
                        formatCurrencyOnBlur(input);
                    }
                });

                function formatCurrencyInput(input) {
                    // Remove non-numeric characters except decimal
                    let value = input.value.replace(/[^0-9.]/g, "");

                    // Ensure there's only one decimal point
                    let parts = value.split(".");
                    if (parts.length > 2) {
                        value = parts[0] + "." + parts.slice(1).join("");
                    }

                    input.value = value;
                }

                function formatCurrencyOnBlur(input) {
                    let value = input.value.trim();

                    if (value === "" || isNaN(value)) {
                        input.value = "";
                        return;
                    }

                    let formattedValue = parseFloat(value).toLocaleString("en-PH", {
                        style: "currency",
                        currency: "PHP",
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                    input.value = formattedValue;
                }
            });

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
                var statusValue = document.getElementById("projectStatus").value;
                                var ongoingInput = document.getElementById("ongoingStatus");

                                if (statusValue === "Ongoing") {
                                    var percentage = ongoingInput.value.trim();
                                    var date = document.getElementById("ongoingDate").value;

                                    if (percentage && date) {
                                        // Prevent duplicate concatenation
                                        if (!ongoingInput.value.includes(" - ")) {
                                            ongoingInput.value = percentage + " - " + date;
                                        }
                                    }
                                }
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

                        document.addEventListener("DOMContentLoaded", function () {
                            loadProjects(); // Load projects on page load
                        });

                        function loadProjects() {
    fetch("{{ route('projects.showDetails') }}")
        .then(response => response.json())
        .then(data => {
            console.log("API Response:", data);

            if (!data || typeof data !== "object" || !Array.isArray(data.projects)) {
                console.error("Invalid API Response Structure:", data);
                showError("No valid projects found.");
                return;
            }

            let projects = data.projects.map(project => [
                project.projectTitle || "N/A",
                project.projectLoc || "N/A",
                project.projectStatus || "N/A",
                project.contractAmount
                    ? `₱${parseFloat(project.contractAmount).toLocaleString()}`
                    : "N/A",
                project.projectContractor || "N/A",
                project.projectContractDays
                    ? `${project.projectContractDays} days`
                    : "N/A",
                `<button class="btn btn-primary btn-sm overview-btn" data-id="${project.projectID}">Overview</button>`
            ]);

            console.log("Processed Data:", projects);

            // Destroy existing DataTable before reloading
            if ($.fn.DataTable.isDataTable("#projects")) {
                $('#projects').DataTable().clear().destroy();
                console.log("Existing DataTable destroyed.");
            }

            // Initialize DataTable with updated settings
            $('#projects').DataTable({
                data: projects,
                columns: [
                    { title: "Project Title" },
                    { title: "Location" },
                    { title: "Status" },
                    { title: "Contract Amount" },
                    { title: "Contractor" },
                    { title: "Duration" },
                    { title: "Action", orderable: false }
                ],
                aLengthMenu: [[10, 15, 25, 50, 75, 100, -1], [10, 15, 25, 50, 75, 100, "All"]],
                pageLength: 10,
                order: [[3, 'desc']], // Sorting based on the 4th column (Contract Amount)
                scrollX: true,  // Enables horizontal scrolling
                responsive: true, // Ensures responsiveness
                autoWidth: false,   // Disable auto width setting
                columnDefs: [
                    {
                        targets: '_all',   // Apply this to all columns
                        orderable: true     // Ensure columns can still be sorted
                    }
                ],
                fixedColumns: {
                    leftColumns: 1  // Freezes the first column
                }
            });

            console.log("DataTable Reloaded Successfully!");
        })
        .catch(error => {
            console.error("Fetch Error:", error);
            showError("Failed to load project data.");
        });
}


// Show an error message inside the table if data fetching fails
function showError(message) {
    document.querySelector("#projects tbody").innerHTML = `
        <tr><td colspan="7" class="text-center text-danger">${message}</td></tr>
    `;
}

// Attach event listener for overview button clicks (event delegation)
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("overview-btn")) {
        let projectID = e.target.getAttribute("data-id");

        // Store projectID in session via AJAX
        fetch("/store-project-id", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content") // Laravel CSRF token
            },
            body: JSON.stringify({ projectID })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Project ID stored successfully, redirecting...");
                window.location.href = "{{ route('main.overview') }}"; // Redirect without ID in URL
            } else {
                console.error("Failed to store project ID:", data);
            }
        })
        .catch(error => console.error("Error storing project ID:", error));
    }
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