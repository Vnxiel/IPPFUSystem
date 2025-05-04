<div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
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

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" id="projectTitle" name="projectTitle" value="{{ old('projectTitle', $project['projectTitle'] ?? '') }}" required>
                                        <label for="projectTitle">Project Title<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-floating mb-2">
                                        <input type="text" class="form-control" id="projectID" name="projectID" value="{{ old('projectID', $project['projectID'] ?? '') }}" required>
                                        <label for="projectID">Project ID<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="form-floating mb-2">
                                        <textarea class="form-control" id="projectDescription" name="projectDescription" style="height: 100px">{{ old('projectDescription', isset($project['projectDescriptions']) ? implode("\n", $project['projectDescriptions']) : '') }}</textarea>
                                        <label for="projectDescription">Project Description <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-12">
                                    <div class="form-floating mb-2 position-relative">
                                        <input type="text" class="form-control" id="projectLoc" name="projectLoc" value="{{ old('projectLoc', $project['projectLoc'] ?? '') }}" onkeyup="showMunicipalitySuggestions(this.value)" autocomplete="off" required>
                                        <label for="projectLoc">Location <span class="text-danger">*</span></label>
                                        <div id="suggestionsBox" class="list-group position-absolute w-100 shadow" style="display:none; max-height: 200px; overflow-y: auto; z-index: 1050;"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label for="projectContractor" class="form-label">Contractor <span class="text-danger">*</span></label>
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

                                    <div class="mb-2" id="othersContractorDiv" style="display: none;">
                                        <label for="othersContractor" class="form-label">Specify New Contractor</label>
                                        <input type="text" class="form-control" id="othersContractor" name="othersContractor" value="{{ old('othersContractor', $project['othersContractor'] ?? '') }}" placeholder="Enter new contractor name">
                                    </div>

                                    <div class="mb-2">
                                        <label for="modeOfImplementation" class="form-label">Mode of Implementation <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="modeOfImplementation" name="modeOfImplementation" value="{{ old('modeOfImplementation', $project['modeOfImplementation'] ?? '') }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                <div class="mb-2">
                                    <label for="sourceOfFunds" class="form-label">Source of Fund <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="sourceOfFunds" name="sourceOfFunds" value="{{ old('sourceOfFunds', $project['sourceOfFunds'] ?? '') }}"
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

                                    <!-- <div class="mb-2">
                                        <label for="projectSlippage" class="form-label">Slippage</label>
                                        <input type="text" class="form-control" id="projectSlippage" name="projectSlippage" value="{{ old('projectSlippage', $project['projectSlippage'] ?? '') }}">
                                    </div> -->
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="ea" class="form-label">Project E.A (Engineer Assigned) <span
                                                class="text-danger">*</span></label>
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" id="ea" name="ea" value="{{ old('ea', $project['ea'] ?? '') }}">
                                            <label for="ea">Fullname</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-2">
                                            <input type="text" class="form-control" id="ea_position" name="ea_position" value="{{ old('ea_position', $project['ea_position'] ?? '') }}">
                                            <label for="ea_position">Position</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-2">
                                            <input type="number" class="form-control" id="ea_monthlyRate" name="ea_monthlyRate" value="{{ old('ea_monthlyRate', $project['ea_monthlyRate'] ?? '') }}">
                                            <label for="ea_monthlyRate">Monthly Rate</label>
                                        </div>
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
                                        <div class="mb-2">
                                            <label for="appropriation" class="form-label">Appropriation <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control currency-input" id="appropriation" name="appropriation" value="{{ old('appropriation', $funds['orig_appropriation'] ?? '') }}">
                                        </div>
                                        <div class="mb-2">
                                            <label for="abc" class="form-label">ABC</label>
                                            <input type="text" class="form-control currency-input" id="abc" name="abc" value="{{ old('abc', $funds['orig_abc'] ?? '') }}">
                                        </div>
                                        <div class="mb-2">
                                            <label for="contractAmount" class="form-label">Contract Amount</label>
                                            <input type="text" class="form-control currency-input" id="contractAmount" name="contractAmount" value="{{ old('contractAmount', $funds['orig_contract_amount'] ?? '') }}">
                                        </div>
                                        <div class="mb-2">
                                            <label for="bid" class="form-label">Bid Difference</label>
                                            <input type="text" class="form-control currency-input" id="bid" name="bid" value="{{ old('bid', $funds['orig_bid'] ?? '') }}">
                                        </div>
                    
                                    </div>

                                    <div class="col-md-6">
                                        <h6 class="m-1 fw-bold">Wages:</h6>
                                        <div class="mb-2">
                                            <label for="engineering" class="form-label">Engineering</label>
                                            <input type="text" class="form-control currency-input" id="engineering" name="engineering" value="{{ old('engineering', $funds['orig_engineering'] ?? '') }}">
                                        </div>
                                        <div class="mb-2">
                                            <label for="mqc" class="form-label">MQC</label>
                                            <input type="text" class="form-control currency-input" id="mqc" name="mqc" value="{{ old('mqc', $funds['orig_mqc'] ?? '') }}">
                                        </div>
                                        <div class="mb-2">
                                            <label for="contingency" class="form-label">Contingency</label>
                                            <input type="text" class="form-control currency-input" id="contingency" name="contingency" value="{{ old('contingency', $funds['orig_contingency'] ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <h6 class="m-1 fw-bold">Notice of Award</h6>
                                    <div class="col-md-6 mb-2">
                                        <label for="noaIssuedDate" class="form-label">Issued Date</label>
                                        <input type="date" class="form-control" id="noaIssuedDate" name="noaIssuedDate" value="{{ old('noaIssuedDate', $project['noaIssuedDate'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="noaReceivedDate" class="form-label">Received Date</label>
                                        <input type="date" class="form-control" id="noaReceivedDate" name="noaReceivedDate" value="{{ old('noaReceivedDate', $project['noaReceivedDate'] ?? '') }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <h6 class="m-1 fw-bold">Notice to Proceed</h6>
                                    <div class="col-md-6 mb-2">
                                        <label for="ntpIssuedDate" class="form-label">Issued Date</label>
                                        <input type="date" class="form-control" id="ntpIssuedDate" name="ntpIssuedDate" value="{{ old('ntpIssuedDate', $project['ntpIssuedDate'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="ntpReceivedDate" class="form-label">Received Date</label>
                                        <input type="date" class="form-control" id="ntpReceivedDate" name="ntpReceivedDate" value="{{ old('ntpReceivedDate', $project['ntpReceivedDate'] ?? '') }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="officialStart" class="form-label">Official Start</label>
                                        <input type="date" class="form-control" id="officialStart" name="officialStart" value="{{ old('officialStart', $project['officialStart'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="targetCompletion" class="form-label">Target Completion Date</label>
                                        <input type="date" class="form-control" id="targetCompletion" name="targetCompletion" value="{{ old('targetCompletion', $project['targetCompletion'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="completionDate" class="form-label">Completion Date</label>
                                        <input type="date" class="form-control" id="completionDate" name="completionDate" value="{{ old('completionDate', $project['completionDate'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="revisedExpiryDate" class="form-label">Revised Completion Date</label>
                                        <input type="date" class="form-control" id="revisedExpiryDate" name="revisedExpiryDate" value="{{ old('revisedExpiryDate', $project['revisedExpiryDate'] ?? '') }}">
                                    </div>
                                    <div class="mb-2">
                                            <label for="projectContractDays" class="form-label">Contract Days (Calendar days)</label>
                                            <input type="number" class="form-control" id="projectContractDays" name="projectContractDays" min="0" value="{{ old('projectContractDays', $project['projectContractDays'] ?? '') }}">
                                        </div>
                                </div>
                            </fieldset>

                            <!-- Implementation Details Section -->
                            <fieldset class="border p-3 mb-4 rounded shadow-sm">
                                <legend class="float-none w-auto px-3 fw-bold text-primary">
                                    <i class="fas fa-info-circle me-2"></i>Implementation Details
                                </legend>

                                <div class="container">
                                    <div class="row align-items-center">
                                        <!-- Add/Remove Order Buttons -->
                                        <div class="col-md-10">
                                            <hr>
                                        </div>
                                        <div class="col-2 text-center mb-0">
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

                                        <!-- Order Fields -->
                                        <div id="orderContainer" class="col-12">
                                            @php
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
                                                <div class="row mb-2 order-set" id="orderSet{{ $order['index'] }}">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label for="{{ $order['suspensionKey'] }}" class="form-label">Suspension Order No. {{ $order['index'] }}</label>
                                                            <input type="date" class="form-control" id="{{ $order['suspensionKey'] }}" name="{{ $order['suspensionKey'] }}" value="{{ $order['suspensionValue'] }}">
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label for="suspensionOrderNo{{ $order['index'] }}Remarks" class="form-label">Remarks</label>
                                                            <input type="text" class="form-control" id="suspensionOrderNo{{ $order['index'] }}Remarks" name="suspensionOrderNo{{ $order['index'] }}Remarks">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label for="{{ $order['resumeKey'] }}" class="form-label">Resumption Order No. {{ $order['index'] }}</label>
                                                            <input type="date" class="form-control" id="{{ $order['resumeKey'] }}" name="{{ $order['resumeKey'] }}" value="{{ $order['resumeValue'] }}">
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label for="resumptionOrderNo{{ $order['index'] }}Remarks" class="form-label">Remarks</label>
                                                            <input type="text" class="form-control" id="resumptionOrderNo{{ $order['index'] }}Remarks" name="resumptionOrderNo{{ $order['index'] }}Remarks">
                                                        </div>
        
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
<!-- 
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="timeExtension" class="form-label">Time Extension</label>
                                        <input type="text" class="form-control" id="timeExtension" name="timeExtension" value="{{ old('timeExtension', $project['timeExtension'] ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <label for="revisedTargetCompletion" class="form-label">Revised Target Completion</label>
                                        <input type="text" class="form-control" id="revisedTargetCompletion" name="revisedTargetCompletion" value="{{ old('revisedTargetCompletion', $project['revisedTargetCompletion'] ?? '') }}">
                                    </div>
                                </div> -->
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

