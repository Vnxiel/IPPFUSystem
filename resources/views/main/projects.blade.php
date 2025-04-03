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
                            <table id="projects" class="table table-striped table-hover table-bordered" style="width:100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width:10%;">Project Title</th>
                                        <th style="width:15%;">Location</th>
                                        <th style="width:10%;">Status</th>
                                        <th style="width:10%;">Contract Amount</th>
                                        <th style="width:15%;">Contractor</th>
                                        <th style="width:15%;">Duration</th>
                                        <th style="width:15%;">Action</th>
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
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-1">
                                                <label for="projectTitle" class="form-label">Project Title</label>
                                                <input type="text" class="form-control" id="projectTitle" name="projectTitle" required placeholder="Enter project title">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-1">
                                                <label for="projectID" class="form-label">Project ID</label>
                                                <input type="text" class="form-control" id="projectID" name="projectID" required placeholder="Enter project id">
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="projectDescription" class="form-label">Project Description</label>
                                        <textarea class="form-control" id="projectDescription" name="projectDescription" rows="3" placeholder="Enter project description"></textarea>
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
                               
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="projectContractor" class="form-label">Contractor</label>
                                        <input type="text" class="form-control" id="projectContractor" name="projectContractor" placeholder="Enter project contractor">
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
                                    <div class="mb-1">
                                        <label for="mqc" class="form-label">MQC</label>
                                        <input type="text" class="form-control currency-input" id="mqc" name="mqc">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="contingency" class="form-label">Contingency</label>
                                        <input type="text" class="form-control currency-input" id="contingency" name="contingency">
                                    </div>
                                    <div class="mb-1">
                                        <label for="bid" class="form-label">Bid Difference</label>
                                        <input type="text" class="form-control currency-input" id="bid" name="bid">
                                    </div>
                                    <div class="mb-1">
                                        <label for="appropriation" class="form-label">Appropriation</label>
                                        <input type="text" class="form-control currency-input" id="appropriation" name="appropriation">
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


            $(document).ready(function() {
                $('#sourceOfFunds').on('change', function() {
                    if ($(this).val() === 'Others') {
                        $('#otherFundContainer').slideDown();
                    } else {
                        $('#otherFundContainer').slideUp();
                    }
                });
            });

          
    

</script>

@endsection