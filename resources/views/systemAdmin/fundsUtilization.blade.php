@extends('systemAdmin.layout')

@section('title', 'Dashboard Page')

@section('content')
<!-- Fund Utilization Section -->
<hr class="mx-2">
<section class="container-fluid  py-4">
<div class="row mt-4">
        <div class="col-md-12 d-flex align-items-center justify-content-between mb-3" style="margin-top:25px;">
            <div class="d-flex align-items-center gap-2">
            <a id="back-to-projects" class="btn btn-outline-secondary btn-sm"
                      href="{{ url('/systemAdmin/overview/' . $project['id']) }}">
                      <span class="fa fa-arrow-left"></span>
                    </a>

                <h5 class="m-0">Funds Utilization</h5>
            </div>
        </div>
    </div>

<div class="card shadow-sm">
  <form id="addFundUtilization" method="POST">
    @csrf

    <!-- Project Title -->
    <fieldset class="border p-1 mb-3 rounded shadow-sm bg-light">
      <div class="mb-3">
        <textarea class="form-control-plaintext border rounded p-3 bg-white text-dark fw-semibold"
          id="projectTitleFU" name="projectTitleFU" readonly>{{ $project['projectTitle'] ?? '' }}</textarea>
      </div>
    </fieldset>

      <!-- Cost Breakdown Table -->
      <fieldset class="border p-3 mb-4 rounded">
        <legend class="float-none w-auto px-2 fw-bold">Fund Source</legend>

        <div class="table-responsive">
        <table id="editableFundTable" class="table table-bordered text-center align-middle"> 
          <thead>
            <tr>
              <th>Category</th>
              <th>Original</th>
              <th>V.O. 1</th> {{-- Always shown --}}
              @foreach ($variationOrders as $vo)
                @if ($vo->vo_number != 1)
                  <th>V.O. {{ $vo->vo_number }}</th>
                @endif
              @endforeach
              <th>Actual</th>
            </tr>
          </thead>
          <tbody>
            <input type="hidden" id="voCount" name="voCount" value="{{ count($variationOrders) > 0 ? count($variationOrders) : 1 }}">

            @php
              $fields = [
                'Appropriation' => 'appropriation',
                'ABC' => 'abc',
                'Contract Amount' => 'contract_amount',
                'Bid Difference' => 'bid',
                'Engineering' => 'engineering',
                'MQC' => 'mqc',
                'Contingency' => 'contingency',
              ];

              // Default values for VO 1 if $variationOrders doesn't contain it
              $vo1 = $variationOrders->firstWhere('vo_number', 1);
            @endphp

            @foreach ($fields as $label => $key)
              <tr>
                <td>
                  @if ($label === 'Engineering')
                    <div class="fw-bold">Wages</div>
                    <div class="text-end ps-4">{{ $label }}</div>
                  @elseif ($label === 'MQC')
                    <div class="text-end">{{ $label }}</div>
                  @else
                    {{ $label }}
                  @endif
                </td>

                {{-- Original --}}
                <td>
                  <input type="text" class="form-control amount-input"
                    id="orig_{{ $key }}" name="orig_{{ $key }}"
                    value="{{ $funds['orig_'.$key] ?? '' }}">
                </td>

                {{-- Always show VO 1 --}}
                <td>
                  <input type="text" class="form-control amount-input"
                    id="vo_{{ $key }}_1" name="vo_{{ $key }}_1"
                    value="{{ $vo1 ? $vo1->{'vo_'.$key} : '' }}">
                </td>

                {{-- Render remaining VO columns (VO 2 and up) --}}
                @foreach ($variationOrders as $vo)
                  @if ($vo->vo_number != 1)
                    <td>
                      <input type="text" class="form-control amount-input"
                        id="vo_{{ $key }}_{{ $vo->vo_number }}"
                        name="vo_{{ $key }}_{{ $vo->vo_number }}"
                        value="{{ $vo->{'vo_'.$key} ?? '' }}">
                    </td>
                  @endif
                @endforeach

                {{-- Actual --}}
                <td>
                  <input type="text" class="form-control amount-input"
                    id="actual_{{ $key }}" name="actual_{{ $key }}"
                    value="{{ $funds['actual_'.$key] ?? '' }}">
                </td>
              </tr>
            @endforeach

            <tr class="fw-bold">
              <td>Total</td>
              <td><input type="text" class="form-control" id="orig_total" name="orig_total" readonly></td>
              <td><input type="text" class="form-control" id="vo_total_1" name="vo_total_1" readonly></td>
              @foreach ($variationOrders as $vo)
                @if ($vo->vo_number != 1)
                  <td><input type="text" class="form-control" id="vo_total_{{ $vo->vo_number }}" name="vo_total_{{ $vo->vo_number }}" readonly></td>
                @endif
              @endforeach
              <td><input type="text" class="form-control" id="actual_total" name="actual_total" readonly></td>
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

    <!-- Fund Utilization Summary -->
