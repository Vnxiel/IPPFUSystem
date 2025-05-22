<div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header text-white bg-primary">
                        <h5 class="modal-title" id="projectModalLabel">Edit Project Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form id="updateProjectForm" name="updateProjectForm" method="POST">
                        @csrf
                        <!-- Project Profile Section -->
                        <fieldset class="border p-3 mb-4 rounded shadow-sm">
                            <legend class="float-none w-auto px-3 fw-bold text-primary">
                                <i class="fas fa-info-circle me-2"></i>Project Profile
                            </legend>

                            <div class="row g-3 mb-2">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-3 p">
                                            <label for="projectTitle" class="form-label">Project Title <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col">
                                             <input type="text" class="form-control" id="projectTitle" name="projectTitle" value="{{ old('projectTitle', $project['projectTitle'] ?? '') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 mb-2">
                                <div class="col-md-12  mb-2">
                                    <div class="row">
                                        <div class="col-3 p">
                                            <label for="projectID" class="form-label">Project ID <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col">
                                            <input type="text" class="form-control" id="projectID" name="projectID" value="{{ old('projectID', $project['projectID'] ?? '') }}" required>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <!-- Project Year with Datalist -->
                                <div class="row g-3 mb-2">
                                    <div class="col-md-3 p">
                                        <label for="projectYear" class="form-label">Year <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select form-select-sm" id="projectYear" name="projectYear" value="{{ old('projectYear', $project['projectYear'] ?? '') }}" required>
                                            <option value="" disabled selected>Select Year</option>
                                            <!-- Year options will be injected here by JavaScript -->
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="projectFPP" class="form-label">FPP <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                    <input type="text" class="form-control" id="projectFPP" name="projectFPP" value="{{ old('projectFPP', $project['projectFPP'] ?? '') }}" required>
                                          </div>
                                </div>
                                <div class="row mb-2 g-3">
                                    <div class="col-md-3">
                                        <label for="projectRC" class="form-label">Responsibility Center<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                    <input type="text" class="form-control" id="projectRC" name="projectRC" value="{{ old('projectRC', $project['projectRC'] ?? '') }}" required>
                                        </div>
                                </div>
                                <div class="row g-3 mb-2 p">
                            <div class="col-md-3">
                                <label for="projectLoc" class="form-label">Location
                                    <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-md-9 position-relative">
                                <input type="text" class="form-control" id="projectLoc" name="projectLoc"
                                    value="{{ old('projectLoc', $project['projectLoc'] ?? '') }}"
                                    placeholder="Select or enter location" autocomplete="off"
                                    oninput="filterLocations()" onblur="finalizeLocation()" onfocus="showLocDropdown()"/>
                                
                                <!-- Dropdown -->
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

                        <div class="row mb-2 g-3">
                            <div class="col-3 p">
                                <label for="projectDescription" class="form-label">Project Description<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col">
                            <textarea class="form-control" id="projectDescription" name="projectDescription" style="height: 100px">{{ old('projectDescription', isset($project['projectDescriptions']) ? implode("\n", $project['projectDescriptions']) : '') }}</textarea>
                                      
                            </div>
                        </div>
                         <!-- Contractor Input with Dynamic Suggestions -->
                         <div class="row g-3 mb-2 p">
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

                            <!-- <div class="mb-2">
                                <label for="projectContractor" class="form-label">Contractor <span
                                        class="text-danger">*</span></label>
                                <select id="projectContractor" name="projectContractor" class="form-select">
                                    <option value="">--Select Contractor--</option>
                                    @foreach($contractors as $contractor)
                                        <option value="{{ $contractor->name }}">{{ $contractor->name }}</option>
                                    @endforeach
                                    <option value="Others">Others: (Specify)</option>
                                </select>-->
                        
                        <!-- Hidden textbox for specifying 'Others' -->
                        <!-- <div class="mb-2" id="othersContractorDiv" style="display: none;">
                                    <label for="othersContractor" class="form-label">Specify New Contractor</label>
                                    <input type="text" class="form-control" id="othersContractor"
                                        name="othersContractor" placeholder="Enter new contractor name">
                                </div> -->

                        <div class="row mb-2 align-items-center">
                            <label for="modeOfImplementation" class="col-3 p form-label">Mode of Implementation
                                <span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="modeOfImplementation" name="modeOfImplementation" value="{{ old('modeOfImplementation', $project['modeOfImplementation'] ?? '') }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-2 g-3 p">
                            <div class="col-md-3 p">
                                <label for="sourceOfFunds" class="form-label">Source of Fund <span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                            <input type="text" class="form-control" id="sourceOfFunds" name="sourceOfFunds" value="{{ old('sourceOfFunds', $project['sourceOfFunds'] ?? '') }}"
                                            placeholder="Enter source of funds.">
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
                                    <div class="col-md-3 p">
                                        <label for="contractDays" class="form-label">Contract Days (Calendar days) <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" id="projectContractDays" name="projectContractDays" min="0" value="{{ old('projectContractDays', $project['projectContractDays'] ?? '') }}">
                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row mb-2 align-items-center">
                            <div class="col-md-12 ">
                                <div class="row align-items-center">
                                    <div class="col-md-3 p">
                                        <label for="projectStatus" class="form-label">Status <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 d-flex gap-2">
                                        <select id="projectStatus" name="projectStatus" class="form-select"
                                            onchange="toggleOngoingStatus()" required>
                                            <option value="" disabled selected>Select Status</option>
                                            <option value="Not Started"><i class="fas fa-not-equal"></i>Not Startedd
                                            </option>
                                            <option value="Ongoing">Ongoing</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Discontinued">Discontinued</option>
                                            <option value="Suspended">Suspended</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                        <!-- Hidden text input for 'Ongoing' -->
                        <!-- <div id="ongoingStatusContainer" class="mt-2" style="display: none;">
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
                        </div> -->
                        <div class="row mb-2 align-items-center">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-3 p">
                                            <label for="projectSlippage" class="form-label">Slippage</label>
                                    </div>
                                    <div class="col-md-9">
                                            <input type="number" class="form-control" id="projectSlippage" name="projectSlippage"  value="{{ old('projectSlippage', $project['projectSlippage'] ?? '') }}"
                                            placeholder="Enter slippage">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Engineer Assigned (E.A) with Datalist -->
                            <div class="col-3 p">
                                <label for="ea" class="form-label">Project Engineer <span
                                            class="text-danger">*</span></label>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" id="ea" name="ea" list="eaList" value="{{ old('ea', $project['ea'] ?? '') }}"
                                    placeholder="Enter Engineer Assigned">
                                <datalist id="eaList">
                                    @foreach($projectEA as $ea)
                                        <option value="{{ $ea->ea }}"></option>
                                    @endforeach
                                </datalist>
                            </div>

                            <div class="col-1 p">
                                <label for="ea_position" class="form-label">Position<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-4">
                                <select class="form-select" id="ea_position" name="ea_position" required>
                                    <option value="" disabled {{ old('ea_position', $project['ea_position'] ?? '') == '' ? 'selected' : '' }}>Select Position</option>
                                    <option value="Engineer Aid" {{ old('ea_position', $project['ea_position'] ?? '') == 'Engineer Aid' ? 'selected' : '' }}>Engineer Aid</option>
                                    <option value="Engineer Assistant" {{ old('ea_position', $project['ea_position'] ?? '') == 'Engineer Assistant' ? 'selected' : '' }}>Engineer Assistant</option>
                                    <option value="Engineer I" {{ old('ea_position', $project['ea_position'] ?? '') == 'Engineer I' ? 'selected' : '' }}>Engineer I</option>
                                </select>
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
                                    <div class="col-3 ">
                                        <label for="appropriation" class="form-label">Appropriation <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <input type="text" class="form-control currency-input" name="appropriation"
                                                id="appropriation" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-3 ">
                                <label for="contractAmount" class="form-label">Contract Amount</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input type="text" class="form-control currency-input" id="contractAmount"
                                        name="contractAmount">
                                </div>
                            </div>
                            <div class="col-3 ">
                                <label for="engineering" class="form-label">Engineering</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input type="text" class="form-control currency-input" id="engineering"
                                        name="engineering">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-3 ">
                                <label for="abc" class="form-label">ABC</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input type="text" class="form-control currency-input" id="abc" name="abc">
                                </div>
                            </div>

                            <div class="col-3 ">
                                <label for="mqc" class="form-label">MQC</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input type="text" class="form-control currency-input" id="mqc" name="mqc">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-3 ">
                                <label for="bid" class="form-label">Bid Difference</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input type="text" class="form-control currency-input" id="bid" name="bid">
                                </div>
                            </div>
                            <div class="col-3 ">
                                <label for="bid" class="form-label">Contingency</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
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
                                <div class="col-3 p">
                                    <label for="noaIssuedDate" class="form-label">Issued Date</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="noaIssuedDate" name="noaIssuedDate" value="{{ old('noaIssuedDate', $project['noaIssuedDate'] ?? '') }}">
                                </div>
                                <div class="col-3 p">
                                    <label for="noaReceivedDate" class="form-label">Received Date</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="noaReceivedDate" name="noaReceivedDate" value="{{ old('noaReceivedDate', $project['noaReceivedDate'] ?? '') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="row">
                                    <h6 class=" m-1 fw-bold">Notice to Proceed</h6>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3 p">
                                    <label for="ntpIssuedDate" class="form-label">Issued Date</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="ntpIssuedDate" name="ntpIssuedDate" value="{{ old('ntpIssuedDate', $project['ntpIssuedDate'] ?? '') }}">
                                </div>
                                <div class="col-3 p">
                                    <label for="ntpReceivedDate" class="form-label">Received Date</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="ntpReceivedDate" name="ntpReceivedDate" value="{{ old('ntpReceivedDate', $project['ntpReceivedDate'] ?? '') }}">
                                </div>
                            </div>
                            <!-- <div class="row mb-2">
                                <div class="col-3 p">
                                    <label for="originalStartDate" class="form-label">Official Start</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="originalStartDate" name="originalStartDate" value="{{ old('originalStartDate', $project['originalStartDate'] ?? '') }}">
                                </div>
                                <div class="col-3 p">
                                    <label for="targetCompletion" class="form-label">Target Completion Date</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="targetCompletion" name="targetCompletion" value="{{ old('targetCompletion', $project['targetCompletion'] ?? '') }}">
                                </div>
                            </div> -->


                            <!-- <div class="row mb-2">
                                <div class="col-3 p">
                                    <label for="completionDate" class="form-label">Completion Date</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="completionDate" name="completionDate" value="{{ old('completionDate', $project['completionDate'] ?? '') }}">
                                </div>
                                <div class="col-3 p">
                                    <label for="revisedCompletionDate" class="form-label">Revised Completion
                                        Date</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="revisedCompletionDate" name="revisedCompletionDate" value="{{ old('revisedCompletionDate', $project['revisedCompletionDate'] ?? '') }}">
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
                        <!-- Implementation Details Section -->
                        <fieldset class="border p-3 mb-4 rounded shadow-sm">
                            <legend class="float-none w-auto px-3 fw-bold text-primary">
                                <i class="fas fa-info-circle me-2"></i>Implementation Details
                            </legend>

                            <div class="container">
                                <div class="row mb-2 align-items-center">
                                    <label for="modeOfImplementation" class="col-3 p form-label">Mode of Implementation
                                        <span class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="modeOfImplementation"
                                            name="modeOfImplementation" value="By contract." readonly required>
                                    </div>
                                </div>

                                <!-- Original and Target Dates -->
                                <div class="row mb-2 align-items-center">
                                    <div class="col-3 p">
                                        <label class="form-label">Original Starting Date <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="originalStartDate" name="originalStartDate"
                                            value="{{ old('originalStartDate', $project['originalStartDate'] ?? '') }}">
                                    </div>
                                    <div class="col-3 p">
                                        <label class="form-label">Target Completion Date <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="targetCompletion" name="targetCompletion"
                                            value="{{ old('targetCompletion', $project['targetCompletion'] ?? '') }}">
                                    </div>
                                </div>

                                

                                <div class="row">
                                <!-- Order pair container -->
                                <div id="orderContainer" class="col-12 ">
                                    <div class="row mt-2 mb-2 order-set" id="orderSet1">
                                        <!-- Suspension and Resumption Order Row -->
                                        <div class="row mb-2">
                                            <div class="col-3 text-end">
                                                <label for="suspensionOrderNo1" class="form-label">Suspension Order No.1</label>
                                            </div>                        
                                            <div class="col-3">
                                                <input type="date" class="form-control" id="suspensionOrderNo1" name="suspensionOrderNo1">
                                            </div>
                                            <div class="col-3 mb-2 text-end">
                                                <label for="resumeOrderNo1" class="form-label">Resumption Order No.1</label>
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
                            <div class="row text-end mb-1">
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
                                    <label for="timeExtension" class="form-label">Extension Date</label>
                                </div>                        
                                <div class="col-9">
                                    <input type="number" class="form-control" id="timeExtension"
                                        name="timeExtension">
                                </div>
                            </div>

                                    <!-- Orders -->
                                    <div id="orderContainer" class="col-12">
                                        @php
                                            $remarksData = $project['remarksData'] ?? [];
                                            $orders = collect($project['orderDetails'] ?? [])
                                                ->filter(fn($val, $key) => preg_match('/suspensionOrderNo\d+/', $key))
                                                ->keys()
                                                ->map(function ($suspKey) use ($project) {
                                                    $index = preg_replace('/\D/', '', $suspKey);
                                                    $resumeKey = 'resumeOrderNo' . $index;
                                                    return [
                                                        'index' => $index,
                                                        'suspensionKey' => $suspKey,
                                                        'resumeKey' => $resumeKey,
                                                        'suspensionValue' => old($suspKey, $project['orderDetails'][$suspKey] ?? ''),
                                                        'resumeValue' => old($resumeKey, $project['orderDetails'][$resumeKey] ?? '')
                                                    ];
                                                })
                                                ->filter(fn($order) => !empty($order['suspensionValue']) || !empty($order['resumeValue']));
                                        @endphp

                                        @foreach ($orders as $order)
                                            <div class="row">
                                                <div class="col-md-3 mb-3 p">
                                                    <label for="{{ $order['suspensionKey'] }}" class="form-label">
                                                        Suspension Order No. {{ $order['index'] }}
                                                    </label>
                                                </div>
                                                <div class="col-3">
                                                    <input type="date" class="form-control" id="{{ $order['suspensionKey'] }}"
                                                        name="{{ $order['suspensionKey'] }}" value="{{ $order['suspensionValue'] }}">
                                                </div>
                                                <div class="col-md-3 mb-3 p">
                                                    <label for="{{ $order['resumeKey'] }}" class="form-label">
                                                        Resumption Order No. {{ $order['index'] }}
                                                    </label>
                                                </div>
                                                <div class="col-3">
                                                    <input type="date" class="form-control" id="{{ $order['resumeKey'] }}"
                                                        name="{{ $order['resumeKey'] }}" value="{{ $order['resumeValue'] }}">
                                                </div>
                                                <div class="row mt-1 mb-2">
                                                    <div class="col-md-3 mb-3 p">
                                                        <label for="suspensionOrderNo{{ $order['index'] }}Remarks" class="form-label">
                                                            Suspension Remarks
                                                        </label>
                                                    </div>
                                                    <div class="col-9">
                                                        <textarea class="form-control"
                                                            id="suspensionOrderNo{{ $order['index'] }}Remarks"
                                                            name="suspensionOrderNo{{ $order['index'] }}Remarks">
                                                            {{ $remarksData[(string) $order['index']]['suspensionOrderRemarks'] ?? '' }}
                                                        </textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                    <!-- Revised Dates and Extension -->
                                    <div class="row mb-2">
                                        <div class="col-3 p">
                                            <label for="revisedTargetDate" class="form-label">Revised Target Date
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input type="date" class="form-control" id="revisedTargetDate"
                                                name="revisedTargetDate"
                                                value="{{ old('revisedTargetDate', $project['revisedTargetDate'] ?? '') }}">
                                        </div>
                                        <div class="col-3 p">
                                            <label for="revisedCompletionDate" class="form-label">Revised Completion Date
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input type="date" class="form-control" id="revisedCompletionDate"
                                                name="revisedCompletionDate"
                                                value="{{ old('revisedCompletionDate', $project['revisedCompletionDate'] ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-3 p">
                                            <label for="timeExtension" class="form-label">Extension Date
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input type="number" class="form-control" id="timeExtension"
                                                name="timeExtension"
                                                value="{{ old('timeExtension', $project['timeExtension'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div class="row mt-2">
                                    <div class="col-3 mb-2 p">
                                        <label class="form-label">Actual Date of Completion <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-9">
                                        <input type="date" class="form-control" id="completionDate" name="completionDate"
                                            value="{{ old('completionDate', $project['completionDate'] ?? '') }}"
                                            style="background-color: lightgray;">
                                    </div>
                                </div>
                            </div>
                        </fieldset>


                            <!-- Modal Footer -->
                            <div class="modal-footer bg-light">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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


    // Optional: Close dropdown if clicked outside
    document.addEventListener('click', function (e) {
        const input = document.getElementById('projectLoc');
        const dropdown = document.getElementById('projectLocDropdown');
        if (!input.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });

    const select = document.getElementById("projectYear");
    const selectedYear = "{{ old('projectYear', $project['projectYear'] ?? '') }}";
    const currentYear = new Date().getFullYear();
    const startYear = 2000;

    // Clear default if it's not actually selected
    select.querySelector("option[value='']").selected = !selectedYear;

    for (let year = currentYear; year >= startYear; year--) {
      const option = document.createElement("option");
      option.value = year;
      option.textContent = year;
      if (year.toString() === selectedYear) {
        option.selected = true;
      }
      select.appendChild(option);
    }
</script>
        <script>
    function applyHistoryValue(selectEl, inputId) {
        const value = selectEl.value;
        if (value) {
            document.getElementById(inputId).value = value;
            document.getElementById(inputId).focus();
        }
    }
</script>


