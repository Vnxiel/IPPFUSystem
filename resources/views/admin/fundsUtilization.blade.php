@extends('admin.layout')

@section('title', 'Funds Utilization')

@section('content')
<section class="container-fluid py-4">
  <!-- Header -->
  <div class="row">
    <div class="col-12 d-flex align-items-center gap-2 mb-2" style="margin-top: 75px;">
      <a href="{{ url('/admin/overview/' . $project['id']) }}" 
         class="btn btn-outline-secondary btn-sm">
        <i class="fa fa-arrow-left"></i>
      </a>
      <h4 class="mb-0">Funds Utilization</h4>
    </div>
  </div>

  <!-- Main Content -->
  <div class="card shadow">
    <form id="addFundUtilization" method="POST">
      @csrf      
      <!-- Project Title Card -->
      <div class="card-header bg-light py-3">
        <h5 class="card-title mb-0 text-primary">{{ $project['projectTitle'] ?? 'Project Title' }}</h5>
      </div>

      <div class="card-body">
        <fieldset class="border rounded shadow-sm p-2 w-100 h-100 mb-2">
          <legend class="float-none w-auto px-2 legend-text">
            <i class="fas fa-money-bill-wave me-2"></i>
            Fund Source and Utilization
          </legend>

          <!-- Fund Source Section -->
          <div class="section mb-2">
            <h5 class="section-title d-flex align-items-center gap-2 mb-2">
              <i class="fas fa-money-bill-wave"></i>
              Fund Source
            </h5>
            
            <div class="table-responsive">
              <table id="editableFundTable" class="table table-bordered table-hover align-middle">
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
                    <th>Actual Utilization</th>
                  </tr>
                </thead>
                <tbody>
                  <input type="hidden" id="voCount" name="voCount"
                    value="{{ count($variationOrders) > 0 ? count($variationOrders) : 1 }}">

                  @php
                  $fields = [
                  'Appropriation' => 'appropriation',
                  'ABC' => 'abc',
                  'Contract Amount' => 'contract_amount',
                  'Savings' => 'bid',
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
                      <input type="text" class="form-control amount-input text-end" id="orig_{{ $key }}" name="orig_{{ $key }}"
                        value="{{ $funds['orig_' . $key] ?? '' }}">
                    </td>

                    {{-- Always show VO 1 --}}
                    <td>
                      <input type="text" class="form-control amount-input text-end" id="vo_{{ $key }}_1" name="vo_{{ $key }}_1"
                        value="{{ $vo1 ? $vo1->{'vo_' . $key} : '' }}">
                    </td>

                    {{-- Render remaining VO columns (VO 2 and up) --}}
                    @foreach ($variationOrders as $vo)
                    @if ($vo->vo_number != 1)
                    <td>
                      <input type="text" class="form-control amount-input text-end" id="vo_{{ $key }}_{{ $vo->vo_number }}"
                        name="vo_{{ $key }}_{{ $vo->vo_number }}" value="{{ $vo->{'vo_' . $key} ?? '' }}">
                    </td>
                    @endif
                    @endforeach

                    {{-- Actual --}}
                    <td>
                        <input type="text" class="form-control amount-input text-end" id="actual_{{ $key }}" name="actual_{{ $key }}"
                              value="{{ $funds['actual_' . $key] ?? '' }}" >
                      </td>
                  @endforeach

                  <tr class="fw-bold">
                    <td>Total</td>
                    <td><input type="text" class="form-control text-end" id="orig_total" name="orig_total" readonly></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="text-end mt-3">
              <button type="button" class="btn btn-outline-primary btn-sm" onclick="addVOFields()">
                <i class="fa-solid fa-plus"></i> Add Variation Order
              </button>
            </div>
        </div>
        <hr>
        <!-- Fund Utilization Summary Section -->
        <div class="section mb-1">
          <h5 class="section-title d-flex align-items-center gap-2 mb-3">
            <i class="fas fa-chart-pie"></i>
            Fund Utilization Summary
          </h5>

          <!-- Action Buttons -->
          <div class="d-flex flex-wrap gap-2 mb-4">
            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#entryModal">
              <i class="fas fa-plus-circle"></i> Add Engineering/MQC Entry
            </button>
            <button id="btnAddBilling" type="button" class="btn btn-outline-success btn-sm">
              <i class="fas fa-file-invoice-dollar"></i> Add Billing
            </button>
            <button id="btnRemoveBilling" type="button" class="btn btn-outline-danger btn-sm">
              <i class="fas fa-minus-circle"></i> Remove Billing
            </button>
          </div>

        

          <!-- Revised Contract Summary Card -->
            <div class="card border shadow-sm mb-4">
              <div class="card-body">
                <table class="table table-sm table-bordered text-center align-middle">
                  <thead>
                    <tr>
                      <th style="width: 20%;">Date</th>
                      <th style="width: 30%;">Particulars</th>
                      <th style="width: 20%;">Amount</th>
                      <th style="width: 30%;">Remarks</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td></td>
                      <td>Contract Amount</td>
                      <td><input type="text" class="form-control text-end" id="contract_amount" name="contract_amount" readonly></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>
                        <input type="date" class="form-control form-control-sm" name="dateMobilization"
                              value="{{ $summary['mobilization']['date'] ?? '' }}">
                      </td>
                      <td>
                        <div class="d-flex align-items-center">
                          <span class="fw-normal me-3">Mobilization</span>
                          <input type="number" max="15" min="0" step="0.01"
                                class="form-control form-control-sm w-50"
                                id="percentMobi" name="percentMobi"
                                placeholder="0–15"  value="{{ $summary['mobilization']['percentMobi'] ?? '' }}"
                               >
                          <span class="ms-1 text-muted small"><i class="fas fa-percentage"></i></span>
                        </div>
                      </td>

                      <td>
                        <input type="text" class="form-control form-control-sm text-end expenditure-amount"
                              name="amountMobilization" id="amountMobilization"
                              value="{{ $summary['mobilization']['amount'] ?? '' }}">
                      </td>
                      <td colspan="2">
                        <input type="text" class="form-control form-control-sm" name="remMobilization"
                              value="{{ $summary['mobilization']['remarks'] ?? '' }}">
                      </td>
                    </tr>


                    <!-- Partial Billing Rows -->
                    @for ($i = 1; $i <= 5; $i++)
                    <tr class="partial-billing billing-{{ $i }}" style="{{ $i > 1 ? 'display: none;' : '' }}">
                      <td>
                        <input type="date" class="form-control form-control-sm" name="partialBillings[{{ $i }}][date]"
                              value="{{ $partial_billings[$i - 1]['date'] ?? '' }}">
                      </td>
                      <td>{{ $i }}{{ $i == 1 ? 'st' : ($i == 2 ? 'nd' : ($i == 3 ? 'rd' : 'th')) }} Partial Billing</td>
                      <td>
                        <input type="text" class="form-control form-control-sm text-end expenditure-amount"
                              name="partialBillings[{{ $i }}][amount]" id="amountPartial{{ $i }}"
                              value="{{ $partial_billings[$i - 1]['amount'] ?? '' }}">
                      </td>
                      <td colspan="2">
                        <input type="text" class="form-control form-control-sm" name="partialBillings[{{ $i }}][remarks]"
                              value="{{ $partial_billings[$i - 1]['remarks'] ?? '' }}">
                      </td>
                    </tr>
                    @endfor

                    <tr>
                      <td>
                        <input type="date" class="form-control form-control-sm" name="dateFinal" value="{{ $summary['final']['date'] ?? '' }}">
                      </td>
                      <td>Final Billing</td>
                      <td>
                        <input type="text" class="form-control form-control-sm text-end expenditure-amount"
                              name="amountFinal" id="amountFinal" value="{{ $summary['final']['amount'] ?? '' }}">
                      </td>
                      <td colspan="2">
                        <input type="text" class="form-control form-control-sm" name="remFinal" value="{{ $summary['final']['remarks'] ?? '' }}">
                      </td>
                    </tr>
                    <tr>
                      <td></td>
                      <td class="fw-bold">Balance</td>
                      <td id="contractBalance" class="fw-bold text-end">0.00</td>
                      <td></td>
                    </tr>

                    <!-- ENGINEERING Table -->
                    <tr>
                      <td></td>
                      <td>Engineering</td>
                      <td>
                        <input type="text" class="form-control form-control-sm text-end expenditure-amount"
                              name="amountEng" id="amountEng" value="{{ $summary['engineering']['amount'] ?? '' }}" readonly>
                      </td>
                      <td colspan="2">
                        <div class="d-flex justify-content-between align-items-center">
                          <input type="text" class="form-control form-control-sm me-2" name="remEng" 
                                value="{{ $summary['engineering']['remarks'] ?? '' }}">
                          <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#engDetails">
                            <i class="fas fa-list-ul"></i>
                          </button>
                        </div>
                      </td>
                    </tr>

                  <tr class="collapse" id="engDetails">
                    <td colspan="5">
                      <table id="engineeringSubTable" class="table table-sm table-bordered text-center mb-0 w-100">
                        <thead>
                          <tr>
                          <th>Date</th>
                            <th>Name - (Payment Period)</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          @if($engineeringEntries->count() > 0)
                            @foreach($engineeringEntries as $eng)
                              <tr>
                                <td style="width: 20%;">{{ $eng->breakdown_date ? \Carbon\Carbon::parse($eng->breakdown_date)->format('Y-m-d') : 'N/A' }}</td>
                                <td style="width: 43%;">{{ $eng->name }} - {{ $eng->payment_periods }}</td>
                                <td class="text-end" data-amount="{{ $eng->amount }}">{{ number_format($eng->amount, 2) }}</td>
                              </tr>
                            @endforeach
                          @else
                            <tr>
                              <td colspan="3" class="text-muted">No entries found.</td>
                            </tr>
                          @endif
                        </tbody>

                      </table>
                    </td>
                  </tr>


                  <tr>
                    <td></td>
                    <td class="fw-bold">Engineering Balance</td>
                    <td class="fw-bold text-end" id="formEngineeringBalance" data-balance="0.00">₱0.00</td>
                   <td colspan="2"></td>
                  </tr>

                  <!-- MQC TABLE -->
                  <tr>
                    <td></td>
                    <td>MQC</td>
                    <td>
                      <input type="text" class="form-control form-control-sm text-end expenditure-amount"
                            name="amountMqc" id="amountMqc" value="{{ $summary['mqc']['amount'] ?? '' }}" readonly>
                    </td>
                    <td colspan="2">
                      <div class="d-flex justify-content-between align-items-center">
                        <input type="text" class="form-control form-control-sm me-2" name="remMqc" 
                              value="{{ $summary['mqc']['remarks'] ?? '' }}">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#mqcDetails">
                          <i class="fas fa-list-ul"></i>
                        </button>
                      </div>
                    </td>
                  </tr>

                    <tr class="collapse" id="mqcDetails">
                      <td colspan="5">
                      <table id="mqcSubTable" class="table table-sm table-bordered text-center mb-0 w-100">
                        <thead>
                          <tr>
                          <th>Date</th>
                            <th>Name (Month - Payment Period)</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse($mqcEntries as $mqc)
                          <tr>
                          <td style="width: 20%;">{{ $mqc->breakdown_date ? \Carbon\Carbon::parse($mqc->breakdown_date)->format('M d, Y') : 'N/A' }}</td>
                            <td style="width: 43%;">{{ $mqc->name }} ({{ $mqc->month }} - {{ $mqc->payment_periods }})</td>
                            <td class="text-end" data-amount="{{ $mqc->amount }}">{{ number_format($mqc->amount, 2) }}</td>
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
                    <td></td>
                    <td class="fw-bold">MQC Balance</td>
                    <td class="fw-bold text-end" id="formMqcBalance">0.00</td>
                    <td colspan="2"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Total Expenditures</td>
                    <td><input type="text" class="form-control form-control-sm text-end" id="amountTotal" name="amountTotal"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td>Total Savings</td>
                    <td><input type="text" class="form-control form-control-sm text-end" id="amountSavings" name="amountSavings"></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <!-- Add this somewhere in your Blade HTML template -->
          <div id="projectMeta" data-project-id="{{ $project['id'] ?? 0 }}"></div>
          </div>
        </div>

            <div class="row text-end mt-2">
              <div class="text-end mt-4">
                <button type="button" id="submitFundsUtilization" 
                        class="btn btn-primary px-4">
                  <i class="fas fa-save me-2"></i>
                  Save Changes
                </button>
              </div>
            </div>
            </div>
            </fieldset>
            </div>
            </form>
            </div>
      </section>
          


<style>
.section {
  background: #fff;
  border-radius: 0.5rem;
  padding: 1.5rem;
}

.section-title {
  color: #2c3e50;
  font-weight: 600;
}

.table th {
  background: #f8f9fa;
  font-weight: 600;
}

.form-control:focus {
  border-color: #2196F3;
  box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
}

.btn {
  font-weight: 500;
  letter-spacing: 0.3px;
}

.card {
  transition: all 0.3s ease;
}

.card:hover {
  transform: translateY(-2px);
}
</style>

@endsection



@include('admin.modals.Funds_Utilization.add-eng_mqc')

@section('page-scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
  const percentInput = document.getElementById('percentMobi');
  const amountInput = document.getElementById('amountMobilization');

  if (!percentInput || !amountInput) return;

  // When percent is cleared, clear amount
  percentInput.addEventListener('input', () => {
    const val = percentInput.value.trim();
    if (val === '' || isNaN(parseFloat(val))) {
      amountInput.value = '';
    }
  });

  // When amount is cleared, clear percent
  amountInput.addEventListener('input', () => {
    const val = amountInput.value.replace(/₱|,/g, '').trim();
    if (val === '' || isNaN(parseFloat(val))) {
      percentInput.value = '';
    }
  });

  const formatPeso = (value) => {
    if (!value) return '';

    // Strip all non-numeric and extra dots
    value = value.replace(/[^0-9.]/g, '');

    // Limit to one decimal point and two decimal places
    const match = value.match(/^(\d{0,})(\.\d{0,2})?/);
    const integer = match[1];
    const decimal = match[2] || '';

    // Add comma separators
    const withCommas = integer.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    return '₱' + withCommas + decimal;
  };

  const unformatPeso = (value) => value.replace(/[^0-9.]/g, '');

  const expenditureInputs = document.querySelectorAll('.expenditure-amount');

  expenditureInputs.forEach(input => {
    // Format on page load
    if (input.value.trim() !== '') {
      input.value = formatPeso(input.value);
    }

    input.addEventListener('input', function () {
      const unformatted = unformatPeso(input.value);
      input.value = formatPeso(unformatted);
      // Always move caret to the end
      input.setSelectionRange(input.value.length, input.value.length);
    });
  });

});

  </script>


<script src="{{ asset('js/FundsUtilization/funds_utilization-addBreakdown.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-submit.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-setCurrencyFormatting.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-setvalue.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-valueLimit.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/add-set.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-Totals.js') }}"></script>
@endsection