<fieldset class="border p-4 rounded shadow bg-white">
  <legend class="w-auto px-3 fw-bold text-primary">Fund Utilization Summary</legend>
  <div class="d-flex gap-2 mb-4 mx-4">
    <button id="engineering_input" type="button" class="btn btn-outline-success btn-sm">Add Engineering</button>
    <button id="mqc_input" type="button" class="btn btn-outline-info btn-sm">Add MQC</button>
    <button type="button" class="btn btn-outline-primary btn-sm me-2" onclick="addNextBilling()">
          <i class="fa-solid fa-square-plus"></i> Add Billing
    </button>
    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeLastBilling()">
      <i class="fa-solid fa-circle-minus"></i> Remove Billing
    </button>
  </div>

<!-- Engineering Form -->
<div id="engineeringFormWrapper" class="row g-2 mb-4 mx-4 d-none" style="display: none;">
  <input type="hidden" id="engType" value="engineering">
  <div class="col-md-3">
    <input type="text" class="form-control form-control-sm" id="engName" placeholder="Name">
  </div>
  <div class="col-md-2">
    <select id="engMonth" class="form-select form-select-sm">
      <option value="" disabled selected>Select Month</option>
      <option value="January">January</option>
      <option value="February">February</option>
      <option value="March">March</option>
      <option value="April">April</option>
      <option value="May">May</option>
      <option value="June">June</option>
      <option value="July">July</option>
      <option value="August">August</option>
      <option value="September">September</option>
      <option value="October">October</option>
      <option value="November">November</option>
      <option value="December">December</option>
    </select>
  </div>
  <div class="col-md-2">
    <select id="engPaymentPeriod" class="form-select form-select-sm">
      <option value="" disabled selected>Select Period</option>
      <option value="1st Quincena">1st Quincena</option>
      <option value="2nd Quincena">2nd Quincena</option>
    </select>
  </div>
  <div class="col-md-2">
    <input type="text" class="form-control form-control-sm" id="engAmount" placeholder="Amount">
  </div>
  <div class="col-auto">
    <button type="button" class="btn btn-info btn-sm" id="addEngineeringEntry">
      <i class="fa fa-plus"></i> Add
    </button>
  </div>
</div>

<!-- MQC Form -->
<div id="mqcFormWrapper" class="row g-2 mb-4 mx-4 d-none" style="display: none;">
  <input type="hidden" id="mqcType" value="mqc">
  <div class="col-md-3">
    <input type="text" class="form-control form-control-sm" id="mqcName" placeholder="Name">
  </div>
  <div class="col-md-2">
    <select id="mqcMonth" class="form-select form-select-sm">
      <option value="" disabled selected>Select Month</option>
      <option value="January">January</option>
      <option value="February">February</option>
      <option value="March">March</option>
      <option value="April">April</option>
      <option value="May">May</option>
      <option value="June">June</option>
      <option value="July">July</option>
      <option value="August">August</option>
      <option value="September">September</option>
      <option value="October">October</option>
      <option value="November">November</option>
      <option value="December">December</option>
    </select>
  </div>
  <div class="col-md-2">
    <select id="mqcPaymentPeriod" class="form-select form-select-sm">
      <option value="" disabled selected>Select Period</option>
      <option value="1st Quincena">1st Quincena</option>
      <option value="2nd Quincena">2nd Quincena</option>
    </select>
  </div>
  <div class="col-md-2">
    <input type="text" class="form-control form-control-sm" id="mqcAmount" placeholder="Amount">
  </div>
  <div class="col-auto">
    <button type="button" class="btn btn-info btn-sm" id="addMqcEntry">
      <i class="fa fa-plus"></i> Add
    </button>
  </div>
</div>


  <div class="col-md-3 mx-4 mb-2">
      <label for="percentMobi" class="form-label mb-1 fw-bold">% Mobilization</label>
      <input type="number" max="15" min="0" step="0.01" class="form-control form-control-sm" id="percentMobi" name="percentMobi" placeholder="0.00">
  </div>

  
