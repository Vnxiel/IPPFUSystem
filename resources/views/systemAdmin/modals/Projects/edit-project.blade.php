<div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
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
                                        <div class="col-3 text-end">
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
                                        <div class="col-3 text-end">
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
                                <div class="row g-3 mb-2 text-end">
                                <div class="col-md-3 text-end">
                                            <label for="projectYear" class="form-label">Year <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-3">
                                            <select class="form-select form-select-sm" id="projectYear" name="projectYear" value="{{ old('projectYear', $project['projectYear'] ?? '') }}" required>
                                                <option value="" disabled selected>Select Year</option>
                                                <!-- Year options will be injected here by JavaScript -->
                                            </select>
                                        </div>
                                    <div class="col-md-2 text-end">
                                        <label for="projectFPP" class="form-label">FPP <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                    <input type="text" class="form-control" id="projectFPP" name="projectFPP" value="{{ old('projectFPP', $project['projectFPP'] ?? '') }}" required>
                                          </div>
                                </div>
                                <div class="row mb-2 g-3 text-end">
                                    <div class="col-md-3 text-end">
                                        <label for="projectRC" class="form-label">Responsibility Center<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                    <input type="text" class="form-control" id="projectRC" name="projectRC" value="{{ old('projectRC', $project['projectRC'] ?? '') }}" required>
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
                                    value="{{ old('projectLoc', $project['projectLoc'] ?? '') }}"
                                    placeholder="Select or enter location" autocomplete="off"
                                    onfocus="showLocDropdown()" oninput="showLocDropdown()" />
                                
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
                            <div class="col-3 text-end">
                                <label for="projectDescription" class="form-label">Project Description<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col">
                            <textarea class="form-control" id="projectDescription" name="projectDescription" style="height: 100px">{{ old('projectDescription', isset($project['projectDescriptions']) ? implode("\n", $project['projectDescriptions']) : '') }}</textarea>
                                      
                            </div>
                        </div>
                        <div class="row mb-2 g-3">
                            <div class="col-3 text-end">
                                <label for="projectContractor" class="form-label">Contractor<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col">
                            <select id="projectContractor" name="projectContractor" class="form-select" onchange="toggleOtherContractor()">
                                            <option value="">--Select Contractor--</option>
                                            @foreach($contractors as $contractor)
                                                <option value="{{ $contractor->name }}" {{ old('projectContractor', $project['projectContractor'] ?? '') == $contractor->name ? 'selected' : '' }}>
                                                    {{ $contractor->name }}
                                                </option>
                                            @endforeach
                                            <option value="Others" {{ old('projectContractor', $project['projectContractor'] ?? '') == 'Others' ? 'selected' : '' }}>Others: (Specify)</option>
                                        </select>
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
                        </div>

                        <!-- Hidden textbox for specifying 'Others' -->
                        <!-- <div class="mb-2" id="othersContractorDiv" style="display: none;">
                                    <label for="othersContractor" class="form-label">Specify New Contractor</label>
                                    <input type="text" class="form-control" id="othersContractor"
                                        name="othersContractor" placeholder="Enter new contractor name">
                                </div> -->

                        <div class="row mb-2 align-items-center">
                            <label for="modeOfImplementation" class="col-3 text-end form-label">Mode of Implementation
                                <span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="modeOfImplementation" name="modeOfImplementation" value="{{ old('modeOfImplementation', $project['modeOfImplementation'] ?? '') }}" readonly>
                            </div>
                        </div>
                        <div class="row mb-2 g-3 text-end">
                            <div class="col-md-3 text-end">
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
                                    <div class="col-md-3 text-end">
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
                                    <div class="col-md-3 text-end">
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
                                    <div class="col-md-3 text-end">
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
                            <div class="col-3 text-end">
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

                            <div class="col-1 text-end">
                                <label for="ea_position" class="form-label">Position<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-4">
                                <select class="form-select" id="ea_position" name="ea_position" value="{{ old('ea_position', $project['ea_position'] ?? '') }}" required>
                                    <option value="" disabled selected>Select Position</option>
                                    <option value="Engineer Aid">Engineer Aid</option>
                                    <option value="Engineer Assistant">Engineer Assistant</option>
                                    <option value="Engineer I">Engineer I</option>
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
                                    <div class="col-3 text-end">
                                        <label for="appropriation" class="form-label">Appropriation <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col">
                                        <div class="input-group">
                                            <span class="input-group-text">₱</span>
                                            <input type="text" class="form-control currency-input" id="appropriation" name="appropriation" value="{{ old('appropriation', $project['funds']['orig_appropriation'] ?? '') }}" required>
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
                                    <input type="text" class="form-control currency-input" id="contractAmount" name="contractAmount" value="{{ old('contractAmount', $project['funds']['orig_contract_amount'] ?? '') }}">
                                        
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <label for="engineering" class="form-label">Engineering</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="engineering" name="engineering" value="{{ old('engineering', $project['funds']['orig_engineering'] ?? '') }}">
                                   
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
                                    <input type="text" class="form-control currency-input" id="abc" name="abc" value="{{ old('abc', $project['funds']['orig_abc'] ?? '') }}">
                                 </div>
                            </div>

                            <div class="col-3 text-end">
                                <label for="mqc" class="form-label">MQC</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="mqc" name="mqc" value="{{ old('mqc', $project['funds']['orig_mqc'] ?? '') }}">
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
                                    <input type="text" class="form-control currency-input" id="bid" name="bid" value="{{ old('bid', $project['funds']['orig_bid'] ?? '') }}">
                                </div>
                             </div>
                            <div class="col-3 text-end">
                                <label for="bid" class="form-label">Contingency</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="contingency" name="contingency" value="{{ old('contingency', $project['funds']['orig_contingency'] ?? '') }}">
                                        
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
                                <input type="date" class="form-control" id="noaIssuedDate" name="noaIssuedDate" value="{{ old('noaIssuedDate', $project['noaIssuedDate'] ?? '') }}">
                                </div>
                                <div class="col-3 text-end">
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
                                <div class="col-3 text-end">
                                    <label for="ntpIssuedDate" class="form-label">Issued Date</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="ntpIssuedDate" name="ntpIssuedDate" value="{{ old('ntpIssuedDate', $project['ntpIssuedDate'] ?? '') }}">
                                </div>
                                <div class="col-3 text-end">
                                    <label for="ntpReceivedDate" class="form-label">Received Date</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="ntpReceivedDate" name="ntpReceivedDate" value="{{ old('ntpReceivedDate', $project['ntpReceivedDate'] ?? '') }}">
                                </div>
                            </div>
                            <!-- <div class="row mb-2">
                                <div class="col-3 text-end">
                                    <label for="originalStartDate" class="form-label">Official Start</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="originalStartDate" name="originalStartDate" value="{{ old('originalStartDate', $project['originalStartDate'] ?? '') }}">
                                </div>
                                <div class="col-3 text-end">
                                    <label for="targetCompletion" class="form-label">Target Completion Date</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="targetCompletion" name="targetCompletion" value="{{ old('targetCompletion', $project['targetCompletion'] ?? '') }}">
                                </div>
                            </div> -->


                            <!-- <div class="row mb-2">
                                <div class="col-3 text-end">
                                    <label for="completionDate" class="form-label">Completion Date</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="completionDate" name="completionDate" value="{{ old('completionDate', $project['completionDate'] ?? '') }}">
                                </div>
                                <div class="col-3 text-end">
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
            <label for="modeOfImplementation" class="col-3 text-end form-label">Mode of Implementation
                <span class="text-danger">*</span></label>
            <div class="col-9">
                <input type="text" class="form-control" id="modeOfImplementation"
                    name="modeOfImplementation" value="By contract." readonly required>
            </div>
        </div>

        <!-- Original and Target Dates -->
        <div class="row mb-2 align-items-center">
            <div class="col-3 text-end">
                <label class="form-label">Original Starting Date <span class="text-danger">*</span></label>
            </div>
            <div class="col-3">
                <input type="date" class="form-control" id="originalStartDate" name="originalStartDate"
                    value="{{ old('originalStartDate', $project['originalStartDate'] ?? '') }}">
            </div>
            <div class="col-3 text-end">
                <label class="form-label">Target Completion Date <span class="text-danger">*</span></label>
            </div>
            <div class="col-3">
                <input type="date" class="form-control" id="targetCompletion" name="targetCompletion"
                    value="{{ old('targetCompletion', $project['targetCompletion'] ?? '') }}">
            </div>
        </div>

        <div class="row">
            <div class="col-3 mb-2 text-end">
                <label class="form-label">Actual Date of Completion <span class="text-danger">*</span></label>
            </div>
            <div class="col-9">
                <input type="date" class="form-control" id="completionDate" name="completionDate"
                    value="{{ old('completionDate', $project['completionDate'] ?? '') }}"
                    style="background-color: lightgray;">
            </div>
        </div>

        <!-- Add/Remove Order Buttons -->
        <div class="row align-items-center">
            <div class="col-md-10"><hr></div>
            <div class="col-2 text-center mb-0">
                <button type="button" class="btn btn-outline-primary btn-sm mr-1"
                    onclick="addOrderFields()" title="Add Suspension and Resumption Order">
                    <span class="fa-solid fa-square-plus"></span>
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm"
                    onclick="removeLastOrderFields()" title="Remove Suspension and Resumption Order">
                    <span class="fa-solid fa-circle-minus"></span>
                </button>
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
                        <div class="col-md-3 mb-3 text-end">
                            <label for="{{ $order['suspensionKey'] }}" class="form-label">
                                Suspension Order No. {{ $order['index'] }}
                            </label>
                        </div>
                        <div class="col-3">
                            <input type="date" class="form-control" id="{{ $order['suspensionKey'] }}"
                                name="{{ $order['suspensionKey'] }}" value="{{ $order['suspensionValue'] }}">
                        </div>
                        <div class="col-md-3 mb-3 text-end">
                            <label for="{{ $order['resumeKey'] }}" class="form-label">
                                Resumption Order No. {{ $order['index'] }}
                            </label>
                        </div>
                        <div class="col-3">
                            <input type="date" class="form-control" id="{{ $order['resumeKey'] }}"
                                name="{{ $order['resumeKey'] }}" value="{{ $order['resumeValue'] }}">
                        </div>
                        <div class="row mt-1 mb-2">
                            <div class="col-md-3 mb-3 text-end">
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

        @if($orders->isNotEmpty())
            <!-- Revised Dates and Extension -->
            <div class="row mb-2">
                <div class="col-3 text-end">
                    <label for="revisedTargetDate" class="form-label">Revised Target Date
                        <span class="text-danger">*</span>
                    </label>
                </div>
                <div class="col-3">
                    <input type="date" class="form-control" id="revisedTargetDate"
                        name="revisedTargetDate"
                        value="{{ old('revisedTargetDate', $project['revisedTargetDate'] ?? '') }}">
                </div>
                <div class="col-3 text-end">
                    <label for="revisedCompletionDate" class="form-label">Revised Completion Date
                        <span class="text-danger">*</span>
                    </label>
                </div>
                <div class="col-3">
                    <input type="date" class="form-control" id="revisedCompletionDate"
                        name="revisedCompletionDate"
                        value="{{ old('revisedCompletionDate', $project['revisedCompletionDate'] ?? '') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-3 text-end">
                    <label for="timeExtension" class="form-label">Extension Date
                        <span class="text-danger">*</span>
                    </label>
                </div>
                <div class="col-3">
                    <input type="number" class="form-control" id="timeExtension"
                        name="timeExtension"
                        value="{{ old('timeExtension', $project['timeExtension'] ?? '') }}">
                </div>
            </div>
        @endif
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


