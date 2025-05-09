<!-- Fund Summary Modal (View Only) -->
<div class="modal fade" id="viewFundSummaryModal" tabindex="-1" aria-labelledby="viewFundSummaryLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="viewFundSummaryLabel">Fund Summary & Utilization</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <!-- Project Title -->
        <div class="mb-4">
          <label class="form-label fw-bold">Project Title:</label>
          <div class="form-control bg-white text-dark fw-semibold" readonly>{{ $project['projectTitle'] ?? '' }}</div>
        </div>

       <!-- Cost Breakdown -->
<fieldset class="border p-3 mb-4 rounded shadow-sm">
  <legend class="float-none w-auto px-2 fw-bold text-primary">Cost Breakdown</legend>
  <div class="table-responsive">
    <table class="table table-bordered table-striped text-center align-middle">
      <thead class="table-light">
        <tr>
          <th>Category</th>
          <th>Original</th>
          <th id="voHeaders">V.O. 1</th>
          <th>Actual</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Appropriation</td>
          <td id="orig_appropriation_view"></td>
          <td id="vo_appropriation_view"></td>
          <td id="actual_appropriation_view"></td>
        </tr>
        <tr>
          <td>Contract Amount</td>
          <td id="orig_contract_amount_view"></td>
          <td id="vo_contract_amount_view"></td>
          <td id="actual_contract_amount_view"></td>
        </tr>
        <tr>
          <td>ABC</td>
          <td id="orig_abc_view"></td>
          <td id="vo_abc_view"></td>
          <td id="actual_abc_view"></td>
        </tr>
        <tr>
          <td>Bid Difference</td>
          <td id="orig_bid_view"></td>
          <td id="vo_bid_view"></td>
          <td id="actual_bid_view"></td>
        </tr>
        <tr>
          <td>Engineering</td>
          <td id="orig_engineering_view"></td>
          <td id="vo_engineering_view"></td>
          <td id="actual_engineering_view"></td>
        </tr>
        <tr>
          <td>MQC</td>
          <td id="orig_mqc_view"></td>
          <td id="vo_mqc_view"></td>
          <td id="actual_mqc_view"></td>
        </tr>
        <tr>
          <td>Contingency</td>
          <td id="orig_contingency_view"></td>
          <td id="vo_contingency_view"></td>
          <td id="actual_contingency_view"></td>
        </tr>
      </tbody>
    </table>
  </div>
</fieldset>

<!-- Fund Utilization Summary -->
<fieldset class="border p-3 mb-4 rounded shadow-sm">
  <legend class="float-none w-auto px-2 fw-bold text-primary">Fund Utilization Summary</legend>
  <div class="mb-3">
    <label class="form-label fw-bold">% Mobilization</label>
    <div class="form-control" id="percentMobi_view">0.00%</div>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-striped text-center align-middle">
      <thead class="table-light">
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
          <td id="dateMobi_view"></td>
          <td id="amountMobi_view"></td>
          <td id="remMobi_view"></td>
        </tr>
        <tr>
          <tbody id="partialBillingsRows"></tbody>
        </tr>
 
        <tr>
          <td>Final Billing</td>
          <td id="dateFinal_view"></td>
          <td id="amountFinal_view"></td>
          <td id="remFinal_view"></td>
        </tr>
        <tr>
          <td>Engineering</td>
          <td id="dateEng_view"></td>
          <td id="amountEng_view"></td>
          <td id="remEng_view"></td>
        </tr>
        <tr>
          <td>MQC</td>
          <td id="dateMqc_view"></td>
          <td id="amountMqc_view"></td>
          <td id="remMqc_view"></td>
        </tr>
        <tr class="fw-bold">
          <td>Total Expenditures</td>
          <td>-</td>
          <td id="amountTotal_view"></td>
          <td id="remTotal_view"></td>
        </tr>
        <tr class="fw-bold">
          <td>Total Savings</td>
          <td>-</td>
          <td id="amountSavings_view"></td>
          <td id="remSavings_view"></td>
        </tr>
      </tbody>
    </table>
  </div>
</fieldset>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
