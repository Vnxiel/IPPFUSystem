<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IPPFU</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  @page {
    margin: 10mm 15mm 10mm 15mm;
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
    font-size: 12px;
  }
    .fit-text-row td {
    padding: 2 4px;
    vertical-align: top;
    font-size: 12px;
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
    font-size: 12px;
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
    font-size: 12px;
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
  <table class="header-table">
    <tr>
      <td style="width: 15%; text-align: left;">
        <img src="{{ public_path('img/temp_logo.png') }}" class="logo">
      </td>
      <td style="width: 70%;">
        <div class="header-text">
          <h6>REPUBLIC OF THE PHILIPPINES</h6>
          <h6>PROVINCIAL GOVERNMENT OF NUEVA VIZCAYA</h6>
          <h4>PROVINCIAL ENGINEERING OFFICE</h4>
          <p>People’s Hall, Capitol Compound, Bayombong, Nueva Vizcaya, 3700</p>
        </div>
      </td>
      <td style="width: 15%; text-align: right;">
        <img src="{{ public_path('img/left_logo.png') }}" class="logo">
      </td>
    </tr>
  </table>

  <table class="contact-table">
  <tr>
    <td>
      <span class="label">Telephone:</span> (078) 332-3000 Loc 418
    </td>
    <td style="text-align: right;">
      <span class="label">E-mail:</span> plgunuevavizcaya.peo@gmail.com
    </td>
  </tr>
</table>

  <!-- Decorative Footer Line -->
  <div class="footer-line">

  </div>


      <!-- Project Information -->
      <table class="project-info-table">
        <tbody>
           <tr class="fit-text-title" >
            <th>PROJECT PROFILE</th>
          </tr>
          <tr class="fit-text-row">
            <th style="width: 30%;">Project Title:</th>
            <td colspan="4" style="font-size: 14px; font-weight: bold">{{ $project->projectTitle }}</td>
          </tr>
          <tr class="fit-text-row">
            <th>Location:</th>
            <td colspan="3">{{ $project->projectLoc }}</td>
          </tr>
          <tr class="fit-text-row"> 
                <th style="text-align: left; vertical-align: top;">Project Description:</th>
                <td colspan="3">
                    <ul style="margin: 0; padding-left: 0; list-style: none;">
                        @foreach ($projectDescriptions as $desc)
                            <li>{{ $desc }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            <tr class="fit-text-row">
            <th>Contractor:</th>
            <td colspan="3">{{ $project->projectContractor }}</td>
          </tr>
          <tr class="fit-text-row">
            <th>Project ID:</th>
            <td colspan="3">{{ $project->projectID }}</td>
          </tr>
          <tr class="fit-text-row">
            <th>Source of Fund:</th>
            <td colspan="3">{{ $project->sourceOfFunds }}</td>
          </tr>
          <tr class="fit-text-row">
            <th>Appropriation:</th>
            <td colspan="3">{{ number_format((float) $projectFundsUtilization['orig_appropriation'], 2) }}</td>

          </tr>
          <tr class="fit-text-row">
            <th>Contract Days:</th>
            <td colspan="1" style="text-align: center;">{{ $project->projectContractDays }}</td>
            <td colspan="2">Calendar Days</td>
          </tr>
          <tr class="fit-text-row">
              <th>Notice of Award:</th>
              <td><i>Issued Date</i></td>
              <td style="white-space: nowrap;">{{ \Carbon\Carbon::parse($project->noaIssuedDate)->format('F d, Y') }}</td>
              <td><i>Received Date</i></td>
              <td style="white-space: nowrap;">{{ \Carbon\Carbon::parse($project->noaReceivedDate)->format('F d, Y') }}</td>
          </tr>

          <tr class="fit-text-row">
              <th>Notice to Proceed:</th>
              <td><i>Issued Date</i></td>
              <td style="white-space: nowrap;">{{ \Carbon\Carbon::parse($project->ntpIssuedDate)->format('F d, Y') }}</td>
              <td><i>Received Date</i></td>
              <td style="white-space: nowrap;">{{ \Carbon\Carbon::parse($project->ntpReceivedDate)->format('F d, Y') }}</td>
          </tr>



          @php
            // Collect suspension/resume pairs with remarks
            $orderPairs = [];
            $remarksData = json_decode($project->suspensionRemarksJson ?? '{}', true);

            foreach ($project->getAttributes() as $key => $value) {
                if (preg_match('/^suspensionOrderNo(\d+)$/', $key, $matches)) {
                  $index = $matches[1];
                  $susp = $value;
                  $resumeKey = "resumeOrderNo{$index}";
                  $resume = $project->{$resumeKey} ?? null;

                  // 🔧 FIX: force $index to string when accessing JSON keys
                  $remarks = $remarksData[$index]['suspensionOrderRemarks'] ?? '';

                    if (!empty($susp) || !empty($resume)) {
                        $orderPairs[] = [
                            'index' => $index,
                            'suspension' => $susp,
                            'resume' => $resume,
                            'remarks' => $remarks
                        ];
                    }
                }
            }

            $hasSuspension = count($orderPairs) > 0;
        @endphp

            <tr class="fit-text-row">
                <th>Target Start Date:</th>
                <td colspan="3">
                    {{ $project->originalStartDate ? \Carbon\Carbon::parse($project->originalStartDate)->format('F d, Y') : 'N/A' }}
                </td>
            </tr>
            <tr class="fit-text-row">
                <th>Target Completion Date:</th>
                <td colspan="3">
                    {{ $project->targetCompletion ? \Carbon\Carbon::parse($project->targetCompletion)->format('F d, Y') : 'N/A' }}
                </td>
            </tr>
              <!-- Blank row for spacing -->
            <tr><td colspan="3"></td></tr>


            @if ($hasSuspension || $project->timeExtension)
            {{-- Show suspension and extension details --}}
            @foreach ($orderPairs as $pair)
                <tr class="fit-text-row">
                    <th>Suspension Order No. {{ $pair['index'] }}</th>
                    <td style="white-space: nowrap;">
                        {{ $pair['suspension'] ? \Carbon\Carbon::parse($pair['suspension'])->format('F d, Y') : ' ' }}
                    </td>
                    <td colspan="2">Reason for suspension: {{ $pair['remarks'] ?: '' }}</td>
                </tr>
                <tr class="fit-text-row">
                    <th>Resume Order No. {{ $pair['index'] }}</th>
                    <td colspan="3" style="white-space: nowrap;">
                        {{ $pair['resume'] ? \Carbon\Carbon::parse($pair['resume'])->format('F d, Y') : ' ' }}
                    </td>
                </tr>
            @endforeach

            <tr class="fit-text-row">
                <th>No. of Days of Extension:</th>
                <td colspan="3">{{ $project->timeExtension ?? 'N/A' }}</td>
            </tr>
            <tr class="fit-text-row">
                <th>Revised Target Completion:</th>
                <td colspan="3">
                    {{ $project->revisedTargetDate ? \Carbon\Carbon::parse($project->revisedTargetDate)->format('F d, Y') : 'N/A' }}
                </td>
            </tr>
            <tr class="fit-text-row">
                <th>Actual Completion Date:</th>
                <td colspan="3">
                    {{ $project->revisedCompletionDate ? \Carbon\Carbon::parse($project->revisedCompletionDate)->format('F d, Y') : 'N/A' }}
                </td>
            </tr>
        @else
            {{-- Show only actual completion date --}}
            <tr class="fit-text-row">
                <th>Actual Completion Date:</th>
                <td colspan="3">
                    {{ $project->revisedCompletionDate ? \Carbon\Carbon::parse($project->revisedCompletionDate)->format('F d, Y') : 'N/A' }}
                </td>
            </tr>
        @endif
        {{-- Actual Length --}}
            <tr class="fit-text-row">
                <th>Actual Length:</th>
                <td colspan="3">
                  {{ $project->actual_length }}
                </td>
            </tr>

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
                <td colspan="2">V.O.1</td>
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
                    --
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
                    isset($projectVariationOrder[2]['vo_contract_amount'])
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
                <td style="text-align: right;">
                  {{
                    number_format(
                      (isset($projectFundsUtilization['actual_contract_amount']) ? $projectFundsUtilization['actual_contract_amount'] : 0) +
                      (isset($projectFundsUtilization['actual_engineering']) ? $projectFundsUtilization['actual_engineering'] : 0) +
                      (isset($projectFundsUtilization['actual_mqc']) ? $projectFundsUtilization['actual_mqc'] : 0) +
                      (isset($projectFundsUtilization['actual_contingency']) ? $projectFundsUtilization['actual_contingency'] : 0) +
                      (isset($projectFundsUtilization['orig_bid']) ? $projectFundsUtilization['orig_bid'] : 0),
                      2
                    )
                  }}
                </td>
              </tr>

            </table>
        </td>
    </tr>

      <!-- Blank row for spacing -->
      <tr><td colspan="3"></td></tr>

         <!-- ABC Section -->
    <tr class="fit-text-title" >
        <th>BREAKDOWN OF UTILIZATION</th>
    </tr>
    
    
    <tr>
      <td colspan="6"  style="margin: 0px; padding: 0px;">
            <table class="fit-text-table" style="width: 100%; border-collapse: collapse;">
              <tr class="sub-header">
                <td>DATE COVERED</td>
                <td>PARTICULARS</td>
                <td>AMOUNT</td>
                <td>REMARKS</td>
              </tr>
              @php
                  $summary = $projectFundsUtilization['summary'] ?? [];
                @endphp
                @php
                  $partialBillings = $projectFundsUtilization['partial_billings'] ?? [];
                @endphp

              <tr class="fit-text-table">
                <td style="text-align: right;">{{ $summary['mobilization']['date'] ?? '' }}</td>
                <td>15% Mobilization</td>
                <td style="text-align: right;">
                  {{ isset($summary['mobilization']['amount']) ? number_format($summary['mobilization']['amount'], 2) : '' }}
                </td>
                <td style="text-align: right;">{{ $summary['mobilization']['remarks'] ?? '' }}</td>
              </tr>
              @php
                  function ordinal($number) {
                      $ends = ['th','st','nd','rd','th','th','th','th','th','th'];
                      if ((($number % 100) >= 11) && (($number % 100) <= 13)) {
                          return $number . 'th';
                      } else {
                          return $number . $ends[$number % 10];
                      }
                  }
              @endphp

              @foreach ($partialBillings as $index => $billing)
                  @if ($index < 4 || ($index === 4 && isset($billing['amount']) && floatval($billing['amount']) > 0))
                      <tr class="fit-text-table">
                          <td style="text-align: right;">{{ $billing['date'] ?? '' }}</td>
                          <td>{{ ordinal($index + 1) }} Partial Billing</td>
                          <td style="text-align: right;">
                              {{ isset($billing['amount']) ? number_format($billing['amount'], 2) : '' }}
                          </td>
                          <td style="text-align: right;">{{ $billing['remarks'] ?? '' }}</td>
                      </tr>
                  @endif
              @endforeach

              <tr class="fit-text-table">
                <td style="text-align: right;">{{ $summary['final']['date'] ?? '' }}</td>
                <td>Final Billing</td>
                <td style="text-align: right;">
                  {{ isset($summary['final']['amount']) ? number_format($summary['final']['amount'], 2) : '' }}
                </td>
                <td style="text-align: right;">{{ $summary['final']['remarks'] ?? '' }}</td>
              </tr>

              <tr class="fit-text-table">
                <td style="text-align: right;">{{ $summary['engineering']['date'] ?? '' }}</td>
                <td>Engineering</td>
                <td style="text-align: right;">
                  {{ isset($summary['engineering']['amount']) ? number_format($summary['engineering']['amount'], 2) : '' }}
                </td>
                <td style="text-align: right;">{{ $summary['engineering']['remarks'] ?? '' }}</td>
              </tr>

              <tr class="fit-text-table">
                <td style="text-align: right;">{{ $summary['mqc']['date'] ?? '' }}</td>
                <td>MQC</td>
                <td style="text-align: right;">
                  {{ isset($summary['mqc']['amount']) ? number_format($summary['mqc']['amount'], 2) : '' }}
                </td>
                <td style="text-align: right;">{{ $summary['mqc']['remarks'] ?? '' }}</td>
              </tr>

              <tr class="fit-text-table">
                <td colspan="2" style="text-align: right; font-size: 14px;">TOTAL EXPENDITURES</td>
                <td style="text-align: right;">
                  {{ isset($summary['totalExpenditures']['amount']) ? number_format($summary['totalExpenditures']['amount'], 2) : '' }}
                </td>
                <td style="text-align: right;">{{ $summary['totalExpenditures']['remarks'] ?? '' }}</td>
              </tr>

              <tr class="fit-text-table">
                <td colspan="2" style="text-align: right; font-size: 14px;">TOTAL SAVINGS</td>
                <td style="text-align: right;">
                  {{ isset($summary['totalSavings']['amount']) ? number_format($summary['totalSavings']['amount'], 2) : '' }}
                </td>
                <td style="text-align: right;">{{ $summary['totalSavings']['remarks'] ?? '' }}</td>
              </tr>
            </table>
        </td>
    </tr>
    </tbody>
  </table>
</div>

<div style="margin-top: 50px;">
  <table style="width: 100%; border-collapse: collapse;">
    <tr>
      <td style="width: 33%; vertical-align: top; font-size: 12px;">
        <p style="text-decoration: underline; margin: 0 0 3px 0;">{{ $userName }}</p>
        <span>Prepared by</span>
      </td>
      <td style="width: 33%; vertical-align: top; text-align: center; font-size: 12px;">
        <p style="text-decoration: underline; margin: 0 0 3px 0;"></p>
        <span>Reviewed by</span>
      </td>
      <td style="width: 33%; vertical-align: top; text-align: center; font-size: 12px;">
        <p style="text-decoration: underline; margin: 0 0 3px 0;"></p>
        <span>NOTE:</span>
      </td>
    </tr>
  </table>
</div>


</body>
</html>