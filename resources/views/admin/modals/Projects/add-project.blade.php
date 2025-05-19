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
                    <div class="border p-3 mb-4 rounded shadow-sm">
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
                                        <input type="text" class="form-control" id="projectID" name="projectID"
                                            pattern="^[0-9-]+$" title="Only numbers and hyphens are allowed" required>
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
                                <select class="form-select form-select-sm" id="projectYear" name="projectYear" required>
                                    <option value="" disabled selected>Select Year</option>
                                    <!-- Year options will be injected here by JavaScript -->
                                </select>
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
                                    oninput="filterLocations()" onblur="finalizeLocation()" onfocus="showLocDropdown()" />


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
                                    oninput="filterAndReorderContractors()" onfocus="filterAndReorderContractors()">

                                <!-- Container for dynamically inserted buttons -->
                                <div id="projectContractorDropdown"
                                    class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                    style="display: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                                </div>
                            </div>
                        </div>


                        <!-- <div class="row mb-2 g-3">
                            <div class="col-3 text-end">
                                <label for="projectContractor" class="form-label">Contractor<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col">
                                <select id="projectContractor" name="projectContractor" class="form-select"
                                    onchange="toggleOtherContractor()">
                                    <option value="">--Select Contractor--</option>
                                    @foreach($contractors as $contractor)
                                        <option value="{{ $contractor->name }}" {{ old('projectContractor', $project['projectContractor'] ?? '') == $contractor->name ? 'selected' : '' }}>
                                            {{ $contractor->name }}
                                        </option>
                                    @endforeach
                                    <option value="Others" {{ old('projectContractor', $project['projectContractor'] ?? '') == 'Others' ? 'selected' : '' }}>Others: (Specify)</option>
                                </select>
                            </div>
                            <div class="row mt-2">
                                <div id="othersContractorDiv" style="display: none;">
                                    <div class="row mb-2 g-3">
                                        <div class="col-3 text-end">
                                            <label for="othersContractor" class="form-label">Specify:</label>
                                        </div>
                                        <div class="col-9">
                                            <input type="text" class="form-control" id="othersContractor"
                                                name="othersContractor" placeholder="Enter new contractor name">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- <div class="mb-2">
                                <label for="projectContractor" class="form-label">Contractor <span
                                        class="text-danger">*</span></label>
                                <select id="projectContractor" name="projectContractor" class="form-select">
                                    <option value="">--Select Contractor--</option>
                                    @foreach($contractors as $contractor)
                                        <option value="{{ $contractor->name }}">{{ $contractor->name }}</option>
                                    @endforeach
                                    <option value="Others">Others: (Specify)</option>
                                </select>
                        </div> -->





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
                                <div id="otherFundContainer" class="mt-2" style="display: none;">
                                    <label for="otherFund" class="form-label">Please specify:</label>
                                    <input type="text" id="otherFund" name="otherFund" class="form-control"
                                        placeholder="Enter fund source">
                                </div>
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
                        <div id="ongoingStatusContainer" class="mt-2 mb-2" style="display: none;">
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
                                    <div class="col-3 text-end">
                                        <label for="ea" class="form-label">Project Engineer <span
                                                    class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="ea" name="ea" list="eaList"
                                            placeholder="Enter Engineer Assigned">
                                        <datalist id="eaList">
                                            @foreach($projectEA as $ea)
                                                <option value="{{ $ea->ea }}"></option>
                                            @endforeach
                                        </datalist>
                                    </div>

                                    <div class="col-1 text-end">
                                        <label for="ea_position" class="form-label">Position<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-4">
                                        <select class="form-select" id="ea_position" name="ea_position" required>
                                            <option value="" disabled selected>Select Position</option>
                                            <option value="Engineer Aid">Engineer Aid</option>
                                            <option value="Engineer Assistant">Engineer Assistant</option>
                                            <option value="Engineer I">Engineer I</option>
                                        </select>
                                    </div>
                            <!-- <div class="col-3 text-end">
                                <label for="ea_monthlyRate" class="form-label">Monthly Rate<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="ea_monthlyRate" name="ea_monthlyRate">
                                </div>
                            </div> -->
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
                                <label for="contractAmount" class="form-label">Contract Amount</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="contractAmount"
                                        name="contractAmount">
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <label for="engineering" class="form-label">Engineering</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="engineering"
                                        name="engineering">
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
                                    <input type="text" class="form-control currency-input" id="abc" name="abc">
                                </div>
                            </div>

                            <div class="col-3 text-end">
                                <label for="mqc" class="form-label">MQC</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="mqc" name="mqc">
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
                                    <input type="text" class="form-control currency-input" id="bid" name="bid">
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <label for="bid" class="form-label">Contingency</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" name="contingency" class="form-control currency-input"
                                        id="contingency">
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
                                    <input type="date" class="form-control" id="noaIssuedDate" name="noaIssuedDate">
                                </div>
                                <div class="col-3 text-end">
                                    <label for="noaReceivedDate" class="form-label">Received Date</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="noaReceivedDate" name="noaReceivedDate">
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
                            <!-- <div class="row mb-2">
                                <div class="col-3 text-end">
                                    <label for="originalStartDate" class="form-label">Official Start<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="originalStartDate" name="originalStartDate">
                                </div>
                                <div class="col-3 text-end">
                                    <label for="targetCompletion" class="form-label">Target Completion Date<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="targetCompletion"
                                        name="targetCompletion">
                                </div>
                            </div> -->


                            <!-- <div class="row mb-2">
                                <div class="col-3 text-end">
                                    <label for="completionDate" class="form-label">Completion Date<span
                                            class="text-danger">*</span>
                                    </label>
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
                            </div> -->
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

                    <!-- Implementation Details -->
                    <div class="border p-3 mb-4 rounded shadow-sm">
                        <legend class="float-none w-auto px-3 fw-bold text-primary">
                            <i class="fas fa-info-circle me-2"></i>Implementation Details
                        </legend>

                        <div class="container">
                            <div class="row mb-2 align-items-center">
                                <label for="modeOfImplementation" class="col-3 text-end form-label">Mode of Implementation
                                    <span class="text-danger">*</span></label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="modeOfImplementation"
                                        name="modeOfImplementation" value="By contract." readonly required>
                                </div>
                            </div>
                            <!-- Bagong add -->
                            <div class="row mb-2 align-items-center">
                                <div class="col-3 text-end">
                                    <label for="" class="form-label">Original Starting Date
                                    <span class="text-danger">*</span></label>
                                </div>                        
                                <div class="col-3">
                                    <input type="date" class="form-control" id="originalStartDate" name="originalStartDate">
                                </div>
                                <div class="col-3 mb-2 text-end">
                                    <label for="" class="form-label">Target Completion Date
                                        <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-3">
                                        <input type="date" class="form-control" id="targetCompletion"
                                        name="targetCompletion">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-3 mb-2 text-end">
                                    <label for="" class="form-label">Actual Date of Completion
                                        <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-9">
                                    <input type="date" style="background-color: lightgray;" class="form-control"
                                        id="completionDate" name="completionDate">
                                </div>
                            </div>

                            <div class="row">
                                <!-- Order pair container -->
                                <div id="orderContainer" class="col-12 ">
                                    <div class="row mt-2 mb-2 order-set" id="orderSet1">
                                        <!-- Suspension and Resumption Order Row -->
                                        <div class="row mb-2">
                                            <div class="col-3 text-end">
                                                <label for="suspensionOrderNo1" class="form-label">Suspension Order No.1
                                                <span class="text-danger">*</span></label>
                                            </div>                        
                                            <div class="col-3">
                                                <input type="date" class="form-control" id="suspensionOrderNo1" name="suspensionOrderNo1">
                                            </div>
                                            <div class="col-3 mb-2 text-end">
                                                <label for="resumeOrderNo1" class="form-label">Resumption Order No.1
                                                    <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-3">
                                                    <input type="date" class="form-control" id="resumeOrderNo1"
                                                    name="resumeOrderNo1">
                                            </div>
                                             <!-- Remarks Row -->
                                            <div class="row mt-1 mb-2">
                                                <div class="col-md-3 mb-3 text-end">
                                                    <label for="suspensionOrderNo1Remarks" class="form-label">Suspension
                                                        Remarks</label>
                                                </div>
                                                <div class="col-9">
                                                    <textarea class="form-control" id="suspensionOrderNo1Remarks"
                                                        name="suspensionOrderNo1Remarks" rows="2"></textarea>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="row text-end">
                                <div class="col-md-10">
                                    <hr>
                                </div>
                                <div class="col-2 text-center mb-2">
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
                            <div class="row mb-2">
                                <div class="col-3 text-end">
                                    <label for="revisedTargetDate" class="form-label">Revised Target Date
                                    <span class="text-danger">*</span></label>
                                </div>                        
                                <div class="col-3">
                                    <input type="date" class="form-control" id="revisedTargetDate"
                                        name="revisedTargetDate">
                                </div>
                                <div class="col-3 text-end">
                                    <label for="revisedCompletionDate" class="form-label">Revised Completion Date
                                    <span class="text-danger">*</span></label>
                                </div>                        
                                <div class="col-3">
                                    <input type="date" class="form-control" id="revisedCompletionDate"
                                        name="revisedCompletionDate">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3 text-end">
                                    <label for="timeExtension" class="form-label">Extension Date
                                    <span class="text-danger">*</span></label>
                                </div>                        
                                <div class="col-3">
                                    <input type="number" class="form-control" id="timeExtension"
                                        name="timeExtension">
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
document.addEventListener('DOMContentLoaded', function () {
    const projectYear = document.getElementById('projectYear');
    const sourceOfFundsInput = document.getElementById('sourceOfFunds');
    const otherFundContainer = document.getElementById('otherFundContainer');
    const dateInputs = [
        'noaIssuedDate', 'noaReceivedDate',
        'ntpIssuedDate', 'ntpReceivedDate',
        'officialStart'
    ];

    // Populate Year Dropdown
    if (projectYear) {
        const currentYear = new Date().getFullYear();
        for (let year = currentYear; year >= 2015; year--) {
            const option = document.createElement('option');
            option.value = year;
            option.textContent = year;
            projectYear.appendChild(option);
        }
    }

    // Validate Source of Funds
    function validateSourceOfFunds() {
        const selectedYear = projectYear.value;
        const fundValue = sourceOfFundsInput.value.trim();
        const isOther = fundValue.toLowerCase().includes('other');

        if (!selectedYear) return;

        // Show/hide other fund input
        otherFundContainer.style.display = isOther ? 'block' : 'none';

        // Validate year prefix
        // if (fundValue && !fundValue.startsWith(selectedYear)) {
        //     sourceOfFundsInput.setCustomValidity(`The Source of Fund must start with "${selectedYear}"`);
        //     sourceOfFundsInput.reportValidity();
        // } else {
        //     sourceOfFundsInput.setCustomValidity('');
        // }
    }

    // Update Date Inputs on Year Change
    projectYear.addEventListener('change', function () {
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

    sourceOfFundsInput.addEventListener('input', validateSourceOfFunds);
    projectYear.addEventListener('change', validateSourceOfFunds);
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
    if (projectFPP) projectFPP.addEventListener('input', restrictInput);
    if (projectRC) projectRC.addEventListener('input', restrictInput);

    // ========= Currency Formatting ========= //
function setupCurrencyInputs() {
    const inputs = document.querySelectorAll('.currency-input');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.value = parseCurrency(input.value) || '';
        });

        input.addEventListener('blur', () => {
            if (input.id !== 'bid') {
                const val = parseCurrency(input.value);
                input.value = val ? formatCurrency(val) : '';
            }
            updateBidDifference();
        });

        input.addEventListener('input', () => {
            let value = input.value.replace(/[^0-9.]/g, '');
            let parts = value.split('.');
            let intPart = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            let decimalPart = parts[1] ? '.' + parts[1].slice(0, 2) : '';
            input.value = intPart + decimalPart;
        });

        if (input.value.trim() !== '') input.dispatchEvent(new Event('blur'));
    });

    document.querySelector('form')?.addEventListener('submit', () => {
        inputs.forEach(input => input.value = parseCurrency(input.value));
    });
}

