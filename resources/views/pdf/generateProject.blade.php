<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IPPFU</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  @page {
    margin: 10mm 15mm 5mm 15mm;
  }
    
  body {
    font-family: "Calibri", sans-serif;
    position: relative;
    margin-bottom: 60px;
  }


  footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: left;
    font-size: 12px;
  }

  .printed-by {
    display: inline-block;
    text-align: left;
  }

  .header-table {
    width: 100%;
    margin-bottom: 2px;
   
  }

  .header-table td {
    vertical-align: middle;
    text-align: center;
  }

  .logo {
    width: 65px;
    height: 65px;
  }

  .header-text h5, .header-text h3, .header-text h6, .header-text h4 {
  font-family: "Times New Roman", Times, serif;
  margin: 2px 0;
}


  .header-text h5 {
    font-size: 16px;
  }

  .header-text h4 {
    font-size: 16px;
    text-transform: uppercase;
    font-weight: bold;
    margin-top: 0px;
    margin-bottom: 0px;
  }

  .header-text h6 {
    font-size: 12px;
    font-weight: normal;
  }

  .header-text p {
    font-size: 12px;
    font-weight: normal;
    margin-top: 0px;
    margin-bottom: 0px;
  }

  .contact-row {
    width: 100%;
    font-size: 12px;
    margin-top: 2px;
    padding-bottom: 5px;
  }

  .contact-row td {
    padding: 0 10px;
    vertical-align: top;
  }

  .contact-left {
    text-align: left;
  }

  .contact-right {
    text-align: right;
  }

  .contact-row span {
    font-weight: normal;
    text-decoration: underline;
  }

  .footer-line {
    border-top: 2px solid #000;
    margin-top: 0px;
    width: 100%;
  }

  .project-info-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }

  .project-info-table th,
  .project-info-table td {
    border: 0px;
    padding: 8px;
    vertical-align: top;
  }

  .project-info-table th {
    width: 20%;
    text-align: left;
    font-weight: normal;
    font-size: 12px;
  }

 

  .fit-text-row {
    line-height: 1;
  }

  .fit-text-row th {
    padding: 1 4px;
    font-weight: normal;
    vertical-align: top;
    margin-left: 15px;
    font-size: 13px;
  }
    .fit-text-row td {
    padding: 2 4px;
    vertical-align: top;
    font-size: 13px;
  }

    .fit-text-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #000; /* Add a border around the entire table */
  }

  .fit-text-table th,
  .fit-text-table td {
    border: 1px solid #000; /* Add borders to table cells */
    padding: 0px;
    font-size: 13px;
  }

  .fit-text-title {
    margin-top: 10px;
    margin-bottom: 0px;
  }

    .fit-text-title th {
    padding: 1 4px;
    margin-top: 10px;
    font-weight: bold;
    vertical-align: top;
    font-size: 13px;
  }

  .sub-header {
    font-weight: bold;
    font-size: 12px;
    text-align: center;
  }

  .contact-table {
  width: 100%;
  font-size: 12px;
  border-collapse: collapse;
  margin-top: 0px;
  margin-bottom: 0px;
  text-align: center;
  vertical-align: middle;
}

.contact-table td {
  padding: 0 10px;
  vertical-align: middle;
  white-space: nowrap; /* Prevent breaking */
}

.left-contact {
  text-align: center;
  width: 50%;
}

.right-contact {
  text-align: center;
  width: 50%;
}

.label {
  font-weight: normal;
}

</style>
</head>
<body>

<div class="container">
  <!-- Header -->
