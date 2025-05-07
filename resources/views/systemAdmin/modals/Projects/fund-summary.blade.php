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
                  <th>V.O. 1</th>
                  <th>Actual</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $categories = ['Appropriation', 'Contract Amount', 'ABC', 'Bid Difference', 'Engineering', 'MQC', 'Contingency'];
                  $keys = ['appropriation', 'contract_amount', 'abc', 'bid', 'engineering', 'mqc', 'contingency'];
                @endphp
                @foreach ($categories as $index => $category)
                <tr>
                  <td>{{ $category }}</td>
                  <td>{{ number_format($project['funds']['orig_'.$keys[$index]] ?? 0, 2) }}</td>
                  <td>{{ number_format($project['variation_orders']['vo_'.$keys[$index]] ?? 0, 2) }}</td>
                  <td>{{ number_format($project['funds']['actual_'.$keys[$index]] ?? 0, 2) }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </fieldset>

        <!-- Fund Utilization Summary -->
        <fieldset class="border p-3 mb-4 rounded shadow-sm">
          <legend class="float-none w-auto px-2 fw-bold text-primary">Fund Utilization Summary</legend>
          <div class="mb-3">
            <label class="form-label fw-bold">% Mobilization</label>
            <div class="form-control">{{ $project['summary']['percentMobi'] ?? '0.00' }}%</div>
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
                @php
                  $summaryItems = [
                    ['15% Mobilization', 'dateMobi', 'amount', 'remMobi'],
                    ['1st Partial Billing', 'datePart1', 'amountPart1', 'remPart1'],
                    ['Final Billing', 'dateFinal', 'amountFinal', 'remFinal'],
                    ['Engineering', 'dateEng', 'amountEng', 'remEng'],
                    ['MQC', 'dateMqc', 'amountMqc', 'remMqc'],
                    ['Total Expenditures', '', 'amountTotal', 'remTotal'],
                    ['Total Savings', '', 'amountSavings', 'remSavings'],
                  ];
                @endphp
                @foreach ($summaryItems as $item)
                <tr class="{{ in_array($item[0], ['Total Expenditures', 'Total Savings']) ? 'fw-bold' : '' }}">
                  <td>{{ $item[0] }}</td>
                  <td>{{ $project['summary'][$item[1]] ?? '-' }}</td>
                  <td>{{ number_format($project['summary'][$item[2]] ?? 0, 2) }}</td>
                  <td>{{ $project['summary'][$item[3]] ?? '-' }}</td>
                </tr>
                @endforeach
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
