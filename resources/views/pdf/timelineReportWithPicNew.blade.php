@php
function ordinal($number) {
    $ends = ['th','st','nd','rd','th','th','th','th','th','th'];
    if ((($number % 100) >= 11) && (($number % 100) <= 13))
        return $number. 'th';
    else
        return $number. $ends[$number % 10];
}
@endphp
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IPPFU</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  @page {
    margin: 5mm 10mm 10mm 10mm;
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
    border: 1px solid rgba(0, 0, 0, 0.7); /* Add a border around the entire table */
  }

  .fit-text-table th,
  .fit-text-table td {
    border: 1px solid rgba(0, 0, 0, 0.7); /* Add borders to table cells */
    padding: 2px;
    font-size: 13px;
  }

  .fit-text-title {
    margin-top: 10px;
    margin-bottom: 0px;
  }

    .fit-text-title th {
    padding: 1 4px;
    margin-top: 10px;
    vertical-align: top;
    font-size: 13px;
  }

  .sub-header {
    font-weight: normal;
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


      <!-- Project Information -->
      <table class="project-info-table">
        <tbody>
           <tr class="fit-text-title" >
            <th>PROJECT PROFILE</th>
          </tr>
          <tr class="fit-text-row">
            <th colspan="2" style="width: 30%;">Project Title:</th>
            <td colspan="4" style="font-size: 13px; font-weight: bold; text-transform: uppercase;">
                {{ $project->title }}
            </td>
            </tr>

          <tr class="fit-text-row">
            <th colspan="2">Location of Project:</th>
            <td colspan="3">{{ $project->location }}</td>
          </tr>
         <tr class="fit-text-row">
            <th colspan="2">Name of Firm:</th>
            <td colspan="3">{{ $project->firm_name }}</td>
          </tr>
          <tr class="fit-text-row">
            <th colspan="2">Contractor's Name:</th>
            <td colspan="3">{{ $project->contractor_name }}</td>
          </tr>
          <tr class="fit-text-row">
            <th colspan="2">Address of Contractor/Firm:</th>
            <td colspan="3">{{ $project->contractor_address }}</td>
          </tr>
          <tr class="fit-text-row">
            <th colspan="2">Source of Fund:</th>
            <td colspan="3">{{ $project->source_of_funds }}</td>
          </tr>
          <tr class="fit-text-row">
            <th colspan="2">Project ID:</th>
            <td colspan="3">{{ $project->projectID }}</td>
          </tr>
        
          <tr class="fit-text-row">
            <th colspan="2">Appropriation:</th>
            <td colspan="3">{{ number_format((float) $projectFundsUtilization['orig_appropriation'], 2) }}</td>

          </tr>
          <tr class="fit-text-row">
            <th colspan="2">Approved Budget for the Contract:</th>
            <td colspan="3">{{ number_format((float) $projectFundsUtilization['orig_abc'], 2) }}</td>

          </tr>
          <tr class="fit-text-row">
            <th colspan="2">Original Contract Amount:</th>
            <td colspan="3">{{ number_format((float) $projectFundsUtilization['orig_contract_amount'], 2) }}</td>
          </tr>
          @php
              $labels = ['1st', '2nd', '3rd', '4th', '5th'];
          @endphp

          @foreach ($projectVariationOrder as $index => $variation)
              @if (isset($variation['vo_contract_amount']) && $index < 5)
                  <tr class="fit-text-row">
                      <th colspan="2">{{ $labels[$index] }} Revised Contract Amount:</th>
                      <td colspan="3">{{ number_format((float) $variation['vo_contract_amount'], 2) }}</td>
                  </tr>
              @endif
          @endforeach


       
          <!-- Blank row for spacing -->
          <tr><td colspan="3"></td></tr>
          <td colspan="7" style="margin: 0px; padding: 0px; border-top: 1px solid #666;">
        <table class="fit-text-table mt-4">
          <tr class="sub-header">
            <td colspan="6" style="font-weight: normal;">TIME LINE OF THE PROJECT</td>
          </tr>
          <tr style="text-align: center;">
            <th style="width: 20px;"></th>
            <th style="width: 280px;"></th>
            <td style="width: 80px;"></td>
            <td style="width: 80px;">Days</td>
            <td style="width: 80px;">Total Time</td>
            <td style="width: 80px; font-weight: bold;">Total Revised</td>
          </tr>
          <tr style="text-align: center;">
            <th></th>
            <th></th>
            <td></td>
            <td>Suspended</td>
            <td>Extension</td>
            <td style="width: 100px; font-weight: bold;">Contract Time</td>
          </tr>

          @php
            $rowNumber = 1;
            $runningExtensionTotal = $project->contract_days;
            $totalExtensionDays = 0;
            $totalSuspensionDays = $suspensionDays ?? 0; // define in controller or default to 0
          @endphp

          <tr>
            <th>{{ $rowNumber++ }}</th>
            <th style="padding: 2px;">Date of Notice to Proceed</th>
            <td style="text-align: center;">{{ \Carbon\Carbon::parse($project->ntp_received_date)->format('d-M-y') }}</td>
            <td></td><td></td><td></td>
          </tr>
          <tr>
            <th>{{ $rowNumber++ }}</th>
            <th style="padding: 2px;">Official Start of the Project</th>
            <td style="text-align: center;">{{ \Carbon\Carbon::parse($project->official_starting_date)->format('d-M-y') }}</td>
            <td></td><td></td><td></td>
          </tr>
          <tr>
            <th>{{ $rowNumber++ }}</th>
            <th style="padding: 2px;">Contract Time</th>
            <td style="text-align: center;">{{ $project->contract_days }}</td>
            <td></td><td></td><td></td>
          </tr>
          <tr>
            <th>{{ $rowNumber++ }}</th>
            <th style="padding: 2px;">Original Expiry Date</th>
            <td style="text-align: center;">{{ \Carbon\Carbon::parse($project->target_completion_date)->format('d-M-y') }}</td>
            <td></td><td></td><td></td>
          </tr>
          <tr><td colspan="6">&nbsp;</td></tr>

          <!-- Dynamic Time Extension Rows -->
          @foreach ($time_extensions as $extension)
            @php $totalExtensionDays += $extension->time_extension; @endphp
            <tr>
              <th>{{ $rowNumber++ }}</th>
              <th style="padding: 4px;">Time Extension No. {{ ordinal($extension->time_extension_no) }} Due to {{ $extension->time_extension_reason }}</th>
              <td style="text-align: center;"></td>
              <td></td>
              <td style="text-align: center;">{{ $extension->time_extension }}</td>
              <td style="text-align: center;">{{ $runningExtensionTotal += $extension->time_extension }}</td>
            </tr>
            <tr>
              <th></th>
              <th>Revised Expiry</th>
              <td style="text-align: center;">{{ \Carbon\Carbon::parse($extension->revised_expiry)->format('d-M-y') }}</td>
              <td></td>
              <td style="text-align: center;"></td>
              <td style="text-align: center;"></td>
            </tr>
            <tr><td colspan="6">&nbsp;</td></tr>
          @endforeach

          <!-- Total Row -->
          <tr>
            <th></th>
            <th></th>
            <td style="text-align: center; font-weight: bold;">TOTAL</td>
            <td style="text-align: center;">{{ $totalSuspensionDays }}</td>
            <td style="text-align: center;">{{ $totalExtensionDays }}</td>
            <td></td>
          </tr>
        </table>
      </td>
    </tr>

    <tr>
      <td colspan="7">
      <table class="fit-text-table" style="width: 100%; padding: 1px; margin-top: 10px; border-collapse: collapse;">
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
@endphp
<tr>
  <td style="text-align: right;">15% Mobilization</td>
  <td style="text-align: right;">{{ $mobiAmount > 0 ? number_format($mobiAmount, 2) : '' }}</td>
  <td style="text-align: right;"></td>
  <td style="text-align: right;"></td>
  <td style="text-align: right;"></td>
</tr>

<!-- Partial Billings -->
@foreach ($partialBillings as $index => $billing)
  @if ($index < 4 || ($index === 4 && isset($billing['amount']) && floatval($billing['amount']) > 0))
    @php
      $amount = isset($billing['amount']) ? floatval($billing['amount']) : 0;
      $hasAmount = $amount > 0;
      $retention = $hasAmount ? $amount * 0.10 : 0;
      $total = $amount - $retention;
    @endphp
    <tr>
      <td style="text-align: right;">{{ ordinal($index + 1) }} Partial Billing</td>
      <td style="text-align: right;">{{ $hasAmount ? number_format($amount, 2) : '' }}</td>
      <td style="text-align: right;">{{ $hasAmount ? '10%' : '' }}</td>
      <td style="text-align: right;">{{ $hasAmount ? number_format($retention, 2) : '' }}</td>
      <td style="text-align: right;">{{ $hasAmount ? number_format($total, 2) : '' }}</td>
    </tr>
  @endif
@endforeach

<!-- Final Billing -->
@php
  $finalAmount = isset($summary['final']['amount']) ? floatval($summary['final']['amount']) : 0;
  $finalRetention = $finalAmount > 0 ? $finalAmount * 0.10 : 0;
  $finalTotal = $finalAmount - $finalRetention;
@endphp
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
        <td></td>
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
    

</tbody>
  </table>
</div>



  
</div>
@if (!empty($projectFiles))
  <div style="page-break-before: always;"></div>
  <div class="container mt-5">
    <h5 class="text-center mb-4" style="text-decoration: underline; font-weight: bold;">
      Project File Attachments (Images Only)
    </h5>

    @foreach ($projectFiles as $file)
      <div class="text-center mb-5">
        <img src="{{ $file['data'] }}"
             alt="Attachment: {{ $file['name'] }}"
             style="max-width: 90%; max-height: 600px; border: 1px solid #666; padding: 6px;">
        <div style="font-size: 12px; margin-top: 6px;">
          Attachment: <strong>{{ $file['name'] }}</strong>
        </div>
      </div>
    @endforeach
  </div>
@endif



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
</body>
</html>