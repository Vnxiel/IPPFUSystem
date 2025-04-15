@extends('systemAdmin.layout')

@section('title', 'Projects Page')

@section('content') 
            <hr class="mx-2">
            <div class="container-fluid px-3">
        <div class="row">
            <!-- Custom Filters -->
            <div class="col-md-12">
                <div class="filter-container">
                    <div class="row">
                    <div class="col-md-3 mb-2">
                        <label for="location_filter">Location:</label>
                        <select id="location_filter" class="form-select">
                            <option value="">All Locations</option>
                            <option value="Alfonso Castañeda, Nueva Vizcaya">Alfonso Castañeda, Nueva Vizcaya</option>
                            <option value="Ambaguio, Nueva Vizcaya">Ambaguio, Nueva Vizcaya</option>
                            <option value="Aritao, Nueva Vizcaya">Aritao, Nueva Vizcaya</option>
                            <option value="Bagabag, Nueva Vizcaya">Bagabag, Nueva Vizcaya</option>
                            <option value="Bambang, Nueva Vizcaya">Bambang, Nueva Vizcaya</option>
                            <option value="Bayombong, Nueva Vizcaya">Bayombong, Nueva Vizcaya</option>
                            <option value="Diadi, Nueva Vizcaya">Diadi, Nueva Vizcaya</option>
                            <option value="Dupax del Norte, Nueva Vizcaya">Dupax del Norte, Nueva Vizcaya</option>
                            <option value="Dupax del Sur, Nueva Vizcaya">Dupax del Sur, Nueva Vizcaya</option>
                            <option value="Kasibu, Nueva Vizcaya">Kasibu, Nueva Vizcaya</option>
                            <option value="Kayapa, Nueva Vizcaya">Kayapa, Nueva Vizcaya</option>
                            <option value="Quezon, Nueva Vizcaya">Quezon, Nueva Vizcaya</option>
                            <option value="Santa Fe, Nueva Vizcaya">Santa Fe, Nueva Vizcaya</option>
                            <option value="Solano, Nueva Vizcaya">Solano, Nueva Vizcaya</option>
                            <option value="Villaverde, Nueva Vizcaya">Villaverde, Nueva Vizcaya</option>
                        </select>
                    </div>

                    <div class="col-md-3 mb-2">
                        <label for="contractor_filter">Contractor:</label>
                        <input 
                            list="contractors_list" 
                            id="contractor_filter" 
                            name="contractor" 
                            class="form-select" 
                            placeholder="Select or type a contractor" 
                            required
                        >
                        <datalist id="contractors_list">
                            <option value="">All Contractors</option>
                            @foreach($contractors as $contractor)
                                <option value="{{ $contractor->name }}"></option>
                            @endforeach
                        </datalist>
                    </div>

                        <div class="col-md-3 mb-2">
                            <label for="amount_filter">Amount:</label>
                            <input type="text" class="form-control" id="amount_filter" name="amount_filter" required>
                        </div>
                        <div class="col-md-3 mb-2">
                            <label for="status_filter">Status:</label>
                            <select id="status_filter" class="form-select">
                                <option value="">All Status</option>
                                <option value="Active">Ongoing</option>
                                <option value="Completed">Completed</option>
                                <option value="Pending">Discontinued</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                                        <th style="width:15%">Project Title</th>
                                        <th style="width:5%">Location</th>
                                        <th style="width:5%">Status</th>
                                        <th style="width:5%">Contract Amount</th>
                                        <th style="width:5%">Contractor</th>
                                        <th style="width:5%">Duration</th>
                                        <th style="width:5%">Action</th>
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
                            <div class="col-md-12">
                                <div class="mb-1">
                                    <label for="projectTitle" class="form-label">Project Title</label>
                                    <textarea class="form-control" id="projectTitle" name="projectTitle" rows="2"
                                        placeholder="Enter project title." required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-1">
                                    <label for="projectID" class="form-label">Project ID</label>
                                    <textarea class="form-control" id="projectID" name="projectID" rows="2"
                                        placeholder="Enter Project ID." required></textarea>
                                </div>
                                <div class="mb-1">
                                            <label for="ea" class="form-label">Project E.A</label>
                                            <input type="text" class="form-control" id="ea" name="ea" placeholder="Enter E.A">
                                        </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-1">
                                    <label for="projectDescription" class="form-label">Project Description</label>
                                    <textarea class="form-control" id="projectDescription" name="projectDescription"
                                        rows="3" placeholder="Enter project description."></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                            <div class="mb-1">
                            <label for="projectLoc">Location:</label>
                            <select id="projectLoc" name="projectLoc" class="form-select" required>
                                <option value="">All Locations</option>
                                <option value="Alfonso Castañeda, Nueva Vizcaya">Alfonso Castañeda, Nueva Vizcaya</option>
                                <option value="Ambaguio, Nueva Vizcaya">Ambaguio, Nueva Vizcaya</option>
                                <option value="Aritao, Nueva Vizcaya">Aritao, Nueva Vizcaya</option>
                                <option value="Bagabag, Nueva Vizcaya">Bagabag, Nueva Vizcaya</option>
                                <option value="Bambang, Nueva Vizcaya">Bambang, Nueva Vizcaya</option>
                                <option value="Bayombong, Nueva Vizcaya">Bayombong, Nueva Vizcaya</option>
                                <option value="Diadi, Nueva Vizcaya">Diadi, Nueva Vizcaya</option>
                                <option value="Dupax del Norte, Nueva Vizcaya">Dupax del Norte, Nueva Vizcaya</option>
                                <option value="Dupax del Sur, Nueva Vizcaya">Dupax del Sur, Nueva Vizcaya</option>
                                <option value="Kasibu, Nueva Vizcaya">Kasibu, Nueva Vizcaya</option>
                                <option value="Kayapa, Nueva Vizcaya">Kayapa, Nueva Vizcaya</option>
                                <option value="Quezon, Nueva Vizcaya">Quezon, Nueva Vizcaya</option>
                                <option value="Santa Fe, Nueva Vizcaya">Santa Fe, Nueva Vizcaya</option>
                                <option value="Solano, Nueva Vizcaya">Solano, Nueva Vizcaya</option>
                                <option value="Villaverde, Nueva Vizcaya">Villaverde, Nueva Vizcaya</option>
                            </select>
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
                                        placeholder="Enter new contractor name">
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
                                            <label for="projectStatus" class="form-label">Status</label>
                                            <select id="projectStatus" name="projectStatus" class="form-select" onchange="toggleOngoingStatus()">
                                                <option value="---">---</option>
                                                <option value="Ongoing">Ongoing</option>
                                                <option value="Completed">Completed</option>
                                                <option value="Cancelled">Discontinued</option>
                                            </select>

                                            <!-- Hidden text input for 'Ongoing' -->
                                            <div id="ongoingStatusContainer" class="mt-2" style="display: none;">
                                                <label for="ongoingStatus" class="form-label">Please specify percentage completion:</label>
                                                
                                                <div class="d-flex gap-2"> 
                                                    <input type="text" id="ongoingStatus" name="ongoingStatus" class="form-control w-50" placeholder="Enter percentage">
                                                    <input type="date" id="ongoingDate" class="form-control w-50">
                                                </div>
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
                                            <label for="revisedContractCost" class="form-label">Revised Contract Cost</label>
                                            <input type="number" class="form-control currency-input" id="revisedContractCost" name="revisedConstractCost" min="0">
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
                                        <input type="text" class="form-control currency-input" id="bid" name="bid" readonly>
                                    </div>                                    
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
                                     <div class="col-md-10">
                                        <hr>
                                     </div>
                                    <div class="col-2 text-center mb-0">
                                        <button type="button" class="btn btn-outline-primary btn-sm mr-1" onclick="addOrderFields()" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Suspension and Resumption Order">
                                            <span class="fa-solid fa-square-plus"></span>                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeLastOrderFields()" data-bs-toggle="tooltip" data-bs-placement="top" title="Suspension and Resumption Order">
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
                                        <input type="date" class="form-control" id="revisedTargetCompletion" name="revisedTargetCompletion">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-1">
                                            <label for="completionDate" class="form-label">Completion Date</label>
                                            <input type="date" class="form-control" id="completionDate" name="completionDate">
                                        </div>
                                </div>                
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Project</button>
                                </div>                            
                            </form>
                        </div>
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
      if (issued.value && received.value) {
        const issuedDate = new Date(issued.value);
        const receivedDate = new Date(received.value);

        // Only validate if both dates are valid
        if (!isNaN(issuedDate) && !isNaN(receivedDate)) {
          if (receivedDate <= issuedDate) {
            Swal.fire({
              icon: 'error',
              title: `${label} Error`,
              text: 'Received date must be after the issued date.',
              confirmButtonColor: '#3085d6',
            });
            received.value = ""; // Clear invalid input
          }
        }
      }
    }

    // Use blur instead of change so it fires after typing and moving away
    issued.addEventListener("blur", checkDate);
    received.addEventListener("blur", checkDate);
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

/////#                  