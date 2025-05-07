@extends('systemAdmin.layout')

@section('title', 'Projects Page')

@section('content')
<div class="container-fluid py-4" style="background-color: transparent;">
    <!-- Header Section -->
    <div class="card mb-1 border-0 shadow-lg" >
        <div class="card-body p-2">
            <div class="d-flex justify-content-between align-items-center">
                <div class="ms-auto">
                    <button class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#addNewProjectModal"
                            style="background: linear-gradient(45deg, #2196F3, #1976D2); border: none; box-shadow: 0 2px 5px rgba(33, 150, 243, 0.3); padding: 10px 20px; font-weight: 500;">
                        <i class="fas fa-plus-circle me-2"></i>Add New Project
                    </button>
                </div>
            </div>
        </div>
    </div>


    <!-- Filters Section -->
    <div class="card border-0 shadow-sm mb-1">
        <div class="card-body p-2">
            <h5 class="mb-3" style="color: #2c3e50; font-weight: 600;">
                <i class="fas fa-filter me-2"></i>Filter Projects
            </h5>
            <div class="row g-3">
               <!-- Location Dropdown -->
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select class="form-select" id="location_filter" name="location_filter">
                                <option value="" selected disabled>Select Location</option>
                                <option value="">All Location</option>
                                @foreach($allLocations as $location)
                                    <option value="{{ $location }}">{{ $location }}</option>
                                @endforeach
                            </select>
                            <label for="location_filter">
                                <i class="bi bi-geo-alt me-2"></i>Location
                            </label>
                        </div>
                    </div>



                <!-- Contractor Dropdown -->
                    <div class="col-md-3">
                        <div class="form-floating">
                            <select id="contractor_filter" name="contractor" class="form-select">
                                <option value="" selected disabled>Select Contractor</option>
                                <option value="" >All Contractor</option>
                                @foreach($contractors as $contractor)
                                    <option value="{{ $contractor->name }}">{{ $contractor->name }}</option>
                                @endforeach
                            </select>
                            <label for="contractor_filter">
                                <i class="bi bi-person-workspace me-2"></i>Contractor
                            </label>
                        </div>
                    </div>

                <!-- Amount Filter -->
                <div class="col-md-3">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="amount_filter" name="amount_filter"
                            placeholder="Enter amount">
                        <label for="amount_filter">
                            <i class="fas fa-peso-sign me-2"></i>Amount
                        </label>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="col-md-3">
                    <div class="form-floating">
                        <select id="status_filter" class="form-select">
                            <option value="">Select Status</option>
                            <option value="All">All</option>
                            <option value="To Be Started">To Be Started</option>
                            <option value="Ongoing">Ongoing</option>
                            <option value="Completed">Completed</option>
                            <option value="Discontinued">Discontinued</option>
                            <option value="Suspended">Suspended</option>
                        </select>
                        <label for="status_filter">
                            <i class="bi bi-info-circle me-2"></i>Status
                        </label>
                    </div>
                </div>
                <!-- View All Projects Checkbox -->
            <div class="col-md-3 d-flex align-items-end">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="view_all_checkbox" onchange="filterProjects()">
                    <label class="form-check-label fw-semibold" for="view_all_checkbox">
                        View All Projects
                    </label>
                </div>
            </div>

            </div>
        </div>
    </div>


            <div class="col-md-12 m-2">

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
                                @forelse($mappedProjects as $project)
                                    <tr>
                                        <td>{{ $project['title'] }}</td>
                                        <td>{{ $project['location'] }}</td>
                                        <td>{{ $project['status'] }}</td>
                                        <td>₱{{ $project['amount'] }}</td>
                                        <td>{{ $project['contractor'] }}</td>
                                        <td>{{ $project['duration'] }}</td>
                                        <td>
                                            <button class="btn btn-primary btn-sm overview-btn" data-id="{{ $project['id'] }}">Overview</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">There are no currently added projects.</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function () {
    const locationInput = document.getElementById('location_filter');
    const dropdown = document.getElementById('locationDropdown');

    function filterLocationDropdown(value) {
        const items = dropdown.querySelectorAll('button');
        let visible = 0;

        items.forEach(item => {
            if (item.textContent.toLowerCase().includes(value.toLowerCase())) {
                item.style.display = '';
                visible++;
            } else {
                item.style.display = 'none';
            }
        });

        dropdown.style.display = (visible > 0) ? 'block' : 'none';
    }

    function selectLocation(value) {
        locationInput.value = value + ', Nueva Vizcaya';
        dropdown.style.display = 'none';
    }

    function showLocationDropdown() {
        const items = dropdown.querySelectorAll('button');
        items.forEach(item => item.style.display = '');
        dropdown.style.display = 'block';
    }

    document.addEventListener('click', function (e) {
        if (dropdown && !dropdown.contains(e.target) && e.target !== locationInput) {
            dropdown.style.display = 'none';
        }
    });

    // If needed, expose the functions globally
    window.filterLocationDropdown = filterLocationDropdown;
    window.selectLocation = selectLocation;
    window.showLocationDropdown = showLocationDropdown;
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

                // Restrict invalid characters while typing
                input.addEventListener("input", function () {
                    input.value = input.value.replace(/[^\d₱.,]/g, '');
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

    </script>

    <script>
        // 1) Define the function globally
        function filterSuggestions(query) {
            const box = document.getElementById('suggestionsBox');
            const items = box.getElementsByClassName('suggestion-item');
            const q = query.trim().toLowerCase();
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
    const box = document.getElementById('suggestionsBox');

    if (!input || !box) return; // Exit early if elements don't exist

    const items = box.getElementsByClassName('suggestion-item');

    input.addEventListener('keyup', e => filterSuggestions(e.target.value));

    Array.from(items).forEach(item => {
        item.addEventListener('click', () => {
            input.value = item.textContent.trim();
            box.style.display = 'none';
        });
    });

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

            suspensionOrderNo.addEventListener('change', function () {
                validateOrderDates(orderCount);
            });

            resumeOrderNo.addEventListener('change', function () {
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
        document.addEventListener("DOMContentLoaded", function () {
            const firstSuspensionOrderNo = document.getElementById('suspensionOrderNo1');
            const firstResumeOrderNo = document.getElementById('resumeOrderNo1');

            firstSuspensionOrderNo.addEventListener('change', function () {
                validateOrderDates(1);
            });

            firstResumeOrderNo.addEventListener('change', function () {
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
                        item.onclick = function () {
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

    @include('systemAdmin.modals.Projects.add-project')

@endsection