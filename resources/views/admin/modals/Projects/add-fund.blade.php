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
                  <input type="hidden" id="voCount" name="voCount" value="1">
                  <tr>
                    <td>Appropriation</td>
                    <td><input type="text" class="form-control amount-input" id="orig_appropriation"
                      name="orig_appropriation" value="{{ $project['funds']['orig_appropriation'] ?? '' }}"></td>
                    <td><input type="text" class="form-control amount-input" id="vo_appropriation_1"
                      name="vo_appropriation_1" value="{{ $project['variation_orders'][0]['vo_appropriation'] ?? '' }}"></td>
                    <td><input type="text" class="form-control amount-input" id="actual_appropriation"
                      name="actual_appropriation" value="{{ $project['funds']['actual_appropriation'] ?? '' }}"></td>
                  </tr>
                  <tr>
                    <td>ABC</td>
                    <td><input type="text" class="form-control amount-input" id="orig_abc"
                      name="orig_abc" value="{{ $project['funds']['orig_abc'] ?? '' }}"></td>
                    <td><input type="text" class="form-control amount-input" id="vo_abc_1"
                      name="vo_abc_1" value="{{ $project['variation_orders'][0]['vo_abc'] ?? '' }}"></td>
                    <td><input type="text" class="form-control amount-input" id="actual_abc"
                      name="actual_abc" value="{{ $project['funds']['actual_abc'] ?? '' }}"></td>
                  </tr>
                  <tr>
                    <td>Contract Amount</td>
                    <td><input type="text" class="form-control amount-input" id="orig_contract_amount"
                      name="orig_contract_amount" value="{{ $project['funds']['orig_contract_amount'] ?? '' }}"></td>
                    <td><input type="text" class="form-control amount-input" id="vo_contract_amount_1"
                      name="vo_contract_amount_1" value="{{ $project['variation_orders'][0]['vo_contract_amount'] ?? '' }}"></td>
                    <td><input type="text" class="form-control amount-input" id="actual_contract_amount"
                      name="actual_contract_amount" value="{{ $project['funds']['actual_contract_amount'] ?? '' }}"></td>
                  </tr>

                

                  <tr>
                    <td>Bid Difference</td>
                    <td><input type="text" class="form-control amount-input" id="orig_bid"
                      name="orig_bid" value="{{ $project['funds']['orig_bid'] ?? '' }}"></td>
                    <td><input type="text" class="form-control amount-input" id="vo_bid_1"
                      name="vo_bid_1" value="{{ $project['variation_orders'][0]['vo_bid'] ?? '' }}"></td>
                    <td><input type="text" class="form-control amount-input" id="actual_bid"
                      name="actual_bid" value="{{ $project['funds']['actual_bid'] ?? '' }}"></td>
                  </tr>

                  <tr>
                    <td>
                      <div class="fw-bold">Wages</div>
                      <div class="text-end ps-4">Engineering</div>
                    </td>
                    <td><input type="text" class="form-control amount-input" id="orig_engineering"
                      name="orig_engineering" value="{{ $project['funds']['orig_engineering'] ?? '' }}"></td>
                    <td><input type="text" class="form-control amount-input" id="vo_engineering_1"
                      name="vo_engineering_1" value="{{ $project['variation_orders'][0]['vo_engineering'] ?? '' }}"></td>
                    <td><input type="text" class="form-control amount-input" id="actual_engineering"
                      name="actual_engineering" value="{{ $project['funds']['actual_engineering'] ?? '' }}"></td>
                  </tr>

                  <tr>
                    <td class="text-end">MQC</td>
                    <td><input type="text" class="form-control amount-input" id="orig_mqc"
                      name="orig_mqc" value="{{ $project['funds']['orig_mqc'] ?? '' }}"></td>
                    <td><input type="text" class="form-control amount-input" id="vo_mqc_1"
                      name="vo_mqc_1" value="{{ $project['variation_orders'][0]['vo_mqc'] ?? '' }}"></td>
                    <td><input type="text" class="form-control amount-input" id="actual_mqc"
                      name="actual_mqc" value="{{ $project['funds']['actual_mqc'] ?? '' }}"></td>
                  </tr>

                  <tr>
                    <td>Contingency</td>
                    <td><input type="text" class="form-control amount-input" id="orig_contingency"
                      name="orig_contingency" value="{{ $project['funds']['orig_contingency'] ?? '' }}"></td>
                    <td><input type="text" class="form-control amount-input" id="vo_contingency_1"
                      name="vo_contingency_1" value="{{ $project['variation_orders'][0]['vo_contingency'] ?? '' }}"></td>
                    <td><input type="text" class="form-control amount-input" id="actual_contingency"
                      name="actual_contingency" value="{{ $project['funds']['actual_contingency'] ?? '' }}"></td>
                  </tr>

                  <tr class="fw-bold">
                    <td>Total</td>
                    <td><input type="text" class="form-control" id="orig_total" name="orig_total" readonly></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="text-end mt-2">
              <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="addVOFields()">
                <i class="fa-solid fa-square-plus"></i> Add V.O.
              </button>
            </div>
        </fieldset>

        <fieldset class="border p-4 rounded shadow bg-white">
            <legend class="w-auto px-3 fw-bold text-primary">Fund Utilization Summary</legend>

            <div class="row mb-3 align-items-center">
              <div class="col-md-6 fw-semibold">
                Contract Amount:
              </div>
              <div class="col-md-6 text-end text-success fw-bold" id="display_contract_amount"></div>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-auto">
                <button id="openEngineeringModal" class="btn btn-outline-success btn-sm" type="button">
                <i class="fa-solid fa-gears me-1"></i> Manage Engineering
              </button>
            </div>

            <div class="col-auto">
              <button id="openMqcModal" class="btn btn-outline-info btn-sm" type="button">
                <i class="fa-solid fa-cubes me-1"></i> Manage MQC
              </button>
            </div>
            <div class="col-md-3 ms-auto">
              <label for="percentMobi" class="form-label mb-1 fw-bold">% Mobilization</label>
              <input type="number" max="15" min="0" step="0.01" class="form-control form-control-sm" id="percentMobi" name="percentMobi" placeholder="0.00">
            </div>
          </div>

          <div class="table-responsive">
            <table class="table table-bordered table-hover text-center align-middle small">
              <thead class="table-light">
                <tr>
                  <th>Category</th>
                  <th>Date</th>
                  <th>Amount</th>
                  <th>Remarks</th>
                </tr>
              </thead>
              <tbody id="mobilizationRows"></tbody>

              <tr>
                <td>1st Partial Billing</td>
                <td><input type="date" class="form-control form-control-sm" name="datePart1" value="{{ $project['partial_billings'][1]['date'] ?? '' }}"></td>
                <td><input type="text" class="form-control form-control-sm amount-input" name="amountPart1" value="{{ $project['partial_billings'][1]['amount'] ?? '' }}"></td>
                <td><input type="text" class="form-control form-control-sm" name="remPart1" value="{{ $project['partial_billings'][1]['remarks'] ?? '' }}"></td>
              </tr>

              <tbody id="billingsTableBody"></tbody>

              <tr>
                <td>Final Billing</td>
                <td><input type="date" class="form-control form-control-sm" name="dateFinal" value="{{ $project['summary']['final_billing']['date'] ?? '' }}"></td>
                <td><input type="text" class="form-control form-control-sm amount-input" name="amountFinal" value="{{ $project['summary']['final_billing']['amount'] ?? '' }}"></td>
                <td><input type="text" class="form-control form-control-sm" name="remFinal" value="{{ $project['summary']['final_billing']['remarks'] ?? '' }}"></td>
              </tr>

              <tr>
                <td>Engineering</td>
                <td><input type="date" class="form-control form-control-sm" name="dateEng" value="{{ $project['summary']['engineering']['date'] ?? '' }}"></td>
                <td><input type="text" class="form-control form-control-sm" name="amountEng" value="{{ $project['summary']['engineering']['amount'] ?? '' }}" readonly></td>
                <td><input type="text" class="form-control form-control-sm" name="remEng" value="{{ $project['summary']['engineering']['remarks'] ?? '' }}"></td>
              </tr>

              <tr>
                <td>MQC</td>
                <td><input type="date" class="form-control form-control-sm" name="dateMqc" value="{{ $project['summary']['mqc']['date'] ?? '' }}"></td>
                <td><input type="text" class="form-control form-control-sm" name="amountMqc" value="{{ $project['summary']['mqc']['amount'] ?? '' }}" readonly></td>
                <td><input type="text" class="form-control form-control-sm" name="remMqc" value="{{ $project['summary']['mqc']['remarks'] ?? '' }}"></td>
              </tr>

              <tr class="table-warning fw-bold">
                <td>Total Expenditures</td>
                <td></td>
                <td><input type="text" class="form-control form-control-sm" name="amountTotal" value="{{ $project['summary']['totalExpenditure']['amount'] ?? '' }}" readonly></td>
                <td><input type="text" class="form-control form-control-sm" name="remTotal" value="{{ $project['summary']['totalExpenditure']['remarks'] ?? '' }}"></td>
              </tr>

              <tr class="table-success fw-bold">
                <td>Total Savings</td>
                <td></td>
                <td><input type="text" class="form-control form-control-sm" name="amountSavings" value="{{ $project['summary']['total_savings']['amount'] ?? '' }}" readonly></td>
                <td><input type="text" class="form-control form-control-sm" name="remSavings" value="{{ $project['summary']['total_savings']['remarks'] ?? '' }}"></td>
              </tr>

                          </table>
          </div>

          <div class="text-end mt-3">
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
  document.addEventListener('DOMContentLoaded', function () {
  const openEngineeringBtn = document.getElementById('openEngineeringModal');
  const parentModalEl = document.getElementById('addProjectFundUtilization');
  const engineeringModalEl = document.getElementById('engineeringModal');

  if (openEngineeringBtn && parentModalEl && engineeringModalEl) {
    const parentModal = new bootstrap.Modal(parentModalEl); // FIX: create instance safely

    openEngineeringBtn.addEventListener('click', function () {
      parentModal.hide(); // safely hide the parent modal

      parentModalEl.addEventListener('hidden.bs.modal', function handler() {
        parentModalEl.removeEventListener('hidden.bs.modal', handler);

        const engineeringModal = new bootstrap.Modal(engineeringModalEl);
        engineeringModal.show(); // show the engineering modal
      });
    });
  }
});

