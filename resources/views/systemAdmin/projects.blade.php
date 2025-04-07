@extends('systemAdmin.layout')

@section('title', 'Projects Page')

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
                            <table id="projects" class="table table-striped table-hover table-bordered display nowrap" style="width:100%;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Project Title</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Contract Amount</th>
                                        <th>Contractor</th>
                                        <th>Duration</th>
                                        <th>Action</th>
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
                                            <input type="text" class="form-control" id="projectContractor" name="projectContractor" placeholder="Enter contractor name" onkeyup="showSuggestions(this.value)">
                                            <div id="suggestionsBox" class="list-group" style="display:none;"></div>
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
                                        <input type="number" class="form-control currency-input" id="abc" name="abc">
                                    </div>
                                    <div class="mb-1">
                                        <label for="contractAmount" class="form-label">Contract Amount</label>
                                        <input type="number" class="form-control currency-input" id="contractAmount" name="contractAmount">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="engineering" class="form-label">Engineering</label>
                                        <input type="number" class="form-control currency-input" id="engineering" name="engineering">
                                    </div>                                        
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="mqc" class="form-label">MQC</label>
                                        <input type="number" class="form-control currency-input" id="mqc" name="mqc">
                                    </div>
                                    <div class="mb-1">
                                        <label for="bid" class="form-label">Contingency</label>
                                        <input type="number" class="form-control currency-input" id="contingency" name="contingency">
                                    </div> 
                                    <div class="mb-1">
                                        <label for="bid" class="form-label">Bid Difference</label>
                                        <input type="number" class="form-control currency-input" id="bid" name="bid">
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="totalExpenditure" class="form-label">Total Expenditure</label>
                                    <input type="number" class="form-control currency-input" id="totalExpenditure" name="totalExpenditure">
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
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Project</button>
                                </div>                            
                            </form>
                        </div>
                    </div>
                </div>
            </div>

   

        <script>    
            document.addEventListener("DOMContentLoaded", function () {
                loadProjects(); // Load projects on page load
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


            // Handle "Other Fund" Dropdown Change
            $('#sourceOfFunds').on('change', function() {
                if ($(this).val() === 'Others') {
                    $('#otherFundContainer').slideDown(); // Show input with animation
                } else {
                    $('#otherFundContainer').slideUp(); // Hide input with animation
                }
            });
    

</script>


<script>
let orderCount = 1;

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
}

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



@endsection