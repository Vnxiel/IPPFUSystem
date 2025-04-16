<!-- Fund Utilization -->
<div class="modal fade" id="addProjectFundUtilization" tabindex="-1" aria-labelledby="addProjectFundUtilizationLabel"
    aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="appNewProjectLabel">Fund Utilization </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addFundUtilization" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-1">
                                <label for="projectTitleFU" class="form-label">Project Title</label>
                                <textarea class="form-control" id="projectTitleFU" name="projectTitleFU" rows="2"
                                    placeholder="Enter project title." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="row text-center">
                            <div class="row">
                                <h6 class=" m-1 fw-bold">Original</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="orig_abc" class="form-label">ABC</label>
                                <input type="text" class="form-control currency-input" id="orig_abc" name="orig_abc">
                            </div>
                            <div class="mb-1">
                                <label for="orig_contract_amount" class="form-label">Contract Amount</label>
                                <input type="text" class="form-control currency-input" id="orig_contract_amount"
                                    name="orig_contract_amount">
                            </div>
                            <div class="mb-1">
                                <label for="orig_engineering" class="form-label">Engineering</label>
                                <input type="text" class="form-control currency-input" id="orig_engineering"
                                    name="orig_engineering">
                            </div>
                            <div class="mb-1">
                                <label for="orig_mqc" class="form-label">MQC</label>
                                <input type="text" class="form-control currency-input" id="orig_mqc" name="orig_mqc">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="orig_bid" class="form-label">Bid Difference</label>
                                <input type="text" class="form-control currency-input" id="orig_bid" name="orig_bid">
                            </div>
                            <div class="mb-1">
                                <label for="orig_completion_date" class="form-label">Completion Date</label>
                                <input type="text" class="form-control" id="orig_completion_date" name="orig_completion_date"
                                    value="">
                            </div>
                          
                            <div class="mb-1">
                                <label for="appropriation" class="form-label">Appropriation</label>
                                <input type="text" class="form-control currency-input" id="orig_appropriation"
                                    name="orig_appropriation">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-1">
                        <div class="container">
                            <div class="row align-items-center">
                                <!-- Buttons above the order fields -->
                                <div class="col-md-10">
                                    <hr>
                                </div>
                                <div class="col-2 text-center mb-0">
                                    <button type="button" class="btn btn-outline-primary btn-sm mr-1"
                                        onclick="addVOFields()" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Add V.O.">
                                        <span class="fa-solid fa-square-plus"></span> </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="removeLastVOFields()" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Remove Last V.O.">
                                        <span class="fa-solid fa-circle-minus"></span>
                                    </button>
                                </div>
                                <!-- Order pair container -->
                                <div id="voContainer" class="col-12">
                                    <div class="row text-center">
                                        <div class="row">
                                            <h6 class=" m-1 fw-bold">V.O.1</h6>
                                        </div>
                                    </div>
                                    <div class="row mb-3 order-set" id="voSet1">
                                        <div class="col-md-6">
                                            <div class="mb-1">
                                                <label for="vo_abc" class="form-label">ABC</label>
                                                <input type="text" class="form-control currency-input" id="vo_abc"
                                                    name="vo_abc">
                                            </div>
                                            <div class="mb-1">
                                                <label for="vo_contract_amount" class="form-label">Contract
                                                    Amount</label>
                                                <input type="text" class="form-control currency-input"
                                                    id="vo_contract_amount" name="vo_contract_amount">
                                            </div>
                                            <div class="mb-1">
                                                <label for="vo_engineering" class="form-label">Engineering</label>
                                                <input type="text" class="form-control currency-input" id="vo_engineering"
                                                    name="vo_engineering">
                                            </div>
                                            <div class="mb-1">
                                                <label for="vo_mqc" class="form-label">MQC</label>
                                                <input type="text" class="form-control currency-input" id="vo_mqc"
                                                    name="vo_mqc">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-1">
                                                <label for="vow_contingency" class="form-label">Contingency</label>
                                                <input type="text" class="form-control currency-input" id="vow_contingency"
                                                    name="vow_contingency">
                                            </div>
                                            <div class="mb-1">
                                                <label for="vo_bid" class="form-label">Bid Difference</label>
                                                <input type="text" class="form-control currency-input" id="vo_bid"
                                                    name="vo_bid">
                                            </div>
                                            <div class="mb-1">
                                                <label for="vo_appropriation" class="form-label">Appropriation</label>
                                                <input type="text" class="form-control currency-input"
                                                    id="vo_appropriation" name="vo_appropriation">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="mt-2">

                    <div class="row">
                        <div class="row text-center">
                            <div class="row">
                                <h6 class=" m-1 fw-bold">Actual</h6>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="actual_abc" class="form-label">ABC</label>
                                <input type="text" class="form-control currency-input" id="actual_abc"
                                    name="actual_abc">
                            </div>
                            <div class="mb-1">
                                <label for="actual_contract_amount" class="form-label">Contract Amount</label>
                                <input type="text" class="form-control currency-input" id="actual_contract_amount"
                                    name="actual_contract_amount">
                            </div>
                            <div class="mb-1">
                                <label for="actual_engineering" class="form-label">Engineering</label>
                                <input type="text" class="form-control currency-input" id="actual_engineering"
                                    name="actual_engineering">
                            </div>
                            <div class="mb-1">
                                <label for="actual_mqc" class="form-label">MQC</label>
                                <input type="text" class="form-control currency-input" id="actual_mqc"
                                    name="actual_mqc">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-1">
                                <label for="actual_bid" class="form-label">Bid Difference</label>
                                <input type="text" class="form-control currency-input" id="actual_bid"
                                    name="actual_bid">
                            </div>
                            <div class="mb-1">
                                <label for="actual_completion_date" class="form-label">Completion Date</label>
                                <input type="text" class="form-control" id="actual_completion_date"
                                    name="actual_completion_date" value="">
                            </div>
                            <div class="mb-1">
                                <label for="actual_contingency" class="form-label">Contingency</label>
                                <input type="text" class="form-control currency-input" id="actual_contingency"
                                    name="actual_contingency">
                            </div>
                            <div class="mb-1">
                                <label for="actual_appropriation" class="form-label">Appropriation</label>
                                <input type="text" class="form-control currency-input" id="actual_appropriation"
                                    name="actual_appropriation">
                            </div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <h6 class=" m-1 fw-bold">Fund Utilization</h6>
                    </div>

                    <hr class="w-50 mx-auto" style="border-color: red;">

                    <div class="row">
                        <div class="row">
                            <h6 class=" m-1 fw-bold">15% Mobilization</h6>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-1">
                                <label for="dateMobi" class="form-label">Date</label>
                                <input type="date" class="form-control" id="dateMobi" name="dateMobi">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label for="amountMobi" class="form-label">Amount</label>
                                <input type="text" class="form-control" id="amountMobi" name="amountMobi">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-1">
                                <label for="remMobi" class="form-label">Remarks</label>
                                <input type="text" class="form-control" id="remMobi" name="remMobi">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-1">
                        <div class="container">
                            <div class="row align-items-center">
                                <!-- Buttons above the order fields -->
                                <div class="col-md-10">
                                    <hr>
                                </div>
                                <div class="col-2 text-center mb-0">
                                    <button type="button" class="btn btn-outline-primary btn-sm mr-1"
                                        onclick="addNextBilling()" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Add Billing">
                                        <span class="fa-solid fa-square-plus"></span>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-sm"
                                        onclick="removeLastBilling()" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Remove Last Billing">
                                        <span class="fa-solid fa-circle-minus"></span>
                                    </button>
                                </div>
                                <!-- Billing container -->
                                <div id="billingsContainer" class="col-12">
                                    <div class="row billing-set" id="billingSet1">
                                        <div class="row">
                                            <h6 class="m-1 fw-bold">1st Partial Billing</h6>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-1">
                                                    <label for="datePart1" class="form-label">Date</label>
                                                    <input type="date" class="form-control" id="datePart1"
                                                        name="datePart1">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-1">
                                                    <label for="amountPart1" class="form-label">Amount</label>
                                                    <input type="text" class="form-control" id="amountPart1"
                                                        name="amountPart1">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-1">
                                                    <label for="remPart1" class="form-label">Remarks</label>
                                                    <input type="text" class="form-control" id="remPart1"
                                                        name="remPart1">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <hr class="mt-2">
                                <div class="row">
                                    <div class="row">
                                        <h6 class=" m-1 fw-bold">Final Billing</h6>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-1">
                                            <label for="dateFinal" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="dateFinal" name="dateFinal">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-1">
                                            <label for="amountFinal" class="form-label">Amount</label>
                                            <input type="text" class="form-control" id="amountFinal" name="amountFinal">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-1">
                                            <label for="remFinal" class="form-label">Remarks</label>
                                            <input type="text" class="form-control" id="remFinal" name="remFinal">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="row">
                                        <h6 class=" m-1 fw-bold">Engineering</h6>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-1">
                                            <label for="dateEng" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="dateEng" name="dateEng">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-1">
                                            <label for="amountEng" class="form-label">Amount</label>
                                            <input type="text" class="form-control" id="amountEng" name="amountEng">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-1">
                                            <label for="remEng" class="form-label">Remarks</label>
                                            <input type="text" class="form-control" id="remEng" name="remEng">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="row">
                                        <h6 class=" m-1 fw-bold">MQC</h6>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-1">
                                            <label for="dateMqc" class="form-label">Date</label>
                                            <input type="date" class="form-control" id="dateMqc" name="dateMqc">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-1">
                                            <label for="amountMqc" class="form-label">Amount</label>
                                            <input type="text" class="form-control" id="amountMqc" name="amountMqc">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-1">
                                            <label for="remMqc" class="form-label">Remarks</label>
                                            <input type="text" class="form-control" id="remMqc" name="remMqc">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 text-end">
                                        <div class="mb-1 align-items-center">
                                            <h6 class="m-1 fw-bold">Total Expenditures</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-1">
                                            <label for="amountTotal" class="form-label">Amount</label>
                                            <input type="text" class="form-control" id="amountTotal" name="amountTotal">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-1">
                                            <label for="remTotal" class="form-label">Remarks</label>
                                            <input type="text" class="form-control" id="remTotal" name="remTotal">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 text-end">
                                        <div class="mb-1 align-items-center">
                                            <h6 class=" m-1 fw-bold align-items-center">Total Savings</h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-1">
                                            <label for="amountSavings" class="form-label">Amount</label>
                                            <input type="text" class="form-control" id="amountSavings"
                                                name="amountSavings">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-1">
                                            <label for="remSavings" class="form-label">Remarks</label>
                                            <input type="text" class="form-control" id="remSavings" name="remSavings">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="buttton" id="submitFundsUtilization" class="btn btn-primary">Add Fund Utilization</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>