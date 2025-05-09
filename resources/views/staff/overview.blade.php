@extends('staff.layout')

@section('title', 'Overview Page')

@section('content')
<!-- Project Overview -->
<hr class="mx-2">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-2">
                <a class="btn btn-outline-secondary btn-sm {{ Request::is('staff/projects') ? 'active' : '' }}"
                    href="{{ url('/staff/projects') }}">
                    <span class="fa fa-arrow-left"></span>
                </a>
                <h5 class="m-0">Project Overview</h5>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex align-items-center gap-2">           
                <button type="button" id="fundSummaryBtn" class="btn btn-secondary btn-sm d-flex align-items-center gap-1" 
                    data-bs-toggle="modal" data-bs-target="#fundSummaryModal" title="Fund Summary">
                    <i class="fa-solid fa-check-to-slot"></i>
                    <span class="d-none d-md-inline">Fund Summary</span>
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <h4 class="mb-0">{{ $project['projectTitle'] ?? 'N/A' }}</h4>
                </div>
            <div class="card-body">
                <div class="row gy-4">
                    <!-- Column 1 -->
                    <div class="col-md-4">
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;" >Project ID: <span style="font-weight: normal; font-size: 18px; color: black;">{{ $project['projectID'] ?? 'N/A' }}</span></strong>
                        </div>
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;">Location:  <span style="font-weight: normal; font-size: 18px; color: black;">{{ $project['projectLoc'] ?? 'N/A' }}</span></strong>
                           
                        </div>
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;">Contractor:  <span style="font-weight: normal; color: black;">
                                {{ ($project['projectContractor'] ?? '') === 'Others' ? ($project['othersContractor'] ?? 'N/A') : ($project['projectContractor'] ?? 'N/A') }}
                            </span></strong>
                        </div>
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;">Project Year:  <span style="font-weight: normal; font-size: 18px; color: black;">{{ $project['projectYear'] ?? 'N/A' }}</span></strong>  
                        </div>
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;">Project FPP:  <span style="font-weight: normal; font-size: 18px; color: black;">{{ $project['projectFPP'] ?? 'N/A' }}</span></strong>  
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="col-md-4">
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;">Implementation Mode:  <span style="font-weight: normal; color: black;">{{ $project['modeOfImplementation'] ?? 'N/A' }}</span></strong>
                        </div>
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;">Source of Fund:  <span style="font-weight: normal; color: black;">
                                {{ ($project['sourceOfFunds'] ?? '') === 'Others' ? ($project['otherFund'] ?? 'N/A') : ($project['sourceOfFunds'] ?? 'N/A') }}
                            </span></strong>
                           
                        </div>
                        <div class="mb-2">
                            <strong class="text-muted d-block" style="font-size: 18px;">Responsibility Center:  <span style="font-weight: normal; font-size: 18px; color: black;">{{ $project['projectRC'] ?? 'N/A' }}</span></strong>  
                        </div>
                        <div class="mb-2 d-flex align-items-center">
                            <strong class="text-muted me-2" style="font-size: 18px;">Status:  <span class="badge bg-success me-2" style="font-weight: normal;">{{ $project['projectStatus'] ?? 'N/A' }}</span>
                            <small >{{ $project['ongoingStatus'] ?? '' }}</small></strong>
                           
                        </div>
                    </div>

                    <!-- Column 3 - Progress Table -->
                    <div class="col-md-4">
                        <div class="bg-light p-2 d-flex justify-content-between align-items-center">
                            <span><i class="bi bi-bar-chart-line me-2"></i><strong>Progress</strong></span>
                        </div>

                        <!-- Scrollable Table Wrapper -->
                        <div class="table-responsive" style="max-height: 180px; overflow-y: auto;">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Progress</th>
                                        <th>Percentage</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($projectStatusData['ongoingStatus']) && is_array($projectStatusData['ongoingStatus']))
                                        @foreach ($projectStatusData['ongoingStatus'] as $status)
                                            <tr>
                                                <td>{{ $status['progress'] }}</td>
                                                <td>{{ $status['percentage'] }}%</td>
                                                <td>{{ $status['date'] }}</td>
                                            </tr>
                                        @endforeach
                                    @elseif ($projectStatusData['projectStatus'] === 'Completed')
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">This project is completed.</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">No progress data available.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <!-- Combined Card with Two Columns -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-light py-2">
                                <h6 class="fw-bold m-0">Project Description & Implementation Details</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Left Column: Project Description -->
                                    <div class="col-md-6 border-end pe-4">
                                        <h6 class="fw-bold">Project Description</h6>
                                        <div class="mb-3">
                                            <ul class="list-unstyled ps-3">
                                                @foreach ($project['projectDescriptions'] ?? [] as $desc)
                                                    <li class="mb-1">• {{ $desc }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div>
                                            <label class="text-muted">Slippage:</label>
                                            <span class="badge bg-danger ms-2">{{ $project['projectSlippage'] ?? 'N/A' }}</span>
                                        </div>
                                    </div>

                                    <!-- Right Column: Implementation Details -->
                                    <div class="col-md-6 ps-4">
                                        <h6 class="fw-bold">Implementation Details</h6>
                                        @foreach ($project['orderDetails'] as $field => $value)
                                            @php
                                                preg_match('/(suspensionOrderNo|resumeOrderNo)(\d+)/', $field, $matches);
                                                $type = $matches[1] ?? null;
                                                $index = isset($matches[2]) ? (int)$matches[2] : null;

                                                $suspKey = 'suspensionOrderNo' . $index;
                                                $resumeKey = 'resumeOrderNo' . $index;

                                                $suspensionValue = $project['orderDetails'][$suspKey] ?? null;
                                                $resumeValue = $project['orderDetails'][$resumeKey] ?? null;

                                                $shouldShow = $index === 1 || !empty($suspensionValue) || !empty($resumeValue);
                                            @endphp

                                              @if (!$type || $shouldShow)
                                                <div class="d-flex gap-2 mb-2">
                                                    <span class="text-muted" style="width: 200px;">{{ ucwords(str_replace(['suspensionOrderNo', 'resumeOrderNo'], ['Suspension Order No. ', 'Resume Order No. '], $field)) }}:</span>
                                                    <span class="fw-medium">{{ $value ?? 'N/A' }}</span>
                                                </div>
                                                
                                            @endif
                                        @endforeach

                                        @foreach ([
                                            'Time Extension' => 'timeExtension',
                                            'Revised Target Completion' => 'revisedTargetCompletion',
                                            'Completion Date' => 'completionDate'
                                        ] as $label => $key)
                                            <div class="d-flex gap-2 mb-2">
                                                <span class="text-muted" style="width: 180px;">{{ $label }}:</span>
                                                <span class="fw-medium">{{ $project[$key] ?? 'N/A' }}</span>
                                            </div>
                                        @endforeach
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

    
    @include('staff.modals.Projects.fund-summary')

@endsection