<div class="container-fluid">
  {{-- Contract Summary Section --}}
  <div class="card border-0 mb-4 shadow-sm">
    <div class="card-body p-3">
      <h6 class="fw-bold mb-3">Contract Summary</h6>
      <table class="table table-sm table-bordered text-center align-middle">
        <thead>
          <tr>
            <th style="width: 20%;">Category</th>
            <th style="width: 20%;">Date</th>
            <th style="width: 20%;">Amount</th>
            <th style="width: 40%;">Remarks</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Contract Amount</td>
            <td></td>
            <td><input type="text" class="form-control amount-input text-end"
                id="contract_amount" name="contract_amount"></td>
            <td></td>
          </tr>
          <tr>
            <td>Mobilization</td>
            <td>
              <input type="date" class="form-control form-control-sm" name="dateMobilization"
                    value="{{ $summary['mobilization']['date'] ?? '' }}">
            </td>
            <td>
              <input type="text" class="form-control form-control-sm amount-input" name="amountMobilization" id="amountMobilization"
                    value="{{ $summary['mobilization']['amount'] ?? '' }}">
            </td>
            <td>
              <input type="text" class="form-control form-control-sm" name="remMobilization"
                    value="{{ $summary['mobilization']['remarks'] ?? '' }}">
            </td>
          </tr>

          <!-- Partial Billing Rows -->
          @for ($i = 1; $i <= 5; $i++)
              <tr class="partial-billing billing-{{ $i }}" style="{{ $i > 1 ? 'display: none;' : '' }}">
                <td>{{ $i }}{{ $i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th')) }} Partial Billing</td>
                <td>
                  <input type="date" class="form-control form-control-sm"
                        name="partialBillings[{{ $i }}][date]"
                        value="{{ $partial_billings[$i - 1]['date'] ?? '' }}">
                </td>
                <td>
                  <input type="text" class="form-control form-control-sm amount-input"
                        name="partialBillings[{{ $i }}][amount]" id="amountPartial{{ $i }}"
                        value="{{ $partial_billings[$i - 1]['amount'] ?? '' }}">
                </td>
                <td>
                  <input type="text" class="form-control form-control-sm"
                        name="partialBillings[{{ $i }}][remarks]"
                        value="{{ $partial_billings[$i - 1]['remarks'] ?? '' }}">
                </td>
              </tr>
            @endfor



          <tr>
            <td>Final Billing</td>
            <td>
              <input type="date" class="form-control form-control-sm" name="dateFinal"
                    value="{{ $summary['final']['date'] ?? '' }}">
            </td>
            <td>
              <input type="text" class="form-control form-control-sm amount-input" name="amountFinal" id="amountFinal"
                    value="{{ $summary['final']['amount'] ?? '' }}">
            </td>
            <td>
              <input type="text" class="form-control form-control-sm" name="remFinal"
                    value="{{ $summary['final']['remarks'] ?? '' }}">
            </td>
          </tr>

          <tr>
            <td class="fw-bold">Balance</td>
            <td></td>
            <td id="contractBalance" class="fw-bold">0.00</td>
            <td></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  {{-- Engineering Section --}}
  <div class="card border-0 mb-4 shadow-sm">
    <div class="card-body p-3">
      <h6 class="fw-bold mb-3">Engineering</h6>
      <table class="table table-sm table-bordered text-center align-middle">
        <thead>
          <tr>
            <th style="width: 20%;">Category</th>
            <th style="width: 20%;">Date</th>
            <th style="width: 20%;">Amount</th>
            <th style="width: 30%;">Remarks</th>
            <th style="width: 10%;">Show</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Engineering</td>
            <td><input type="date" class="form-control form-control-sm" name="dateEng"></td>
            <td><input type="text" class="form-control form-control-sm" name="amountEng" ></td>
            <td><input type="text" class="form-control form-control-sm" name="remEng"></td>
            <td>
              <button type="button" class="btn btn-sm btn-link p-0" data-bs-toggle="collapse" data-bs-target="#engDetails">Breakdown</button>
            </td>
          </tr>
          <tr class="collapse" id="engDetails">
            <td colspan="2"> {{-- Keep colspan 5 if your parent table has 5 columns --}}
              <table id="engineeringSubTable" class="table table-sm table-bordered text-center mb-0 w-100">
                <thead>
                  <tr>
                    <th>Name (Month - Payment Period)</th>
                    <th>Amount</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($engineeringEntries as $eng)
                  <tr>
                    <td>{{ $eng->name }} ({{ $eng->month }} - {{ $eng->payment_periods }})</td>
                    <td>{{ number_format($eng->amount, 2) }}</td>
                  </tr>
                  @empty
                    <tr>
                      <td></td>
                      <td class="text-muted">No entries found.</td>
                    </tr>
                    @endforelse

                </tbody>
              </table>
            </td>
          </tr>

          <tr>
            <td class="fw-bold">Engineering Balance</td>
            <td></td>
            <td class="fw-bold" id="engineeringBalance">0.00</td>
            <td colspan="2"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

{{-- MQC Section --}}
<div class="card border-0 mb-4 shadow-sm">
  <div class="card-body p-3">
    <h6 class="fw-bold mb-3">MQC</h6>
    <table class="table table-sm table-bordered text-center align-middle">
      <thead>
        <tr>
          <th style="width: 20%;">Category</th>
          <th style="width: 20%;">Date</th>
          <th style="width: 20%;">Amount</th>
          <th style="width: 30%;">Remarks</th>
          <th style="width: 10%;">Show</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>MQC</td>
          <td><input type="date" class="form-control form-control-sm" name="dateMqc"></td>
          <td><input type="text" class="form-control form-control-sm" name="amountMqc"></td>
          <td><input type="text" class="form-control form-control-sm" name="remMqc"></td>
          <td>
            <button type="button" class="btn btn-sm btn-link p-0" data-bs-toggle="collapse" data-bs-target="#mqcDetails">Breakdown</button>
          </td>
        </tr>
        <tr class="collapse" id="mqcDetails">
          <td colspan="2">
            <table id="mqcSubTable" class="table table-sm table-bordered text-center mb-0 w-100">
              <thead>
                <tr>
                  <th>Name (Month - Payment Period)</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
                @forelse($mqcEntries as $mqc)
                <tr>
                  <td>{{ $mqc->name }} ({{ $mqc->month }} - {{ $mqc->payment_periods }})</td>
                  <td>{{ number_format($mqc->amount, 2) }}</td>
                </tr>
                @empty
                  <tr>
                    <td></td>
                    <td class="text-muted">No entries found.</td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td class="fw-bold">MQC Balance</td>
          <td></td>
          <td class="fw-bold" id="mqcBalance">0.00</td>
          <td colspan="2"></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>


<!-- {{-- Contingency Section --}}
<div class="card border-0 mb-4 shadow-sm">
  <div class="card-body p-3">
    <h6 class="fw-bold mb-3">Contingency</h6>
    <table class="table table-sm table-bordered text-center align-middle">
      <thead>
        <tr>
          <th style="width: 20%;">Category</th>
          <th style="width: 20%;">Date</th>
          <th style="width: 20%;">Amount</th>
          <th style="width: 30%;">Remarks</th>
          <th style="width: 10%;">Show</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Contingency</td>
          <td><input type="date" class="form-control form-control-sm" name="dateContingency"></td>
          <td><input type="text" class="form-control form-control-sm" name="amountContingency"></td>
          <td><input type="text" class="form-control form-control-sm" name="remContingency"></td>
          <td>
            <button type="button" class="btn btn-sm btn-link p-0" data-bs-toggle="collapse" data-bs-target="#contingencyDetails">Breakdown</button>
          </td>
        </tr>
        <tr class="collapse" id="contingencyDetails">
          <td colspan="2">
            <table id="contingencySubTable" class="table table-sm table-bordered text-center mb-0 w-100">
              <thead>
                <tr>
                  <th>Name (Month - Payment Period)</th>
                  <th>Amount</th>
                </tr>
              </thead>
              <tbody>
              
              </tbody>
            </table>
          </td>
        </tr>
        <tr>
          <td class="fw-bold">Contingency Balance</td>
          <td></td>
          <td class="fw-bold" id="contingencyBalance">0.00</td>
          <td colspan="2"></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
 -->

  {{-- Totals Section --}}
  <div class="card border-0 mb-4 shadow-sm">
    <div class="card-body p-3">
      <h6 class="fw-bold mb-3">Summary</h6>
      <table class="table table-sm table-bordered text-center align-middle">
        <thead>
          <tr>
            <th style="width: 40%;">Category</th>
            <th style="width: 60%;">Amount</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Total Expenditures</td>
            <td><input type="text" class="form-control form-control-sm" id="amountTotal"></td>
         </tr>
          <tr>
            <td>Total Savings</td>
            <td><input type="text" class="form-control form-control-sm" id="amountSavings"></td>
           </tr>
        </tbody>
      </table>
    </div>

      <div class="text-end mt-3">
      
      </div>
    </fieldset>

    <!-- Save Button -->
    <div class="text-end mt-4">
    <button type="button" id="submitFundsUtilization" class="btn btn-primary">Save Fund Utilization</button>
    </div>
  </form>
</div>
</section>

<script>
document.addEventListener('DOMContentLoaded', () => {
    function parseAmount(value) {
        value = value?.toString().replace(/,/g, '').trim(); // Remove commas
        return parseFloat(value) || 0;
    }

    function calculateExpenditureAndSavings() {
        // Get contract amount
        
        const contractAmount = parseAmount(document.getElementById('contract_amount')?.value);

        // Get Mobilization
        const mobilization = parseAmount(document.getElementById('amountMobilization')?.value);

        // Get Partial Billings
        let partialTotal = 0;
        for (let i = 1; i <= 5; i++) {
            partialTotal += parseAmount(document.getElementById(`amountPartial${i}`)?.value);
        }

        // Get Final Billing
        const finalBilling = parseAmount(document.getElementById('amountFinal')?.value);

        // Get Engineering
        const engineering = parseAmount(document.querySelector('[name="amountEng"]')?.value);

        // Get MQC
        const mqc = parseAmount(document.querySelector('[name="amountMqc"]')?.value);

        // Get Contingency if it's visible in future
        const contingency = parseAmount(document.querySelector('[name="amountContingency"]')?.value);

        console.log({
          contractAmount,
          mobilization,
          partialTotal,
          finalBilling,
          engineering,
          mqc,
          contingency
        });

        // Compute total expenditure
        const totalExpenditure = mobilization + partialTotal + finalBilling + engineering + mqc + contingency;

        // Compute savings
        const savings = contractAmount - totalExpenditure;

        // Update the DOM
        document.getElementById('amountTotal').value = totalExpenditure.toFixed(2);
        document.getElementById('amountSavings').value = savings.toFixed(2);
    }

    // Attach blur listeners to amount inputs
    const amountInputs = document.querySelectorAll('.amount-input');
    amountInputs.forEach(input => {
        input.addEventListener('blur', calculateExpenditureAndSavings);
    });

    // Optional: Call once on load
    calculateExpenditureAndSavings();
});
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Update amountEng, amountMqc, amountContingency from actual_* inputs
    const updateAmountFields = () => {
      const engineeringValue = document.getElementById('actual_engineering')?.value || '';
      const mqcValue = document.getElementById('actual_mqc')?.value || '';
      const contingencyValue = document.getElementById('actual_contingency')?.value || '';

      const amountEngInput = document.querySelector('input[name="amountEng"]');
      if (amountEngInput) amountEngInput.value = engineeringValue;

      const amountMqcInput = document.querySelector('input[name="amountMqc"]');
      if (amountMqcInput) amountMqcInput.value = mqcValue;

      const amountContingencyInput = document.querySelector('input[name="amountContingency"]');
      if (amountContingencyInput) amountContingencyInput.value = contingencyValue;

      updateEngineeringBalance();
      updateMqcBalance(); // added for MQC balance
    };

    // Calculate Engineering Balance
    function updateEngineeringBalance() {
      const amountEngInput = document.querySelector('input[name="amountEng"]');
      const rawValue = amountEngInput?.value || '';
      const cleanedValue = rawValue.replace(/[^\d.-]/g, '');
      const amountEng = parseFloat(cleanedValue) || 0;

      const engRows = document.querySelectorAll('#engineeringSubTable tbody tr');
      let sumEngineeringEntries = 0;

      engRows.forEach(row => {
        const amountCell = row.cells[1];
        if (amountCell) {
          const val = parseFloat(amountCell.textContent.replace(/,/g, ''));
          if (!isNaN(val)) {
            sumEngineeringEntries += val;
          }
        }
      });

      const balance = amountEng - sumEngineeringEntries;
      const balanceElem = document.getElementById('engineeringBalance');
      if (balanceElem) {
        balanceElem.textContent = balance.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      }
    }

    // ✅ Calculate MQC Balance
    function updateMqcBalance() {
      const amountMqcInput = document.querySelector('input[name="amountMqc"]');
      const rawValue = amountMqcInput?.value || '';
      const cleanedValue = rawValue.replace(/[^\d.-]/g, '');
      const amountMqc = parseFloat(cleanedValue) || 0;

      const mqcRows = document.querySelectorAll('#mqcSubTable tbody tr');
      let sumMqcEntries = 0;

      mqcRows.forEach(row => {
        const amountCell = row.cells[1];
        if (amountCell) {
          const val = parseFloat(amountCell.textContent.replace(/,/g, ''));
          if (!isNaN(val)) {
            sumMqcEntries += val;
          }
        }
      });

      const balance = amountMqc - sumMqcEntries;
      const balanceElem = document.getElementById('mqcBalance');
      if (balanceElem) {
        balanceElem.textContent = balance.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      }
    }

    // Initial update after page load
    setTimeout(updateAmountFields, 100);

    // Update when actual_* inputs change
    ['actual_engineering', 'actual_mqc', 'actual_contingency'].forEach(id => {
      const input = document.getElementById(id);
      if (input) {
        input.addEventListener('input', updateAmountFields);
        input.addEventListener('change', updateAmountFields);
      }
    });

    // Update balances when amount inputs change manually
    const amountEngInput = document.querySelector('input[name="amountEng"]');
    if (amountEngInput) {
      amountEngInput.addEventListener('input', updateEngineeringBalance);
      amountEngInput.addEventListener('change', updateEngineeringBalance);
    }

    const amountMqcInput = document.querySelector('input[name="amountMqc"]');
    if (amountMqcInput) {
      amountMqcInput.addEventListener('input', updateMqcBalance);
      amountMqcInput.addEventListener('change', updateMqcBalance);
    }
  });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const actualContractAmount = document.getElementById("actual_contract_amount");
    const contractAmount = document.getElementById("contract_amount");

    if (actualContractAmount && contractAmount) {
        // Set initial value
        contractAmount.value = actualContractAmount.value;

        // Update on input
        actualContractAmount.addEventListener("input", () => {
            contractAmount.value = actualContractAmount.value;
        });
    }
});
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const actualContractAmountInput = document.getElementById("actual_contract_amount");
  const contractAmountInput = document.getElementById("contract_amount");
  const balanceDisplay = document.getElementById("contractBalance");

  const inputIds = [
    'amountMobilization',
    'amountPartial1',
    'amountPartial2',
    'amountPartial3',
    'amountPartial4',
    'amountPartial5',
    'amountFinal'
  ];

  function formatNumber(num) {
    return num.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
  }

  function getSanitizedValue(input) {
    return parseFloat(input.value.replace(/₱|,/g, '').trim()) || 0;
  }

  function calculateBalance(triggerInput = null) {
    const contractAmount = getSanitizedValue(actualContractAmountInput);
    let total = 0;

    inputIds.forEach(id => {
      const input = document.getElementById(id);
      if (input) {
        total += getSanitizedValue(input);
      }
    });

    const balance = contractAmount - total;

    // Update balance display
    if (balanceDisplay) {
      balanceDisplay.textContent = formatNumber(balance);
    }

    // Update visible contract amount input
    if (contractAmountInput) {
      contractAmountInput.value = formatNumber(contractAmount);
    }

    // Exceeded contract amount
    if (balance < 0 && triggerInput) {
      Swal.fire({
        icon: 'warning',
        title: 'Exceeded Allocation',
        text: 'Total billing exceeds the allocated Contract Amount!',
        confirmButtonText: 'OK'
      }).then(() => {
        triggerInput.value = '';  // Clear the field
        triggerInput.focus();
        calculateBalance(); // Recalculate after clearing
      });
    }
  }

  // Add input listeners for billing fields
  inputIds.forEach(id => {
    const input = document.getElementById(id);
    if (input) {
      input.addEventListener('input', () => calculateBalance(input));
      input.addEventListener('blur', function () {
        const val = getSanitizedValue(this);
        this.value = val ? formatNumber(val) : '';
      });
    }
  });

  // Add listener for changes to actual_contract_amount
  if (actualContractAmountInput) {
    actualContractAmountInput.addEventListener("input", () => calculateBalance());
  }

  // Initial balance calculation
  calculateBalance();
});
</script>



