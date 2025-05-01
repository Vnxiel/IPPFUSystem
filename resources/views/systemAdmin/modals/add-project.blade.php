<!-- Add Project Modal -->
<div class="modal fade" id="addNewProjectModal" tabindex="-1" aria-labelledby="addNewProjectLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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

                        <!-- Project Title & ID Section -->
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-floating mb-2">
                                    <textarea class="form-control" id="projectTitle" name="projectTitle"
                                        style="height: 80px" required></textarea>
                                    <label for="projectTitle">Project Title<span
                                    class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="projectID" name="projectID" required>
                                    <label for="projectID">Project ID<span
                                    class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>

                        <!-- Project Description -->
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-floating mb-2">
                                    <textarea class="form-control" id="projectDescription" name="projectDescription"
                                        style="height: 100px"></textarea>
                                    <label for="projectDescription">Project Description <span
                                            class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-floating mb-2 position-relative">
                                    <input type="text" class="form-control" id="projectLoc" name="projectLoc" required
                                        onkeyup="filterSuggestions(this.value)" autocomplete="off">
                                    <label for="projectLoc">Location <span class="text-danger">*</span></label>

                                    <div id="suggestionsBoxs" class="list-group position-absolute w-100 shadow"
                                        style="display:none; max-height: 200px; overflow-y: auto; z-index: 1050;">
                                        @foreach($locations as $location)
                                            <button type="button"
                                                class="list-group-item list-group-item-action suggestion-items">
                                                {{ $location->location }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Location & Details Section -->
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="projectContractor" class="form-label">Contractor <span
                                            class="text-danger">*</span></label>
                                    <select id="projectContractor" name="projectContractor" class="form-select">
                                        <option value="">--Select Contractor--</option>
                                        @foreach($contractors as $contractor)
                                            <option value="{{ $contractor->name }}">{{ $contractor->name }}</option>
                                        @endforeach
                                        <option value="Others">Others: (Specify)</option>
                                    </select>
                                </div>

                                <!-- Hidden textbox for specifying 'Others' -->
                                <div class="mb-2" id="othersContractorDiv" style="display: none;">
                                    <label for="othersContractor" class="form-label">Specify New Contractor</label>
                                    <input type="text" class="form-control" id="othersContractor"
                                        name="othersContractor" placeholder="Enter new contractor name">
                                </div>

                                <div class="mb-2">
                                    <label for="modeOfImplementation" class="form-label">Mode of Implementation <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="modeOfImplementation"
                                        name="modeOfImplementation" placeholder="Enter mode of implementation."
                                        value="By contract." readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="sourceOfFunds" class="form-label">Source of Fund <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="sourceOfFunds" name="sourceOfFunds"
                                        placeholder="Enter source of funds.">
                                    <!-- <label for="sourceOfFunds" class="form-label">Source of Fund <span
                                            class="text-danger">*</span></label>
                                    <select id="sourceOfFunds" name="sourceOfFunds" class="form-select"
                                        onchange="toggleOtherFund()">
                                        <option value="">Select Source</option>
                                        <option value="Wages">Wages</option>
                                        <option value="% Mobilization">15% Mobilization</option>
                                        <option value="Trust Fund">Trust Fund</option>
                                        <option value="Final Billing">Final Billing</option>
                                        <option value="Others">Others</option>
                                    </select> -->

                                    <!-- Hidden text input for 'Others' -->
                                    <div id="otherFundContainer" class="mt-2" style="display: none;">
                                        <label for="otherFund" class="form-label">Please specify:</label>
                                        <input type="text" id="otherFund" name="otherFund" class="form-control"
                                            placeholder="Enter fund source">
                                    </div>
                                </div>

                                <div class="mb-2">
                                    <label for="projectStatus" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select id="projectStatus" name="projectStatus" class="form-select"
                                        onchange="toggleOngoingStatus()">
                                        <option value="">Select Status</option>
                                        <option value="Started">Started</option>
                                        <option value="Ongoing">Ongoing</option>
                                        <option value="Completed">Completed</option>
                                        <option value="Discontinued">Discontinued</option>
                                        <option value="Suspended">Suspended</option>
                                    </select>

                                    <!-- Hidden text input for 'Ongoing' -->
                                    <div id="ongoingStatusContainer" class="mt-2" style="display: none;">
                                        <label for="ongoingStatus" class="form-label">Please specify percentage
                                            completion:</label>

                                        <div class="d-flex gap-2">
                                            <input type="text" id="ongoingStatus" name="ongoingStatus"
                                                class="form-control w-50" placeholder="Enter percentage">
                                            <input type="date" id="ongoingDate" class="form-control w-50">
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="mb-2">
                                    <label for="projectSlippage" class="form-label">Slippage</label>
                                    <input type="number" class="form-control" id="projectSlippage"
                                        name="projectSlippage" placeholder="Enter slippage">
                                </div> -->
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label for="ea" class="form-label">Project E.A (Engineer Assigned) <span
                                        class="text-danger">*</span></label>
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="ea" name="ea">
                                    <label for="ea">Fullname</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-2">
                                    <input type="text" class="form-control" id="ea_position" name="ea_position">
                                    <label for="ea_position">Position</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-2">
                                    <input type="number" class="form-control" id="ea_monthlyRate" name="ea_monthlyRate">
                                    <label for="ea_monthlyRate">Monthly Rate</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <!-- Contract Details Section -->
                    <fieldset class="border p-3 mb-4 rounded shadow-sm">
                        <legend class="float-none w-auto px-3 fw-bold text-primary">
                            <i class="fas fa-file-contract me-2"></i>Contract Details
                        </legend>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="mb-2">
                                        <label for="appropriation" class="form-label">Appropriation <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control currency-input" id="appropriation"
                                            name="appropriation">
                                    </div>
                                    <div class="mb-2">
                                    <label for="abc" class="form-label">ABC</label>
                                    <input type="text" class="form-control currency-input" id="abc" name="abc">
                                </div>
                                <div class="mb-2">
                                    <label for="contractAmount" class="form-label">Contract Amount</label>
                                    <input type="text" class="form-control currency-input" id="contractAmount"
                                        name="contractAmount">
                                </div>
                                <div class="mb-2">
                                    <label for="bid" class="form-label">Bid Difference</label>
                                    <input type="text" class="form-control currency-input" id="bid" name="bid">
                                </div>
                                <div class="mb-2">
                                        <label for="projectContractDays" class="form-label">Contract Days(Calendar
                                            days)</label>
                                        <input type="number" class="form-control" id="projectContractDays"
                                            name="projectContractDays" min="0">
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="mb-2">
                                        <label for="contractCost" class="form-label">Contract Cost <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control currency-input" id="contractCost"
                                            name="contractCost">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-2">
                                        <label for="revisedContractCost" class="form-label">Revised Contract
                                            Cost</label>
                                        <input type="text" class="form-control currency-input" id="revisedContractCost"
                                            name="revisedConstractCost" min="0">
                                    </div>
                                </div> -->
                            </div>

                            <div class="col-md-6">
                            <h6 class=" m-1 fw-bold">Wages:</h6>
                                <div class="row">
                                    <div class="mb-2">
                                        <label for="engineering" class="form-label">Engineering</label>
                                        <input type="text" class="form-control currency-input" id="engineering"
                                            name="engineering">
                                    </div>
                                    <div class="mb-2">
                                        <label for="mqc" class="form-label">MQC</label>
                                        <input type="text" class="form-control currency-input" id="mqc" name="mqc">
                                    </div>
                                    <div class="mb-2">
                                        <label for="bid" class="form-label">Contingency</label>
                                        <input type="text" class="form-control currency-input" id="contingency" name="contingency">
                                    </div>
                                </div>
                                <div class="row">
                                  
                                </div>
                                

                            </div>
                        </div>
                        <div class="row">
                            <div class="row">
                                <h6 class=" m-1 fw-bold">Notice of Award</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                               
                                    <div class="mb-2">
                                        <label for="noaIssuedDate" class="form-label">Issued Date</label>
                                        <input type="date" class="form-control" id="noaIssuedDate" name="noaIssuedDate">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="noaReceivedDate" class="form-label">Received Date</label>
                                        <input type="date" class="form-control" id="noaReceivedDate"
                                            name="noaReceivedDate">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <h6 class=" m-1 fw-bold">Notice to Proceed</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                               
                                    <div class="mb-2">
                                        <label for="ntpIssuedDate" class="form-label">Issued Date</label>
                                        <input type="date" class="form-control" id="ntpIssuedDate" name="ntpIssuedDate">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="ntpReceivedDate" class="form-label">Received Date</label>
                                        <input type="date" class="form-control" id="ntpReceivedDate"
                                            name="ntpReceivedDate">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                        <label for="officialStart" class="form-label">Official Start</label>
                                        <input type="date" class="form-control" id="officialStart" name="officialStart">
                                 </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="targetCompletion" class="form-label">Target Completion Date</label>
                                    <input type="date" class="form-control" id="targetCompletion"
                                        name="targetCompletion">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="completionDate" class="form-label">Completion Date</label>
                                    <input type="date" style="background-color: lightgray;" class="form-control"
                                        id="completionDate" name="completionDate">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                            <div class="mb-2">
                                <label for="revisedCompletionDate" class="form-label">Revised Completion Date</label>
                                <input type="date" class="form-control" id="revisedCompletionDate" name="revisedCompletionDate">
                                </div>
                            </div>
                           
                            
                            </div>
                        <!-- <div class="row">
                            <div class="mb-2">
                                <label for="revisedTargetCompletion" class="form-label">Revised Target
                                    Completion</label>
                                <input type="date" class="form-control" style="background-color: lightgray;"
                                    id="revisedTargetCompletion" name="revisedTargetCompletion">
                            </div> 
                        </div> -->
                    </fieldset>


                    <fieldset class="border p-3 mb-4 rounded shadow-sm">
                        <legend class="float-none w-auto px-3 fw-bold text-primary">
                            <i class="fas fa-info-circle me-2"></i>Implementation Details
                        </legend>

                        <div class="container">
                            <div class="row align-items-center">
                                <!-- Buttons above the order fields -->
                                <div class="col-md-10">
                                    <hr>
                                </div>
                                <div class="col-2 text-center mb-0">
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

                                <!-- Order pair container -->
                                <div id="orderContainer" class="col-12">
                                    <div class="row mb-2 order-set" id="orderSet1">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label for="suspensionOrderNo1" class="form-label">Suspension Order No.
                                                    1</label>
                                                <input type="date" class="form-control" id="suspensionOrderNo1"
                                                    name="suspensionOrderNo1">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="suspensionOrderNo1" class="form-label">Remarks</label>
                                                <input type="text" class="form-control" id="resumeOrderNo1Remarks"
                                                    name="suspensionOrderNo1Remarks">
                                            </div>                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label for="resumeOrderNo1" class="form-label">Resumption Order No.
                                                    1</label>
                                                <input type="date" class="form-control" id="resumeOrderNo1"
                                                    name="resumeOrderNo1">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="resumeOrderNo1" class="form-label">Remarks</label>
                                                <input type="text" class="form-control" id="resumeOrderNo1Remarks"
                                                    name="resumeOrderNo1Remarks">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="timeExtension" class="form-label">Time Extension</label>
                                    <input type="text" class="form-control" id="timeExtension" name="timeExtension" value="">
                                </div>  
                            </div> 
                        </div>
                    </fieldset>
            </div>

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
