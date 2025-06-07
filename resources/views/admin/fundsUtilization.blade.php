@extends('admin.layout')

@section('title', 'Funds Utilization')

@section('content')
<div class="container-fluid py-4" style="background-color: transparent;">
  <div class="card mb-1 border-0 shadow-lg" style="margin-top:75px;">
    <div class="card-body p-2">
      <div class="d-flex align-items-center gap-2">
        <a href="{{ url('/systemAdmin/overview/' . $project['id']) }}" 
           class="btn btn-outline-secondary btn-sm">
          <i class="fa fa-arrow-left"></i>
        </a>
        <h5 class="mb-0">Funds Utilization</h5>
      </div>
    </div>
  </div>

  <!-- Main Content -->
  <div class="card shadow">
    <form id="addFundUtilization" method="POST">
      @csrf      
      <div class="card-header bg-light py-3">
        <h5 class="font-title-overview mb-0 text-uppercase">{{ $project['title'] ?? 'Project Title' }}</h5>
      </div>

      <div class="card-body">
        <!-- Fund Source Section -->
        <fieldset class="border rounded shadow-sm p-2 w-100 h-100 mb-2">
          <legend class="float-none w-auto px-2 legend-text">
            <i class="fas fa-money-bill-wave me-2"></i>
            Fund Source
          </legend>
          <div class="text-end mb-2">
            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addVOFields()">
              <i class="fa-solid fa-plus"></i> Add Variation Order
            </button>
          </div>
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
                  @php
                    $origTotal = 0;
                    $actualTotal = 0;
                  @endphp


                @foreach ($fields as $label => $key)
                @php
                  $origValue = isset($funds['orig_' . $key]) ? floatval(preg_replace('/[^\d.]/', '', $funds['orig_' . $key])) : 0;
                  $actualValue = isset($funds['actual_' . $key]) ? floatval(preg_replace('/[^\d.]/', '', $funds['actual_' . $key])) : 0;
                  $origTotal += $origValue;
                  $actualTotal += $actualValue;
                @endphp

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
                  <input 
                    type="text" 
                    class="form-control amount-input text-end" 
                    id="vo_{{ $key }}_1" 
                    name="vo_{{ $key }}_1"
                    value="{{ $vo1 ? $vo1->{'vo_' . $key} : '' }}"
                    {{ $key !== 'contract_amount' ? 'disabled' : '' }}>
                </td>

                {{-- Render remaining VO columns (VO 2 and up) --}}
                @foreach ($variationOrders as $vo)
                  @if ($vo->vo_number != 1)
                  <td>
                    <input 
                      type="text" 
                      class="form-control amount-input text-end" 
                      id="vo_{{ $key }}_{{ $vo->vo_number }}" 
                      name="vo_{{ $key }}_{{ $vo->vo_number }}" 
                      value="{{ $vo->{'vo_' . $key} ?? '' }}"
                      {{ $key !== 'contract_amount' ? 'disabled' : '' }}>
                  </td>
                  @endif
                @endforeach

                  {{-- Actual --}}
                  <td>
                    <input 
                      type="text" 
                      class="form-control amount-input text-end actual-input" 
                      id="actual_{{ $key }}" 
                      name="actual_{{ $key }}"
                      value="{{ $funds['actual_' . $key] ?? '' }}"
                      {{ $key !== 'contract_amount' ? 'disabled' : '' }}>
                  </td>

                @endforeach

                <tr class="fw-bold table-warning">
                    <td>Total</td>
                    <td>
                    <input type="text" class="form-control text-end" id="orig_total" name="orig_total" value="{{ number_format($origTotal, 2) }}" readonly>

                    </td>
                    {{-- Always one for VO 1 --}}
                      <td></td>

                    {{-- Dynamically render empty <td>s for each VO column --}}
                    @php
                        $voCount = count($variationOrders);
                    @endphp
                    @for ($i = 0; $i < ($voCount - 1); $i++)
                      <td></td>
                  @endfor
                    {{-- Actual Total Cell --}}
                  <td>   
                    <input type="text" class="form-control text-end" id="actual_total" name="actual_total" value="{{ number_format($actualTotal, 2) }}" readonly>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </fieldset>

        <!-- Fund Utilization Summary Section -->
        <fieldset class="border rounded shadow-sm p-2 w-100 h-100 mb-2">
          <legend class="float-none w-auto px-2 legend-text">
            <i class="fas fa-money-bill-wave me-2"></i>
            Fund Utilization Summary
          </legend>

          <!-- Action Buttons -->
          <div class="d-flex flex-wrap gap-2 mb-4 justify-content-end">
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
          <table class="table table-sm table-bordered text-center align-middle">
            <thead>
              <tr>
                <th style="width: 20%;">Particulars</th>
                <th style="width: 20%;">Amount</th>
                <th style="width: 10%;">Retention Percentage</th>
                <th style="width: 20%;">Retention Amount</th>
                <th style="width: 20%;">Total</th>
                <th style="width: 10%;">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Total Appropriation</td>
                <td><input type="text" class="form-control text-end" id="totalAppro" name="totalAppro"  value="{{ $funds['orig_appropriation'] ?? '' }}" readonly></td>
                <td></td><td></td><td></td><td></td>
              </tr>
              <tr>
                <td>Contract Amount</td>
                <td><input type="text" class="form-control text-end" id="contract_amount" name="contract_amount" readonly></td>
                <td></td><td></td><td></td><td></td>
              </tr>
              <tr>
                <td>
                  <div class="d-flex align-items-center">
                    <span class="fw-normal me-3">Mobilization</span>
                    <input type="number" max="15" min="0" step="0.01"
                          class="form-control form-control-sm w-50"
                          id="percentMobi" name="percentMobi"
                          placeholder="0–15"  value="{{ $summary['mobilization']['percentMobi'] ?? '' }}">
                    <span class="ms-1 text-muted small"><i class="fas fa-percentage"></i></span>
                  </div>
                </td>
              <td>
                <input type="text" class="form-control form-control-sm text-end expenditure-amount"
                      name="amountMobilization" id="amountMobilization"
                      value="{{ $summary['mobilization']['amount'] ?? '' }}">
              </td>
              <td>
                <!-- <input type="text" class="form-control form-control-sm text-end"
                      name="retentionMobiPercent" id="retentionMobiPercent"
                      value="10%"> -->
              </td>
              <td>
                <!-- <input type="text" class="form-control form-control-sm text-end expenditure-amount"
                      name="retentionMobiAmount" id="retentionMobiAmount" readonly> -->
              </td>
              <td>
                <!-- <input type="text" class="form-control form-control-sm text-end"
                      name="mobilizationTotal" id="mobilizationTotal" readonly> -->
              </td>
              <td class="text-center">
                <!-- <div class="form-check d-flex align-items-center gap-2 justify-content-center">
                      @php
                      $isMobilizationReleased = ($summary['mobilization']['remarks'] ?? '') === 'Release';
                    @endphp

                    <input class="form-check-input release-checkbox" type="checkbox" id="releaseMobilization"
                          data-label-id="labelMobi"
                          {{ $isMobilizationReleased ? 'checked' : '' }}>
                    <span id="labelMobi" class="small {{ $isMobilizationReleased ? 'text-success' : 'text-muted' }}">
                      {{ $isMobilizationReleased ? 'Released' : 'Not Released' }}
                    </span>
                </div> -->
              </td>
                </tr>

                @for ($i = 1; $i <= 5; $i++)
                  @php
                    $amount = $partial_billings[$i - 1]['amount'] ?? '';
                    $remarks = $partial_billings[$i - 1]['remarks'] ?? '';
                    $showRow = $i === 1 || !empty($amount);
                    $suffix = match($i) {
                      1 => 'st',
                      2 => 'nd',
                      3 => 'rd',
                      default => 'th',
                    };
                  @endphp
                  <tr class="partial-billing billing-{{ $i }}" style="{{ $showRow ? '' : 'display: none;' }}">
                    <td>{{ $i }}{{ $suffix }} Partial Billing</td>
                    <td>
                      <input type="text" class="form-control form-control-sm text-end expenditure-amount"
                            name="partialBillings[{{ $i }}][amount]" id="amountPartial{{ $i }}"
                            value="{{ $amount }}">
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm text-end"
                            name="partialBillings[{{ $i }}][retentionPercent]" id="retentionPartialPercent{{ $i }}"
                            value="10%" readonly>
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm text-end"
                            name="partialBillings[{{ $i }}][retentionAmount]" id="retentionPartialAmount{{ $i }}" readonly>
                    </td>
                    <td>
                      <input type="text" class="form-control form-control-sm text-end"
                            name="partialBillings[{{ $i }}][total]" id="totalPartial{{ $i }}" readonly>
                    </td>
                    <td class="text-center">
                      <div class="form-check d-flex align-items-center gap-2 justify-content-center">
                        @php
                          $remarks = $partial_billings[$i - 1]['remarks'] ?? '';
                          $isPartialReleased = $remarks === 'Release';
                        @endphp

                        <input class="form-check-input release-checkbox release-partial" type="checkbox"
                              id="releasePartial{{ $i }}" data-label-id="labelPartial{{ $i }}"
                              {{ $isPartialReleased ? 'checked' : '' }}>
                        <span id="labelPartial{{ $i }}" class="small {{ $isPartialReleased ? 'text-success' : 'text-muted' }}">
                          {{ $isPartialReleased ? 'Released' : 'Not Released' }}
                        </span>

                      </div>
                    </td>

                  </tr>
                @endfor

                <tr>
                  <td>Final Billing</td>
                  <td>
                    <input type="text" class="form-control form-control-sm text-end expenditure-amount"
                      name="amountFinal" id="amountFinal" value="{{ $summary['final']['amount'] ?? '' }}">
                  </td>
                  <td>
                    <input type="text" class="form-control form-control-sm text-end"
                          name="retentionFinalPercent" id="retentionFinalPercent"
                          value="10%" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control form-control-sm text-end"
                          name="retentionFinalAmount" id="retentionFinalAmount" readonly>
                  </td>
                  <td>
                    <input type="text" class="form-control form-control-sm text-end"
                          name="finalAmountTotal" id="finalAmountTotal" readonly>
                  </td>
                  <td class="text-center">
                    <div class="form-check d-flex align-items-center gap-2 justify-content-center">
                      @php
                        $isFinalReleased = ($summary['final']['remarks'] ?? '') === 'Release';
                      @endphp

                      <input class="form-check-input release-checkbox" type="checkbox" id="releaseFinal"
                            data-label-id="labelFinal"
                            {{ $isFinalReleased ? 'checked' : '' }}>
                      <span id="labelFinal" class="small {{ $isFinalReleased ? 'text-success' : 'text-muted' }}">
                        {{ $isFinalReleased ? 'Released' : 'Not Released' }}
                      </span>

                    </div>
                  </td>

                </tr>
                <tr>
                  <td class="fw-bold">Balance</td>
                  <td id="contractBalance" class="fw-bold text-end">0.00</td>
                  <td></td><td></td> <td></td><td></td>
                </tr>

                <!-- ENGINEERING Table -->
                <tr>
                  <td>Engineering</td>
                  <td>
                    <input type="text" class="form-control form-control-sm text-end expenditure-amount"
                          name="amountEng" id="amountEng" value="{{ $summary['engineering']['amount'] ?? '' }}" readonly>
                  </td>
                  <td></td>
                  <td></td>
                  <td>
                  
                    <input type="text" 
                            class="form-control form-control-sm me-2 text-end" 
                            name="TotalEng"  id="TotalEng" 
                            value="{{ number_format($summary['engineering']['amount'] ?? 0, 2) }}" 
                            readonly>
                  </td>
                  <td style="display: flex; justify-content: center;">
                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#engDetails">
                      <i class="fas fa-list-ul"></i>
                    </button>
                  </td>
                </tr>

                <tr class="collapse" id="engDetails">
                  <td colspan="5">
                    <table id="engineeringSubTable" class="table table-sm table-bordered text-center mb-0 w-100">
                      <thead>
                        <tr>
                        <th>Date Period</th>
                          <th>Name - (Month)</th>
                          <th>Amount</th>
                        </tr>
                      </thead>
                      @php
                          $validEntries = $engineeringEntries->filter(function($eng) {
                              return $eng->date_from || $eng->date_to || $eng->name || $eng->month || $eng->amount;
                          });
                      @endphp

                      <tbody>
                        @forelse($validEntries as $eng)
                          <tr>
                            <td style="width: 22%;">
                              @if($eng->date_from && $eng->date_to)
                                {{ \Carbon\Carbon::parse($eng->date_from)->format('Y-m-d') }} to {{ \Carbon\Carbon::parse($eng->date_to)->format('Y-m-d') }}
                              @endif
                            </td>
                            <td style="width: 22%;">{{ $eng->name }} - {{ $eng->month }}</td>
                            <td class="text-end" data-amount="{{ $eng->amount }}">{{ number_format($eng->amount, 2) }}</td>
                          </tr>
                        @empty
                          <tr>
                            <td colspan="4" class="text-muted">No entries found.</td>
                          </tr>
                        @endforelse
                      </tbody>


                    </table>
                  </td>
                </tr>

                <tr>
                  <td class="fw-bold">Engineering Balance</td>
                  <td class="fw-bold text-end" id="formEngineeringBalance" data-balance="0.00">₱0.00</td>
                  <td colspan="5"></td>
                </tr>

                <!-- MQC TABLE -->
                <tr>
                  <td>MQC</td>
                  <td>
                    <input type="text" class="form-control form-control-sm text-end expenditure-amount"
                          name="amountMqc" id="amountMqc" value="{{ $summary['mqc']['amount'] ?? '' }}" readonly>
                  </td>
                  <td></td>
                  <td></td>
                  <td>
                    <input type="text" 
                          class="form-control text-end form-control-sm me-2" 
                          name="TotalMqc" id="TotalMqc" 
                          value="{{ number_format($summary['mqc']['amount'] ?? 0, 2) }}" 
                          readonly>
                  </td>
                  <td style="display: flex; justify-content: center;">  
                      <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#mqcDetails">
                        <i class="fas fa-list-ul"></i>
                      </button></td>
                </tr>

                <tr class="collapse" id="mqcDetails">
                  <td colspan="5">
                  <table id="mqcSubTable" class="table table-sm table-bordered text-center mb-0 w-100">
                    <thead>
                      <tr>
                          <th>Date Period</th>
                        <th>Name - (Month)</th>
                        <th>Amount</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($mqcEntries as $mqc)
                      <tr>
                      <td style="width: 22%;">
                                @if($eng->date_from && $eng->date_to)
                                    {{ \Carbon\Carbon::parse($mqc->date_from)->format('Y-m-d') }} to {{ \Carbon\Carbon::parse($mqc->date_to)->format('Y-m-d') }}
                                @else
                                    
                                @endif
                            </td>
                            <td style="width: 22%;">{{ $mqc->name }} - {{ $mqc->month }}</td>
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
                  <td class="fw-bold">MQC Balance</td>
                  <td class="fw-bold text-end" id="formMqcBalance">0.00</td>
                  <td colspan="5"></td>
                </tr>
                <tr>
                  <td>Total Expenditures</td>
                  <td><input type="text" class="form-control form-control-sm text-end" id="amountTotal" name="amountTotal"></td>
                  <td></td>
                  <td></td>
                  <td> <input type="text" id="totalAmount" readonly class="form-control form-control-sm text-end" /></td>
                  <td></td>
                </tr>
                <tr>
                  <td>Total Savings</td>
                  <td><input type="text" class="form-control form-control-sm text-end" id="amountSavings" name="amountSavings"></td>
                  <td></td><td></td><td> </td><td></td>
                </tr>
              </tbody>
            </table>
          
        <!-- Add this somewhere in your Blade HTML template -->
      <div id="projectMeta" data-project-id="{{ $project['id'] ?? 0 }}"></div>
        <input type="hidden" id="existingFinancialCompletionDate" value="{{ $funds['financial_completion_date'] ?? '' }}">

        </fieldset>
        <div class="row text-end mt-2">
          <div class="text-end mt-4 mr-5">
            <a href="{{ url('/systemAdmin/overview/' . $project['id']) }}" 
              class="btn btn-outline-secondary  px-4"> Back
            </a>
            <button type="button" id="submitFundsUtilization" 
              class="btn btn-primary px-4 mx-3">
              <i class="fas fa-save me-2"></i>
              Save Changes
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
          


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
<script src="{{ asset('js/FundsUtilization/funds_utilization-setvalue.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-financial-progress.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-format-amounts.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-add-set.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-addBreakdown.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-valueLimit.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-updateTotal.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-submit.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-setCurrencyFormatting.js') }}"></script>
<script src="{{ asset('js/FundsUtilization/funds_utilization-Totals.js') }}"></script>
@endsection