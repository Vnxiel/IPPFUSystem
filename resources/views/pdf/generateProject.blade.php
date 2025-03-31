<!DOCTYPE html>
<html>
<head>
    <title>Project Details</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; padding: 20px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid black; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Project Report</h2>
        <table>
            <tr><th>Project Title</th><td>{{ $project->projectTitle }}</td></tr>
            <tr><th>Location</th><td>{{ $project->projectLoc }}</td></tr>
            <tr><th>Status</th><td>{{ $project->projectStatus }}</td></tr>
            <tr><th>Contract Amount</th><td>₱{{ number_format($project->contractAmount, 2) }}</td></tr>
            <tr><th>Contractor</th><td>{{ $project->projectContractor }}</td></tr>
            <tr><th>Duration</th><td>{{ $project->projectContractDays }} days</td></tr>
        </table>
    </div>
</body>
</html>
