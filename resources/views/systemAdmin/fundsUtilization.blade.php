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
    <!-- Trigger Button -->
      <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#entryModal">
        Add Engineering or MQC Entry
      </button>
      <button id="btnAddBilling" type="button" class="btn btn-outline-primary btn-sm me-2">
        <i class="fa-solid fa-square-plus"></i> Add Billing
      </button>

      <button id="btnRemoveBilling" type="button" class="btn btn-outline-danger btn-sm">
        <i class="fa-solid fa-circle-minus"></i> Remove Billing
      </button>

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
                id="contract_amount" name="contract_amount" readonly></td>
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
            <td id="contractBalance" class="fw-bold text-end">0.00</td>
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
            <td><input type="text" class="form-control form-control-sm text-end" name="amountEng" ></td>
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
            <td class="fw-bold text-end" id="engineeringBalance">0.00</td>
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
          <td><input type="text" class="form-control form-control-sm text-end" name="amountMqc"></td>
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
          <td class="fw-bold text-end" id="mqcBalance">0.00</td>
          <td colspan="2"></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

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
</script>
@endsection

@include('systemAdmin.modals.Funds_Utilization.add-eng_mqc')
