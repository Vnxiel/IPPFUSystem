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
        

<script>
   // Function to toggle the visibility of the 'otherFundContainer' when 'Others' is selected in 'Source of Fund'
function toggleOtherFund() {
    const sourceOfFunds = document.getElementById("sourceOfFunds").value;
    const otherFundContainer = document.getElementById("otherFundContainer");
    
    if (sourceOfFunds === "Others") {
        otherFundContainer.style.display = "block"; // Show the input field for specifying the fund
    } else {
        otherFundContainer.style.display = "none"; // Hide the input field if not selected
    }
}

// Function to toggle the visibility of the 'othersContractorDiv' when 'Others' is selected in 'Contractor'
function toggleOtherContractor() {
    const projectContractor = document.getElementById("projectContractor").value;
    const othersContractorDiv = document.getElementById("othersContractorDiv");
    
    if (projectContractor === "Others") {
        othersContractorDiv.style.display = "block"; // Show the input field for specifying the contractor
    } else {
        othersContractorDiv.style.display = "none"; // Hide the input field if not selected
    }
}

// Ensure the correct visibility when the page loads, in case the 'Others' option was already selected in any dropdown
document.addEventListener("DOMContentLoaded", function() {
    toggleOtherFund(); // Check if 'Others' was selected for Source of Fund
    toggleOtherContractor(); // Check if 'Others' was selected for Contractor
});

    </script>

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

    
    @include('systemAdmin.modals.add-fund')
    @include('systemAdmin.modals.add-status')
    @include('systemAdmin.modals.check-status')
    @include('systemAdmin.modals.edit-project')
    @include('systemAdmin.modals.uploadFiles')
    @include('systemAdmin.modals.generate-report')

@endsection
