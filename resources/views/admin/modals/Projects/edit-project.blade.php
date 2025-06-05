<!-- Edit Project Modal -->

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
                                            <textarea class="form-control" id="title" name="title" rows="3" required>{{ old('title', $project['title'] ?? '') }}</textarea>
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
                                            title="Only numbers and hyphens are allowed" value="{{ old('projectID', $project['projectID'] ?? '') }}" required>
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


                                <div class="col-md-2 ">
                                    <label for="fpp" class="form-label">FPP <span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" id="fpp" name="fpp" value="{{ old('fpp', $project['fpp'] ?? '') }}" required>
                                </div>
                            </div>
                            <div class="row mb-2 g-3 ">
                                <div class="col-md-3 ">
                                    <label for="responsibility_center" class="form-label">Responsibility Center<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" id="responsibility_center" name="responsibility_center" value="{{ old('responsibility_center', $project['responsibility_center'] ?? '') }}" required>
                                </div>
                            </div>
                            <div class="row g-3 mb-2 ">
                                <div class="col-md-3">
                                    <label for="location" class="form-label">Location of Project
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
                            <!-- Project Description -->
                            <div class="row mb-2 g-3">
                                <div class="col-3 ">
                                    <label for="description" class="form-label">Project Description<span
                                            class="text-danger">*</span></label>
                                </div>
                                <div class="col">
                                    <textarea class="form-control" id="description" name="description"
                                        rows="4" required>{{ old('description', isset($project['description']) ? implode("\n", $project['description']) : '') }}</textarea>
                                </div>
                            </div>

                            <!-- Firm Name Input with Dynamic Suggestions -->
                            <div class="row g-3 mb-2">
                                <div class="col-md-3">
                                    <label for="firm_name" class="form-label">Name of Firm <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="firm_name" name="firm_name"
                                        placeholder="Select or enter name of firm" autocomplete="off" value="{{ old('firm_name', $project['firm_name'] ?? '') }}"
                                        oninput="filterFirmNames()" onblur="finalizeFirm()" onfocus="showFirmDropdown()" required />

                                    <!-- Dropdown container -->
                                    <div id="firmDropdown"
                                        class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                        style="display: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                                        @foreach($contractors->pluck('firm_name')->unique()->sort() as $firm)
                                            <button type="button" class="list-group-item list-group-item-action"
                                                    onclick="selectFirm('{{ $firm }}')">
                                                {{ $firm }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                             <!-- Contractor Name Input with Dynamic Suggestions -->
                             <div class="row g-3 mb-2">
                                <div class="col-md-3">
                                    <label for="contractor_name" class="form-label">Contractor's Name <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="contractor_name" name="contractor_name"
                                        placeholder="Select or enter contractor name" autocomplete="off" value="{{ old('contractor_name', $project['contractor_name'] ?? '') }}"
                                        oninput="filterContractorNames()" onblur="finalizeContractorName()" onfocus="showContractorNameDropdown()" required />

                                    <!-- Dropdown container -->
                                    <div id="contractorNameDropdown"
                                        class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                        style="display: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                                        @foreach($contractors->pluck('contractor_name')->unique()->sort() as $contractor_name)
                                            <button type="button" class="list-group-item list-group-item-action"
                                                    onclick="selectContractorName('{{ $contractor_name }}')">
                                                {{ $contractor_name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3 mb-2">
                                <div class="col-md-3">
                                    <label for="contractor_address" class="form-label">
                                        Address of Contractor/Firm <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="contractor_address" name="contractor_address"
                                        placeholder="Select or enter contractor address" autocomplete="off" value="{{ old('contractor_address', $project['contractor_address'] ?? '') }}"
                                        oninput="filterContractors()" onblur="finalizeContractor()" onfocus="showContractorDropdown()" required />

                                    <!-- Dropdown container -->
                                    <div id="contractor_addressDropdown"
                                        class="list-group position-absolute w-100 shadow-sm bg-white rounded"
                                        style="display: none; max-height: 180px; overflow-y: auto; z-index: 1050;">
                                        @foreach($contractors->pluck('contractor_address')->unique()->sort() as $contractor_address)
                                            <button type="button" class="list-group-item list-group-item-action"
                                                onclick="selectContractor('{{ $contractor_address }}')">
                                                {{ $contractor_address }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-2 g-3 ">
                                <div class="col-md-3 ">
                                    <label for="source_of_funds" class="form-label">Source of Fund <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-9 position-relative">
                                    <input type="text" class="form-control" id="source_of_funds" name="source_of_funds"
                                        placeholder="Select or enter source" autocomplete="off" value="{{ old('source_of_funds', $project['source_of_funds'] ?? '') }}"
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
                                                name="contract_days" min="0"  value="{{ old('contract_days', $project['contract_days'] ?? '') }}" required>
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
                                    <input type="text" class="form-control" id="project_slippage" name="project_slippage"  value="{{ old('project_slippage', $project['project_slippage'] ?? '') }}"
                                        placeholder="Enter project slippage">
                                </div>
                            </div>
                            
                        
                            <div class="row">
                                <div class="col-md-3 ">
                                    <label for="engineer_name" class="form-label">Project Engineer <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-md-4 position-relative">
                                    <input type="text" class="form-control" id="engineer_name" name="engineer_name" value="{{ old('engineer_name', $project['engineer_name'] ?? '') }}"
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
                                                <input type="text" class="form-control currency-input" name="appropriation"
                                                    id="appropriation" value="{{ old('orig_appropriation', $project['funds']['orig_appropriation'] ?? '') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-3 ">
                                    <label for="abc" class="form-label">ABC</label>
                                </div>
                                <div class="col-3">
                                        <input type="text" class="form-control currency-input" id="abc" name="abc" value="{{ old('orig_abc', $project['funds']['orig_abc'] ?? '') }}">
                                </div>
                            
                                <div class="col-3 ">
                                    <label for="engineering" class="form-label">Engineering</label>
                                </div>
                                <div class="col-3">
                                        <input type="text" class="form-control currency-input" id="engineering"
                                            name="engineering" value="{{ old('orig_engineering', $project['funds']['orig_engineering'] ?? '') }}">
                                </div>
                            </div>

                            <div class="row mb-2">
                            
                                <div class="col-3 ">
                                    <label for="orig_contract_amount" class="form-label">Contract Amount</label>
                                </div>
                                <div class="col-3">
                                        <input type="text" class="form-control currency-input" id="orig_contract_amount"
                                            name="orig_contract_amount" value="{{ old('orig_contract_amount', $project['funds']['orig_contract_amount'] ?? '') }}">
                                </div>
                                <div class="col-3 ">
                                    <label for="mqc" class="form-label">MQC</label>
                                </div>
                                <div class="col-3">
                                        <input type="text" class="form-control currency-input" id="mqc" name="mqc" value="{{ old('orig_mqc', $project['funds']['orig_mqc'] ?? '') }}">
                                </div>
                            </div>
                            <!-- Savings = Bid Difference -->
                            <div class="row mb-2">
                                <div class="col-3 ">
                                    <label for="bid" class="form-label">Savings</label>
                                </div>
                                <div class="col-3">
                                        <input type="text" class="form-control currency-input" id="bid" name="bid" value="{{ old('orig_bid', $project['funds']['orig_bid'] ?? '') }}">
                                </div>

                                <div class="col-3 ">
                                    <label for="bid" class="form-label">Contingency</label>
                                </div>
                                <div class="col-3">
                                        <input type="text" name="contingency" class="form-control currency-input"
                                            id="contingency" value="{{ old('orig_contingency', $project['funds']['orig_contingency'] ?? '') }}">
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
                                        <input type="date" class="form-control" id="noa_issued_date" name="noa_issued_date" value="{{ old('noa_issued_date', $project['noa_issued_date'] ?? '') }}">
                                    </div>
                                    <div class="col-3 ">
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
                                    <div class="col-3 ">
                                        <label for="ntp_issued_date" class="form-label">Issued Date</label>
                                    </div>
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="ntp_issued_date" name="ntp_issued_date" value="{{ old('ntp_issued_date', $project['ntp_issued_date'] ?? '') }}">
                                    </div>
                                    <div class="col-3 ">
                                        <label for="ntp_received_date" class="form-label">Received Date</label>
                                    </div>
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="ntp_received_date" name="ntp_received_date" value="{{ old('ntp_received_date', $project['ntp_received_date'] ?? '') }}">
                                    </div>
                                </div>
                                
                            </div>
                        </fieldset>

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
                                        <input type="date" class="form-control" id="official_starting_date" name="official_starting_date" value="{{ old('official_starting_date', $project['official_starting_date'] ?? '') }}">
                                    </div>
                                    <div class="col-3 mb-2 ">
                                        <label for="" class="form-label">Target Completion Date
                                            <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-3">
                                            <input type="date" class="form-control" id="target_completion_date"
                                            name="target_completion_date" value="{{ old('target_completion_date', $project['target_completion_date'] ?? '') }}">
                                    </div>
                                </div>
                          
                                <!-- Suspension and Resumption Orders Section -->
                            <div id="orderContainer" class="col-12">
                                  <!-- Buttons for adding/removing Suspension and Resumption Orders -->
                                  <div class="row mb-3">
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addOrderFields()" 
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Add Suspension and Resumption Order">
                                    <span class="fa-solid fa-square-plus"></span>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm ms-2" onclick="removeLastOrderFields()" 
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Remove Suspension and Resumption Order">
                                    <span class="fa-solid fa-circle-minus"></span>
                                    </button>
                                </div>
                                </div>

                                <fieldset class="border p-2 mb-3" id="orderFieldset1">
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
                                    <div class="row mb-2">
                                        <div class="col-3">
                                            <label for="{{ $order['suspensionKey'] }}" class="form-label">
                                                Suspension Order No. {{ $order['index'] }}
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input type="date" class="form-control" id="{{ $order['suspensionKey'] }}"
                                                                name="{{ $order['suspensionKey'] }}" value="{{ $order['suspensionValue'] }}">
                                        </div>
                                        <div class="col-3">
                                            <label for="{{ $order['resumeKey'] }}" class="form-label">
                                                Resumption Order No. {{ $order['index'] }}
                                            </label>
                                        </div>
                                        <div class="col-3">
                                            <input type="date" class="form-control" id="{{ $order['resumeKey'] }}"
                                                name="{{ $order['resumeKey'] }}" value="{{ $order['resumeValue'] }}">
                                        </div>
                                    </div>

                                        <!-- Reason for Suspension -->
                                    <div class="row mb-2">
                                        <div class="col-3">
                                            <label for="suspensionOrderNo{{ $order['index'] }}Remarks" class="form-label">
                                                Reason for Suspension
                                            </label>
                                        </div>
                                        <div class="col-9">
                                            <textarea class="form-control"
                                                id="suspensionOrderNo{{ $order['index'] }}Remarks"
                                                name="suspensionOrderNo{{ $order['index'] }}Remarks">{{ trim($remarksData[(string) $order['index']]['suspensionOrderRemarks'] ?? '') }}</textarea>
                                        </div>
                                        <div class="invalid-feedback">Please provide a reason for the suspension/resumption.</div>
                                    </div>
                                </fieldset>
                                @endforeach
                            </div>

                              
                                <!-- Time Extension Section -->
                                <div id="timeExtensionContainer">
                                      <!-- Add & Remove Time Extension Buttons -->
                                <div class="row mb-2">
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-outline-primary btn-sm mr-1" onclick="addTimeExtension()" 
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Add Time Extension">
                                    <span class="fa-solid fa-square-plus"></span>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeLastTimeExtension()" 
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Remove Last Time Extension">
                                    <span class="fa-solid fa-circle-minus"></span>
                                    </button>
                                </div>
                                </div>
                                    @if ($timeExtensions->isEmpty())
                                        <!-- Default empty fieldset when no extensions exist -->
                                        <fieldset class="border p-2 mb-2" id="extensionFieldset1">
                                            <legend class="float-none w-auto px-2 small">Time Extension 1</legend>
                                            <div class="row" id="extensionRow1">
                                                <div class="col-3">
                                                    <label for="timeExtension1" class="form-label">No. of Days of Extension</label>
                                                </div>
                                                <div class="col-3">
                                                    <input type="number" class="form-control" id="timeExtension1" name="timeExtension1" onchange="calculateRevisedExpiry()">
                                                </div>
                                                <div class="col-3">
                                                    <label for="extensionReason1" class="form-label">Reason for Extension</label>
                                                </div>
                                                <div class="col-3">
                                                    <input type="text" class="form-control" id="extensionReason1" name="extensionReason1">
                                                </div>
                                                <div class="col-3 mt-2">
                                                    <label for="revisedExpiry1" class="form-label">Revised Expiry Date</label>
                                                </div>
                                                <div class="col-3 mt-2">
                                                    <input type="date" class="form-control" id="revisedExpiry1" name="revisedExpiry1" readonly>
                                                </div>
                                                <!-- <div class="col-3 mt-2">
                                                    <label for="revisedReason1" class="form-label">Reason for Revised Expiry</label>
                                                </div>
                                                <div class="col-3 mt-2">
                                                    <input type="text" class="form-control" id="revisedReason1" name="revisedReason1">
                                                </div> -->
                                            </div>
                                        </fieldset>
                                    @else
                                        <!-- Loop through existing time extensions -->
                                        @foreach ($timeExtensions as $index => $extension)
                                            <fieldset class="border p-2 mb-2" id="extensionFieldset{{ $index + 1 }}">
                                                <legend class="float-none w-auto px-2 small">Time Extension {{ $index + 1 }}</legend>
                                                <div class="row" id="extensionRow{{ $index + 1 }}">
                                                    <div class="col-3">
                                                        <label for="timeExtension{{ $index + 1 }}" class="form-label">No. of Days of Extension</label>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="number" class="form-control"
                                                            id="timeExtension{{ $index + 1 }}"
                                                            name="timeExtension{{ $index + 1 }}"
                                                            value="{{ $extension->time_extension }}"
                                                            onchange="calculateRevisedExpiry()">
                                                    </div>
                                                    <div class="col-3">
                                                        <label for="extensionReason{{ $index + 1 }}" class="form-label">Reason for Extension</label>
                                                    </div>
                                                    <div class="col-3">
                                                        <input type="text" class="form-control"
                                                            id="extensionReason{{ $index + 1 }}"
                                                            name="extensionReason{{ $index + 1 }}"
                                                            value="{{ $extension->time_extension_reason }}">
                                                    </div>
                                                    <div class="col-3 mt-2">
                                                        <label for="revisedExpiry{{ $index + 1 }}" class="form-label">Revised Expiry Date</label>
                                                    </div>
                                                    <div class="col-3 mt-2">
                                                        <input type="date" class="form-control"
                                                            id="revisedExpiry{{ $index + 1 }}"
                                                            name="revisedExpiry{{ $index + 1 }}"
                                                            value="{{ $extension->revised_expiry }}"
                                                            readonly>
                                                    </div>
                                                    <!-- <div class="col-3 mt-2">
                                                        <label for="revisedReason{{ $index + 1 }}" class="form-label">Reason for Revised Expiry</label>
                                                    </div>
                                                    <div class="col-3 mt-2">
                                                        <input type="text" class="form-control"
                                                            id="revisedReason{{ $index + 1 }}"
                                                            name="revisedReason{{ $index + 1 }}"
                                                            value="{{ $extension->revised_expiry_reason }}">
                                                    </div> -->
                                                </div>
                                            </fieldset>
                                        @endforeach
                                    @endif
                                </div>


                               <!-- New Target and Completion Dates -->
                               <div id="newDatesSection" class="row mb-2" style="display: none;">
                                    <div class="col-3">
                                        <label for="revised_target_date" class="form-label">New Target Completion Date</label>
                                    </div>
                                    <div class="col-3">
                                        <input type="date" class="form-control" id="revised_target_date" name="revised_target_date">
                                    </div>
                                    <!-- <div class="col-3">
                                        <label for="revisedCompletionDate " class="form-label">Actual Completion Date</label>
                                    </div>
                                    <div class="col-3 mb-2">
                                        <input type="date" class="form-control" id="revisedCompletionDate " name="revisedCompletionDate">
                                    </div>
                                    Actual Length inside newDatesSection but initially hidden
                                    <div class="col-3  actual-length-label" style="display:none;">
                                        <label for="actual_length_new" class="form-label">Actual Length:</label>
                                    </div>
                                    <div class="col-4 actual-length-input" style="display:none;">
                                        <input type="text" class="form-control" id="actual_length_new" name="actual_length"
                                            placeholder="Enter project's actual length">
                                    </div> -->
                                </div>

                                <div class="row" id="completionSection">
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
                                        <div class="col-2 actual-length-label">
                                            <label for="actual_length" class="form-label">Actual Length:</label>
                                        </div>
                                        <div class="col-4 actual-length-input">
                                            <input type="text" class="form-control" id="actual_length" name="actual_length" value="{{ old('actual_length', $project['actual_length'] ?? '') }}"
                                                placeholder="Enter project's actual length">
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



@section('page-scripts')
        <script src="{{ asset('js/Projects/projects-addSubmit.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-addOrder.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-suspension-remarks.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-time_extension.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-actual_date-condition.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-currencyFormatting.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-dateValidation.js') }}"></script>
       <script src="{{ asset('js/Projects/projects-restrictionsValue.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-suggestionBox.js') }}"></script>
        <script src="{{ asset('js/Projects/projects-valueCalculations.js') }}"></script>
        <script src="{{ asset('js/Filters/contractor-search.js') }}"></script>
        <script src="{{ asset('js/Filters/location-search.js') }}"></script>
        <script src="{{ asset('js/Filters/engineer-search.js') }}"></script>
        <script src="{{ asset('js/Filters/sourceOfFund-search.js') }}"></script>
        <script src="{{ asset('js/Filters/year-search.js') }}"></script>
@endsection
