@extends('admin.layout')

@section('title', 'Overview Page')

@section('content')
<!-- Project Overview -->
<hr class="mx-2">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center gap-2">
                <a class="btn btn-outline-secondary btn-sm {{ Request::is('systemAdmin/projects') ? 'active' : '' }}"
                    href="{{ url('/systemAdmin/projects') }}">
                    <span class="fa fa-arrow-left"></span>
                </a>
                <h5 class="m-0">Project Overview</h5>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-primary btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal"
                    data-bs-target="#addProjectFundUtilization" title="Add Fund Utilization Details">
                    <span class="fa fa-plus"></span>
                    <span class="d-none d-md-inline">Add Fund</span>
                </button>
                <button type="button" class="btn btn-success btn-sm d-flex align-items-center gap-1" data-bs-toggle="modal" 
                    data-bs-target="#uploadModal" title="Upload Files">
                    <i class="fa fa-upload"></i>
                    <span class="d-none d-md-inline">Upload</span>
                </button>
                <button type="button" id="editProjectBtn" class="btn btn-warning btn-sm d-flex align-items-center gap-1" 
                    data-bs-toggle="modal" data-bs-target="#projectModal" title="Edit Project Details">
                    <i class="fa fa-edit"></i>
                    <span class="d-none d-md-inline">Edit</span>
                </button>
                <button type="button" id="generateProjectBtn" class="btn btn-info btn-sm d-flex align-items-center gap-1" 
                    data-bs-toggle="modal" data-bs-target="#generateProjectModal" title="Generate/Download Report">
                    <i class="fa fa-download"></i>
                    <span class="d-none d-md-inline">Report</span>
                </button>
                <button type="button" id="checkStatusBtn" class="btn btn-secondary btn-sm d-flex align-items-center gap-1" 
                    data-bs-toggle="modal" data-bs-target="#checkStatusModal" title="Check Status">
                    <i class="fa-solid fa-check-to-slot"></i>
                    <span class="d-none d-md-inline">Status</span>
                </button>
                <button type="button" id="trashProjectBtn" class="btn btn-danger btn-sm d-flex align-items-center gap-1" 
                    data-bs-toggle="modal" data-bs-target="#trashModal" title="Archive Project">
                    <i class="fa fa-trash"></i>
                    <span class="d-none d-md-inline">Archive</span>
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-3">{{ $project['projectTitle'] ?? 'N/A' }}</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="d-flex gap-2 mb-2">
                                <span class="text-muted" style="width: 120px;">Project ID:</span>
                                <span class="fw-medium">{{ $project['projectID'] ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex gap-2 mb-2">
                                <span class="text-muted" style="width: 120px;">Location:</span>
                                <span class="fw-medium">{{ $project['projectLoc'] ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex gap-2 mb-2">
                                <span class="text-muted" style="width: 120px;">Contractor:</span>
                                <span class="fw-medium">
                                    {{ ($project['projectContractor'] ?? '') === 'Others' ? ($project['othersContractor'] ?? 'N/A') : ($project['projectContractor'] ?? 'N/A') }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-3 mb-2">
                                <span class="text-muted" style="width: 150px;">Implementation:</span>
                                <span class="fw-medium">{{ $project['modeOfImplementation'] ?? 'N/A' }}</span>
                            </div>
                            <div class="d-flex gap-3 mb-2">
                                <span class="text-muted" style="width: 150px;">Source of Fund:</span>
                                <span class="fw-medium">
                                    {{ ($project['sourceOfFunds'] ?? '') === 'Others' ? ($project['otherFund'] ?? 'N/A') : ($project['sourceOfFunds'] ?? 'N/A') }}
                                </span>
                            </div>
                            <div class="d-flex gap-3 align-items-center">
                                <span class="text-muted" style="width: 150px;">Status:</span>
                                <span class="badge bg-success">{{ $project['projectStatus'] ?? 'N/A' }}</span>
                                <span class="text-muted ms-2">{{ $project['ongoingStatus'] ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row g-4">
                        <!-- LEFT COLUMN -->
                        <div class="col-md-12">
                            <!-- Project Details -->
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-light py-2">
                                    <h6 class="fw-bold m-0">Project Description</h6>
                                </div>
                                <div class="card-body">
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
                            </div>

                           <!-- Contract Details -->
<!-- Contract Details -->
<div class="card shadow-sm mb-3">
    <div class="card-header bg-light py-2">
        <h6 class="fw-bold m-0">Fund Utilization Summary</h6>
    </div>
    <div class="card-body">
        @php
            $funds = $project['funds'] ?? [];
            $summary = $project['summary'] ?? [];
            $variationOrders = $project['variation_orders'] ?? [];
            $voHeader = collect($variationOrders)->pluck('vo_number');

            $voCount = $voHeader->count();
            $totalCol = 2 + $voCount; // original + actual + VOs

            $totalExpenditures = $summary['totalExpenditures'] ?? 0;
            $totalSavings = $summary['totalSavings'] ?? 0;
        @endphp

        <div class="d-flex flex-column gap-2">
            <!-- Header Row -->
            <div class="d-flex fw-bold border-bottom pb-2">
                <div class="flex-grow-1" style="width: 25%;">Category</div>
                <div class="text-end" style="width: 15%;">Original</div>
                @foreach ($voHeader as $voNum)
                    <div class="text-end" style="width: 15%;">VO {{ $voNum }}</div>
                @endforeach
                <div class="text-end" style="width: 15%;">Actual</div>
            </div>

            @php
                $standardRows = [
                    'Appropriation' => ['orig_appropriation', 'actual_appropriation', 'vo_appropriation'],
                    'ABC' => ['orig_abc', 'actual_abc', 'vo_abc'],
                    'Contract Amount' => ['orig_contract_amount', 'actual_contract_amount', 'vo_contract_amount'],
                    'Bid Difference' => ['orig_bid', 'actual_bid', 'vo_bid'],
                ];
                $postEngineeringRows = [
                    'MQC' => ['orig_mqc', 'actual_mqc', 'vo_mqc'],
                    'Contingency' => ['orig_contingency', 'actual_contingency', 'vo_contingency'],
                ];
            @endphp

            <!-- Standard Rows -->
            @foreach ($standardRows as $label => [$origKey, $actualKey, $voKey])
                <div class="d-flex border-bottom py-1 align-items-center">
                    <div class="flex-grow-1 fw-semibold" style="width: 25%;">{{ $label }}</div>
                    <div class="text-end" style="width: 15%;">₱{{ number_format((float)($funds[$origKey] ?? 0), 2) }}</div>
                    @foreach ($variationOrders as $vo)
                        <div class="text-end" style="width: 15%;">₱{{ number_format((float)($vo[$voKey] ?? 0), 2) }}</div>
                    @endforeach
                    <div class="text-end" style="width: 15%;">₱{{ number_format((float)($funds[$actualKey] ?? 0), 2) }}</div>
                </div>
            @endforeach

            <!-- Divider -->
            <div class="border-top border-dark my-2" style="height: 3px;"></div>

            <!-- Wages Header Row -->
            <div class="d-flex fw-bold align-items-center">
                <div class="flex-grow-1" style="width: 25%;">Wages</div>
                <div class="text-end" style="width: 15%;"></div>
                @for ($i = 0; $i < $voCount; $i++)
                    <div class="text-end" style="width: 15%;"></div>
                @endfor
                <div class="text-end" style="width: 15%;"></div>
            </div>

            <!-- Wages: Engineering Row -->
            <div class="d-flex py-1 align-items-center">
                <div class="flex-grow-1 ps-3" style="width: 25%;">Engineering</div>
                <div class="text-end" style="width: 15%;">₱{{ number_format((float)($funds['orig_engineering'] ?? 0), 2) }}</div>
                @foreach ($variationOrders as $vo)
                    <div class="text-end" style="width: 15%;">₱{{ number_format((float)($vo['vo_engineering'] ?? 0), 2) }}</div>
                @endforeach
                <div class="text-end" style="width: 15%;">₱{{ number_format((float)($funds['actual_engineering'] ?? 0), 2) }}</div>
            </div>

            <!-- Post Engineering Rows -->
            @foreach ($postEngineeringRows as $label => [$origKey, $actualKey, $voKey])
                <div class="d-flex py-1 align-items-center">
                    <div class="flex-grow-1 fw-semibold" style="width: 25%;">{{ $label }}</div>
                    <div class="text-end" style="width: 15%;">₱{{ number_format((float)($funds[$origKey] ?? 0), 2) }}</div>
                    @foreach ($variationOrders as $vo)
                        <div class="text-end" style="width: 15%;">₱{{ number_format((float)($vo[$voKey] ?? 0), 2) }}</div>
                    @endforeach
                    <div class="text-end" style="width: 15%;">₱{{ number_format((float)($funds[$actualKey] ?? 0), 2) }}</div>
                </div>
            @endforeach

            <!-- Totals -->
            <div class="border-top border-dark my-2" style="height: 3px;"></div>

            <div class="d-flex py-1 align-items-center bg-light">
                <div class="fw-bold" style="width: 25%;">Total Expenditures</div>
                <div class="text-end" style="width: 15%;"></div>
                <div class="text-end fw-bold" style="width: 15%;">
                    {{ $summary['totalExpenditures']['amount'] ?? '₱0.00' }}
                </div>   
            </div>

            <div class="d-flex py-1 align-items-center bg-light">
                <div class="fw-bold" style="width: 25%;">Total Savings</div>
                <div class="text-end" style="width: 15%;"></div>
                <div class="text-end fw-bold" style="width: 15%;">
                    {{ $summary['totalSavings']['amount'] ?? '₱0.00' }}
                </div>   
            </div>
        </div>
    </div>
</div>



                            </div>

                            <!-- Implementation Details -->
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="fw-bold">Implementation Details</h6>
                                </div>
                                <div class="card-body">
                                @foreach ($project['orderDetails'] as $field => $value)
                                @php
                                    // Match fields like suspensionOrderNo2, resumeOrderNo3, etc.
                                    preg_match('/(suspensionOrderNo|resumeOrderNo)(\d+)/', $field, $matches);
                                    $type = $matches[1] ?? null;
                                    $index = isset($matches[2]) ? (int)$matches[2] : null;

                                    // Get both suspension and resume values for this index
                                    $suspKey = 'suspensionOrderNo' . $index;
                                    $resumeKey = 'resumeOrderNo' . $index;

                                    $suspensionValue = $project['orderDetails'][$suspKey] ?? null;
                                    $resumeValue = $project['orderDetails'][$resumeKey] ?? null;

                                    $shouldShow = $index === 1 || !empty($suspensionValue) || !empty($resumeValue);
                                @endphp

                                @if (!$type || $shouldShow)
                                    <div class="d-flex gap-2 mb-2">
                                        <span class="text-muted" style="width: 200px;">{{ ucwords(str_replace(['suspensionOrderNo', 'resumeOrderNo'], ['Suspension Order No. ', 'Resume Order No. '], $field)) }}:</span>
                                        <span class="fw-medium">
                                            {{ $value ?? 'N/A' }}                                       
                                        </span>
                                    </div>
                                @endif
                            @endforeach

                                @foreach ([
                                    'Time Extension' => 'timeExtension',
                                    'Revised Target Completion' => 'revisedTargetCompletion',
                                    'Completion Date' => 'completionDate'
                                ] as $label => $key)
                                    <div class="d-flex gap-2 mb-2">
                                        <span class="text-muted" style="width: 200px;">{{ $label }}:</span>
                                        <span class="fw-medium">
                                            {{ $project[$key] ?? 'N/A' }}                                     
                                        </span>
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
