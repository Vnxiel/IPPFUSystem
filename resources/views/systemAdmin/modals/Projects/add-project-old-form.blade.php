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
                                        <div class="col-3 ">
                                            <label for="title" class="form-label">Project Title <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col">
                                            <textarea class="form-control" id="title" name="title" rows="3"
                                                required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mb-2">
                                <div class="col-md-12  mb-2">
                                    <div class="row">
                                        <div class="col-3 ">
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
                            <div class="row g-3 mb-2 ">
                                <div class="col-md-3 ">
                                    <label for="year" class="form-label">Year <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select form-select-sm" id="year" name="year" required>
                                        <option value="" disabled selected>Select Year</option>
                                        <!-- Year options will be injected here by JavaScript -->
                                    </select>
                                </div>

                                <div class="col-md-2 ">
                                    <label for="fpp" class="form-label">FPP <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="fpp" name="fpp" required>
                                </div>
                            </div>
                            <div class="row mb-2 g-3 ">
                                <div class="col-md-3 ">
                                    <label for="responsibility_center" class="form-label">Responsibility Center<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="responsibility_center" name="responsibility_center" required>
                                </div>
                            </div>
                            <div class="row g-3 mb-2 ">
                                <div class="col-md-3">
                                    <label for="location" class="form-label">Location
                                        <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-md-9 position-relative">
                                <input type="text" class="form-control" id="location" name="location"
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
                                <div class="col-3 ">
                                    <label for="projectDescription" class="form-label">Project Description<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col">
                                    <textarea class="form-control" id="projectDescription" name="projectDescription"
                                        rows="4" required></textarea>
                                </div>
                            </div>

                            <!-- Contractor Input with Dynamic Suggestions -->
                            <div class="row g-3 mb-2 ">
                                <div class="col-md-3">
                                    <label for="firm_name" class="form-label">Contractor <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="firm_name" name="firm_name"
                                        placeholder="Select or enter contractor name" autocomplete="off"
                                        oninput="filterAndReorderContractors()" onfocus="filterAndReorderContractors()">

                                    <!-- Container for dynamically inserted buttons -->
                                    <div id="projectContractorDropdown"
                                        class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                        style="dis  play: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2 g-3 ">
                                <div class="col-md-3 ">
                                    <label for="source_of_funds" class="form-label">Source of Fund <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="source_of_funds" name="source_of_funds"
                                        placeholder="Select or enter source" autocomplete="off"
                                        oninput="filterFunds()" onfocus="showFundsDropdown()" onblur="hideFundsDropdownDelayed()" required>

                                    <div id="sourceOfFundsDropdown"
                                        class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                        style="display: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                                        @foreach($source_of_funds as $fund)
                                        <button type="button" class="list-group-item list-group-item-action"
                                                onclick="selectFund('{{ trim($fund->source_of_funds) }}')">
                                            {{ trim($fund->source_of_funds) }}
                                        </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-2 align-items-center">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-3 ">
                                            <label for="contractDays" class="form-label">Contract Days (Calendar days) <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9">
                                            <input type="number" class="form-control" id="contract_days"
                                                name="contract_days" min="0" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-12 ">
                                    <div class="row align-items-center">
                                        <div class="col-md-3 ">
                                            <label for="physical_status" class="form-label">Status <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9 d-flex gap-2">
                                            <select id="physical_status" name="physical_status" class="form-select"
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
                                        <label for="ongoing_status" class="form-label">Please specify percentage
                                            completion </label>

                                        <div class="d-flex gap-2">
                                            <input type="text" id="ongoing_status" name="ongoing_status"
                                                class="form-control w-50" placeholder="Enter percentage">
                                            <input type="date" id="ongoingDate" class="form-control w-50">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <!-- Engineer project slippage -->
                                <div class="col-3 ">
                                    <label for="project_slippage" class="form-label">Project Slippage</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="project_slippage" name="project_slippage"
                                        placeholder="Enter project slippage">
                                </div>
                            </div>
                            
                        
                            <div class="row">
                                <div class="col-md-3 ">
                                    <label for="engineer_name" class="form-label">Project Engineer <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-4 position-relative">
                                    <input type="text" class="form-control" id="engineer_name" name="engineer_name"
                                    placeholder="Select or enter engineer name" autocomplete="off">
                                    <div id="projectEngineerDropdown"
                                        class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                        style="display: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                                    </div>
                                </div>
                                <div class="col-1 ">
                                    <label for="engineer_position" class="form-label">Position<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-4">
                                    <select class="form-select" id="engineer_position" name="engineer_position" required>
                                        <option value="" disabled selected>Select Position</option>
                                        <option value="Engineer Aid">Engineer Aid</option>
                                        <option value="Engineer Assistant">Engineer Assistant</option>
                                        <option value="Engineer I">Engineer I</option>
                                    </select>
                                </div>
                                <!-- <div class="col-3 ">
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
                                        <div class="col-3 ">
                                            <label for="appropriation" class="form-label">Appropriation <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col">                                        
                                                <input type="text" class="form-control currency-input" name="appropriation"
                                                    id="appropriation" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3 ">
                                    <label for="abc" class="form-label">ABC</label>
                                </div>
                                <div class="col-3">
                                        <input type="text" class="form-control currency-input" id="abc" name="abc">
                                </div>
                            
                                <div class="col-3 ">
                                    <label for="engineering" class="form-label">Engineering</label>
                                </div>
                                <div class="col-3">
                                        <input type="text" class="form-control currency-input" id="engineering"
                                            name="engineering">
                                </div>
                            </div>

                            <div class="row mb-2">
                            
                                <div class="col-3 ">
                                    <label for="orig_contract_amount" class="form-label">Contract Amount</label>
                                </div>
                                <div class="col-3">
                                        <input type="text" class="form-control currency-input" id="orig_contract_amount"
                                            name="orig_contract_amount">
                                </div>
                                <div class="col-3 ">
                                    <label for="mqc" class="form-label">MQC</label>
                                </div>
                                <div class="col-3">
                                        <input type="text" class="form-control currency-input" id="mqc" name="mqc">
                                </div>
                            </div>
                            <!-- Savings = Bid Difference -->
                            <div class="row mb-2">
                                <div class="col-3 ">
                                    <label for="bid" class="form-label">Savings</label>
                                </div>
                                <div class="col-3">
                                        <input type="text" class="form-control currency-input" id="bid" name="bid">
                                </div>

                                <div class="col-3 ">
                                    <label for="bid" class="form-label">Contingency</label>
                                </div>
                                <div class="col-3">
                                        <input type="text" name="contingency" class="form-control currency-input"
                                            id="contingency">
                                </div>
                            </div>



                            <div class="row">
                                <div class="row">
                                    <h6 class=" m-1 fw-bold">Notice of Award</h6>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3 ">
                                        <label for="noa_issued_date" class="form-label">Issued Date</label>
                                    </div>
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="noa_issued_date" name="noa_issued_date">
                                    </div>
                                    <div class="col-3 ">
                                        <label for="noa_received_date" class="form-label">Received Date</label>
                                    </div>
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="noa_received_date" name="noa_received_date">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="row">
                                        <h6 class=" m-1 fw-bold">Notice to Proceed</h6>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-3 ">
                                        <label for="ntp_issued_date" class="form-label">Issued Date</label>
                                    </div>
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="ntp_issued_date" name="ntp_issued_date">
                                    </div>
                                    <div class="col-3 ">
                                        <label for="ntp_received_date" class="form-label">Received Date</label>
                                    </div>
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="ntp_received_date" name="ntp_received_date">
                                    </div>
                                </div>
                                <!-- <div class="row mb-2">
                                    <div class="col-3 ">
                                        <label for="official_starting_date" class="form-label">Official Start<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="official_starting_date" name="official_starting_date">
                                    </div>
                                    <div class="col-3 ">
                                        <label for="target_completion_date" class="form-label">Target Completion Date<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="target_completion_date"
                                            name="target_completion_date">
                                    </div>
                                </div> -->


                                <!-- <div class="row mb-2">
                                    <div class="col-3 ">
                                        <label for="actual_completion_date" class="form-label">Completion Date<span
                                                class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-3">
                                        <input type="date" style="background-color: lightgray;" class="form-control"
                                            id="actual_completion_date" name="actual_completion_date">
                                    </div>
                                    <div class="col-3 ">
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
                                <div class="row mb-2 ">
                                    <label for="mode_of_implementation" class="col-3 form-label">Mode of Implementation
                                        <span class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="mode_of_implementation"
                                            name="mode_of_implementation" value="By contract." readonly required>
                                    </div>
                                </div>
                                <!-- Bagong add -->
                                <div class="row mb-2 align-items-center">
                                    <div class="col-3 ">
                                        <label for="" class="form-label">Starting Date
                                        <span class="text-danger">*</span></label>
                                    </div>                        
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="official_starting_date" name="official_starting_date">
                                    </div>
                                    <div class="col-3 mb-2 ">
                                        <label for="" class="form-label">Target Completion Date
                                            <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-3">
                                            <input type="date" class="form-control" id="target_completion_date"
                                            name="target_completion_date">
                                    </div>
                                </div>
                          
                                <div class="row">
                                    <!-- Order pair container -->
                                    <div id="orderContainer" class="col-12 ">
                                        <div class="row mt-2 mb-2 order-set" id="orderSet1">
                                            <!-- Suspension and Resumption Order Row -->
                                            <div class="row mb-2">
                                                <div class="col-3 ">
                                                    <label for="suspensionOrderNo1" class="form-label">Suspension Order No.1</label>
                                                </div>                        
                                                <div class="col-3">
                                                    <input type="date" class="form-control" id="suspensionOrderNo1" name="suspensionOrderNo1">
                                                </div>
                                                <div class="col-3 mb-2 ">
                                                    <label for="resumeOrderNo1" class="form-label">Resumption Order No.1</label>
                                                </div>
                                                <div class="col-3">
                                                        <input type="date" class="form-control" id="resumeOrderNo1"
                                                        name="resumeOrderNo1">
                                                </div>
                                                <!-- Remarks Row -->
                                                <div class="row mt-1 mb-2">
                                                    <div class="col-md-3 mb-3 ">
                                                        <label for="suspensionOrderNo1Remarks" class="form-label">Reason for Suspension</label>
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
                                <div class="row mb-1">
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
                                    <div class="col-3 ">
                                        <label for="timeExtension" class="form-label">Number of Days Extension</label>
                                    </div>                        
                                    <div class="col-9">
                                        <input type="number" class="form-control" id="timeExtension"
                                            name="timeExtension">
                                    </div>
                                </div>
                                <!-- New Target and Completion Dates -->
                                <div id="newDatesSection" class="row mb-2" style="display: none;">
                                    <div class="col-3 ">
                                        <label for="revised_target_date" class="form-label">New Target Completion Date</label>
                                    </div>                        
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="revised_target_date" name="revised_target_date">
                                    </div>
                                    <div class="col-3 ">
                                        <label for="actual_completion_date" class="form-label">Actual Completion Date</label>
                                    </div>                        
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="actual_completion_date" name="actual_completion_date">
                                    </div>
                                </div>

                                <div class="row">
                                    <!-- Actual Completion Date (Default View) -->
                                    <div class="row mb-2">
                                        <div class="col-3">
                                            <label class="form-label">Actual Date of Completion</label>
                                        </div>
                                        <div class="col-3">
                                            <input type="date" class="form-control" id="actual_completion_date" name="actual_completion_date"
                                                value="{{ old('actual_completion_date', $project['actual_completion_date'] ?? '') }}"
                                                style="background-color: lightgray;">
                                        </div>
                                        <div class="col-2 ">
                                            <label for="actual_length" class="form-label">Actual Length:</label>
                                        </div>
                                        <div class="col-4">
                                            <input type="text" class="form-control" id="actual_length" name="actual_length"
                                                placeholder="Enter project's actual length">
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
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script id="contractor-data" type="application/json">
    {!! json_encode($contractors->pluck('name')) !!}
</script>
<script id="engineer-data" type="application/json">
  {!! json_encode($engineer_name->pluck('engineer_name')->map(fn($engineer_name) => trim($engineer_name))->values()) !!}
</script>



@section('page-scripts')
        <script src="{{ asset('js/Projects/projects-addSubmit.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-addOrder.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-currencyFormatting.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-dateValidation.js') }}"></script>
       <script src="{{ asset('js/Projects/projects-restrictionsValue.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-suggestionBox.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-valueCalculations.js') }}"></script>
        <script src="{{ asset('js/Filters/contractor-search.js') }}"></script>
        <script src="{{ asset('js/Filters/location-search.js') }}"></script>
        <script src="{{ asset('js/Filters/engineer-search.js') }}"></script>
        <script src="{{ asset('js/Filters/sourceOfFund-search.js') }}"></script>
@endsection
