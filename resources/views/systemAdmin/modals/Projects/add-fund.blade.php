<!-- Fund Utilization Modal -->
<div class="modal fade" id="addProjectFundUtilization" tabindex="-1" aria-labelledby="addProjectFundUtilizationLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addProjectFundUtilizationLabel">Fund Utilization</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="addFundUtilization" method="POST">
          @csrf
          <fieldset class="border p-1 mb-1 rounded shadow-sm bg-light">
              <div class="mb-3">
                  <!-- Project Title -->
                  <textarea class="form-control-plaintext border rounded p-3 bg-white text-dark fw-semibold"
                     id="projectTitleFU" name="projectTitleFU" readonly>{{ $project['projectTitle'] ?? '' }}</textarea>
              </div>
            </fieldset>
           <!-- Cost Breakdown Table -->
           <fieldset class="border p-3 mb-4 rounded">
            <legend class="float-none w-auto px-2 fw-bold">Cost Breakdown</legend>

            <div class="table-responsive">
              <table id="editableFundTable" class="table table-bordered text-center align-middle">
                <thead>
                  <tr>
                    <th>Category</th>
                    <th>Original</th>
                    <th>V.O. 1</th>
                    <th>Actual</th>
                  </tr>
                </thead>
                <tbody>
                <tr>
                   <input type="hidden" id="voCount" name="voCount" value="1">
                    <td>Appropriation</td>
                    <td>
                        <input type="text" class="form-control amount-input" id="orig_appropriation"
                            name="orig_appropriation" list="orig_appropriation_list"
                             >
                        <datalist id="orig_appropriation_list"></datalist>
                    </td>
                    <td>
                        <input type="text" class="form-control amount-input" id="vo_appropriation_1"
                            name="vo_appropriation_1" list="vo_appropriation_list"
                             >
                        <datalist id="vo_appropriation_list"></datalist>
                    </td>
                    <td>
                        <input type="text" class="form-control amount-input" id="actual_appropriation"
                            name="actual_appropriation" list="actual_appropriation_list"
                           >
                        <datalist id="actual_appropriation_list"></datalist>
                    </td>
                </tr>

                <tr>
                  <td>Contract Amount</td>
                  <td>
                    <input type="text" class="form-control amount-input" id="orig_contract_amount"
                          name="orig_contract_amount" list="orig_contract_amount_list"
                           >
                    <datalist id="orig_contract_amount_list"></datalist>
                  </td>
                  <td>
                    <input type="text" class="form-control amount-input" id="vo_contract_amount_1"
                          name="vo_contract_amount_1" list="vo_contract_amount_list"
                           >
                    <datalist id="vo_contract_amount_list"></datalist>
                  </td>
                  <td>
                    <input type="text" class="form-control amount-input" id="actual_contract_amount"
                          name="actual_contract_amount" list="actual_contract_amount_list"
                           >
                    <datalist id="actual_contract_amount_list"></datalist>
                  </td>
                </tr>
                <tr>  
                    <td>ABC</td>
                    <td><input type="text" class="form-control amount-input" id="orig_abc" name="orig_abc" 
                        ></td>
                    <td><input type="text" class="form-control amount-input" id="vo_abc_1" name="vo_abc_1" 
                        ></td>
                    <td><input type="text" class="form-control amount-input" id="actual_abc" name="actual_abc" 
                        ></td>
                  </tr>
                  <tr>
                    <td>Bid Difference</td>
                    <td><input type="text" class="form-control amount-input" id="orig_bid" name="orig_bid" 
                        ></td>
                    <td><input type="text" class="form-control amount-input" id="vo_bid_1" name="vo_bid_1" 
                        ></td>
                    <td><input type="text" class="form-control amount-input" id="actual_bid" name="actual_bid" 
                        ></td>
                  </tr>
                  <tr>
                    <td>Engineering</td>
                    <td><input type="text" class="form-control amount-input" id="orig_engineering" 
                        name="orig_engineering" ></td>
                    <td><input type="text" class="form-control amount-input" id="vo_engineering_1" 
                        name="vo_engineering_1" ></td>
                    <td><input type="text" class="form-control amount-input" id="actual_engineering" 
                        name="actual_engineering" ></td>
                  </tr>
                  <tr>
                    <td>MQC</td>
                    <td><input type="text" class="form-control amount-input" id="orig_mqc" name="orig_mqc"
                        ></td>
                    <td><input type="text" class="form-control amount-input" id="vo_mqc_1" name="vo_mqc_1" 
                        ></td>
                    <td><input type="text" class="form-control amount-input" id="actual_mqc" name="actual_mqc" 
                        ></td>
                  </tr>
                  <tr>
                    <td>Contingency</td>
                    <td><input type="text" class="form-control amount-input" id="orig_contingency" 
                        name="orig_contingency" ></td>
                    <td><input type="text" class="form-control amount-input" id="vo_contingency_1" 
                        name="vo_contingency_1" ></td>
                    <td><input type="text" class="form-control amount-input" id="actual_contingency" 
                        name="actual_contingency" ></td>
                  </tr>
                </tbody>
              </table>
            </div>

            
          </fieldset>


          <div class="text-end mt-2">
            <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="addVOFields()">
              <i class="fa-solid fa-square-plus"></i> Add V.O.
            </button>
          </div>
          </fieldset>

          <!-- Fund Utilization Summary Table -->
          <fieldset class="border p-3 mb-4 rounded">
            <legend class="float-none w-auto px-2 fw-bold">Fund Utilization Summary</legend>
            <!-- <div class="mb-2 row align-element-center">
              <div class="row">
                <div class="table-responsive">
                  <table id="editableFundTable" class="table table-bordered text-center align-middle">
                    <thead>
                      <th>Contract amount</th>
                    </thead>
                  </table>
                 </div>
              </div> -->
            <!-- </div> -->
            <div class="row mb-1">
              <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                  <thead>
                    <tr>
                      <th colspan="3">
                        <strong>Contract Amount</strong>
                      </th>
                      <th colspan="2" class="text-end">
                        ---
                      </th>
                    </tr>                    
                  </thead>
                  <tr>
                    <tr>
                      <td>15% Mobilization</td>
                      <td><input type="date" class="form-control" name="datePart1"></td>
                      <td colspan="2">
                        <input type="number" max="15" min="0" class="form-control" id="percentMobi" name="percentMobi" placeholder="0.00">
                      </td>
                      <td><input type="text" class="form-control" name="remPart1" placeholder="Remarks"></td>
                    </tr>
                   <tr accesskey="billsTableBody">
                      <td>1st Partial Billing</td>
                      <td><input type="date" class="form-control" name="datePart1"></td>
                      <td colspan="2"><input type="text" class="form-control amount-input" name="amountPart1"></td>
                      <td><input type="text" class="form-control" name="remPart1"></td>                        
                    </tr>
                    <tr>
                      <td colspan="5" class="text-end">
                        <div class="text-end mt-2">
                          <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="addNewBill()">
                            <i class="fa-solid fa-square-plus"></i> Add Billing
                          </button>
                          <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeLastBill()">
                            <i class="fa-solid fa-circle-minus"></i> Remove Billing
                          </button>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Final Billing</td>
                      <td><input type="date" class="form-control" name="dateFinal"></td>
                      <td><input type="text" class="form-control amount-input" name="amountFinal" >
                      </td>
                      <td><input type="text" class="form-control" name="remFinal"></td>
                    </tr>
                    <tr>
                      <th colspan="2">
                        Balance
                      </th>
                      <td colspan="3">
                        ---
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="row mb-1">
              <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                  <thead>
                    <tr>
                      <th colspan="3">
                        <strong>Engineering</strong>
                      </th>
                      <th colspan="2" class="text-end">
                        ---
                      </th>
                    </tr>                    
                  </thead>
                  <tr>
                    <td colspan="5">Breakdown</td>
                  </tr>
                  <tr>
                    <tr>
                      <td><input type="date" class="form-control" name=""></td>
                      <td colspan="2"><input type="text" class="form-control" id="" name="" placeholder="Name of Receiver"></td>
                      <td colspan="2">
                        <input type="number" max="15" min="0" class="form-control" id="" name="" placeholder="0.00">
                      </td>
                    </tr>
                      <td colspan="5" class="text-end">
                          <div class="text-end mt-2">
                            <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="addEngineeringBreakdown()">
                              <i class="fa-solid fa-square-plus"></i> Add 
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeEngineeringBreakdown()">
                              <i class="fa-solid fa-circle-minus"></i> Remove
                            </button>
                          </div>
                      </td>
                    </tr>
                    <tr>
                      <th colspan="2">
                        Balance
                      </th>
                      <td colspan="3">
                        ---
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row mb-1">
              <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                  <thead>
                    <tr>
                      <th colspan="3">
                        <strong>MQC</strong>
                      </th>
                      <th colspan="2" class="text-end">
                        ---
                      </th>
                    </tr>                    
                  </thead>
                  <tr>
                    <td colspan="5">Breakdown</td>
                  </tr>
                  <tr>
                    <tr>
                      <td><input type="date" class="form-control" name=""></td>
                      <td colspan="2"><input type="text" class="form-control" id="" name="" placeholder="Name of Receiver"></td>
                      <td colspan="2">
                        <input type="number" max="15" min="0" class="form-control" id="" name="" placeholder="0.00">
                      </td>
                    </tr>
                      <td colspan="5" class="text-end">
                          <div class="text-end mt-2">
                            <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="addMQCBreakdown()">
                              <i class="fa-solid fa-square-plus"></i> Add 
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeMQCBreakdown()">
                              <i class="fa-solid fa-circle-minus"></i> Remove
                            </button>
                          </div>
                      </td>
                    </tr>
                    <tr>
                      <th colspan="2">
                        Balance
                      </th>
                      <td colspan="3">
                        ---
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <div class="row mb-1">
              <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                  <thead>
                    <tr>
                      <th colspan="3">
                        <strong>Contingency</strong>
                      </th>
                      <th colspan="2" class="text-end">
                        ---
                      </th>
                    </tr>                    
                  </thead>
                  <tr>
                    <td colspan="5">Breakdown</td>
                  </tr>
                  <tr>
                    <tr>
                      <td><input type="date" class="form-control" name=""></td>
                      <td colspan="2"><input type="text" class="form-control" id="" name="" placeholder="Name of Receiver"></td>
                      <td colspan="2">
                        <input type="number" max="15" min="0" class="form-control" id="" name="" placeholder="0.00">
                      </td>
                    </tr>
                      <td colspan="5" class="text-end">
                          <div class="text-end mt-2">
                            <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="addContingencyBreakdown()">
                              <i class="fa-solid fa-square-plus"></i> Add 
                            </button>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeContingencyBreakdown()">
                              <i class="fa-solid fa-circle-minus"></i> Remove
                            </button>
                          </div>
                      </td>
                    </tr>
                    <tr>
                      <th colspan="2">
                        Balance
                      </th>
                      <td colspan="3">
                        ---
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="row mb-1">
              <div class="table-responsive">
                <table class="table table-bordered text-center align-middle">
                  <tr class="fw-bold">
                    <td>Total Expenditures</td>
                    <td colspan="4"><input type="text" class="form-control amount-input" name="amountTotal" disabled>
                    </td>
                  </tr>
                  <tr class="fw-bold">
                    <td>Total Savings</td>
                    <td colspan="4"><input type="text" class="form-control amount-input" name="amountSavings"  disabled>
                    </td>
                  </tr>
                </table>
              </div>
            </div>
