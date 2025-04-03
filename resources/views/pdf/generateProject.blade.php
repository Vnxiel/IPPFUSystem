<!DOCTYPE html>
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
            width: 100px;
            height: auto;
        }
        .header-text h5, .header-text h3, .header-text h6, .header-text p {
            margin: 2px 0;
        }
        .header-text h5 {
            font-size: 12px;
        }
        .header-text h3 {
            font-weight: bold;
            font-size: 20px;
            text-transform: uppercase;
        }
        .header-text h6 {
            font-size: 10px;
        }
        .contact-info {
            text-align: center;
            font-size: 12px;
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
            width: 100%;
            height: auto;
        }
        /* Project Information Table Styling */
        .project-info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .project-info-table th, 
        .project-info-table td {
            border: 1px solid black;
            padding: 8px;
        }
        .project-info-table th {
            width: 25%;
            text-align: right;
            font-weight: normal;

        }
        .project-info-table td {
            width: 85%;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header Section using Table for Proper Alignment -->
    <table class="header-table">
        <tr>
            <td style="width: 15%; text-align: left;">
                <img src="{{ public_path('img/temp_logo.png') }}" class="logo">
            </td>
            <td style="width: 70%;">
                <div class="header-text">
                    <h5>REPUBLIC OF THE PHILIPPINES</h5>
                    <h5>PROVINCIAL GOVERNMENT OF NUEVA VIZCAYA</h5>
                    <h3 style="font-weight: bold;">PROVINCIAL ENGINEERING OFFICE</h3>
                    <h6>People’s Hall, Capitol Compound, Bayombong, Nueva Vizcaya, 3700</h6>  
                </div>
            </td>
            <td style="width: 15%; text-align: right;">
                <img src="{{ public_path('img/left_logo.png') }}" class="logo">
            </td>
        </tr>
    </table>

    <!-- Contact Information -->
    <div class="contact-info">
        <span>Telephone:</span> (078) 332-3000 Loc 418 &nbsp; &nbsp; | &nbsp; &nbsp;
        <span>E-mail:</span> plgunuevavizcaya.peo@gmail.com
    </div>

    <!-- Decorative Footer (if required) -->
    <div class="footer-image">
        <img src="{{ public_path('img/Picture2.gif') }}" alt="Footer Design">
    </div>

    <!-- Project Information Table -->
    <table class="project-info-table">
        <tbody>
            <tr>
                <th>Project Title:</th>
                <td style="font-size: 18px; font-weight: bold">{{ $project->projectTitle }}</td>
            </tr>
            <tr>
                <th>Location:</th>
                <td>{{ $project->projectLoc }}</td>
            </tr>
            <tr>
                <th>Project Description:</th>
                <td>{{ $project->projectDescription }}</td>
            </tr>
            <tr>
                <th>Project ID:</th>
                <td>{{ $project->projectID }}</td>
            </tr>
            <tr>
                <th>Source of Fund:</th>
                <td>{{ $project->sourceOfFunds }}</td>
            </tr>
            <tr>
                <th>Appropriation:</th>
                <td>{{ number_format($project->appropriation, 2) }}</td>
            </tr>
            <tr>
                <th>Contract Days:</th>
                <td>{{ $project->projectContractDays }} Calendar Days</td>
            </tr>
            <tr>
                <th>Notice of Award:</th>
                <td>{{ $project->noticeOfAward }}</td>
            </tr>
            <tr>
                <th>Notice to Proceed:</th>
                <td>{{ $project->noticeToProceed }}</td>
            </tr>
            <tr>
                <th>Official Start:</th>
                <td>{{ $project->officialStart }}</td>
            </tr>
            <tr>
                <th>Target Completion:</th>
                <td>{{ $project->targetCompletion }}</td>
            </tr>
            <tr>
                <th>Time Extension:</th>
                <td>{{ $project->timeExtension }}</td>
            </tr>
            <tr>
                <th>Revised Target Completion:</th>
                <td>{{ $project->revisedTargetCompletion }}</td>
            </tr>
            <tr>
                <th>Completion Date:</th>
                <td>{{ $project->completionDate }}</td>
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>
