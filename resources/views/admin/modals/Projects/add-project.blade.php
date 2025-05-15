<!-- Add Project Modal -->
<div class="modal fade" id="addNewProjectModal" tabindex="-1" aria-labelledby="addNewProjectLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5 fw-bold" id="appNewProjectLabel">
                    <i class="fas fa-plus-circle me-2"></i>Add Project
                </h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{ route('projects.addProject') }}" id="addProjectForm" method="POST">
                    @csrf
                    <fieldset class="border p-3 mb-4 rounded shadow-sm">
                        <legend class="float-none w-auto px-3 fw-bold text-primary">
                            <i class="fas fa-info-circle me-2"></i>Project Profile
                        </legend>

                        <!-- Project Title, ID, and Year -->
                        <div class="row g-3 mb-2">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-3 text-end">
                                        <label for="projectTitle" class="form-label">Project Title <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col">
                                        <textarea class="form-control" id="projectTitle" name="projectTitle" rows="3"
                                            required></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-2">
                            <div class="col-md-12  mb-2">
                                <div class="row">
                                    <div class="col-3 text-end">
                                        <label for="projectID" class="form-label">Project ID <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col">
                                        <input type="text" class="form-control" id="projectID" name="projectID" pattern="^[0-9-]+$" title="Only numbers and hyphens are allowed"                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3 mb-2 text-end">
                            <div class="col-md-3 text-end">
                                <label for="projectYear" class="form-label">Year <span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" id="projectYearSelect" name="projectYearSelect" required>
                                    <option value="" disabled selected>Select Year</option>
                                    <!-- Year options will be injected here by JavaScript -->
                                </select>

                                <!-- Hidden input for custom year -->
                                <input type="number" class="form-control form-control-sm mt-2" id="customYearInput" name="projectYear" placeholder="Enter Year" style="display: none;" min="1900" max="2100">
                            </div>
                            <div class="col-md-2 text-end">
                                <label for="projectFPP" class="form-label">FPP <span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="projectFPP" name="projectFPP" required>
                            </div>
                        </div>
                        <div class="row mb-2 g-3 text-end">
                            <div class="col-md-3 text-end">
                                <label for="projectRC" class="form-label">Responsibility Center<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="projectRC" name="projectRC" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-2 text-end">
                            <div class="col-md-3">
                                <label for="projectLoc" class="form-label">Location
                                    <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-md-9 position-relative">
                                <input type="text" class="form-control" id="projectLoc" name="projectLoc"
                                    placeholder="Select or enter location" autocomplete="off"
                                    onfocus="showLocDropdown()" oninput="showLocDropdown()" />
                                <!-- Place dropdown outside input -->
                                <div id="projectLocDropdown"
                                    class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                    style="display: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                                    @foreach($locations as $location)
                                        <button type="button" class="list-group-item list-group-item-action"
                                            onclick="selectLoc('{{ $location }}')">
                                            {{ $location }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                        <!-- Project Description -->
                        <div class="row mb-2 g-3">
                            <div class="col-3 text-end">
                                <label for="projectDescription" class="form-label">Project Description<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col">
                                <textarea class="form-control" id="projectDescription" name="projectDescription"
                                    rows="4" required></textarea>
                            </div>
                        </div>

                        <!-- Contractor Input with Dynamic Suggestions -->
                        <div class="row g-3 mb-2 text-end">
                            <div class="col-md-3">
                                <label for="projectContractor" class="form-label">Contractor <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9 position-relative">
                                <input type="text" class="form-control" id="projectContractor" name="projectContractor"
                                    placeholder="Select or enter contractor name" autocomplete="off"
                                    value="{{ old('projectContractor', $project['projectContractor'] ?? '') }}"
                                    oninput="filterAndReorderContractors()" onfocus="filterAndReorderContractors()">

                                <!-- Container for dynamically inserted buttons -->
                                <div id="projectContractorDropdown"
                                    class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                    style="display: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                                </div>
                            </div>
                        </div>


                        

                        <div class="row mb-2 align-items-center">
                            <label for="modeOfImplementation" class="col-3 text-end form-label">Mode of Implementation
                                <span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="modeOfImplementation"
                                    name="modeOfImplementation" value="By contract." readonly>
                            </div>
                        </div>
                        <div class="row mb-2 g-3 text-end">
                            <div class="col-md-3 text-end">
                                <label for="sourceOfFunds" class="form-label">Source of Fund <span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="sourceOfFunds" name="sourceOfFunds"
                                    list="sourceOfFundsList" required>
                                <datalist id="sourceOfFundsList">
                                    @foreach($sourceOfFunds as $fund)
                                        <option value="{{ $fund->sourceOfFunds }}"></option>
                                    @endforeach
                                </datalist>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3 text-end">
                                        <label for="contractDays" class="form-label">Contract Days (Calendar days) <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" id="projectContractDays"
                                            name="projectContractDays" min="0" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 align-items-center">
                            <div class="col-md-12 ">
                                <div class="row align-items-center">
                                    <div class="col-md-3 text-end">
                                        <label for="projectStatus" class="form-label">Status <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 d-flex gap-2">
                                        <select id="projectStatus" name="projectStatus" class="form-select"
                                            onchange="toggleOngoingStatus()" required>
                                            <option value="" disabled selected>Select Status</option>
                                            <option value="Not Started"><i class="fas fa-not-equal"></i>Not Started
                                            </option>
                                            <option value="Ongoing">Ongoing</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Discontinued">Discontinued</option>
                                            <option value="Suspended">Suspended</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden text input for 'Ongoing' -->
                        <div id="ongoingStatusContainer" class="mt-2" style="display: none;">
                            <div class="row">
                                <div class="offset-3 col-md-9">
                                    <label for="ongoingStatus" class="form-label">Please specify percentage
                                        completion </label>

                                    <div class="d-flex gap-2">
                                        <input type="text" id="ongoingStatus" name="ongoingStatus"
                                            class="form-control w-50" placeholder="Enter percentage">
                                        <input type="date" id="ongoingDate" class="form-control w-50">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="mb-2">
                                <label for="projectSlippage" class="form-label">Slippage</label>
                                <input type="number" class="form-control" id="projectSlippage" name="projectSlippage"
                                    placeholder="Enter slippage">
                            </div> -->
                        <div class="row">
                            <!-- Engineer Assigned (E.A) with Datalist -->
                            <div class="col-md-12">
                                <div class="row mb-2">
                                    <label for="ea" class="form-label">Project E.A (Engineer Assigned) <span
                                            class="text-danger">*</span></label>
                                </div>
                                <d class="row mb-2 align-items-center">
                                    <div class="col-3 text-end">
                                        <label for="ea" class="form-label">E.A. Fullname</label>
                                    </div>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="ea" name="ea" list="eaList"
                                            placeholder="Enter E.A. Fullname" required>
                                        <datalist id="eaList">
                                            @foreach($projectEA as $ea)
                                                <option value="{{ $ea->ea }}"></option>
                                            @endforeach
                                        </datalist>
                                    </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-3 text-end">
                                <label for="ea_position" class="form-label">Position</label>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="ea_position" name="ea_position" required>
                            </div>
                            <div class="col-3 text-end">
                                <label for="ea_monthlyRate" class="form-label">Monthly Rate</label>
                            </div>
                            <div class="col-3">
                                <input type="number" class="form-control" id="ea_monthlyRate" name="ea_monthlyRate" required>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Contract Details Section -->
                    <fieldset class="border p-3 mb-4 rounded shadow-sm">
                        <legend class="float-none w-auto px-3 fw-bold text-primary">
                            <i class="fas fa-file-contract me-2"></i>Contract Details
                        </legend>

                        <div class="row g-3 mb-2">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-3 text-end">
                                        <label for="appropriation" class="form-label">Appropriation <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="text" class="form-control currency-input" name="appropriation"
                                                id="appropriation" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-2">
                        <div class="col-3 text-end">
                                <label for="abc" class="form-label">ABC</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="abc" name="abc" required>
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <label for="engineering" class="form-label">Engineering</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="engineering"
                                        name="engineering" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-3 text-end">
                                <label for="contractAmount" class="form-label">Contract Amount</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="contractAmount"
                                        name="contractAmount" required>
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <label for="mqc" class="form-label">MQC</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="mqc" name="mqc" required>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-3 text-end">
                                <label for="bid" class="form-label">Bid Difference</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="bid" name="bid" readonly>
                                </div>
                             </div>
                            <div class="col-3 text-end">
                                <label for="bid" class="form-label">Contingency</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" name="contingency" class="form-control currency-input" id="contingency">
                                </div>
                            </div>
                        </div>
                        


                        <div class="row">
                            <div class="row">
                                <h6 class=" m-1 fw-bold">Notice of Award</h6>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3 text-end">
                                    <label for="noaIssuedDate" class="form-label">Issued Date</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="noaIssuedDate" name="noaIssuedDate" required>
                                </div>
                                <div class="col-3 text-end">
                                    <label for="noaReceivedDate" class="form-label">Received Date</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="noaReceivedDate" name="noaReceivedDate" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="row">
                                    <h6 class=" m-1 fw-bold">Notice to Proceed</h6>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3 text-end">
                                    <label for="ntpIssuedDate" class="form-label">Issued Date</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="ntpIssuedDate" name="ntpIssuedDate">
                                </div>
                                <div class="col-3 text-end">
                                    <label for="ntpReceivedDate" class="form-label">Received Date</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="ntpReceivedDate" name="ntpReceivedDate">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-3 text-end">
                                    <label for="originalStartDate" class="form-label">Official Start</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="originalStartDate" name="originalStartDate">
                                </div>
                                <div class="col-3 text-end">
                                    <label for="targetCompletion" class="form-label">Target Completion Date</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="targetCompletion"
                                        name="targetCompletion">
                                </div>
                            </div>


                            <div class="row mb-2">
                                <div class="col-3 text-end">
                                    <label for="completionDate" class="form-label">Completion Date</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" style="background-color: lightgray;" class="form-control"
                                        id="completionDate" name="completionDate">
                                </div>
                                <div class="col-3 text-end">
                                    <label for="revisedCompletionDate" class="form-label">Revised Completion
                                        Date</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="revisedCompletionDate"
                                        name="revisedCompletionDate">
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <!-- <div class="row">
                            <div class="mb-2">
                                <label for="revisedTargetCompletion" class="form-label">Revised Target
                                    Completion</label>
                                <input type="date" class="form-control" style="background-color: lightgray;"
                                    id="revisedTargetCompletion" name="revisedTargetCompletion">
                            </div> 
                        </div> -->


                    <fieldset class="border p-3 mb-4 rounded shadow-sm">
                        <legend class="float-none w-auto px-3 fw-bold text-primary">
                            <i class="fas fa-info-circle me-2"></i>Implementation Details
                        </legend>

                        <div class="container">
                            <div class="row text-end">
                                <div class="offset-10 col-2 text-center mb-0">
                                    <button type="button" class="btn btn-outline-primary btn-sm mr-1"
                                        onclick="addOrderFields()" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Add Suspension and Resumption Order">
                                        <span class="fa-solid fa-square-plus"></span> </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="removeLastOrderFields()" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Suspension and Resumption Order">
                                        <span class="fa-solid fa-circle-minus"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Order pair container -->
                                <div id="orderContainer" class="col-12">
                                    <div class="row mt-2 mb-2 order-set" id="orderSet1">
                                        <!-- Suspension and Resumption Order Row -->
                                        <div class="row mb-2">
                                            <div class="col-md-6 mb-2">
                                                <label for="suspensionOrderNo1" class="form-label">Suspension Order No. 1</label>
                                                <input type="date" class="form-control" id="suspensionOrderNo1" name="suspensionOrderNo1">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="resumeOrderNo1" class="form-label">Resumption Order No. 1</label>
                                                <input type="date" class="form-control" id="resumeOrderNo1" name="resumeOrderNo1">
                                            </div>
                                        </div>

                                        <!-- Remarks Row -->
                                        <div class="row mb-2">
                                            <div class="col-md-12 mb-2">
                                                <label for="suspensionOrderNo1Remarks" class="form-label">Suspension Remarks</label>
                                                <textarea class="form-control" id="suspensionOrderNo1Remarks" name="suspensionOrderNo1Remarks" rows="2"></textarea>
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Save Project
                        </button>
                    </div>
                </form>
        </div>
    </div>
</div>
</div>
</div>

<script>
    const select = document.getElementById('projectYearSelect');
    const customInput = document.getElementById('customYearInput');
    const currentYear = new Date().getFullYear();

    // Populate 15 years
    for (let i = 0; i < 15; i++) {
        const year = currentYear + i;
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        select.appendChild(option);
    }

    // Add "Other" option
    const otherOption = document.createElement('option');
    otherOption.value = 'other';
    otherOption.textContent = 'Other (Enter manually)';
    select.appendChild(otherOption);

    // Handle selection change
    select.addEventListener('change', function () {
        if (this.value === 'other') {
            customInput.style.display = 'block';
            customInput.required = true;
            select.name = 'projectYearSelect';  // Optional: ignore select on submit
        } else {
            customInput.style.display = 'none';
            customInput.required = false;
            customInput.value = '';
            select.name = 'projectYear';  // Make sure selected value gets submitted
        }
    });
</script>


<script>
    const contractorInput = document.getElementById('projectContractor');
    const dropdown = document.getElementById('projectContractorDropdown');

    // Store contractor names in JavaScript for easier manipulation
    const contractorNames = [
        @foreach($contractors as $contractor)
            "{{ $contractor->name }}",
        @endforeach
    ];

    function filterAndReorderContractors() {
        const inputValue = contractorInput.value.toLowerCase();
        const matches = contractorNames
            .map(name => ({
                name,
                score: name.toLowerCase().startsWith(inputValue) ? 0 : 
                       name.toLowerCase().includes(inputValue) ? 1 : 2
            }))
            .filter(item => item.score < 2)
            .sort((a, b) => a.score - b.score || a.name.localeCompare(b.name));

        dropdown.innerHTML = '';
        matches.forEach(item => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'list-group-item list-group-item-action';
            button.textContent = item.name;
            button.onclick = () => selectContractor(item.name);
            dropdown.appendChild(button);
        });

        dropdown.style.display = matches.length ? 'block' : 'none';
    }

    function selectContractor(name) {
        contractorInput.value = name;
        dropdown.style.display = 'none';
    }

    document.addEventListener('click', function(event) {
        if (!contractorInput.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.style.display = 'none';
        }
    });