// ========= Input Restriction ========= //
document.getElementById('projectID')?.addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/[^0-9-]/g, '');
});

// ========= Bid Difference ========= //
function updateBidDifference() {
    const abc = parseCurrency(document.getElementById('abc')?.value);
    const contract = parseCurrency(document.getElementById('contractAmount')?.value);
    const bidInput = document.getElementById('bid');
    if (!isNaN(abc) && !isNaN(contract)) {
        bidInput.value = formatCurrency(abc - contract);
    }
}


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

    function filterLocations() {
    const input = document.getElementById('projectLoc');
    const dropdown = document.getElementById('projectLocDropdown');
    const buttons = dropdown.getElementsByTagName('button');

    // Remove existing ", Nueva Vizcaya" before filtering
    const filter = input.value.toLowerCase().replace(/,\s*nueva\s*vizcaya\s*$/i, '').trim();

    let anyVisible = false;

    for (let i = 0; i < buttons.length; i++) {
        const txt = buttons[i].textContent || buttons[i].innerText;
        if (txt.toLowerCase().includes(filter)) {

            buttons[i].style.display = '';
            anyVisible = true;
        } else {
            buttons[i].style.display = 'none';
        }
    }

    dropdown.style.display = anyVisible ? 'block' : 'none';
}

function finalizeLocation() {
    const input = document.getElementById('projectLoc');
    let value = input.value.trim();

    // Remove any existing ", Nueva Vizcaya"
    value = value.replace(/,\s*nueva\s*vizcaya\s*$/i, '');

    if (value !== '') {
        input.value = value + ', Nueva Vizcaya';
    }
}