<!-- <hr>
<br>
            
            <div class="mb-2 row align-items-center">
              <div class="col-md-2">
                <label for="percentMobi" class="form-label fw-bold">% Mobilization</label>
              </div>
              <div class="col-md-3">
              <input type="number" max="15" min="0" class="form-control" id="percentMobi" name="percentMobi" placeholder="0.00">
              </div>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered text-center align-middle">
                <thead>
                  <tr>
                    <th>Category</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Remarks</th>
                  </tr>
                </thead>
                <tbody>
                <tbody id="mobilizationRows">-->
                  <!-- JavaScript will populate mobilization rows here -->
                <!---</tbody>
          
                <tbody id="billingsTableBody">
                  <tr>
                  <td>1st Partial Billing</td>
                  <td><input type="date" class="form-control" name="datePart1"></td>
                  <td><input type="text" class="form-control amount-input" name="amountPart1" >
                  </td>
                  <td><input type="text" class="form-control" name="remPart1"></td>
                  </tr>
                </tbody>
                <tbody>
                  <tr>
                    <td>Final Billing</td>
                    <td><input type="date" class="form-control" name="dateFinal"></td>
                    <td><input type="text" class="form-control amount-input" name="amountFinal" >
                    </td>
                    <td><input type="text" class="form-control" name="remFinal"></td>
                  </tr>
                  <tr>
                    <td>Engineering</td>
                    <td><input type="date" class="form-control" name="dateEng"></td>
                    <td><input type="text" class="form-control amount-input" name="amountEng"  disabled></td>
                    <td><input type="text" class="form-control" name="remEng"></td>
                  </tr>
                  <tr>
                    <td>MQC</td>
                    <td><input type="date" class="form-control" name="dateMqc"></td>
                    <td><input type="text" class="form-control amount-input" name="amountMqc"  disabled></td>
                    <td><input type="text" class="form-control" name="remMqc"></td>
                  </tr>
                  <tr class="fw-bold">
                    <td>Total Expenditures</td>
                    <td></td>
                    <td><input type="text" class="form-control amount-input" name="amountTotal" disabled>
                    </td>
                    <td><input type="text" class="form-control" name="remTotal"></td>
                  </tr>
                  <tr class="fw-bold">
                    <td>Total Savings</td>
                    <td></td>
                    <td><input type="text" class="form-control amount-input" name="amountSavings"  disabled>
                    </td>
                    <td><input type="text" class="form-control" name="remSavings"></td>
                  </tr>
                </tbody>
              </table>
            </div> -->

            <!-- <div class="text-end mt-2">
              <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="addNextBilling()">
                <i class="fa-solid fa-square-plus"></i> Add Billing
              </button>
              <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeLastBilling()">
                <i class="fa-solid fa-circle-minus"></i> Remove Billing
              </button>
            </div> -->
          </fieldset>

          <!-- Modal Footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="submitFundsUtilization" class="btn btn-primary">Save Fund Utilization</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
  function parseCurrency(value) {
    return parseFloat((value || '0').replace(/[₱,]/g, '')) || 0;
  }

  function showError(fieldLabel) {
    Swal.fire({
      icon: 'error',
      title: 'Limit Exceeded',
      text: `${fieldLabel} exceeds the Original Appropriation!`
    });
  }

  const fieldGroups = [
    { label: 'ABC', ids: ['orig_abc', 'vo_abc_1', 'actual_abc'] },
    { label: 'Contract Amount', ids: ['orig_contract_amount', 'vo_contract_amount_1', 'actual_contract_amount'] },
    { label: 'Engineering', ids: ['orig_engineering', 'vo_engineering_1', 'actual_engineering'] },
    { label: 'MQC', ids: ['orig_mqc', 'vo_mqc_1', 'actual_mqc'] },
    { label: 'Contingency', ids: ['orig_contingency', 'vo_contingency_1', 'actual_contingency'] },
    { label: 'Bid Difference', ids: ['orig_bid', 'vo_bid_1', 'actual_bid'] },
    { label: 'Appropriation', ids: ['vo_appropriation_1', 'actual_appropriation'] } // Note: 'orig_appropriation' is the base limit
  ];

  fieldGroups.forEach(group => {
    group.ids.forEach(id => {
      const input = document.getElementById(id);
      if (input) {
        input.addEventListener('blur', function () {
          const appropriationValue = parseCurrency(document.getElementById('orig_appropriation').value);
          const inputValue = parseCurrency(input.value);

       
          if (inputValue > appropriationValue) {
            console.warn(`✖ ${group.label} [${id}] exceeds appropriation`);
            showError(group.label);
            input.value = '';
          } else {
            console.log(`✔ ${group.label} [${id}] is within limit`);
          }
        });
      }
    });
  });
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const actualEng = document.getElementById("actual_engineering");
  const summaryEng = document.querySelector('input[name="amountEng"]');

  const actualMqc = document.getElementById("actual_mqc");
  const summaryMqc = document.querySelector('input[name="amountMqc"]');

  const voContractAmount = document.getElementById("vo_contract_amount_1");
  const actualContractAmount = document.getElementById("actual_contract_amount");
  const finalBillingAmount = document.querySelector('input[name="amountFinal"]');

  if (actualEng && summaryEng) {
    actualEng.addEventListener("input", () => {
      summaryEng.value = actualEng.value;
    });
  }

  if (actualMqc && summaryMqc) {
    actualMqc.addEventListener("input", () => {
      summaryMqc.value = actualMqc.value;
    });
  }

  if (voContractAmount && actualContractAmount && finalBillingAmount) {
    voContractAmount.addEventListener("input", () => {
      const voValue = voContractAmount.value.trim();
      if (voValue !== "") {
        actualContractAmount.value = voValue;
        finalBillingAmount.value = voValue;
      }
    });
  }
});
</script>


