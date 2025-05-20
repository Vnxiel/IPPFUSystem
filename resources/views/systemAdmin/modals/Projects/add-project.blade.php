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
                                         title="Only numbers and hyphens are allowed" required>
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

                        <div class="row mb-2 g-3 text-end">
                            <div class="col-md-3 text-end">
                                <label for="sourceOfFunds" class="form-label">Source of Fund <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9 position-relative">
                                <input type="text" class="form-control" id="sourceOfFunds" name="sourceOfFunds"
                                    placeholder="Select or enter source" autocomplete="off"
                                    oninput="filterFunds()" onfocus="showFundsDropdown()" onblur="hideFundsDropdownDelayed()" required>

                                <div id="sourceOfFundsDropdown"
                                    class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                    style="display: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                                    @foreach($sourceOfFunds as $fund)
                                        <button type="button" class="list-group-item list-group-item-action"
                                                onclick="selectFund('{{ $fund->sourceOfFunds }}')">
                                            {{ $fund->sourceOfFunds }}
                                        </button>
                                    @endforeach
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
                        <div class="row mb-2">
                            <!-- Engineer project slippage -->
                            <div class="col-3 text-end">
                                <label for="projectSlippage" class="form-label">Project Slippage</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" id="projectSlippage" name="projectSlippage"
                                    placeholder="Enter project slippage">
                            </div>
                        </div>
                      
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
                                <label for="abc" class="form-label">ABC</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="abc" name="abc">
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
                                    <label for="timeExtension" class="form-label">Extension Date
                                    <span class="text-danger">*</span></label>
                                </div>                        
                                <div class="col-9">
                                    <input type="number" class="form-control" id="timeExtension"
                                        name="timeExtension">
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
                                <div class="col-3 mb-2 text-end">
                                    <label for="" class="form-label">Actual Date of Completion
                                        <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-9">
                                    <input type="date" style="background-color: lightgray;" class="form-control"
                                        id="completionDate" name="completionDate">
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

<script id="contractor-data" type="application/json">
    {!! json_encode($contractors->pluck('name')) !!}
</script>
