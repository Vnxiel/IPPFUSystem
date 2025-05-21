@extends('systemAdmin.layout')

@section('title', 'Funds Utilization')

@section('content')
<section class="container-fluid py-4">
  <!-- Header -->
  <div class="row">
    <div class="col-12 d-flex align-items-center gap-2 mb-4" style="margin-top: 75px;">
      <a href="{{ url('/systemAdmin/overview/' . $project['id']) }}" 
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
        <h5 class="card-title mb-0">{{ $project['projectTitle'] ?? 'Project Title' }}</h5>
      </div>

      <div class="card-body">
        <fieldset class="border p-3 mb-4 rounded shadow-sm">
          <legend class="float-none w-auto px-3 fw-bold text-primary">
             <i class="fas fa-money-bill-wave me-2"></i>
            Fund Source
          </legend>

          <!-- Fund Source Section -->
          <div class="section mb-4">            
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
                    <th>Actual</th>
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
                      <input type="text" class="form-control amount-input" id="orig_{{ $key }}" name="orig_{{ $key }}"
                        value="{{ $funds['orig_' . $key] ?? '' }}">
                    </td>

                    {{-- Always show VO 1 --}}
                    <td>
                      <input type="text" class="form-control amount-input" id="vo_{{ $key }}_1" name="vo_{{ $key }}_1"
                        value="{{ $vo1 ? $vo1->{'vo_' . $key} : '' }}">
                    </td>

                    {{-- Render remaining VO columns (VO 2 and up) --}}
                    @foreach ($variationOrders as $vo)
                    @if ($vo->vo_number != 1)
                    <td>
                      <input type="text" class="form-control amount-input" id="vo_{{ $key }}_{{ $vo->vo_number }}"
                        name="vo_{{ $key }}_{{ $vo->vo_number }}" value="{{ $vo->{'vo_' . $key} ?? '' }}">
                    </td>
                    @endif
                    @endforeach

                    {{-- Actual --}}
                    <td>
                      <input type="text" class="form-control amount-input" id="actual_{{ $key }}" name="actual_{{ $key }}"
                        value="{{ $funds['actual_' . $key] ?? '' }}">
                    </td>
                  </tr>
                  @endforeach

                  <tr class="fw-bold">
                    <td>Total</td>
                    <td><input type="text" class="form-control" id="orig_total" name="orig_total" readonly></td>
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
        </fieldset>

        <fieldset class="border p-3 mb-4 rounded shadow-sm">
          <legend class="float-none w-auto px-3 fw-bold text-primary">
            <i class="fas fa-chart-pie text-primary"></i>
            Fund Utilization Summary
          </legend>
          <!-- Fund Utilization Summary Section -->
          <div class="section mb-4">
            <h5 class="section-title d-flex align-items-center gap-2 mb-3">
              <i class="fas fa-chart-pie text-primary"></i>
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

            <!-- Mobilization Input -->
            <div class="row mb-4">
              <div class="col-md-3">
                <div class="form-group">
                  <label class="form-label fw-semibold">
                    <i class="fas fa-percentage text-muted me-1"></i>
                    Mobilization Percentage
                  </label>
                  <input type="number" max="15" min="0" step="0.01" 
                        class="form-control form-control-sm" 
                        id="percentMobi" name="percentMobi" 
                        placeholder="Enter percentage (0-15)">
                </div>
              </div>
            </div>

            <!-- Contract Summary Card -->
            <div class="card border shadow-sm mb-4">
              <div class="card-header bg-light py-2">
                <h6 class="card-title mb-0">
                  <i class="fas fa-file-contract text-primary me-2"></i>
                  Contract Summary
                </h6>
              </div>
              <div class="card-body">
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
                      <td><input type="text" class="form-control amount-input text-end" id="contract_amount"
                          name="contract_amount" readonly></td>
                      <td></td>
                    </tr>
                    <tr>
                      <td>Mobilization</td>
                      <td>
                        <input type="date" class="form-control form-control-sm" name="dateMobilization"
                          value="{{ $summary['mobilization']['date'] ?? '' }}">
                      </td>
                      <td>
                        <input type="text" class="form-control form-control-sm amount-input expenditure-amount"
                          name="amountMobilization" id="amountMobilization"
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
                        <input type="date" class="form-control form-control-sm " name="partialBillings[{{ $i }}][date]"
                          value="{{ $partial_billings[$i - 1]['date'] ?? '' }}">
                      </td>
                      <td>
                        <input type="text" class="form-control form-control-sm amount-input expenditure-amount"
                          name="partialBillings[{{ $i }}][amount]" id="amountPartial{{ $i }}"
                          value="{{ $partial_billings[$i - 1]['amount'] ?? '' }}">
                      </td>
                      <td>
                        <input type="text" class="form-control form-control-sm" name="partialBillings[{{ $i }}][remarks]"
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
                          <input type="text" class="form-control form-control-sm amount-input expenditure-amount"
                            name="amountFinal" id="amountFinal" value="{{ $summary['final']['amount'] ?? '' }}">
                        </td>
                        <td>
                          <input type="text" class="form-control form-control-sm" name="remFinal"
                            value="{{ $summary['final']['remarks'] ?? '' }}">
                        </td>
                      </tr>

                      <tr>
                        <td class="fw-bold">Balance</td>
                        <td></td>
                        <td id="contractBalance" class="fw-bold text-end">0.00</td>
                        <td></td>
                      </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Engineering Section Card -->
            <div class="card border shadow-sm mb-4">
              <div class="card-header bg-light py-2">
                <h6 class="card-title mb-0">
                  <i class="fas fa-hard-hat text-primary me-2"></i>
                  Engineering Details
                </h6>
              </div>
              <div class="card-body">
                <h6 class="fw-bold mb-3">Engineering</h6>
                <table class="table table-sm table-bordered text-center align-middle">
                  <thead>
                    <tr>
                      <th style="width: 20%;">Category</th>
                      <th style="width: 20%;">Date</th>
                      <th style="width: 20%;">Amount</th>
                      <th style="width: 30%;">Remarks</th>
                      <th style="width: 10%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Engineering</td>
                      <td><input type="date" class="form-control form-control-sm" name="dateEng"
                          value="{{ $summary['engineering']['date'] ?? '' }}"></td>
                      <td><input type="text" class="form-control form-control-sm text-end expenditure-amount"
                          name="amountEng" id="amountEng" value="{{ $summary['engineering']['amount'] ?? '' }}" readonly>
                      </td>
                      <td><input type="text" class="form-control form-control-sm" name="remEng"
                          value="{{ $summary['engineering']['remarks'] ?? '' }}"></td>
                      <td>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse"
                          data-bs-target="#engDetails">
                          <i class="fas fa-list-ul"></i>
                        </button>
                      </td>
                    </tr>
                    <tr class="collapse" id="engDetails">
                      <td colspan="5">
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
                              <td data-amount="{{ $eng->amount }}">{{ number_format($eng->amount, 2) }}</td>
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
                      <td class="fw-bold text-end" id="engineeringBalance">0.00</td>
                      <td colspan="2"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- MQC Section Card -->
            <div class="card border shadow-sm mb-4">
              <div class="card-header bg-light py-2">
                <h6 class="card-title mb-0">
                  <i class="fas fa-clipboard-check text-primary me-2"></i>
                  MQC Details
                </h6>
              </div>
              <div class="card-body">
                <h6 class="fw-bold mb-3">MQC</h6>
                <table class="table table-sm table-bordered text-center align-middle">
                  <thead>
                    <tr>
                      <th style="width: 20%;">Category</th>
                      <th style="width: 20%;">Date</th>
                      <th style="width: 20%;">Amount</th>
                      <th style="width: 30%;">Remarks</th>
                      <th style="width: 10%;">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>MQC</td>
                      <td><input type="date" class="form-control form-control-sm" name="dateMqc"
                          value="{{ $summary['mqc']['date'] ?? '' }}"></td>
                      <td><input type="text" class="form-control form-control-sm text-end expenditure-amount"
                          name="amountMqc" id="amountMqc" value="{{ $summary['mqc']['amount'] ?? '' }}" readonly></td>
                      <td><input type="text" class="form-control form-control-sm" name="remMqc"
                          value="{{ $summary['mqc']['remarks'] ?? '' }}"></td>
                      <td>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse"
                          data-bs-target="#mqcDetails">
                          <i class="fas fa-list-ul"></i>
                        </button>
                      </td>
                    </tr>
                    <tr class="collapse" id="mqcDetails">
                      <td colspan="5">
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
                              <td data-amount="{{ $eng->amount }}">{{ number_format($mqc->amount, 2) }}</td>
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
                      <td class="fw-bold text-end" id="mqcBalance">0.00</td>
                      <td colspan="2"></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Totals Section Card -->
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
              </div>
            </div>

        </fieldset>

        <!-- Save Button -->
        <div class="text-end mt-4">
          <button type="button" id="submitFundsUtilization" 
                  class="btn btn-primary px-4">
            <i class="fas fa-save me-2"></i>
            Save Changes
          </button>
        </div>
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

@include('systemAdmin.modals.Funds_Utilization.add-eng_mqc')
@section('page-scripts')
<script src="{{ asset('js/FundsUtilization/funds_utilization-submit.js') }}"></script>

<script src="{{ asset('js/FundsUtilization/funds_utilization-addBreakdown.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-setCurrencyFormatting.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-setvalue.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-valueLimit.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/add-set.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-Totals.js') }}"></script>
@endsection