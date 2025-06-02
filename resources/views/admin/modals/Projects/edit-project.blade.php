
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
                                            <label for="title" class="form-label">Project Title <span
                                                    class="text-danger">*</span></label>
                                        </div>
                                        <div class="col">
                                             <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $project['title'] ?? '') }}" required>
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
                                        <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-select form-select-sm" id="year" name="year" required>
                                            <option value="" disabled {{ old('year', $project['year'] ?? '') == '' ? 'selected' : '' }}>Select Year</option>
                                            @php
                                                $selectedYear = old('year', $project['year'] ?? '');
                                                $currentYear = date('Y');
                                            @endphp
                                            @for ($year = $currentYear; $year >= 2000; $year--)
                                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="col-md-2">
                                        <label for="fpp" class="form-label">FPP <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                    <input type="text" class="form-control" id="fpp" name="fpp" value="{{ old('fpp', $project['fpp'] ?? '') }}" required>
                                          </div>
                                </div>
                                <div class="row mb-2 g-3">
                                    <div class="col-md-3">
                                        <label for="responsibility_center" class="form-label">Responsibility Center<span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                    <input type="text" class="form-control" id="responsibility_center" name="responsibility_center" value="{{ old('responsibility_center', $project['responsibility_center'] ?? '') }}" required>
                                        </div>
                                </div>
                                <div class="row g-3 mb-2 p">
                            <div class="col-md-3">
                                <label for="location" class="form-label">Location
                                    <span class="text-danger">*</span>
                                </label>
                            </div>
                            <div class="col-md-9 position-relative">
                                <input type="text" class="form-control" id="location" name="location"
                                    value="{{ old('location', $project['location'] ?? '') }}"
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
                                <label for="description" class="form-label">Project Description<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col">
                            <textarea class="form-control" id="description" name="description" style="height: 100px">{{ old('description', isset($project['projectDescriptions']) ? implode("\n", $project['projectDescriptions']) : '') }}</textarea>
                                      
                            </div>
                        </div>
                         <!-- Contractor Input with Dynamic Suggestions -->
                         <div class="row g-3 mb-2 p">
                            <div class="col-md-3">
                                <label for="firm_name" class="form-label">Contractor <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9 position-relative">
                                <input type="text" class="form-control" id="firm_name" name="firm_name"
                                    placeholder="Select or enter contractor name" autocomplete="off"
                                    value="{{ old('firm_name', $project['firm_name'] ?? '') }}"
                                    oninput="filterAndReorderContractors()" onfocus="filterAndReorderContractors()">

                                <!-- Container for dynamically inserted buttons -->
                                <div id="projectContractorDropdown"
                                    class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                    style="display: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                                </div>
                            </div>
                        </div>

                            <!-- <div class="mb-2">
                                <label for="firm_name" class="form-label">Contractor <span
                                        class="text-danger">*</span></label>
                                <select id="firm_name" name="firm_name" class="form-select">
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
                            <label for="mode_of_implementation" class="col-3 p form-label">Mode of Implementation
                                <span class="text-danger">*</span></label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="mode_of_implementation" name="mode_of_implementation" value="{{ old('mode_of_implementation', $project['mode_of_implementation'] ?? '') }}" readonly>
                            </div>
                        </div>

                        
                        <div class="row mb-2 g-3">
                            <div class="col-md-3 p">
                                <label for="source_of_funds" class="form-label">Source of Fund <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-md-9 position-relative">
                                <input type="text" class="form-control" id="source_of_funds" name="source_of_funds"
                                    placeholder="Select or enter source" autocomplete="off"
                                    oninput="filterFunds()" onfocus="showFundsDropdown()" onblur="hideFundsDropdownDelayed()" value="{{ old('source_of_funds', $project['source_of_funds'] ?? '') }}" required>

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
                                    <div class="col-md-3 p">
                                        <label for="contractDays" class="form-label">Contract Days (Calendar days) <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <input type="number" class="form-control" id="contract_days" name="contract_days" min="0" value="{{ old('contract_days', $project['contract_days'] ?? '') }}">
                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row mb-2 align-items-center">
                            <div class="col-md-12 ">
                                <div class="row align-items-center">
                                    <div class="col-md-3 p">
                                        <label for="physical_status" class="form-label">Status <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 d-flex gap-2">
                                        <select id="physical_status" name="physical_status" class="form-select"
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
                                    <label for="ongoing_status" class="form-label">Please specify percentage
                                        completion </label>

                                    <div class="d-flex gap-2">
                                        <input type="text" id="ongoing_status" name="ongoing_status"
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
                                            <label for="project_slippage" class="form-label">Slippage</label>
                                    </div>
                                    <div class="col-md-9">
                                            <input type="number" class="form-control" id="project_slippage" name="project_slippage"  value="{{ old('project_slippage', $project['project_slippage'] ?? '') }}"
                                            placeholder="Enter slippage">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <!-- Actual length-->
                            <div class="col-3 p">
                                <label for="actual_length" class="form-label">Actual Length:</label>
                            </div>
                            <div class="col-9">
                                <input type="text" class="form-control" id="actual_length" name="actual_length" value="{{ old('actual_length', $project['actual_length'] ?? '') }}"
                                    placeholder="Enter projects actual length">
                            </div>
                        </div>

                        <div class="row">
                            <!-- Engineer Assigned (E.A) with Datalist -->
                            <div class="col-3 p">
                                <label for="engineer_name" class="form-label">Project Engineer</label>
                            </div>
                            <div class="col-md-4 position-relative">
                                        <input type="text" class="form-control" id="engineer_name" name="engineer_name"
                                         placeholder="Select or enter engineer name" autocomplete="off" value="{{ old('engineer_name', $project['engineer_name'] ?? '') }}">
                                        <div id="projectEngineerDropdown"
                                            class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                            style="display: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                                        </div>
                                     </div>

                            <div class="col-1 p">
                                <label for="engineer_position" class="form-label">Position<span
                                        class="text-danger">*</span></label>
                            </div>
                            <div class="col-4">
                                <select class="form-select" id="engineer_position" name="engineer_position" required>
                                    <option value="" disabled {{ old('engineer_position', $project['engineer_position'] ?? '') == '' ? 'selected' : '' }}>Select Position</option>
                                    <option value="Engineer Aide" {{ old('engineer_position', $project['engineer_position'] ?? '') == 'Engineer Aide' ? 'selected' : '' }}>Engineer Aide</option>
                                    <option value="Engineer Assistant" {{ old('engineer_position', $project['engineer_position'] ?? '') == 'Engineer Assistant' ? 'selected' : '' }}>Engineer Assistant</option>
                                    <option value="Engineer I" {{ old('engineer_position', $project['engineer_position'] ?? '') == 'Engineer I' ? 'selected' : '' }}>Engineer I</option>
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
                                                id="appropriation" value="{{ old('orig_appropriation', $project['funds']['orig_appropriation'] ?? '') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-3 ">
                                <label for="abc" class="form-label">ABC</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input type="text" class="form-control currency-input" id="abc" name="abc" value="{{ old('abc', $project['funds']['orig_abc'] ?? '') }}">
                                </div>
                            </div>

                            
                            <div class="col-3 ">
                                <label for="engineering" class="form-label">Engineering</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input type="text" class="form-control currency-input" id="engineering"
                                        name="engineering" value="{{ old('orig_engineering', $project['funds']['orig_engineering'] ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-3 ">
                                <label for="orig_contract_amount" class="form-label">Contract Amount</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input type="text" class="form-control currency-input" id="orig_contract_amount"
                                        name="orig_contract_amount" value="{{ old('orig_contract_amount', $project['funds']['orig_contract_amount'] ?? '') }}">
                                </div>
                            </div>
                            <div class="col-3 ">
                                <label for="mqc" class="form-label">MQC</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input type="text" class="form-control currency-input" id="mqc" name="mqc" value="{{ old('orig_mqc', $project['funds']['orig_mqc'] ?? '') }}">
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-3 ">
                                <label for="bid" class="form-label">Bid Difference</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input type="text" class="form-control currency-input" id="bid" name="bid" value="{{ old('orig_bid', $project['funds']['orig_bid'] ?? '') }}">
                                </div>
                            </div>
                            <div class="col-3 ">
                                <label for="bid" class="form-label">Contingency</label>
                            </div>
                            <div class="col-3">
                                <div class="input-group">
                                    <input type="text" name="contingency" class="form-control currency-input" id="contingency" value="{{ old('orig_contingency', $project['funds']['orig_contingency'] ?? '') }}">
                                </div>
                            </div>
                        </div>
               
                        <div class="row">
                            <div class="row">
                                <h6 class=" m-1 fw-bold">Notice of Award</h6>
                            </div>
                            <div class="row mb-2">
                                <div class="col-3 p">
                                    <label for="noa_issued_date" class="form-label">Issued Date</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="noa_issued_date" name="noa_issued_date" value="{{ old('noa_issued_date', $project['noa_issued_date'] ?? '') }}">
                                </div>
                                <div class="col-3 p">
                                    <label for="noa_received_date" class="form-label">Received Date</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="noa_received_date" name="noa_received_date" value="{{ old('noa_received_date', $project['noa_received_date'] ?? '') }}">
                                </div>
                            </div>

                            <div class="row">
                                <div class="row">
                                    <h6 class=" m-1 fw-bold">Notice to Proceed</h6>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3 p">
                                    <label for="ntp_issued_date" class="form-label">Issued Date</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="ntp_issued_date" name="ntp_issued_date" value="{{ old('ntp_issued_date', $project['ntp_issued_date'] ?? '') }}">
                                </div>
                                <div class="col-3 p">
                                    <label for="ntp_received_date" class="form-label">Received Date</label>
                                </div>
                                <div class="col-3">
                                <input type="date" class="form-control" id="ntp_received_date" name="ntp_received_date" value="{{ old('ntp_received_date', $project['ntp_received_date'] ?? '') }}">
                                </div>
                            </div>
                                <!-- <div class="row mb-2">
                                    <div class="col-3 p">
                                        <label for="official_starting_date" class="form-label">Official Start</label>
                                    </div>
                                    <div class="col-3">
                                    <input type="date" class="form-control" id="official_starting_date" name="official_starting_date" value="{{ old('official_starting_date', $project['official_starting_date'] ?? '') }}">
                                    </div>
                                    <div class="col-3 p">
                                        <label for="target_completion_date" class="form-label">Target Completion Date</label>
                                    </div>
                                    <div class="col-3">
                                    <input type="date" class="form-control" id="target_completion_date" name="target_completion_date" value="{{ old('target_completion_date', $project['target_completion_date'] ?? '') }}">
                                    </div>
                                </div> -->


                                <!-- <div class="row mb-2">
                                    <div class="col-3 p">
                                        <label for="actual_completion_date" class="form-label">Completion Date</label>
                                    </div>
                                    <div class="col-3">
                                    <input type="date" class="form-control" id="actual_completion_date" name="actual_completion_date" value="{{ old('actual_completion_date', $project['actual_completion_date'] ?? '') }}">
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
                                    <label for="mode_of_implementation" class="col-3 p form-label">Mode of Implementation
                                        <span class="text-danger">*</span></label>
                                    <div class="col-9">
                                        <input type="text" class="form-control" id="mode_of_implementation"
                                            name="mode_of_implementation" value="By contract." readonly required>
                                    </div>
                                </div>

                                <!-- Starting and Completion Dates -->
                                <div class="row mb-2 align-items-center">
                                    <div class="col-3 p">
                                        <label class="form-label">Target Starting Date <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="official_starting_date" name="official_starting_date"
                                            value="{{ old('official_starting_date', $project['official_starting_date'] ?? '') }}">
                                    </div>
                                    <div class="col-3 p">
                                        <label class="form-label">Target Completion Date <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="target_completion_date" name="target_completion_date"
                                            value="{{ old('target_completion_date', $project['target_completion_date'] ?? '') }}">
                                    </div>
                                </div>
                                <!-- <div class="row mb-2">
                                        <div class="col-3 mb-2 p">
                                            <label class="form-label">Actual Date of Completion <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-9">
                                            <input type="date" class="form-control" id="actual_completion_date" name="actual_completion_date"
                                                value="{{ old('actual_completion_date', $project['actual_completion_date'] ?? '') }}"
                                                style="background-color: lightgray;">
                                        </div>
                                    </div> -->

                                

                                    <div class="row">
                                        <!-- Order pair container -->
                                        <div id="orderContainer" class="col-12 ">
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

                                            @if ($orders->isEmpty())
                                                @php $orders = collect([[
                                                    'index' => 1,
                                                    'suspensionKey' => 'suspensionOrderNo1',
                                                    'resumeKey' => 'resumeOrderNo1',
                                                    'suspensionValue' => old('suspensionOrderNo1', ''),
                                                    'resumeValue' => old('resumeOrderNo1', '')
                                                ]]); @endphp
                                            @endif

                                            @foreach ($orders as $order)
                                                <div class="row order-set">
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
                                                               Reason for Suspension
                                                            </label>
                                                        </div>
                                                        <div class="col-9">
                                                            <textarea class="form-control"
                                                                id="suspensionOrderNo{{ $order['index'] }}Remarks"
                                                                name="suspensionOrderNo{{ $order['index'] }}Remarks">{{ trim($remarksData[(string) $order['index']]['suspensionOrderRemarks'] ?? '') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
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
                                        <div class="col-3 ">
                                            <label for="timeExtension" class="form-label">Number of Days Extensions
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input type="number" class="form-control" id="timeExtension"
                                                name="timeExtension"
                                                value="{{ old('timeExtension', $project['timeExtension'] ?? '') }}">
                                        </div>
                                    </div>
                                    <div id="newDatesSection" class="row mb-2" style="display: none;">
                                        <div class="col-3 text-end">
                                            <label for="revised_target_date" class="form-label">New Target Completion Date</label>
                                        </div>                        
                                        <div class="col-3">
                                            <input type="date" class="form-control" id="revised_target_date" name="revised_target_date"  value="{{ old('revised_target_date', $project['revised_target_date'] ?? '') }}">
                                        </div>
                                        <div class="col-3 text-end">
                                            <label for="revisedCompletionDate" class="form-label">Actual Completion Date</label>
                                        </div>                        
                                        <div class="col-3">
                                            <input type="date" class="form-control" id="revisedCompletionDate" name="revisedCompletionDate" value="{{ old('revisedCompletionDate', $project['revisedCompletionDate'] ?? '') }}">
                                        </div>
                                    </div>

                                    <!-- Actual Completion Date (Default View) -->
                                    <div id="actualCompletionSection" class="row mb-2">
                                        <div class="col-3 mb-2">
                                            <label class="form-label">Actual Date of Completion <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-9">
                                            <input type="date" class="form-control" id="actual_completion_date" name="actual_completion_date"
                                                value="{{ old('actual_completion_date', $project['actual_completion_date'] ?? '') }}"
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
    <script id="contractor-data" type="application/json">
        {!! json_encode($contractors->pluck('name')) !!}
    </script>
    <script id="engineer-data" type="application/json">
    {!! json_encode($projectEA->pluck('engineer_name')->map(fn($engineer_name) => trim($engineer_name))->values()) !!}
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