<script>
  
  let voCount = 1;
  let billingCount = 1;

  function getOrdinalSuffix(n) {
    const s = ["th", "st", "nd", "rd"];
    const v = n % 100;
    return s[(v - 20) % 10] || s[v] || s[0];
  }


  function addNextBilling() {
    if (billingCount >= 5) {
      Swal.fire({
        icon: 'warning',
        title: 'Limit Reached',
        text: 'You can only add up to 5 billings.',
      });
      return;
    }
    billingCount++;
    const suffix = getOrdinalSuffix(billingCount);
    const tbody = document.getElementById('billingsTableBody');
    const row = document.createElement('tr');
    row.innerHTML = `
    <td>${billingCount}${suffix} Partial Billing</td>
    <td><input type="date" class="form-control" name="datePart${billingCount}"></td>
    <td><input type="text" class="form-control amount-input" name="amountPart${billingCount}" ></td>
    <td><input type="text" class="form-control" name="remPart${billingCount}"></td>
  `;
    tbody.appendChild(row);

    // Disable Add Billing button if limit is reached
    if (billingCount >= 5) {
      document.querySelector('button[onclick="addNextBilling()"]').disabled = true;
    }

    // Enable Remove Billing button
    document.querySelector('button[onclick="removeLastBilling()"]').disabled = false;
  }

function removeLastBilling() {
  if (billingCount > 1) { 
    const tbody = document.getElementById('billingsTableBody');
    tbody.removeChild(tbody.lastElementChild);
    billingCount--;
  }
}
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
  const amountTotal = document.querySelector('input[name="amountTotal"]');
  const amountSavings = document.querySelector('input[name="amountSavings"]');
  const origAppropriation = document.getElementById('orig_appropriation');

  const validateExpenditures = () => {
    const appropriation = parseCurrency(origAppropriation.value);
    const total = parseCurrency(amountTotal.value);
    const savings = parseCurrency(amountSavings.value);

    if (total > appropriation) {
      Swal.fire({
        icon: 'error',
        title: 'Expenditure Exceeded',
        text: 'Total Expenditures cannot exceed the Original Appropriation!',
      });
      amountTotal.value = '';
      return false;
    }

    if (savings < 0) {
      Swal.fire({
        icon: 'error',
        title: 'Negative Savings',
        text: 'Total Savings cannot be a negative amount!',
      });
      amountSavings.value = '';
      return false;
    }

    return true;
  };

  amountTotal.addEventListener('blur', validateExpenditures);
  amountSavings.addEventListener('blur', validateExpenditures);
});
</script>