<header>
  <table class="header-table">
    <tr>
      <td style="width: 15%; text-align: left;">
        <img src="{{ public_path('img/temp_logo.png') }}" class="logo">
      </td>
      <td style="width: 70%; vertical-align: middle; font-family: serif;">
        <div class="header-text">
          <div style="font-family: 'Old English MT', serif; font-size: 18px; font-weight: normal;">
            Republic of the Philippines
          </div>          <div style="font-weight: bold; font-size: 14px; margin-top: 2px;">
            PROVINCE OF NUEVA VIZCAYA
          </div>

          <div style="font-weight: bold; font-size: 14px; margin-top: 2px;">
            BAYOMBONG
          </div>
          <div style="font-size: 12px; margin-top: -4px;">
            -o0o-
          </div>

          <div style="font-weight: bold; font-size: 16px; margin-top: 2px;">
            PROVINCIAL ENGINEERING OFFICE
          </div>
          <p>People’s Hall, Capitol Compound, Bayombong, Nueva Vizcaya, 3700</p>
        </div>
      </td>
      <td style="width: 15%; text-align: right;">
        <img src="{{ public_path('img/left_logo.png') }}" class="logo">
      </td>
    </tr>
  </table>


    <table class="contact-table mt-2">
    <tr>
      <td class="text-left">
        <span class="label"><b> TEL .NO.: </span> (078) 332-3000 Loc 418</b>
      </td>
      <td style="text-align: right;">
        <span class="label"><b>E_MAIL:</span> PLGYNUEVAVIZCAYA.PEO@GMAIL.COM</b>
      </td>
    </tr>
  </table>

  <!-- Decorative Footer Line -->
  <div class="footer-line">

  </div>

