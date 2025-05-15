<div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h1 class="modal-title fs-5 fw-bold" id="projectModalLabel">
                    <i class="fas fa-pen me-2"></i>Edit Project Details
                </h1>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
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
                                        <textarea class="form-control" row="3" id="projectTitle" name="projectTitle"
                                            value="{{ old('projectTitle', $project['projectTitle'] ?? '') }}"
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
                                            pattern="^[0-9-]+$" title="Only numbers and hyphens are allowed"
                                            value="{{ old('projectID', $project['projectID'] ?? '') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Project Year with Datalist -->
                        <div class="row g-3 mb-2 text-end">
                            <div class="col-md-3 text-end">
                                <label for="projectYear" class="form-label">Year <span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-3">
                                <select class="form-select form-select-sm" id="projectYear" name="projectYear"
                                    value="{{ old('projectYear', $project['projectYear'] ?? '') }}" required>
                                    <option value="" disabled selected>Select Year</option>
                                    <!-- Year options will be injected here by JavaScript -->
                                </select>
                            </div>
                            <div class="col-md-2 text-end">
                                <label for="projectFPP" class="form-label">FPP <span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="projectFPP" name="projectFPP"
                                    value="{{ old('projectFPP', $project['projectFPP'] ?? '') }}" required>
                            </div>
                        </div>
                        <div class="row mb-2 g-3 text-end">
                            <div class="col-md-3 text-end">
                                <label for="projectRC" class="form-label">Responsibility Center<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="projectRC" name="projectRC"
                                    value="{{ old('projectRC', $project['projectRC'] ?? '') }}" required>
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

                                    @foreach($locations as $locationObj)
                                        @php
                                            $locName = trim($locationObj->projectLoc);
                                            // Match only locations in Nueva Vizcaya
                                            if (str_ends_with($locName, 'Nueva Vizcaya')) {
                                                // Remove "Nueva Vizcaya" if already present to avoid duplication
                                                $municipality = trim(str_replace(', Nueva Vizcaya', '', $locName));
                                                $formatted = $municipality . ', Nueva Vizcaya';
                                            } else {
                                                $formatted = $locName . ', Nueva Vizcaya';
                                            }
                                        @endphp
                                        <button type="button" class="list-group-item list-group-item-action"
                                            onmousedown="selectLoc('{{ $formatted }}')">
                                            {{ $formatted }}
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
                                <textarea class="form-control" id="projectDescription" name="projectDescription"
                                    style="height: 100px">{{ old('projectDescription', isset($project['projectDescriptions']) ? implode("\n", $project['projectDescriptions']) : '') }}</textarea>

                            </div>
                        </div>

                        <div class="row mb-2 g-3">
                            <div class="col-3 text-end">
                                <label for="projectContractor" class="form-label">Contractor<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col position-relative">
                                <input type="text" class="form-control" id="projectContractor" name="projectContractor"
                                    value="{{ old('projectContractor', $project['projectContractor'] ?? '') }}"
                                    placeholder="Select or enter contractor" autocomplete="off"
                                    onfocus="showContractorDropdown()" oninput="showContractorDropdown()" />
                                <div id="projectContractorDropdown"
                                    class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                    style="display: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                                    @foreach($contractors as $contractor)
                                        <button type="button" class="list-group-item list-group-item-action"
                                            onclick="selectContractor('{{ $contractor->name }}')">
                                            {{ $contractor->name }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        </div>


                        <div class="row mb-2 g-3 text-end">
                            <div class="col-md-3 text-end">
                                <label for="sourceOfFunds" class="form-label">Source of Fund <span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9 position-relative">
                                <input type="text" class="form-control" id="sourceOfFunds" name="sourceOfFunds"
                                    value="{{ old('sourceOfFunds', $project['sourceOfFunds'] ?? '') }}"
                                    placeholder="Enter source of funds" autocomplete="off" onfocus="showFundDropdown()"
                                    oninput="showFundDropdown()" />
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
                                            name="projectContractDays" min="0"
                                            value="{{ old('projectContractDays', $project['projectContractDays'] ?? '') }}">


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
                        <div class="row g-3 mb-2">
                            <div class="col-3 text-end">
                                <label for="eaInput" class="form-label">Project Engineer <span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-4 position-relative">
                                <input type="text" class="form-control" id="eaInput" name="ea" autocomplete="off"
                                    placeholder="Enter Project Engineer" value="{{ old('ea', $project['ea'] ?? '') }}"
                                    onfocus="showEADropdown()" oninput="showEADropdown()" />

                                <div id="eaDropdown"
                                    class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                    style="display:none; max-height:180px; overflow-y:auto; z-index:1050;">
                                    @foreach($projectEA as $eaObj)
                                        <button type="button" class="list-group-item list-group-item-action"
                                            onclick="selectEA('{{ $eaObj->ea }}')">
                                            {{ $eaObj->ea }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>


                            <div class="col-1 text-end">
                                <label for="ea" class="form-label">Position<span class="text-danger"
                                        list="eaList">*</span></label>
                            </div>
                            <div class="col-4">
                                <select class="form-select" id="ea" name="ea"
                                    value="{{ old('ea', $project['ea'] ?? '') }}" required>
                                    <option value="" disabled selected>Select Position</option>
                                    <option value="Engineer Aid">Engineer Aid</option>
                                    <option value="Engineer Assistant">Engineer Assistant</option>
                                    <option value="Engineer I">Engineer I</option>
                                </select>
                            </div>

                        </div>

                        <!-- <div class="row mb-2">
                            <div class="col-3 text-end">
                                <label for="ea_position" class="form-label">Position<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="ea_position" name="ea_position"
                                    value="{{ old('ea_position', $project['ea_position'] ?? '') }}">
                            </div>
                            <div class="col-3 text-end">
                                <label for="ea_monthlyRate" class="form-label">Monthly Rate<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="ea_monthlyRate"
                                        name="ea_monthlyRate"
                                        value="{{ old('ea_monthlyRate', $project['ea_monthlyRate'] ?? '') }}">
                                </div>
                            </div> -->
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
                                            <input type="text" class="form-control currency-input" id="appropriation"
                                                name="appropriation"
                                                value="{{ old('appropriation', $project['funds']['orig_appropriation'] ?? '') }}"
                                                required>
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
                                        name="contractAmount"
                                        value="{{ old('contractAmount', $project['funds']['orig_contract_amount'] ?? '') }}">

                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <label for="engineering" class="form-label">Engineering</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="engineering"
                                        name="engineering"
                                        value="{{ old('engineering', $project['funds']['orig_engineering'] ?? '') }}">

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
                                    <input type="text" class="form-control currency-input" id="abc" name="abc"
                                        value="{{ old('abc', $project['funds']['orig_abc'] ?? '') }}">
                                </div>
                            </div>

                            <div class="col-3 text-end">
                                <label for="mqc" class="form-label">MQC</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="mqc" name="mqc"
                                        value="{{ old('mqc', $project['funds']['orig_mqc'] ?? '') }}">
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
                                    <input type="text" class="form-control currency-input" id="bid" name="bid"
                                        value="{{ old('bid', $project['funds']['orig_bid'] ?? '') }}">
                                </div>
                            </div>
                            <div class="col-3 text-end">
                                <label for="bid" class="form-label">Contingency</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="text" class="form-control currency-input" id="contingency"
                                        name="contingency"
                                        value="{{ old('contingency', $project['funds']['orig_contingency'] ?? '') }}">

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
                                    <input type="date" class="form-control" id="noaIssuedDate" name="noaIssuedDate"
                                        value="{{ old('noaIssuedDate', $project['noaIssuedDate'] ?? '') }}">
                                </div>
                                <div class="col-3 text-end">
                                    <label for="noaReceivedDate" class="form-label">Received Date</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="noaReceivedDate" name="noaReceivedDate"
                                        value="{{ old('noaReceivedDate', $project['noaReceivedDate'] ?? '') }}">
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
                                    <input type="date" class="form-control" id="ntpIssuedDate" name="ntpIssuedDate"
                                        value="{{ old('ntpIssuedDate', $project['ntpIssuedDate'] ?? '') }}">
                                </div>
                                <div class="col-3 text-end">
                                    <label for="ntpReceivedDate" class="form-label">Received Date</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="ntpReceivedDate" name="ntpReceivedDate"
                                        value="{{ old('ntpReceivedDate', $project['ntpReceivedDate'] ?? '') }}">
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

                    <!-- Implementation Details Section -->
                    <fieldset class="border p-3 mb-4 rounded shadow-sm">
                        <legend class="float-none w-auto px-3 fw-bold text-primary">
                            <i class="fas fa-info-circle me-2"></i>Implementation Details
                        </legend>

                        <div class="container">
                            <div class="row mb-2 align-items-center">
                                <label for="modeOfImplementation" class="col-3 text-end form-label">Mode of
                                    Implementation
                                    <span class="text-danger">*</span></label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="modeOfImplementation"
                                        name="modeOfImplementation" value="By contract." readonly required>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-3 text-end">
                                    <label for="officialStart" class="form-label">Original Starting Date <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="officialStart" name="officialStart"
                                        value="{{ old('officialStart', $project['officialStart'] ?? '') }}">
                                </div>
                                <div class="col-3 text-end">
                                    <label for="targetCompletion" class="form-label">Target Completion Date</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="targetCompletion"
                                        name="targetCompletion"
                                        value="{{ old('targetCompletion', $project['targetCompletion'] ?? '') }}">
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

                            <div class="row align-items-center">

                                <!-- Order Fields -->
                                <div id="orderContainer" class="col-12">
                                    @php
                                        // Extract remarks data at the top level so it's accessible in the view
                                        $remarksData = $project['remarksData'] ?? [];

                                        $orders = collect($project['orderDetails'] ?? [])
                                            ->filter(fn($val, $key) => preg_match('/suspensionOrderNo\d+/', $key))
                                            ->keys()
                                            ->map(function ($suspKey) use ($project) {
                                                $index = preg_replace('/\D/', '', $suspKey);
                                                $resumeKey = 'resumeOrderNo' . $index;

                                                $suspensionValue = old($suspKey, $project['orderDetails'][$suspKey] ?? '');
                                                $resumeValue = old($resumeKey, $project['orderDetails'][$resumeKey] ?? '');

                                                return [
                                                    'index' => $index,
                                                    'suspensionKey' => $suspKey,
                                                    'resumeKey' => $resumeKey,
                                                    'suspensionValue' => $suspensionValue,
                                                    'resumeValue' => $resumeValue,
                                                ];
                                            })
                                            ->filter(fn($order) => $order['index'] == 1 || !empty($order['suspensionValue']) || !empty($order['resumeValue']));
                                    @endphp

                                    @foreach ($orders as $order)
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label for="{{ $order['suspensionKey'] }}" class="form-label">Suspension
                                                    Order No. {{ $order['index'] }}</label>
                                                <input type="date" class="form-control" id="{{ $order['suspensionKey'] }}"
                                                    name="{{ $order['suspensionKey'] }}"
                                                    value="{{ $order['suspensionValue'] }}">
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="{{ $order['resumeKey'] }}" class="form-label">Resumption Order
                                                    No. {{ $order['index'] }}</label>
                                                <input type="date" class="form-control" id="{{ $order['resumeKey'] }}"
                                                    name="{{ $order['resumeKey'] }}" value="{{ $order['resumeValue'] }}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <label for="suspensionOrderNo{{ $order['index'] }}Remarks"
                                                    class="form-label">Suspension Remarks</label>
                                                <textarea class="form-control"
                                                    id="suspensionOrderNo{{ $order['index'] }}Remarks"
                                                    name="suspensionOrderNo{{ $order['index'] }}Remarks"
                                                    value="{{ $remarksData[$order['index']]['suspensionOrderRemarks'] ?? '' }}"></textarea>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <label for="resumeOrderNo{{ $order['index'] }}Remarks"
                                                    class="form-label">Resumption Remarks</label>
                                                <textarea class="form-control"
                                                    id="resumeOrderNo{{ $order['index'] }}Remarks"
                                                    name="resumeOrderNo{{ $order['index'] }}Remarks"
                                                    value="{{ $remarksData[$order['index']]['resumeOrderRemarks'] ?? '' }}"></textarea>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Add/Remove Order Buttons -->
                                <div class="col-md-10">
                                    <hr>
                                </div>
                                <div class="col-2 text-center mb-2">
                                    <button type="button" class="btn btn-outline-primary btn-sm mr-1"
                                        onclick="addOrderFields()" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Add Suspension and Resumption Order">
                                        <span class="fa-solid fa-square-plus"></span>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="removeLastOrderFields()" data-bs-toggle="tooltip"
                                        data-bs-placement="top" title="Remove Suspension and Resumption Order">
                                        <span class="fa-solid fa-circle-minus"></span>
                                    </button>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3 text-end">
                                    <label for="" class="form-label">Revised Target Date</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="" name="">
                                </div>
                                <div class="col-3 text-end">
                                    <label for="revisedCompletionDate" class="form-label">Revised Completion
                                        Date</label>
                                </div>
                                <div class="col-3">
                                    <input type="date" class="form-control" id="revisedCompletionDate"
                                        name="revisedCompletionDate"
                                        value="{{ old('revisedCompletionDate', $project['revisedCompletionDate'] ?? '') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-end">
                                    <label for="timeExtension" class="form-label">Time Extension</label>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <input type="text" class="form-control" id="timeExtension" name="timeExtension"
                                        value="{{ old('timeExtension', $project['timeExtension'] ?? '') }}">
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
</div>
<script>
    function showLocDropdown() {
        document.getElementById('projectLocDropdown').style.display = 'block';
    }

    function selectLoc(value) {
        document.getElementById('projectLoc').value = value;
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

    const select = document.getElementById('projectYear');
    const currentYear = new Date().getFullYear();
    const startYear = 2015; // Set your desired start year

    for (let year = currentYear; year >= startYear; year--) {
        const option = document.createElement('option');
        option.value = year;
        option.textContent = year;
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

    const fundInput = document.getElementById('sourceOfFunds');
    const fundDropdown = document.getElementById('sourceOfFundsDropdown');
    const fundItems = fundDropdown.getElementsByTagName('button');
    let selectedIndexFund = -1;

    function showFundDropdown() {
        const filter = fundInput.value.toLowerCase().trim();
        let anyVisible = false;

        for (let i = 0; i < fundItems.length; i++) {
            const text = fundItems[i].textContent.toLowerCase().trim();
            const match = text.startsWith(filter);
            fundItems[i].style.display = match ? '' : 'none';
            if (match) anyVisible = true;
        }

        fundDropdown.style.display = (filter.length > 0 && anyVisible) ? 'block' : 'none';
        selectedIndexFund = -1;
    }

    function selectFund(value) {
        fundInput.value = value.trim();
        fundDropdown.style.display = 'none';
    }

    function updateActiveFund(visibleItems) {
        visibleItems.forEach((item, i) => {
            item.classList.toggle('active', i === selectedIndexFund);
        });
    }

    fundInput.addEventListener('focus', showFundDropdown);
    fundInput.addEventListener('input', showFundDropdown);

    fundInput.addEventListener('keydown', function (e) {
        const visibleItems = Array.from(fundItems).filter(item => item.style.display !== 'none');

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (selectedIndexFund < visibleItems.length - 1) selectedIndexFund++;
            updateActiveFund(visibleItems);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (selectedIndexFund > 0) selectedIndexFund--;
            updateActiveFund(visibleItems);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (visibleItems[selectedIndexFund]) {
                selectFund(visibleItems[selectedIndexFund].textContent);
            } else if (visibleItems.length === 1) {
                selectFund(visibleItems[0].textContent);
            }
        } else if (e.key === 'Escape') {
            fundDropdown.style.display = 'none';
        }
    });

    Array.from(fundItems).forEach(item => {
        item.addEventListener('mousedown', function (e) {
            e.preventDefault(); // prevent blur before click
            selectFund(this.textContent);
        });
    });

    document.addEventListener('click', function (e) {
        if (!fundInput.contains(e.target) && !fundDropdown.contains(e.target)) {
            fundDropdown.style.display = 'none';
        }
    });




    const eaInput = document.getElementById('eaInput');
    const eaDropdown = document.getElementById('eaDropdown');
    const eaItems = eaDropdown.getElementsByTagName('button');
    let eaSelectedIndex = -1;

    function showEADropdown() {
        const filter = eaInput.value.toLowerCase().trim();
        let anyVisible = false;

        for (let i = 0; i < eaItems.length; i++) {
            const text = eaItems[i].textContent.toLowerCase().trim();
            const match = text.startsWith(filter);
            eaItems[i].style.display = match ? '' : 'none';
            if (match) anyVisible = true;
        }

        eaDropdown.style.display = (filter.length > 0 && anyVisible) ? 'block' : 'none';
        eaSelectedIndex = -1;
    }

    function selectEA(value) {
        eaInput.value = value.trim();
        eaDropdown.style.display = 'none';
    }

    eaInput.addEventListener('keydown', function (e) {
        const visibleItems = Array.from(eaItems).filter(item => item.style.display !== 'none');

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (eaSelectedIndex < visibleItems.length - 1) eaSelectedIndex++;
            updateEAActive(visibleItems);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (eaSelectedIndex > 0) eaSelectedIndex--;
            updateEAActive(visibleItems);
        } else if (e.key === 'Enter') {
            e.preventDefault();

            if (visibleItems.length === 1 && eaSelectedIndex === -1) {
                // Only one visible option and none selected, pick it automatically
                selectEA(visibleItems[0].textContent);
            } else if (visibleItems[eaSelectedIndex]) {
                // Normal case: selected index is valid
                selectEA(visibleItems[eaSelectedIndex].textContent);
            }
        } else if (e.key === 'Escape') {
            eaDropdown.style.display = 'none';
        }
    });


    function updateEAActive(visibleItems) {
        visibleItems.forEach((item, i) => {
            item.classList.toggle('active', i === eaSelectedIndex);
        });
    }

    // Hide dropdown when clicking outside
    document.addEventListener('click', function (e) {
        if (!eaInput.contains(e.target) && !eaDropdown.contains(e.target)) {
            eaDropdown.style.display = 'none';
        }
    });

</script>