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
              <textarea class="form-control-plaintext border rounded p-3 bg-white text-dark fw-semibold"
                id="projectTitleFU" name="projectTitleFU" rows="2" readonly>Project Title</textarea>
            </div>
          </fieldset>
          <!-- Cost Breakdown Table -->
          <fieldset class="border p-3 mb-4 rounded">
            <legend class="float-none w-auto px-2 fw-bold">Cost Breakdown</legend>

            <div class="table-responsive">
              <table class="table table-bordered text-center align-middle">
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

                    <td>ABC</td>
                    <td><input type="text" class="form-control amount-input" id="orig_abc" name="orig_abc"
                        placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control amount-input" id="vo_abc_1" name="vo_abc_1"
                        placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control amount-input" id="actual_abc" name="actual_abc"
                        placeholder="₱0.00"></td>
                  </tr>
                  <tr>
                    <td>Contract Amount</td>
                    <td><input type="text" class="form-control amount-input" id="orig_contract_amount"
                        name="orig_contract_amount" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control amount-input" id="vo_contract_amount_1"
                        name="vo_contract_amount_1" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control amount-input" id="actual_contract_amount"
                        name="actual_contract_amount" placeholder="₱0.00"></td>
                  </tr>
                  <tr>
                    <td>Engineering</td>
                    <td><input type="text" class="form-control amount-input" id="orig_engineering"
                        name="orig_engineering" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control amount-input" id="vo_engineering_1"
                        name="vo_engineering_1" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control amount-input" id="actual_engineering"
                        name="actual_engineering" placeholder="₱0.00"></td>
                  </tr>
                  <tr>
                    <td>MQC</td>
                    <td><input type="text" class="form-control amount-input" id="orig_mqc" name="orig_mqc"
                        placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control amount-input" id="vo_mqc_1" name="vo_mqc_1"
                        placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control amount-input" id="actual_mqc" name="actual_mqc"
                        placeholder="₱0.00"></td>
                  </tr>
                  <tr>
                    <td>Contingency</td>
                    <td><input type="text" class="form-control amount-input" id="orig_contingency"
                        name="orig_contingency" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control amount-input" id="vo_contingency_1"
                        name="vo_contingency_1" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control amount-input" id="actual_contingency"
                        name="actual_contingency" placeholder="₱0.00"></td>
                  </tr>
                  <tr>
                    <td>Bid Difference</td>
                    <td><input type="text" class="form-control amount-input" id="orig_bid" name="orig_bid"
                        placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control amount-input" id="vo_bid_1" name="vo_bid_1"
                        placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control amount-input" id="actual_bid" name="actual_bid"
                        placeholder="₱0.00"></td>
                  </tr>
                  <tr>
                    <td>Appropriation</td>
                    <td><input type="text" class="form-control amount-input" id="orig_appropriation"
                        name="orig_appropriation" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control amount-input" id="vo_appropriation_1"
                        name="vo_appropriation_1" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control amount-input" id="actual_appropriation"
                        name="actual_appropriation" placeholder="₱0.00"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </fieldset>


          <div class="text-end mt-2">
            <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="addVOFields()">
              <i class="fa-solid fa-square-plus"></i> Add V.O.
            </button>
            <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeLastVOFields()">
              <i class="fa-solid fa-circle-minus"></i> Remove V.O.
            </button>
          </div>
          </fieldset>

          <!-- Fund Utilization Summary Table -->
          <fieldset class="border p-3 mb-4 rounded">
            <legend class="float-none w-auto px-2 fw-bold">Fund Utilization Summary</legend>
            <div class="mb-2 row align-items-center">
              <div class="col-md-2">
                <label for="percentMobi" class="form-label fw-bold">% Mobilization</label>
              </div>
              <div class="col-md-3">
              <input type="number" class="form-control" id="percentMobi" name="percentMobi" placeholder="0.00">
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
                  <tr>
                    <td>15% Mobilization</td>
                    <td><input type="date" class="form-control" name="dateMobi"></td>
                    <td><input type="text" class="form-control amount-input" name="amountMobi" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control" name="remMobi"></td>
                  </tr>
                </tbody>
                <tbody id="billingsTableBody">
                  <tr>
                  <td>1st Partial Billing</td>
                  <td><input type="date" class="form-control" name="datePart1"></td>
                  <td><input type="text" class="form-control amount-input" name="amountPart1" placeholder="₱0.00">
                  </td>
                  <td><input type="text" class="form-control" name="remPart1"></td>
                  </tr>
                </tbody>
                <tbody>
                  <tr>
                    <td>Final Billing</td>
                    <td><input type="date" class="form-control" name="dateFinal"></td>
                    <td><input type="text" class="form-control amount-input" name="amountFinal" placeholder="₱0.00">
                    </td>
                    <td><input type="text" class="form-control" name="remFinal"></td>
                  </tr>
                  <tr>
                    <td>Engineering</td>
                    <td><input type="date" class="form-control" name="dateEng"></td>
                    <td><input type="text" class="form-control amount-input" name="amountEng" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control" name="remEng"></td>
                  </tr>
                  <tr>
                    <td>MQC</td>
                    <td><input type="date" class="form-control" name="dateMqc"></td>
                    <td><input type="text" class="form-control amount-input" name="amountMqc" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control" name="remMqc"></td>
                  </tr>
                  <tr class="fw-bold">
                    <td>Total Expenditures</td>
                    <td></td>
                    <td><input type="text" class="form-control amount-input" name="amountTotal" placeholder="₱0.00">
                    </td>
                    <td><input type="text" class="form-control" name="remTotal"></td>
                  </tr>
                  <tr class="fw-bold">
                    <td>Total Savings</td>
                    <td></td>
                    <td><input type="text" class="form-control amount-input" name="amountSavings" placeholder="₱0.00">
                    </td>
                    <td><input type="text" class="form-control" name="remSavings"></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="text-end mt-2">
              <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="addNextBilling()">
                <i class="fa-solid fa-square-plus"></i> Add Billing
              </button>
              <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeLastBilling()">
                <i class="fa-solid fa-circle-minus"></i> Remove Billing
              </button>
            </div>
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
  const actualEng = document.getElementById("actual_engineering");
  const summaryEng = document.querySelector('input[name="amountEng"]');

  const actualMqc = document.getElementById("actual_mqc");
  const summaryMqc = document.querySelector('input[name="amountMqc"]');

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
    <td><input type="text" class="form-control amount-input" name="amountPart${billingCount}" placeholder="₱0.00"></td>
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