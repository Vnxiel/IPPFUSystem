<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IPPFU</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: "Times New Roman", Times, serif;
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
      width: 80px;
      height: 80px;
    }
    .header-text h5, .header-text h3, .header-text h6 {
      margin: 2px 0;
    }
    .header-text h5 {
      font-size: 14px;
    }
    .header-text h3 {
      font-size: 20px;
      text-transform: uppercase;
      font-weight: bold;
    }
    .header-text h6 {
      font-size: 10px;
    }
    .contact-info {
      text-align: center;
      font-size: 14px;
      margin-top: 2px;
      padding-bottom: 5px;
    }
    .contact-info span {
      font-weight: bold;
      color: #d9534f;
      text-decoration: underline;
    }
    .footer-image {
      text-align: center;
      margin-top: 10px;
    }
    .footer-image img {
      width: 90%;
      height: auto;
    }
    .project-info-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    .project-info-table th,
    .project-info-table td {
      border: 1px solid black;
      padding: 8px;
      vertical-align: top;
    }
    .project-info-table th {
      width: 35%;
      text-align: right;
      font-weight: normal;
    }
    .project-info-table td {
      width: 65%;
    }
    .fit-text-row {
        line-height: 1;
    }
    .fit-text-row th,
    .fit-text-row td {
        padding: 1 4px;
        vertical-align: top;
        font-size: 16px;
    }
    .sub-header {
      font-weight: bold;
      font-size: 13px;
      text-align: center;
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
          <h5>REPUBLIC OF THE PHILIPPINES</h5>
          <h5>PROVINCIAL GOVERNMENT OF NUEVA VIZCAYA</h5>
          <h3>PROVINCIAL ENGINEERING OFFICE</h3>
          <h6>People’s Hall, Capitol Compound, Bayombong, Nueva Vizcaya, 3700</h6>
        </div>
      </td>
      <td style="width: 15%; text-align: right;">
        <img src="{{ public_path('img/left_logo.png') }}" class="logo">
      </td>
    </tr>
  </table>

  <!-- Contact Info -->
  <div class="contact-info">
    <span>Telephone:</span> (078) 332-3000 Loc 418 &nbsp; | &nbsp;
    <span>E-mail:</span> plgunuevavizcaya.peo@gmail.com
  </div>

  <!-- Decorative Footer -->
  <div class="footer-image">
    <img src="{{ public_path('img/Picture2.gif') }}" alt="Footer Design">
  </div>

      <!-- Project Information -->
      <table class="project-info-table">
        <tbody>
          <tr class="fit-text-row">
            <th>Project Title:</th>
            <td colspan="3" style="font-size: 18px; font-weight: bold">{{ $project->projectTitle }}</td>
          </tr>
          <tr class="fit-text-row">
            <th>Location:</th>
            <td colspan="3">{{ $project->projectLoc }}</td>
          </tr>
          <tr class="fit-text-row"> 
                <th style="text-align: right; vertical-align: middle;">Project Description:</th>
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
            <td colspan="3">{{ number_format((float) $project->appropriation, 2) }}</td>

          </tr>
          <tr class="fit-text-row">
            <th>Contract Days:</th>
            <td colspan="3">{{ $project->projectContractDays }} Calendar Days</td>
          </tr>
            <tr class="fit-text-row">
                <th rowspan="2">Notice of Award:</th>
                <td style="border-right: none;">{{ $project->noaIssuedDate }}</td>
                <td colspan="2" style="border-left: none;"><em>Issued Date</em></td>
            </tr> 
            <tr class="fit-text-row">
                <td style="border-right: none;">{{ $project->noaReceivedDate }}</td>
                <td colspan="2" style="border-left: none;"><em>Received Date</em></td>
            </tr>
            <tr class="fit-text-row">
                <th rowspan="2">Notice to Proceed::</th>
                <td style="border-right: none;">{{ $project->ntpIssuedDate }}</td>
                <td colspan="2" style="border-left: none;"><em>Issued Date</em></td>
            </tr>
            <tr class="fit-text-row">
                <td style="border-right: none;">{{ $project->ntpReceivedDate }}</td>
                <td colspan="2" style="border-left: none;"><em>Received Date</em></td>
            </tr>
          <tr class="fit-text-row">
            <th>Official Start:</th>
            <td colspan="3">{{ $project->officialStart }}</td>
          </tr>
          <tr class="fit-text-row">
            <th>Target Completion:</th>
            <td colspan="3">{{ $project->targetCompletion }}</td>
          </tr>
          <tr class="fit-text-row">
            <th>Completion Date:</th>
            <td colspan="3">{{ $project->completionDate }}</td>
          </tr>

        <!-- ABC Section -->
    <tr class="fit-text-row sub-header">
      <td></td>
      <td>ORIGINAL</td>
      <td>V.O.1</td>
      <td>ACTUAL</td>
    </tr>
    <tr class="fit-text-row">
      <th>ABC:</th>
      <td style="text-align: right;">{{ $projectFundsUtilization['orig_abc'] ?? '--' }}</td>
      <td style="text-align: right;">{{ $projectVariationOrder[0]['vo_abc'] ?? '--' }}</td>
      <td style="text-align: right;">{{ $projectFundsUtilization['actual_abc'] ?? '--' }}</td>
    </tr>
    <tr class="fit-text-row">
      <th>Contract Amount:</th>
      <td style="text-align: right;">{{ $projectFundsUtilization['orig_contract_amount'] ?? '--' }}</td>
      <td style="text-align: right;">{{ $projectVariationOrder[0]['vo_contract_amount'] ?? '--' }}</td>
      <td style="text-align: right;">{{ $projectFundsUtilization['actual_contract_amount'] ?? '--' }}</td>
    </tr>
    <tr class="fit-text-row">
      <th>Engineering:</th>
      <td style="text-align: right;">{{ $projectFundsUtilization['orig_engineering'] ?? '--' }}</td>
      <td style="text-align: right;">{{ $projectVariationOrder[0]['vo_engineering'] ?? '--' }}</td>
      <td style="text-align: right;">{{ $projectFundsUtilization['actual_engineering'] ?? '--' }}</td>
    </tr>
    <tr class="fit-text-row">
      <th>MQC:</th>
      <td style="text-align: right;">{{ $projectFundsUtilization['orig_mqc'] ?? '--' }}</td>
      <td style="text-align: right;">{{ $projectVariationOrder[0]['vo_mqc'] ?? '--' }}</td>
      <td style="text-align: right;">{{ $projectFundsUtilization['actual_mqc'] ?? '--' }}</td>
    </tr>
      <tr class="fit-text-row">
        <th>Contingency:</th>
        <td style="text-align: right;">{{ $projectFundsUtilization['orig_contingency'] ?? '--' }}</td>
        <td style="text-align: right;">{{ $projectVariationOrder[0]['vo_contingency'] ?? '--' }}</td>
        <td style="text-align: right;">{{ $projectFundsUtilization['actual_contingency'] ?? '--' }}</td>
      </tr>
      <tr class="fit-text-row">
        <th>Bid Difference:</th>
        <td style="text-align: right;">{{ $projectFundsUtilization['orig_bid'] ?? '' }}</td>
        <td style="text-align: right;">{{ $projectVariationOrder[0]['vo_bid'] ?? '' }}</td>
        <td style="text-align: right;">{{ $projectFundsUtilization['actual_bid'] ?? '' }}</td>
      </tr>
      <tr class="fit-text-row">
        <th>Appropriation:</th>
        <td style="text-align: right;">{{ $projectFundsUtilization['orig_appropriation'] ?? '' }}</td>
        <td style="text-align: right;">{{ $projectVariationOrder[0]['vo_appropriation'] ?? '' }}</td>
        <td style="text-align: right;">{{ $projectFundsUtilization['actual_appropriation'] ?? '' }}</td>
      </tr>

      <!-- Blank row for spacing -->
      <tr><td colspan="4"></td></tr>

      <!-- Billings Section -->
      <tr class="fit-text-row sub-header">
        <td>DATE COVERED</td>
        <td>PARTICULARS</td>
        <td>AMOUNT</td>
        <td>REMARKS</td>
      </tr>

      @php
        $summary = $projectFundsUtilization['summary'] ?? [];
      @endphp

      <tr class="fit-text-row">
        <td style="text-align: right;">{{ $summary['mobilization']['date'] ?? '' }}</td>
        <td>15% Mobilization</td>
        <td style="text-align: right;">{{ $summary['mobilization']['amount'] ?? '' }}</td>
        <td style="text-align: right;">{{ $summary['mobilization']['remarks'] ?? '' }}</td>
      </tr>
      <tr class="fit-text-row">
        <td style="text-align: right;">{{ $summary['final']['date'] ?? '' }}</td>
        <td>1st Partial Billing</td>
        <td style="text-align: right;">{{ $summary['final']['amount'] ?? '' }}</td>
        <td style="text-align: right;">{{ $summary['final']['remarks'] ?? '' }}</td>
      </tr>
      <tr class="fit-text-row">
        <td style="text-align: right;">{{ $summary['final']['date'] ?? '' }}</td>
        <td>2nd Partial Billing</td>
        <td style="text-align: right;">{{ $summary['final']['amount'] ?? '' }}</td>
        <td style="text-align: right;">{{ $summary['final']['remarks'] ?? '' }}</td>
      </tr>
      <tr class="fit-text-row">
        <td style="text-align: right;">{{ $summary['final']['date'] ?? '' }}</td>
        <td>3rd Partial Billing</td>
        <td style="text-align: right;">{{ $summary['final']['amount'] ?? '' }}</td>
        <td style="text-align: right;">{{ $summary['final']['remarks'] ?? '' }}</td>
      </tr>
      <tr class="fit-text-row">
        <td style="text-align: right;">{{ $summary['final']['date'] ?? '' }}</td>
        <td>4th Partial Billing</td>
        <td style="text-align: right;">{{ $summary['final']['amount'] ?? '' }}</td>
        <td style="text-align: right;">{{ $summary['final']['remarks'] ?? '' }}</td>
      </tr>
      <tr class="fit-text-row">
        <td style="text-align: right;">{{ $summary['final']['date'] ?? '' }}</td>
        <td>Final Billing</td>
        <td style="text-align: right;">{{ $summary['final']['amount'] ?? '' }}</td>
        <td style="text-align: right;">{{ $summary['final']['remarks'] ?? '' }}</td>
      </tr>
      <tr class="fit-text-row">
        <td style="text-align: right;">{{ $summary['engineering']['date'] ?? '' }}</td>
        <td>Engineering</td>
        <td style="text-align: right;">{{ $summary['engineering']['amount'] ?? '' }}</td>
        <td style="text-align: right;">{{ $summary['engineering']['remarks'] ?? '' }}</td>
      </tr>
      <tr class="fit-text-row">
        <td style="text-align: right;">{{ $summary['mqc']['date'] ?? '' }}</td>
        <td>MQC</td>
        <td style="text-align: right;">{{ $summary['mqc']['amount'] ?? '' }}</td>
        <td style="text-align: right;">{{ $summary['mqc']['remarks'] ?? '' }}</td>
      </tr>

      <tr class="fit-text-row">
        <td colspan="2" style="text-align: right; font-size: 14px;">TOTAL EXPENDITURES</td>
        <td style="text-align: right;">{{ $summary['totalExpenditures']['amount'] ?? '' }}</td>
        <td style="text-align: right;">{{ $summary['totalExpenditures']['remarks'] ?? '' }}</td>
      </tr>
      <tr class="fit-text-row">
        <td colspan="2" style="text-align: right; font-size: 14px;">TOTAL SAVINGS</td>
        <td style="text-align: right;">{{ $summary['totalSavings']['amount'] ?? '' }}</td>
        <td style="text-align: right;">{{ $summary['totalSavings']['remarks'] ?? '' }}</td>
      </tr>
    </tbody>
  </table>
</div>
<footer style="width: 100%; margin-top: 120px; margin-left: 50px;">
  <div style="display: flex; justify-content: center; width: 100%;">
    <div style="text-align: left; font-size: 14px;">
      <u>{{ $userName }}</u><br>
      Printed by
    </div>
  </div>
</footer>

</body>
</html>