</header>
      <!-- Project Information -->
      <table class="project-info-table">
        <tbody>
           <tr class="fit-text-title" >
            <th>PROJECT PROFILE</th>
          </tr>
          <tr class="fit-text-row">
            <th style="width: 30%;">Project Title:</th>
            <td colspan="4" style="font-size: 14px; font-weight: bold">{{ $project->title }}</td>
          </tr>
          <tr class="fit-text-row">
            <th>Location:</th>
            <td colspan="3">{{ $project->location }}</td>
          </tr>
          <tr class="fit-text-row"> 
                <th style="text-align: left; vertical-align: top;">Project Description:</th>
                <td colspan="5">
                    <p style="margin: 0;">
                        {{ implode(' ', $description) }}
                    </p>
                </td>

            </tr>
            <tr class="fit-text-row">
            <th>Name of Firm:</th>
            <td colspan="3">{{ $project->firm_name }}</td>
          </tr>
          <tr class="fit-text-row">
            <th>Project ID:</th>
            <td colspan="3">{{ $project->projectID }}</td>
          </tr>
          <tr class="fit-text-row">
            <th>Source of Fund:</th>
            <td colspan="3">{{ $project->source_of_funds }}</td>
          </tr>
          <tr class="fit-text-row">
            <th>Appropriation:</th>
            <td colspan="3">{{ number_format((float) $projectFundsUtilization['orig_appropriation'], 2) }}</td>

          </tr>
          <tr class="fit-text-row">
            <th>Contract Days:</th>
            <td colspan="3" style="text-align: left;">{{ $project->contract_days }} Calendar Days</td>
          
          </tr>
          <tr class="fit-text-row">
            <th>Notice of Award:</th>
            <td style="white-space: nowrap;"><i>Issued Date</i></td>
            <td style="white-space: nowrap;">
                {{ $project->noa_issued_date ? \Carbon\Carbon::parse($project->noa_issued_date)->format('F d, Y') : '' }}
            </td>
            <td style="white-space: nowrap;"><i>Received Date</i></td>
            <td style="white-space: nowrap;">
                {{ $project->noa_received_date ? \Carbon\Carbon::parse($project->noa_received_date)->format('F d, Y') : '' }}
            </td>
        </tr>

        <tr class="fit-text-row">
            <th>Notice to Proceed:</th>
            <td style="white-space: nowrap;"><i>Issued Date</i></td>
            <td style="white-space: nowrap;">
                {{ $project->ntp_issued_date ? \Carbon\Carbon::parse($project->ntp_issued_date)->format('F d, Y') : '' }}
            </td>
            <td style="white-space: nowrap;"><i>Received Date</i></td>
            <td style="white-space: nowrap;">
                {{ $project->ntp_received_date ? \Carbon\Carbon::parse($project->ntp_received_date)->format('F d, Y') : '' }}
            </td>
        </tr>


          @php
              // Collect suspension/resume pairs with remarks
              $orderPairs = [];

              foreach ($project->getAttributes() as $key => $value) {
                  if (preg_match('/^suspensionOrderNo(\d+)$/', $key, $matches)) {
                      $index = $matches[1];
                      $susp = $value;
                      $resumeKey = "resumeOrderNo{$index}";
                      $resume = $project->{$resumeKey} ?? null;

                      // Use the passed remarksData array from the controller
                      $remarks = $remarksData[(string)$index]['suspensionOrderRemarks'] ?? '';

                      if (!empty($susp) || !empty($resume)) {
                          $orderPairs[] = [
                              'index' => $index,
                              'suspension' => $susp,
                              'resume' => $resume,
                              'remarks' => $remarks,
                          ];
                      }
                  }
              }

              $hasSuspension = count($orderPairs) > 0;
          @endphp


            <tr class="fit-text-row">
                <th>Start Date:</th>
                <td colspan="3">
                    {{ $project->official_starting_date ? \Carbon\Carbon::parse($project->official_starting_date)->format('F d, Y') : 'N/A' }}
                </td>
            </tr>
            <tr class="fit-text-row">
                <th>Target Completion Date:</th>
                <td colspan="3">
                    {{ $project->target_completion_date ? \Carbon\Carbon::parse($project->target_completion_date)->format('F d, Y') : 'N/A' }}
                </td>
            </tr>
              <!-- Blank row for spacing -->
            <tr><td colspan="3"></td></tr>


          @if ($hasSuspension)
            {{-- Show suspension and extension details --}}
            @foreach ($orderPairs as $pair)
                <tr class="fit-text-row">
                    <th>Suspension Order No. {{ $pair['index'] }}</th>
                    <td style="white-space: nowrap;">
                        {{ $pair['suspension'] ? \Carbon\Carbon::parse($pair['suspension'])->format('F d, Y') : ' ' }}
                    </td>
                    <td colspan="4">Reason for suspension: {{ $pair['remarks'] ?: '' }}</td>
                </tr>
                <tr class="fit-text-row">
                    <th>Resume Order No. {{ $pair['index'] }}</th>
                    <td colspan="3" style="white-space: nowrap;">
                        {{ $pair['resume'] ? \Carbon\Carbon::parse($pair['resume'])->format('F d, Y') : ' ' }}
                    </td>
                </tr>
            @endforeach
        @endif
      <!-- Display Total Extension Days -->
      @php
          $totalExtensionDays = 0;
          foreach ($time_extensions as $extension) {
              $totalExtensionDays += $extension->time_extension;
          }
      @endphp

      @if ($totalExtensionDays > 0)
          <tr class="fit-text-row">
              <th>No. of Days of Extension:</th>
              <td colspan="3">{{ $totalExtensionDays }}</td>
          </tr>
          <tr class="fit-text-row">
          <th>Revised Target Completion:</th>
          <td colspan="3">
              {{ $project->revised_target_date ? \Carbon\Carbon::parse($project->revised_target_date)->format('F d, Y') : '' }}
          </td>
      </tr>
      @endif

    

    <!-- Blank row for spacing -->
    <tr><td colspan="3"></td></tr>

        <!-- ABC Section -->
    <tr class="fit-text-title" >
        <th>SUMMARY (FUND SOURCE)</th>
      </tr>
    <tr>
      <td colspan="6"  style="margin: 0px; padding: 0px;">
            <table class="fit-text-table" style="width: 100%; border-collapse: collapse;">
              <tr class="sub-header">
                <td>DESCRIPTION</td>
                <td>ORIGINAL</td>
                <td colspan="2">Variation Order</td>
                <td>ACTUAL</td>
              </tr>
              <tr class="fit-text-table">
                <th>Appropriation</th>
                <td style="text-align: right;">{{ isset($projectFundsUtilization['orig_appropriation']) ? number_format($projectFundsUtilization['orig_appropriation'], 2) : '--' }}</td>
                <td colspan="2" style="text-align: right;">{{ isset($projectVariationOrder[0]['vo_appropriation']) ? number_format($projectVariationOrder[0]['vo_appropriation'], 2) : '--' }}</td>
                <td style="text-align: right;">{{ isset($projectFundsUtilization['actual_appropriation']) ? number_format($projectFundsUtilization['actual_appropriation'], 2) : '--' }}</td>
              </tr>
              <tr class="fit-text-table">
                <th>ABC</th>
                <td style="text-align: right;">{{ isset($projectFundsUtilization['orig_abc']) ? number_format($projectFundsUtilization['orig_abc'], 2) : '--' }}</td>
                <td colspan="2" style="text-align: right;">{{ isset($projectVariationOrder[0]['vo_abc']) ? number_format($projectVariationOrder[0]['vo_abc'], 2) : '--' }}</td>
                <td style="text-align: right;">{{ isset($projectFundsUtilization['actual_abc']) ? number_format($projectFundsUtilization['actual_abc'], 2) : '--' }}</td>
              </tr>
              <tr class="fit-text-table">
                <th>Contract Amount</th>
                <td style="text-align: right;">
                  {{ isset($projectFundsUtilization['orig_contract_amount']) ? number_format($projectFundsUtilization['orig_contract_amount'], 2) : '--' }}
                </td>
                <td style="text-align: center; width: 50px;">1</td>
                <td style="text-align: right;">
                  {{ isset($projectVariationOrder[0]['vo_contract_amount']) ? number_format($projectVariationOrder[0]['vo_contract_amount'], 2) : '--' }}
                </td>
                <td style="text-align: right;">
                  @if (
                    isset($projectFundsUtilization['actual_contract_amount']) &&
                    isset($projectVariationOrder[0]['vo_contract_amount']) &&
                    !isset($projectVariationOrder[1]['vo_contract_amount']) &&
                    !isset($projectVariationOrder[2]['vo_contract_amount'])
                  )
                    {{ number_format($projectFundsUtilization['actual_contract_amount'], 2) }}
                  @else
                  {{ number_format($projectFundsUtilization['orig_contract_amount'], 2) }}
                  @endif
                </td>
              </tr>
              <tr class="fit-text-table">
                <th></th>
                <td style="text-align: right;"></td>
                <td style="text-align: center; width: 50px;">2</td>
                <td style="text-align: right;">
                  {{ isset($projectVariationOrder[1]['vo_contract_amount']) ? number_format($projectVariationOrder[1]['vo_contract_amount'], 2) : '--' }}
                </td>
                <td style="text-align: right;">
                  @if (
                    isset($projectFundsUtilization['actual_contract_amount']) &&
                    isset($projectVariationOrder[0]['vo_contract_amount']) &&
                    isset($projectVariationOrder[1]['vo_contract_amount']) &&
                    !isset($projectVariationOrder[2]['vo_contract_amount'])
                  )
                    {{ number_format($projectFundsUtilization['actual_contract_amount'], 2) }}
                  @else
                    --
                  @endif
                </td>
              </tr>
              <tr class="fit-text-table">
                <th></th>
                <td style="text-align: right;"></td>
                <td style="text-align: center; width: 50px;">3</td>
                <td style="text-align: right;">
                  {{ isset($projectVariationOrder[2]['vo_contract_amount']) ? number_format($projectVariationOrder[2]['vo_contract_amount'], 2) : '--' }}
                </td>
                <td style="text-align: right;">
                  @if (
                    isset($projectFundsUtilization['actual_contract_amount']) &&
                    isset($projectVariationOrder[1]['vo_contract_amount']) &&
                    isset($projectVariationOrder[2]['vo_contract_amount'])  &&
                    isset($projectVariationOrder[3]['vo_contract_amount'])
                  )
                    {{ number_format($projectFundsUtilization['actual_contract_amount'], 2) }}
                  @else
                    --
                  @endif
                </td>
              </tr>
              <tr class="fit-text-table">
                <th></th>
                <td style="text-align: right;"></td>
                <td style="text-align: center; width: 50px;">4</td>
                <td style="text-align: right;">
                  {{ isset($projectVariationOrder[3]['vo_contract_amount']) ? number_format($projectVariationOrder[3]['vo_contract_amount'], 2) : '--' }}
                </td>
                <td style="text-align: right;">
                  @if (
                    isset($projectFundsUtilization['actual_contract_amount']) &&
                    isset($projectVariationOrder[1]['vo_contract_amount']) &&
                    isset($projectVariationOrder[2]['vo_contract_amount']) &&
                    isset($projectVariationOrder[3]['vo_contract_amount'])
                  )
                    {{ number_format($projectFundsUtilization['actual_contract_amount'], 2) }}
                  @else
                    --
                  @endif
                </td>
              </tr>
              <tr class="fit-text-table">
                <th></th>
                <td style="text-align: right;"></td>
                <td style="text-align: center; width: 50px;">5</td>
                <td style="text-align: right;">
                  {{ isset($projectVariationOrder[4]['vo_contract_amount']) ? number_format($projectVariationOrder[4]['vo_contract_amount'], 2) : '--' }}
                </td>
                <td style="text-align: right;">
                  @if (
                    isset($projectFundsUtilization['actual_contract_amount']) &&
                    isset($projectVariationOrder[1]['vo_contract_amount']) &&
                    isset($projectVariationOrder[2]['vo_contract_amount']) &&
                    isset($projectVariationOrder[3]['vo_contract_amount']) &&
                    isset($projectVariationOrder[4]['vo_contract_amount'])
                  )
                    {{ number_format($projectFundsUtilization['actual_contract_amount'], 2) }}
                  @else
                    --
                  @endif
                </td>
              </tr>

              <tr class="fit-text-table">
                <th>Savings</th>
                <td style="text-align: right;">{{ isset($projectFundsUtilization['orig_bid']) ? number_format($projectFundsUtilization['orig_bid'], 2) : '--' }}</td>
                <td colspan="2" style="text-align: right;">{{ isset($projectVariationOrder[0]['vo_bid']) ? number_format($projectVariationOrder[0]['vo_bid'], 2) : '--' }}</td>
                <td style="text-align: right;">{{ isset($projectFundsUtilization['actual_bid']) ? number_format($projectFundsUtilization['actual_bid'], 2) : '--' }}</td>
              </tr>
              <tr class="fit-text-table">
                <td colspan="5">Wages</td>
              </tr>
              <tr class="fit-text-table">
                <th style="text-align: right;">Engineering</th>
                <td style="text-align: right;">{{ isset($projectFundsUtilization['orig_engineering']) ? number_format($projectFundsUtilization['orig_engineering'], 2) : '--' }}</td>
                <td colspan="2" style="text-align: right;">{{ isset($projectVariationOrder[0]['vo_engineering']) ? number_format($projectVariationOrder[0]['vo_engineering'], 2) : '--' }}</td>
                <td style="text-align: right;">{{ isset($projectFundsUtilization['actual_engineering']) ? number_format($projectFundsUtilization['actual_engineering'], 2) : '--' }}</td>
              </tr>
            
              <tr class="fit-text-table">
                <th style="text-align: right;">MQC</th>
                <td style="text-align: right;">{{ isset($projectFundsUtilization['orig_mqc']) ? number_format($projectFundsUtilization['orig_mqc'], 2) : '--' }}</td>
                <td colspan="2" style="text-align: right;">{{ isset($projectVariationOrder[0]['vo_mqc']) ? number_format($projectVariationOrder[0]['vo_mqc'], 2) : '--' }}</td>
                <td style="text-align: right;">{{ isset($projectFundsUtilization['actual_mqc']) ? number_format($projectFundsUtilization['actual_mqc'], 2) : '--' }}</td>
              </tr>
            
              <tr class="fit-text-table">
                <th>Contingency</th>
                <td style="text-align: right;">{{ isset($projectFundsUtilization['orig_contingency']) ? number_format($projectFundsUtilization['orig_contingency'], 2) : '--' }}</td>
                <td colspan="2" style="text-align: right;">{{ isset($projectVariationOrder[0]['vo_contingency']) ? number_format($projectVariationOrder[0]['vo_contingency'], 2) : '--' }}</td>
                <td style="text-align: right;">{{ isset($projectFundsUtilization['actual_contingency']) ? number_format($projectFundsUtilization['actual_contingency'], 2) : '--' }}</td>
              </tr>
              <tr class="fit-text-table">
                <th>TOTAL</th>
                <td style="text-align: right;">
                {{ number_format(
                    (isset($projectFundsUtilization['orig_contract_amount']) ? $projectFundsUtilization['orig_contract_amount'] : 0) +
                    (isset($projectFundsUtilization['orig_engineering']) ? $projectFundsUtilization['orig_engineering'] : 0) +
                    (isset($projectFundsUtilization['orig_mqc']) ? $projectFundsUtilization['orig_mqc'] : 0) +
                    (isset($projectFundsUtilization['orig_contingency']) ? $projectFundsUtilization['orig_contingency'] : 0) +
                    (isset($projectFundsUtilization['orig_bid']) ? $projectFundsUtilization['orig_bid'] : 0),
                    2
                  ) }}

                </td>
                <td colspan="2" style="text-align: right;"></td>
                <td style="text-align: right;"></td>
              </tr>         
            </table>
        </td>
    </tr>

      <!-- Blank row for spacing -->
      <tr><td colspan="3"></td></tr>

         <!-- ABC Section -->
      <tr class="fit-text-title mt-5" >
          <th colspan="3">BREAKDOWN OF UTILIZATION</th>
      </tr>
    <tr>
      <td colspan="6" style="margin: 0px; padding: 0px;">
        <table class="fit-text-table" style="width: 100%; border-collapse: collapse;">
          <tr class="sub-header">
            <td style="width: 25%; padding: 4px;">PARTICULARS</td>
            <td style="width: 20%; padding: 4px;">AMOUNT</td>
            <td style="width: 15%;  padding: 4px;">RETENTION %</td>
            <td style="width: 20%; padding: 2px;">RETENTION AMOUNT</td>
            <td style="width: 20%; padding: 4px;">TOTAL</td>
          </tr>

          @php
            $summary = $projectFundsUtilization['summary'] ?? [];
            $partialBillings = $projectFundsUtilization['partial_billings'] ?? [];

            function ordinal($number) {
              $ends = ['th','st','nd','rd','th','th','th','th','th','th'];
              if (($number % 100) >= 11 && ($number % 100) <= 13) return $number . 'th';
              return $number . $ends[$number % 10];
            }
          @endphp

          <!-- Total Appropriation -->
          <tr>
            <td style="text-align: right;">TOTAL APPROPRIATION</td>
            <td style="text-align: right;">{{ isset($projectFundsUtilization['orig_appropriation']) ? number_format($projectFundsUtilization['orig_appropriation'], 2) : '' }}</td>
            <td></td>
            <td></td>
            <td></td>
          </tr>

          <!-- Contract Amount
          <tr>
            <td style="text-align: right;">CONTRACT AMOUNT</td>
            <td style="text-align: right;">{{ isset($projectFundsUtilization['actual_contract_amount']) ? number_format($projectFundsUtilization['actual_contract_amount'], 2) : '' }}</td>
            <td></td>
            <td></td>
            <td></td>
          </tr> -->

          <!-- Mobilization -->
          @php
          $mobiAmount = isset($summary['mobilization']['amount']) ? floatval($summary['mobilization']['amount']) : 0;
          $mobiRetention = $mobiAmount > 0 ? $mobiAmount * 0.10 : 0;
          $mobiTotal = $mobiAmount - $mobiRetention;

          // Partial Billings total and storing for rows
          $partialTotal = 0;
          $partialRows = [];
          foreach ($partialBillings as $index => $billing) {
            $amount = isset($billing['amount']) ? floatval($billing['amount']) : 0;
            $retention = $amount > 0 ? $amount * 0.10 : 0;
            $total = $amount - $retention;
            if ($index < 4 || ($index === 4 && $amount > 0)) {
              $partialRows[] = [
                'index' => $index,
                'amount' => $amount,
                'retention' => $retention,
                'total' => $total,
              ];
              $partialTotal += $total;
            }
          }

          // Final Billing
          $finalAmount = isset($summary['final']['amount']) ? floatval($summary['final']['amount']) : 0;
          $finalRetention = $finalAmount > 0 ? $finalAmount * 0.10 : 0;
          $finalTotal = $finalAmount - $finalRetention;

          // Calculate total expenditures = mobiTotal + partialTotal + finalTotal + engineering + mqc
          $engineeringAmount = isset($summary['engineering']['amount']) ? floatval($summary['engineering']['amount']) : 0;
          $mqcAmount = isset($summary['mqc']['amount']) ? floatval($summary['mqc']['amount']) : 0;
          $totalExpenditures = $mobiTotal + $partialTotal + $finalTotal + $engineeringAmount + $mqcAmount;
        @endphp

        <!-- Mobilization -->
        <tr>
          <td style="text-align: right;">15% Mobilization</td>
          <td style="text-align: right;">{{ $mobiAmount > 0 ? number_format($mobiAmount, 2) : '' }}</td>
          <td style="text-align: right;"></td>
          <td style="text-align: right;"></td>
          <td style="text-align: right;"></td>
        </tr>

        <!-- Partial Billings -->
        @foreach ($partialRows as $row)
          <tr>
            <td style="text-align: right;">{{ ordinal($row['index'] + 1) }} Partial Billing</td>
            <td style="text-align: right;">{{ $row['amount'] > 0 ? number_format($row['amount'], 2) : '' }}</td>
            <td style="text-align: right;">{{ $row['amount'] > 0 ? '10%' : '' }}</td>
            <td style="text-align: right;">{{ $row['amount'] > 0 ? number_format($row['retention'], 2) : '' }}</td>
            <td style="text-align: right;">{{ $row['amount'] > 0 ? number_format($row['total'], 2) : '' }}</td>
          </tr>
        @endforeach

        <!-- Final Billing -->
        <tr>
          <td style="text-align: right;">Final Billing</td>
          <td style="text-align: right;">{{ $finalAmount > 0 ? number_format($finalAmount, 2) : '' }}</td>
          <td style="text-align: right;">{{ $finalAmount > 0 ? '10%' : '' }}</td>
          <td style="text-align: right;">{{ $finalAmount > 0 ? number_format($finalRetention, 2) : '' }}</td>
          <td style="text-align: right;">{{ $finalAmount > 0 ? number_format($finalTotal, 2) : '' }}</td>
        </tr>

          <!-- Engineering -->
          <tr>
            <td style="text-align: right;">Engineering</td>
            <td style="text-align: right;">{{ isset($summary['engineering']['amount']) ? number_format($summary['engineering']['amount'], 2) : '' }}</td>
            <td></td>
            <td></td>
            <td>{{ $summary['engineering']['remarks'] ?? '' }}</td>
          </tr>

          <!-- MQC -->
          <tr>
            <td style="text-align: right;">MQC</td>
            <td style="text-align: right;">{{ isset($summary['mqc']['amount']) ? number_format($summary['mqc']['amount'], 2) : '' }}</td>
            <td></td>
            <td></td>
            <td>{{ $summary['mqc']['remarks'] ?? '' }}</td>
          </tr>

          <!-- Total Expenditures -->
          <tr>
            <td style="text-align: right;"><strong>TOTAL EXPENDITURES</strong></td>
            <td style="text-align: right;"><strong>{{ isset($summary['totalExpenditures']['amount']) ? number_format($summary['totalExpenditures']['amount'], 2) : '' }}</strong></td>
            <td></td>
            <td></td>
            <td><strong>{{ $summary['total_expenditure']['remarks'] ?? '' }}</strong></td>
          </tr>

          <!-- Total Savings -->
          <tr>
            <td style="text-align: right;"><strong>TOTAL SAVINGS</strong></td>
            <td style="text-align: right;"><strong>{{ isset($summary['totalSavings']['amount']) ? number_format($summary['totalSavings']['amount'], 2) : '' }}</strong></td>
            <td></td>
            <td></td>
            <td><strong>{{ $summary['totalSavings']['remarks'] ?? '' }}</strong></td>
          </tr>
        </table>
      </td>
    </tr>

      <tr class="fit-text-row" >
          <th style="margin-top: 5px;">Actual Completion Date (Physical)</th>
          <td colspan="2">
              {{ $project->actual_completion_date ? \Carbon\Carbon::parse($project->actual_completion_date)->format('F d, Y') : ' ' }}
          </td>
          <td>Actual Length:</td>
          <td colspan="1">
            {{ $project->actual_length }}
          </td>
      </tr>
      <tr class="fit-text-row">
          <th>Actual Completion Date (Financial)</th>
          <td colspan="2">
              {{ $projectFundsUtilization->financial_completion_date ? \Carbon\Carbon::parse($projectFundsUtilization->financial_completion_date)->format('F d, Y') : ' ' }}
          </td>
      </tr>
  </tbody>
  </table>