<script>
  let currentBilling = 1;

  // Show next billing row
  function addNextBilling() {
    if (currentBilling < 5) {
      currentBilling++;
      const nextRow = document.querySelector(`.billing-${currentBilling}`);
      if (nextRow) {
        nextRow.style.display = 'table-row';
      }
    }
  }

  // Hide last billing row if needed
  function removeLastBilling() {
    if (currentBilling > 1) {
      const rowToHide = document.querySelector(`.billing-${currentBilling}`);
      if (rowToHide) {
        rowToHide.style.display = 'none';
        // Optional: clear the inputs
        rowToHide.querySelectorAll('input').forEach(input => input.value = '');
      }
      currentBilling--;
    }
  }

  // On page load, auto-show rows that have any value
  document.addEventListener('DOMContentLoaded', () => {
    for (let i = 2; i <= 5; i++) {
      const row = document.querySelector(`.billing-${i}`);
      const hasValue = Array.from(row.querySelectorAll('input')).some(input => input.value.trim() !== '');

      if (hasValue) {
        row.style.display = 'table-row';
        currentBilling = i; // Update currentBilling to the highest visible row
      } else {
        row.style.display = 'none'; // Ensure it's hidden if empty
      }
    }
  });

  document.addEventListener('DOMContentLoaded', () => {
  
    const voCount = parseInt(document.getElementById('voCount').value) || 1;
    const keys = ['contract_amount', 'engineering', 'mqc']; // add all your keys here

    function updateActualValues() {
      keys.forEach(key => {
        const origInput = document.getElementById(`orig_${key}`);
        const actualInput = document.getElementById(`actual_${key}`);

        let actualVal = '';

        // Check all VO inputs in order, pick the first non-empty value
        for (let i = 1; i <= voCount; i++) {
          const voInput = document.getElementById(`vo_${key}_${i}`);
          if (voInput && voInput.value.trim() !== '') {
            actualVal = voInput.value.trim();
            break; // stop checking further if found a VO value
          }
        }

        // If no VO values found, fallback to original
        if (actualVal === '') {
          actualVal = origInput ? origInput.value.trim() : '';
        }

        if (actualInput) {
          actualInput.value = actualVal;
        }
      });
    }

    // Run on page load
    updateActualValues();

    // Attach event listeners to all relevant inputs (orig + all VOs) to update live
    keys.forEach(key => {
      const origInput = document.getElementById(`orig_${key}`);
      if (origInput) origInput.addEventListener('input', updateActualValues);

      for (let i = 1; i <= voCount; i++) {
        const voInput = document.getElementById(`vo_${key}_${i}`);
        if (voInput) voInput.addEventListener('input', updateActualValues);
      }
    });
  });
