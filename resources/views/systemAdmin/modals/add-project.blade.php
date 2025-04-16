        <!-- Add Project Modal -->
        <div class="modal fade" id="addNewProjectModal" tabindex="-1" aria-labelledby="addNewProjectLabel" aria-hidden="true">
            <div class="modal-dialog  modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="appNewProjectLabel">Add Project</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('projects.addProject') }}" id="addProjectForm" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-1">
                                        <label for="projectTitle" class="form-label">Project Title</label>
                                        <textarea class="form-control" id="projectTitle" name="projectTitle" rows="2"
                                            placeholder="Enter project title." required></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-1">
                                            <label for="projectDescription" class="form-label">Project Description</label>
                                            <textarea class="form-control" id="projectDescription" name="projectDescription"
                                                rows="3" placeholder="Enter project description."></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label for="projectID" class="form-label">Project ID</label>
                                            <input type="text" class="form-control" id="projectID" name="projectID" -
                                                placeholder="Enter Project ID." required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-1">
                                            <label for="ea" class="form-label">Project E.A</label>
                                            <input type="text" class="form-control" id="ea" name="ea" placeholder="Enter E.A">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="projectLoc">Location:</label>
                                        <select id="projectLoc" name="projectLoc" class="form-select" required>
                                            <option value="">All Locations</option>
                                            <option value="Alfonso Castañeda, Nueva Vizcaya">Alfonso Castañeda, Nueva Vizcaya
                                            </option>
                                            <option value="Ambaguio, Nueva Vizcaya">Ambaguio, Nueva Vizcaya</option>
                                            <option value="Aritao, Nueva Vizcaya">Aritao, Nueva Vizcaya</option>
                                            <option value="Bagabag, Nueva Vizcaya">Bagabag, Nueva Vizcaya</option>
                                            <option value="Bambang, Nueva Vizcaya">Bambang, Nueva Vizcaya</option>
                                            <option value="Bayombong, Nueva Vizcaya">Bayombong, Nueva Vizcaya</option>
                                            <option value="Diadi, Nueva Vizcaya">Diadi, Nueva Vizcaya</option>
                                            <option value="Dupax del Norte, Nueva Vizcaya">Dupax del Norte, Nueva Vizcaya
                                            </option>
                                            <option value="Dupax del Sur, Nueva Vizcaya">Dupax del Sur, Nueva Vizcaya</option>
                                            <option value="Kasibu, Nueva Vizcaya">Kasibu, Nueva Vizcaya</option>
                                            <option value="Kayapa, Nueva Vizcaya">Kayapa, Nueva Vizcaya</option>
                                            <option value="Quezon, Nueva Vizcaya">Quezon, Nueva Vizcaya</option>
                                            <option value="Santa Fe, Nueva Vizcaya">Santa Fe, Nueva Vizcaya</option>
                                            <option value="Solano, Nueva Vizcaya">Solano, Nueva Vizcaya</option>
                                            <option value="Villaverde, Nueva Vizcaya">Villaverde, Nueva Vizcaya</option>
                                        </select>
                                    </div>
                                    <div class="mb-1">
                                        <label for="projectContractor" class="form-label">Contractor</label>
                                        <select id="projectContractor" name="projectContractor" class="form-select">
                                            <option value="">--Select Contractor--</option>
                                            @foreach($contractors as $contractor)
                                                <option value="{{ $contractor->name }}">{{ $contractor->name }}</option>
                                            @endforeach
                                            <option value="Others">Others: (Specify)</option>
                                        </select>
                                    </div>

                                    <!-- Hidden textbox for specifying 'Others' -->
                                    <div class="mb-1" id="othersContractorDiv" style="display: none;">
                                        <label for="othersContractor" class="form-label">Specify New Contractor</label>
                                        <input type="text" class="form-control" id="othersContractor" name="othersContractor"
                                            placeholder="Enter new contractor name">
                                    </div>

                                    <div class="mb-1">
                                        <label for="modeOfImplementation" class="form-label">Mode of Implementation</label>
                                        <input type="text" class="form-control" id="modeOfImplementation"
                                            name="modeOfImplementation" placeholder="Enter mode of implementation."
                                            value="By contract">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="sourceOfFunds" class="form-label">Source of Fund</label>
                                        <select id="sourceOfFunds" name="sourceOfFunds" class="form-select"
                                            onchange="toggleOtherFund()">
                                            <option value="">-- --</option>
                                            <option value="Wages">Wages</option>
                                            <option value="% Mobilization">15% Mobilization</option>
                                            <option value="Trust Fund">Trust Fund</option>
                                            <option value="Final Billing">Final Billing</option>
                                            <option value="Others">Others</option>
                                        </select>

                                        <!-- Hidden text input for 'Others' -->
                                        <div id="otherFundContainer" class="mt-2" style="display: none;">
                                            <label for="otherFund" class="form-label">Please specify:</label>
                                            <input type="text" id="otherFund" name="otherFund" class="form-control"
                                                placeholder="Enter fund source">
                                        </div>
                                    </div>

                                    <div class="mb-1">
                                        <label for="projectStatus" class="form-label">Status</label>
                                        <select id="projectStatus" name="projectStatus" class="form-select"
                                            onchange="toggleOngoingStatus()">
                                            <option value="---">---</option>
                                            <option value="Ongoing">Ongoing</option>
                                            <option value="Completed">Completed</option>
                                            <option value="Cancelled">Discontinued</option>
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
                                    <div class="mb-1">
                                        <label for="projectSlippage" class="form-label">Slippage</label>
                                        <input type="text" class="form-control" id="projectSlippage" name="projectSlippage"
                                            placeholder="Enter slippage">
                                    </div>
                                </div>
                            </div>

                            <hr class="w-50 mx-auto" style="border-color: red;">

                            <div class="row text-center">
                                <div class="row">
                                    <h6 class=" m-1 fw-bold">Contract Details</h6>
                                </div>
                            </div>

                            <hr class="w-50 mx-auto" style="border-color: red;">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="mb-1">
                                            <label for="appropriation" class="form-label">Appropriation</label>
                                            <input type="text" class="form-control currency-input" id="appropriation"
                                                name="appropriation">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-1">
                                            <label for="contractCost" class="form-label">Contract Cost</label>
                                            <input type="text" class="form-control currency-input" id="contractCost"
                                                name="contractCost">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-1">
                                            <label for="revisedContractCost" class="form-label">Revised Contract Cost</label>
                                            <input type="number" class="form-control currency-input" id="revisedContractCost"
                                                name="revisedConstractCost" min="0">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="mb-1">
                                            <label for="projectContractDays" class="form-label">Contract Days</label>
                                            <input type="number" class="form-control" id="projectContractDays"
                                                name="projectContractDays" min="0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-1">
                                            <label for="officialStart" class="form-label">Official Start</label>
                                            <input type="date" class="form-control" id="officialStart" name="officialStart">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="mb-1">
                                            <label for="targetCompletion" class="form-label">Target Completion</label>
                                            <input type="date" class="form-control" id="targetCompletion"
                                                name="targetCompletion">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="row text-center">
                                            <h6 class=" m-1 fw-bold">Notice of Award</h6>
                                        </div>
                                        <div class="mb-1">
                                            <label for="noaIssuedDate" class="form-label">Issued Date</label>
                                            <input type="date" class="form-control" id="noaIssuedDate" name="noaIssuedDate">
                                        </div>
                                        <div class="mb-1">
                                            <label for="noaReceivedDate" class="form-label">Received Date</label>
                                            <input type="date" class="form-control" id="noaReceivedDate" name="noaReceivedDate">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="row text-center">
                                            <h6 class=" m-1 fw-bold">Notice to Proceed</h6>
                                        </div>
                                        <div class="mb-1">
                                            <label for="ntpIssuedDate" class="form-label">Issued Date</label>
                                            <input type="date" class="form-control" id="ntpIssuedDate" name="ntpIssuedDate">
                                        </div>
                                        <div class="mb-1">
                                            <label for="ntpReceivedDate" class="form-label">Received Date</label>
                                            <input type="date" class="form-control" id="ntpReceivedDate" name="ntpReceivedDate">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="originalExpiryDate" class="form-label">Original Expiry Date</label>
                                    <input type="date" class="form-control" id="originalExpiryDate" name="originalExpiryDate">
                                </div>
                                <div class="col-md-6">
                                    <label for="revisedExpiryDate" class="form-label">Revised Expiry Date</label>
                                    <input type="date" class="form-control" id="revisedExpiryDate" name="revisedExpiryDate">
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="abc" class="form-label">ABC</label>
                                        <input type="text" class="form-control currency-input" id="abc" name="abc">
                                    </div>
                                    <div class="mb-1">
                                        <label for="contractAmount" class="form-label">Contract Amount</label>
                                        <input type="text" class="form-control currency-input" id="contractAmount"
                                            name="contractAmount">
                                    </div>
                                    <div class="mb-1">
                                        <label for="engineering" class="form-label">Engineering</label>
                                        <input type="text" class="form-control currency-input" id="engineering"
                                            name="engineering">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="mqc" class="form-label">MQC</label>
                                        <input type="text" class="form-control currency-input" id="mqc" name="mqc">
                                    </div>
                                    <div class="mb-1">
                                        <label for="bid" class="form-label">Contingency</label>
                                        <input type="text" class="form-control currency-input" id="contingency"
                                            name="contingency">
                                    </div>
                                    <div class="mb-1">
                                        <label for="bid" class="form-label">Bid Difference</label>
                                        <input type="text" class="form-control currency-input" id="bid" name="bid" readonly>
                                    </div>
                                </div>
                            </div>


                            <hr class="w-50 mx-auto" style="border-color: red;">

                            <div class="row text-center">
                                <div class="row">
                                    <h6 class=" m-1 fw-bold">Implementation Details</h6>
                                </div>
                            </div>

                            <hr class="w-50 mx-auto" style="border-color: red;">

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
                                            onclick="removeLastOrderFields()" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="Suspension and Resumption Order">
                                            <span class="fa-solid fa-circle-minus"></span>
                                        </button>
                                    </div>

                                    <!-- Order pair container -->
                                    <div id="orderContainer" class="col-12">
                                        <div class="row mb-3 order-set" id="orderSet1">
                                            <div class="col-md-6 mb-1">
                                                <label for="suspensionOrderNo1" class="form-label">Suspension Order No.
                                                    1</label>
                                                <input type="date" class="form-control" id="suspensionOrderNo1"
                                                    name="suspensionOrderNo1">
                                            </div>
                                            <div class="col-md-6 mb-1">
                                                <label for="resumeOrderNo1" class="form-label">Resumption Order No. 1</label>
                                                <input type="date" class="form-control" id="resumeOrderNo1"
                                                    name="resumeOrderNo1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="timeExtension" class="form-label">Time Extension</label>
                                        <input type="text" class="form-control" id="timeExtension" name="timeExtension"
                                            value="">
                                    </div>
                                    <div class="mb-1">
                                        <label for="revisedTargetCompletion" class="form-label">Revised Target
                                            Completion</label>
                                        <input type="date" class="form-control" id="revisedTargetCompletion"
                                            name="revisedTargetCompletion">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-1">
                                        <label for="completionDate" class="form-label">Completion Date</label>
                                        <input type="date" class="form-control" id="completionDate" name="completionDate">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Add Project</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Add Project Modal -->