</div>

<div style="page-break-inside: avoid;">
  <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <tr>
      <td style="width: 33%; vertical-align: top; font-size: 12px; padding-bottom: 5px;">
        <span style="margin-bottom: 20px; display: inline-block;">Prepared by</span>
      </td>
      <td style="width: 33%; vertical-align: top; font-size: 12px;">
        <span>Reviewed by</span>
      </td>
      <td style="width: 33%; vertical-align: top; font-size: 12px;">
        <span>Noted by</span>
      </td>
    </tr>
    <tr>
      <td style="width: 33%; vertical-align: top; text-align: center; font-size: 12px;">
        <div style="margin-top: 5px; border-bottom: 1px solid #000; width: 70%; margin: 5px auto 3px auto;">
          <span style="display: inline-block; padding-top: 1px;">{{ $userName }}</span>
        </div>
        <span>{{ $userPosition }}</span>
      </td>
      <td style="width: 33%; vertical-align: top; text-align: center; font-size: 12px;">
        <div style="border-bottom: 1px solid #000; width: 70%; margin: 5px auto 3px auto;">
          <span style="display: inline-block; padding-top: 3px;">{{ $reviewedBy }}</span>
        </div>
        <span>{{ $reviewed_by_position }}</span>
      </td>
      <td style="width: 33%; vertical-align: top; text-align: center; font-size: 12px;">
        <div style="border-bottom: 1px solid #000; width: 70%; margin: 5px auto 3px auto;">
          <span style="display: inline-block; padding-top: 3px;">{{ $notedBy }}</span>
        </div>
        <span>{{ $noted_by_position }}</span>
      </td>
    </tr>
  </table>
</div>


  </table>
</div>


</body>
</html>