</script>

<script>
// Helper: parse amount string to float (null if invalid)
function parseAmount(val) {
  const n = parseFloat(val.replace(/,/g, ''));
  return isNaN(n) ? 0 : n;
}

// Calculate and update Balance
function updateBalance() {
  const contractAmountText = document.getElementById('display_contract_amount').innerText;
  const contractAmount = parseAmount(contractAmountText);
  let totalBilling = 0;

  // Sum billing amounts
  document.querySelectorAll('.billing-amount').forEach(input => {
    totalBilling += parseAmount(input.value);
  });

  // You can add mobilization amount summing here if needed

  const balance = contractAmount - totalBilling;
  document.getElementById('balanceAmount').value = balance.toFixed(2);
}

// Attach event listeners to billing inputs
function setupListeners() {
  document.querySelectorAll('.billing-amount').forEach(input => {
    input.removeEventListener('input', updateBalance); // Avoid duplicates
    input.addEventListener('input', updateBalance);
  });
}

let billingCount = 1; // Initial billing

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
    <td><input type="text" class="form-control amount-input billing-amount" name="amountPart${billingCount}"></td>
    <td><input type="text" class="form-control" name="remPart${billingCount}"></td>
  `;
  tbody.appendChild(row);
  setupListeners(); // Re-attach listeners to new input

  if (billingCount >= 5) {
    document.querySelector('button[onclick="addNextBilling()"]').disabled = true;
  }
  document.querySelector('button[onclick="removeLastBilling()"]').disabled = false;
}

function removeLastBilling() {
  if (billingCount > 1) {
    const tbody = document.getElementById('billingsTableBody');
    tbody.removeChild(tbody.lastElementChild);
    billingCount--;

    document.querySelector('button[onclick="addNextBilling()"]').disabled = false;

    if (billingCount <= 1) {
      document.querySelector('button[onclick="removeLastBilling()"]').disabled = true;
    }

    updateBalance();
  }
}

// Initialize listeners on load
window.addEventListener('DOMContentLoaded', () => {
  setupListeners();
  updateBalance();

  // Optional: Disable remove if only 1 billing initially
  if (billingCount <= 1) {
    document.querySelector('button[onclick="removeLastBilling()"]').disabled = true;
  }
});
</script>