</script>

<script>
    
    // Function to allow only numbers and hyphen
    function restrictInput(event) {
        const regex = /^[0-9-]*$/;
        const value = event.target.value;
        if (!regex.test(value)) {
            event.target.value = value.replace(/[^0-9-]/g, ''); // Remove invalid characters
        }
    }

    // Get the input fields
    const projectFPP = document.getElementById('projectFPP');
    const projectRC = document.getElementById('projectRC');

    // Add input event listeners to restrict characters
    projectFPP.addEventListener('input', restrictInput);
    projectRC.addEventListener('input', restrictInput);
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    function parseCurrency(value) {
        return parseFloat((value || '0').replace(/[₱,]/g, '')) || 0;
    }

    function showError(fieldLabel) {
        Swal.fire({
        icon: 'warning',
        title: 'Limit Exceeded',
        text: `${fieldLabel} exceeds the Appropriation!`
        });
    }

    const fieldGroups = [
        { label: 'ABC', ids: ['abc'] },
        { label: 'Contract Amount', ids: ['contractAmount'] },
        { label: 'Engineering', ids: ['engineering'] },
        { label: 'MQC', ids: ['mqc'] },
        { label: 'Contingency', ids: ['contingency'] },
        { label: 'Bid Difference', ids: ['bid'] },
        { label: 'Appropriation', ids: ['appropriation'] } // Note: 'orig_appropriation' is the base limit
    ];

    fieldGroups.forEach(group => {
        group.ids.forEach(id => {
        const input = document.getElementById(id);
        if (input) {
            input.addEventListener('blur', function () {
            const appropriationValue = parseCurrency(document.getElementById('appropriation').value);
            const inputValue = parseCurrency(input.value);

          
            if (inputValue > appropriationValue) {
                console.warn(`✖ ${group.label} [${id}] exceeds appropriation`);
                showError(group.label);
                input.value = '';
            } else {
                console.log(`✔ ${group.label} [${id}] is within limit`);
            }
            });
        }
        });
    });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const projectYear = document.getElementById('projectYear');
        const sourceOfFundsInput = document.getElementById('sourceOfFunds');
        const otherFundContainer = document.getElementById('otherFundContainer');

        function validateSourceOfFunds() {
            const selectedYear = projectYear.value;
            const fundValue = sourceOfFundsInput.value.trim();
            const isOther = fundValue.toLowerCase().includes('other');

            if (!selectedYear) return;

            // Toggle Other Fund input
            otherFundContainer.style.display = isOther ? 'block' : 'none';

            // Validate year prefix
            if (fundValue && !fundValue.startsWith(selectedYear)) {
                sourceOfFundsInput.setCustomValidity(`The Source of Fund must start with "${selectedYear}"`);
                sourceOfFundsInput.reportValidity();
            } else {
                sourceOfFundsInput.setCustomValidity('');
            }
        }

        // Attach validation on input and year change
        sourceOfFundsInput.addEventListener('input', validateSourceOfFunds);
        projectYear.addEventListener('change', validateSourceOfFunds);
    });

    document.addEventListener('DOMContentLoaded', function () {
        const yearSelect = document.getElementById('projectYear');
        const select = document.getElementById('projectYear');
        const currentYear = new Date().getFullYear();
        const startYear = 2015; // Set your desired start year

    for (let year = currentYear; year >= startYear; year--) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
        select.appendChild(option);
    }


        const dateInputs = [
            'noaIssuedDate', 'noaReceivedDate',
            'ntpIssuedDate', 'ntpReceivedDate',
            'originalStartDate', 'targetCompletion',
            'completionDate', 'revisedCompletionDate'
        ];

        // Populate year dropdown (e.g., last 10 years + current)
        const currentYear = new Date().getFullYear();
        for (let i = currentYear; i >= currentYear - 10; i--) {
            const option = document.createElement('option');
            option.value = i;
            option.textContent = i;
            yearSelect.appendChild(option);
        }

        yearSelect.addEventListener('change', function () {
            const selectedYear = this.value;

            if (selectedYear) {
                const minDate = `${selectedYear}-01-01`;
                const maxDate = `${selectedYear}-12-31`;

                dateInputs.forEach(id => {
                    const input = document.getElementById(id);
                    if (input) {
                        input.min = minDate;
                        input.max = maxDate;
                        input.value = ''; // Clear value if out of range
                    }
                });
            }
        });
    });


    function showLocDropdown() {
        const dropdown = document.getElementById('projectLocDropdown');
        if (dropdown) {
            dropdown.style.display = 'block';
        }
    }

    function selectLoc(value) {
        document.getElementById('projectLoc').value = value + ', Nueva Vizcaya';
        document.getElementById('projectLocDropdown').style.display = 'none';
    }

    
    // Hide when clicking outside
    document.addEventListener('click', function (event) {
        const dropdown = document.getElementById('projectLocDropdown');
        const input = document.getElementById('projectLoc');

        if (!dropdown.contains(event.target) && event.target !== input) {
            dropdown.style.display = 'none';
        }
    });

    document.querySelectorAll('.currency-input').forEach(input => {
    input.addEventListener('input', () => {
        let value = input.value;

        // Remove all non-digit and non-dot characters
        value = value.replace(/[^0-9.]/g, '');

        // If more than one dot, keep only the first
        const firstDot = value.indexOf('.');
        if (firstDot !== -1) {
            const beforeDot = value.substring(0, firstDot);
            const afterDot = value.substring(firstDot + 1).replace(/\./g, '');
            value = beforeDot + '.' + afterDot;
        }

        // Split into integer and decimal parts
        let [intPart, decimalPart] = value.split('.');

        // Remove leading zeros, unless input is just "0" or "0.x"
        if (intPart.length > 1 && intPart.startsWith('0')) {
            intPart = intPart.replace(/^0+/, '') || '0';
        }

        // Format integer part with commas
        intPart = intPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

        // Keep up to two decimal digits
        if (decimalPart !== undefined) {
            decimalPart = decimalPart.slice(0, 2);
            input.value = `${intPart}.${decimalPart}`;
        } else {
            input.value = intPart;
        }
    });

});

document.querySelector('form').addEventListener('submit', () => {
    document.querySelectorAll('.currency-input').forEach(input => {
        input.value = input.value.replace(/[^0-9.]/g, '');
    });
});

document.getElementById('projectID').addEventListener('input', function(event) {
        // Replace anything that is not a number or hyphen
        event.target.value = event.target.value.replace(/[^0-9-]/g, '');
    });

document.querySelectorAll('.currency-input').forEach(input => {
    input.addEventListener('blur', () => {
        let value = parseFloat(input.value.replace(/[^0-9.]/g, ''));
        input.value = isNaN(value) ? '' : value.toLocaleString('en-PH', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    });
});


</script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const ongoingStatusInput = document.getElementById('ongoingStatus');

    ongoingStatusInput.addEventListener('blur', function () {
      const value = parseFloat(this.value.trim());

      if (isNaN(value) || value < 1 || value > 100) {
        Swal.fire({
          icon: 'warning',
          title: 'Invalid Percentage',
          text: 'Please enter a value between 1 and 100.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        }).then(() => {
          this.value = '';
          this.focus();
        });
      }
    });
  });
</script>