function selectLoc(value) {
    const input = document.getElementById('projectLoc');
    input.value = value + ', Nueva Vizcaya';
    document.getElementById('projectLocDropdown').style.display = 'none';
}

function showLocDropdown() {
    const dropdown = document.getElementById('projectLocDropdown');
    const buttons = dropdown.getElementsByTagName('button');

    for (let i = 0; i < buttons.length; i++) {
        buttons[i].style.display = '';
    }

    dropdown.style.display = 'block';
}

// Optional: hide dropdown if clicked outside
document.addEventListener('click', function (e) {
    const input = document.getElementById('projectLoc');
    const dropdown = document.getElementById('projectLocDropdown');
    if (!input.contains(e.target) && !dropdown.contains(e.target)) {
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

</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const originalStartDate = document.getElementById("originalStartDate");
    const suspensionDate = document.getElementById("suspensionOrderNo1");
    const resumeDate = document.getElementById("resumeOrderNo1");
    const targetCompletion = document.getElementById("targetCompletion");
    const actualCompletion = document.getElementById("completionDate");
    const revisedTargetField = document.getElementById("revisedTargetDate");
    const revisedCompletionField = document.getElementById("revisedCompletionDate");
    const extensionField = document.getElementById("timeExtension");

    const ntpIssuedDate = document.getElementById("ntpIssuedDate");
    const ntpReceivedDate = document.getElementById("ntpReceivedDate");

    // Hide optional rows initially
    extensionField.closest('.row').style.display = "none";
    revisedTargetField.closest('.row').style.display = "none";
    revisedCompletionField.closest('.row').style.display = "none";

    function showError(message, field) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Date',
            text: message
        }).then(() => {
            if (field) {
                field.value = '';
                field.focus();
            }
        });
    }

    function setMinDates() {
        const start = originalStartDate.value;
        if (start) {
            const nextDay = new Date(start);
            nextDay.setDate(nextDay.getDate() + 1);
            const minDate = nextDay.toISOString().split("T")[0];

            suspensionDate.min = minDate;
            resumeDate.min = minDate;
            targetCompletion.min = minDate;
            actualCompletion.min = minDate;
            revisedTargetField.min = minDate;
            revisedCompletionField.min = minDate;
        }
    }

    function validateAfterStart(field, label) {
        const startDate = new Date(originalStartDate.value);
        const date = new Date(field.value);
        if (field.value && (date <= startDate)) {
            showError(`${label} must be strictly after the Official Starting Date.`, field);
            return false;
        }
        return true;
    }

    function validateOriginalStartVsNTP() {
        const ntpDate = new Date(ntpIssuedDate.value);
        const startDate = new Date(originalStartDate.value);
        if (originalStartDate.value && ntpIssuedDate.value && startDate < ntpDate) {
            showError("Original Starting Date must be on or after the NTP Issued Date.", originalStartDate);
            return false;
        }
        return true;
    }

    function validateSuspensionAndResumption() {
        const suspend = new Date(suspensionDate.value);
        const resume = new Date(resumeDate.value);

        if (suspensionDate.value && !validateAfterStart(suspensionDate, "Suspension Date")) return;
        if (resumeDate.value && !validateAfterStart(resumeDate, "Resumption Date")) return;

        if (suspensionDate.value && resumeDate.value && resume <= suspend) {
            showError("Resumption Date must be after Suspension Date.", resumeDate);
            return;
        }

        if (suspensionDate.value && resumeDate.value) {
            const extensionDays = Math.max(0, Math.floor((resume - suspend) / (1000 * 60 * 60 * 24)) - 1);

            extensionField.closest('.row').style.display = "flex";
            revisedTargetField.closest('.row').style.display = "flex";
            revisedCompletionField.closest('.row').style.display = "flex";
            extensionField.value = extensionDays;

            if (targetCompletion.value) {
                let newTarget = new Date(targetCompletion.value);
                newTarget.setDate(newTarget.getDate() + extensionDays);
                revisedTargetField.valueAsDate = newTarget;
            }

            if (actualCompletion.value) {
                let newActual = new Date(actualCompletion.value);
                newActual.setDate(newActual.getDate() + extensionDays);
                revisedCompletionField.valueAsDate = newActual;
            }
        }
    }

    originalStartDate.addEventListener("change", () => {
        if (!validateOriginalStartVsNTP()) return;
        setMinDates();
        suspensionDate.value = '';
        resumeDate.value = '';
        targetCompletion.value = '';
        actualCompletion.value = '';
        revisedTargetField.value = '';
        revisedCompletionField.value = '';
    });

    ntpIssuedDate.addEventListener("change", () => {
        validateOriginalStartVsNTP();
    });

    suspensionDate.addEventListener("change", () => {
        validateSuspensionAndResumption();
    });

    resumeDate.addEventListener("change", () => {
        validateSuspensionAndResumption();
    });

    targetCompletion.addEventListener("change", () => {
        validateAfterStart(targetCompletion, "Target Completion Date");
    });

    actualCompletion.addEventListener("change", () => {
        validateAfterStart(actualCompletion, "Actual Completion Date");
    });

    revisedTargetField.addEventListener("change", () => {
        validateAfterStart(revisedTargetField, "Revised Target Date");
    });

    revisedCompletionField.addEventListener("change", () => {
        validateAfterStart(revisedCompletionField, "Revised Completion Date");
    });
});
</script>
