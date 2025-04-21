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

            <!-- Location -->
            <div class="col-md-3 mb-2">
                <label for="location_filter">Location:</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-geo-alt"></i> <!-- Bootstrap icon -->
                    </span>
                    <input type="text" class="form-control" id="location_filter" name="location_filter"
                        placeholder="Enter Location" onkeyup="filterSuggestions(this.value)" autocomplete="off">
                </div>
                <div id="suggestionsBox" class="list-group position-absolute w-100 shadow"
                    style="display:none; max-height: 200px; overflow-y: auto; z-index: 10;">
                    @foreach($locations as $location)
                    <button type="button" class="list-group-item list-group-item-action suggestion-item">
                        {{ $location->location }}
                    </button>
                    @endforeach
                </div>
            </div>

            <!-- Contractor -->
            <div class="col-md-3 mb-2">
                <label for="contractor_filter">Contractor:</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person-workspace"></i>
                    </span>
                    <input list="contractors_list" id="contractor_filter" name="contractor" class="form-select"
                        placeholder="Select or type a contractor" required>
                    <datalist id="contractors_list">
                        <option value="">All Contractors</option>
                        @foreach($contractors as $contractor)
                        <option value="{{ $contractor->name }}"></option>
                        @endforeach
                    </datalist>
                </div>
            </div>

            <!-- Amount -->
            <div class="col-md-3 mb-2">
                <label for="amount_filter">Amount:</label>
                <div class="input-group">
                    <span class="input-group-text">₱</span>
                    <input type="text" class="form-control" id="amount_filter" name="amount_filter"
                        placeholder="Enter amount" required>
                </div>
            </div>

            <!-- Status -->
            <div class="col-md-3 mb-2">
                <label for="status_filter">Status:</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-info-circle"></i>
                    </span>
                    <select id="status_filter" class="form-select">
                        <option value="">All Status</option>
                        <option value="Ongoing">Ongoing</option>
                        <option value="Completed">Completed</option>
                        <option value="Discontinued">Discontinued</option>
                    </select>
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
  // 1) Define the function globally
  function filterSuggestions(query) {
    const box   = document.getElementById('suggestionsBox');
    const items = box.getElementsByClassName('suggestion-item');
    const q     = query.trim().toLowerCase();
    let visible = false;

    Array.from(items).forEach(item => {
      const text = item.textContent.trim().toLowerCase();
      if (q !== '' && text.includes(q)) {
        item.style.display = 'block';
        visible = true;
      } else {
        item.style.display = 'none';
      }
    });

    box.style.display = visible ? 'block' : 'none';
  }

  // 2) Wire up events once DOM is ready
  document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('projectLoc');
    const box   = document.getElementById('suggestionsBox');
    const items = box.getElementsByClassName('suggestion-item');

    // Replace inline onkeyup with a JS listener
    input.addEventListener('keyup', e => filterSuggestions(e.target.value));

    // Click a suggestion → fill input + hide box
    Array.from(items).forEach(item => {
      item.addEventListener('click', () => {
        input.value = item.textContent.trim();
        box.style.display = 'none';
      });
    });

    // Click outside → hide box
    document.addEventListener('click', e => {
      if (!box.contains(e.target) && e.target !== input) {
        box.style.display = 'none';
      }
    });
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


    @include('systemAdmin.modals.add-project')

@endsection
