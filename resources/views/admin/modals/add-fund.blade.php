<!-- Fund Utilization Modal -->
<div class="modal fade" id="addProjectFundUtilization" tabindex="-1" aria-labelledby="addProjectFundUtilizationLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
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
                        id="projectTitleFU" 
                        name="projectTitleFU" 
                        rows="2" 
                        readonly>Project Title</textarea>
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
          <th>V.O.1</th>
          <th>Actual</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>ABC</td>
          <td><input type="text" class="form-control" id="orig_abc" name="orig_abc" placeholder="₱0.00"></td>
          <td><input type="text" class="form-control" id="vo_abc" name="vo_abc" placeholder="₱0.00"></td>
          <td><input type="text" class="form-control" id="actual_abc" name="actual_abc" placeholder="₱0.00"></td>
        </tr>
        <tr>
          <td>Contract Amount</td>
          <td><input type="text" class="form-control" id="orig_contract_amount" name="orig_contract_amount" placeholder="₱0.00"></td>
          <td><input type="text" class="form-control" id="vo_contract_amount" name="vo_contract_amount" placeholder="₱0.00"></td>
          <td><input type="text" class="form-control" id="actual_contract_amount" name="actual_contract_amount" placeholder="₱0.00"></td>
        </tr>
        <tr>
          <td>Engineering</td>
          <td><input type="text" class="form-control" id="orig_engineering" name="orig_engineering" placeholder="₱0.00"></td>
          <td><input type="text" class="form-control" id="vo_engineering" name="vo_engineering" placeholder="₱0.00"></td>
          <td><input type="text" class="form-control" id="actual_engineering" name="actual_engineering" placeholder="₱0.00"></td>
        </tr>
        <tr>
          <td>MQC</td>
          <td><input type="text" class="form-control" id="orig_mqc" name="orig_mqc" placeholder="₱0.00"></td>
          <td><input type="text" class="form-control" id="vo_mqc" name="vo_mqc" placeholder="₱0.00"></td>
          <td><input type="text" class="form-control" id="actual_mqc" name="actual_mqc" placeholder="₱0.00"></td>
        </tr>
        <tr>
          <td>Contingency</td>
          <td><input type="text" class="form-control" id="orig_contingency" name="orig_contingency" placeholder="₱0.00"></td>
          <td><input type="text" class="form-control" id="vo_contingency" name="vo_contingency" placeholder="₱0.00"></td>
          <td><input type="text" class="form-control" id="actual_contingency" name="actual_contingency" placeholder="₱0.00"></td>
        </tr>
        <tr>
          <td>Bid Difference</td>
          <td><input type="text" class="form-control" id="orig_bid" name="orig_bid" placeholder="₱0.00"></td>
          <td><input type="text" class="form-control" id="vo_bid" name="vo_bid" placeholder="₱0.00"></td>
          <td><input type="text" class="form-control" id="actual_bid" name="actual_bid" placeholder="₱0.00"></td>
        </tr>
        <tr>
          <td>Appropriation</td>
          <td><input type="text" class="form-control" id="orig_appropriation" name="orig_appropriation" placeholder="₱0.00"></td>
          <td><input type="text" class="form-control" id="vo_appropriation" name="vo_appropriation" placeholder="₱0.00"></td>
          <td><input type="text" class="form-control" id="actual_appropriation" name="actual_appropriation" placeholder="₱0.00"></td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- VO Dynamic Controls -->
  <div class="text-end mt-2">
    <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="addVOFields()" title="Add V.O.">
      <i class="fa-solid fa-square-plus"></i> Add V.O.
    </button>
    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeLastVOFields()" title="Remove Last V.O.">
      <i class="fa-solid fa-circle-minus"></i> Remove V.O.
    </button>
  </div>
</fieldset>



          <!-- Fund Utilization Summary Table -->
          <fieldset class="border p-3 mb-4 rounded">
            <legend class="float-none w-auto px-2 fw-bold">Fund Utilization Summary</legend>

            <div class="table-responsive">
              <table class="table table-bordered text-center align-middle">
                <thead >
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
                    <td><input type="text" class="form-control" name="amountMobi" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control" name="remMobi"></td>
                  </tr>
                </tbody>
                <tbody id="billingsTableBody">
                  <tr>
                    <td>1st Partial Billing</td>
                    <td><input type="date" class="form-control" name="datePart1"></td>
                    <td><input type="text" class="form-control" name="amountPart1" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control" name="remPart1"></td>
                  </tr>
                </tbody>
                <tbody>
                  <tr>
                    <td>Final Billing</td>
                    <td><input type="date" class="form-control" name="dateFinal"></td>
                    <td><input type="text" class="form-control" name="amountFinal" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control" name="remFinal"></td>
                  </tr>
                  <tr>
                    <td>Engineering</td>
                    <td><input type="date" class="form-control" name="dateEng"></td>
                    <td><input type="text" class="form-control" name="amountEng" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control" name="remEng"></td>
                  </tr>
                  <tr>
                    <td>MQC</td>
                    <td><input type="date" class="form-control" name="dateMqc"></td>
                    <td><input type="text" class="form-control" name="amountMqc" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control" name="remMqc"></td>
                  </tr>
                  <tr class="fw-bold">
                    <td>Total Expenditures</td>
                    <td></td>
                    <td><input type="text" class="form-control" name="amountTotal" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control" name="remTotal"></td>
                  </tr>
                  <tr class="fw-bold">
                    <td>Total Savings</td>
                    <td></td>
                    <td><input type="text" class="form-control" name="amountSavings" placeholder="₱0.00"></td>
                    <td><input type="text" class="form-control" name="remSavings"></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <!-- Billing Controls -->
            <div class="text-end mt-2">
              <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="addNextBilling()"><i class="fa-solid fa-square-plus"></i> Add Billing</button>
              <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeLastBilling()"><i class="fa-solid fa-circle-minus"></i> Remove Billing</button>
            </div>
          </fieldset>

          <!-- Modal Footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" id="submitFundsUtilization" class="btn btn-primary">Add Fund Utilization</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