</script>


<script>
  
document.addEventListener('DOMContentLoaded', function () {

  $(document).ready(function () {
  $("#engineering_input").on("click", function () {
    $("#engineeringFormWrapper").slideDown(); // Show engineering
    $("#mqcFormWrapper").slideUp();           // Hide MQC
  });

  $("#mqc_input").on("click", function () {
    $("#mqcFormWrapper").slideDown();         // Show MQC
    $("#engineeringFormWrapper").slideUp();   // Hide engineering
  });
});

  $(document).ready(function () {
  const engTable = $('#engineeringSubTable');
  if (engTable.length && engTable.find('tbody tr').not('.text-muted').length) {
    engTable.DataTable({
      paging: true,
      searching: false,
      info: false,
      ordering: true,
      responsive: true,
      language: {
        emptyTable: "No engineering details available"
      },
      columnDefs: [
        { targets: 1, type: 'num' }
      ]
    });
  }
});

$(document).ready(function () {
  const engTable = $('#mqcSubTable');
  if (engTable.length && engTable.find('tbody tr').not('.text-muted').length) {
    engTable.DataTable({
      paging: true,
      searching: false,
      info: false,
      ordering: true,
      responsive: true,
      language: {
        emptyTable: "No engineering details available"
      },
      columnDefs: [
        { targets: 1, type: 'num' }
      ]
    });
  }
});

// Calculate Mobilization Percentage
const percentInput = document.getElementById('percentMobi');
    const contractAmountInput = document.getElementById('actual_contract_amount');
    const amountMobilizationInput = document.querySelector('input[name="amountMobilization"]');

    function cleanMoney(value) {
        if (typeof value === 'string') {
            value = value.replace(/,/g, '');
        }
        return parseFloat(value) || 0;
    }

    function calculateMobilization() {
      let percent = parseFloat(percentInput.value);
      const contractAmount = cleanMoney(contractAmountInput.value);

      if (percent > 15) {
          percent = 15;
          percentInput.value = 15;
      }

      const mobilizationAmount = (percent / 100) * contractAmount;

      if (!isNaN(mobilizationAmount)) {
          amountMobilizationInput.value = mobilizationAmount.toFixed(2);

          // Trigger the balance recalculation manually
          amountMobilizationInput.dispatchEvent(new Event('input'));
      }
  }

    percentInput.addEventListener('input', calculateMobilization);
    contractAmountInput.addEventListener('input', calculateMobilization);

  $(document).ready(function () {
  const monthNames = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];
  const currentMonth = monthNames[new Date().getMonth()];

  $("#engMonth").val(currentMonth);
  $("#mqcMonth").val(currentMonth);
});

  const projectId = '{{ $project->id ?? 0 }}'; // Ensure $project is passed to the view

  // Function to clean money input (e.g., remove commas or currency signs)
  function cleanMoney(value) {
    return value.replace(/[^0-9.]/g, '');
  }

  // Submit Engineering Entry
  $(document).ready(function () {
  const projectId = '{{ $project->id ?? 0 }}';

  function cleanMoney(value) {
    return value.replace(/[^0-9.]/g, '');
  }

  // Engineering AJAX
  $("#addEngineeringEntry").on("click", function () {
    const name = $("#engName").val();
    const month = $("#engMonth").val();
    const paymentPeriod = $("#engPaymentPeriod").val();
    const amount = cleanMoney($("#engAmount").val());
    const type = $("#engType").val();

    if (!name || !month || !paymentPeriod || !amount) {
      Swal.fire({ icon: "warning", title: "Please fill in all Engineering fields." });
      return;
    }

    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: `/projects/fund-utilization/${projectId}/details`,
      method: "POST",
      data: { name, month, payment_period: paymentPeriod, amount, type },
      success: function (response) {
            if (response.success) {
              Swal.fire({ icon: "success", title: "Engineering entry added!" }).then(() => {
            $("#engName, #engMonth, #engPaymentPeriod, #engAmount").val("");
              });
            } else {
              Swal.fire({ icon: "error", title: response.message || "Failed to add Engineering entry." });
            }
          }
    });
  });

  // MQC AJAX
  $("#addMqcEntry").on("click", function () {
    const name = $("#mqcName").val();
    const month = $("#mqcMonth").val();
    const paymentPeriod = $("#mqcPaymentPeriod").val();
    const amount = cleanMoney($("#mqcAmount").val());
    const type = $("#mqcType").val();

    if (!name || !month || !paymentPeriod || !amount) {
      Swal.fire({ icon: "warning", title: "Please fill in all MQC fields." });
      return;
    }

    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: `/projects/fund-utilization/${projectId}/details`,
      method: "POST",
      data: { name, month, payment_period: paymentPeriod, amount, type },
      success: function (response) {
          if (response.success) {
            Swal.fire({ icon: "success", title: "MQC entry added!" }).then(() => {
              $("#mqcName, #mqcMonth, #mqcPaymentPeriod, #mqcAmount").val("");
    
            });
          } else {
            Swal.fire({ icon: "error", title: response.message || "Failed to add MQC entry." });
          }
        }

    });
  });
});
});
</script>


<script>
  // Hide both forms initially (in case class="d-none" is overridden)
  document.getElementById('engineeringFormWrapper').style.display = 'none';
  document.getElementById('mqcFormWrapper').style.display = 'none';

  // Show Engineering Form
  document.getElementById('engineering_input').onclick = function () {
    const engForm = document.getElementById('engineeringFormWrapper');
    if (engForm.style.display === 'none') {
      engForm.style.display = 'flex'; // or 'block' depending on your layout
    } else {
      engForm.style.display = 'none';
    }
  };

  // Show MQC Form
  document.getElementById('mqc_input').onclick = function () {
    const mqcForm = document.getElementById('mqcFormWrapper');
    if (mqcForm.style.display === 'none') {
      mqcForm.style.display = 'flex'; // or 'block'
    } else {
      mqcForm.style.display = 'none';
    }
  };


</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    $('#engineering_input').on('click', function () {
      $('#engineeringFormWrapper').toggleClass('d-none');
    });

    $('#mqc_input').on('click', function () {
      $('#mqcFormWrapper').toggleClass('d-none');
    });
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

@endsection
